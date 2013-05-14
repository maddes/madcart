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
		<?php echo __('My Account', 'account/account'); ?>
	</h1>
	<h2>
		<?php echo __('My Account', 'account/account'); ?>
	</h2>
	<div class="content">
		<ul>
			<li><a href="<?php echo $edit; ?>"><?php echo __('Edit your account information', 'account/account'); ?>
			</a></li>
			<li><a href="<?php echo $password; ?>"><?php echo __('Change your password', 'account/account'); ?>
			</a></li>
			<li><a href="<?php echo $address; ?>"><?php echo __('Modify your address book entries', 'account/account'); ?>
			</a></li>
			<li><a href="<?php echo $wishlist; ?>"><?php echo __('Modify your wish list', 'account/account'); ?>
			</a></li>
		</ul>
	</div>
	<h2>
		<?php echo __('My Orders', 'account/account'); ?>
	</h2>
	<div class="content">
		<ul>
			<li><a href="<?php echo $order; ?>"><?php echo __('View your order history', 'account/account'); ?>
			</a></li>
			<li><a href="<?php echo $download; ?>"><?php echo __('Downloads', 'account/account'); ?>
			</a></li>
			<?php if ($reward) { ?>
			<li><a href="<?php echo $reward; ?>"><?php echo __('Your Reward Points', 'account/account'); ?>
			</a></li>
			<?php } ?>
			<li><a href="<?php echo $return; ?>"><?php echo __('View your return requests', 'account/account'); ?>
			</a></li>
			<li><a href="<?php echo $transaction; ?>"><?php echo __('Your Transactions', 'account/account'); ?>
			</a></li>
		</ul>
	</div>
	<h2>
		<?php echo __('Newsletter', 'account/account'); ?>
	</h2>
	<div class="content">
		<ul>
			<li><a href="<?php echo $newsletter; ?>"><?php echo __('Subscribe / unsubscribe to newsletter', 'account/account'); ?>
			</a></li>
		</ul>
	</div>
	<?php echo $content_bottom; ?>
</div>
<?php echo $footer; ?>
