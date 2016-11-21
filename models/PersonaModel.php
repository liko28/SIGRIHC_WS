<?php

namespace Models;

class PersonaModel extends BaseModel {
    /** @param Connection $connection */
    public function __construct(Connection $connection) {
        parent::__construct($connection);
        $this->setTableName('SF_PERSONAS');
        $this->setPrimaryKey('ID_USUARIO');
        $this->addColumns('ID_USUARIO','APELLIDO1','APELLIDO2','NOMBRE1','NOMBRE2','TIPODOC','DOCUMENTO','CARNET','FECHANAC','SEXO','ESTADO','CELULAR','EMAIL','PESONACER','TALLANACER','DOCMAMA','DOCPAPA','IDULTVISITA','FECULTVISITA','CODINST','FECMODI');
    }

    /** @return CustomArray */
    public function getAll(){
        return $this->query("SELECT {$this->getColumns('ID_USUARIO','APELLIDO1','APELLIDO2','NOMBRE1','NOMBRE2','TIPODOC','DOCUMENTO','CARNET','FECHANAC','SEXO','ESTADO','CELULAR','EMAIL','PESONACER','TALLANACER','DOCMAMA','DOCPAPA','IDULTVISITA','FECULTVISITA','CODINST','FECMODI')->commaSep()} FROM {$this->getSchema()}.{$this->getTableName()}");
    }

    /** @return CustomArray */
    public function getUpdates($lastSyncDate) {
        return $this->query("SELECT {$this->getColumns('ID_USUARIO','APELLIDO1','APELLIDO2','NOMBRE1','NOMBRE2','TIPODOC','DOCUMENTO','CARNET','FECHANAC','SEXO','ESTADO','CELULAR','EMAIL','PESONACER','TALLANACER','DOCMAMA','DOCPAPA','IDULTVISITA','FECULTVISITA','CODINST','FECMODI')->commaSep()} FROM {$this->getSchema()}.{$this->getTableName()} WHERE FECMODI BETWEEN ? AND CURRENT_TIMESTAMP",$lastSyncDate);
    }

}