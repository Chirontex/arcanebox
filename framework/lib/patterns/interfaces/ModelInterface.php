<?php

namespace Arcanebox\lib\patterns\interfaces;

interface ModelInterface
{

    function __construct($tableName);
    function __destruct();
    function index();

}
