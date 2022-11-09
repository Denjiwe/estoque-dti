<?php

class Produto 
    {
        private int $id;

        private string $modelo;

        private string $descricao;
        
        private int $qntde;

        private bool $ativo;

        private array $itens;

        public function getId() : int {
            return $this-> id;
        }
        public function getModelo() : string {
            return $this-> modelo;
        }
        public function getDescricao() : ?string {
            return $this-> descricao;
        }
        public function getQntde() : int {
            return $this-> qntde;
        }
        public function getAtivo() : bool {
            return $this-> ativo;
        }
        public function getItens() : array {
            return $this-> itens;
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
        public function setItens(array $itens) {
            $this->itens = $itens;
        }
    }