<div class="site">
	<h2>
    <?php echo($site['Site']['name']) ?>
    <?php echo $html->link('add instance', array('controller' => 'instances', 'action' => 'add', $site['Site']['id'])) ?>
		<?php echo $html->link('edit site', array('controller' => 'sites', 'action' => 'edit', $site['Site']['id'])) ?>
    <?php
      if(empty($site['Instance'])) {
        echo $html->link('delete site', array('controller' => 'sites', 'action' => 'delete', $site['Site']['id']));
      }
    ?>
  </h2>
  <?php if(!empty($site['Instance'])) { ?>
		<table class="instance">
      <tr>
        <th><?php __('Name') ?></th>
        <th><?php __('Status') ?></th>
        <th><?php __('Detail') ?></th>
        <th><?php __('Actions') ?></th>
			<?php
				foreach($site['Instance'] as $instance) {
			?>
				<tr class="<?php echo $builder->getClass($instance) ?>">
					<td class="name"><?php echo $instance['name'] ?></td>
					<td class="status"><?php echo $builder->status($instance) ?></td>
					<td class="detail">
						<?php echo $builder->detail($instance) ?>
						<?php echo $builder->detailLink($instance) ?>
					</td>
					<td class="actions">
						<?php echo $html->link(__('build', true), array('controller' => 'instances', 'action' => 'build', $instance['id'])) ?>
						<?php echo $html->link(__('history', true), array('controller' => 'builds', 'action' => 'index', $instance['id'])) ?>
            <?php echo $html->link(__('edit', true), array('controller' => 'instances', 'action' => 'edit', $instance['id'])) ?>
            <?php echo $html->link(__('delete', true), array('controller' => 'instances', 'action' => 'confirm_delete', $instance['id'])) ?>
					</td>
				</tr>
			<?php } ?>
    </table>
	<?php } ?>
</div>