<?php

namespace Model;

class BaseModel {
    protected $tableName;
    protected $schema;
    protected $connection;
    protected $query;
    protected $result;

    /**
     * @param Connection $connection
     * @param string $tableName
     * @param string $schema
     */
    function __construct(Connection $connection, $tableName = NULL, $schema = NULL) {
        $this->setTableName($tableName);
        $this->setSchema($schema ? $schema : $connection->getSchema());
        $this->connection = $connection;
    }

    /**
     * @return string
     */
    public function getTableName()
    {
        return $this->tableName;
    }

    /**
     * @param string $tableName
     */
    public function setTableName($tableName)
    {
        $this->tableName = $tableName;
    }

    /**
     * @return string
     */
    public function getSchema()
    {
        return $this->schema;
    }

    /**
     * @param string $schema
     */
    public function setSchema($schema)
    {
        $this->schema = $schema;
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
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param mixed $result
     */
    public function setResult($result)
    {
        $this->result = $result;
    }

    /**
     * @param string $sql
     * @param string $sqlName
     * @param bool $labels
     * @return void
     * */
    function query($sql,$sqlName,$labels) {
        if ($this->connection) {
            $preparedStatement = db2_prepare($this->connection->getConnectionResource(), utf8_encode(db2_escape_string($sql)));
            if ($preparedStatement) {
                $executedStatement = db2_execute($preparedStatement,'SET SCHEMA '.$this->schema);
                if ($executedStatement) {
                    //For INSERT
                    if (strpos($sql,"INSERT") !== false) {
                        $resultSet = db2_last_insert_id($this->connection->getConnectionResource());
                        $this->setResult($resultSet);
                    }
                    //For SELECT
                    if (strpos($sql,"SELECT") !== false) {
                        $resultSet = array();
                        if ($labels && $labels == true) {
                            while ($result = db2_fetch_assoc($preparedStatement)) {
                                array_push($resultSet, $result);
                            }
                        } else {
                            while ($result = db2_fetch_array($preparedStatement)) {
                                array_push($resultSet, $result);
                            }
                        }
                        $this->setResult($resultSet);
                    }
                } else {
                    throw new Exception('Falló la Ejecucion -'.$sqlName."-\n".'SQLSTATE:'.db2_stmt_error($executedStatement)."\n".'Mensaje de Error:'.db2_stmt_errormsg($executedStatement));
                }
            } else {
                throw new Exception('Falló la Preparacion -'.$sqlName."-\n".'SQLSTATE:'.db2_stmt_error($preparedStatement)."-\n".'Mensaje de Error:'.db2_stmt_errormsg($preparedStatement));
            }
        }
    }
}