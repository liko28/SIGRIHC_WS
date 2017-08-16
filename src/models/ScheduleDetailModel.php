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
    public function getAll($userId, $client, $lastSyncDate){
        if($lastSyncDate) {
            $date = $lastSyncDate->format('Y-m-d-H.i.s');
        }
        if($date){
            return $this->query("SELECT {$this->getColumns()}
FROM {$this->getFullTableName()} DET
JOIN {$this->getSchema()}.SF_PROGRAMACION PROG ON PROG.ID_PROGRAMACION = DET.ID_PROGRAMACION
WHERE PROMOTOR = ? AND ESTADO IN('A','D') AND FECMODI BETWEEN ? AND CURRENT_TIMESTAMP;",$userId,$date);
        }
        return $this->query("SELECT {$this->getColumns()}
FROM {$this->getFullTableName()} DET
JOIN {$this->getSchema()}.SF_PROGRAMACION PROG ON PROG.ID_PROGRAMACION = DET.ID_PROGRAMACION
WHERE PROMOTOR = ? AND ESTADO IN('A','D');",$userId);
    }

    /** @return CustomArray */
    public function getUpdates($userId,$lastSyncDate) {
        return $this->query("SELECT {$this->getColumns()} ".
            "FROM {$this->getFullTableName()} ".
            "JOIN {$this->getSchema()}.SF_PROGRAMACION ON {$this->getFullTableName()}.ID_PROGRAMACION = {$this->getSchema()}.SF_PROGRAMACION.ID_PROGRAMACION ".
            "WHERE PROMOTOR = ? AND FECMODI BETWEEN ? AND CURRENT_TIMESTAMP AND ESTADO IN (?,?)",$lastSyncDate,$userId,'A','D'
        );
    }
}