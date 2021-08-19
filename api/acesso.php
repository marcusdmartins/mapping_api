<?php

include_once ('./controller/AcessoController.php');

class Acesso extends AcessoController {

	public function index() {
            $this -> view('index');
	}

	//@Post("mapping/acesso/pegar")
	public function pegar($json) {
            $controller = new AcessoController();
            $controller -> getAcessoSistema($json);
	}
        
        //@Post("mapping/acesso/logar")
        public function logar($json) {
            $controller = new AcessoController();
            $controller->logar($json);
        }  
        
        //@Post("mapping/acesso/listarPermissoes")
        public function listarPermissoes($json) {
            $controller = new AcessoController();
            $controller->listarPermissoes($json);
        }          
        
        //@Post("mapping/acesso/listarRotinas")
        public function listarRotinas() {
            $controller = new AcessoController();
            $controller->listarRotinas();
        }

        //@Post("mapping/acesso/verificaPermissao")
        public function verificaPermissao($json) {
            $controller = new AcessoController();
            $controller->verificaPermissao($json);
        }    
        
        //@Post("mapping/acesso/updatePermissao")
        public function updatePermissao($json) {
            $controller = new AcessoController();
            $controller->updatePermissao($json);
        }           
        
}