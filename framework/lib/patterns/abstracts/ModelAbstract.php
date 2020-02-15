<?php

namespace Arcanebox\lib\patterns\abstracts;

use Arcanebox\lib\patterns\interfaces\ModelInterface;

abstract class ModelAbstract implements ModelInterface
{

    protected $table_name, $connection, $database_config;

    public function __construct($tableName = false)
    {

        $autoload = $GLOBALS['autoload'];

        $this->table_name = $tableName;

        if ($this->table_name) {

            $this->database_config = $autoload->configs_loaded['Database'];

            $this->connection = new \mysqli($this->database_config['host'], $this->database_config['username'], $this->database_config['password'], $this->database_config['database']);

            if ($this->connection) $this->connection->query("SET NAMES 'utf8'");

        }

    }

    public function __destruct()
    {

        if (isset($this->connection)) $this->connection->close();

    }

    public function database_select($params)
    {

        if ($this->table_name) {

            if (isset($params['table'])) $table = $params['table'];
            else $table = $this->table_name;

            $columns = "";

            if (isset($params['columns']) && count($params['columns']) > 0) {

                foreach ($params['columns'] as $key => $column) {
                    
                    if (iconv_strlen($columns) > 0) $columns .= ", db.".$column;
                    else $columns = "db.".$column;

                }

            } else $columns = "*";

            $where_conditions = "";

            if (isset($params['where']) && count($params['where']) > 0) {

                foreach ($params['where'] as $column => $condition) {
                    
                    if (iconv_strlen($where_conditions) > 0) $where_conditions .= " AND db.".$column." = '".$condition."'";
                    else $where_conditions = " WHERE db.".$column." = '".$condition."'";

                }

            }

            $order_by = "";

            if (isset($params['order_by']) && count($params['order_by']) > 0) {

                foreach ($params['order_by'] as $column => $condition) {
                    
                    if (iconv_strlen($order_by) > 0) $order_by .= ", db.".$column." ".$condition;
                    else $order_by = " ORDER BY db.".$column." ".$condition;

                }

            }

            $limit = "";

            if (isset($params['limit'])) {

                $limit_int = (int)$params['limit'];

                if ($limit_int > 0) $limit = " LIMIT ".$limit_int;

            }

            $raw_result = $this->connection->query("SELECT ".$columns." FROM ".$this->database_config['database'].$table." AS db".$where_conditions.$order_by.$limit);

            $result = [];

            if ($raw_result) {

                while ($raw_result_row = $raw_result->fetch_assoc()) {

                    $result[] = $raw_result_row;

                }

            } else $result = false;

            return $result;

        } else return false;

    }

}
