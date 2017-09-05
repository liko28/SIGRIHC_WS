<?php

namespace SIGRI_HC\Helpers;

use Monolog\Handler\StreamHandler;
use SIGRI_HC\Controllers\UserController;
use SIGRI_HC\Models\Connection;

class Logger {
    /** @var \Monolog\Logger  */
    private $loggerInstance;
    /** @var string  */
    private $path;
    /** @var string  */
    private $fileName;

    /** @param string|null $userName*/
    public function __construct($userName = null, Connection $connection = null) {
        $this->fileName = $userName ? "$userName.txt" : "log.txt";
        $this->path = "logs/".date('Y-m-d')."/";

        //Obtener Dpto y Municipio para el User
        if($connection && $userName) {
            $user = new UserController($connection);
            $userData = $user->getByUserName($userName)[0];
            $this->path .= $userData->DPTO."/".$userData->CIUDAD."/";
        }

        $this->createPath();
        $this->loggerInstance = new \Monolog\Logger('SIGRIHC_LOGGER');
        $this->loggerInstance->pushHandler(new StreamHandler($this->path.$this->fileName));
    }

    /** @return void */
    public function createPath() {
        mkdir($this->path,0777,true);
    }

    public static function getPath($userName = null) {
        $fileName = $userName ? "$userName.txt" : "log.txt";
        $path = "logs/".date('Y-m-d')."/";
        return $path.$fileName;

    }

    /** @return \Monolog\Logger */
    public function getInstance() {
        return $this->loggerInstance;
    }

    public static function log($level,$message,$path){
        $logger = new Logger();
        switch ($level) {
            case 300:
                $logger->getInstance()->pushHandler(new StreamHandler($path))->addWarning($message);
                break;
            case 200:
                $logger->getInstance()->pushHandler(new StreamHandler($path))->addInfo($message);
                break;
        }
    }
}