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
            'model' => 'Hello',
            'view' => 'sign_in'
        ]);

    }

    public function documentation()
    {

        $this->render([
            'model' => 'Hello',
            'view' => 'documentation'
        ]);

    }

}
