<?php
class TestsController extends AppController {

	var $name = 'Tests';

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Test.', true));
			$this->redirect($this->referer());
		}
    
    $this->Test->contain('Build');
		$this->set('test', $this->Test->read(null, $id));
	}
}
?>