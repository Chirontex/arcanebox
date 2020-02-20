<?php

namespace Arcanebox\lib\patterns\interfaces;

interface SQLWizardInterface
{

    function __construct($tableName);
    function __destruct();
    function sql_select(array $params);

}
