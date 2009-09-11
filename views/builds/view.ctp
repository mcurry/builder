<div class="builds view">
<h2><?php  __('Build');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $build['Build']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Site'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $build['Instance']['Site']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Instance'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $build['Instance']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Start'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $build['Build']['start']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('End'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $build['Build']['end']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Build Time'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $appTime->timeInWords($build['Build']['build_time']); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('State'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php
        switch ($build['Build']['state']) {
          case Build::$pending:
            __('Pending');
            break;
          case Build::$running:
            __('Running');
            break;
          case Build::$completed:
            __('Completed');
            break;
        }
      ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Success'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php if($build['Build']['success']) { __('Success'); } else { __('Error'); } ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Branch'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $build['Build']['source_branch']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Version'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $build['Build']['version']; ?>
			&nbsp;
		</dd>
	</dl>
	
		<?php if (!empty($build['Test'])) { ?>
			<h2><?php __('Tests'); ?></h2>
			<h3><?php echo $build['Build']['tests_passed']; ?> of <?php echo $build['Build']['tests_run']; ?> tests passed</h3>
			<table cellpadding="0" cellspacing="0">
				<tr>
					<th><?php __('Success'); ?></th>
					<th><?php __('Case'); ?></th>
					<th><?php __('Test Time'); ?></th>
				</tr>

				<?php
					foreach($build['Test'] as $test) {
						echo $this->element('test_results', array('test' => $test));
					}
				?>
			</table>
		<?php } ?>
</div>