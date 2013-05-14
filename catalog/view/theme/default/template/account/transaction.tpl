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
		<?php echo __('Your Transactions', 'account/transaction'); ?>
	</h1>
	<p>
		<?php echo __('Your current balance is:', 'account/transaction'); ?>
		<b> <?php echo $total; ?>
		</b>.
	</p>
	<table class="table table-striped table-bordered table-hover">
		<thead>
			<tr>
				<td class="left"><?php echo __('Date Added', 'account/transaction'); ?>
				</td>
				<td class="left"><?php echo __('Description', 'account/transaction'); ?>
				</td>
				<td class="right"><?php echo $column_amount; ?></td>
			</tr>
		</thead>
		<tbody>
			<?php if ($transactions) { ?>
			<?php foreach ($transactions  as $transaction) { ?>
			<tr>
				<td class="left"><?php echo $transaction['date_added']; ?></td>
				<td class="left"><?php echo $transaction['description']; ?></td>
				<td class="right"><?php echo $transaction['amount']; ?></td>
			</tr>
			<?php } ?>
			<?php } else { ?>
			<tr>
				<td class="center" colspan="5"><?php echo __('You do not have any transactions!', 'account/transaction'); ?>
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