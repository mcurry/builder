<?php
App::import('Vendor', 'Find.find_app_model');

class AppModel extends FindAppModel {
	var $actsAs = array('Containable');
	var $recursive = -1;
}

?>