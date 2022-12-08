<?php

class Diretoria {
    private int $id;

    private string $nome;

    private bool $ativo;

    private $dataCriacao;
    
    private $dataDesativo;

    private int $orgaoId;

    private string $orgaoNome;

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
    public function getOrgaoId() : int {
        return $this-> orgaoId;
    }
    public function getOrgaoNome() : string {
        return $this-> orgaoNome;
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
    public function setOrgaoId(int $orgaoId) {
        $this->orgaoId = $orgaoId;
    }
    public function setOrgaoNome(string $orgaoNome) {
        $this->orgaoNome = $orgaoNome;
    }
}