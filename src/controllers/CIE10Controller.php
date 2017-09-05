<?php

namespace SIGRI_HC\Controllers;

use SIGRI_HC\Helpers\CustomArray;
use SIGRI_HC\Models\Connection;
use SIGRI_HC\Models\CIE10Model;

class CIE10Controller extends BaseController {
    /** @param Connection $connection */
    public function __construct(Connection $connection) {
        parent::__construct(new CIE10Model($connection));
    }

    public function get(\DateTime $lastSyncDate = null, $client = null) {
        switch ($client) {
            case DEMANDA:
            case VISITA:
            case HISTORIA:
                $asterisk = true;
                break;
            case AUDITORIA:
                $this->model->setColumns(new CustomArray(["ID", "CODIGO", "DESCRIPCION"]));
                $asterisk = false;
                break;
            default:
                $asterisk = true;
        }
        $result = parent::get($lastSyncDate, $asterisk);
        return $result;
    }
}