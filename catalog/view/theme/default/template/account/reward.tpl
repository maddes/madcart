<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content">
	<?php echo $content_top; ?>
	<ul class="breadcrumb">
		<?php foreach ($breadcrumbs as $breadcrumb) { ?>
		<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?>
		</a></li>
		<?php } ?>
	</ul>
	<h1>
		<?php echo __('Your Reward Points', 'account/reward'); ?>
	</h1>
	<p>
		<?php echo __('Your total number of reward points is:', 'account/reward'); ?>
		<b> <?php echo $total; ?>
		</b>.
	</p>
	<table class="table table-striped table-bordered table-hover">
		<thead>
			<tr>
				<td class="left"><?php echo __('Date Added', 'account/reward'); ?></td>
				<td class="left"><?php echo __('Description', 'account/reward'); ?>
				</td>
				<td class="right"><?php echo __('Points', 'account/reward'); ?></td>
			</tr>
		</thead>
		<tbody>
			<?php if ($rewards) { ?>
			<?php foreach ($rewards  as $reward) { ?>
			<tr>
				<td class="left"><?php echo $reward['date_added']; ?></td>
				<td class="left"><?php if ($reward['order_id']) { ?> <a
					href="<?php echo $reward['href']; ?>"><?php echo $reward['description']; ?>
				</a> <?php } else { ?> <?php echo $reward['description']; ?> <?php } ?>
				</td>
				<td class="right"><?php echo $reward['points']; ?></td>
			</tr>
			<?php } ?>
			<?php } else { ?>
			<tr>
				<td class="center" colspan="5"><?php echo __('You do not have any reward points!', 'account/reward'); ?>
				</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	<div class="pagination">
		<?php echo $pagination; ?>
	</div>
	<div class="results">
		<?php echo $results; ?>
	</div>
	<div class="buttons">
		<div class="right">
			<a href="<?php echo $continue; ?>" class="btn"><?php echo $button_continue; ?>
			</a>
		</div>
	</div>
	<?php echo $content_bottom; ?>
</div>
<?php echo $footer; ?>