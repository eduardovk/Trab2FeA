<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require './vendor/autoload.php';

$app = new \Slim\App;


$app->get('/evento', function (Request $request, Response $response) use ($app) {
    $return = $response->withJson(['msg' => 'Lista de Eventos'], 200)
    ->withHeader('Content-type', 'application/json');
    return $return;
});


$app->get('/evento/{id}', function (Request $request, Response $response) use ($app) {
    $route = $request->getAttribute('route');
    $id = $route->getArgument('id');

    $return = $response->withJson(['msg' => "Exibindo o evento {$id}"], 200)
    ->withHeader('Content-type', 'application/json');
    return $return;
});


$app->post('/evento', function (Request $request, Response $response) use ($app) {
    $return = $response->withJson(['msg' => "Cadastrando um evento"], 201)
    ->withHeader('Content-type', 'application/json');
    return $return;
});


$app->put('/evento/{id}', function (Request $request, Response $response) use ($app) {
    $route = $request->getAttribute('route');
    $id = $route->getArgument('id');
    $return = $response->withJson(['msg' => "Modificando o evento {$id}"], 200)
    ->withHeader('Content-type', 'application/json');
    return $return;
});


$app->delete('/evento/{id}', function (Request $request, Response $response) use ($app) {
    $route = $request->getAttribute('route');
    $id = $route->getArgument('id');
    $return = $response->withJson(['msg' => "Deletando o evento {$id}"], 204)
    ->withHeader('Content-type', 'application/json');
    return $return;
});

$app->run();
