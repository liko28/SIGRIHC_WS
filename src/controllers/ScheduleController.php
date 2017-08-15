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

    //Nuevas funciones para Programacion
    public function getSchedule($userName, $input, $client, \DateTime $lastSyncDate = null){
        $user = new UserController($this->model->getConnection());
        $userId = $user->getByUserName($userName)[0]->ID;

        //obtener programacion por user, cliente y fecmodi
        $this->model->getAll($userId, $client, $lastSyncDate);

        //obtener detalle por user, cliente y fecmodi
        $details = new ScheduleDetailController($this->model->getConnection());
        $details->getAll($userId, $client, $lastSyncDate);

        //Añadir el detalle
        foreach ($this->model->getResult() as $schedules => $schedule){
            $schedule->PERSONAS = array();
            //verificar si es el mismo ID_PROGRAMACION
            foreach ($details->model->getResult() as $_details => $detail){
                if($detail->ID_PROGRAMACION == $schedule->ID_PROGRAMACION){

                    switch ($client){
                        //TODO si es de DEMANDA debe llevar la cuenta de servicios y eventos que tiene el usuario
                        case DEMANDA:
                        //TODO si es de SIGRI debe llevar la visita anterior
                        case VISITA:
                        case HISTORIA:
                            break;
                        case AUDITORIA:
                            $detail->PROGRAMAS = array_filter(explode("|",$detail->TIPOVISITA));
                        break;
                    }
                    unset($detail->ID_PROGRAMACION);
                    $schedule->PERSONAS[] = $detail;
                }
            }
        }

        //comparar con el input
        //retornar
        return $this->compare($this->model->getResult(),$input)->values();
    }
}