<?php

namespace Arcanebox\config;

use Arcanebox\lib\patterns\interfaces\ConfigInterface;

class Interceptor implements ConfigInterface
{

    public function initialization()
    {

        $interceptor = [
            '404' => 'not_found'
        ];

        return $interceptor;

    }

}
