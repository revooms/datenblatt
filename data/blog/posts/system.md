---
date: 2025-04-14
tags:
  - systemhack
  - haxxor
---

Ich glaube ich hab' das System gehackt! Die Maschinerie genutzt!

Ich hab' mir hier mein Github-Repo so eingerichtet, dass GitHub Actions ausgeführt werden, wenn Änderungen gemacht werden.
Diese Actions können auch PHP-Scripte ausführen (docker), deren Ausgaben wiederum im Repository gespeichert werden können. 
So hol' ich mir z.B. eine Liste deutscher IPTV-Kanäle von iptvfree, parse die und schreibe das Ergebnis als JSON in eine Datei, die ich dann, nachdem meine statische Site über die Actions generiert wurde, aufrufen kann: 

[https://revooms.github.io/datenblatt/api/iptv_channels_ger.json](https://revooms.github.io/datenblatt/api/iptv_channels_ger.json)

ICHROKKE! 🤟
