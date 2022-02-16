<?php

class Controller {
    public function getCurrencies() {
        $updated = UpdatesModel::first([], ['updated_at' => 'DESC']);
        if(!$updated || date("Y-m-d H:i:s", strtotime('+1 hours', strtotime($updated->updated_at))) < date("Y-m-d H:i:s")) {
            $this->updateCurrencies();
        }
        $result = CurrencyModel::all();
        return $result;
    }
    public function calculate() {
        $updated = UpdatesModel::first([], ['updated_at' => 'DESC']);
        if(!$updated || date("Y-m-d H:i:s", strtotime('+1 hours', strtotime($updated->updated_at))) < date("Y-m-d H:i:s")) {
            $this->updateCurrencies();
        }
        if(!isset($_GET['from']) || !isset($_GET['to']) || !isset($_GET['value'])) {
            return false;
        }
        if(empty($_GET['from']) || empty($_GET['to']) || empty($_GET['value'])) {
            return false;
        }

        $from = CurrencyModel::first(['name' => $_GET['from']]);
        $to = CurrencyModel::first(['name' => $_GET['to']]);
        $value = doubleval($_GET['value']);
        $exchanged_value = $value * doubleval($from['value']) * doubleval($to['value']);

        return ['exchanged_value' => $exchanged_value];
    }
    protected function updateCurrencies() {
        $curl = curl_init(API_KEY);
        if(!$curl)
            return false;

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($curl);
        curl_close($curl);

        if(!$result)
            return false;

        $result = json_decode($result,true);
        if(!$result['success'])
            return false;

        $date = date(strval($result['timestamp']));
        UpdatesModel::save();
        foreach($result['rates'] as $key => $value) {
            CurrencyModel::update(['name' => $key],['name' => $key, 'value' => $value]);
        }
        return true;
    }
    public function init_records() {
        return "no more";
        $curl = curl_init(API_KEY);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($curl);
        curl_close($curl);
        $result = json_decode($result,true);
        foreach($result['rates'] as $key => $value) {
            CurrencyModel::save(['name' => $key, 'value' => $value]);
        }
    }

}

?>