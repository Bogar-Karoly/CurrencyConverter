<?php

class UpdatesModel extends DbModel {

    public static function tableName() {
        return "updates";
    }
    public static function attributes() {
        return ['updated_at'];
    }

    public function getLast() {
        return parent::first([], ['date' => 'DESC']);
    }
}


?>