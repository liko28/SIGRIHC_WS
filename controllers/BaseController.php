<?php
/**
 * Created by PhpStorm.
 * User: ramiro
 * Date: 8/11/16
 * Time: 12:44 PM
 */

namespace Controllers;


use Models\BaseModel;

class BaseController {
    /** @var  $model BaseModel */
    protected $model;

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

    public function convertToUtf8(&$item) {
        if(is_array($item)) {
            array_walk_recursive($item,'convertToUtf8');
        } else {
            utf8_encode($item);
        }
    }


}