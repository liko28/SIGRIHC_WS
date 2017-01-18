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
            /** PROCESAMIENTO DEL BLOQUE RESPUESTAS */
            foreach ($answers['RESPUESTAS'] as $answer) {
                $entity = $questions->getQuestionEntity($answer[0]);
                if(!isset($entities[$entity]) && ($entity !== "SF_PERSONAS" || $entity !== "SF_NPERSONAS")) {
                    $entities[$entity] = new Row();
                }
                $tipo = $questions->getQuestionType($answer[0]);
                $respuesta = null;
                switch ($tipo) {
                    case "BIGINT":
                    case "SMALLINT":
                    case "INTEGER":
                        $respuesta = intval($answer[1]);
                        break;
                    case "DECIMAL":
                        $respuesta = floatval($answer[1]);
                        break;
                    case "VARCHAR":
                    case "DATE":
                    case "TIMESTAMP":
                    case "TIME":
                        $respuesta = $answer[1];
                        break;
                }
                $entities[$entity]->addField([$questions->getQuestionField($answer[0]) => $respuesta]);
            }

            /** PROCESAMIENTO DEL BLOQUE ACOMPAÑANTES */
            foreach ($answers['ACOMPAÑANTES'] as $companion => $answers) {
                foreach ($answers as $answer) {
                    $entity = $questions->getQuestionEntity($answer[0]);
                    if(!isset($entities[$entity]->$companion) && ($entity !== "SF_PERSONAS" || $entity !== "SF_NPERSONAS")) {
                        $entities[$entity]->$companion = new Row();
                    }
                    $tipo = $questions->getQuestionType($answer[0]);
                    $respuesta = null;
                    switch ($tipo) {
                        case "BIGINT":
                        case "SMALLINT":
                        case "INTEGER":
                            $respuesta = intval($answer[1]);
                            break;
                        case "DECIMAL":
                            $respuesta = floatval($answer[1]);
                            break;
                        case "VARCHAR":
                        case "DATE":
                        case "TIMESTAMP":
                        case "TIME":
                            $respuesta = $answer[1];
                            break;
                    }
                    $entities[$entity]->$companion->addField([$questions->getQuestionField($answer[0]) => $respuesta]);
                }
            }


            /** INSERCION DE HC_MEDICA (PARENT) */
            //TODO ESTE ES UN ERROR EN LA TABLA PREGUNTAS, DEBERIA TENER TODOS LOS CAMPOS
            $entities['HC_MEDICA']->addField(["ID_USUARIO"=>$person,"TIPOHC"=>"ME","ESTADO" => "A","PROGRAMACION" => 1, "RIESGOCV" => 1]);
            try{
                $hcId = $this->model->insert($entities['HC_MEDICA']);
            } catch (\Exception $e) {
                //TODO Log error
                $result[] = ['ERROR' => $e->getMessage()];
                db2_rollback($this->model->getConnection()->getConnectionResource());
                continue;
            }
            /** ELIMINACION DE LOS DATOS DE HC_MEDICA PARA EVITAR UNA NUEVA INSERCION */
            unset($entities['HC_MEDICA']);

            /** INSERCION DEL RESTO DE REGISTROS */
            foreach ($entities as $entity => $row) {
                switch ($entity){
                    case "HC_RESPONSABLE":
                        foreach ($row as $companion) {
                            //TODO Inject Fecmodi, IpModi, Feccrea, Ipcrea, Usercrea, Usermodi
                            //TODO Inject UserId
                            $baseModel->setTableName($entity);
                            $companion->addField(["ID_HC" => $hcId]);
                            try {
                                $baseModel->insert($companion);
                            } catch (\Exception $e) {
                                //TODO Log error
                                $result[] = ['ERROR' => $e->getMessage()];
                                db2_rollback($this->model->getConnection()->getConnectionResource());
                                continue 3;
                            }
                        }
                        break;
                    case "HC_ANTFALLECIDO":
                    case "HC_ANTFAMILIAR":
                    case "HC_ANTFAMILIARTC":
                    case "HC_ANTGINECO":
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
                    case "HC_HABITOS":
                    case "HC_INTERCONSULTA":
                    case "HC_MEDICA":
                    case "HC_PARACLINICOS":
                    case "HC_PECTEMAS":
                    case "HC_PLANTERAPEUTICO":
                    case "HC_REGISTROEXA":
                    case "HC_REVISION":
                    case "HC_TESTBAR":
                    case "HC_TESTBAR":
                        //TODO Inject Fecmodi, IpModi, Feccrea, Ipcrea, Usercrea, Usermodi
                        //TODO Inject UserId
                        $baseModel->setTableName($entity);
                        $row->addField(["ID_HC" => $hcId]);
                        try {
                            $baseModel->insert($row);
                        } catch (\Exception $e) {
                            //TODO Log error
                            $result[] = ["ERROR" => $e->getMessage()];
                            db2_rollback($this->model->getConnection()->getConnectionResource());
                            continue 3;
                        }
                        break;
                }
            }
            $result[] = $hcId;
            db2_commit($this->model->getConnection()->getConnectionResource());
        }
        return $result;
    }
}