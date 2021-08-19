<?php

interface iCicloDAO
{
    	public function save(CicloModel $ciclo);
	public function view(CicloModel $ciclo);
	public function listAll();
	public function delete(CicloModel $ciclo);
	public function update(CicloModel $ciclo);
}