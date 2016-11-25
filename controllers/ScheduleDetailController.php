<?php
/**
 * Created by PhpStorm.
 * User: ramiro
 * Date: 18/11/16
 * Time: 10:50 AM
 */

namespace Controllers;


use Models\Connection;
use Models\ScheduleDetailModel;

class ScheduleDetailController extends BaseController {
    /** @param Connection $connection */
    public function __construct(Connection $connection) {
        parent::__construct(new ScheduleDetailModel($connection));
    }

    public function getAll($userId) {
        return $this->model->getAll($userId);
    }

    public function getUpdates($userId, $lastSyncDate){
        return $this->model->getUpdates($lastSyncDate, $userId);
    }
}