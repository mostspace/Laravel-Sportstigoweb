<?php
use bulk360\client;
require_once "./vendor/autoload.php";

// Please whitelist your IP and enable API in sms.360.my before you call this 

$smsClient = new client('W4QbYQObzq', 'rJViG05DM7HflZr7Y2wnacCZV2ADJyPMt0KBLB9f');


# To check default balance in MYR 
$response = $smsClient->balance();
print_r($response);
echo "\n";

$arr_response = json_decode($response, true);
print_r($arr_response);


# To check credit balance for a country
$response = $smsClient->balance(['country' => '65']);
print_r($response);
echo "\n";

$json_response = json_decode($response);
print_r($json_response);