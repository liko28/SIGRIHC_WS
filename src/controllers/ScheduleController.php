<?php
/**
 * Created by PhpStorm.
 * User: ramiro
 * Date: 18/11/16
 * Time: 10:50 AM
 */

namespace SIGRI_HC\Controllers;


use SIGRI_HC\Helpers\CustomArray;
use SIGRI_HC\Helpers\Row;
use SIGRI_HC\Models\Connection;
use SIGRI_HC\Models\ScheduleModel;

class ScheduleController extends BaseController {
    /** @param Connection $connection */
    public function __construct(Connection $connection) {
        parent::__construct(new ScheduleModel($connection));
    }

    //TODO ACTUALIZAR ESTADO A D
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

    public function getAllCompared($userName, $input) {
        $user = new UserController($this->model->getConnection());
        $this->model->getAll($user->getByUserName($userName)[0]->ID);
        $details = $this->getDetail($user->getByUserName($userName)[0]->ID);
        $newResult = new CustomArray();
        foreach ($this->model->getResult() as $schedule => $props) {
            $props->PERSONAS = array();
            foreach ($details as $detail => &$_props) {
                if($props->ID_PROGRAMACION == $_props->ID_PROGRAMACION) {
                    unset($_props->ID_PROGRAMACION);
                    $props->PERSONAS[] = $_props;
                    unset($_props);
                }
            }
            $newResult->append($props);
        }
        return $this->compare($newResult, $input);
    }

    public function getUpdates($userName, \DateTime $lastSyncDate) {
        $user = new UserController($this->model->getConnection());
        $this->model->getUpdates($user->getByUserName($userName)[0]->ID,$lastSyncDate->format('Y-m-d-H.i.s'));
        $details = $this->getDetailUpdates($user->getByUserName($userName)[0]->ID,$lastSyncDate->format('Y-m-d-H.i.s'));
        $newResult = new CustomArray();
        foreach ($this->model->getResult() as $schedule => $props) {
            $props->PERSONAS = array();
            foreach ($details as $detail => &$_props) {
                if($props->ID_PROGRAMACION == $_props->ID_PROGRAMACION) {
                    unset($_props->ID_PROGRAMACION);
                    $props->PERSONAS[] = $_props;
                    unset($_props);
                }
            }
            $newResult->append($props);
        }
        return $newResult;
    }

    public function getComparedUpdates($userName, \DateTime $lastSyncDate, $input) {
        $user = new UserController($this->model->getConnection());
        $this->model->getUpdates($user->getByUserName($userName)[0]->ID,$lastSyncDate->format('Y-m-d-H.i.s'));
        $details = $this->getDetailUpdates($user->getByUserName($userName)[0]->ID,$lastSyncDate->format('Y-m-d-H.i.s'));
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
        return $this->compare($newResult,$input);
    }

    protected function getDetail($userId) {
        $details = new ScheduleDetailController($this->model->getConnection());
        return $details->getAll($userId);
    }

    protected function getDetailUpdates($userId, \DateTime $lastSyncDate) {
        $details = new ScheduleDetailController($this->model->getConnection());
        return $details->getUpdates($userId,$lastSyncDate);
    }

    protected function compare($serverSchedules, $clientSchedules){
        $result = new CustomArray();
        foreach ($serverSchedules as $serverSchedule) {
            foreach ($clientSchedules as $clientSchedule) {
                if($clientSchedule == $serverSchedule->ID_PROGRAMACION) {
                    switch ($serverSchedule->ESTADO) {
                        case "A":
                            try {
                                $this->model->update($serverSchedule->ID_PROGRAMACION,new Row(['ESTADO' => "D"]));
                                $this->model->commit();
                            } catch (\Exception $e) {
                                $result[] = ['ERROR' => $e->getMessage()];
                                db2_rollback($this->model->getConnection()->getConnectionResource());
                                continue 2;
                            }
                            break;
                        case "D":
                            //NO PASA NADA
                            break;
                    }
                }
            }

            if(!in_array($serverSchedule->ID_PROGRAMACION,$clientSchedules) && in_array($serverSchedule->ESTADO,array("A","D"))){
                try {
                    $this->model->update($serverSchedule->ID_PROGRAMACION,new Row(['ESTADO' => "D"]));
                    $this->model->commit();
                } catch (\Exception $e) {
                    $result[] = ['ERROR' => $e->getMessage()];
                    db2_rollback($this->model->getConnection()->getConnectionResource());
                    continue;
                }
                $result[] = $serverSchedule;
            }
        }
        foreach ($clientSchedules as $clientSchedule) {
            $found = false;
            foreach ($serverSchedules as $serverSchedule) {
                if($serverSchedule->ID_PROGRAMACION == $clientSchedule) {
                    $found = true;
                }
            }
            if(!$found) {
                $result[] = array("ID_PROGRAMACION" => $clientSchedule, "ESTADO" => "I");
            }
        }
        return $result;

    }
}