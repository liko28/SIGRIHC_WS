<?php
/**
 * Created by PhpStorm.
 * User: ramiro
 * Date: 18/11/16
 * Time: 10:50 AM
 */

namespace SIGRI_HC\Models;


class GroupModel extends BaseModel {
    /** @param Connection $connection */
    public function __construct(Connection $connection) {
        parent::__construct($connection);
        $this->setTableName('SIGRI_GRUPOS');
        $this->setPrimaryKey('ID');
        $this->addColumns('ID', 'DESCRIPCION', 'TIPO', 'ID_VARIABLE', 'PREFIJO', 'LIMITE', 'FECCREA', 'FECMODI');
    }
}