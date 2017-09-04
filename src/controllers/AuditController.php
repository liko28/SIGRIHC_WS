<?php

namespace SIGRI_HC\Controllers;

use SIGRI_HC\Helpers\Generic;
use SIGRI_HC\Helpers\Row;
use SIGRI_HC\Models\BaseModel;
use SIGRI_HC\Models\Connection;

class AuditController extends BaseController {
    /** @param Connection $connection */
    public function __construct(Connection $connection) {
        parent::__construct(new BaseModel($connection));
    }

    /** @inject  Connection $connection */
    public function create($inputData, $user){
        $result = array();
        foreach ($inputData as $programation => $block) {
            $result[$programation] = $this->insert($block,$programation,$user);;
        }
        return $result;
    }

    public function insert($block, $programationId, $userName) {
        //Datos de la Persona
        $person = new PersonController($this->model->getConnection());
        $person->getModel()->get($block->ID_USUARIO);
        $personData = $person->getModel()->getResult()[0];

        $entities = array();
        /** INSERCION DE SIGRI_MAESTRO (PARENT) */
        $entities['SIGRI_MAESTRO'] = new Row();
        $entities['SIGRI_MAESTRO']->addField([
            "FECVISITA" => $block->FECINICIO,
            "ID_USUARIO" => $block->ID_USUARIO,
            "CARNET" => $personData->CARNET,
            "TIPODOC"=> $personData->TIPODOC,
            "DOCUMENTO"=> $personData->DOCUMENTO,
            "MOTVISITA" => $block->MOTIVO_VISITA,
            "PROGRAMACION" => $programationId,
            "ESTADO" => 'A',
            "DPTO" => $personData->DPTO,
            "MUNICIPIO" => $personData->MUNICIPIO,
            //TODO REVISAR ESTOS TRES CON VANE Y GIO
            //"ZONA" => (int)Generic::findInPairs("6",$block->RESPUESTAS)[1], //ESTO NO ESTÁ EN PERSONA
            //"BARRIO" => (int)Generic::findInPairs("7",$block->RESPUESTAS)[1], //ESTO NO ESTÁ EN PERSONA
            //"DIRECCION" => (string)Generic::findInPairs("8",$block->RESPUESTAS)[1], //ESTO NO ESTÁ EN PERSONA
            "TELEFONO" => $personData->CELULAR,
            "FECINICIO" => $block->FECINICIO,
            "FECFIN" => $block->FECFIN,
            "LATITUD" => $block->LATITUD,
            "LONGITUD" => $block->LONGITUD,
            "USERCREA" => $userName,
            "IPCREA" => $_SERVER['REMOTE_ADDR']
        ]);

        $this->model->setTableName("SIGRI_MAESTRO");
        try{
            $masterId = $this->model->insert($entities['SIGRI_MAESTRO']);
        } catch (\Exception $e) {
            db2_rollback($this->model->getConnection()->getConnectionResource());
            return ['ERROR' => $e->getMessage()];
        }

        /** INSERCION DE SIGRI_DETALLE (CHILD) */
        foreach ($block->RESPUESTAS as $answers) {
            $this->getModel()->setTableName("SIGRI_DETALLE");
            //TODO Si es un objeto tons es un grupo
            if($answers->GRUPO) {
                foreach ($answers->RESPUESTAS as $answer) {
                    $detailRow = new Row(
                        [
                            "ID_VISITA" => $masterId,
                            "VARIABLE" => $answer[0],
                            "VALOR" => $answer[1],
                            "GRUPO" => $answers->GRUPO,
                            "CONSECUTIVO_GRUPO" => $answers->CONSECUTIVO
                        ]
                    );
                    try{
                        $this->model->insert($detailRow);
                    } catch (\Exception $e) {
                        db2_rollback($this->model->getConnection()->getConnectionResource());
                        return ['ERROR' => $e->getMessage()];
                    }
                }
            } else {
                try{
                    $this->model->insert(new Row(["ID_VISITA" => $masterId, "VARIABLE" => $answers[0], "VALOR" => $answers[1]]));
                } catch (\Exception $e) {
                    db2_rollback($this->model->getConnection()->getConnectionResource());
                    return ['ERROR' => $e->getMessage()];
                }
            }
        }

        /** ACTUALIZACION DEL ESTADO DE LA PROGRAMACION */
        $scheduleStatus = $e ? ['ESTADO' => "P", "ID_VISITA" => $masterId] : ['ESTADO' => "OK", "ID_VISITA" => $masterId];
        try {
            $this->getModel()->setTableName("SF_PROGRAMACION");
            $this->getModel()->setPrimaryKey("ID_PROGRAMACION");
            $this->getModel()->update($programationId,new Row($scheduleStatus));
        } catch (\Exception $e) {
            db2_rollback($this->getModel()->getConnection()->getConnectionResource());
            return ["ERROR" => $e->getMessage()];
        }

        /** END */
        db2_commit($this->getModel()->getConnection()->getConnectionResource());

        return $masterId;
    }

    //TODO Verificar si ya está sincronizado
}