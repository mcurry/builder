<?php
class UsersController extends AppController {
	var $name = 'Users';
  
	function beforeFilter() {
		parent::beforeFilter();

		$this->Auth->allow(array('install', 'logout'));
	}
  
  function login() {
    
  }
  
  function logout() {
    $this->Auth->logout();
    $this->redirect($this->Auth->redirect());
  }
  
  function install() {
    //if any user already exists...
    if($this->User->find('count') > 0) {
      $this->render('already_installed');
    }
    
    if($this->data) {
      if($this->User->save($this->data)) {
        $this->Auth->login($this->data);
        $this->Session->setFlash(__('User created', true));
        $this->redirect('/');
      }
    }
  }
}