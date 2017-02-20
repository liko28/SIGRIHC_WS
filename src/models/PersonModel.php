<?php

namespace SIGRI_HC\Models;

use SIGRI_HC\Helpers\CustomArray;

class PersonModel extends BaseModel {
    /** @param Connection $connection */
    public function __construct(Connection $connection) {
        parent::__construct($connection);
        $this->setTableName('SF_PERSONAS');
        $this->setPrimaryKey('ID_USUARIO');
        $this->addColumns("ID_USUARIO", "APELLIDO1", "APELLIDO2", "NOMBRE1", "NOMBRE2", "TIPODOC", "DOCUMENTO", "CARNET", "FECHANAC", "SEXO", "ESTADO", "DPTO", "MUNICIPIO", "SITUACION", "CODINST", "CELULAR", "EMAIL", "PESONACER", "TALLANACER", "DOCMAMA", "DOCPAPA", "PROMOTOR", "IDULTVISITA", "FECULTVISITA", "PROGRAMADO", "PROGRAMACION", "USERCREA", "FECCREA", "IPCREA", "USERMODI", "IPMODI", "FECMODI");
    }

    /** @return CustomArray */
    public function getAll($departamento, $municipio){
        return $this->query("SELECT {$this->getColumns()->commaSep()} FROM {$this->getSchema()}.{$this->getTableName()} WHERE DPTO = ? AND MUNICIPIO = ?", $departamento, $municipio);
    }

    /** @return CustomArray */
    public function getUpdates($departamento, $municipio, $lastSyncDate) {
        return $this->query("SELECT {$this->getColumns()->commaSep()} FROM {$this->getSchema()}.{$this->getTableName()} WHERE  DPTO = ? AND MUNICIPIO = ? AND FECMODI BETWEEN ? AND CURRENT_TIMESTAMP", $departamento, $municipio, $lastSyncDate);
    }

    /** @return CustomArray */
    public function getScheduled($userId){
        return $this->query("SELECT {$this->getColumns('ID_USUARIO', 'APELLIDO1', 'APELLIDO2', 'NOMBRE1', 'NOMBRE2', 'TIPODOC', 'DOCUMENTO', 'CARNET', 'FECHANAC', 'SEXO', 'ESTADO', 'DPTO', 'MUNICIPIO', 'SITUACION', 'CODINST', 'CELULAR', 'EMAIL', 'PESONACER', 'TALLANACER', 'DOCMAMA', 'DOCPAPA', 'PROMOTOR', 'IDULTVISITA', 'FECULTVISITA', 'PROGRAMADO', 'PROGRAMACION', 'USERCREA', 'FECCREA', 'IPCREA', 'USERMODI', 'IPMODI', 'FECMODI')->commaSep()} FROM {$this->getSchema()}.{$this->getTableName()} JOIN {$this->getSchema()}.SF_PROGRAMACION ON {$this->getSchema()}.SF_PROGRAMACION.PROMOTOR = ? JOIN {$this->getSchema()}.SF_PROGRAMACION_DET ON {$this->getSchema()}.SF_PROGRAMACION.ID_PROGRAMACION = {$this->getSchema()}.SF_PROGRAMACION_DET.ID_PROGRAMACION AND {$this->getSchema()}.SF_PROGRAMACION_DET.ID_USUARIO = {$this->getSchema()}.SF_PERSONAS.ID_USUARIO",$userId);

    }

    /** @return CustomArray */
    public function getUpdatedSchedules($userId, $lastSyncDate){
        return $this->query("SELECT {$this->getColumns('ID_USUARIO', 'APELLIDO1', 'APELLIDO2', 'NOMBRE1', 'NOMBRE2', 'TIPODOC', 'DOCUMENTO', 'CARNET', 'FECHANAC', 'SEXO', 'ESTADO', 'DPTO', 'MUNICIPIO', 'SITUACION', 'CODINST', 'CELULAR', 'EMAIL', 'PESONACER', 'TALLANACER', 'DOCMAMA', 'DOCPAPA', 'PROMOTOR', 'IDULTVISITA', 'FECULTVISITA', 'PROGRAMADO', 'PROGRAMACION', 'USERCREA', 'FECCREA', 'IPCREA', 'USERMODI', 'IPMODI', 'FECMODI')->commaSep()} FROM {$this->getSchema()}.{$this->getTableName()} JOIN {$this->getSchema()}.SF_PROGRAMACION ON {$this->getSchema()}.SF_PROGRAMACION.PROMOTOR = ? JOIN {$this->getSchema()}.SF_PROGRAMACION_DET ON {$this->getSchema()}.SF_PROGRAMACION.ID_PROGRAMACION = {$this->getSchema()}.SF_PROGRAMACION_DET.ID_PROGRAMACION AND {$this->getSchema()}.SF_PROGRAMACION_DET.ID_USUARIO = {$this->getSchema()}.SF_PERSONAS.ID_USUARIO WHERE FECMODI BETWEEN ? AND CURRENT_TIMESTAMP",$userId, $lastSyncDate);
    }



}