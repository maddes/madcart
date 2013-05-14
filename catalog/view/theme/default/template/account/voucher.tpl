<?php echo $header; ?>
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
		<?php echo __('Purchase a Gift Certificate', 'account/voucher'); ?>
	</h1>
	<p>
		<?php echo __('This gift certificate will be emailed to the recipient after your order has been paid for.', 'account/voucher'); ?>
	</p>
	<form action="<?php echo $action; ?>" method="post"
		enctype="multipart/form-data">
		<table class="form">
			<tr>
				<td><span class="required">*</span> <?php echo __('Recipient\'s Name:', 'account/voucher'); ?>
				</td>
				<td><input type="text" name="to_name"
					value="<?php echo $to_name; ?>" /> <?php if ($error_to_name) { ?> <span
					class="error"><?php echo $error_to_name; ?> </span> <?php } ?></td>
			</tr>
			<tr>
				<td><span class="required">*</span> <?php echo __('Recipient\'s Email:', 'account/voucher'); ?>
				</td>
				<td><input type="text" name="to_email"
					value="<?php echo $to_email; ?>" /> <?php if ($error_to_email) { ?>
					<span class="error"><?php echo $error_to_email; ?> </span> <?php } ?>
				</td>
			</tr>
			<tr>
				<td><span class="required">*</span> <?php echo __('Your Name:', 'account/voucher'); ?>
				</td>
				<td><input type="text" name="from_name"
					value="<?php echo $from_name; ?>" /> <?php if ($error_from_name) { ?>
					<span class="error"><?php echo $error_from_name; ?> </span> <?php } ?>
				</td>
			</tr>
			<tr>
				<td><span class="required">*</span> <?php echo __('Your Email:', 'account/voucher'); ?>
				</td>
				<td><input type="text" name="from_email"
					value="<?php echo $from_email; ?>" /> <?php if ($error_from_email) { ?>
					<span class="error"><?php echo $error_from_email; ?> </span> <?php } ?>
				</td>
			</tr>
			<tr>
				<td><span class="required">*</span> <?php echo __('Gift Certificate Theme:', 'account/voucher'); ?>
				</td>
				<td><?php foreach ($voucher_themes as $voucher_theme) { ?> <?php if ($voucher_theme['voucher_theme_id'] == $voucher_theme_id) { ?>
					<input type="radio" name="voucher_theme_id"
					value="<?php echo $voucher_theme['voucher_theme_id']; ?>"
					id="voucher-<?php echo $voucher_theme['voucher_theme_id']; ?>"
					checked="checked" /> <label
					for="voucher-<?php echo $voucher_theme['voucher_theme_id']; ?>"><?php echo $voucher_theme['name']; ?>
				</label> <?php } else { ?> <input type="radio"
					name="voucher_theme_id"
					value="<?php echo $voucher_theme['voucher_theme_id']; ?>"
					id="voucher-<?php echo $voucher_theme['voucher_theme_id']; ?>" /> <label
					for="voucher-<?php echo $voucher_theme['voucher_theme_id']; ?>"><?php echo $voucher_theme['name']; ?>
				</label> <?php } ?> <br /> <?php } ?> <?php if ($error_theme) { ?> <span
					class="error"><?php echo $error_theme; ?> </span> <?php } ?></td>
			</tr>
			<tr>
				<td><?php echo __('Message:', 'account/voucher'); ?></td>
				<td><textarea name="message" cols="40" rows="5">
						<?php echo $message; ?>
					</textarea></td>
			</tr>
			<tr>
				<td><span class="required">*</span> <?php echo $entry_amount; ?></td>
				<td><input type="text" name="amount" value="<?php echo $amount; ?>"
					size="5" /> <?php if ($error_amount) { ?> <span class="error"><?php echo $error_amount; ?>
				</span> <?php } ?></td>
			</tr>
		</table>
		<div class="buttons">
			<div class="right">
				<?php echo __('I understand that gift certificates are non-refundable.', 'account/voucher'); ?>
				<?php if ($agree) { ?>
				<input type="checkbox" name="agree" value="1" checked="checked" />
				<?php } else { ?>
				<input type="checkbox" name="agree" value="1" />
				<?php } ?>
				<input type="submit" value="<?php echo $button_continue; ?>"
					class="btn" />
			</div>
		</div>
	</form>
	<?php echo $content_bottom; ?>
</div>
<?php echo $footer; ?>