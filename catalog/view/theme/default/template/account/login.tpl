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
		<?php echo __('Account Login', 'account/login'); ?>
	</h1>
	<div class="login-content">
		<div class="left">
			<h2>
				<?php echo __('New Customer', 'account/login'); ?>
			</h2>
			<div class="content">
				<p>
					<b><?php echo __('Register Account', 'account/login'); ?> </b>
				</p>
				<p>
					<?php echo __('Register Account', 'account/login'); ?>
				</p>
				<a href="<?php echo $register; ?>" class="btn"><?php echo $button_continue; ?>
				</a>
			</div>
		</div>
		<div class="right">
			<h2>
				<?php echo __('Returning Customer', 'account/login'); ?>
			</h2>
			<form action="<?php echo $action; ?>" method="post"
				enctype="multipart/form-data">
				<div class="content">
					<p>
						<?php echo __('I am a returning customer', 'account/login'); ?>
					</p>
					<b><?php echo __('E-Mail Address:', 'account/login'); ?> </b><br />
					<input type="text" name="email" value="<?php echo $email; ?>" /> <br />
					<br /> <b><?php echo __('Password:', 'account/login'); ?> </b><br />
					<input type="password" name="password"
						value="<?php echo $password; ?>" /> <br /> <a
						href="<?php echo $forgotten; ?>"><?php echo __('Forgotten Password', 'account/login'); ?>
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