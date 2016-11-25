<?php
/**
 * Created by PhpStorm.
 * User: ramiro
 * Date: 22/11/16
 * Time: 11:05 AM
 */

namespace models;


class NewsTypeModel extends BaseModel {
    /** @param Connection $connection */
    public function __construct(Connection $connection) {
        parent::__construct($connection);
        $this->setTableName('SF_NOVEDADES_TIPO');
        $this->addColumns('TIPO_NOVEDAD', 'DESCRIPCION', 'ESTADO', 'FECCREA', 'IPCREA', 'USERMODI', 'FECMODI', 'IPMODI', 'USER_CREA');
    }

    public function getAll() {
        return $this->query("SELECT {$this->getColumns('TIPO_NOVEDAD', 'DESCRIPCION', 'ESTADO')->commaSep()} FROM {$this->getSchema()}.{$this->getTableName()}");
    }

    public function getUpdates($lastSyncDate) {
        return $this->query("SELECT {$this->getColumns('TIPO_NOVEDAD', 'DESCRIPCION', 'ESTADO')->commaSep()} FROM {$this->getSchema()}.{$this->getTableName()} WHERE FECMODI BETWEEN ? AND CURRENT_TIMESTAMP",$lastSyncDate);
    }

}