<?php

namespace Models;

use Helpers\CustomArray;

class PECObjetiveModel extends BaseModel {
    /** @param Connection $connection */
    public function __construct(Connection $connection) {
        parent::__construct($connection);
        $this->setTableName("PEC_GRUPOSOBJETIVO");
        $this->addColumns('ID_OBJETIVO','NOMBRE_OBJETIVO');
    }

    /** @return CustomArray */
    public function getAll() {
        return $this->query("SELECT {$this->getColumns()->commaSep()} FROM {$this->getSchema()}.{$this->getTableName()}");
    }
}