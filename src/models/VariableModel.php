<?php

namespace SIGRI_HC\Models;


class VariableModel extends BaseModel {
    /** @param Connection $connection */
    public function __construct(Connection $connection) {
        parent::__construct($connection);
        $this->setTableName('SIGRI_VARIABLES');
        $this->setPrimaryKey('ID_VARIABLE');
        $this->addColumns('ID_VARIABLE', 'NOMBRE_VARIABLE', 'DESCRIPCION', 'ENTIDAD', 'ATRIBUTO', 'TIPOCAMPO', 'LONCAMPO', 'DEPENDE', 'OBLIGATORIO', 'ID_LISTA', 'NOMLISTA', 'VALORLISTA', 'ID_MODULO', 'TIPO', 'VALIDAR', 'EDADINI', 'EDADFIN', 'GENERO', 'ESTADO', 'VISIBILIDAD', 'NIVEL', 'CODIGO', 'ORDEN', 'FECCREA', 'FECMODI', 'INTERVALO', 'FRECUENCIA');
    }
}