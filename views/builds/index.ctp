<div class="builds index">
<h2><?php __('Builds');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('success');?></th>
	<th><?php echo $paginator->sort('source');?></th>
  <th><?php echo $paginator->sort('source_branch');?></th>
	<th><?php echo $paginator->sort('version');?></th>
	<th><?php echo $paginator->sort('start');?></th>
	<th><?php echo $paginator->sort('build_time');?></th>
	<th><?php echo $paginator->sort('tests_passed');?></th>
	<th><?php echo $paginator->sort('tests_run');?></th>
</tr>
<?php
$i = 0;
foreach ($builds as $build):
  $class = sprintf(' class="%s"', $builder->getClass($build));
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $html->link($build['Build']['id'], array('controller' => 'builds', 'action' => 'view', $build['Build']['id'])); ?>
		</td>
		<td>
			<?php echo $builder->statusIcon($build['Build']); ?>
		</td>
		<td>
			<?php echo $build['Build']['source']; ?>
		</td>
		<td>
			<?php echo $build['Build']['source_branch']; ?>
		</td>
		<td>
			<?php echo $build['Build']['version']; ?>
		</td>
		<td>
			<?php echo $build['Build']['start']; ?>
		</td>
		<td>
			<?php echo $appTime->timeInWords($build['Build']['build_time']); ?>
		</td>
		<td>
			<?php echo $build['Build']['tests_passed']; ?>
		</td>
		<td>
			<?php echo $build['Build']['tests_run']; ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>

<div class="paging">
<?php echo $paginator->prev('<< ' . __('previous', true), array(), null, array('class' => 'disabled')) ;?>
 | <?php echo $paginator->numbers() ?> | 
<?php echo $paginator->next(__('next', true) .' >>', array(), null, array('class' => 'disabled')) ;?>
</div>