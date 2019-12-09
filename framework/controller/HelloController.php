<?php

namespace Arcanebox\controller;

use Arcanebox\lib\patterns\abstracts\ControllerAbstract;
use Arcanebox\model\Hello;

class HelloController extends ControllerAbstract
{

    public function index()
    {

        parent::index();

    }

    public function sign_in()
    {

        $this->render([
            'view' => 'sign_in'
        ]);

    }

    public function documentation()
    {

        $this->render([
            'view' => 'documentation'
        ]);

    }

}
