Sure! You can replace "vhost1" with "brombeer" in the steps provided. Here's an updated example:

1. Install Apache and PHP:

```bash
sudo apt update
sudo apt install apache2
sudo apt install php7.4 php7.4-cli php7.4-fpm # Install PHP 7.4 as an example
```

2. Configure PHP-FPM:

```bash
sudo nano /etc/php/7.4/fpm/pool.d/brombeer.conf
```

In the pool configuration file, you can specify the PHP version, listen address, and other settings. For example:

```
[brombeer]
listen = /run/php/php7.4-fpm.sock
listen.owner = www-data
listen.group = www-data
user = www-data
group = www-data
pm = dynamic
pm.max_children = 5
pm.start_servers = 2
pm.min_spare_servers = 1
pm.max_spare_servers = 3
php_admin_value[upload_max_filesize] = 64M
php_admin_value[post_max_size] = 64M
php_admin_value[error_log] = /var/log/php7.4-fpm/brombeer-error.log
php_admin_flag[log_errors] = on
```

3. Configure Virtual Host:

```bash
sudo nano /etc/apache2/sites-available/brombeer.conf
```

In the virtual host configuration file, you can specify the PHP-FPM pool created in step 2 using the `ProxyPassMatch` directive. For example:

```
<VirtualHost *:80>
    ServerName brombeer.local
    DocumentRoot /var/www/brombeer
    <Directory /var/www/brombeer>
        AllowOverride All
        Require all granted
    </Directory>
    ProxyPassMatch ^/(.*\.php(/.*)?)$ unix:/run/php/php7.4-fpm.sock|fcgi://localhost/var/www/brombeer
    ErrorLog ${APACHE_LOG_DIR}/brombeer-error.log
    CustomLog ${APACHE_LOG_DIR}/brombeer-access.log combined
</VirtualHost>
```

4. Enable Virtual Host and PHP-FPM pool:

```bash
sudo a2ensite brombeer.conf
sudo service apache2 reload
sudo service php7.4-fpm restart
```

5. Repeat steps 3 and 4 for each virtual host and PHP version you want to configure.

With these steps, you should now have Apache set up to serve different versions of PHP for the "brombeer" virtual host on your Ubuntu system. Please note that the specific paths and configuration settings may vary depending on your system setup and PHP version.