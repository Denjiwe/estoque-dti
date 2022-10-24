<?php

class Produto {
    private string $id;

    private string $modelo;

    private string $descricao;
    
    private int $qntde;

    private bool $ativo;

    public function getId() : int {
        return $this-> id;
    }
    public function getModelo() : string {
        return $this-> modelo;
    }
    public function getDescricao() : string {
        return $this-> descricao;
    }
    public function getQntde() : int {
        return $this-> qntde;
    }
    public function getAtivo() : bool {
        return $this-> ativo;
    }

    public function setId(int $id) {
        $this->id = $id;
    }
    public function setModelo(string $modelo) {
        $this->modelo = $modelo;
    }
    public function setDescricao(string $descricao) {
        $this->descricao = $descricao;
    }
    public function setQntde(int $qntde) {
        $this->qntde = $qntde;
    }
    public function setAtivo(int $ativo) {
        $this->ativo = $ativo;
    }
}