<?php

namespace SIGRI_HC\Models;

class QuestionModel extends BaseModel {
    /** @param Connection $connection */
    public function __construct(Connection $connection) {
        parent::__construct($connection);
        $this->setTableName('HC_PREGUNTAS');
        $this->setPrimaryKey('ID_PREGUNTA');
        $this->addColumns('ID_PREGUNTA', 'DESCRIPCION', 'ENTIDAD', 'ATRIBUTO', 'TIPOCAMPO', 'LONCAMPO', 'DEPENDE', 'OBLIGATORIO', 'ID_MODULO', 'ID_LISTA', 'NOMLISTA', 'VALORLISTA', 'CAMPOSIRFAM','TIPO','VALIDAR','EDADINI','EDADFIN','GENERO','ESTADO','VISIBILIDAD','NIVEL','CODIGO','ORDEN','FECCREA','FECMODI');
    }
}