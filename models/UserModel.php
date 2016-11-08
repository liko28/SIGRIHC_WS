<?php

namespace Model;


class UsersModel extends BaseModel {
    public function __construct(Connection $connection) {
        parent::__construct($connection);
        $this->setTableName("USERS");
        $this->setPrimaryKey("ID");
    }

}