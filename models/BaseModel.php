<?php

namespace Models;

use Helpers\CustomArray;
use Helpers\Row;

class BaseModel{
    /** @var null|string */
    protected $tableName;
    /** @var null|string */
    protected $schema;
    /** @var mixed|null */
    protected $primaryKey;
    /** @var Connection */
    protected $connection;
    /** @var string */
    protected $query;
    /** @var CustomArray */
    protected $result;
    /** @var CustomArray */
    protected $columns;

    /**
     * BaseModel constructor.
     * @param Connection $connection
     * @param null|string $tableName
     * @param null|string $schema
     * @param null|array $primaryKey
     */
    function __construct(Connection $connection, $tableName = null, $schema = null, $primaryKey = null) {
        $this->tableName = $tableName;
        $this->schema = $schema ? $schema : $connection->getDefaultSchema();
        $this->connection = $connection;
        $this->primaryKey = $primaryKey;
        $this->result = new CustomArray();
        $this->columns = new CustomArray();
    }

    /**
     * @return null|string
     */
    public function getTableName()
    {
        return $this->tableName;
    }

    /**
     * @param null|string $tableName
     */
    public function setTableName($tableName)
    {
        $this->tableName = $tableName;
    }

    /**
     * @return null|string
     */
    public function getSchema()
    {
        return $this->schema;
    }

    /**
     * @param null|string $schema
     */
    public function setSchema($schema)
    {
        $this->schema = $schema;
    }

    /**
     * @return mixed|null
     */
    public function getPrimaryKey()
    {
        return $this->primaryKey;
    }

    /**
     * @param mixed|null $primaryKey
     */
    public function setPrimaryKey($primaryKey)
    {
        $this->primaryKey = $primaryKey;
    }

    /**
     * @return Connection
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @param Connection $connection
     */
    public function setConnection($connection)
    {
        $this->connection = $connection;
    }

    /**
     * @return string
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param string $query
     */
    public function setQuery($query)
    {
        $this->query = $query;
    }

    /**
     * @return CustomArray
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param CustomArray $result
     */
    public function setResult(CustomArray $result)
    {
        $this->result = $result;
    }

    /**
     * @return array
     * @throws \ErrorException
     * */
    public function getColumns(...$columns)
    {
        $filteredColumns = new CustomArray();
        foreach ($columns as $column) {
            if(array_key_exists($column,$this->getColumns())) {
                $filteredColumns[$column] = $column;
            } else {
                throw new \ErrorException("El Campo $column NO EXISTE EN LA TABLA $this->schema.$this->tableName");
            }
        }
        if(!$columns) {
            return $this->columns;
        }
        return $filteredColumns;
    }

    /**
     * @param CustomArray $columns
     */
    public function setColumns(CustomArray $columns)
    {
        $this->columns = $columns;
    }

    /** @param string */
    public function addColumns(...$columns) {
        foreach ($columns as $column) {
            $this->columns[$column] = $column;
        }
    }

    /**
     * @param string $SQLsentence
     * @param mixed $arguments
     * @return string|CustomArray|bool
     * @throws \ErrorException
     */
    public function query($SQLsentence,...$arguments) {
        $this->setQuery($SQLsentence);
        if($this->connection->getConnectionResource()) {
            $preparedStmt = db2_prepare($this->connection->getConnectionResource(),$SQLsentence);
            foreach ($arguments as $argument) {
                $parameters[] = $argument;
                $this->query = substr_replace($this->query,$argument,strpos($this->query,'?'),strlen('?'));
            }
            if($preparedStmt) {
                if($this->execute($preparedStmt,$parameters)) {
                    $operation = substr($SQLsentence,0,strpos($SQLsentence," "));
                    switch ($operation) {
                        case "INSERT":
                            //Caso si Insert
                            return db2_last_insert_id($preparedStmt);
                            break;
                        case "SELECT":
                            //Caso si Select
                            if(LABELS) {
                                while ($result = db2_fetch_assoc($preparedStmt)) {
                                    $this->result->append(new Row($result));
                                }
                            } else {
                                while ($result = db2_fetch_array($preparedStmt)) {
                                    $this->result->append($result);
                                }
                            }
                            return $this->result;
                            break;
                        case "UPDATE":
                            //Caso si Update
                            break;
                        default:
                            return true;
                        break;
                    }
                }else {
                    throw new \ErrorException("ERROR DE EJECUCION ".db2_stmt_error().":".db2_stmt_errormsg());
                }
            } else {
                throw new \ErrorException("ERROR DE PREPARACION ".db2_stmt_error().":".db2_stmt_errormsg());
            }
        } else {
            throw new \ErrorException("ERROR DE CONEXION ".db2_conn_error().": ".db2_conn_errormsg());
        }
    }

    /** @param array $parameters
     * @return bool
     */
    public function execute(&$preparedStmt,$parameters){
        if(is_array($parameters)) {
            return db2_execute($preparedStmt,$parameters);
        }
        return db2_execute($preparedStmt);
    }
}