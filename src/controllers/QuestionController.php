<?php
/**
 * Created by PhpStorm.
 * User: ramiro
 * Date: 18/11/16
 * Time: 10:50 AM
 */

namespace SIGRI_HC\Controllers;


use SIGRI_HC\Models\Connection;
use SIGRI_HC\Models\QuestionModel;

class QuestionController extends BaseController {
    /** @param Connection $connection */
    public function __construct(Connection $connection) {
        parent::__construct(new QuestionModel($connection));
    }

    public function getQuestionEntity($id) {
        foreach ($this->model->getResult() as $question) {
            if($question->CODIGO == $id) {
                return $question->ENTIDAD;
            }
        }

    }

    public function getQuestionField($id) {
        foreach ($this->model->getResult() as $question) {
            if($question->CODIGO == $id) {
                return $question->ATRIBUTO;
            }
        }
    }

    public function getQuestionType($id) {
        foreach ($this->model->getResult() as $question) {
            if($question->CODIGO == $id) {
                return $question->TIPOCAMPO;
            }
        }

    }

    public function getResult() {
        return $this->model->getResult();
    }
}