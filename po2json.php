<?php

declare(strict_types=1);

use Po2Json\Commands\Convert;
use Symfony\Component\Console\Application;

require __DIR__ . '/vendor/autoload.php';

$application = new Application('po2json', '1.0.0');
$defaultCommand = new Convert();
$application->add($defaultCommand);
$application->setDefaultCommand($defaultCommand->getName(), true);
$application->run();
