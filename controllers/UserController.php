<?php

namespace Controllers;

use Helpers\CustomArray;
use Models\Connection as Connection;
use Models\UserModel;

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