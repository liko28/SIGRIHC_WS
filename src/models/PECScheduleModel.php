<?php

namespace SIGRI_HC\Models;

use SIGRI_HC\Helpers\CustomArray;

class PECScheduleModel extends BaseModel {
    /** @param Connection $connection */
    public function __construct(Connection $connection) {
        parent::__construct($connection);
        $this->setTableName("PEC_PROGRAMACION");
        $this->setPrimaryKey("ID");
        $this->addColumns("ID","GUIA","DEPARTAMENTO","CIUDAD","MIN_ASISTENTES","FECHA_INICIAL","FECHA_FINAL","GRUPO_OBJETO","HORAS");
    }

    /** @return CustomArray */
    public function getAll() {
        return $this->query("SELECT {$this->getColumns()->commaSep()} FROM {$this->getSchema()}.{$this->getTableName()}");
    }
}