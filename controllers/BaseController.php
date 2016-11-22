<?php

namespace Controllers;

use Models\BaseModel;

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
     * @param string $lastSyncDate
     * @return CustomArray */
    public function getUpdates($lastSyncDate){
        $_lastSyncDate = new \DateTime();
        return $this->model->getUpdates($_lastSyncDate->setTimeStamp($lastSyncDate)->format('Y-m-d-H.i.s'));
    }
}