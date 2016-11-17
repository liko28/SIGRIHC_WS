<?php

namespace Helpers;

use Controllers\UsersController as Users;
use Models\Connection;

abstract class Authenticator {
    /** @return bool */
    public function authenticate() {
        if($_SERVER['PHP_AUTH_USER']) {
            $user = new Users(new Connection(...CONNECTION_CREDENTIALS));
            if($user->getPassword($_SERVER['PHP_AUTH_USER']) == $_SERVER['PHP_AUTH_PW']) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}