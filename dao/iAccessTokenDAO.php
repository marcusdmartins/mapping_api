<?php

interface iAccessTokenDAO {
    
    public function save(AccessTokenModel $access_token);
    public function listarAplicacoes();
    public function atualizaToken(PessoaModel $pessoa, AplicacaoModel $aplicacao);
    public function validaToken(AccessTokenModel $access_token);
    public function excluiToken(PessoaModel $pessoa, AplicacaoModel $aplicacao);
    
}
