<?php

namespace Arcanebox\lib\patterns\abstracts;

use Arcanebox\lib\patterns\interfaces\SQLWizardInterface;

abstract class SQLWizardAbstract implements SQLWizardInterface
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

    private function joiner()
    {



    }

    public function sql_select(array $params)
    {

        if ($this->table_name && is_array($params)) {

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
/*
            $joins = "";

            if (isset($params['joins'])) {

                for ($i = 0; $i < count($params['joins'][$i]); $i++) {

                    $t = $i + 2;

                    if (isset($params['joins'][$i]['columns']) && count($params['joins'][$i]['columns']) > 0) {

                        foreach ($params['joins'][$i]['columns'] as $key => $column) {
                            
                            if ($columns == "*") $columns = "db".$t.".".$column;
                            else $columns .= ", db".$t.".".$column;

                        }

                    }

                    if (isset($params['joins'][$i]['where']) && count($params['joins'][$i]['where']) > 0) {

                        foreach ($params['joins'][$i]['where'] as $column => $condition) {
                            
                            if (iconv_strlen($where_conditions) > 0) $where_conditions .= " AND db".$t.".".$column." = '".$condition."'";
                            else $where_conditions = " WHERE db".$t.".".$column." = '".$condition."'";

                        }

                    }

                    if (isset($params['joins'][$i]['order_by']) && count($params['joins'][$i]['order_by']) > 0) {

                        foreach ($$params['joins'][$i]['order_by'] as $column => $condition) {
                            
                            if (iconv_strlen($order_by) > 0) $order_by .= ", db".$t.".".$column." ".$condition;
                            else $order_by = " ORDER BY db".$t.".".$column." ".$condition;

                        }

                    }

                    if (!isset($params['joins'][$i]['type'])) $params['joins'][$i]['type'] = 'inner';

                    switch ($params['joins'][$i]['type']) {
                        case 'left':
                            //дописать
                            break;
                        
                        default:
                            # code...
                            break;
                    }

                }

            }
*/
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
