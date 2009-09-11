<div class="users form">
<?php echo $form->create('User', array('url' => 'login'));?>
	<fieldset>
 		<legend><?php __('Login');?></legend>
	<?php
		echo $form->input('username');
		echo $form->input('password');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>