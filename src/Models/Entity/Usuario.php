<?php

namespace App\Models\Entity;

/**
* @Entity @Table(name="usuarios")
**/
class Usuario {

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
    public $nome;

    /**
     * @var string
     * @Column(type="string")
     */
    public $email;

    /**
     * @var string
     * @Column(type="string", length=14, nullable=true)
     */
    public $cpf;

    /**
     * @var string
     * @Column(type="string")
     */
    public $senha;

    /**
    * @var bool
    * @Column(type="boolean")
    */
    public $admin;


    public function getId(){
        return $this->id;
    }

    public function getNome(){
        return $this->nome;
    }

    public function setNome($nome){
        if (!$nome && !is_string($nome)) {
            throw new \InvalidArgumentException("É necessário informar o nome do usuário!", 400);
        }
        $this->nome = $nome;
        return $this;
    }

    public function getEmail(){
        return $this->email;
    }

    public function setEmail($email){
        if (!$email && !is_string($email)) {
            throw new \InvalidArgumentException("É necessário informar o e-mail do usuário!", 400);
        }
        $this->email = $email;
        return $this;
    }

    public function getCpf(){
        return $this->cpf;
    }

    public function setCpf($cpf){
        $this->cpf = $cpf;
        return $this;
    }

    public function getSenha(){
        return $this->senha;
    }

    public function setSenha($senha){
        if (!$senha && !is_string($senha)) {
            throw new \InvalidArgumentException("É necessário informar a senha do usuário!", 400);
        }
        $this->senha = $senha;
        return $this;
    }

    public function getAdmin(){
        return $this->admin;
    }

    public function setAdmin($Admin){
        $this->admin = $admin;
        return $this;
    }

}
