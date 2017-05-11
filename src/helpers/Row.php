<?php

namespace SIGRI_HC\Helpers;

class Row {
    /**
     * @param array $fields
     * @internal param array $row
     */
    public function __construct(array $fields = null) {
        foreach ($fields as $field => $value) {
            if(mb_check_encoding($value) == "UTF-8") {
                $this->$field = (string)$value;
            } else {
                $this->$field = utf8_encode($value);
            }
        }
    }

    public function addField(array $field){
        foreach ($field as $_field => $value) {
            if(mb_check_encoding($value) == "UTF-8") {
                $this->$_field = (string)$value;
            } else {
                $this->$_field = utf8_encode($value);
            }
        }
    }
}