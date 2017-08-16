<?php
/**
 * Created by PhpStorm.
 * User: ramiro
 * Date: 18/11/16
 * Time: 10:50 AM
 */

namespace SIGRI_HC\Models;


use SIGRI_HC\Helpers\CustomArray;

class ScheduleModel extends BaseModel {
    /** @param Connection $connection */
    public function __construct(Connection $connection) {
        parent::__construct($connection);
        $this->setTableName('SF_PROGRAMACION');
        $this->setPrimaryKey('ID_PROGRAMACION');
        $this->addColumns('ID_PROGRAMACION', 'DPTO', 'MUNICIPIO', 'PROMOTOR', 'CEB', 'ESTADO', 'ID_VISITA', 'DIRECCION', 'OTRADIR', 'TELEFONO1', 'TELEFONO2', 'EMAIL', 'LATITUD', 'LONGITUD', 'ID_BARRIO', 'BARRIO', 'FECPROG', 'USERCREA', 'FECCREA', 'IPCREA', 'USERMODI', 'IPMODI', 'FECMODI');
    }

    /** @return CustomArray */
    public function getAll($userId, $client, \DateTime $lastSyncDate = null){
        if($lastSyncDate) {
            $date = $lastSyncDate->format('Y-m-d-H.i.s');
        }
        $visitType = '';
        switch ($client) {
            case DEMANDA:
                $visitType = "AND DET.TIPOVISITA IN('DI')";
                break;
            case AUDITORIA:
                $visitType = "AND DET.TIPOVISITA IN('AU')";
                break;
            case VISITA:
                $visitType = "AND DET.TIPOVISITA IS NULL";
                break;
            case HISTORIA:
                $visitType ="AND DET.TIPOVISITA IN('ME', 'EN', 'MG', 'PS', 'TS')" ;
                break;
        }


        if($date) {
            return $this->query("SELECT {$this->getColumns()->commaSep()}
FROM {$this->getFullTableName()} PROG
JOIN {$this->getTableName()}.SF_PROGRAMACION_DET DET ON PROG.ID_PROGRAMACION = DET.ID_PROGRAMACION
WHERE PROMOTOR = ? $visitType AND ESTADO IN('A','D') AND FECMODI BETWEEN ? AND CURRENT_TIMESTAMP;",$userId,$date);
        }

        return $this->query("SELECT {$this->getColumns()->commaSep()}
FROM {$this->getFullTableName()} PROG
JOIN {$this->getTableName()}.SF_PROGRAMACION_DET DET ON PROG.ID_PROGRAMACION = DET.ID_PROGRAMACION
WHERE PROMOTOR = ? $visitType AND ESTADO IN('A','D')",$userId);

    }
}