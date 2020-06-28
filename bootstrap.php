<?php

require './vendor/autoload.php';

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Psr7Middlewares\Middleware\TrailingSlash;

$configs = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];

$container = new \Slim\Container($configs);

$container['errorHandler'] = function ($c) {
    return function ($request, $response, $exception) use ($c) {
        $statusCode = $exception->getCode() ? $exception->getCode() : 500;
        return $c['response']->withStatus($statusCode)
        ->withHeader('Content-Type', 'Application/json')
        ->withJson(["message" => $exception->getMessage()], $statusCode);
    };
};

$container['logger'] = function($container) {
    $logger = new Monolog\Logger('logs');
    $logfile = __DIR__ . '/log/logs.log';
    $stream = new Monolog\Handler\StreamHandler($logfile, Monolog\Logger::DEBUG);
    $fingersCrossed = new Monolog\Handler\FingersCrossedHandler(
        $stream, Monolog\Logger::INFO);
    $logger->pushHandler($fingersCrossed);

    return $logger;
};

$isDevMode = true;

$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/src/Models/Entity"), $isDevMode);

$conn = array('driver' => 'pdo_mysql','host'=> 'localhost','dbname' => 'trab2fea','user' => 'root','password' => '');

$entityManager = EntityManager::create($conn, $config);

$container['em'] = $entityManager;

$app = new \Slim\App($container);

$app->add(new TrailingSlash(false));
