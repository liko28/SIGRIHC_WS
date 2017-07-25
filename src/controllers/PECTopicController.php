<?php

namespace SIGRI_HC\Controllers;

use SIGRI_HC\Models\Connection as Connection;
use SIGRI_HC\Models\PECTopicModel;

class PECTopicController extends BaseController {
    /** @param Connection $connection */
    public function __construct(Connection $connection) {
        parent::__construct(new PECTopicModel($connection));
    }
}