<?php
class BuilderShell extends Shell {
	var $uses = array('Instance');
	var $Folder = null;
	var $tmp = null;
	var $silent = false;

	var $build = null;

	var $vcs = array();
	var $vc = null;

	var $tests_passed = 0;
	var $tests_run = 0;

	function initialize() {
		parent::initialize();

		$this->Folder = new Folder();
	}

	function main() {
		$this->__startPid();
		
		$builds = $this->__gather();

		if (empty($builds)) {
			$this->out('No pending builds');
			$this->__stopPid();
			$this->_stop();
		}

		foreach($builds as $build) {
			try {
				$this->Instance->create();
				$this->Instance->Build->create();
				$this->Instance->id = $build['id'];

				if ($build['pending']) {
					$this->Instance->saveField('pending', false);
				}

				if (!$this->vc = $this->vcs[$build['version_control']]) {
					$this->__exception(__METHOD__, 'Unsupported version control system: :vcs', array('vcs' => $build['version_control']));
				}
        
        $this->tmp = TMP . 'builder' . DS . $build['id'];
        $this->vcs[$build['version_control']]->setConf($build);
				
				$success = true;
				$status = null;

				$this->Instance->Build->start($build['id'], $build['source'], $build['version'], $build['source_branch']);
        $version = $build['version'];
        if(!empty($build['source_branch'])) {
          $version = $build['source_branch'] . ', ' . $version;
        }
				$this->__setStatus('Building ' . $build['source'] . ' (' . $version . ')');
				
				$this->build = $build;

				$this->__findCacheDirs();

				$this->__export();

				$this->__fixDebug();

				$this->__sync();

				$this->__versionTxt();

				$this->__createTmpDirs();

				$this->__clearCache();

				$this->__runTests();
			} catch (Exception $e) {
				$success = false;
				$status = $e->getMessage();
			}

			$this->Instance->saveField('last_version', $this->build['version']);
			$this->Instance->Build->end($success, array('status' => $status,
																	'tests_passed' => $this->tests_passed,
																	'tests_run' => $this->tests_run));
		}
		
		$this->__stopPid();
	}
	
	function __gather() {
		$builds = array();
		$instances = $this->Instance->find('build');

		foreach($instances as $instance) {
			$instance = $instance['Instance'];
			$version = $this->__setupVersionControl($instance);

			if ($instance['pending']) {
				$instance['version'] = $this->vcs[$instance['version_control']]->getVersion();
				$builds[] = $instance;
			} else if ($instance['continuous'] && $version != $instance['last_version']) {
				if ($instance['test_each']) {
					$oldVersions = $this->vcs[$instance['version_control']]->getOldVersions($instance['last_version']);
					foreach($oldVersions as $version) {
						$instance['version'] = $version;
						$builds[] = $instance;
					}
				} else {
					$instance['version'] = $version;
					$builds[] = $instance;
				}
			}
		}

		return $builds;
	}

	function __setupVersionControl($instance) {
		$version = null;

		if (empty($this->vcs[$instance['version_control']])) {
			$this->vcs[$instance['version_control']] = ConnectionManager::getDataSource($instance['version_control']);
		}
		
		$this->vcs[$instance['version_control']]->setConf($instance);

		if ($instance['continuous']) {
			if (!$version = $this->vcs[$instance['version_control']]->getVersion()) {
				$this->__exception(__METHOD__, 'Unable to detect version from :vc :source', array('vc' => $instance['version_control'],
													 'source' => $instance['source']));
			}
		}

		return $version;
	}

	function __findCacheDirs() {
		$this->__setStatus('Building cache dir list');

		$paths = array('tmp' . DS . 'cache' . DS . 'models',
									 'tmp' . DS . 'cache' . DS . 'persistent',
									 'tmp' . DS . 'cache' . DS . 'views');

		$assetPlugin = Folder::addPathElement($this->build['app_path'], 'plugins' . DS . 'asset');
		if (is_dir($assetPlugin)) {
			$paths[] = 'webroot' . DS . 'ccss';
			$paths[] = 'webroot' . DS . 'cjs';
		}

		$this->build['cache_dirs'] = $paths;
	}

