<?php
class Build extends AppModel {

	var $name = 'Build';
	var $belongsTo = array('Instance');
	var $hasMany = array('Test' => array('dependent' => true));
	var $order = 'start DESC';

	var $startTime = null;

	static $pending = 1;
	static $running = 2;
	static $completed = 3;

	function start($instance_id, $source, $version=null, $branch=null) {
		$this->startTime = time();

		$this->create(array('instance_id' => $instance_id,
												'start' => date('Y-m-d H:i:s', $this->startTime),
												'state' => self::$running,
												'status' => __('Starting', true),
												'source' => $source,
												'version' => $version,
												'source_branch' => $branch
											 ));
		$this->save();
	}

	function setStatus($status) {
		$this->saveField('status', $status);
	}

	function end($success, $extra=array()) {
		if (empty($this->id)) {
			return;
		}

		$extra = array_merge(array('status' => null, 'tests_passed' => 0, 'tests_run' => 0), $extra);

		$end = time();
		$this->save(array('end' => date('Y-m-d H:i:s', $end),
											'build_time' => $end - $this->startTime,
											'state' => self::$completed,
											'success' => $success,
											'status' => $extra['status'],
											'tests_passed' => $extra['tests_passed'],
											'tests_run' => $extra['tests_run']));
	}
}
?>