<?php

namespace Controllers;

use Models\Connection as Connection;
use Models\PECObjetiveModel;

class PECObjetiveController extends BaseController {
    /** @param Connection $connection */
    public function __construct(Connection $connection) {
        parent::__construct(new PECObjetiveModel($connection));
    }
}