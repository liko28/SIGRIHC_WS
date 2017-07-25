<?php

namespace SIGRI_HC\Models;

use SIGRI_HC\Helpers\CustomArray;
use SIGRI_HC\Helpers\Row;

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
     * @return null|string
     */
    public function getFullTableName(){
        return $this->getSchema().".".$this->getTableName();
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
     * @throws \Exception
     * */
    public function getColumns(...$columns)
    {
        $filteredColumns = new CustomArray();
        foreach ($columns as $column) {
            if(array_key_exists($column,$this->getColumns())) {
                $filteredColumns[$column] = $this->getSchema().'.'.$this->tableName.'.'.$column;
            } else {
                throw new \Exception("El Campo $column NO EXISTE EN LA TABLA $this->schema.$this->tableName");
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
     * @throws \Exception
     */
    public function query($SQLsentence,...$arguments) {
        $this->setQuery($SQLsentence);
        if($this->connection->getConnectionResource()) {
            $parameters = null;
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
                            $this->result = db2_last_insert_id($this->connection->getConnectionResource());
                            return $this->result;
                            break;
                        case "SELECT":
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
                            return db2_num_rows($preparedStmt);
                            break;
                        default:
                            return true;
                            break;
                    }
                }else {
                    throw new \Exception("ERROR DE EJECUCION ".db2_stmt_error().":".db2_stmt_errormsg()." en {$this->getSchema()}.{$this->getTableName()}");
                }
            } else {
                throw new \Exception("ERROR DE PREPARACION ".db2_stmt_error().":".db2_stmt_errormsg());

            }
        } else {
            throw new \Exception("ERROR DE CONEXION ".db2_conn_error().": ".db2_conn_errormsg());
        }
    }

    /** @param array $parameters
     * @return bool
     * @throws \Exception
     */
    public function execute(&$preparedStmt,$parameters = null){
        if($parameters) {
            $res = db2_execute($preparedStmt,$parameters);
        } else {
            $res = db2_execute($preparedStmt);
        }

        if($res) {
            return true;
        } else {
            return false;
        }
    }

    public function insert(Row $object) {
        $columns = "";
        $values = "";
        foreach ($object as $field => $value) {
            $columns .= "$field, ";
            if (is_string($value)) {
                $val = db2_escape_string($value);
                $values .= "'$val', ";
            } elseif(is_numeric($value)) {
                $values .= "$value, ";
            } else {
                $values .= "$value, ";
            }
        }
        $columns = trim($columns,', ');
        $values = trim($values,', ');
        $query = "INSERT INTO {$this->getSchema()}.{$this->getTableName()} ($columns) VALUES($values)";
        try {
            $this->query($query);
        } catch (\Exception $e) {
            throw $e;
        }
        return $this->result;
    }

    public function update($id, Row $object) {
        $columns = "";
        foreach ($object as $field => $value) {
            if (is_string($value)) {
                $val = db2_escape_string($value);
                $columns .= "$field = '$val', ";
            } elseif(is_numeric($value)) {
                $columns .= "$field = $value, ";
            } else {
                $columns .= "$field = $value, ";
            }
        }
        $columns = trim($columns,', ');
        $query = "UPDATE {$this->getSchema()}.{$this->getTableName()} SET $columns WHERE {$this->getSchema()}.{$this->getTableName()}.{$this->getPrimaryKey()} = ?";
        return $this->query($query,$id);
    }

    public function get($id){
        return $this->query("SELECT * FROM {$this->getSchema()}.{$this->getTableName()} WHERE {$this->getSchema()}.{$this->getTableName()}.{$this->getPrimaryKey()} = ?",$id);
    }

    public function commit(){
        db2_commit($this->connection->getConnectionResource());
    }

    public function getAll(){
        return $this->query("SELECT {$this->getColumns()->commaSep()} FROM {$this->getSchema()}.{$this->getTableName()}");
    }

    /** @return CustomArray */
    public function getUpdates($lastSyncDate){
        return $this->query("SELECT {$this->getColumns()->commaSep()} FROM {$this->getSchema()}.{$this->getTableName()} WHERE FECMODI BETWEEN ? AND CURRENT_TIMESTAMP",$lastSyncDate);
    }
}