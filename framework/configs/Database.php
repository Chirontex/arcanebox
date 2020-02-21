<?php

namespace Arcanebox\configs;

use Arcanebox\lib\patterns\interfaces\ConfigInterface;

class Database implements ConfigInterface {

    public function initialization() {

        $dbconnect = [
            'host' => 'localhost',
            'username' => 'root',
            'password' => '',
            'database' => 'arcanebox'
        ];

        return $dbconnect;

    }

}
