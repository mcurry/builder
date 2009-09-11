<div class="instances form">
<?php echo $form->create('Instance');?>
	<fieldset>
 		<legend><?php __('Edit Instance');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('site_id', array('type' => 'hidden'));
    echo $form->input('enabled');
		echo $form->input('name');
		echo $form->input('path', array('type' => 'text'));
		echo $form->input('app_path', array('type' => 'text'));
		echo $form->input('cake_path', array('type' => 'text'));
		echo $form->input('skip_sync');
		echo $form->input('continuous');
    echo $form->input('version_control', array('type' => 'select', 'options' => array('svn' => 'SVN', 'git' => 'Git')));
		echo $form->input('source', array('type' => 'text'));
    echo $form->input('source_branch');
		echo $form->input('source_username');
		echo $form->input('source_password');
		echo $form->input('test');
		echo $form->input('test_each');
		echo $form->input('force_debug_off');
		echo $form->input('version_txt');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>

<script type="text/javascript">
	$(function() {
		$("#InstanceContinuous").change(function() {
			if($(this).attr("checked")) {
				$("#InstanceSource").parent().show();
			} else {
				$("#InstanceSource").parent().hide();
			}
			
			setTestEach();
		}).change();
		
		$("#InstanceTest").change(function() {
			setTestEach();
		}).change();
	});
	
	function setTestEach() {
		if($("#InstanceContinuous").attr("checked") && $("#InstanceTest").attr("checked")) {
			$("#InstanceTestEach").parent().show();
		} else {
			$("#InstanceTestEach").parent().hide();
		}
	}
</script>