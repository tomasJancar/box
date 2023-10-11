<?php

use App\Application;
use Doctrine\ORM\EntityManager;
use GuzzleHttp\Psr7\Message;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use Nette\DI\Container;
use Nette\DI\ContainerLoader;

/** @var EntityManager $entityManager */
$entityManager = require __DIR__ . '/src/bootstrap.php';

$loader = new ContainerLoader(__DIR__ . '/temp', autoRebuild: true);
$class = $loader->load(function($compiler) {
    $compiler->loadConfig(__DIR__ . '/config/config.neon');
});
/** @var Container $container */
$container = new $class;

$request = new Request('POST', new Uri('http://localhost/pack'), ['Content-Type' => 'application/json'], $argv[1]);

$application = new Application($entityManager, $container);
$response = $application->run($request);

echo "<<< In:\n" . Message::toString($request) . "\n\n";
echo ">>> Out:\n" . Message::toString($response) . "\n\n";

