<?php

namespace App\Models\Entity;

/**
* @Entity @Table(name="inscricoes")
**/
class Inscricao {

    /**
    * @var int
    * @Id @Column(type="integer")
    * @GeneratedValue
    */
    public $id;

    /**
    * @var int
    * @Column(type="integer")
    */
    public $id_usuario;

    /**
    * @var int
    * @Column(type="integer")
    */
    public $id_ingresso;

    /**
     * @var string
     * @Column(type="string")
     */
    public $nome;

    /**
    * @var bool
    * @Column(type="boolean")
    */
    public $pago;



    public function getId(){
        return $this->id;
    }

    public function getIdUsuario(){
        return $this->id_usuario;
    }

    public function setIdUsuario($id_usuario){
        if (!$id_usuario) {
            throw new \InvalidArgumentException("É necessário informar a ID do usuário da inscrição!", 400);
        }
        $this->id_usuario = $id_usuario;
        return $this;
    }

    public function getIdIngresso(){
        return $this->id_ingresso;
    }

    public function setIdIngresso($id_ingresso){
        if (!$id_ingresso) {
            throw new \InvalidArgumentException("É necessário informar a ID do ingresso da inscrição!", 400);
        }
        $this->id_ingresso = $id_ingresso;
        return $this;
    }

    public function getNome(){
        return $this->nome;
    }

    public function setNome($nome){
        if (!$nome && !is_string($nome)) {
            throw new \InvalidArgumentException("É necessário informar o nome na inscrição!", 400);
        }
        $this->nome = $nome;
        return $this;
    }

    public function getPago(){
        return $this->pago;
    }

    public function setPago($pago){
        $this->pago = $pago;
        return $this;
    }



}
