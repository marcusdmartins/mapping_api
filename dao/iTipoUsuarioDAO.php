<?php

interface iTipoUsuarioDAO
{
    	public function save(TipoUsuarioModel $tipoAvaliacao);
	public function view(TipoUsuarioModel $tipoAvaliacao);
	public function listAll();
	public function delete(TipoUsuarioModel $tipoAvaliacao);
	public function update(TipoUsuarioModel $tipoAvaliacao);
}