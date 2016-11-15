<?php
/**
 * Created by PhpStorm.
 * User: ramiro
 * Date: 3/11/16
 * Time: 12:42 PM
 */

namespace Models;


class Connection {
    private $database;
    private $host;
    private $port;
    private $userName;
    private $password;
    private $connectionString;
    private $connectionResource;
    private $options;
    private $defaultSchema;

    /**
     * Connection constructor.
     * @param string $bd
     * @param string $host
     * @param integer $port
     * @param string $userName
     * @param string $password
     * @param string $defaultSchema
     */
    function __construct($bd = NULL, $host = NULL, $port = NULL, $userName = NULL, $password = NULL, $defaultSchema = NULL) {
        $this->database = $bd;
        $this->host = $host;
        $this->port = $port;
        $this->userName = $userName;
        $this->password = $password;
        $this->defaultSchema = $defaultSchema;
        $this->connectionString = "DRIVER={IBM DB2 ODBC DRIVER}; DATABASE={$this->database}; HOSTNAME={$this->host}; PORT={$this->port}; PROTOCOL=TCPIP; UID={$this->userName}; PWD={$this->password}; SCHEMA={$this->defaultSchema}";
        $this->options = array("AUTOCOMMIT" => DB2_AUTOCOMMIT_OFF,"DB2_ATTR_CASE" => DB2_CASE_UPPER);
        try {
            $this->connect();
        } catch (\ErrorException $e) {
            return $e->getMessage();
        }
    }

    /**
     * @throws \ErrorException
     * @return void
     */
    public function connect() {
        $this->connectionResource = db2_connect($this->connectionString,'','');
        if(!$this->connectionResource) {
            //TODO especificar los errores de conexion
            throw new \ErrorException("ERROR DE CONEXION: ".db2_conn_error().":".db2_conn_errormsg());
        }
    }

    /**
     * @return void
     */
    public function disconnect() {
        db2_close($this->connectionResource);
    }

    /**
     * @return void
     */
    public function __destruct() {
        $this->disconnect();
    }

    /**
     * @return string
     */
    public function getDatabase()
    {
        return $this->database;
    }

    /**
     * @param string $database
     */
    public function setDatabase($database)
    {
        $this->database = $database;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param string $host
     */
    public function setHost($host)
    {
        $this->host = $host;
    }

    /**
     * @return int
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @param int $port
     */
    public function setPort($port)
    {
        $this->port = $port;
    }

    /**
     * @return string
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @param string $userName
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getConnectionString()
    {
        return $this->connectionString;
    }

    /**
     * @param string $connectionString
     */
    public function setConnectionString($connectionString)
    {
        $this->connectionString = $connectionString;
    }

    /**
     * @return mixed
     */
    public function getConnectionResource()
    {
        return $this->connectionResource;
    }

    /**
     * @param mixed $connectionResource
     */
    public function setConnectionResource($connectionResource)
    {
        $this->connectionResource = $connectionResource;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param array $options
     */
    public function setOptions($options)
    {
        $this->options = $options;
    }

    /**
     * @return string
     */
    public function getDefaultSchema()
    {
        return $this->defaultSchema;
    }

    /**
     * @param string $defaultSchema
     */
    public function setDefaultSchema($defaultSchema)
    {
        $this->defaultSchema = $defaultSchema;
    }


}