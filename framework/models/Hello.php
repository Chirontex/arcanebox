<?php

namespace Arcanebox\models;

use Arcanebox\lib\patterns\abstracts\ModelAbstract;

class Hello extends ModelAbstract
{

    public function checkAuth($login, $password, $remember = null)
    {

        if ($login == 'test' && $password == '123') {

            if ($login != $_SESSION['login'] && $password != $_SESSION['password']) {

                if ($remember == 'remember-me') {

                    session_start(['cookie_lifetime' => 86400]);
                    $session_id = session_id();
                    setcookie('session', $session_id, time()+86400);

                } else session_start();

                $_SESSION['login'] = $login;
                $_SESSION['password'] = $password;

            }

            setcookie('logged', true);
            $_COOKIE['logged'] = true;

            return true;

        } else return false;

    }

    public function abortAuth()
    {

        session_start();
        $_SESSION = [];
        session_destroy();

        setcookie('logged', false, 0);
        $_COOKIE['logged'] = false;

    }

}
