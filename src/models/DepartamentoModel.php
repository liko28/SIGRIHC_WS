<?php
/**
 * Created by PhpStorm.
 * User: ramiro
 * Date: 18/11/16
 * Time: 10:50 AM
 */

namespace SIGRI_HC\Models;


class DepartamentoModel extends BaseModel {
    /** @param Connection $connection */
    public function __construct(Connection $connection) {
        parent::__construct($connection);
        $this->setTableName('DPTO');
        $this->setPrimaryKey('ID');
        $this->addColumns('ID', 'NOMBRE', 'CODIGO', 'ID_PAIS', 'ESTADO', 'FECCREA', 'FECMODI');
    }

    /** @return CustomArray */
    public function getAll(){
        return $this->query("SELECT {$this->getColumns('ID', 'NOMBRE', 'CODIGO', 'ID_PAIS', 'ESTADO')->commaSep()} FROM {$this->getSchema()}.{$this->getTableName()}");
    }

    /** @return CustomArray */
    public function getUpdates($lastSyncDate) {
        return $this->query("SELECT {$this->getColumns('ID', 'NOMBRE', 'CODIGO', 'ID_PAIS', 'ESTADO')->commaSep()} FROM {$this->getSchema()}.{$this->getTableName()} WHERE FECMODI BETWEEN ? AND CURRENT_TIMESTAMP",$lastSyncDate);
    }

}