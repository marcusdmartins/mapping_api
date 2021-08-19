<?php

interface iTipoMidiaDAO
{
    	public function save(TipoMidiaModel $tipomidia);
	public function view(TipoMidiaModel $tipomidia);
	public function listAll();
	public function delete(TipoMidiaModel $tipomidia);
	public function update(TipoMidiaModel $tipomidia);
}