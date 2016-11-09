<?php

namespace Helpers;


use Controllers\UsersController;
use Models\UsersModel;
use Models\Connection;

abstract class Authenticator {
    public function authenticate() {
        $user = new UsersController(new Connection(...CONNECTION_CREDENTIALS));
        if($_SERVER['PHP_AUTH_USER']) {
            $user->getByUserName("'{$_SERVER['PHP_AUTH_USER']}'");
            if($user->getModel()->getResult()[0]['PASSWORD'] == $_SERVER['PHP_AUTH_PW']) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }

    }
}