<?php

namespace SIGRI_HC\Controllers;

use SIGRI_HC\Models\Connection as Connection;
use SIGRI_HC\Models\PECScheduleModel;

class PECScheduleController extends BaseController {
    /** @param Connection $connection */
    public function __construct(Connection $connection) {
        parent::__construct(new PECScheduleModel($connection));
    }
}