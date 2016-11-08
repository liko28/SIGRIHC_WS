<?php

namespace Helpers;


use Controllers\UsersController;
use Model\UsersModel;
use Models\Connection;

abstract class Authenticator {
    public function authenticate($userName,$password) {
        $user = new UsersController(new UsersModel(new Connection(...CONNECTION_CREDENTIALS)));
        $user->getByUserName($userName);
        if($user->getModel()->getResult()[0]['PASSWORD'] == $password) {
            return true;
        }
    }
}