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
		<?php echo __('Checkout', 'checkout/checkout'); ?>
	</h1>
	<div class="checkout">
		<div id="checkout">
			<div class="checkout-heading">
				<?php echo __('Step 1: Checkout Options', 'checkout/checkout'); ?>
			</div>
			<div class="checkout-content"></div>
		</div>
		<?php if (!$logged) { ?>
		<div id="payment-address">
			<div class="checkout-heading">
				<span><?php echo __('Step 2: Account &amp; Billing Details', 'checkout/checkout'); ?>
				</span>
			</div>
			<div class="checkout-content"></div>
		</div>
		<?php } else { ?>
		<div id="payment-address">
			<div class="checkout-heading">
				<span><?php echo __('Step 2: Billing Details', 'checkout/checkout'); ?>
				</span>
			</div>
			<div class="checkout-content"></div>
		</div>
		<?php } ?>
		<?php if ($shipping_required) { ?>
		<div id="shipping-address">
			<div class="checkout-heading">
				<?php echo __('Step 3: Delivery Details', 'checkout/checkout'); ?>
			</div>
			<div class="checkout-content"></div>
		</div>
		<div id="shipping-method">
			<div class="checkout-heading">
				<?php echo __('Step 4: Delivery Method', 'checkout/checkout'); ?>
			</div>
			<div class="checkout-content"></div>
		</div>
		<?php } ?>
		<div id="payment-method">
			<div class="checkout-heading">
				<?php echo __('Step 5: Payment Method', 'checkout/checkout'); ?>
			</div>
			<div class="checkout-content"></div>
		</div>
		<div id="confirm">
			<div class="checkout-heading">
				<?php echo __('Step 6: Confirm Order', 'checkout/checkout'); ?>
			</div>
			<div class="checkout-content"></div>
		</div>
	</div>
	<?php echo $content_bottom; ?>
</div>
<script type="text/javascript"><!--
$(document).ready(function() {
	<?php if (!$logged) { ?> 
	$.ajax({
		url: 'index.php?route=checkout/login',
		dataType: 'html',
		success: function(html) {
			$('#checkout .checkout-content').html(html);
			
			$('#checkout .checkout-content').slideDown('slow');
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});	
<?php } else { ?>
	$.ajax({
		url: 'index.php?route=checkout/payment_address',
		dataType: 'html',
		success: function(html) {
			$('#payment-address .checkout-content').html(html);
				
			$('#payment-address .checkout-content').slideDown('slow');
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});	
<?php } ?>
});

$('.checkout-heading a').on('click', function() {
	$('.checkout-content').slideUp('slow');
	
	$(this).parent().parent().find('.checkout-content').slideDown('slow');
});
//--></script>
<?php echo $footer; ?>