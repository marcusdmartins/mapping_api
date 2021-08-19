<?php

interface iRotinaDAO
{
    	public function save(RotinaModel $rotina);
	public function view(RotinaModel $rotina);
	public function listAll();
	public function delete(RotinaModel $rotina);
	public function update(RotinaModel $rotina);
}