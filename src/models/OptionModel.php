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
            $res = $this->query("SELECT {$this->getColumns()->commaSep()} FROM {$this->getFullTableName()} JOIN {$this->getSchema()}.DEMANDA_PREGUNTAS D ON D.ID_LISTA =  {$this->getFullTableName()}.ID_LISTA;");
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
        return $res;
    }

    public function updatesForDemandas(\DateTime $lastSyncDate){
        $date = $lastSyncDate->format('Y-m-d-H.i.s');
        try {
            $res = $this->query("SELECT {$this->getColumns()->commaSep()} FROM {$this->getFullTableName()} JOIN {$this->getSchema()}.DEMANDA_PREGUNTAS D ON D.ID_LISTA =  {$this->getFullTableName()}.ID_LISTA WHERE {$this->getFullTableName()}.FECMODI BETWEEN ? AND CURRENT_TIMESTAMP OR D.FECMODI BETWEEN ? AND CURRENT_TIMESTAMP;", $date,$date);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
        return $res;
    }

    public function forAuditorias(){
        try {
            $res = $this->query("SELECT {$this->getColumns()->commaSep()} FROM {$this->getSchema()}.SIGRI_OPCIONES  JOIN {$this->getSchema()}.AUDITORIA_PREGUNTAS A ON A.ID_LISTA =  {$this->getFullTableName()}.ID_LISTA;");
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
        return $res;
    }

    public function updatesForAuditorias(\DateTime $lastSyncDate){
        $date = $lastSyncDate->format('Y-m-d-H.i.s');
        try {
            $res = $this->query("SELECT {$this->getColumns()->commaSep()} FROM {$this->getFullTableName()} JOIN {$this->getSchema()}.AUDITORIA_PREGUNTAS A ON A.ID_LISTA =  {$this->getFullTableName()}.ID_LISTA WHERE {$this->getFullTableName()}.FECMODI BETWEEN ? AND CURRENT_TIMESTAMP OR A.FECMODI BETWEEN ? AND CURRENT_TIMESTAMP;", $date, $date);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
        return $res;
    }

    //TODO Pendiente SQL Sigri
    public function forSigri(){
        return [];
    }

    //TODO Pendiente SQL Sigri Updates
    public function updatesForSigri(\DateTime $lastSyncDate){
        return [];
    }

    //TODO Pendiente SQL HC
    public function forSigriHc(){
        return [];
    }

    //TODO Pendiente SQL HC Updates
    public function updatesForSigriHc(\DateTime $lastSyncDate){
        return [];
    }
}