<?php

interface iAcessoDAO {
        public function logar(PessoaModel $pessoa, AplicacaoModel $aplicacao);
        public function listarPermissoes(TipoUsuarioModel $tipoUsuario);
        public function getSubRotinas(TipoUsuarioModel $tipoUsuario, RotinaModel $rotina);
        public function listarRotinas();
        public function getTodasSubRotinas(RotinaModel $rotina);
        public function verificaPermissao(TipoUsuarioModel $tipoUsuario, SubRotinaModel $subRotina);
        public function updatePermissao(TipoUsuarioModel $tipoUsuario, RotinaModel $rotina, SubRotinaModel $subRotina);
        public function inserePermissao(TipoUsuarioModel $tipoUsuario, RotinaModel $rotina, SubRotinaModel $subRotina);
        public function retiraPermissao(TipoUsuarioModel $tipoUsuario, SubRotinaModel $subRotina);
}
