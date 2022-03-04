<?php

class DB
{
    private $connection;
    //
    function __construct($dbConfig)
    {
        $connectionID = mysqli_init();
        $connectionID->options(MYSQLI_OPT_CONNECT_TIMEOUT, $dbConfig['timeout']);
        $connectionID->real_connect($dbConfig["host"], $dbConfig["username"], $dbConfig["password"]);

        if (mysqli_connect_errno()) {
            echo 'Connection error.';
            exit();
        }

        if (!$connectionID->select_db($dbConfig["database"])) {
            $connectionID->close();
            echo 'Database not found.';
            exit();
        }

        $connectionID->query("SET NAMES 'utf8'");

        $this->connection=$connectionID;
    }
    //
    public function escape($value)
    {
        return $this->connection->escape_string($value);
    }
    //
    public function query($query)
    {
        if ($result = $this->connection->query($query)) {
            $data = array();

            if($result===true){
                if($this->connection->insert_id){
                    $data[]=['insert_id'=>$this->connection->insert_id];
                }
                else
                    return true;
            }
            if(is_object($result)) {
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $data[] = $row;
                    }
                }
                $result->close();
            }

            return $data;

        } else {
            return false;
        }
    }
}
