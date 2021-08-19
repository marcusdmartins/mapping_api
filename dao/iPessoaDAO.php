<?php

interface iPessoaDAO
{
    	public function save(PessoaModel $pessoa);
	public function view(PessoaModel $pessoa);
	public function listAll();
	public function delete(PessoaModel $pessoa);
	public function update(PessoaModel $pessoa);
        public function buscaPorEmail(PessoaModel $pessoa);
        public function buscaInstPessoa($busca, TipoUsuarioModel $tipoUsuario);
        public function listarPorTipo(TipoUsuarioModel $tipo);
        public function pessoaUltimoResgistro();
        public function alteraSenha(PessoaModel $pessoa, $novaSenha);
        public function verificaSenhaAntiga(PessoaModel $pessoa);
        public function desbloquear(PessoaModel $pessoa);
        public function bloquear(PessoaModel $pessoa);
        public function resetar(PessoaModel $pessoa);
}