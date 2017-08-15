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
        $this->setTableName('AUDIT_PROGRAMAS');
        $this->setPrimaryKey('ID');
        $this->addColumns('ID', 'CODIGO', 'NOMBRE', 'ESTADO', 'EDAD_INICIAL', 'EDAD_FINAL', 'GENERO', 'FRECUENCIA', 'INTERVALO', 'CODSERV', 'DESCRIPCION');
    }
}