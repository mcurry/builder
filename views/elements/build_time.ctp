<?php
$buildTime = Configure::read('Build.cron');
if($buildTime) {
	$next = '';
	switch($buildTime['frequency']) {
		case 'minute':
			$next = strtotime(date('Y-m-d H:i:00', strtotime('+1 minute'))) - time() . ' ' . __('seconds', true);
	}
	
	if($next) {
		echo __('next build:', true) . $next;
	}
}
?>