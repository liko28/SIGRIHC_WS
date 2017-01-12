<?php

namespace SIGRI_HC\Controllers;

use SIGRI_HC\Helpers\Row;
use SIGRI_HC\Models\BaseModel;
use SIGRI_HC\Models\Connection;
use SIGRI_HC\Models\HcMedicaModel;

class HcMedicaController extends BaseController {
    /** @param Connection $connection */
    public function __construct(Connection $connection) {
        parent::__construct(new HcMedicaModel($connection));
    }

    /** @inject  Connection $connection */
    public function create($stories){
        $questions = new QuestionController($this->model->getConnection());
        $questions->getAll();
        $baseModel = new BaseModel($this->model->getConnection());
        $entities = array();
        $result = array();

        foreach ($stories as $person => $answers) {
            foreach ($answers as $answer) {
                $entity = $questions->getQuestionEntity($answer[0]);
                if(!isset($entities[$entity])) {
                    $entities[$entity] = new Row();
                }
                $entities[$entity]->addField([$questions->getQuestionField($answer[0]) => $answer[2]]);
            }

            //TODO ESTE ES UN ERROR EN LA TABLA PREGUNTAS
            $entities['HC_MEDICA']->addField(["ID_USUARIO"=>$person,"TIPOHC"=>"ME","ESTADO" => "A","PROGRAMACION" => 1, "RIESGOCV" => 1]);
            try{
                $hcId = $this->model->insert($entities['HC_MEDICA']);
            } catch (\Exception $e) {
                $hcId = $e->getMessage();
            } finally {
                if(!$e) {
                    db2_commit($this->model->getConnection()->getConnectionResource());
                } else {
                    db2_rollback($this->model->getConnection()->getConnectionResource());
                }
            }
            unset($entities['HC_MEDICA']);

            foreach ($entities as $entity => $row) {
                $baseModel->setTableName($entity);
                //TODO Verificar si ID_HC aplica para todas las tablas
                $row->addField(["ID_HC" => $hcId]);
                //TODO Inject Fecmodi, IpModi, Feccrea, Ipcrea, Usercrea, Usermodi
                //TODO Inject UserId
                try {
                    $baseModel->insert($row);
                } catch (\Exception $e) {
                    $hcId = $e->getMessage();
                } finally {
                    if(!$e) {
                        db2_commit($this->model->getConnection()->getConnectionResource());
                    } else {
                        db2_rollback($this->model->getConnection()->getConnectionResource());
                    }
                }
            }
            $result[] = $hcId;
        }
        return $result;

    }
}