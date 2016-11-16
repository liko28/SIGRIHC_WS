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
        $this->addColumns("ID_LISTA","PADRE","DESCRIPCION","CODLISTA","VALOR","ESTADO","FECCREA","FECMODI");
    }

    public function getAll() {
        return $this->query("SELECT {$this->getColumns('ID_LISTA','PADRE','DESCRIPCION','CODLISTA','VALOR','ESTADO')->commaSep()} FROM {$this->getSchema()}.{$this->getTableName()}");
    }

    public function getUpdates($lastSyncDate) {
        return $this->query("SELECT {$this->getColumns('ID_LISTA','PADRE','DESCRIPCION','CODLISTA','VALOR','ESTADO')->commaSep()} FROM {$this->getSchema()}.{$this->getTableName()} WHERE FECMODI BETWEEN '?' AND '?' OR FECCREA BETWEEN '?' AND '?'",$lastSyncDate,'CURRENT_TIMESTAMP',$lastSyncDate,'CURRENT_TIMESTAMP');
    }
}