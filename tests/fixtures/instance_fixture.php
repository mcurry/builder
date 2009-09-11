<?php 
/* SVN FILE: $Id$ */
/* Instance Fixture generated on: 2009-07-23 01:07:13 : 1248328513*/

class InstanceFixture extends CakeTestFixture {
	var $name = 'Instance';
	var $table = 'instances';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'site_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'name' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 50),
		'continuous' => array('type'=>'boolean', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'site_id'  => 1,
		'name'  => 'Lorem ipsum dolor sit amet',
		'continuous'  => 1,
		'created'  => '2009-07-23 01:55:13',
		'modified'  => '2009-07-23 01:55:13'
	));
}
?>