<?php 

class Solicitacao 
    {
        private int $id;
        
        private string $estadoSolicitacao;

        private string $descricao;

        private $dataSolicitacao;

        private int $usuarioId;

        private array $itemSolicitacao;

        private int $qntdeItem;

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
        public function getItemSolicitacao() : array {
            return $this-> itemSolicitacao;
        }
        public function getQntdeItem() : int {
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
        public function setItemSolicitacao(array $itemSolicitacao) {
            $this->itemSolicitacao = $itemSolicitacao;
        }
        public function setQntdeItem(int $qntdeItem) {
            $this->qntdeItem = $qntdeItem;
        }
    }

?>