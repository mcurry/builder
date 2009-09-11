<?php
class SitesController extends AppController {

	var $name = 'Sites';
	var $helpers = array('Html', 'Form', 'Builder');

	function index() {
		$sites = $this->Site->find('index');
		$this->set(compact('sites'));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Site.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('site', $this->Site->read(null, $id));
	}
	
	function edit($id = null) {		
		if (!empty($this->data)) {
			if ($this->Site->save($this->data)) {
				$this->Session->setFlash(__('The Site has been saved', true));
				$this->redirect(array('controller' => 'sites', 'action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Site could not be saved. Please, try again.', true));
			}
		}
		
		if (!$id && empty($this->data)) {
			$this->data = $this->Site->read(null, $id);
		}
	}
  
  function delete($id) {
    $this->Site->delete($id);
    $this->redirect(array('controller' => 'sites', 'action' => 'index'));
  }
}
?>