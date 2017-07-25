<?php

namespace SIGRI_HC\Models;


class VariableModel extends BaseModel {
    /** @param Connection $connection */
    public function __construct(Connection $connection) {
        parent::__construct($connection);
        $this->setTableName('SIGRI_VARIABLES');
        $this->setPrimaryKey('ID_VARIABLE');
        $this->addColumns('ID_VARIABLE', 'NOMBRE_VARIABLE', 'DESCRIPCION', 'ENTIDAD', 'ATRIBUTO', 'TIPOCAMPO', 'LONCAMPO', 'DEPENDE', 'OBLIGATORIO', 'ID_LISTA', 'NOMLISTA', 'VALORLISTA', 'ID_MODULO', 'TIPO', 'VALIDAR', 'EDADINI', 'EDADFIN', 'GENERO', 'ESTADO', 'VISIBILIDAD', 'NIVEL', 'CODIGO', 'ORDEN', 'FECCREA', 'FECMODI');
    }

    /** @return CustomArray */
    public function getAll(){
        return $this->query("SELECT {$this->getColumns('ID_VARIABLE', 'NOMBRE_VARIABLE', 'DESCRIPCION', 'ENTIDAD', 'ATRIBUTO', 'TIPOCAMPO', 'LONCAMPO', 'DEPENDE', 'OBLIGATORIO', 'ID_LISTA', 'NOMLISTA', 'VALORLISTA', 'ID_MODULO', 'TIPO', 'VALIDAR', 'EDADINI', 'EDADFIN', 'GENERO', 'ESTADO', 'VISIBILIDAD', 'NIVEL', 'CODIGO', 'ORDEN', 'FECCREA', 'FECMODI')->commaSep()}, CONF.INTERVALO, CONF.FRECUENCIA FROM {$this->getFullTableName()} LEFT JOIN {$this->getSchema()}.SIGRI_CONFIGURACION CONF ON CONF.ID_VARIABLE = {$this->getFullTableName()}.ID_VARIABLE");
    }

    /** @return CustomArray */
    public function getUpdates($lastSyncDate) {
        return $this->query("SELECT {$this->getColumns('ID_VARIABLE', 'NOMBRE_VARIABLE', 'DESCRIPCION', 'ENTIDAD', 'ATRIBUTO', 'TIPOCAMPO', 'LONCAMPO', 'DEPENDE', 'OBLIGATORIO', 'ID_LISTA', 'NOMLISTA', 'VALORLISTA', 'ID_MODULO', 'TIPO', 'VALIDAR', 'EDADINI', 'EDADFIN', 'GENERO', 'ESTADO', 'VISIBILIDAD', 'NIVEL', 'CODIGO', 'ORDEN', 'FECCREA', 'FECMODI')->commaSep()}, CONF.INTERVALO, CONF.FRECUENCIA FROM {$this->getFullTableName()} LEFT JOIN {$this->getSchema()}.SIGRI_CONFIGURACION CONF ON CONF.ID_VARIABLE = {$this->getFullTableName()}.ID_VARIABLE WHERE {$this->getFullTableName()}.FECMODI BETWEEN ? AND CURRENT_TIMESTAMP",$lastSyncDate);
    }

}