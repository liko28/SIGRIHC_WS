<?php

namespace SIGRI_HC\Controllers;

use SIGRI_HC\Helpers\Generic;
use SIGRI_HC\Helpers\Row;
use SIGRI_HC\Models\BaseModel;
use SIGRI_HC\Models\Connection;

class DemandController extends BaseController {
    /** @param Connection $connection */
    public function __construct(Connection $connection) {
        parent::__construct(new BaseModel($connection));
    }

    /** @inject  Connection $connection */
    public function create($inputData, $user){
        $result = array();
        foreach ($inputData as $person => $block) {
            $result[$person] = $this->insert($block,$person,$user);;
        }
        return $result;
    }

    public function insert($block, $personId, $userName) {
        $idDemand = array();
        //Datos de la Persona
        $person = new PersonController($this->model->getConnection());
        $person->getModel()->get($personId);
        $personData = $person->getModel()->getResult()[0];

        foreach ($block->RESPUESTAS as $ips => $answers) {
            $entities = array();
            /** INSERCION DE SIGRI_MAESTRO (PARENT) */
            $entities['SIGRI_MAESTRO'] = new Row();
            $entities['SIGRI_MAESTRO']->addField([
                "FECVISITA" => $block->FECINICIO,
                "ID_USUARIO" => $personId,
                "CARNET" => $personData->CARNET,
                "TIPODOC"=> $personData->TIPODOC,
                "DOCUMENTO"=> $personData->DOCUMENTO,
                "MOTVISITA" => $block->MOTIVO_VISITA,
                "PROGRAMACION" => $block->PROGRAMACION,
                "ESTADO" => 'A',
                "DPTO" => $personData->DPTO,
                "MUNICIPIO" => $personData->MUNICIPIO,
                //TODO REVISAR ESTOS TRES CON VANE
                "ZONA" => (int)Generic::findInPairs("6",$answers)[1], //ESTO NO ESTÁ EN PERSONA
                "BARRIO" => (int)Generic::findInPairs("7",$answers)[1], //ESTO NO ESTÁ EN PERSONA
                "DIRECCION" => (string)Generic::findInPairs("8",$answers)[1], //ESTO NO ESTÁ EN PERSONA
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
                $idDemand[$ips] = ['ERROR' => $e->getMessage()];
                continue;
            }
            /** INSERCION DE SIGRI_DETALLE (CHILD) */
            $this->getModel()->setTableName("SIGRI_DETALLE");
            foreach ($answers as $answer) {
                try{
                    $this->model->insert(new Row(["ID_VISITA" => $masterId, "VARIABLE" => $answer[0], "VALOR" => $answer[1]]));
                } catch (\Exception $e) {
                    db2_rollback($this->model->getConnection()->getConnectionResource());
                    $idDemand[$ips] = ['ERROR' => $e->getMessage()];
                    continue;
                }
            }
            db2_commit($this->getModel()->getConnection()->getConnectionResource());
            $idDemand[$ips] = $masterId;
        }

        /** ACTUALIZACION DEL ESTADO DE LA PROGRAMACION */
        $scheduleStatus = $e ? ['ESTADO' => "P", "ID_VISITA" => $masterId] : ['ESTADO' => "OK", "ID_VISITA" => $masterId];
        try {
            $this->getModel()->setTableName("SF_PROGRAMACION");
            $this->getModel()->setPrimaryKey("ID_PROGRAMACION");
            $this->getModel()->update($block->PROGRAMACION,new Row($scheduleStatus));
        } catch (\Exception $e) {
            db2_rollback($this->getModel()->getConnection()->getConnectionResource());
            return ["ERROR" => $e->getMessage()];
        }

        /** END */
        db2_commit($this->getModel()->getConnection()->getConnectionResource());

        return $idDemand;
    }

    //TODO Verificar si ya está sincronizado
}