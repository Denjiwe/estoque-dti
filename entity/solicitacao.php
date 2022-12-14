<?php 

class Solicitacao 
    {
        private int $id;
        
        private string $estadoSolicitacao;

        private string $descricao;

        private $dataSolicitacao;

        private int $usuarioId;

        private string $usuarioNome;

        private int $usuarioDivisao;

        private int $usuarioDiretoria;

        private array $itemSolicitacao;

        private array $qntdeItem;

        public function getId() : int {
            return $this-> id;
        }
        public function getEstadoSolicitacao() : string {
            return $this-> estadoSolicitacao;
        }
        public function getDescricao() : ?string {
            return $this-> descricao;
        }
        public function getDataSolicitacao() {
            return $this-> dataSolicitacao;
        }
        public function getUsuarioId() : int {
            return $this-> usuarioId;
        }
        public function getUsuarioNome() : string {
            return $this-> usuarioNome;
        }
        public function getUsuarioDivisao() : string {
            return $this-> usuarioDivisao;
        }
        public function getUsuarioDiretoria() : string {
            return $this-> usuarioDiretoria;
        }
        public function getItemSolicitacao() : array {
            return $this-> itemSolicitacao;
        }
        public function getQntdeItem() : array {
            return $this-> qntdeItem;
        }
        

        public function setId(int $id) {
            $this->id = $id;
        }
        public function setEstadoSolicitacao(string $estadoSolicitacao) {
            $this->estadoSolicitacao = $estadoSolicitacao;
        }
        public function setDescricao(string $descricao) {
            $this->descricao = $descricao;
        }
        public function setDataSolicitacao($dataSolicitacao) {
            $this->dataSolicitacao = $dataSolicitacao;
        }
        public function setUsuarioId(int $usuarioId) {
            $this->usuarioId = $usuarioId;
        }
        public function setUsuarioNome(string $usuarioNome) {
            $this->usuarioNome = $usuarioNome;
        }
        public function setUsuarioDivisao(string $usuarioDivisao) {
            $this->usuarioDivisao = $usuarioDivisao;
        }
        public function setUsuarioDiretoria(string $usuarioDiretoria) {
            $this->usuarioDiretoria = $usuarioDiretoria;
        }
        public function setItemSolicitacao(array $itemSolicitacao) {
            $this->itemSolicitacao = $itemSolicitacao;
        }
        public function setQntdeItem(array $qntdeItem) {
            $this->qntdeItem = $qntdeItem;
        }
    }

?>