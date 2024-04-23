<?php
define('BASE_URL', 'http://localhost/Crud%20App/RESTAPI/');
define('PROJECT_PATH', dirname(__DIR__));

$autoload = ['config/connect', 'helper/functions', 'helper/query-builder', 'helper/lexical'];

foreach ($autoload as $index => $file) {
    require_once PROJECT_PATH . "/{$file}.php";
}