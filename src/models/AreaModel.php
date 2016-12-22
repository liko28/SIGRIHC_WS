<?php
/**
 * Created by PhpStorm.
 * User: ramiro
 * Date: 18/11/16
 * Time: 10:50 AM
 */

namespace SIGRI_HC\Models;


class AreaModel extends BaseModel {
    /** @param Connection $connection */
    public function __construct(Connection $connection) {
        parent::__construct($connection);
        $this->setTableName('SF_AREA');
        $this->setPrimaryKey('ID_AREA');
        $this->addColumns('ID_AREA', 'DESCRIPCION', 'CODAREA', 'CODPOSTAL', 'DPTO', 'MUNICIPIO', 'ZONA', 'NIVEL4', 'CODIGO', 'ESTADO', 'ORDEN', 'FECCREA', 'FECMODI');
    }

    /** @return CustomArray */
    public function getAll(){
        return $this->query("SELECT {$this->getColumns('ID_AREA', 'DESCRIPCION', 'CODAREA', 'CODPOSTAL', 'DPTO', 'MUNICIPIO', 'ZONA', 'NIVEL4', 'CODIGO', 'ESTADO', 'ORDEN')->commaSep()} FROM {$this->getSchema()}.{$this->getTableName()}");
    }

    /** @return CustomArray */
    public function getUpdates($lastSyncDate) {
        return $this->query("SELECT {$this->getColumns('ID_AREA', 'DESCRIPCION', 'CODAREA', 'CODPOSTAL', 'DPTO', 'MUNICIPIO', 'ZONA', 'NIVEL4', 'CODIGO', 'ESTADO', 'ORDEN')->commaSep()} FROM {$this->getSchema()}.{$this->getTableName()} WHERE FECMODI BETWEEN ? AND CURRENT_TIMESTAMP",$lastSyncDate);
    }

}