#!/usr/bin/env php

<?php

require __DIR__ . '/vendor/autoload.php';

use App\SendClientsDataCommand;
use Symfony\Component\Console\Application;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$application = new Application();

$application->add(new SendClientsDataCommand());

$application->run();