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

    public function getQuestionId($entity,$attr) {
        foreach ($this->model->getResult() as $question) {
            if($question->ENTIDAD == $entity && $question->ATRIBUTO == $attr ) {
                return $question->CODIGO;
            }
        }
    }

    public function getResult() {
        return $this->model->getResult();
    }

    public function getQuestionsDemanda(\DateTime $lastSyncDate = null){
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

    public function getQuestionsAuditoria(\DateTime $lastSyncDate = null){
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

    public function getQuestionsSigri(\DateTime $lastSyncDate = null){
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

    public function getQuestionsSigriHc(\DateTime $lastSyncDate = null){
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