<?php

$time_start = microtime(true);

require_once 'framework/autoloader.php';

use Arcanebox\controller;

$autoload = new Arcanebox\Autoloader;

$response_code = http_response_code();

if (isset($_GET['r'])) $action = $_GET['r'];
else $action = 'index';

if (isset($autoload->configs_loaded['Interceptor'])) {

    switch ($response_code) {
        case 404: {

            if (isset($autoload->configs_loaded['Interceptor']['404'])) $action = $autoload->configs_loaded['Interceptor']['404'];

        }
        break;

        default:
        break;

    }

}

if (isset($_GET['l']) && $_GET['l'] != 'default') {
    setcookie("language", $_GET['l']);
    $language = $_GET['l'];
}

if ($_GET['l'] === 'default') {
    setcookie("language", "", 0);
    $language = 'default';
}

if (!(isset($_GET['l'])) && isset($_COOKIE["language"])) $language = $_COOKIE["language"];

if (!(isset($_GET['l'])) && !(isset($_COOKIE["language"]))) $language = 'default';

$controller_calling = new controller\HelloController($action, $language);
