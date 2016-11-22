<?php

namespace Controllers;

use Models\Connection as Connection;
use Models\PECProcessModel;

class PECProcessController extends BaseController {
    /** @param Connection $connection */
    public function __construct(Connection $connection) {
        parent::__construct(new PECProcessModel($connection));
    }
}