---
tags:
  - php
  - repository
  - linux
  - ubunutu
---


Install various PHP versions

```bash
sudo add-apt-repository -y ppa:ondrej/php
sudo apt update
sudo apt install php7.4
sudo a2enmod php7.4
```

To change default version
```bash
sudo update-alternatives --config php
```