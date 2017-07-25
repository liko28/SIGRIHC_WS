<?php
/**
 * Created by PhpStorm.
 * User: ramiro
 * Date: 18/11/16
 * Time: 10:50 AM
 */

namespace SIGRI_HC\Models;


class LaboratoryModel extends BaseModel {
    /** @param Connection $connection */
    public function __construct(Connection $connection) {
        parent::__construct($connection);
        $this->setTableName('HC_LABORATORIOS');
        $this->setPrimaryKey('ID_LABORATORIO');
        $this->addColumns('ID_LABORATORIO', 'CODIGO', 'DESCRIPCION', 'VALORREF1', 'VALORREF2', 'TIPO', 'ORDEN', 'FECCREA', 'FECMODI');
    }
}