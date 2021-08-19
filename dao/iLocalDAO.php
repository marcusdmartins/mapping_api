<?php

interface iLocalDAO
{
    	public function save(LocalModel $local);
	public function view(LocalModel $local);
	public function listAll();
	public function delete(LocalModel $local);
	public function update(LocalModel $local);
        public function localPorSubgrupo(SubGrupoModel $subgrupo);
        public function buscaUltimoLocal();
}