<?php
/**
 * Created by PhpStorm.
 * User: ramiro
 * Date: 10/11/16
 * Time: 11:26 AM
 */

namespace Controllers;

use Models\Connection as Connection;
use Models\ReferenceListModel;

class ReferenceListController extends BaseController {
    public function __construct(Connection $connection) {
        parent::__construct(new ReferenceListModel($connection));
    }

    public function getAll() {
        return $this->model->getAll();
    }

    public function getUpdates($lastSyncDate){
        $lastSyncDate = new \DateTime($lastSyncDate);
        return $this->model->getUpdates($lastSyncDate->format('Y-m-d H:i:s'));
    }
}