<?php

namespace Arcanebox\model;

use Arcanebox\lib\patterns\abstracts\ModelAbstract;

class Hello extends ModelAbstract
{

    public function checkAuth($login, $password, $remember)
    {

        if ($login == 'test' && $password == '123') {

            session_name('authorization');

            if ($remember == 'remember-me') {

                session_start(['cookie_lifetime' => 86400]);
                $_SESSION['remember'] = $remember;

            } else session_start();

            $_SESSION['login'] = $login;
            $_SESSION['password'] = $password;

            return true;

        } else return false;

    }

    public function abortAuth()
    {

        session_abort();

    }

}
