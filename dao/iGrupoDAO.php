<?php

interface iGrupoDAO
{
    	public function save(GrupoModel $grupo);
	public function view(GrupoModel $grupo);
	public function listAll();
	public function delete(GrupoModel $grupo);
	public function update(GrupoModel $grupo);
}