<?php
/**
 * Created by PhpStorm.
 * User: ramiro
 * Date: 18/11/16
 * Time: 10:50 AM
 */

namespace Models;


class MunicipioModel extends BaseModel {
    /** @param Connection $connection */
    public function __construct(Connection $connection) {
        parent::__construct($connection);
        $this->setTableName('MUNICIPIOS');
        $this->setPrimaryKey('ID');
        $this->addColumns('ID','NOMBRE','CODIGO','ID_DPTO','NOMBRE_DPTO','ESTADO','ID_CIUDAD','FECCREA','SUBREGION','FECMODI');
    }

    /** @return CustomArray */
    public function getAll(){
        return $this->query("SELECT {$this->getColumns('ID','ID_CIUDAD','CODIGO','NOMBRE','ID_DPTO','NOMBRE_DPTO','SUBREGION','ESTADO')->commaSep()} FROM {$this->getSchema()}.{$this->getTableName()}");
    }

    /** @return CustomArray */
    public function getUpdates($lastSyncDate) {
        return $this->query("SELECT {$this->getColumns('ID','ID_CIUDAD','CODIGO','NOMBRE','ID_DPTO','NOMBRE_DPTO','SUBREGION','ESTADO')->commaSep()} FROM {$this->getSchema()}.{$this->getTableName()} WHERE FECMODI BETWEEN ? AND CURRENT_TIMESTAMP",$lastSyncDate);
    }

}