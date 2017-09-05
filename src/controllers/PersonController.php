<?php

namespace SIGRI_HC\Controllers;

use SIGRI_HC\Models\Connection;
use SIGRI_HC\Models\PersonModel;

class PersonController extends BaseController {
    /** @param Connection $connection */
    public function __construct(Connection $connection) {
        parent::__construct(new PersonModel($connection));
    }

    public function getAll($userName) {
        $user = new UserController($this->model->getConnection());
        return $this->model->getAll($user->getByUserName($userName)[0]->DPTO, $user->getByUserName($userName)[0]->CIUDAD);
    }

    public function getUpdates($userName, \DateTime $lastSyncDate) {
        $user = new UserController($this->model->getConnection());
        return $this->model->getUpdates($user->getByUserName($userName)[0]->DPTO, $user->getByUserName($userName)[0]->CIUDAD, $lastSyncDate->format('Y-m-d H:i:s'));
    }

    public function getScheduled($userName) {
        $user = new UserController($this->model->getConnection());
        return $this->model->getScheduled($user->getByUserName($userName)[0]->ID);
    }

    public function getUpdatedSchedules($userName, \DateTime $lastSyncDate) {
        $user = new UserController($this->model->getConnection());
        return $this->model->getUpdatedSchedules($user->getByUserName($userName)[0]->ID, $lastSyncDate->format('Y-m-d H:i:s'));
    }
}