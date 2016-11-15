<?php
/**
 * Created by PhpStorm.
 * User: ramiro
 * Date: 10/11/16
 * Time: 11:26 AM
 */

namespace Controllers;

use Models\Connection as Connection;
use Models\ReferenceListModel;

class ReferenceListController extends BaseController {
    public function __construct(Connection $connection) {
        parent::__construct(new ReferenceListModel($connection));
    }

    public function getAll() {
        $res = $this->getModel()->getAll()->getArray();
        return $res;
    }
}