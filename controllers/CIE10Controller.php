<?php
/**
 * Created by PhpStorm.
 * User: ramiro
 * Date: 18/11/16
 * Time: 10:50 AM
 */

namespace Controllers;


use Models\Connection;
use Models\CIE10Model;

class CIE10Controller extends BaseController {
    /** @param Connection $connection */
    public function __construct(Connection $connection) {
        parent::__construct(new CIE10Model($connection));
    }

    /** @return CustomArray */
    public function getAll() {
        return $this->model->getAll();
    }

}