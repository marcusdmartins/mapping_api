<?php

interface iMidiaDAO
{
    	public function save(MidiaModel $midia);
	public function view(MidiaModel $midia);
	public function listAll();
	public function delete(MidiaModel $midia);
	public function update(MidiaModel $midia);
        public function buscaMidiaPorTipo(TipoMidiaModel $tipomidia);
}