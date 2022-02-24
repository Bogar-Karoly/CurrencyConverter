<?php

class Controller {
    protected String $time = '+1 hours';
    protected Int $decimal_precision = 2;

    public function getCurrencies() {
        $updated = UpdatesModel::first([], ['updated_at' => 'DESC']);
        if(!$updated || date("Y-m-d H:i:s", strtotime($this->time, strtotime($updated->updated_at))) < date("Y-m-d H:i:s")) {
            $this->updateCurrencies();
        }
        $result = CurrencyModel::all();
        if(!$result)
            return new Response(false,Application::$app->error->getErrorByCode(101));
        return $result;
    }
    public function calculate($param) {
        $updated = UpdatesModel::first([], ['updated_at' => 'DESC']);
        if(!$updated || date("Y-m-d H:i:s", strtotime($this->time, strtotime($updated->updated_at))) < date("Y-m-d H:i:s")) {
            $this->updateCurrencies();
        }
        if(!isset($param['from']) || empty($param['from']) || strlen($param['from']) !== 3)
            return new Response(false,Application::$app->error->getErrorByCode(110));
        if(!isset($param['to']) || empty($param['to']) || strlen($param['to']) !== 3)
            return new Response(false,Application::$app->error->getErrorByCode(111));
        if(!isset($param['value']) || empty($param['value']))
            return new Response(false,Application::$app->error->getErrorByCode(112));
        
        $from = CurrencyModel::first(['short_name' => strtoupper($param['from'])]);
        $to = CurrencyModel::first(['short_name' => strtoupper($param['to'])]);

        if(!$from)
            return new Response(false,Application::$app->error->getErrorByCode(110));
        if(!$to)
            return new Response(false,Application::$app->error->getErrorByCode(111));

        $value = doubleval($param['value']);
        $converted = round($value / doubleval($from->value) * doubleval($to->value),$this->decimal_precision,PHP_ROUND_HALF_UP);

        return new Response(true,['converted' => $converted]);
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

        //$date = date(strval($result['timestamp']));
        UpdatesModel::save();
        foreach($result['rates'] as $key => $value) {
            CurrencyModel::update(['name' => $key],['value' => $value]);
        }
        return true;
    }
}

?>