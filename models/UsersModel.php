<?php
/**
 * Created by PhpStorm.
 * User: ramiro
 * Date: 8/11/16
 * Time: 11:17 AM
 */

namespace Model;


class UsersModel extends BaseModel {
    public function __construct(Connection $connection) {
        parent::__construct($connection);
        $this->setTableName("USERS");
    }
}