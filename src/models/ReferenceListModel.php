<?php

namespace SIGRI_HC\Models;

use SIGRI_HC\Helpers\CustomArray;

class ReferenceListModel extends BaseModel {
    /** @param Connection $connection */
    public function __construct(Connection $connection) {
        parent::__construct($connection);
        $this->setTableName("SF_LISTA_REF");
        $this->setPrimaryKey("ID_LISTA");
        $this->addColumns("ID_LISTA","PADRE","DESCRIPCION","CODLISTA","VALOR","ESTADO","ORDEN","FECCREA","FECMODI");
    }

    /** @return CustomArray */
    public function getAll() {
        return $this->query("SELECT {$this->getColumns('ID_LISTA','PADRE','DESCRIPCION','CODLISTA','VALOR','ESTADO','ORDEN')->commaSep()} FROM {$this->getSchema()}.{$this->getTableName()}");
    }

    /** @return CustomArray */
    public function getUpdates($lastSyncDate) {
        return $this->query("SELECT {$this->getColumns('ID_LISTA','PADRE','DESCRIPCION','CODLISTA','VALOR','ESTADO','ORDEN')->commaSep()} FROM {$this->getSchema()}.{$this->getTableName()} WHERE FECMODI BETWEEN ? AND CURRENT_TIMESTAMP",$lastSyncDate);
    }
}