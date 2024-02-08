<?php
@$api_url = 'https://api.coingecko.com/api/v3/coins/markets?vs_currency=usd&ids=bitcoin';
@$data = file_get_contents($api_url);
$price = json_decode($data);
$proce = $price[0]->name;

echo json_encode($proce);
?>
