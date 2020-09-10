<?php
/*
if(!isset($_POST['submit'])) {
    $value = floatval(trim($_POST["Value"]));
    $from = $_POST['From'];
    $to = $_POST['To'];
    $fromto = $from.'_'.$to;
    $fromto = "EUR_HUF";

    //$apiUrl = "https://free.currconv.com/api/v7/convert?q=".$fromto."&compact=ultra&apiKey=ff150b18677e80c649f4";
    $apiUrl = "https://free.currconv.com/api/v7/convert?q=USD_PHP&compact=ultra&apiKey=ff150b18677e80c649f4";
    $json = file_get_contents("{$apiUrl}");
    $exchangeRate = json_decode($json,true);

    $exchange = $value * floatval($exchangeRate["$fromto"]);
    echo json_encode(number_format($exchange, 2, '.', ''));
    //exit();
}

//echo json_encode('text');
*/

$value = floatval(trim($_POST['Value']));
$from = $_POST['From'];
$to = $_POST['To'];

$data = Callapi();

$toEuro = $value / floatval($data["{$from}"]);
$newCurrency = $toEuro * floatval($data["{$to}"]);

echo json_encode(number_format($newCurrency, 6, '.', ''));


function Callapi() {
    $ch = curl_init("http://data.fixer.io/api/latest?access_key=3e6e9740c403926dd5b3b09d26f47d59");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    curl_close($ch);
    $raw = json_decode($result,true);
    $data = $raw['rates'];

    //print_r($data);
    return $data;
}
?>