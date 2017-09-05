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
        $this->setTableName('SF_PERSONAS');
        $this->query("SELECT DISTINCT {$this->getColumns('ID_USUARIO', 'APELLIDO1', 'APELLIDO2', 'NOMBRE1', 'NOMBRE2', 'TIPODOC', 'DOCUMENTO', 'CARNET', 'FECHANAC', 'SEXO', 'ESTADO', 'DPTO', 'MUNICIPIO', 'SITUACION', 'CODINST', 'CELULAR', 'EMAIL', 'PESONACER', 'TALLANACER', 'DOCMAMA', 'DOCPAPA', 'PROMOTOR', 'IDULTVISITA', 'FECULTVISITA', 'PROGRAMADO', 'PROGRAMACION', 'USERCREA', 'FECCREA', 'IPCREA', 'USERMODI', 'IPMODI', 'FECMODI')->commaSep()} FROM {$this->getSchema()}.{$this->getTableName()} JOIN {$this->getSchema()}.SF_PROGRAMACION ON {$this->getSchema()}.SF_PROGRAMACION.PROMOTOR = ? JOIN {$this->getSchema()}.SF_PROGRAMACION_DET ON {$this->getSchema()}.SF_PROGRAMACION.ID_PROGRAMACION = {$this->getSchema()}.SF_PROGRAMACION_DET.ID_PROGRAMACION AND {$this->getSchema()}.SF_PROGRAMACION_DET.ID_USUARIO = {$this->getSchema()}.{$this->getTableName()}.ID_USUARIO",$userId);
        $this->tableName = 'SF_NPERSONAS';
        $this->query("SELECT DISTINCT -{$this->getSchema()}.{$this->getTableName()}.ID_USUARIO as ID_USUARIO, {$this->getColumns('APELLIDO1', 'APELLIDO2', 'NOMBRE1', 'NOMBRE2', 'TIPODOC', 'DOCUMENTO', 'CARNET', 'FECHANAC', 'SEXO', 'ESTADO', 'DPTO', 'MUNICIPIO', 'SITUACION', 'CODINST', 'CELULAR', 'EMAIL', 'PESONACER', 'TALLANACER', 'DOCMAMA', 'DOCPAPA', 'PROMOTOR', 'IDULTVISITA', 'FECULTVISITA', 'PROGRAMADO', 'PROGRAMACION', 'USERCREA', 'FECCREA', 'IPCREA', 'USERMODI', 'IPMODI', 'FECMODI')->commaSep()} FROM {$this->getSchema()}.{$this->getTableName()} JOIN {$this->getSchema()}.SF_PROGRAMACION ON {$this->getSchema()}.SF_PROGRAMACION.PROMOTOR = ? JOIN {$this->getSchema()}.SF_PROGRAMACION_DET ON {$this->getSchema()}.SF_PROGRAMACION.ID_PROGRAMACION = {$this->getSchema()}.SF_PROGRAMACION_DET.ID_PROGRAMACION AND -{$this->getSchema()}.SF_PROGRAMACION_DET.ID_USUARIO = {$this->getSchema()}.{$this->getTableName()}.ID_USUARIO WHERE {$this->getSchema()}.SF_PROGRAMACION_DET.ID_USUARIO < 0",$userId);
        return $this->getResult()->getArrayCopy();
    }

    /** @return CustomArray */
    public function getUpdatedSchedules($userId, $lastSyncDate){
        $this->setTableName('SF_PERSONAS');
        $this->query("SELECT DISTINCT {$this->getColumns('ID_USUARIO', 'APELLIDO1', 'APELLIDO2', 'NOMBRE1', 'NOMBRE2', 'TIPODOC', 'DOCUMENTO', 'CARNET', 'FECHANAC', 'SEXO', 'ESTADO', 'DPTO', 'MUNICIPIO', 'SITUACION', 'CODINST', 'CELULAR', 'EMAIL', 'PESONACER', 'TALLANACER', 'DOCMAMA', 'DOCPAPA', 'PROMOTOR', 'IDULTVISITA', 'FECULTVISITA', 'PROGRAMADO', 'PROGRAMACION', 'USERCREA', 'FECCREA', 'IPCREA', 'USERMODI', 'IPMODI', 'FECMODI')->commaSep()} FROM {$this->getSchema()}.{$this->getTableName()} JOIN {$this->getSchema()}.SF_PROGRAMACION ON {$this->getSchema()}.SF_PROGRAMACION.PROMOTOR = ? JOIN {$this->getSchema()}.SF_PROGRAMACION_DET ON {$this->getSchema()}.SF_PROGRAMACION.ID_PROGRAMACION = {$this->getSchema()}.SF_PROGRAMACION_DET.ID_PROGRAMACION AND {$this->getSchema()}.SF_PROGRAMACION_DET.ID_USUARIO = {$this->getSchema()}.{$this->getTableName()}.ID_USUARIO WHERE {$this->getSchema()}.{$this->getTableName()}.FECMODI BETWEEN ? AND CURRENT_TIMESTAMP",$userId, $lastSyncDate);
        $this->tableName = 'SF_NPERSONAS';
        $this->query("SELECT DISTINCT -{$this->getSchema()}.{$this->getTableName()}.ID_USUARIO as ID_USUARIO, {$this->getColumns('APELLIDO1', 'APELLIDO2', 'NOMBRE1', 'NOMBRE2', 'TIPODOC', 'DOCUMENTO', 'CARNET', 'FECHANAC', 'SEXO', 'ESTADO', 'DPTO', 'MUNICIPIO', 'SITUACION', 'CODINST', 'CELULAR', 'EMAIL', 'PESONACER', 'TALLANACER', 'DOCMAMA', 'DOCPAPA', 'PROMOTOR', 'IDULTVISITA', 'FECULTVISITA', 'PROGRAMADO', 'PROGRAMACION', 'USERCREA', 'FECCREA', 'IPCREA', 'USERMODI', 'IPMODI', 'FECMODI')->commaSep()} FROM {$this->getSchema()}.{$this->getTableName()} JOIN {$this->getSchema()}.SF_PROGRAMACION ON {$this->getSchema()}.SF_PROGRAMACION.PROMOTOR = ? JOIN {$this->getSchema()}.SF_PROGRAMACION_DET ON {$this->getSchema()}.SF_PROGRAMACION.ID_PROGRAMACION = {$this->getSchema()}.SF_PROGRAMACION_DET.ID_PROGRAMACION AND -{$this->getSchema()}.SF_PROGRAMACION_DET.ID_USUARIO = {$this->getSchema()}.{$this->getTableName()}.ID_USUARIO WHERE {$this->getSchema()}.{$this->getTableName()}.FECMODI BETWEEN ? AND CURRENT_TIMESTAMP AND {$this->getSchema()}.SF_PROGRAMACION_DET.ID_USUARIO < 0",$userId, $lastSyncDate);
        return $this->getResult()->getArrayCopy();
    }



}