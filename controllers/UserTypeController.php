<?php

namespace Controllers;

use Helpers\CustomArray;
use Models\Connection as Connection;
use Models\UserTypeModel;

class UserTypeController extends BaseController {
    /** @param Connection $connection */
    public function __construct(Connection $connection) {
        parent::__construct(new UserTypeModel($connection));
    }

    /** @return CustomArray */
    public function getAll() {
        return $this->model->getAll();
    }
}