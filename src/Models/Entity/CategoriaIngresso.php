<?php

namespace App\Models\Entity;

/**
* @Entity @Table(name="categorias_ingressos")
**/
class CategoriaIngresso {

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
    public $id_evento;

    /**
    * @var string
    * @Column(type="string")
    */
    public $titulo;

    /**
    * @Column(type="decimal", precision=10, scale=2)
    */
    public $valor;

    /**
    * @var int
    * @Column(type="integer")
    */
    public $qtd;

    /**
    * @var bool
    * @Column(type="boolean")
    */
    public $ativo;


    public function getId(){
        return $this->id;
    }

    public function getIdEvento(){
        return $this->id_evento;
    }

    public function setIdEvento($id_evento){
        $this->id_evento = $id_evento;
        return $this;
    }

    public function getTitulo(){
        return $this->titulo;
    }

    public function setTitulo($titulo){
        $this->titulo = $titulo;
        return $this;
    }

    public function getValor(){
        return $this->valor;
    }

    public function setValor($valor){
        $this->valor = $valor;
        return $this;
    }

    public function getQtd(){
        return $this->qtd;
    }

    public function setQtd($qtd){
        $this->qtd = $qtd;
        return $this;
    }

    public function getAtivo(){
        return $this->ativo;
    }

    public function setAtivo($ativo){
        $this->ativo = $ativo;
        return $this;
    }

}
