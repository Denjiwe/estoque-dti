<?php 

class Solicitacao 
    {
        private int $id;
        
        private int $cpf;

        private string $nome;

        private string $email;

        private string $senha;

        private bool $ativo;

        private int $divisao;

        private int $diretoria;

        public function getId() : int {
            return $this-> id;
        }
        public function getCpf() : int {
            return $this-> cpf;
        }
        public function getNome() : string {
            return $this-> nome;
        }
        public function getEmail() : string {
            return $this-> email;
        }
        public function getSenha() : string {
            return $this-> senha;
        }
        public function getAtivo() : bool {
            return $this-> ativo;
        }
        public function getDivisao() : int {
            return $this-> divisao;
        }
        public function getDiretoria() : int {
            return $this-> diretoria;
        }

        public function setId(int $id) {
            $this->id = $id;
        }
        public function setCpf(int $cpf) {
            $this->cpf = $cpf;
        }
        public function setNome(string $nome) {
            $this->nome = $nome;
        }
        public function setEmail(string $email) {
            $this->email = $email;
        }
        public function setSenha(string $senha) {
            $this->senha = $senha;
        }
        public function setAtivo(bool $ativo) {
            $this->ativo = $ativo;
        }
        public function setDivisao(int $divisao) {
            $this->divisao = $divisao;
        }
        public function setDiretoria(int $diretoria) {
            $this->diretoria = $diretoria;
        }
    }

?>