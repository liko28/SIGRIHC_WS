<?php

namespace SIGRI_HC\Helpers;

use Monolog\Handler\StreamHandler;

class Logger {
    /** @var \Monolog\Logger  */
    private $loggerInstance;
    /** @var string  */
    private $path;
    /** @var string  */
    private $fileName;

    /** @param string|null $userName*/
    public function __construct($userName = null) {
        $this->fileName = $userName ? "$userName.txt" : "log.txt";
        $this->path = "logs/".date('Y-m-d')."/";
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