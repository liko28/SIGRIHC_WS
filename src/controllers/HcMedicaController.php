<?php

namespace SIGRI_HC\Controllers;

use SIGRI_HC\Helpers\Logger;
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
                if(!isset($entities[$entity]) && ($entity !== "SF_PERSONAS" || $entity !== "SF_NPERSONAS")) {
                    $entities[$entity] = new Row();
                }
                $entities[$entity]->addField([$questions->getQuestionField($answer[0]) => $answer[1]]);
            }

            //TODO ESTE ES UN ERROR EN LA TABLA PREGUNTAS
            $entities['HC_MEDICA']->addField(["ID_USUARIO"=>$person,"TIPOHC"=>"ME","ESTADO" => "A","PROGRAMACION" => 1, "RIESGOCV" => 1]);
            try{
                $hcId = $this->model->insert($entities['HC_MEDICA']);
            } catch (\Exception $e) {
                $hcId['ERROR'] = $e->getMessage();
                $result[] = $hcId;
                continue;
            } finally {
                if(!$e) {
                    db2_commit($this->model->getConnection()->getConnectionResource());
                } else {
                    db2_rollback($this->model->getConnection()->getConnectionResource());
                }
            }
            unset($entities['HC_MEDICA']);

            foreach ($entities as $entity => $row) {
                switch ($entity){
                    case "HC_ANTFALLECIDO":
                    case "HC_ANTFAMILIAR":
                    case "HC_ANTFAMILIARTC":
                    case "HC_ANTGINECO":
                    case "HC_ANTHABITOS":
                    case "HC_ANTMEDICAMENTOS":
                    case "HC_ANTPERSONAL":
                    case "HC_ANTPERSONAL1":
                    case "HC_ANTPERSONAL2":
                    case "HC_COMPLEMENTO":
                    case "HC_DIAGNOSTICO":
                    case "HC_DXNANDA":
                    case "HC_DXNIC":
                    case "HC_DXNOC":
                    case "HC_EVALUACION":
                    case "HC_EXAMENFIS":
                    case "HC_EXAMENLAB":
                    case "HC_EXAMENLABO":
                    case "HC_GESCITAS":
                    case "HC_INTERCONSULTA":
                    case "HC_MEDICA":
                    case "HC_PARACLINICOS":
                    case "HC_PECTEMAS":
                    case "HC_PLANTERAPEUTICO":
                    case "HC_REGISTROEXA":
                    case "HC_RESPONSABLE":
                    case "HC_REVISION":
                    case "HC_TESTBAR":
                    case "HC_TESTBAR":
                        //TODO Inject Fecmodi, IpModi, Feccrea, Ipcrea, Usercrea, Usermodi
                        //TODO Inject UserId
                        $baseModel->setTableName($entity);
                        $row->addField(["ID_HC" => $hcId]);
                        try {
                            $baseModel->insert($row);
                            Logger::log(200,$baseModel->getQuery());
                        } catch (\Exception $e) {
                            $hcId['ERROR'] = $e->getMessage();
                        } finally {
                            if(!$e) {
                                db2_commit($this->model->getConnection()->getConnectionResource());
                            } else {
                                db2_rollback($this->model->getConnection()->getConnectionResource());
                            }
                        }
                        break;
                }
            }
            $result[] = $hcId;
        }
        return $result;
    }
}