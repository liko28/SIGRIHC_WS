<?php
/**
 * Created by PhpStorm.
 * User: ramiro
 * Date: 18/11/16
 * Time: 10:50 AM
 */

namespace Models;


class QuestionModel extends BaseModel {
    /** @param Connection $connection */
    public function __construct(Connection $connection) {
        parent::__construct($connection);
        $this->setTableName('HC_PREGUNTAS');
        $this->setPrimaryKey('ID_PREGUNTA');
        $this->addColumns('ID_PREGUNTA', 'DESCRIPCION', 'ENTIDAD', 'ATRIBUTO', 'TIPOCAMPO', 'LONCAMPO', 'DEPENDE', 'OBLIGATORIO', 'ID_MODULO', 'ID_LISTA', 'NOMLISTA', 'VALORLISTA', 'CAMPOSIRFAM','TIPO','VALIDAR','EDADINI','EDADFIN','GENERO','ESTADO','VISIBILIDAD','NIVEL','CODIGO','ORDEN','FECCREA','FECMODI');
    }

    /** @return CustomArray */
    public function getAll(){
        return $this->query("SELECT {$this->getColumns('ID_PREGUNTA', 'DESCRIPCION', 'ENTIDAD', 'ATRIBUTO', 'TIPOCAMPO', 'LONCAMPO', 'DEPENDE', 'OBLIGATORIO', 'ID_MODULO', 'ID_LISTA', 'NOMLISTA', 'VALORLISTA', 'CAMPOSIRFAM','TIPO','VALIDAR','EDADINI','EDADFIN','GENERO','ESTADO','VISIBILIDAD','NIVEL','CODIGO','ORDEN')->commaSep()} FROM {$this->getSchema()}.{$this->getTableName()}");
    }

    /** @return CustomArray */
    public function getUpdates($lastSyncDate) {
        return $this->query("SELECT {$this->getColumns('ID_PREGUNTA', 'DESCRIPCION', 'ENTIDAD', 'ATRIBUTO', 'TIPOCAMPO', 'LONCAMPO', 'DEPENDE', 'OBLIGATORIO', 'ID_MODULO', 'ID_LISTA', 'NOMLISTA', 'VALORLISTA', 'CAMPOSIRFAM','TIPO','VALIDAR','EDADINI','EDADFIN','GENERO','ESTADO','VISIBILIDAD','NIVEL','CODIGO','ORDEN')->commaSep()} FROM {$this->getSchema()}.{$this->getTableName()} WHERE FECMODI BETWEEN ? AND CURRENT_TIMESTAMP",$lastSyncDate);
    }

}