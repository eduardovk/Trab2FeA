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
        $this->id_usuario = $id_usuario;
        return $this;
    }

    public function getIdIngresso(){
        return $this->id_ingresso;
    }

    public function setIdIngresso($id_ingresso){
        $this->id_ingresso = $id_ingresso;
        return $this;
    }

    public function getNome(){
        return $this->nome;
    }

    public function setNome($nome){
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
