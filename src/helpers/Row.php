<?php

namespace SIGRI_HC\Helpers;

class Row {
    /**
     * @param array $fields
     * @internal param array $row
     */
    public function __construct(array $fields) {
        foreach ($fields as $field => $value) {
            $this->$field = utf8_encode($value);
        }
    }
}