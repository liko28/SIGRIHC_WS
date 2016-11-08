<?php
/**
 * Created by PhpStorm.
 * User: ramiro
 * Date: 8/11/16
 * Time: 12:44 PM
 */

namespace Controllers;


use Model\UsersModel;

class UsersController extends BaseController {

    public function __construct(UsersModel $model)
    {
        parent::__construct($model);
        return self::class;
    }

    public function getByUserName($userName) {
        $this->getByColumName('NOMBRE',$userName);
    }


}