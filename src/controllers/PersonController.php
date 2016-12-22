<?php

namespace SIGRI_HC\Controllers;

use SIGRI_HC\Models\Connection;
use SIGRI_HC\Models\PersonModel;

class PersonController extends BaseController {
    /** @param Connection $connection */
    public function __construct(Connection $connection) {
        parent::__construct(new PersonModel($connection));
    }
}