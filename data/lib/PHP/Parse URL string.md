```php
<?php 

$url = 'http://127.0.0.1:8000/hasil-transaksi?data%5B0%5D%5B%5D=0000260&data%5B0%5D%5Bno_transaksi%5D=KRJ22010001';
$url_decoded = urldecode($url);
$query = parse_url($url_decoded, PHP_URL_QUERY);
parse_str($query, $parsed_query);

echo $parsed_query['data'][0]['no_transaksi'];
```
