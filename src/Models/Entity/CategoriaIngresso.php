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
        if (!$id_evento) {
            throw new \InvalidArgumentException("É necessário informar a ID do evento no ingresso!", 400);
        }
        $this->id_evento = $id_evento;
        return $this;
    }

    public function getTitulo(){

        return $this->titulo;
    }

    public function setTitulo($titulo){
        if (!$titulo && !is_string($titulo)) {
            throw new \InvalidArgumentException("É necessário informar o título do ingresso!", 400);
        }
        $this->titulo = $titulo;
        return $this;
    }

    public function getValor(){
        return $this->valor;
    }

    public function setValor($valor){
        if (!$valor) {
            throw new \InvalidArgumentException("É necessário informar o valor do ingresso!", 400);
        }
        $this->valor = $valor;
        return $this;
    }

    public function getQtd(){
        return $this->qtd;
    }

    public function setQtd($qtd){
        if (!$valor) {
            throw new \InvalidArgumentException("É necessário informar a quantidade do ingresso!", 400);
        }
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
