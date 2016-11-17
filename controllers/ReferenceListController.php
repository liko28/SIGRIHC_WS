<?php

namespace Controllers;

use Helpers\CustomArray;
use Models\Connection as Connection;
use Models\ReferenceListModel;

class ReferenceListController extends BaseController {
    /** @param Connection $connection */
    public function __construct(Connection $connection) {
        parent::__construct(new ReferenceListModel($connection));
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