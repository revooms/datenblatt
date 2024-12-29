```bash
curl \
  -X POST 'http://localhost:7700/indexes/snippets/settings' \
  -H 'Content-Type: application/json' \
  -H 'Authorization: Bearer MASTERKEY' \
  --data-binary '{
    "filterableAttributes": [
      "user"
    ]
  }'
```