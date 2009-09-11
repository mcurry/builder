<?php
App::import('core', array('Xml', 'Folder'));

class SvnSource extends DataSource {
	var $description = "SVN DataSource";
	
	var $cmd = '';
  var $tmpPath = '';
  
	var $_baseConfig = array('path' => false,
													 'username' => false,
													 'password' => false);
	
	function __construct($config = array()) {
		parent::__construct($config);
		
		$this->cmd = $this->config['path'];
	}
	
	function setConf($config=array()) {
    $this->tmpPath = TMP . 'builder' . DS . $config['id'];
    
    if(!empty($config['source_branch'])) {
      $config['source'] .= '/' . $config['source_branch'];
    }
    
		$defaults = array('source' => false, 'source_username' => false, 'source_password' => false);
		$config = array_intersect_key($config, $defaults);
		$this->config = array_merge($this->config, $config);
	}
	
	function export($version=null) {
    if(!$this->tmpPath) {
      return false;
    }
    
    $Folder = new Folder();
		if (!$Folder->delete($this->tmpPath)) {
			return false;
		}
  
		if (empty($version)) {
			$version = 'HEAD';
		}

		$cmd = $this->__getCmd() . ' export --revision ' . $version . ' ' . $this->config['source'] . ' ' . $this->tmpPath;
		exec($cmd, $output, $return_value);

		if ($return_value !== 0) {
			return false;
		}

		return true;
	}

	function getVersion() {
		$cmd = $this->__getCmd() . ' log --xml --limit 1 ' . $this->config['source'];
		exec($cmd, $output);
		$Xml = new Xml(implode('', $output));
		return $Xml->children[0]->child('logentry')->attributes['revision'];
	}

	function getOldVersions($revision) {
    if(empty($revision)) {
      return array($this->getVersion());
    }
    
		$cmd = $this->__getCmd() . ' log --xml --revision ' . $revision . ':HEAD ' . $this->config['source'];
		exec($cmd, $output);

		$Xml = new Xml(implode('', $output));

		$revisions = array();
		foreach($Xml->children[0]->children('logentry') as $logentry) {
			if ($logentry->attributes['revision']> $revision) {
				$revisions[] = $logentry->attributes['revision'];
			}
		}

		return $revisions;
	}
	
	function __getCmd() {
		$cmd = $this->cmd . ' --non-interactive';
    
		if($this->config['username']) {
			$cmd .= ' --username ' . $this->config['username'];
		}
		if($this->config['password']) {
			$cmd .= ' --password ' . $this->config['password'];
		}
		
		return $cmd;
	}
}
?>