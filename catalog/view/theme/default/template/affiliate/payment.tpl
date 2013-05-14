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
		<?php echo __('Payment Method', 'affiliate/payment'); ?>
	</h1>
	<form action="<?php echo $action; ?>" method="post"
		enctype="multipart/form-data">
		<h2>
			<?php echo __('Payment Information', 'affiliate/payment'); ?>
		</h2>
		<div class="content">
			<table class="form">
				<tbody>
					<tr>
						<td><?php echo __('Tax ID:', 'affiliate/payment'); ?></td>
						<td><input type="text" name="tax" value="<?php echo $tax; ?>" /></td>
					</tr>
					<tr>
						<td><?php echo __('Payment Method:', 'affiliate/payment'); ?></td>
						<td><?php if ($payment == 'cheque') { ?> <input type="radio"
							name="payment" value="cheque" id="cheque" checked="checked" /> <?php } else { ?>
							<input type="radio" name="payment" value="cheque" id="cheque" />
							<?php } ?> <label for="cheque"><?php echo __('Cheque', 'affiliate/payment'); ?>
						</label> <?php if ($payment == 'paypal') { ?> <input type="radio"
							name="payment" value="paypal" id="paypal" checked="checked" /> <?php } else { ?>
							<input type="radio" name="payment" value="paypal" id="paypal" />
							<?php } ?> <label for="paypal"><?php echo __('PayPal', 'affiliate/payment'); ?>
						</label> <?php if ($payment == 'bank') { ?> <input type="radio"
							name="payment" value="bank" id="bank" checked="checked" /> <?php } else { ?>
							<input type="radio" name="payment" value="bank" id="bank" /> <?php } ?>
							<label for="bank"><?php echo __('Bank Transfer', 'affiliate/payment'); ?>
						</label></td>
					</tr>
				</tbody>
				<tbody id="payment-cheque" class="payment">
					<tr>
						<td><?php echo __('Cheque Payee Name:', 'affiliate/payment'); ?></td>
						<td><input type="text" name="cheque"
							value="<?php echo $cheque; ?>" /></td>
					</tr>
				</tbody>
				<tbody class="payment" id="payment-paypal">
					<tr>
						<td><?php echo __('PayPal Email Account:', 'affiliate/payment'); ?>
						</td>
						<td><input type="text" name="paypal"
							value="<?php echo $paypal; ?>" /></td>
					</tr>
				</tbody>
				<tbody id="payment-bank" class="payment">
					<tr>
						<td><?php echo __('Bank Name:', 'affiliate/payment'); ?></td>
						<td><input type="text" name="bank_name"
							value="<?php echo $bank_name; ?>" /></td>
					</tr>
					<tr>
						<td><?php echo __('ABA/BSB number (Branch Number):', 'affiliate/payment'); ?>
						</td>
						<td><input type="text" name="bank_branch_number"
							value="<?php echo $bank_branch_number; ?>" /></td>
					</tr>
					<tr>
						<td><?php echo __('SWIFT Code:', 'affiliate/payment'); ?></td>
						<td><input type="text" name="bank_swift_code"
							value="<?php echo $bank_swift_code; ?>" /></td>
					</tr>
					<tr>
						<td><?php echo __('Account Name:', 'affiliate/payment'); ?></td>
						<td><input type="text" name="bank_account_name"
							value="<?php echo $bank_account_name; ?>" /></td>
					</tr>
					<tr>
						<td><?php echo __('Account Number:', 'affiliate/payment'); ?></td>
						<td><input type="text" name="bank_account_number"
							value="<?php echo $bank_account_number; ?>" /></td>
					</tr>
				</tbody>
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
<script type="text/javascript"><!--
$('input[name=\'payment\']').on('change', function() {
	$('.payment').hide();
	
	$('#payment-' + this.value).show();
});

$('input[name=\'payment\']:checked').trigger('change');
//--></script>
<?php echo $footer; ?>
