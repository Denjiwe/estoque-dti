<?php

class Orgao {
    private int $id;

    private string $nome;

    private bool $ativo;

    private $dataCriacao;
    
    private $dataDesativo;

    

    public function getId() : int {
        return $this-> id;
    }
    public function getNome() : string {
        return $this-> nome;
    }
    public function getAtivo() : bool {
        return $this-> ativo;
    }
    public function getDataCriacao() {
        return $this-> dataCriacao;
    }
    public function getDataDesativo() {
        return $this-> dataDesativo;
    }
    

    public function setId(int $id) {
        $this->id = $id;
    }
    public function setNome(string $nome) {
        $this->nome = $nome;
    }
    public function setAtivo(int $ativo) {
        $this->ativo = $ativo;
    }
    public function setDataCriacao($dataCriacao) {
        $this->dataCriacao = $dataCriacao;
    }
    public function setDataDesativo($dataDesativo) {
        $this->dataDesativo = $dataDesativo;
    }
    
}