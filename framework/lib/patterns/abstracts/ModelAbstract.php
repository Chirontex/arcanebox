<?php

namespace Arcanebox\lib\patterns\abstracts;

use Arcanebox\lib\patterns\interfaces\ModelInterface;

abstract class ModelAbstract implements ModelInterface
{

    protected $table_name, $mysqli;

    public function __construct()
    {

        $autoload = $GLOBALS['autoload'];

        $this->table_name = $this->tableName();

        if ($this->table_name != false) {

            $connection = $GLOBALS['autoload']->configs_loaded[Database];

            $this->mysqli = new \mysqli($connection[host], $connection[username], $connection[password], $connection[database]);
            $this->mysqli->query("SET NAMES 'utf8'");

        }

    }

    public function __destruct()
    {

        if (isset($this->mysqli)) {

            $this->mysqli->close();

        }

    }

    public function tableName()
    {

        return false;

    }

    public function index()
    {
 
    }

}
