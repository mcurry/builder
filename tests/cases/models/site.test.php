<?php 
/* SVN FILE: $Id$ */
/* Site Test cases generated on: 2009-07-23 01:07:28 : 1248328528*/
App::import('Model', 'Site');

class SiteTestCase extends CakeTestCase {
	var $Site = null;
	var $fixtures = array('app.site', 'app.instance');

	function startTest() {
		$this->Site =& ClassRegistry::init('Site');
	}

	function testSiteInstance() {
		$this->assertTrue(is_a($this->Site, 'Site'));
	}

	function testSiteFind() {
		$this->Site->recursive = -1;
		$results = $this->Site->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Site' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'created'  => '2009-07-23 01:55:28',
			'modified'  => '2009-07-23 01:55:28'
		));
		$this->assertEqual($results, $expected);
	}
}
?>