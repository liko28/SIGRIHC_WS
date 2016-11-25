<?php

namespace Helpers;

class Row {
    /**
     * @param array $rows
     * @internal param array $row
     */
    public function __construct(array $rows) {
        foreach ($rows as $field => $value) {
            $this->$field = utf8_encode($value);
        }
    }
}