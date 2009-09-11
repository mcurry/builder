<h2><?php __('Are you sure you want to do this?') ?></h2>
<p><?php __('No files will be deleted from your disk drive') ?></p>
<?php echo $html->link(__('Cancel', true), array('controller' => 'sites', 'action' => 'index')) ?>
<?php echo $html->link(__('DELETE', true), array('action' => 'delete', $id)) ?>
