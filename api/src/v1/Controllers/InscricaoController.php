<?php
namespace App\v1\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use \App\FuncoesGerais as FuncoesGerais;
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
        $fb_Token = $args['token'];
        $entityManager = $this->container->get('em');

        // Verifica se ID e Token da conta Facebook sao validos
        if(!FuncoesGerais::validarFBToken($fb_ID, $fb_Token)){
            $return = $response->withJson('Nao foi possivel verificar a autenticidade da conta Facebook.', 401)
            ->withHeader('Content-type', 'application/json');
            return $return;
        }

        // Busca o ID do usuario no bd atraves do ID da conta Facebook
        $usuarioController = new UsuarioController($this->container);
        $id = $usuarioController->getUserID($fb_ID, $entityManager);

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

        $fb_ID = $request->getParam('fb_ID');
        $fb_Token = $request->getParam('fb_Token');

        // Verifica se ID e Token da conta Facebook sao validos
        if(!FuncoesGerais::validarFBToken($fb_ID, $fb_Token)){
            $return = $response->withJson('Nao foi possivel verificar a autenticidade da conta Facebook.', 401)
            ->withHeader('Content-type', 'application/json');
            return $return;
        }

        $parametros = array(
            'fb_ID' => $fb_ID,
            'nome' => $request->getParam('nome'),
            'email' => $email = $request->getParam('email')
        );

        // Se usuario nao for encontrado no bd, faz novo insert
        $id_usuario = UsuarioController::getUserID($request->getParam('fb_ID'), $entityManager);
        if(!$id_usuario){
            $id_usuario = UsuarioController::criarUsuario($parametros, $entityManager, $this->container->get('logger'));
        }

        $pago = 0;

        $inscricao = (new Inscricao())->setIdUsuario($id_usuario)
        ->setIdIngresso($request->getParam('id_ingresso'))
        ->setNome($request->getParam('nome'))
        ->setPago($pago);

        $entityManager->persist($inscricao);
        $entityManager->flush();

        $logger = $this->container->get('logger');
        $logger->info('Inscricao criada!', array($inscricao));

        $return = $response->withJson($inscricao, 201)
        ->withHeader('Content-type', 'application/json');
        return $return;
    }

    public function atualizarInscricao($request, $response, $args) {
        $id = (int) $args['id'];

        $fb_ID = $request->getParam('fb_ID');
        $fb_Token = $request->getParam('fb_Token');

        // Verifica se ID e Token da conta Facebook sao validos
        if(!FuncoesGerais::validarFBToken($fb_ID, $fb_Token)){
            $return = $response->withJson('Nao foi possivel verificar a autenticidade da conta Facebook.', 401)
            ->withHeader('Content-type', 'application/json');
            return $return;
        }

        $entityManager = $this->container->get('em');
        $inscricoesRepo = $entityManager->getRepository('App\Models\Entity\Inscricao');
        $inscricao = $inscricoesRepo->find($id);

        $logger = $this->container->get('logger');

        if(!$inscricao){
            $logger->warning("Inscricao {$id} nao encontrada - Nao foi possivel atualizar!");
            throw new \Exception("Inscricao nao encontrada", 404);
        }

        $inscricao->setIdUsuario($request->getParam('id_usuario'))
        ->setIdIngresso($request->getParam('id_ingresso'))
        ->setNome($request->getParam('nome'))
        ->setPago($request->getParam('pago'));

        $entityManager->persist($inscricao);
        $entityManager->flush();

        $logger->info("Inscricao {$id} atualizada!", array($inscricao));

        $return = $response->withJson($inscricao, 200)
        ->withHeader('Content-type', 'application/json');
        return $return;
    }

    public function excluirInscricao($request, $response, $args){
        $id = (int) $args['id'];

        $fb_ID = $args['fb_id'];
        $fb_Token = $args['token'];

        // Verifica se ID e Token da conta Facebook sao validos
        if(!FuncoesGerais::validarFBToken($fb_ID, $fb_Token)){
            $return = $response->withJson('Nao foi possivel verificar a autenticidade da conta Facebook.', 401)
            ->withHeader('Content-type', 'application/json');
            return $return;
        }

        $entityManager = $this->container->get('em');
        $inscricoesRepo = $entityManager->getRepository('App\Models\Entity\Inscricao');
        $inscricao = $inscricoesRepo->find($id);

        $logger = $this->container->get('logger');

        if(!$inscricao){
            $logger->warning("Inscricao {$id} nao encontrada - Nao foi possivel deletar!");
            throw new \Exception("Inscricao nao encontrada", 404);
        }

        $entityManager->remove($inscricao);
        $entityManager->flush();

        $logger->info("Inscricao {$id} deletada!", array($inscricao));

        $return = $response->withJson(['msg' => "Deletada a inscricao {$id}"], 204)
        ->withHeader('Content-type', 'application/json');
        return $return;
    }


}
