<?php
class BuildsController extends AppController {
  var $name = 'Builds';
  var $helpers = array('AppTime', 'Builder');

  function index($instance_id=null) {
    if (empty($instance_id)) {
      $instance_id = $this->Session->read('Instance.id');
    } else {
      $this->Session->write('Instance.id', $instance_id);
    }
    
    $this->paginate['conditions'] = array('Build.instance_id' => $instance_id);
    $this->set('builds', $this->paginate());
  }

  function view($id) {
    $this->Build->Contain(array('Test', 'Instance.Site'));
    $this->set('build', $this->Build->read(null, $id));
  }
}
?>