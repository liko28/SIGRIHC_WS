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
}