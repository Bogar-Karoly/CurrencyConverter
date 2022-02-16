<?php

abstract class Model {
    public function loadData(Array $param) {
        foreach($param as $key => $value) {
            if(property_exists($this,$key))
                $this->{$key} = $value;
        }
    } 
}

?>