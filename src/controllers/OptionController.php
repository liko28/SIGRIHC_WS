<?php
/**
 * Created by PhpStorm.
 * User: ramiro
 * Date: 18/11/16
 * Time: 10:50 AM
 */

namespace SIGRI_HC\Controllers;


use SIGRI_HC\Models\Connection;
use SIGRI_HC\Models\OptionModel;

class OptionController extends BaseController {
    /** @param Connection $connection */
    public function __construct(Connection $connection) {
        parent::__construct(new OptionModel($connection));
    }

    public function getOptionsDemanda(\DateTime $lastSyncDate = null){
        try {
            if($lastSyncDate) {
                $res =$this->getModel()->updatesForDemandas($lastSyncDate);
            } else {
                $res = $this->getModel()->forDemandas();
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
        return $res->values();
    }

    public function getOptionsAuditoria(\DateTime $lastSyncDate = null){
        try {
            if($lastSyncDate) {
                $res =$this->getModel()->updatesForAuditorias($lastSyncDate);
            } else {
                $res = $this->getModel()->forAuditorias();
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
        return $res->values();
    }

    public function getOptionsSigri(\DateTime $lastSyncDate = null){
        try {
            if($lastSyncDate) {
                $res =$this->getModel()->updatesForSigri($lastSyncDate);
            } else {
                $res = $this->getModel()->forSigri();
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
        return $res->values();
    }

    public function getOptionsSigriHc(\DateTime $lastSyncDate = null){
        try {
            if($lastSyncDate) {
                $res =$this->getModel()->updatesForSigriHc($lastSyncDate);
            } else {
                $res = $this->getModel()->forSigriHc();
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
        return $res->values();
    }
}