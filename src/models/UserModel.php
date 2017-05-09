<?php

namespace SIGRI_HC\Models;

use SIGRI_HC\Helpers\CustomArray;

class UserModel extends BaseModel {
    /** @param Connection $connection */
    public function __construct(Connection $connection) {
        parent::__construct($connection);
        $this->setTableName("USERS");
        $this->setPrimaryKey("ID");
        $this->addColumns("ID", "NOMBRE", "PASSWORD", "TIPO_USUARIO", "ACTIVO", "EMAIL", "DPTO", "PAIS", "CIUDAD", "MOVIL", "TELEFONO", "DIRECCION", "DOC_IDENT", "NOMBRES", "APELLIDOS", "CARGO", "TIPO_DOC", "INFORMA_A", "FECHA_CREA", "USER_CREA", "IP_CREA", "FECHA_MODI", "USER_MODI", "IP_MODI");
    }

    /** @return CustomArray */
    public function getByUserName($userName) {
        return $this->query("SELECT {$this->getColumns()->commaSep()} FROM {$this->getSchema()}.{$this->getTableName()} WHERE NOMBRE = ?",$userName);
    }

    /** @return CustomArray */
    public function getPassword($userName) {
        return $this->query("SELECT {$this->getColumns('PASSWORD')->commaSep()} FROM {$this->getSchema()}.{$this->getTableName()} WHERE NOMBRE = ?",$userName);
    }

    /** @return CustomArray */
    public function getUpdates($lastSyncDate){
        return $this->query("SELECT {$this->getColumns()->commaSep()} FROM {$this->getSchema()}.{$this->getTableName()} WHERE FECHA_MODI BETWEEN ? AND CURRENT_TIMESTAMP",$lastSyncDate);
    }
}