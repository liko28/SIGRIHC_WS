<?php
/**
 * Created by PhpStorm.
 * User: ramiro
 * Date: 10/11/16
 * Time: 11:24 AM
 */

namespace Models;


class ReferenceListModel extends BaseModel {
    public function __construct(Connection $connection) {
        parent::__construct($connection);
        $this->setTableName("SF_LISTA_REF");
        $this->setPrimaryKey("ID_LISTA");
    }

    public function getAll() {
        return $this->getConnection()->getConnectionResource()->query("SELECT * FROM {$this->getSchema()}.{$this->getTableName()}");
    }
}