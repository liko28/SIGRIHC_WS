<?php
/**
 * Created by PhpStorm.
 * User: ramiro
 * Date: 18/11/16
 * Time: 10:50 AM
 */

namespace Models;


class ModuleModel extends BaseModel {
    /** @param Connection $connection */
    public function __construct(Connection $connection) {
        parent::__construct($connection);
        $this->setTableName('SF_MODULOS');
        $this->setPrimaryKey('ID_MODULO');
        $this->addColumns('ID_MODULO', 'DESCRIPCION', 'CODIGO', 'ENTIDAD', 'ESTADO', 'ORDEN', 'TIPO', 'VALIDAR', 'EDADINI', 'EDADFIN', 'GENERO', 'MODULO_P', 'REGISTROS','FECCREA','FECMODI');
    }

    /** @return CustomArray */
    public function getAll(){
        return $this->query("SELECT {$this->getColumns('ID_MODULO', 'DESCRIPCION', 'CODIGO', 'ENTIDAD', 'ESTADO', 'ORDEN', 'TIPO', 'VALIDAR', 'EDADINI', 'EDADFIN', 'GENERO', 'MODULO_P', 'REGISTROS')->commaSep()} FROM {$this->getSchema()}.{$this->getTableName()}");
    }

    /** @return CustomArray */
    public function getUpdates($lastSyncDate) {
        return $this->query("SELECT {$this->getColumns('ID_MODULO', 'DESCRIPCION', 'CODIGO', 'ENTIDAD', 'ESTADO', 'ORDEN', 'TIPO', 'VALIDAR', 'EDADINI', 'EDADFIN', 'GENERO', 'MODULO_P', 'REGISTROS')->commaSep()} FROM {$this->getSchema()}.{$this->getTableName()} WHERE FECMODI BETWEEN ? AND CURRENT_TIMESTAMP",$lastSyncDate);
    }

}