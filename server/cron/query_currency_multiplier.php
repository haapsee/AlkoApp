<?php

function getCurrencyMultiplier($source, $currencies, $accesskey) {
    $client = new GuzzleHttp\Client();
    $query = "http://apilayer.net/api/live?access_key=" . $accesskey . "&currencies=" . join(",", $currencies) . "&source=" . $source . "&format=1";
    $res = $client->request('GET', $query);
    $res = json_decode($res->getBody(), true);

    $result = array();
    foreach ($currencies as $currency) {
        $result[] = $res["quotes"][$source . $currency];
    }
    return $result;
}


?>