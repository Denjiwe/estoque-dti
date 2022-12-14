<?php 

class Usuario 
    {
        private int $id;
        
        private int $cpf;

        private string $nome;

        private string $email;

        private string $senha;

        private bool $ativo;

        private bool $usuarioDti;

        private int $divisaoId;

        private string $divisaoNome;

        private int $diretoriaId;
        
        private string $diretoriaNome;

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
        public function getUsuarioDti() : bool {
            return $this-> usuarioDti;
        }
        public function getDivisaoId() : ?int {
            return $this-> divisaoId;
        }
        public function getDivisaoNome() : ?string {
            return $this-> divisaoNome;
        }
        public function getDiretoriaId() : ?int {
            return $this-> diretoriaId;
        }
        public function getDiretoriaNome() : ?string {
            return $this-> diretoriaNome;
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
        public function setUsuarioDti(bool $usuarioDti) {
            $this->usuarioDti = $usuarioDti;
        }
        public function setDivisaoId(int $divisaoId) {
            $this->divisaoId = $divisaoId;
        }
        public function setDivisaoNome(string $divisaoNome) {
            $this->divisaoNome = $divisaoNome;
        }
        public function setDiretoriaId(int $diretoriaId) {
            $this->diretoriaId = $diretoriaId;
        }
        public function setDiretoriaNome(string $diretoriaNome) {
            $this->diretoriaNome = $diretoriaNome;
        }
    }

?>