<?php

namespace SIGRI_HC\Helpers;

use SIGRI_HC\Controllers\UserController as User;
use SIGRI_HC\Models\Connection;

abstract class Authenticator {
    /** @return bool */
    public function authenticate() {
        if($_SERVER['PHP_AUTH_USER']) {
            $user = new User(new Connection(...CONNECTION_CREDENTIALS));
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