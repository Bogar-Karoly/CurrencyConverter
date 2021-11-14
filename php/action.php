<?php

class CurrencyConverter {
    function __construct() {
        $this->init();
    }
    private function init() {
        array_map(function($v) {
            if(!isset($_POST[$v]) || empty($_POST[$v]))
                $this->sendResult(false, "Please make sure that all the required field are filled!");
        }, ["from","to","value"]);

        $value = floatval(trim($_POST['exchangevalue']));
        $from = $_POST['from'];
        $to = $_POST['to'];


    }
    private function sendResult($type, $message) {
        echo json_encode(["result" => $type, "data" => $message]);
    }
    
}

class CurrencyApi {
    private $currencyList = [];
    function __construct() {
        $this->init();
    }
    private function init() {
        
    }
    private function readFile() {

    }
    private function saveFile() {

    }
    private function updateFile() {
        require_once('config.php');

        $curl = curl_init(API_KEY);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($curl);
        curl_close($curl);

        $raw = json_decode($result,true);
    }
    public function get() {

    }
}

$value = floatval(trim($_POST['Value']));
$from = $_POST['From'];
$to = $_POST['To'];

$data = Callapi();

$toEuro = $value / floatval($data["{$from}"]);
$newCurrency = $toEuro * floatval($data["{$to}"]);

echo json_encode(number_format($newCurrency, 6, '.', ''));
exit();
function Callapi() {
    require_once('config.php');

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