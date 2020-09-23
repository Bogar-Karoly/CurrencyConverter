<?php

$value = floatval(trim($_POST['Value']));
$from = $_POST['From'];
$to = $_POST['To'];

$data = Callapi();

$toEuro = $value / floatval($data["{$from}"]);
$newCurrency = $toEuro * floatval($data["{$to}"]);

echo json_encode(number_format($newCurrency, 6, '.', ''));

function Callapi() {
    require_once('Url.php');

    $curl = curl_init(GetUrl());
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($curl);
    curl_close($curl);

    $raw = json_decode($result,true);
    $data = $raw['rates'];

    return $data;
}
?>