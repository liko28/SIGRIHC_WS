<?php
/**
 * Created by PhpStorm.
 * User: ramiro
 * Date: 18/11/16
 * Time: 10:50 AM
 */

namespace SIGRI_HC\Models;


class CIE10Model extends BaseModel {
    /** @param Connection $connection */
    public function __construct(Connection $connection) {
        parent::__construct($connection);
        $this->setTableName('CIE10');
        $this->setPrimaryKey('ID');
        $this->addColumns('ID', 'CODIGO','DESCRIPCION','CLASE','ACTIVO','TIPO', 'FECCREA', 'FECMODI');
    }

    /** @return CustomArray */
    public function getAll(){
        return $this->query("SELECT {$this->getColumns('ID', 'CODIGO','DESCRIPCION','CLASE','ACTIVO','TIPO', 'FECCREA', 'FECMODI')->commaSep()} FROM {$this->getSchema()}.{$this->getTableName()}");
    }

    /** @return CustomArray */
    public function getUpdates($lastSyncDate) {
        return $this->query("SELECT {$this->getColumns('ID', 'CODIGO','DESCRIPCION','CLASE','ACTIVO','TIPO', 'FECCREA', 'FECMODI')->commaSep()} FROM {$this->getSchema()}.{$this->getTableName()} WHERE FECMODI BETWEEN ? AND CURRENT_TIMESTAMP",$lastSyncDate);
    }
}