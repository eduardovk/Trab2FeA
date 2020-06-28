<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use App\Models\Entity\Evento;
use Firebase\JWT\JWT;

require 'bootstrap.php';

$app->get('/auth', function (Request $request, Response $response) use ($app) {

    $key = $this->get("secretkey");

    $token = "teste_token_jwt";

    $jwt = JWT::encode($token, $key);

    return $response->withJson(["auth-jwt" => $jwt], 200)
        ->withHeader('Content-type', 'application/json');
});

$app->get('/evento', function (Request $request, Response $response) use ($app) {
    $entityManager = $this->get('em');
    $eventosRepository = $entityManager->getRepository('App\Models\Entity\Evento');
    $eventos = $eventosRepository->findAll();

    $return = $response->withJson($eventos, 200)
        ->withHeader('Content-type', 'application/json');
    return $return;
});


$app->get('/evento/{id}', function (Request $request, Response $response) use ($app) {
    $route = $request->getAttribute('route');
    $id = $route->getArgument('id');

    $entityManager = $this->get('em');
    $eventosRepository = $entityManager->getRepository('App\Models\Entity\Evento');
    $evento = $eventosRepository->find($id);

    if(!$evento){
        $logger = $this->get('logger');
        $logger->warning("Evento {$id} não encontrado!");
        throw new \Exception("Evento não encontrado", 404);
    }

    $return = $response->withJson($evento, 200)
        ->withHeader('Content-type', 'application/json');
    return $return;
});

/*
curl -X POST http://localhost:8000/evento -H "Content-type: application/json" -d
'{"titulo":"Teste Evento POST","descricao":"Descricao do Evento","data_hora":"2020-06-22 15:50:00",
"local":"Local do Evento","imagem":"nenhuma","url_amiga":"teste-evento-post","id_usuario":"0","ativo":"1"}'
*/
$app->post('/evento', function (Request $request, Response $response) use ($app) {
    $params = (object) $request->getParams();

    $entityManager = $this->get('em');

    $evento = (new Evento())->setTitulo($params->titulo)
    ->setDescricao($params->descricao)
    ->setDataHora(new DateTime($params->data_hora))
    ->setLocal($params->local)
    ->setImagem($params->imagem)
    ->setUrlAmiga($params->url_amiga)
    ->setIdUsuario($params->id_usuario)
    ->setAtivo($params->ativo);


    $entityManager->persist($evento);
    $entityManager->flush();

    $logger = $this->get('logger');
    $logger->info('Evento cadastrado!', null);

    $return = $response->withJson($evento, 201)
        ->withHeader('Content-type', 'application/json');
    return $return;
});


$app->put('/evento/{id}', function (Request $request, Response $response) use ($app) {
    $params = (object) $request->getParams();
    $route = $request->getAttribute('route');
    $id = $route->getArgument('id');

    $entityManager = $this->get('em');
    $eventosRepository = $entityManager->getRepository('App\Models\Entity\Evento');
    $evento = $eventosRepository->find($id);

    $logger = $this->get('logger');

    if(!$evento){
        $logger->warning("Evento {$id} não encontrado - Não foi possível atualizar!");
        throw new \Exception("Evento não encontrado", 404);
    }

    $evento->setTitulo($params->titulo)
    ->setDescricao($params->descricao)
    ->setDataHora(new DateTime($params->data_hora))
    ->setLocal($params->local)
    ->setImagem($params->imagem)
    ->setUrlAmiga($params->url_amiga)
    ->setIdUsuario($params->id_usuario)
    ->setAtivo($params->ativo);

    $entityManager->persist($evento);
    $entityManager->flush();

    $logger->info("Evento {$id} atualizado!", array($evento));

    $return = $response->withJson($evento, 200)
        ->withHeader('Content-type', 'application/json');
    return $return;
});


$app->delete('/evento/{id}', function (Request $request, Response $response) use ($app) {
  $route = $request->getAttribute('route');
  $id = $route->getArgument('id');

  $entityManager = $this->get('em');
  $eventosRepository = $entityManager->getRepository('App\Models\Entity\Evento');
  $evento = $eventosRepository->find($id);

  $logger = $this->get('logger');

  if(!$evento){
      $logger->warning("Evento {$id} não encontrado - Não foi possível deletar!");
      throw new \Exception("Evento não encontrado", 404);
  }

  $entityManager->remove($evento);
  $entityManager->flush();

  $logger->info("Evento {$id} deletado!", array($evento));

  $return = $response->withJson(['msg' => "Deletado o evento {$id}"], 204)
      ->withHeader('Content-type', 'application/json');
  return $return;
});

$app->run();
