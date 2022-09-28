<?php

use Core\Routing\Router;

require "../bootstrap.php";
require "../routes/api.php";

$router = new Router;
$router->handle();