<div class="sites view">
<h2><?php  __('Site');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $site['Site']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $site['Site']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $site['Site']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $site['Site']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit Site', true), array('action'=>'edit', $site['Site']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete Site', true), array('action'=>'delete', $site['Site']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $site['Site']['id'])); ?> </li>
		<li><?php echo $html->link(__('List Sites', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Site', true), array('action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Instances', true), array('controller'=> 'instances', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Instance', true), array('controller'=> 'instances', 'action'=>'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Instances');?></h3>
	<?php if (!empty($site['Instance'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Site Id'); ?></th>
		<th><?php __('Name'); ?></th>
		<th><?php __('Continuous'); ?></th>
		<th><?php __('Test'); ?></th>
		<th><?php __('Test Each'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($site['Instance'] as $instance):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $instance['id'];?></td>
			<td><?php echo $instance['site_id'];?></td>
			<td><?php echo $instance['name'];?></td>
			<td><?php echo $instance['continuous'];?></td>
			<td><?php echo $instance['test'];?></td>
			<td><?php echo $instance['test_each'];?></td>
			<td><?php echo $instance['created'];?></td>
			<td><?php echo $instance['modified'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller'=> 'instances', 'action'=>'view', $instance['id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller'=> 'instances', 'action'=>'edit', $instance['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller'=> 'instances', 'action'=>'delete', $instance['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $instance['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Instance', true), array('controller'=> 'instances', 'action'=>'add'));?> </li>
		</ul>
	</div>
</div>
