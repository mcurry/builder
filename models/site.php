<?php
class Site extends AppModel {

	var $name = 'Site';

	var $hasMany = array('Instance');
	
	var $order = array('Site.name' => 'ASC');

	function __findIndex() {
		$this->contain(array('Instance' => array('Build' => array('limit' => 1, 'order' => 'start DESC'))));
		return $this->find('all');
	}
}
?>