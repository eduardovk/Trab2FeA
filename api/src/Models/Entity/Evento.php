<?php

namespace App\Models\Entity;

/**
* @Entity @Table(name="eventos")
**/
class Evento {

    /**
    * @var int
    * @Id @Column(type="integer")
    * @GeneratedValue
    */
    public $id;

    /**
     * @var string
     * @Column(type="string")
     */
    public $titulo;

    /**
     * @var string
     * @Column(type="string")
     */
    public $descricao;

    /**
     * @var DateTime
     * @Column(type="datetime")
     */
    public $data_hora;

    /**
     * @var string
     * @Column(type="string")
     */
    public $local;

    /**
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $imagem;

    /**
     * @var string
     * @Column(type="string")
     */
    public $url_amiga;

    /**
    * @var int
    * @Column(type="integer")
    */
    public $id_usuario;

    /**
    * @var bool
    * @Column(type="boolean")
    */
    public $ativo;


    public function getId(){
        return $this->id;
    }

    public function getTitulo(){
        return $this->titulo;
    }

    public function setTitulo($titulo){
        if (!$titulo && !is_string($titulo)) {
            throw new \InvalidArgumentException("É necessário informar o título do evento!", 400);
        }
        $this->titulo = $titulo;
        return $this;
    }

    public function getDescricao(){
        return $this->descricao;
    }

    public function setDescricao($descricao){
        if (!$descricao && !is_string($descricao)) {
            throw new \InvalidArgumentException("É necessário preencher a descrição do evento!", 400);
        }
        $this->descricao = $descricao;
        return $this;
    }

    public function getDataHora(){
        return $this->data_hora;
    }

    public function setDataHora($data_hora){
        if ($data_hora == null) {
            throw new \InvalidArgumentException("É necessário informar a data e hora do evento!", 400);
        }
        $this->data_hora = $data_hora;
        return $this;
    }

    public function getLocal(){
        return $this->local;
    }

    public function setLocal($local){
        if (!$local && !is_string($local)) {
            throw new \InvalidArgumentException("É necessário informar o local do evento!", 400);
        }
        $this->local = $local;
        return $this;
    }

    public function getImagem(){
        return $this->imagem;
    }

    public function setImagem($imagem){
        $this->imagem = $imagem;
        return $this;
    }

    public function getUrlAmiga(){
        return $this->url_amiga;
    }

    public function setUrlAmiga($url_amiga){
        if (!$url_amiga && !is_string($url_amiga)) {
            throw new \InvalidArgumentException("É necessário informar a URL-amiga do evento!", 400);
        }
        $this->url_amiga = $url_amiga;
        return $this;
    }

    public function getIdUsuario(){
        return $this->$id_usuario;
    }

    public function setIdUsuario($id_usuario){
        if (!$id_usuario) {
            throw new \InvalidArgumentException("É necessário informar a ID do usuário criador do evento!", 400);
        }
        $this->id_usuario = $id_usuario;
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
