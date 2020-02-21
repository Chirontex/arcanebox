<?php

namespace Arcanebox\lib\patterns\abstracts;

use Arcanebox\lib\patterns\interfaces\SQLWizardInterface;

abstract class SQLWizardAbstract implements SQLWizardInterface
{

    private $connection, $host, $username, $password, $database;

    public function __construct()
    {

        global $autoload;

        $this->host = $autoload['Database']['host'];
        $this->username = $autoload['Database']['username'];
        $this->password = $autoload['Database']['password'];
        $this->database = $autoload['Database']['database'];

        $this->connection = new \mysqli($this->host, $this->username, $this->password, $this->database);

        if ($this->connection) $this->connection->query("SET NAMES 'utf8'");

    }

    public function __destruct()
    {

        if ($this->connection) $this->connection->close();

    }

    public function sql_select(array $params)
    {

        if ($this->connection && isset($params['prime']['name'])) {

            $columns = "";
            $joins = "";
            $where = "";
            $order_by = "";

            $t = 1;

            foreach ($params as $status => $terms) {

                $join_type = "";
                $on = "";
                $table_columns = "";
                $table_where = "";
                $table_order_by = "";

                if ($status = 'prime') $t = "";
                elseif ($status == 'left' || $status == 'right' || $status == 'full' || $status == 'cross') $join_type = $status;
                else {

                    if (is_array($terms['on'])) $join_type = 'inner';
                    else $join_type = 'cross';

                }

                if (iconv_strlen($join_type) > 0) {

                    switch ($join_type) {
                        case 'left':
                            $join_type = " LEFT ";
                            if (!is_array($terms['on'])) break 2;
                            break;

                        case 'right':
                            $join_type = " RIGHT ";
                            if (!is_array($terms['on'])) break 2;
                            break;

                        case 'inner':
                            $join_type = " INNER ";
                            if (!is_array($terms['on'])) break 2;
                            break;

                        case 'full':
                            $join_type = " FULL ";
                            break;

                        case 'cross':
                            $join_type = " CROSS ";
                            break;
                    }

                    $t += 1;

                }

                if (is_array($terms['on'])) {

                    foreach ($terms['on'] as $number => $column) {
                        
                        if ($number == 1) $n = "";
                        else $n = $number;

                        if (iconv_strlen($on) > 0) $on .= " db".$n.".".$column.")";
                        else $on = " ON (db".$n.".".$column." =";

                    }

                }
                
                if (isset($terms['columns'])) {

                    if (is_array($terms['columns'])) {

                        for ($i = 0; $i < count($terms['columns']); $i++) {

                            if (iconv_strlen($table_columns) > 0) $table_columns .= ", db".$t.".".$terms['columns'][$i];
                            else $table_columns = "db".$t.".".$terms['columns'][$i];

                        }

                    } else {

                        $column_string = (string)$terms['columns'];

                        $table_columns = "db".$t.".".$column_string;

                    }

                }

                if (is_array($terms['where'])) {

                    foreach ($terms['where'] as $column => $conditions) {

                        if (isset($conditions['union'])) {

                            switch ($conditions['union']) {
                                case 'and':
                                    $union = "AND";
                                    break;
                                
                                case 'or':
                                    $union = "OR";
                                    break;

                                default:
                                    $union = "AND";
                                    break;
                            }

                        } else $union = "AND";
                        
                        if (iconv_strlen($table_where) > 0 || iconv_strlen($where) > 0) $table_where .= " ".$union." db".$t.".".$column." = '".$conditions['value']."'";
                        else $table_where = " db".$t.".".$column." = '".$conditions['value']."'";

                    }

                }

                if (is_array($terms['order_by'])) {

                    foreach ($terms['order_by'] as $column => $condition) {
                        
                        if (iconv_strlen($table_order_by) > 0 || iconv_strlen($order_by) > 0) $table_order_by .= ", db".$t.".".$column." ".$condition;
                        else $table_order_by = "ORDER BY db".$t.".".$column." ".$condition;

                    }

                }

                if (iconv_strlen($join_type) > 0) $joins .= " ".$join_type." JOIN ".$on;

                $columns .= $table_columns;

                $where .= $table_where;

                $order_by .= $table_order_by;

            }

            if ($columns == "") $columns = "*";

            if (isset($params['prime']['limit'])) {

                $limit_int = (int)$params['prime']['limit'];

                $limit = " LIMIT ".$limit_int;

            } else $limit = "";

            $result_raw = $this->connection->query("SELECT ".$columns." FROM db.".$params['prime']['name'].$joins.$where.$order_by.$limit);

            $result = [];

            while ($result_row = $result_raw->fetch_assoc()) {

                $result[] = $result_row;

            }

        } else return false;

        return $result;

    }

}
