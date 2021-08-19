<?php

class AccessTokenModel {

	private $id;
	private $pessoa;
        private $token;
        private $data;
        private $aplicacao;
        
        function getId() {
            return $this->id;
        }

        function getPessoa() {
            return $this->pessoa;
        }

        function getToken() {
            return $this->token;
        }

        function getData() {
            return $this->data;
        }

        function getAplicacao() {
            return $this->aplicacao;
        }

        function setId($id) {
            $this->id = $id;
        }

        function setPessoa(PessoaModel $pessoa) {
            $this->pessoa = $pessoa;
        }

        function setToken($token) {
            $this->token = $token;
        }

        function setData($data) {
            $this->data = $data;
        }

        function setAplicacao(AplicacaoModel $aplicacao) {
            $this->aplicacao = $aplicacao;
        }

}
