# .env Settings
```ini
SCOUT_DRIVER=meilisearch
MEILISEARCH_HOST=http://127.0.0.1:7700
MEILISEARCH_KEY=meilisearch-master-key
MEILISEARCH_PRIVATE_KEY=meilisearch-private-key
MEILISEARCH_PUBLIC_KEY=meilisearch-public-key
```
To obtain public and private key from meilisearch run the following curl command:

```bash
curl -X GET 'http://127.0.0.1:7700/keys' \
--header "X-Meili-API-Key: your-master-key
```

Then go to config/scout.php and update this

```php
'meilisearch' => [
    'host' => env('MEILISEARCH_HOST', 'http://localhost:7700'),
    'key' => env('MEILISEARCH_KEY', null),
    'public_key' => env('MEILISEARCH_PUBLIC_KEY', null),
    'private_key' => env('MEILISEARCH_PRIVATE_KEY', null),
]
```