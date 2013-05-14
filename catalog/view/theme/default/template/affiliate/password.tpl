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
		<?php echo __('Change Password', 'affiliate/password'); ?>
	</h1>
	<form action="<?php echo $action; ?>" method="post"
		enctype="multipart/form-data">
		<h2>
			<?php echo __('Your Password', 'affiliate/password'); ?>
		</h2>
		<div class="content">
			<table class="form">
				<tr>
					<td><span class="required">*</span> <?php echo __('Password:', 'affiliate/password'); ?>
					</td>
					<td><input type="password" name="password"
						value="<?php echo $password; ?>" /> <?php if ($error_password) { ?>
						<span class="error"><?php echo $error_password; ?> </span> <?php } ?>
					</td>
				</tr>
				<tr>
					<td><span class="required">*</span> <?php echo __('Password Confirm:', 'affiliate/password'); ?>
					</td>
					<td><input type="password" name="confirm"
						value="<?php echo $confirm; ?>" /> <?php if ($error_confirm) { ?>
						<span class="error"><?php echo $error_confirm; ?> </span> <?php } ?>
					</td>
				</tr>
			</table>
		</div>
		<div class="buttons">
			<div class="left">
				<a href="<?php echo $back; ?>" class="btn"><?php echo $button_back; ?>
				</a>
			</div>
			<div class="right">
				<input type="submit" value="<?php echo $button_continue; ?>"
					class="btn" />
			</div>
		</div>
	</form>
	<?php echo $content_bottom; ?>
</div>
<?php echo $footer; ?>