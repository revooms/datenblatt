---
tags:
- apache
- php
- fpm
- devops
---
von [howtoforge](https://www.howtoforge.de/author/howtoforge/ "Beiträge von howtoforge") 

Das Hypertext Transfer Protocol Version 2 **(HTTP/2**) ist die neueste Version des HTTP-Protokolls, die 2015 als IETF-Standard im RFC 7540 veröffentlicht wurde. Der Schwerpunkt des Protokolls liegt auf der Leistung, insbesondere auf der vom Endbenutzer wahrgenommenen Latenz, der Netzwerk- und Server-Ressourcennutzung. Ein Hauptziel ist es, die Nutzung einer einzigen Verbindung von Browsern zu einer Website zu ermöglichen. Das Protokoll ist abwärtskompatibel, d.h. HTTP-Methoden, Statuscodes und Semantik sind die gleichen wie bei früheren Versionen des Protokolls. Der Apache hat seit Version 2.4.17 HTTP/2-Unterstützung.In diesem Tutorial gehe ich davon aus, dass Sie bereits eine funktionierende TLS-Konfiguration haben und dass Sie eine Apache-Version auf der Linux-Distribution Ihrer Wahl installiert haben müssen und dass Sie wissen, wie man Let’s Encrypt verwendet oder wie man ein selbstsigniertes Zertifikat ausstellt.

Dieses Tutorial wurde auf Debian 9, Debian 10 und Ubuntu 18.04 LTS getestet.

## Voraussetzungen

Um HTTP/2 im Apache zu aktivieren, müssen Sie die folgenden Anforderungen erfüllen:

- Zuerst müssen Sie HTTPS auf Ihrem Server aktivieren. Alle gängigen Browser erlauben die Verwendung von HTTP/2 nur über HTTPS. Außerdem ist die **TLS-Protokollversion** >= 1.2 mit modernen Cipher-Suites erforderlich.
- Stellen Sie als nächstes sicher, dass Sie Apache **2.4.17** oder höher einsetzen, da HTTP/2 ab dieser Version unterstützt wird.
- Stellen Sie außerdem sicher, dass Ihr Client/Browser HTTP/2 tatsächlich unterstützt.

## Deaktivieren Sie das mod_php-Modul

Bevor wir das Apache MPM-Modul im nächsten Schritt auf mpm_event umstellen können, müssen wir den alten mod_php-Modus deaktivieren und durch den moderneren PHP-FPM-Modus ersetzen. Die Befehle sind für jede Betriebssystemversion unterschiedlich, bitte verwenden Sie die Befehle, die zu Ihrem installierten System passen.

**Ubuntu 18.04 LTS**
```
sudo apt-get install php7.2-fpm
sudo a2dismod php7.2
sudo a2enconf php7.2-fpm
sudo a2enmod proxy_fcgi
```

## Aktivieren Sie ein Apache MPM, das mit HTTP/2 kompatibel ist

Standardmäßig verwendet der Apache das Prefork MPM. Dieses MPM ist nicht kompatibel mit HTTP/2, daher müssen wir es durch das modernere Modul mpm_event ersetzen.

Zuerst deaktivieren wir das Modul mpm_prefork:
```
sudo a2dismod mpm_prefork
```

Dann aktivieren wir das Modul mpm_event:
```
sudo a2enmod mpm_event
```

## Aktivieren Sie die HTTP/2-Unterstützung im Apache

Um HTTP/2 auf dem Apache zum Laufen zu bringen, müssen Sie SSL- und HTTP/2-Module aktivieren und laden. Dazu können Sie Folgendes in Ihrem Terminal ausführen:
```
sudo a2enmod ssl
```

und dann
```
sudo a2enmod http2
```

Um diese neuen Module zu aktivieren, müssen Sie sie ausführen:
```
sudo systemctl restart apache2
```

Nachdem Sie die erforderlichen Apache-Module aktiviert und geladen haben, navigieren Sie zu Ihrem Apache-Konfigurationsverzeichnis und bearbeiten Sie die Apache-Konfiguration.

Um HTTP/2 auf Ihrem Apache-Webserver zu aktivieren, fügen Sie eine der folgenden Optionen zu Ihrer globalen Apache-Konfiguration oder innerhalb eines bestimmten virtuellen Hosts hinzu.

**Protocols h2 http/1.1**

Hier ist die minimale virtuelle Serverkonfiguration, die verwendet werden kann, um HTTP/2 in einigen virtuellen Hosts zu aktivieren:

```
<VirtualHost *:443>
  ServerName example.com
  ServerAlias www.example.com
  DocumentRoot /var/www/public_html/example.com
  SSLEngine on
  SSLCertificateKeyFile /path/to/private.pem
  SSLCertificateFile /path/to/cert.pem
  SSLProtocol all -SSLv3 -TLSv1 -TLSv1.1
  Protocols h2 http/1.1
</VirtualHost>
```

Um zu überprüfen, ob Ihr Server HTTP/2 unterstützt, können Sie Ihre Browser-Dev-Tools verwenden.