<?php
namespace App\v1\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use App\Models\Entity\Usuario;

class UsuarioController {

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

    public function getUserID($fb_ID, $entityManager){
        $usuariosRepository = $entityManager->getRepository('App\Models\Entity\Usuario');
        $usuarios = $usuariosRepository->findBy(array('fb_ID' => $fb_ID));
        if($usuarios){
            foreach($usuarios as $usuario){
                return $usuario->id;
            }
        }
        return null;
    }

    public function criarUsuario($usuario, $entityManager, $logger){

        $usuario = (new Usuario())->setFbID($usuario['fb_ID'])
        ->setNome($usuario['nome'])
        ->setEmail($usuario['email'])
        ->setAdmin(0);

        $entityManager->persist($usuario);
        $entityManager->flush();

        $logger->info('Usuario criado!', array($usuario));

        return $usuario->getId();
    }


}
