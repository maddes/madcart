<?php echo $header; ?>
<?php if ($success) { ?>
<div class="alert alert-success">
	<i class="icon-ok-sign"></i>
	<?php echo $success; ?>
	<button type="button" class="close" data-dismiss="alert">&times;</button>
</div>
<?php } ?>
<?php if ($error_warning) { ?>
<div class="alert alert-error">
	<i class="icon-exclamation-sign"></i>
	<?php echo $error_warning; ?>
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
		<?php echo __('Affiliate Program', 'affiliate/login'); ?>
	</h1>
	<?php echo $text_description; ?>
	<div class="login-content">
		<div class="left">
			<h2>
				<?php echo __('New Affiliate', 'affiliate/login'); ?>
			</h2>
			<div class="content">
				<?php echo __('<p>I am not currently an affiliate.</p><p>Click Continue below to create a new affiliate account. Please note that this is not connected in any way to your customer account.</p>', 'affiliate/login'); ?>
				<a href="<?php echo $register; ?>" class="btn"><?php echo $button_continue; ?>
				</a>
			</div>
		</div>
		<div class="right">
			<form action="<?php echo $action; ?>" method="post"
				enctype="multipart/form-data">
				<h2>
					<?php echo __('Affiliate Login', 'affiliate/login'); ?>
				</h2>
				<div class="content">
					<p>
						<?php echo __('I am a returning affiliate.', 'affiliate/login'); ?>
					</p>
					<b><?php echo __('Affiliate E-Mail:', 'affiliate/login'); ?> </b><br />
					<input type="text" name="email" value="<?php echo $email; ?>" /> <br />
					<br /> <b><?php echo __('Password:', 'affiliate/login'); ?> </b><br />
					<input type="password" name="password"
						value="<?php echo $password; ?>" /> <br /> <a
						href="<?php echo $forgotten; ?>"><?php echo __('Forgotten Password', 'affiliate/login'); ?>
					</a><br /> <br /> <input type="submit"
						value="<?php echo $button_login; ?>" class="btn" />
					<?php if ($redirect) { ?>
					<input type="hidden" name="redirect"
						value="<?php echo $redirect; ?>" />
					<?php } ?>
				</div>
			</form>
		</div>
	</div>
	<?php echo $content_bottom; ?>
</div>
<?php echo $footer; ?>