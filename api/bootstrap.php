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

$container['notAllowedHandler'] = function ($c) {
    return function ($request, $response, $methods) use ($c) {
        return $c['response']
            ->withStatus(405)
            ->withHeader('Allow', implode(', ', $methods))
            ->withHeader('Content-Type', 'Application/json')
            ->withHeader("Access-Control-Allow-Methods", implode(",", $methods))
            ->withJson(["message" => "Method not Allowed; Method must be one of: " . implode(', ', $methods)], 405);
    };
};

$container['notFoundHandler'] = function ($container) {
    return function ($request, $response) use ($container) {
        return $container['response']
            ->withStatus(404)
            ->withHeader('Content-Type', 'Application/json')
            ->withJson(['message' => 'Page not found']);
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

$container['secretkey'] = "chavesecreta";

$app = new \Slim\App($container);

$app->add(new TrailingSlash(false));

/*
$app->add(new \Slim\Middleware\HttpBasicAuthentication([
    "users" => [
        "eduardo" => "abc123"
    ],
    "path" => ["/auth"],
]));*/
$app->add(new \Tuupola\Middleware\HttpBasicAuthentication([
    "users" => [
        "eduardo" => "abc123"
    ],
    "path" => ["/v1/auth"],
]));

$app->add(new Tuupola\Middleware\JwtAuthentication([
    "regexp" => "/(.*)/", //Regex para encontrar o Token nos Headers - Livre
    "header" => "X-Token", //O Header que vai conter o token
    "path" => "/", //Vamos cobrir toda a API a partir do /
    "ignore" => ["/auth", "/v1/auth", "/v1/evento/"], //Vamos adicionar a exceção de cobertura a rota /auth
    "realm" => "Protected",
    "secret" => $container['secretkey'] //Nosso secretkey criado
]));
