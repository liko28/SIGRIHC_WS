<?php
/**
 * Created by PhpStorm.
 * User: ramiro
 * Date: 18/11/16
 * Time: 10:50 AM
 */

namespace Controllers;


use Models\Connection;
use Models\IpsModel;

class IpsController extends BaseController {
    /** @param Connection $connection */
    public function __construct(Connection $connection) {
        parent::__construct(new IpsModel($connection));
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
        $_lastSyncDate->setTimeStamp($lastSyncDate);
        return $this->model->getUpdates($_lastSyncDate->format('Y-m-d-H.i.s'));
    }

}