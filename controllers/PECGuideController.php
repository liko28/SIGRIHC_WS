<?php

namespace Controllers;

use Models\Connection as Connection;
use Models\PECGuideModel;

class PECGuideController extends BaseController {
    /** @param Connection $connection */
    public function __construct(Connection $connection) {
        parent::__construct(new PECGuideModel($connection));
    }
}