<?php

namespace SIGRI_HC\Models;

use SIGRI_HC\Helpers\CustomArray;

class PECTopicModel extends BaseModel {
    /** @param Connection $connection */
    public function __construct(Connection $connection) {
        parent::__construct($connection);
        $this->setTableName("PEC_TEMAS");
        $this->addColumns('ID_GUIA', 'ID_TEMA', 'NOMBRE_TEMA', 'PROCESOS', 'SERV_GRUPAL', 'SERV_INDIVIDUAL', 'FECCREA', 'FECMODI');
    }

    /** @return CustomArray */
    public function getAll() {
        return $this->query("SELECT {$this->getColumns('ID_GUIA', 'ID_TEMA', 'NOMBRE_TEMA', 'PROCESOS', 'SERV_GRUPAL', 'SERV_INDIVIDUAL')->commaSep()} FROM {$this->getSchema()}.{$this->getTableName()}");
    }

    /** @return CustomArray */
    public function getUpdates($lastSyncDate) {
        return $this->query("SELECT {$this->getColumns('ID_GUIA', 'ID_TEMA', 'NOMBRE_TEMA', 'PROCESOS', 'SERV_GRUPAL', 'SERV_INDIVIDUAL')->commaSep()} FROM {$this->getSchema()}.{$this->getTableName()} WHERE FECMODI BETWEEN ? AND CURRENT_TIMESTAMP",$lastSyncDate);
    }
}