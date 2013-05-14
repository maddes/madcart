<?php echo $header; ?>
<?php if ($success) { ?>
<div class="alert alert-success">
	<i class="icon-ok-sign"></i>
	<?php echo $success; ?>
	<button type="button" class="close" data-dismiss="alert">&times;</button>
</div>
<?php } ?>
<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content">
	<?php echo $content_top; ?>
	<ul class="breadcrumb">
		<?php foreach ($breadcrumbs as $breadcrumb) { ?>
		<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?>
		</a></li>
		<?php } ?>
	</ul>
	<h1>
		<?php echo __('My Affiliate Account', 'affiliate/account'); ?>
	</h1>
	<h2>
		<?php echo __('My Affiliate Account', 'affiliate/account'); ?>
	</h2>
	<div class="content">
		<ul>
			<li><a href="<?php echo $edit; ?>"><?php echo __('Edit your account information', 'affiliate/account'); ?>
			</a></li>
			<li><a href="<?php echo $password; ?>"><?php echo __('Change your password', 'affiliate/account'); ?>
			</a></li>
			<li><a href="<?php echo $payment; ?>"><?php echo __('Change your payment preferences', 'affiliate/account'); ?>
			</a></li>
		</ul>
	</div>
	<h2>
		<?php echo __('My Tracking Information', 'affiliate/account'); ?>
	</h2>
	<div class="content">
		<ul>
			<li><a href="<?php echo $tracking; ?>"><?php echo __('Custom Affiliate Tracking Code', 'affiliate/account'); ?>
			</a></li>
		</ul>
	</div>
	<h2>
		<?php echo __('My Transactions', 'affiliate/account'); ?>
	</h2>
	<div class="content">
		<ul>
			<li><a href="<?php echo $transaction; ?>"><?php echo __('View your transaction history', 'affiliate/account'); ?>
			</a></li>
		</ul>
	</div>
	<?php echo $content_bottom; ?>
</div>
<?php echo $footer; ?>