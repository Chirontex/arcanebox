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

        if (isset($_SESSION['login']) && isset($_SESSION['password']) && isset($_SESSION['remember'])) $this->auth($_SESSION['login'], $_SESSION['password'], $_SESSION['remember']);
        elseif (isset($_SESSION['login']) && isset($_SESSION['password'])) $this->auth($_SESSION['login'], $_SESSION['password']);
        else $this->render(['view' => 'sign_in']);

    }

    public function documentation()
    {

        $this->render([
            'view' => 'documentation'
        ]);

    }

    public function auth($login = null, $password = null, $remember = null)
    {

        $model = new Hello;

        if ($login == null) $login = $_POST['login'];
        if ($password == null) $password = $_POST['password'];
        if ($remember == null) $remember = $_POST['remember'];

        $check = $model->checkAuth($login, $password, $remember);

        $model = null;

        if ($check) $this->render(['view' => 'cabinet']);
        else $this->render(['view' => 'sign_in', 'auth' => 'fail']);

    }

    public function logout()
    {

        $model = new Hello;
        $model->abortAuth();
        $model = null;

        $this->sign_in();

    }

}
