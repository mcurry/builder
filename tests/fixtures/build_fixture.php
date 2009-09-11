<?php 
/* SVN FILE: $Id$ */
/* Build Fixture generated on: 2009-07-23 01:07:56 : 1248328496*/

class BuildFixture extends CakeTestFixture {
	var $name = 'Build';
	var $table = 'builds';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'instance_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'start' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'end' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'status' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 10),
		'version' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 50),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'instance_id'  => 1,
		'start'  => '2009-07-23 01:54:56',
		'end'  => '2009-07-23 01:54:56',
		'status'  => 'Lorem ip',
		'version'  => 'Lorem ipsum dolor sit amet'
	));
}
?>