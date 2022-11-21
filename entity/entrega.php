<?php

class Entrega 
    {
        private int $id;

        private int $qntde;

        private $dataEntrega;

        private string $observação;

        private int $usuarioId;

        private int $itensId;

        public function getId() : int {
            return $this->id;
        }
        public function getQntde() : int {
            return $this->qntde;
        }
        public function getDataEntrega() {
            return $this->dataEntrega;
        }
        public function geObservacao() : string {
            return $this->observacao;
        }
        public function getUsuarioId() : int {
            return $this->usuarioId;
        }
        public function getItensId() : int {
            return $this->itensId;
        }

        public function setId(int $id) {
            $this->id = $id;
        }
        public function setQtnde(int $qntde) {
            $this->qntde = $qntde;
        }
        public function setDataEntrega($dataEntrega) {
            $this->dataEntrega = $dataEntrega;
        }
        public function setObservacao(string $observacao) {
            $this->observacao = $observacao;
        }
        public function setUsuarioId(int $usuarioId) {
            $this->usuarioId = $usuarioId;
        }
        public function setItensId(int $itensId) {
            $this->itensId = $itensId;
        }
    }