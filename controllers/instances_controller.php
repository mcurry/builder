<?php
class InstancesController extends AppController {

	var $name = 'Instances';
	var $helpers = array('Html', 'Form');

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Instance.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('instance', $this->Instance->read(null, $id));
	}	
	
	function add() {
		$this->data = array('Instance' => array('site_id' => $this->params['site_id']));
		$this->render('edit');
	}

	function edit($id = null) {		
		if (!empty($this->data)) {
			if ($this->Instance->save($this->data)) {
				$this->Session->setFlash(__('The Instance has been saved', true));
				$this->redirect(array('controller' => 'sites', 'action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Instance could not be saved. Please, try again.', true));
			}
		}
		
		if ($id && empty($this->data)) {
			$this->data = $this->Instance->read(null, $id);
		}
	}
	
	function build($id=null) {
		if($this->data) {
			$this->data['Instance']['pending'] = true;
			$this->Instance->save($this->data, false, array('source', 'source_username', 'source_password', 'pending'));
			$this->redirect(array('controller' => 'sites', 'action' => 'index'));
		}
		
		$this->Instance->id = $id;
		$instance = $this->Instance->read();
		
		if($instance['Instance']['continuous']) {
			$this->Instance->saveField('pending', true);
			$this->redirect(array('controller' => 'sites', 'action' => 'index'));
		}
		
		if($id) {
			$this->data = $instance;
		}
	}
  
  function confirm_delete($id) {
    $this->set('id', $id);
  }
  
  function delete($id) {
    $this->Instance->delete($id);
    $this->redirect(array('controller' => 'sites', 'action' => 'index'));
  }
}
?>