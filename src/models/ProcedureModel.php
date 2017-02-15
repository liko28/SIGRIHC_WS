<?php
/**
 * Created by PhpStorm.
 * User: ramiro
 * Date: 18/11/16
 * Time: 10:50 AM
 */

namespace SIGRI_HC\Models;


class ProcedureModel extends BaseModel {
    /** @param Connection $connection */
    public function __construct(Connection $connection) {
        parent::__construct($connection);
        $this->setTableName('HC_PROCEDIMIENTOS');
        $this->setPrimaryKey('ID_PROCEDIMIENTO');
        $this->addColumns('ID_PROCEDIMIENTO', 'CODIGO', 'DESCRIPCION', 'ESTADO');
    }

    /** @return CustomArray */
    public function getAll(){
        return $this->query("SELECT {$this->getColumns()->commaSep()} FROM {$this->getSchema()}.{$this->getTableName()}");
    }

}