<?php

namespace Controllers;

use Models\Connection as Connection;
use Models\PECTopicModel;

class PECTopicController extends BaseController {
    /** @param Connection $connection */
    public function __construct(Connection $connection) {
        parent::__construct(new PECTopicModel($connection));
    }
}