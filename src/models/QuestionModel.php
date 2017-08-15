<?php

namespace SIGRI_HC\Models;

class QuestionModel extends BaseModel {
    /** @param Connection $connection */
    public function __construct(Connection $connection) {
        parent::__construct($connection);
        $this->setTableName('HC_PREGUNTAS');
        $this->setPrimaryKey('ID_PREGUNTA');
        $this->addColumns('ID_PREGUNTA', 'DESCRIPCION', 'ENTIDAD', 'ATRIBUTO', 'TIPOCAMPO', 'LONCAMPO', 'DEPENDE', 'OBLIGATORIO', 'ID_MODULO', 'ID_LISTA', 'NOMLISTA', 'VALORLISTA', 'CAMPOSIRFAM','TIPO','VALIDAR','EDADINI','EDADFIN','GENERO','ESTADO','VISIBILIDAD','NIVEL','CODIGO','ORDEN','FECCREA','FECMODI');
    }

    public function forDemandas(){
        $this->setTableName('DEMANDA_PREGUNTAS');
        try {
            $res = $this->getAll();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
        return $res;
    }

    public function updatesForDemandas(\DateTime $lastSyncDate){
        $date = $lastSyncDate->format('Y-m-d-H.i.s');
        $this->setTableName('DEMANDA_PREGUNTAS');
        try {
            $res = $this->getUpdates($date);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
        return $res;
    }

    public function forAuditorias(){
        $this->setTableName('AUDIT_PREGUNTAS');
        try {
            $res = $this->getAll();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
        return $res;
    }

    public function updatesForAuditorias(\DateTime $lastSyncDate){
        $date = $lastSyncDate->format('Y-m-d-H.i.s');
        $this->setTableName('AUDIT_PREGUNTAS');
        try {
            $res = $this->getUpdates($date);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
        return $res;
    }

    public function forSigri(){
        $this->setTableName('SF_PREGUNTAS');
        try {
            $res = $this->getAll();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
        return $res;
    }

    public function updatesForSigri(\DateTime $lastSyncDate){
        $date = $lastSyncDate->format('Y-m-d-H.i.s');
        $this->setTableName('SF_PREGUNTAS');
        try {
            $res = $this->getUpdates($date);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
        return $res;
    }

    public function forSigriHc(){
        $this->setTableName('HC_PREGUNTAS');
        try {
            $res = $this->getAll();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
        return $res;
    }

    public function updatesForSigriHc(\DateTime $lastSyncDate){
        $date = $lastSyncDate->format('Y-m-d-H.i.s');
        $this->setTableName('HC_PREGUNTAS');
        try {
            $res = $this->getUpdates($date);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
        return $res;
    }
}