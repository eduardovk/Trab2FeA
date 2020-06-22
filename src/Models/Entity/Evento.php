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
    protected $id;

    /**
     * @var string
     * @Column(type="string")
     */
    protected $titulo;

    /**
     * @var string
     * @Column(type="string")
     */
    protected $descricao;

    /**
     * @var datetime
     * @Column(type="datetime")
     */
    protected $data_hora;

    /**
     * @var string
     * @Column(type="string")
     */
    protected $local;

    /**
     * @var string
     * @Column(type="string")
     */
    protected $imagem;

    /**
     * @var string
     * @Column(type="string")
     */
    protected $url_amiga;

    /**
    * @var int
    * @Column(type="integer")
    */
    protected $id_usuario;

    /**
    * @var bool
    * @Column(type="boolean")
    */
    protected $ativo;


    public function getId(){
        return $this->id;
    }

    public function getTitulo(){
        return $this->titulo;
    }

    public function setTitulo($titulo){
        $this->titulo = $titulo;
        return $this;
    }

    public function getDescricao(){
        return $this->descricao;
    }

    public function setDescricao($descricao){
        $this->descricao = $descricao;
        return $this;
    }

    public function getDataHora(){
        return $this->data_hora;
    }

    public function setDataHora($data_hora){
        $this->data_hora = $data_hora;
        return $this;
    }

    public function getLocal(){
        return $this->local;
    }

    public function setLocal($local){
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
        $this->url_amiga = $url_amiga;
        return $this;
    }

    public function getIdUsuario(){
        return $this->$id_usuario;
    }

    public function setIdUsuario($id_usuario){
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
