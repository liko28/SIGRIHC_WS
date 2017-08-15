<?php
/**
 * Created by PhpStorm.
 * User: ramiro
 * Date: 18/11/16
 * Time: 10:50 AM
 */

namespace SIGRI_HC\Models;


class ProgramModel extends BaseModel {
    /** @param Connection $connection */
    public function __construct(Connection $connection) {
        parent::__construct($connection);
        $this->setTableName('AUDI_PROGRAMAS');
        $this->setPrimaryKey('ID');
        $this->addColumns('ID', 'CODIGO', 'NOMBRE', 'ACTIVO', 'EDAD_MIN', 'EDAD_MAX', 'HOMBRE', 'MUJER', 'FRECUENCIA', 'INTERVALO', 'CODSERV', 'DESCRIPCION');
    }

    /**
     * @param $lastSyncDate
     * @return \SIGRI_HC\Helpers\CustomArray
     * @deprecated
     */
    public function getUpdates($lastSyncDate)
    {
        return parent::getUpdates($lastSyncDate);
    }
}