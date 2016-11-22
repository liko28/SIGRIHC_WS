<?php

namespace Controllers;

use Models\Connection;
use Models\PersonaModel;

class PersonController extends BaseController {
    /** @param Connection $connection */
    public function __construct(Connection $connection) {
        parent::__construct(new PersonaModel($connection));
    }
}