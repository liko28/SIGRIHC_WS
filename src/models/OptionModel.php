<?php

namespace SIGRI_HC\Models;


class OptionModel extends BaseModel {
    /** @param Connection $connection */
    public function __construct(Connection $connection) {
        parent::__construct($connection);
        $this->setTableName('SIGRI_OPCIONES');
        $this->setPrimaryKey('ID_OPCION');
        $this->addColumns('ID_OPCION', 'ID_LISTA', 'NOMBRE_LISTA', 'DESCRIPCION', 'VALOR', 'ESTADO', 'ORDEN', 'FECCREA', 'FECMODI');
    }
}