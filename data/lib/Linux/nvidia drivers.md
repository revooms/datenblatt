https://unix.stackexchange.com/questions/542360/how-to-install-the-latest-nvidia-drivers-on-linux-mint

liste der versionen:
```
apt-cache policy 'nvidia-driver-5*'
```

dann die entsprechende version installieren:
```
sudo apt-get install --install-recommends nvidia-driver-530
```

hat alles geklappt? prüfen mit 
```
nvidia-smi
```
