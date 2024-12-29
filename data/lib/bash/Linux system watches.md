Show the number of system watches:
```bash
cat /proc/sys/fs/inotify/max_user_watches
```

Change the number of system watches:
```bash
echo fs.inotify.max_user_watches=16384 | sudo tee -a /etc/sysctl.conf
sudo sysctl -p
```