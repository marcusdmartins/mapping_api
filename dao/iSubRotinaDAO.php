<?php

interface iSubRotinaDAO
{
    	public function save(SubRotinaModel $subRotina);
	public function view(SubRotinaModel $subRotina);
	public function listAll();
	public function delete(SubRotinaModel $subRotina);
	public function update(SubRotinaModel $subRotina);
}