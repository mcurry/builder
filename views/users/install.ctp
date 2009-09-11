<div class="users form">
<?php echo $form->create('User', array('url' => 'install'));?>
	<fieldset>
 		<legend><?php __('Install');?></legend>
	<?php
		echo $form->input('username');
		echo $form->input('password');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>