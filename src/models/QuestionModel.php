<?php

namespace SIGRI_HC\Models;

use SIGRI_HC\Helpers\CustomArray;
use SIGRI_HC\Helpers\Logger;

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
        $this->setColumns(new CustomArray());
        $this->addColumns("ID", "ID_VARIABLE", "DESCRIPCION", "PROGRAMA", "OBLIGATORIO", "EDAD_INICIAL", "EDAD_FINAL", "GENERO", "MAX", "MIN", "VISIBILIDAD", "NIVEL", "ORDEN", "ESTADO", "FECCREA", "FECMODI");
        try {
            $res = $this->query("SELECT {$this->getColumns()->commaSep()}, SV.TIPO, SV.ID_LISTA, SV.NOMBRE_LISTA FROM {$this->getFullTableName()} JOIN {$this->getSchema()}.SIGRI_VARIABLES SV ON {$this->getFullTableName()}.ID_VARIABLE = SV.ID_VARIABLE");
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
        return $res;
    }

    public function updatesForAuditorias(\DateTime $lastSyncDate){
        $date = $lastSyncDate->format('Y-m-d-H.i.s');
        $this->setTableName('AUDIT_PREGUNTAS');
        $this->setColumns(new CustomArray());
        $this->addColumns("ID", "ID_VARIABLE", "DESCRIPCION", "PROGRAMA", "OBLIGATORIO", "EDAD_INICIAL", "EDAD_FINAL", "GENERO", "MAX", "MIN", "VISIBILIDAD", "NIVEL", "ORDEN", "ESTADO", "FECCREA", "FECMODI");
        try {
            $res = $this->query("SELECT {$this->getColumns()->commaSep()}, SV.TIPO, SV.ID_LISTA, SV.NOMBRE_LISTA FROM {$this->getFullTableName()} JOIN {$this->getSchema()}.SIGRI_VARIABLES SV ON {$this->getFullTableName()}.ID_VARIABLE = SV.ID_VARIABLE WHERE {$this->getFullTableName()}.FECMODI BETWEEN '?' AND CURRENT_TIMESTAMP OR SV.FECMODI BETWEEN '?' AND CURRENT_TIMESTAMP",$date, $date);
            Logger::log(200,$this->getQuery(),Logger::getPath("ramiro.alvarez"));
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