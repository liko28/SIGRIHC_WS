<?php

namespace SIGRI_HC\Models;


class UserTypeModel extends BaseModel {
    /** @param Connection $connection */
    public function __construct(Connection $connection) {
        parent::__construct($connection);
        $this->setTableName("TIPO_USUARIO");
        $this->setPrimaryKey("ID");
        $this->addColumns('ID', 'NOMBRE', 'CODIGO', 'ESTADO', 'ABREVIATURA');
    }

    public function getAll() {
        return $this->query("SELECT {$this->getColumns()->commaSep()} FROM {$this->getSchema()}.{$this->getTableName()}");
    }
}