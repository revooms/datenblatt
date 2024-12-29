```bash
curl \
  -X POST 'http://localhost:7700/indexes/snippets/search' \
  -H 'Content-Type: application/json'\
  -H 'Authorization: Bearer MASTERKEY' \
  --data-binary '{ 
    "q": "java" 
    }'
```