<?php

namespace SIGRI_HC\Models;


class OptionModel extends BaseModel {
    /** @param Connection $connection */
    public function __construct(Connection $connection) {
        parent::__construct($connection);
        $this->setTableName('SIGRI_OPCIONES');
        $this->setPrimaryKey('ID_LISTA');
        $this->addColumns('ID_LISTA', 'PADRE', 'NOMBRE_VARIABLE', 'VALOR', 'DESCRIPCION', 'CODLISTA', 'ESTADO', 'ORDEN', 'FECCREA', 'FECMODI');
    }
}