<?php
class GitSource extends DataSource {
  var $description = "Git DataSource";

  var $cmd = '';
  var $tmpPath = null;
  var $_baseConfig = array('path' => false);

  function __construct($config = array()) {
    parent::__construct($config);

    $this->cmd = $this->config['path'];
  }

  function setConf($config=array()) {
    $this->tmpPath = TMP . 'builder' . DS . $config['id'];
    
    $defaults = array('source' => false, 'source_branch' => 'origin/master');
    $config = array_intersect_key($config, $defaults);
    $this->config = array_merge($this->config, $config);
  }


  function export($version=null) {
    $cmd = sprintf('cd %s; %s reset %s', $this->tmpPath, $this->cmd, $version);
    exec($cmd, $output, $return_value);
    
		if ($return_value !== 0) {
			return false;
		}

		return true;
  }

  function getVersion() {
    $this->_clone();
   
    $cmd = sprintf('cd %s; %s pull %s; %s log -n 1', $this->tmpPath,
                   $this->cmd, str_replace('/', ' ', $this->config['source_branch']),
                   $this->cmd);
    exec($cmd, $output);
    
    $revision = false;
    foreach($output as $line) {
      if(preg_match('/^commit/', $line)) {
        $revision = str_replace('commit ', '', $line);
      }
    }
    
    return $revision;
  }

  function getOldVersions($revision) {
    if(empty($revision)) {
      return array($this->getVersion());
    }
    
    $cmd = sprintf('cd %s; %s log %s..', $this->tmpPath, $this->cmd, $revision);
    exec($cmd, $output);
    
    $revisions = array();
    foreach($output as $line) {
      if(preg_match('/^commit/', $line)) {
        $revisions[] = str_replace('commit ', '', $line);
      }
    }
    
    return array_reverse($revisions);
  }
  
  function _clone() {
    if(!file_exists($this->tmpPath . DS . '.git')) {
      $cmd = sprintf('%s clone %s %s', $this->cmd, $this->config['source'], $this->tmpPath);
      exec($cmd);
    }
    
    if(!empty($this->config['source_branch'])) {
      $cmd = sprintf('cd %s; %s checkout %s', $this->tmpPath, $this->cmd, $this->config['source_branch']);
      exec($cmd);
    }
  }
}
?>