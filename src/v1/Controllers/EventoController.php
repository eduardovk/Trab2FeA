<?php
namespace App\v1\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use App\Models\Entity\Evento;

class EventoController {

    /**
     * Container Class
     * @var [object]
     */
    private $container;

    /**
     * Undocumented function
     * @param [object] $container
     */
    public function __construct($container) {
        $this->container = $container;
    }

    /**
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return Response
     */
    public function listarEventos($request, $response, $args) {
        $entityManager = $this->container->get('em');
        $eventosRepository = $entityManager->getRepository('App\Models\Entity\Evento');
        $eventos = $eventosRepository->findAll();

        $return = $response->withJson($eventos, 200)
            ->withHeader('Content-type', 'application/json');
        return $return;
    }

    /**
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return Response
     */
    public function criarEvento($request, $response, $args) {
        $params = (object) $request->getParams();

        $entityManager = $this->container->get('em');

        $evento = (new Evento())->setTitulo($request->getParam('titulo'))
        ->setDescricao($request->getParam('descricao'))
        ->setDataHora(new \DateTime($request->getParam('data_hora')))
        ->setLocal($request->getParam('local'))
        ->setImagem($request->getParam('imagem'))
        ->setUrlAmiga($request->getParam('url_amiga'))
        ->setIdUsuario($request->getParam('id_usuario'))
        ->setAtivo($request->getParam('ativo'));

        $entityManager->persist($evento);
        $entityManager->flush();

        $logger = $this->container->get('logger');
        $logger->info('Evento cadastrado!', array($evento));

        $return = $response->withJson($evento, 201)
            ->withHeader('Content-type', 'application/json');
        return $return;
    }

    /**
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return Response
     */
    public function verEvento($request, $response, $args) {

        $id = (int) $args['id'];

        $entityManager = $this->container->get('em');
        $eventosRepository = $entityManager->getRepository('App\Models\Entity\Evento');
        $evento = $eventosRepository->find($id);

        if(!$evento){
            $logger = $this->container->get('logger');
            $logger->warning("Evento {$id} não encontrado!");
            throw new \Exception("Evento não encontrado", 404);
        }

        $return = $response->withJson($evento, 200)
            ->withHeader('Content-type', 'application/json');
        return $return;
    }

    /**
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return Response
     */
    public function atualizarEvento($request, $response, $args) {
        $id = (int) $args['id'];

        $entityManager = $this->container->get('em');
        $eventosRepository = $entityManager->getRepository('App\Models\Entity\Evento');
        $evento = $eventosRepository->find($id);

        $logger = $this->container->get('logger');

        if(!$evento){
            $logger->warning("Evento {$id} não encontrado - Não foi possível atualizar!");
            throw new \Exception("Evento não encontrado", 404);
        }

        $evento->setTitulo($request->getParam('titulo'))
        ->setDescricao($request->getParam('descricao'))
        ->setDataHora(new \DateTime($request->getParam('data_hora')))
        ->setLocal($request->getParam('local'))
        ->setImagem($request->getParam('imagem'))
        ->setUrlAmiga($request->getParam('url_amiga'))
        ->setIdUsuario($request->getParam('id_usuario'))
        ->setAtivo($request->getParam('ativo'));

        $entityManager->persist($evento);
        $entityManager->flush();

        $logger->info("Evento {$id} atualizado!", array($evento));

        $return = $response->withJson($evento, 200)
            ->withHeader('Content-type', 'application/json');
        return $return;
    }

    /**
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return Response
     */
    public function deletarEvento($request, $response, $args) {
        $id = (int) $args['id'];

        $entityManager = $this->container->get('em');
        $eventosRepository = $entityManager->getRepository('App\Models\Entity\Evento');
        $evento = $eventosRepository->find($id);

        $logger = $this->container->get('logger');

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
    }

}