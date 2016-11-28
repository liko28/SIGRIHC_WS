<?php
/**
 * Created by PhpStorm.
 * User: ramiro
 * Date: 18/11/16
 * Time: 10:50 AM
 */

namespace Models;


class MedicineModel extends BaseModel {
    /** @param Connection $connection */
    public function __construct(Connection $connection) {
        parent::__construct($connection);
        $this->setTableName('HC_MEDICAMENTOS');
        $this->setPrimaryKey('ID_MEDICAMENTO');
        $this->addColumns('ID_MEDICAMENTO', 'CODIGO', 'DESCRIPCION', 'PRINCIPIO', 'CONCENTRACION', 'PRESENTACION', 'ACLARACION', 'GRUPO');
    }

    /** @return CustomArray */
    public function getAll(){
        return $this->query("SELECT {$this->getColumns()->commaSep()} FROM {$this->getSchema()}.{$this->getTableName()}");
    }

}