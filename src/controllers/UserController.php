<?php

namespace SIGRI_HC\Controllers;

use SIGRI_HC\Helpers\CustomArray;
use SIGRI_HC\Models\Connection as Connection;
use SIGRI_HC\Models\UserModel;

class UserController extends BaseController {
    /** @param Connection $connection */
    public function __construct(Connection $connection) {
        parent::__construct(new UserModel($connection));
    }

    /**
     * @param string $userName
     * @return CustomArray */
    public function getByUserName($userName) {
        return $this->model->getByUserName($userName);
    }

    /**
     * @param string $userName
     * @return string */
    public function getPassword($userName) {
        return $this->model->getPassword($userName)[0]->PASSWORD;
    }
}