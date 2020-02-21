<?php

namespace Arcanebox\configs;

use Arcanebox\lib\patterns\interfaces\ConfigInterface;

class Domain implements ConfigInterface
{

    public function initialization()
    {

        $domain = [
            'domain_name' => $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'],
            'framework_folder' => 'framework'
        ];

        return $domain;

    }

}
