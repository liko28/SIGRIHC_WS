<?php

namespace SIGRI_HC\Models;


class OptionModel extends BaseModel {
    /** @param Connection $connection */
    public function __construct(Connection $connection) {
        parent::__construct($connection);
        $this->setTableName('SIGRI_OPCIONES');
        $this->setPrimaryKey('ID_OPCION');
        $this->addColumns('ID_OPCION', 'ID_LISTA', 'NOMBRE_LISTA', 'DESCRIPCION', 'VALOR', 'ESTADO', 'ORDEN', 'FECCREA', 'FECMODI');
    }

    public function forDemandas(){
        try {
            $res = $this->query("SELECT O.ID_OPCION, O.ID_LISTA, O.NOMBRE_LISTA, O.DESCRIPCION, O.VALOR, O.ESTADO, O.ORDEN, O.FECCREA, O.FECMODI FROM SALFAM2.SIGRI_OPCIONES O JOIN SALFAM2.DEMANDA_PREGUNTAS D ON D.ID_LISTA =  O.ID_LISTA;");
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
        return $res;
    }

    public function updatesForDemandas(\DateTime $lastSyncDate){
        $date = $lastSyncDate->format('Y-m-d-H.i.s');
        try {
            $res = $this->query("SELECT O.ID_OPCION, O.ID_LISTA, O.NOMBRE_LISTA, O.DESCRIPCION, O.VALOR, O.ESTADO, O.ORDEN, O.FECCREA, O.FECMODI FROM SALFAM2.SIGRI_OPCIONES O JOIN SALFAM2.DEMANDA_PREGUNTAS D ON D.ID_LISTA =  O.ID_LISTA WHERE O.FECMODI BETWEEN ? AND CURRENT_TIMESTAMP OR D.FECMODI BETWEEN ? AND CURRENT_TIMESTAMP;", $date,$date);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
        return $res;
    }

    public function forAuditorias(){
        try {
            $res = $this->query("SELECT O.ID_OPCION, O.ID_LISTA, O.NOMBRE_LISTA, O.DESCRIPCION, O.VALOR, O.ESTADO, O.ORDEN, O.FECCREA, O.FECMODI FROM SALFAM2.SIGRI_OPCIONES O JOIN SALFAM2.AUDITORIA_PREGUNTAS A ON A.ID_LISTA =  O.ID_LISTA;");
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
        return $res;
    }

    public function updatesForAuditorias(\DateTime $lastSyncDate){
        $date = $lastSyncDate->format('Y-m-d-H.i.s');
        try {
            $res = $this->query("SELECT O.ID_OPCION, O.ID_LISTA, O.NOMBRE_LISTA, O.DESCRIPCION, O.VALOR, O.ESTADO, O.ORDEN, O.FECCREA, O.FECMODI FROM SALFAM2.SIGRI_OPCIONES O JOIN SALFAM2.AUDITORIA_PREGUNTAS A ON A.ID_LISTA =  O.ID_LISTA WHERE O.FECMODI BETWEEN ? AND CURRENT_TIMESTAMP OR A.FECMODI BETWEEN ? AND CURRENT_TIMESTAMP;", $date, $date);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
        return $res;
    }

    //TODO Pendiente SQL Sigri
    public function forSigri(){
        try {
            $res = $this->query("SELECT O.ID_OPCION, O.ID_LISTA, O.NOMBRE_LISTA, O.DESCRIPCION, O.VALOR, O.ESTADO, O.ORDEN, O.FECCREA, O.FECMODI FROM SALFAM2.SIGRI_OPCIONES O JOIN SALFAM2.AUDITORIA_PREGUNTAS A ON A.ID_LISTA =  O.ID_LISTA;");
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
        return $res;
    }

    //TODO Pendiente SQL Sigri Updates
    public function updatesForSigri(\DateTime $lastSyncDate){
        $date = $lastSyncDate->format('Y-m-d-H.i.s');
        try {
            $res = $this->query("SELECT O.ID_OPCION, O.ID_LISTA, O.NOMBRE_LISTA, O.DESCRIPCION, O.VALOR, O.ESTADO, O.ORDEN, O.FECCREA, O.FECMODI FROM SALFAM2.SIGRI_OPCIONES O JOIN SALFAM2.AUDITORIA_PREGUNTAS A ON A.ID_LISTA =  O.ID_LISTA WHERE O.FECMODI BETWEEN ? AND CURRENT_TIMESTAMP OR A.FECMODI BETWEEN ? AND CURRENT_TIMESTAMP;", $date, $date);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
        return $res;
    }

    //TODO Pendiente SQL HC
    public function forSigriHc(){
        try {
            $res = $this->query("SELECT O.ID_OPCION, O.ID_LISTA, O.NOMBRE_LISTA, O.DESCRIPCION, O.VALOR, O.ESTADO, O.ORDEN, O.FECCREA, O.FECMODI FROM SALFAM2.SIGRI_OPCIONES O JOIN SALFAM2.AUDITORIA_PREGUNTAS A ON A.ID_LISTA =  O.ID_LISTA;");
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
        return $res;
    }

    //TODO Pendiente SQL HC Updates
    public function updatesForSigriHc(\DateTime $lastSyncDate){
        $date = $lastSyncDate->format('Y-m-d-H.i.s');
        try {
            $res = $this->query("SELECT O.ID_OPCION, O.ID_LISTA, O.NOMBRE_LISTA, O.DESCRIPCION, O.VALOR, O.ESTADO, O.ORDEN, O.FECCREA, O.FECMODI FROM SALFAM2.SIGRI_OPCIONES O JOIN SALFAM2.AUDITORIA_PREGUNTAS A ON A.ID_LISTA =  O.ID_LISTA WHERE O.FECMODI BETWEEN ? AND CURRENT_TIMESTAMP OR A.FECMODI BETWEEN ? AND CURRENT_TIMESTAMP;", $date, $date);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
        return $res;
    }
}