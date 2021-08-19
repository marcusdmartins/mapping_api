<?php
include_once('./controller/IndexController.php');
class Index extends IndexController{

  public function index(){
     $this->view('index');
  }
}
