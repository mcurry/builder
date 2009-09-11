<div class="instances form">
<?php echo $form->create('Instance', array('action' => 'build'));?>
	<fieldset>
 		<legend><?php __('Setup Build');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('source', array('type' => 'text'));
    echo $form->input('source_branch');
		echo $form->input('source_username');
		echo $form->input('source_password');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>