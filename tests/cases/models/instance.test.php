<?php 
/* SVN FILE: $Id$ */
/* Instance Test cases generated on: 2009-07-23 01:07:13 : 1248328513*/
App::import('Model', 'Instance');

class InstanceTestCase extends CakeTestCase {
	var $Instance = null;
	var $fixtures = array('app.instance', 'app.site', 'app.build');

	function startTest() {
		$this->Instance =& ClassRegistry::init('Instance');
	}

	function testInstanceInstance() {
		$this->assertTrue(is_a($this->Instance, 'Instance'));
	}

	function testInstanceFind() {
		$this->Instance->recursive = -1;
		$results = $this->Instance->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Instance' => array(
			'id'  => 1,
			'site_id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'continuous'  => 1,
			'created'  => '2009-07-23 01:55:13',
			'modified'  => '2009-07-23 01:55:13'
		));
		$this->assertEqual($results, $expected);
	}
}
?>