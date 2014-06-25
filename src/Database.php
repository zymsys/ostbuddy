<?php
namespace Buddy;

class Database
{
    private $connection;
    function __construct(Config $config)
    {
        $this->connection = mysqli_connect($config['DBHOST'], $config['DBUSER'], $config['DBPASS'], $config['DBNAME']);
    }

    public function get($sql)
    {
        $rows = array();
        $ri = mysqli_query($this->connection, $sql);
        if (!$ri) {
            throw new \ErrorException(mysqli_error($this->connection), mysqli_errno($this->connection));
        }
        while (($row = mysqli_fetch_assoc($ri)) !== null) {
            $rows[] = $row;
        }
        mysqli_free_result($ri);
        return $rows;
    }
}