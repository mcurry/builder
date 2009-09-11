<?php
	$class = array(); 
  if($test['success']) {
    $class[] = 'success';
  } else {
    $class[] = 'error';
  }

  $class = ' class="' . implode(' ', $class) . '"';
?>
<tr<?php echo $class;?>>
	<td><?php echo $builder->statusIcon($build['Build']); ?></td>
	<td><?php echo $html->link($test['case'], array('controller' => 'tests', 'action' => 'view', $test['id'])); ?></td>
	<td><?php echo $appTime->timeInWords($test['test_time']) ?></td>
</tr>