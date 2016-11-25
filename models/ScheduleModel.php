<?php
/**
 * Created by PhpStorm.
 * User: ramiro
 * Date: 18/11/16
 * Time: 10:50 AM
 */

namespace Models;


use Helpers\CustomArray;

class ScheduleModel extends BaseModel {
    /** @param Connection $connection */
    public function __construct(Connection $connection) {
        parent::__construct($connection);
        $this->setTableName('SF_PROGRAMACION');
        $this->setPrimaryKey('ID_PROGRAMACION');
        $this->addColumns('ID_PROGRAMACION', 'DPTO', 'MUNICIPIO', 'PROMOTOR', 'CEB', 'ESTADO', 'ID_VISITA', 'DIRECCION', 'OTRADIR', 'TELEFONO1', 'TELEFONO2', 'EMAIL', 'LATITUD', 'LONGITUD', 'ID_BARRIO', 'BARRIO', 'FECPROG', 'USERCREA', 'FECCREA', 'IPCREA', 'USERMODI', 'IPMODI', 'FECMODI');
    }

    /** @return CustomArray */
    public function getAll($userId){
        return $this->query("SELECT {$this->getColumns('ID_PROGRAMACION', 'DPTO', 'MUNICIPIO', 'PROMOTOR', 'CEB', 'ESTADO', 'ID_VISITA', 'DIRECCION', 'OTRADIR', 'TELEFONO1', 'TELEFONO2', 'EMAIL', 'LATITUD', 'LONGITUD', 'ID_BARRIO', 'BARRIO', 'FECPROG')->commaSep()} FROM {$this->getSchema()}.{$this->getTableName()} WHERE PROMOTOR = ? AND ESTADO IN (?,?)",$userId,'A','D');
    }

    /** @return CustomArray */
    public function getUpdates($userId,$lastSyncDate) {
        return $this->query("SELECT {$this->getColumns('ID_PROGRAMACION', 'DPTO', 'MUNICIPIO', 'PROMOTOR', 'CEB', 'ESTADO', 'ID_VISITA', 'DIRECCION', 'OTRADIR', 'TELEFONO1', 'TELEFONO2', 'EMAIL', 'LATITUD', 'LONGITUD', 'ID_BARRIO', 'BARRIO', 'FECPROG')->commaSep()} FROM {$this->getSchema()}.{$this->getTableName()} WHERE PROMOTOR = ? AND FECMODI BETWEEN ? AND CURRENT_TIMESTAMP AND ESTADO IN (?,?,?)",$userId,$lastSyncDate,'I','A','D');
    }

}