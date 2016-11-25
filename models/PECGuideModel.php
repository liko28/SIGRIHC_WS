<?php

namespace Models;

use Helpers\CustomArray;

class PECGuideModel extends BaseModel {
    /** @param Connection $connection */
    public function __construct(Connection $connection) {
        parent::__construct($connection);
        $this->setTableName("PEC_GUIAS");
        $this->addColumns('ID_GUIA', 'NOMBRE_GUIA', 'GRUPO_OBJETIVO', 'PROCESOS', 'FECCREA', 'FECMODI');
    }

    /** @return CustomArray */
    public function getAll() {
        return $this->query("SELECT {$this->getColumns('ID_GUIA', 'NOMBRE_GUIA', 'GRUPO_OBJETIVO', 'PROCESOS')->commaSep()} FROM {$this->getSchema()}.{$this->getTableName()}");
    }

    /** @return CustomArray */
    public function getUpdates($lastSyncDate) {
        return $this->query("SELECT {$this->getColumns('ID_GUIA', 'NOMBRE_GUIA', 'GRUPO_OBJETIVO', 'PROCESOS')->commaSep()} FROM {$this->getSchema()}.{$this->getTableName()} WHERE FECMODI BETWEEN ? AND CURRENT_TIMESTAMP",$lastSyncDate);
    }
}