- Journal-Dateien aufräumen
```
sudo journalctl --vacuum-time=3weeks
```

```
sudo journalctl --vacuum-size=50M
```

- Plattenplatz
```
sudo du -h --max-depth=1 /opt | sort -h
```
```
sudo du -hx --max-depth=1 /
```
```
sudo du -hx --max-depth=2 / | sort -h
```
