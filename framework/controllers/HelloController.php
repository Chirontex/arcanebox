<?php

namespace Arcanebox\controllers;

use Arcanebox\lib\patterns\abstracts\ControllerAbstract;
use Arcanebox\models\Hello;

class HelloController extends ControllerAbstract
{

    public function index()
    {

        parent::index();

    }

    public function sign_in()
    {

        if (isset($_COOKIE['session'])) session_id($_COOKIE['session']);

        session_start();

        $model = new Hello;

        $check = $model->checkAuth($_SESSION['login'], $_SESSION['password']);

        if ($check) {

            $this->render(['view' => 'cabinet']);

        } else $this->render(['view' => 'sign_in']);

        $model = null;

    }

    public function documentation()
    {

        $this->render([
            'view' => 'documentation'
        ]);

    }

    public function auth($login = null, $password = null, $remember = null)
    {

        session_start();

        $model = new Hello;

        if ($login == null) $login = $_POST['login'];
        if ($password == null) $password = $_POST['password'];
        if ($remember == null) $remember = $_POST['remember'];

        $check = $model->checkAuth($login, $password, $remember);

        if ($check) {

            $this->render(['view' => 'cabinet']);

        } elseif (isset($_SESSION['login']) && isset($_SESSION['password'])) {

            $check = $model->checkAuth($_SESSION['login'], $_SESSION['password']);

            if ($check) {

                $this->render(['view' => 'cabinet']);

            } else $this->render(['view' => 'sign_in', 'auth' => 'fail']);

        } else {

            $this->render(['view' => 'sign_in', 'auth' => 'fail']);

        }

        $model = null;

    }

    public function logout()
    {

        $model = new Hello;
        $model->abortAuth();

        setcookie('logged', false, 0);
        $_COOKIE['logged'] = false;

        $this->sign_in();

        $model = null;

    }

}
