<?php

interface iPublicidadeDAO
{
    	public function save(PublicidadeModel $publicidade);
	public function view(PublicidadeModel $publicidade);
	public function listAll();
	public function delete(PublicidadeModel $publicidade);
	public function update(PublicidadeModel $publicidade);
        public function buscaUltimaPublicidade();
        public function buscaPublicidadePorLocal(LocalModel $local);
        public function buscaCiclosPublicidade(PublicidadeModel $publicidade);
        public function deletarCiclosPublicidade(PublicidadeModel $publicidade);
        public function buscaUltimoCicloPublicidade(PublicidadeModel $publicidade);
        public function buscarPublicidadesPorGrupo(GrupoModel $grupo);
        public function buscarPublicidadesPorSubgrupo(SubGrupoModel $subgrupo);
        public function buscarQtdPublicidadesPorLocal(LocalModel $local);
        public function filtroPublicidades($campanha, $midia, $status);
        public function buscaPublicidadesPorMidia(MidiaModel $midia);
        public function buscaPublicidadesPorAmbiente($ambiente);
}