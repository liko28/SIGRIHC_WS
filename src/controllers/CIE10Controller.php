<?php

namespace SIGRI_HC\Controllers;

use SIGRI_HC\Models\Connection;
use SIGRI_HC\Models\CIE10Model;

class CIE10Controller extends BaseController {
    /** @param Connection $connection */
    public function __construct(Connection $connection) {
        parent::__construct(new CIE10Model($connection));
    }
}