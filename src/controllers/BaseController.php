<?php

namespace SIGRI_HC\Controllers;

use SIGRI_HC\Helpers\CustomArray;
use SIGRI_HC\Models\BaseModel;

class BaseController {
    /** @var  $model BaseModel */
    protected $model;

    /** @param BaseModel $model */
    public function __construct(BaseModel $model) {
        $this->setModel($model);
    }

    /**
     * @return BaseModel
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param BaseModel $model
     */
    public function setModel($model)
    {
        $this->model = $model;
    }

    /** @return CustomArray */
    public function getAll() {
        return $this->model->getAll();
    }

    /**
     * @param \DateTime $lastSyncDate
     * @return CustomArray */
    public function getUpdates(\DateTime $lastSyncDate){
        return $this->model->getUpdates($lastSyncDate->format('Y-m-d H:i:s'));
    }

    /**
     * @param \DateTime|null $lastSyncDate
     * @return CustomArray
     */
    public function get(\DateTime $lastSyncDate = null){
        if($lastSyncDate) {
            return $this->getUpdates($lastSyncDate);
        }
        return $this->getAll();
    }

    public function insert(Row $object) {
        return $this->model->insert($object);
    }
}