<?php
namespace App\v1\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use \App\v1\Controllers\UsuarioController as UsuarioController;
use App\Models\Entity\Inscricao;
use App\Models\Entity\Evento;

use Doctrine\ORM\Query\ResultSetMapping;

class InscricaoController {

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
    public function inscricoesPorUsuario($request, $response, $args) {
        $fb_ID = (int) $args['id'];
        $entityManager = $this->container->get('em');

        $usuarioController = new UsuarioController($this->container);
        $id = $usuarioController->getUserID($fb_ID, $entityManager);

        //$inscricoesRepository = $entityManager->getRepository('App\Models\Entity\Inscricao');
        //$inscricoes = $inscricoesRepository->findBy(array('id_usuario' => $id));

        $RAW_QUERY = 'SELECT i.*, ci.titulo AS titulo_ingresso, ci.valor, e.titulo AS titulo_evento
        FROM inscricoes AS i INNER JOIN categorias_ingressos AS ci ON (ci.id = i.id_ingresso)
        INNER JOIN eventos AS e ON (ci.id_evento = e.id) WHERE i.id_usuario = :id';
        $statement = $entityManager->getConnection()->prepare($RAW_QUERY);
        $statement->bindValue('id', $id);
        $statement->execute();

        $inscricoes = $statement->fetchAll();


        $return = $response->withJson($inscricoes, 200)
        ->withHeader('Content-type', 'application/json');
        return $return;
    }

    /**
    * @param [type] $request
    * @param [type] $response
    * @param [type] $args
    * @return Response
    */
    public function criarInscricao($request, $response, $args) {
        $params = (object) $request->getParams();

        $entityManager = $this->container->get('em');

        $parametros = array(
            'fb_ID' => $request->getParam('fb_ID'),
            'nome' => $request->getParam('nome'),
            'email' => $email = $request->getParam('email')
        );

        $id_usuario = UsuarioController::getUserID($request->getParam('fb_ID'), $entityManager);
        if(!$id_usuario){
            $id_usuario = UsuarioController::criarUsuario($parametros, $entityManager, $this->container->get('logger'));
        }

        $inscricao = (new Inscricao())->setIdUsuario($id_usuario)
        ->setIdIngresso($request->getParam('id_ingresso'))
        ->setNome($request->getParam('nome'))
        ->setPago($request->getParam('pago'));

        $entityManager->persist($inscricao);
        $entityManager->flush();

        $logger = $this->container->get('logger');
        $logger->info('Inscricao criada!', array($inscricao));

        $return = $response->withJson($inscricao, 201)
        ->withHeader('Content-type', 'application/json');
        return $return;
    }


}
