<?php

namespace Helpers;

class Row {
    /** @param array $row */
    public function __construct(array $row) {
        foreach ($row as $field => $value) {
            $this->$field = $value;
        }
    }
}