<?php
/**
 * Created by PhpStorm.
 * User: ramiro
 * Date: 18/11/16
 * Time: 10:50 AM
 */

namespace SIGRI_HC\Controllers;


use SIGRI_HC\Models\Connection;
use SIGRI_HC\Models\ProcedureModel;

class ProcedureController extends BaseController {
    /** @param Connection $connection */
    public function __construct(Connection $connection) {
        parent::__construct(new ProcedureModel($connection));
    }

    /** @Deprecated */
    public function getUpdates(\DateTime $lastSyncDate)
    {
        return parent::getUpdates($lastSyncDate);
    }
}