<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Server\Server;

Server::create();
Server::run();

?>