	function __export() {
		$this->__setStatus('Exporting');

		if (!$this->vc->export($this->build['version'])) {
			$this->__exception(__METHOD__, ' Error exporting new version: :source', array('source' => $this->build['source']));
		}
	}

	function __fixDebug() {
		if (empty($this->build['force_debug_off'])) {
			return;
		}

		$this->__setStatus('Turning debug off');

		if (!$this->Folder->cd($this->tmp)) {
			$this->__exception(__METHOD__, 'Error changing to tmp directory: :tmp', array('tmp' => $this->tmp));
		}

		$cores = $this->Folder->findRecursive('core\.php');
		if (empty($cores)) {
			$this->__exception(__METHOD__, 'Couldn\'t find core.php in: :tmp', array('tmp' => $this->tmp));
		}

		foreach($cores as $core) {
			if (!$File = new File($core)) {
				$this->__exception(__METHOD__, 'Error opening core.php: :core', compact('core'));
			}

			if (!$contents = $File->read()) {
				$this->__exception(__METHOD__, 'Error reading core.php: :core', compact('core'));
			}

			$contents = preg_replace('/\'debug\', [0-2]/', '\'debug\', 0', $contents, 1, $count);

			if ($count !== 1) {
				$this->__exception(__METHOD__, 'Could not find debug setting in core.php: :core', compact('core'));
			}

			if (!$File->write($contents)) {
				$this->__exception(__METHOD__, 'Error writing core.php: :core', compact('core'));
			}
		}
	}

	function __sync() {
		$this->__setStatus('Syncing');

		$skip = array_merge(array('.git', '.gitignore'), array_map('trim', explode(',', $this->build['skip_sync'])));
		$this->__syncRecursive($this->tmp, $this->build['path'], array('skip' => $skip));
	}

	function __syncRecursive($fromDir, $toDir, $options=array()) {
		$options = array_merge(array('skip' => array()), $options);
		$fromFolder = new Folder($fromDir);
		$toFolder = new Folder($toDir);

		list($fromDirs, $fromFiles) = $fromFolder->read();
		list($toDirs, $toFiles) = $toFolder->read();

		foreach($fromFiles as $item) {
			if (in_array($item, $options['skip'])) {
				continue;
			}

			$from = Folder::addPathElement($fromDir, $item);
			$to = Folder::addPathElement($toDir, $item);

			if (!is_dir($toDir)) {
				if (!$toFolder->mkdir($toDir)) {
					$this->__exception(__METHOD__, 'Error creating dir :$toDir', compact('toDir'));
				}
			}

			if (!copy($from, $to)) {
				$this->__exception(__METHOD__, 'Error syncing: :from to :to', compact('from', 'to'));
			}
			touch($to, filemtime($from));
		}

		$old = array_diff($toFiles, $fromFiles, $options['skip']);
		if (!empty($old)) {
			foreach($old as $item) {
				$item = Folder::addPathElement($toDir, $item);
				if (!unlink($item)) {
					$this->__exception(__METHOD__, 'Error removing old file :item', compact('item'));
				}
			}
		}

		foreach($fromDirs as $item) {
			if (in_array($item, $options['skip'])) {
				continue;
			}
      
			$this->__syncRecursive(Folder::addPathElement($fromDir, $item), Folder::addPathElement($toDir, $item), $options);
		}

		$old = array_diff($toDirs, $fromDirs, $options['skip']);
		if (!empty($old)) {
			foreach($old as $item) {
				$item = Folder::addPathElement($toDir, $item);
				if (!$toFolder->delete($item)) {
					$this->__exception(__METHOD__, 'Error removing old directory :item', compact('item'));
				}
			}
		}
	}

