<?php
/**
 * Created by PhpStorm.
 * User: ramiro
 * Date: 18/11/16
 * Time: 10:50 AM
 */

namespace Controllers;


use Helpers\CustomArray;
use Models\Connection;
use Models\ScheduleModel;

class ScheduleController extends BaseController {
    /** @param Connection $connection */
    public function __construct(Connection $connection) {
        parent::__construct(new ScheduleModel($connection));
    }

    public function getAll($userName) {
        $user = new UserController($this->model->getConnection());
        $this->model->getAll($user->getByUserName($userName)[0]->ID);
        $details = $this->getDetail($user->getByUserName($userName)[0]->ID);
        $newResult = new CustomArray();
        foreach ($this->model->getResult() as $schedule => $props) {
            $props->PERSONAS = array();
            foreach ($details as $detail => $_props) {
                if($props->ID_PROGRAMACION == $_props->ID_PROGRAMACION) {
                    unset($_props->ID_PROGRAMACION);
                    $props->PERSONAS[] = $_props;
                }
            }
            $newResult->append($props);
        }
        return $newResult;
    }

    public function getUpdates($userName,$lastSyncDate) {
        $_lastSyncDate = new \DateTime();
        $user = new UserController($this->model->getConnection());
        $this->model->getUpdates($user->getByUserName($userName)[0]->ID,$_lastSyncDate->setTimeStamp($lastSyncDate)->format('Y-m-d-H.i.s'));
        $details = $this->getDetailUpdates($user->getByUserName($userName)[0]->ID,$_lastSyncDate->setTimeStamp($lastSyncDate)->format('Y-m-d-H.i.s'));
        $newResult = new CustomArray();
        foreach ($this->model->getResult() as $schedule => $props) {
            $props->PERSONAS = array();
            foreach ($details as $detail => $_props) {
                if($props->ID_PROGRAMACION == $_props->ID_PROGRAMACION) {
                    unset($_props->ID_PROGRAMACION);
                    $props->PERSONAS[] = $_props;
                }
            }
            $newResult->append($props);
        }
        return $newResult;
    }

    protected function getDetail($userId) {
        $details = new ScheduleDetailController($this->model->getConnection());
        return $details->getAll($userId);
    }

    protected function getDetailUpdates($userId,$lastSyncDate) {
        $details = new ScheduleDetailController($this->model->getConnection());
        return $details->getUpdates($userId,$lastSyncDate);
    }
}