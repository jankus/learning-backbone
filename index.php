<?php

require_once __DIR__ . '/Application/Application.php';

try {
    $application = new \Application\Application();
    $application->init();
    $application->run();
} catch (\Exception $e) {
    echo 'Man.. something bad happened. Here\'s what: ',  $e->getMessage(), "\n";
}
