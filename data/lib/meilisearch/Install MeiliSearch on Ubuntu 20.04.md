MeiliSearch is an open-source search engine written in the Rust programming language. This search engine provides customizable search and indexing, understands typos, supports full-text search, synonyms, and offers other features.

This tutorial shows how to install MeiliSearch on Ubuntu 20.04.

# Install MeiliSearch

Add the MeiliSearch repository:

```bash
echo "deb [trusted=yes] https://apt.fury.io/meilisearch/ /" | sudo tee /etc/apt/sources.list.d/meilisearch.list
```

Update the package lists:
```bahs
sudo apt update
```
Run the following command to install MeiliSearch:
```bash
sudo apt install -y meilisearch-http
```
When installation is completed, we can check MeiliSearch version:
```bash
meilisearch --version
```

# Run MeiliSearch as a service
Now we need to configure systemd in order to run MeiliSearch as a service. So create a systemd unit file:
```bash
sudo nano /etc/systemd/system/meilisearch.service
```
Copy the following content to the file:
```bash
[Unit]
Description=MeiliSearch search engine
After=network.target
 
[Service]
ExecStart=/usr/bin/meilisearch --http-addr 0.0.0.0:7700 --env production --master-key pwd123
Restart=always
 
[Install]
WantedBy=multi-user.target
```
Change value for `--master-key` option. It specifies master key which is used to access or create documents, indexes, or change configuration via API. Save and close file.

Note that 0.0.0.0 binds MeiliSearch to all network interfaces. It accepts connections from any IPv4 address.

Now start MeiliSearch service:
```bash
sudo service meilisearch start
```
You can use the following command to make sure that MeiliSearch service is running:
```bash
sudo service meilisearch status
```
Also you can stop or restart the service:
```bash
sudo service meilisearch stop
sudo service meilisearch restart
```
To enable MeiliSearch to start on boot, execute the following command:
```bash
sudo systemctl enable meilisearch
```

# Testing MeiliSearch
Download movies dataset:
```bash
curl -Lo movies.json https://bit.ly/2PAcw9l
```
Send POST request to index data:
```bash
curl -X POST --data-binary @movies.json --header 'X-Meili-API-Key: pwd123' http://192.168.0.174:7700/indexes/movies/documents
```
Don't forget to change key and IP address of your machine.

Now send GET request to search movies:
```bash
curl --header 'X-Meili-API-Key: pwd123' http://192.168.0.174:7700/indexes/movies/search?q=spiderman
```
MeiliSearch will return response in JSON format.
```json
{
  "hits": [
    {
      "id": "315635",
      "title": "Spider-Man: Homecoming",
      "poster": "https://...",
      "overview": "...",
      "release_date": 1499216400
    },
    ...
  ],
  "nbHits": 11,
  "exhaustiveNbHits": false,
  "query": "spiderman",
  "limit": 20,
  "offset": 0,
  "processingTimeMs": 3
}
```

# Uninstall MeiliSearch

If you want to completely remove the MeiliSearch, stop the service and remove a systemd unit file.
```bash
sudo service meilisearch stop
sudo systemctl disable meilisearch
sudo rm -rf /etc/systemd/system/meilisearch.service
sudo systemctl daemon-reload
sudo systemctl reset-failed
```
Uninstall MeiliSearch:
```bash
sudo apt purge --autoremove -y meilisearch-http
```
Remove repository:
```bash
sudo rm -rf /etc/apt/sources.list.d/meilisearch.list
```