<?php

namespace Arcanebox\lib\patterns\interfaces;

interface SQLWizardInterface
{

    function __construct();
    function __destruct();
    function sql_select(array $params);

}
