<?php

namespace Models;

class BaseModel {
    protected $tableName;
    protected $schema;
    protected $primaryKey;
    protected $connection;
    protected $query;
    protected $result;

    /**
     * @param Connection $connection
     * @param string $tableName
     * @param string $schema
     * @param mixed $primaryKey
     */
    function __construct(Connection $connection, $schema = null, $tableName = null, $primaryKey = null) {
        $this->setTableName($tableName);
        $this->setSchema($schema ? $schema : $connection->getDefaultSchema());
        $this->setConnection($connection);
        $this->setPrimaryKey($primaryKey);
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
     * @return mixed
     */
    public function getPrimaryKey()
    {
        return $this->primaryKey;
    }

    /**
     * @param mixed $primaryKey
     */
    public function setPrimaryKey($primaryKey)
    {
        $this->primaryKey = $primaryKey;
    }

    public function query($sql) {
        return $this->getConnection()->getConnectionResource()->query($sql);
    }

    public function getRow($sql) {
        return \JsonSerializable::
    }
}