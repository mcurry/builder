<?php 
/* SVN FILE: $Id$ */
/* Build Test cases generated on: 2009-07-23 01:07:56 : 1248328496*/
App::import('Model', 'Build');

class BuildTestCase extends CakeTestCase {
	var $Build = null;
	var $fixtures = array('app.build', 'app.instance');

	function startTest() {
		$this->Build =& ClassRegistry::init('Build');
	}

	function testBuildInstance() {
		$this->assertTrue(is_a($this->Build, 'Build'));
	}

	function testBuildFind() {
		$this->Build->recursive = -1;
		$results = $this->Build->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Build' => array(
			'id'  => 1,
			'instance_id'  => 1,
			'start'  => '2009-07-23 01:54:56',
			'end'  => '2009-07-23 01:54:56',
			'status'  => 'Lorem ip',
			'version'  => 'Lorem ipsum dolor sit amet'
		));
		$this->assertEqual($results, $expected);
	}
}
?>