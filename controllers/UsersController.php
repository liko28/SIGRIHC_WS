<?php
/**
 * Created by PhpStorm.
 * User: ramiro
 * Date: 8/11/16
 * Time: 12:44 PM
 */

namespace Controllers;


use Models\Connection;
use Models\UsersModel;

class UsersController extends BaseController {

    public function __construct(Connection $connection) {
        parent::__construct(new UsersModel($connection));
    }

    public function getByUserName($userName) {
        //$this->getByColumName('NOMBRE',$userName);
        $this->getModel()->query("SELECT * FROM {$this->getModel()->getSchema()}.{$this->getModel()->getTableName()} WHERE NOMBRE = $userName",get_class($this)." $userName",true);
    }


}