	function __versionTxt() {
		if (empty($this->build['version_txt'])) {
			return;
		}


		$this->__setStatus('Writing version.txt');

		$path = $this->build['app_path'] . DS . 'webroot' . DS . 'version.txt';
		if (!$File = new File($path, true)) {
			$this->__exception(__METHOD__, 'Error creating version file :path', compact('path'));
		}

		$content = sprintf("%s\n%s", $this->build['version'], date('Y-m-d H:i:s'));
		if (!$File->write($content)) {
			$this->__exception(__METHOD__, 'Error writing version file :path', compact('path'));
		}
	}

	function __createTmpDirs() {
		$this->__setStatus('Creating tmp dirs');

		$paths = array_merge($this->build['cache_dirs'],
												 array('tmp' . DS . 'logs',
															 'tmp' . DS . 'sessions'));

		foreach($paths as $item) {
			$item = Folder::addPathElement($this->build['app_path'], $item);
			if (!$this->Folder->create($item)) {
				$this->__exception(__METHOD__, 'Error creating dir :item', compact('item'));
			}
		}
	}

	function __clearCache() {
		$this->__setStatus('Clearing cache dirs');

		foreach($this->build['cache_dirs'] as $item) {
			$item = Folder::addPathElement($this->build['app_path'], $item);

			$files = glob($item . DS . '*');
			if ($files === false) {
				continue;
			}

			foreach($files as $file) {
				if (is_file($file)) {
					@unlink($file);
				} else if (is_dir($file)) {
					$this->Folder->delete($file);
				}
			}
		}
	}

	function __runTests() {
		if(!$this->build['test']) {
			return;
		}
		
		$this->__setStatus('Starting unit tests');

		$console = $this->build['cake_path'] . DS . 'console' . DS . 'cake';

		$this->Folder->cd($this->build['app_path'] . DS . 'tests' . DS . 'cases');
		$tests = $this->Folder->findRecursive('.{1,}\.test\.php');

		$this->tests_passed = 0;
		$this->tests_run = 0;
		foreach($tests as $test) {
			$case = substr($test, strpos($test, 'cases') + 6, -9);
			$this->__setStatus('Running unit test: :case', compact('case'));
			$cmd = sprintf('%s -app %s testsuite app case %s', $console, $this->build['app_path'], $case);
			$output = array();
			
			$start = time();
			exec($cmd, $output, $return_value);
			$end = time();

			$success = false;
			if ($return_value === 0) {
				$success = true;
				$this->tests_passed ++;
			}
			
			$data = array('build_id' => $this->Instance->Build->id,
										'case' => $case,
										'success' => $success,
										'output' => $this->__formatTestOutput($output),
										'start' => date('Y-m-d H:i:s', $start),
										'end' => date('Y-m-d H:i:s', $end),
										'test_time' => $end - $start);
			$this->Instance->Build->Test->create($data);
			$this->Instance->Build->Test->save();
			$this->tests_run ++;
		}
	}

	function __formatTestOutput($output) {
		if(empty($output)) {
			return '';
		}
		
		foreach($output as $i => $line) {
			if (preg_match('/Running app case/', $line)) {
				break;
			}
		}

		$output = array_slice($output, $i);
		return implode("\n", $output);
	}

	function __setStatus($status, $data=array()) {
		$status = String::insert(__($status, true), $data);
		if (!$this->silent) {
			$this->out($status);
		}

		$this->Instance->Build->setStatus($status);
	}

	function __exception($method, $message, $data=array()) {
		$exception = sprintf('[%s] %s', $method, String::insert(__($message, true), $data));

		if (!$this->silent) {
			$this->out($exception);
		}

		throw new Exception($exception);
	}
	
	function __startPid() {
		if (Cache::read('Builder.pid')) {
			$this->out(__('Builder already running', true));
			$this->_stop();
		}
		
		Cache::write('Builder.pid', true);
	}
	
	function __stopPid() {
		Cache::delete('Builder.pid');
	}
}
?>