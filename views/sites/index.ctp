<?php
	foreach($sites as $site) {
		echo $this->element('site', array('site' => $site));
	}
?>