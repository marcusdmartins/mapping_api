<?php

interface iSubGrupoDAO
{
    	public function save(SubGrupoModel $subgrupo);
	public function view(SubGrupoModel $subgrupo);
	public function listAll();
	public function delete(SubGrupoModel $subgrupo);
	public function update(SubGrupoModel $subgrupo);
        public function subgrupoPorGrupo(GrupoModel $grupo);
}