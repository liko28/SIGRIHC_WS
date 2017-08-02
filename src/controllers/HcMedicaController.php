<?php

namespace SIGRI_HC\Controllers;

use SIGRI_HC\Helpers\Row;
use SIGRI_HC\Helpers\Generic;
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
        $result = array();
        foreach ($stories as $person => $answers) {
            if (is_array($answers)) {
                foreach ($answers as $answer => $details) {
                    $result[$person][] = $this->insert($details,$person,$user);
                }
            }
            if (is_object($answers)) {
                $result[$person] = $this->insert($answers,$person,$user);;
            }
        }
        return $result;
    }

    public function insert(\stdClass $answers, $person, $user) {
        $baseModel = new BaseModel($this->model->getConnection());
        $entities = array();

        /** VALIDACION DE SINCRONIZACIONES PREVIAS -DUPLICIDADES-*/
        $existentId = $this->verify($answers->PROGRAMACION,$person, Generic::findAnswer("5",$answers->RESPUESTAS)[1],$user);
        if($existentId) {
            return $existentId;
        }

        /** Procesar Historias-Consultas con Novedad (No realizadas) */
        if($answers->ESTADO == 'NO' || $answers->MOTIVO) {
            /** ACTUALIZACION DEL ESTADO DE LA PROGRAMACION */
            try {
                $baseModel->setTableName("SF_PROGRAMACION");
                $baseModel->setPrimaryKey("ID_PROGRAMACION");
                $baseModel->update($answers->PROGRAMACION,new Row(['ESTADO' => "NO"]));
            } catch (\Exception $e) {
                db2_rollback($this->model->getConnection()->getConnectionResource());
                return ["ERROR" => $e->getMessage()];
            }
            /** DETALLE DE LA PROGRAMACION */
            $progData = $baseModel->get($answers->PROGRAMACION);

            /** INSERCION EN NOVEDADES */
            try {
                $baseModel->setTableName('SF_NOVEDADES');
                $idNovedad = $baseModel->insert(new Row(array(
                    'ID_VISITA' => -2,
                    'FECNOVEDAD' => $answers->FECHA_NOVEDAD,
                    'ID_USUARIO' => $person,
                    'DEPARTAMENTO' => $progData[0]->DPTO,
                    'PROGRAMACION' => $answers->PROGRAMACION,
                    'MUNICIPIO' => $progData[0]->MUNICIPIO,
                    'ESTADO' => 'A',
                    'PROMOTOR' => $progData[0]->PROMOTOR,
                    'USERCREA' => $user,
                    'IPCREA' => $_SERVER['REMOTE_ADDR']
                )));
            } catch (\Exception $e) {
                db2_rollback($this->model->getConnection()->getConnectionResource());
                return ["ERROR" => $e->getMessage()];
            }

            try{
                $baseModel->setTableName('SF_NOVEDADES_DET');
                /** DETALLE DE LA NOVEDAD */
                $baseModel->insert(new Row(array(
                    'ID_NOVEDAD' => $idNovedad,
                    'COD_NOVEDAD' => $answers->MOTIVO,
                    'VALOR' => $answers->VALOR ? $answers->VALOR : 1
                )));
            } catch (\Exception $e) {
                db2_rollback($this->model->getConnection()->getConnectionResource());
                return ["ERROR" => $e->getMessage()];
            }

            db2_commit($this->model->getConnection()->getConnectionResource());
            return $idNovedad;
        }


        /** PROCESAMIENTO DEL BLOQUE RESPUESTAS */
        $this->processAnswers($answers->RESPUESTAS,$entities);
        /** PROCESAMIENTO DEL BLOQUE ACOMPAÑANTES */
        $this->processAnswersMulti($answers->ACOMPAÑANTES,$entities);
        /** PROCESAMIENTO DEL BLOQUE ANTECEDENTES MEDICAMENTOS */
        $this->processAnswersMulti($answers->ANTECEDENTES_MEDICAMENTOS,$entities);
        /** PROCESAMIENTO DEL BLOQUE ANTECEDENTES PERSONALES */
        $this->processAnswersMulti($answers->ANTECEDENTES_PERSONALES,$entities);
        /** PROCESAMIENTO DEL BLOQUE ANTECEDENTES FAMILIARES */
        $this->processAnswersMulti($answers->ANTECEDENTES_FAMILIARES,$entities);
        /** PROCESAMIENTO DEL BLOQUE ANTECEDENTES FALLECIDOS */
        $this->processAnswersMulti($answers->ANTECEDENTES_FALLECIDOS,$entities);
        /** PROCESAMIENTO DEL BLOQUE LABORATORIOS */
        $this->processAnswersMulti($answers->LABORATORIOS,$entities);
        /** PROCESAMIENTO DEL BLOQUE OTROS LABORATORIOS */
        $this->processAnswersMulti($answers->OTROS_LABORATORIOS,$entities);
        /** PROCESAMIENTO DEL BLOQUE DIAGNOSTICOS */
        $this->processAnswersMulti($answers->DIAGNOSTICOS,$entities);
        /** PROCESAMIENTO DEL BLOQUE EXAMENES (HC_REGISTROEXA) */
        $this->processAnswersMulti($answers->EXAMENES,$entities);
        /** PROCESAMIENTO DEL BLOQUE PARACLINICOS */
        $this->processAnswersMulti($answers->PARACLINICOS,$entities);
        /** PROCESAMIENTO DEL BLOQUE REGISTRO EXAMENES */
        $this->processAnswersMulti($answers->REGISTRO_EXAMENES,$entities);
        /** PROCESAMIENTO DEL BLOQUE PLAN TERAPEUTICO */
        $this->processAnswersMulti($answers->PLAN_TERAPEUTICO,$entities);
        /** PROCESAMIENTO DEL BLOQUE INTERCONSULTA*/
        $this->processAnswersMulti($answers->INTERCONSULTA,$entities);
        /** PROCESAMIENTO DEL BLOQUE TEMAS */
        $this->processAnswersMulti($answers->TEMAS,$entities);
        /** PROCESAMIENTO DEL BLOQUE CITAS */
        $this->processAnswersMulti($answers->CITAS,$entities);
        /** PROCESAMIENTO DEL BLOQUE GLUCOMETRIAS (HC_INSULINARES) */
        $this->processAnswersMulti($answers->GLUCOMETRIAS,$entities);

        /** INSERCION DE HC_MEDICA (PARENT) */
        //TODO ESTE ES UN ERROR EN LA TABLA PREGUNTAS, DEBERIA TENER TODOS LOS CAMPOS
        $entities['HC_MEDICA']->addField(["ID_USUARIO"=>$person,"TIPOHC"=>"ME","ESTADO" => "A","PROGRAMACION" => $answers->PROGRAMACION, "RIESGOCV" => 1, "IPCREA" => $_SERVER['REMOTE_ADDR'], "USERCREA" => $user]);
        try{
            $hcId = $this->model->insert($entities['HC_MEDICA']);
        } catch (\Exception $e) {
            //TODO Log error
            db2_rollback($this->model->getConnection()->getConnectionResource());
            return ['ERROR' => $e->getMessage()];;
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
                            db2_rollback($this->model->getConnection()->getConnectionResource());
                            return ['ERROR' => $e->getMessage()];
                            continue 3;
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
                        db2_rollback($this->model->getConnection()->getConnectionResource());
                        return ["ERROR" => $e->getMessage()];
                        continue 2;
                    }
                    break;
                case "HC_MEDICA":
                    break;
            }
        }

        /** ACTUALIZACION DEL ESTADO DE LA PROGRAMACION */
        try {
            $baseModel->setTableName("SF_PROGRAMACION");
            $baseModel->setPrimaryKey("ID_PROGRAMACION");
            $baseModel->update($answers->PROGRAMACION,new Row(['ESTADO' => "OK"]));
        } catch (\Exception $e) {
            db2_rollback($this->model->getConnection()->getConnectionResource());
            return ["ERROR" => $e->getMessage()];
        }

        /** END */
        db2_commit($this->model->getConnection()->getConnectionResource());

        return $hcId;
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
        foreach ($answers as $item => $_answers) {
            foreach ($_answers as $answer) {
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

    public function getByPerson($personId,$onlyLast=false) {
        //TODO refactor
        //obtener las visitas de esa persona
        $historias = $this->model->getByPerson($personId);

        if(empty($historias->getArrayCopy())) {
            return array();
        }
        //Si es solo la ultima tons pedir solo esa y retornar
        if(filter_var($onlyLast,FILTER_VALIDATE_BOOLEAN)) {
            $idHc = $historias[0]->ID_HC;
            $fecha = new \DateTime($historias[0]->FECATENCION);
            foreach ($historias as $historia) {
                if($fecha < new \DateTime($historia->FECATENCION)) {
                    $idHc = $historia->ID_HC;
                    $fecha = new \DateTime($historia->FECATENCION);
                }
            }
            return $this->get($idHc);
        }
        //si son varias entonces recorrer el arreglo e ir obteniendo cada una
        foreach ($historias as $historia) {
            $result[] = $this->get($historia->ID_HC);
        }
        return $result;
    }

    public function get($hcId)
    {
        $questions = new QuestionController($this->model->getConnection());
        $questions->getAll();
        $sentences = array();
        //Obtencion de Entidades->Atributos
        foreach ($questions->getResult() as $question) {
            $sentences[$question->ENTIDAD][] = $question->ATRIBUTO;
        }
        //Consultas a BD
        foreach ($sentences as $entity => $attr) {
            $this->model->setTableName($entity);
            $this->model->addColumns($attr);
            switch ($entity) {
                case "HC_ANTMEDICAMENTOS":
                case "HC_ANTPERSONAL":
                case "HC_ANTPERSONAL1":
                case "HC_ANTPERSONAL2":
                case "HC_ANTFAMILIAR":
                case "HC_ANTFAMILIARTC":
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
                case "HC_ANTGINECO":
                case "HC_COMPLEMENTO":
                case "HC_EVALUACION":
                case "HC_EXAMENFIS":
                case "HC_HABITOS":
                case "HC_REVISION":
                case "HC_INSULINA":
                case "HC_TESTBAR":
                case "HC_MEDICA":
                    $tempResult[$entity] = $this->model->query("SELECT * FROM {$this->model->getSchema()}.{$this->model->getTableName()} WHERE ID_HC = $hcId")->values();
                    break;
            }
        }

        //Armado en Respuestas
        $i = 0;
        foreach ($tempResult as $entity => $rows) {

            foreach ($rows as $row => $attrs) {

                foreach ($attrs as $attr => $value) {
                    switch ($entity) {
                        case "HC_ANTMEDICAMENTOS":
                            $block = "ANTECEDENTES_MEDICAMENTOS";
                            break;
                        case "HC_ANTPERSONAL":
                        case "HC_ANTPERSONAL1":
                        case "HC_ANTPERSONAL2":
                            $block = "ANTECEDENTES_PERSONALES";
                            break;
                        case "HC_ANTFAMILIAR":

                            $block = "ANTECEDENTES_FAMILIARES";
                            break;
                        case "HC_ANTFALLECIDO":
                            $block = "ANTECEDENTES_FALLECIDOS";
                            break;
                        case "HC_DIAGNOSTICO":
                        case "HC_DXNANDA":
                        case "HC_DXNIC":
                        case "HC_DXNOC":
                            $block = "DIAGNOSTICOS";
                            break;
                        case "HC_EXAMENLAB":
                            $block = "LABORATORIOS";
                            break;
                        case "HC_EXAMENLABO":
                            $block = "OTROS_LABORATORIOS";
                            break;
                        case "HC_GESCITAS":
                            $block = "CITAS";
                            break;
                        case "HC_INTERCONSULTA":
                            $block = "INTERCONSULTA";
                            break;
                        case "HC_PARACLINICOS":
                            $block = "PARACLINICOS";
                            break;
                        case "HC_PECTEMAS":
                            $block = "TEMAS";
                            break;
                        case "HC_PLANTERAPEUTICO":
                            $block = "PLAN_TERAPEUTICO";
                            break;
                        case "HC_INSULINARES":
                            $block = "GLUCOMETRIAS";
                            break;
                        case "HC_REGISTROEXA":
                            $block = "EXAMENES";
                            break;
                        case "HC_RESPONSABLE":
                            $block = "ACOMPAÑANTES";
                            break;
                        case "HC_ANTGINECO":
                        case "HC_COMPLEMENTO":
                        case "HC_EVALUACION":
                        case "HC_EXAMENFIS":
                        case "HC_HABITOS":
                        case "HC_REVISION":
                        case "HC_INSULINA":
                        case "HC_TESTBAR":
                        case "HC_MEDICA":
                        case "HC_ANTFAMILIARTC":
                        default:
                            $block = "RESPUESTAS";
                            break;
                    }
                    if($questions->getQuestionId($entity,$attr)) {
                        if ($block == "RESPUESTAS") {
                            $result[$block][] = array($questions->getQuestionId($entity,$attr),$value);
                        } else {
                            $result[$block][$i][] = array($questions->getQuestionId($entity,$attr),$value);
                        }
                    }

                }
                $i++;
            }
        }
        foreach ($result as $resultBlock => $items) {
            $result[$resultBlock] = array_values($items);
        }
        return array($hcId => $result);
    }

    public function verify($idProgramacion,$person = null,$date = null,$user = null) {
        $baseModel = new BaseModel($this->model->getConnection());
        /** Verificar por PROGRAMACION, FECATENCION, ID_USUARIO,  */
        $baseModel->setTableName("HC_MEDICA");
        $baseModel->setPrimaryKey("PROGRAMACION");
        if($person) {
            $baseModel->query("SELECT * FROM {$this->getModel()->getSchema()}.{$this->getModel()->getTableName()} WHERE PROGRAMACION = ? OR (FECATENCION = ? AND ID_USUARIO = ? AND USERCREA = ?)",$idProgramacion,$date,$person,$user);
        } else {
            $baseModel->get($idProgramacion);
        }
        foreach ($baseModel->getResult() as $historia) {
            if(in_array($historia->ESTADO, ["A","AC","OK","NO"])) {
                return $historia->ID_HC;
            }
        }
        /** Verificar en Novedades */
        $baseModel->setTableName("SF_NOVEDADES");
        $baseModel->setPrimaryKey("PROGRAMACION");
        $baseModel->get($idProgramacion);

        foreach ($baseModel->getResult() as $novedad) {
            if($novedad->PROGRAMACION == $idProgramacion) {
                return $novedad->ID_NOVEDAD;
            }
        }
        return false;
    }
}