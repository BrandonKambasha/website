<?php

require '../autoload.php';
require '../loadTemplate.php';

$routes = new \carsdb\Routes();

$entryPoint = new \entry\entryPoint($routes);

$entryPoint->run();