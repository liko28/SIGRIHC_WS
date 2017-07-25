<?php
/**
 * Created by PhpStorm.
 * User: ramiro
 * Date: 18/11/16
 * Time: 10:50 AM
 */

namespace SIGRI_HC\Models;


class ScheduleDetailModel extends BaseModel {
    /** @param Connection $connection */
    public function __construct(Connection $connection) {
        parent::__construct($connection);
        $this->setTableName('SF_PROGRAMACION_DET');
        $this->setPrimaryKey('ID_PROGRAMACION','ID_USUARIO');
        $this->addColumns('ID_PROGRAMACION', 'ID_USUARIO', 'MOTVISITA', 'TIPOVISITA', 'PARENTESCO', 'CLASIFICACION', 'FECINGRESO');
    }

    /** @return CustomArray */
    public function getAll($userId){
        return $this->query("SELECT {$this->getSchema()}.{$this->getTableName()}.ID_PROGRAMACION, {$this->getColumns('ID_USUARIO', 'MOTVISITA', 'TIPOVISITA', 'PARENTESCO', 'CLASIFICACION', 'FECINGRESO')->commaSep()} ".
            "FROM {$this->getSchema()}.{$this->getTableName()} ".
            "JOIN {$this->getSchema()}.SF_PROGRAMACION ON {$this->getSchema()}.{$this->getTableName()}.ID_PROGRAMACION = {$this->getSchema()}.SF_PROGRAMACION.ID_PROGRAMACION ".
            "WHERE PROMOTOR = ? AND ESTADO IN (?,?)",$userId,'A','D'
            );
    }

    /** @return CustomArray */
    public function getUpdates($userId,$lastSyncDate) {
        return $this->query("SELECT {$this->getSchema()}.{$this->getTableName()}.ID_PROGRAMACION, {$this->getColumns('ID_USUARIO', 'MOTVISITA', 'TIPOVISITA', 'PARENTESCO', 'CLASIFICACION', 'FECINGRESO')->commaSep()} ".
            "FROM {$this->getSchema()}.{$this->getTableName()} ".
            "JOIN {$this->getSchema()}.SF_PROGRAMACION ON {$this->getSchema()}.{$this->getTableName()}.ID_PROGRAMACION = {$this->getSchema()}.SF_PROGRAMACION.ID_PROGRAMACION ".
            "WHERE PROMOTOR = ? AND FECMODI BETWEEN ? AND CURRENT_TIMESTAMP AND ESTADO IN (?,?)",$lastSyncDate,$userId,'A','D'
        );
    }
}