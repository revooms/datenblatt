---
tags:
- development
- php
- laravel
---

# Laravel MatterMost
Package, mit dem man einfach mit einem Mattermost-Server kommunizieren kann
Benutzer gibt in `.env` einen API-Endpoint und einen Key/Token an
```
MATTERMOST_API_URL=https://example.com/api/v4/
MATTERMOST_API_KEY=ABCDEFGHIJKLMNOPQRSTUVWXYZ
```
- Notifications an einen Kanal/Webhook senden
```
Mattermost::notify("Hello world");
```
- Logs in Kanal schreiben
- Nachrichten aus einem Kanal auslesen
- Verfügbare Gruppen des Servers?
- Verfügbare Kanäle