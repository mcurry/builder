--
-- Table structure for table `builds`
--

CREATE TABLE IF NOT EXISTS `builds` (
  `id` int(11) NOT NULL auto_increment,
  `instance_id` int(11) NOT NULL,
  `source` text NOT NULL,
  `source_branch` varchar(50) default NULL,
  `start` datetime default NULL,
  `end` datetime default NULL,
  `build_time` int(11) default NULL,
  `state` smallint(6) NOT NULL,
  `success` tinyint(4) NOT NULL,
  `status` text,
  `tests_passed` int(11) NOT NULL default '0',
  `tests_run` int(11) NOT NULL default '0',
  `version` varchar(50) default NULL,
  PRIMARY KEY  (`id`)
);

-- --------------------------------------------------------

--
-- Table structure for table `instances`
--

CREATE TABLE IF NOT EXISTS `instances` (
  `id` int(11) NOT NULL auto_increment,
  `site_id` int(11) NOT NULL,
  `last_version` varchar(50) NOT NULL,
  `pending` tinyint(1) NOT NULL,
  `name` varchar(50) NOT NULL,
  `path` text NOT NULL,
  `app_path` text NOT NULL,
  `cake_path` text NOT NULL,
  `skip_sync` text NOT NULL,
  `version_control` varchar(10) NOT NULL,
  `source` text NOT NULL,
  `source_branch` varchar(50) default NULL,
  `source_username` varchar(50) default NULL,
  `source_password` varchar(50) default NULL,
  `continuous` tinyint(1) NOT NULL,
  `test` tinyint(1) NOT NULL,
  `test_each` tinyint(1) NOT NULL,
  `force_debug_off` tinyint(1) NOT NULL,
  `version_txt` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
);

-- --------------------------------------------------------

--
-- Table structure for table `sites`
--

CREATE TABLE IF NOT EXISTS `sites` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
);

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

CREATE TABLE IF NOT EXISTS `tests` (
  `id` int(11) NOT NULL auto_increment,
  `build_id` int(11) NOT NULL,
  `case` varchar(255) NOT NULL,
  `success` tinyint(4) NOT NULL,
  `output` text NOT NULL,
  `start` datetime default NULL,
  `end` datetime default NULL,
  `test_time` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(255) NOT NULL,
  `password` varchar(40) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`)
);