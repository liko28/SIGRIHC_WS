<?php

namespace Models;


class UsersModel extends BaseModel {
    public function __construct(Connection $connection) {
        parent::__construct($connection);
        $this->setTableName("USERS");
        $this->setPrimaryKey("ID");
    }

    public function getByUserName($userName) {
        return $this->getConnection()->getConnectionResource()->getRow("SELECT * FROM {$this->getSchema()}.{$this->getTableName()} WHERE NOMBRE = ?",$userName);
    }

    public function getPassword($userName) {
        return $this->getConnection()->getConnectionResource()->getRow("SELECT PASSWORD FROM {$this->getSchema()}.{$this->getTableName()} WHERE NOMBRE = ?", $userName);
    }
}