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

    public function get(\DateTime $lastSyncDate = null) {
        $res = parent::get($lastSyncDate);
        foreach ($res as $users => $user) {
            if($user->FIRMA) {
                $user->FIRMA = base64_encode(utf8_decode($user->FIRMA));
                $user->CHECKSUM = md5($user->FIRMA);
            }
        }
        return $res;
    }
}
