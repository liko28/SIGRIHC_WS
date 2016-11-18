<?php
/**
 * Created by PhpStorm.
 * User: ramiro
 * Date: 18/11/16
 * Time: 10:50 AM
 */

namespace Models;

class IpsModel extends BaseModel {
    /** @param Connection $connection */
    public function __construct(Connection $connection) {
        parent::__construct($connection);
        $this->setTableName('IPS');
        $this->setPrimaryKey('ID');
        $this->addColumns('ID', 'COD_INS', 'NIT', 'NOMBRE', 'DIRECCION', 'PAIS', 'DPTO', 'CIUDAD', 'TELEFONO', 'MOVIL', 'EMAIL', 'REPRESENTANTE', 'ACTIVO', 'FECCREA', 'FECMODI');
    }

    /** @return CustomArray */
    public function getAll(){
        return $this->query("SELECT {$this->getColumns('ID', 'COD_INS', 'NIT', 'NOMBRE', 'DIRECCION', 'PAIS', 'DPTO', 'CIUDAD', 'TELEFONO', 'MOVIL', 'EMAIL', 'REPRESENTANTE', 'ACTIVO')->commaSep()} FROM {$this->getSchema()}.{$this->getTableName()}");
    }

    /** @return CustomArray */
    public function getUpdates($lastSyncDate) {
        return $this->query("SELECT {$this->getColumns('ID', 'COD_INS', 'NIT', 'NOMBRE', 'DIRECCION', 'PAIS', 'DPTO', 'CIUDAD', 'TELEFONO', 'MOVIL', 'EMAIL', 'REPRESENTANTE', 'ACTIVO')->commaSep()} FROM {$this->getSchema()}.{$this->getTableName()} WHERE FECMODI BETWEEN ? AND CURRENT_TIMESTAMP",$lastSyncDate);
    }

}