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
            $this->connection->query("SET NAMES 'utf8'");

        }

    }

    public function __destruct()
    {

        if (isset($this->connection)) {

            $this->connection->close();

        }

    }

    public function databaseSelect($params)
    {

        if ($this->table_name && $params['column']) {

            if (isset($params['tablename'])) $table_name = $params['tablename'];
            else $table_name = $this->table_name;

            $columns = "";
            $columns_temp = [];
            $temp_count = 0;

            foreach ($params as $key => $value) {
                
                if (substr($key, 0, 6) == 'column') {

                    if (!(substr($key, 5))) $columns .= "t.".$value;
                    elseif (substr($columns, 0, 2) == 't.') $columns .= ", t.".$value;
                    else {

                        $temp_count += 1;
                        $temp_name = 'column_temp_'.$temp_count;
                        $columns_temp = [$temp_name => ", t.".$value];

                    }

                }

            }

            foreach ($columns_temp as $key => $value) {
                
                $columns .= $value;

            }

            $conditions = "";

            if (is_array($params['where'])) {

                foreach ($params['where'] as $key => $value) {
                    
                    if ($conditions == "") $conditions = "WHERE t.".$key." = ".$value;
                    else $conditions .= "AND t.".$key." = ".$value;

                }

            }

            $raw_result = $this->connection->query("SELECT ".$columns." FROM ".$this->database_config['database'].$table_name." AS t ".$conditions);

            $result = [];

            $row_count = 0;

            while ($result_row = $raw_result->fetch_assoc()) {
                
                $result = [$row_count => $result_row];

                $row_count += 1;

            }

            return $result;

        } else return false;

    }

}
