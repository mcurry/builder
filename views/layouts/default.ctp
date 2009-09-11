<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $html->charset(); ?>
	<title><?php echo $title_for_layout; ?></title>
	<?php
		echo $html->meta('icon');

		echo $javascript->link(array('http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js',
																 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js',
                                 'builder'));
		echo $html->css(array('http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/redmond/jquery-ui.css',
													'cake.generic',
                          'builder'));

		echo $scripts_for_layout;
	?>
</head>
<body>
	<div id="container">
		<div id="header">
			<h1><?php echo $html->link(__('Builder', true), '/'); ?></h1>
			<?php if($session->read('Auth.User')) { ?>
				<ul id="menu">
					<li><?php echo $this->element('build_time') ?></li>
					<li><?php echo $html->link(__('home', true), '/'); ?></li>
					<li><?php echo $html->link(__('add site', true), array('controller' => 'sites', 'action' => 'add')); ?></li>
					<li><?php echo $html->link(__('logout', true), array('controller' => 'users', 'action' => 'logout')); ?></li>
				</ul>
			<?php } ?>
		</div>
		<div id="content">

			<?php $session->flash(); ?>

			<?php echo $content_for_layout; ?>

		</div>
		<div id="footer">
			<?php echo $html->link(
					$html->image('cake.power.gif', array('alt'=> __("CakePHP: the rapid development php framework", true), 'border'=>"0")),
					'http://www.cakephp.org/',
					array('target'=>'_blank'), null, false
				);
			?>
		</div>
	</div>
	<?php echo $cakeDebug; ?>
</body>
</html>