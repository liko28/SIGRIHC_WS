<?php
/**
 * Created by PhpStorm.
 * User: ramiro
 * Date: 18/11/16
 * Time: 10:50 AM
 */

namespace SIGRI_HC\Controllers;


use SIGRI_HC\Models\Connection;
use SIGRI_HC\Models\LaboratoryModel;

class LaboratoryController extends BaseController {
    /** @param Connection $connection */
    public function __construct(Connection $connection) {
        parent::__construct(new LaboratoryModel($connection));
    }

    /**
     * @deprecated
     * @param string $lastSyncDate
     * @return CustomArray
     *
     */
    public function getUpdates($lastSyncDate)
    {
        return parent::getUpdates($lastSyncDate);
    }
}