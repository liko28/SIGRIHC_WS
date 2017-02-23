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
    public function create($stories, $user){
        foreach ($stories as $person => $answers) {
            $baseModel = new BaseModel($this->model->getConnection());
            $entities = array();
            $result = array();
            /** PROCESAMIENTO DEL BLOQUE RESPUESTAS */
            $this->processAnswers($answers['RESPUESTAS'],$entities);
            /** PROCESAMIENTO DEL BLOQUE ACOMPAÑANTES */
            $this->processAnswersMulti($answers['ACOMPAÑANTES'],$entities);
            /** PROCESAMIENTO DEL BLOQUE ANTECEDENTES MEDICAMENTOS */
            $this->processAnswersMulti($answers['ANTECEDENTES_MEDICAMENTOS'],$entities);
            /** PROCESAMIENTO DEL BLOQUE ANTECEDENTES PERSONALES */
            $this->processAnswersMulti($answers['ANTECEDENTES_PERSONALES'],$entities);
            /** PROCESAMIENTO DEL BLOQUE ANTECEDENTES FAMILIARES */
            $this->processAnswersMulti($answers['ANTECEDENTES_FAMILIARES'],$entities);
            /** PROCESAMIENTO DEL BLOQUE ANTECEDENTES FALLECIDOS */
            $this->processAnswersMulti($answers['ANTECEDENTES_FALLECIDOS'],$entities);
            /** PROCESAMIENTO DEL BLOQUE LABORATORIOS */
            $this->processAnswersMulti($answers['LABORATORIOS'],$entities);
            /** PROCESAMIENTO DEL BLOQUE OTROS LABORATORIOS */
            $this->processAnswersMulti($answers['OTROS_LABORATORIOS'],$entities);
            /** PROCESAMIENTO DEL BLOQUE DIAGNOSTICOS */
            $this->processAnswersMulti($answers['DIAGNOSTICOS'],$entities);
            /** PROCESAMIENTO DEL BLOQUE EXAMENES (HC_REGISTROEXA) */
            $this->processAnswersMulti($answers['EXAMENES'],$entities);
            /** PROCESAMIENTO DEL BLOQUE PARACLINICOS */
            $this->processAnswersMulti($answers['PARACLINICOS'],$entities);
            /** PROCESAMIENTO DEL BLOQUE REGISTRO EXAMENES */
            $this->processAnswersMulti($answers['REGISTRO_EXAMENES'],$entities);
            /** PROCESAMIENTO DEL BLOQUE PLAN TERAPEUTICO */
            $this->processAnswersMulti($answers['PLAN_TERAPEUTICO'],$entities);
            /** PROCESAMIENTO DEL BLOQUE INTERCONSULTA*/
            $this->processAnswersMulti($answers['INTERCONSULTA'],$entities);
            /** PROCESAMIENTO DEL BLOQUE TEMAS */
            $this->processAnswersMulti($answers['TEMAS'],$entities);
            /** PROCESAMIENTO DEL BLOQUE CITAS */
            $this->processAnswersMulti($answers['CITAS'],$entities);
            /** PROCESAMIENTO DEL BLOQUE GLUCOMETRIAS (HC_INSULINARES) */
            $this->processAnswersMulti($answers['GLUCOMETRIAS'],$entities);

            /** INSERCION DE HC_MEDICA (PARENT) */
            //TODO ESTE ES UN ERROR EN LA TABLA PREGUNTAS, DEBERIA TENER TODOS LOS CAMPOS
            $entities['HC_MEDICA']->addField(["ID_USUARIO"=>$person,"TIPOHC"=>"ME","ESTADO" => "A","PROGRAMACION" => 1, "RIESGOCV" => 1, "IPCREA" => $_SERVER['REMOTE_ADDR'], "USERCREA" => $user]);
            try{
                $hcId = $this->model->insert($entities['HC_MEDICA']);
            } catch (\Exception $e) {
                //TODO Log error
                $result[] = ['ERROR' => $e->getMessage()];
                db2_rollback($this->model->getConnection()->getConnectionResource());
                continue;
            }

            /** INSERCION DEL RESTO DE REGISTROS */
            foreach ($entities as $entity => $row) {
                switch ($entity){
                    case "HC_ANTMEDICAMENTOS":
                    case "HC_ANTPERSONAL":
                    case "HC_ANTPERSONAL1":
                    case "HC_ANTPERSONAL2":
                    case "HC_ANTFAMILIAR":
                    case "HC_ANTFALLECIDO":
                    case "HC_DIAGNOSTICO":
                    case "HC_DXNANDA":
                    case "HC_DXNIC":
                    case "HC_DXNOC":
                    case "HC_EXAMENLAB":
                    case "HC_EXAMENLABO":
                    case "HC_GESCITAS":
                    case "HC_INTERCONSULTA":
                    case "HC_PARACLINICOS":
                    case "HC_PECTEMAS":
                    case "HC_PLANTERAPEUTICO":
                    case "HC_INSULINARES":
                    case "HC_REGISTROEXA":
                    case "HC_RESPONSABLE":
                        foreach ($row as $item) {
                            //TODO Inject Fecmodi, IpModi, Feccrea, Ipcrea, Usercrea, Usermodi
                            //TODO Inject UserId
                            $baseModel->setTableName($entity);
                            $item->addField(["ID_HC" => $hcId]);
                            try {
                                $baseModel->insert($item);
                            } catch (\Exception $e) {
                                //TODO Log error
                                $result[] = ['ERROR' => $e->getMessage()];
                                db2_rollback($this->model->getConnection()->getConnectionResource());
                                continue 4;
                            }
                        }
                        break;
                    case "HC_ANTFAMILIARTC":
                    case "HC_ANTGINECO":
                    case "HC_COMPLEMENTO":
                    case "HC_EVALUACION":
                    case "HC_EXAMENFIS":
                    case "HC_HABITOS":
                    case "HC_REVISION":
                    case "HC_INSULINA":
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
                    case "HC_MEDICA":
                        break;
                }
            }
            $result[] = $hcId;
            db2_commit($this->model->getConnection()->getConnectionResource());
        }
        return $result;
    }

    public function processAnswers($answers, &$entities) {
        $questions = new QuestionController($this->model->getConnection());
        $questions->getAll();
        foreach ($answers as $answer) {
            if($answer)
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
    }

    public function processAnswersMulti($answers, &$entities) {
        $questions = new QuestionController($this->model->getConnection());
        $questions->getAll();
        foreach ($answers as $item => $answers) {
            foreach ($answers as $answer) {
                $entity = $questions->getQuestionEntity($answer[0]);
                if(!isset($entities[$entity]->$item) && ($entity !== "SF_PERSONAS" || $entity !== "SF_NPERSONAS")) {
                    $entities[$entity]->$item = new Row();
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
                $entities[$entity]->$item->addField([$questions->getQuestionField($answer[0]) => $respuesta]);
            }
        }
    }
}