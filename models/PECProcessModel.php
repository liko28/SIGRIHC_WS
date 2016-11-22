<?php

namespace Models;

use Helpers\CustomArray;

class PECProcessModel extends BaseModel {
    /** @param Connection $connection */
    public function __construct(Connection $connection) {
        parent::__construct($connection);
        $this->setTableName("PEC_PROCESOS");
        $this->addColumns("ID_PROCESO","NOMBRE_PROCESO");
    }

    /** @return CustomArray */
    public function getAll() {
        return $this->query("SELECT {$this->getColumns()->commaSep()} FROM {$this->getSchema()}.{$this->getTableName()}");
    }
}