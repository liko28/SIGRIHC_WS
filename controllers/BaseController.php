<?php
/**
 * Created by PhpStorm.
 * User: ramiro
 * Date: 8/11/16
 * Time: 12:44 PM
 */

namespace Controllers;


use Model\BaseModel;

class BaseController {
    /** @var  $model BaseModel */
    private $model;

    public function __construct(BaseModel $model) {
        $this->setModel($model);
    }

    public function getById($id) {
        $this->model->query("SELECT * FROM {$this->model->getSchema()} WHERE {$this->model->getPrimaryKey()} = {$id}",
            "getById $id in {$this->model->getSchema()}.{$this->model->getTableName()}",
            true);
    }

    public function getByColumName($columnName, $value) {
        $this->model->query("SELECT * FROM {$this->model->getSchema()} WHERE {$columnName} = {$value}");
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