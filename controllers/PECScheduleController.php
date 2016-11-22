<?php

namespace Controllers;

use Models\Connection as Connection;
use Models\PECScheduleModel;

class PECScheduleController extends BaseController {
    /** @param Connection $connection */
    public function __construct(Connection $connection) {
        parent::__construct(new PECScheduleModel($connection));
    }
}