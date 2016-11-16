<?php
/**
 * Created by PhpStorm.
 * User: ramiro
 * Date: 8/11/16
 * Time: 12:44 PM
 */

namespace Controllers;


use Models\Connection as Connection;
use Models\UsersModel;

class UsersController extends BaseController {

    public function __construct(Connection $connection) {
        parent::__construct(new UsersModel($connection));
    }

    public function getByUserName($userName) {
        return $this->model->getByUserName($userName);
    }

    public function getPassword($userName) {
        return $this->model->getPassword($userName)[0]->PASSWORD;
    }


}