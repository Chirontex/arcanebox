<?php

namespace Arcanebox\lib\patterns\interfaces;

interface ControllerInterface
{

    function __construct($action, $language);
    function index();
    function chooseLayout();
    function render($view);

}
