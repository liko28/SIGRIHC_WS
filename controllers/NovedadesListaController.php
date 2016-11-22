<?php
/**
 * Created by PhpStorm.
 * User: ramiro
 * Date: 18/11/16
 * Time: 10:50 AM
 */

namespace Controllers;


use Models\Connection;
use Models\NovedadesListaModel;

class NovedadesListaController extends BaseController {
    /** @param Connection $connection */
    public function __construct(Connection $connection) {
        parent::__construct(new NovedadesListaModel($connection));
    }

    /** @return CustomArray */
    public function getAll() {
        return $this->model->getAll();
    }

    /**
     * @param string $lastSyncDate
     * @return CustomArray */
    public function getUpdates($lastSyncDate){
        $_lastSyncDate = new \DateTime();
        return $this->model->getUpdates($_lastSyncDate->setTimeStamp($lastSyncDate)->format('Y-m-d-H.i.s'));
    }

}