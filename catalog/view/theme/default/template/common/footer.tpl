<div id="footer">
	<?php if ($informations) { ?>
	<div class="column">
		<h3>
			<?php echo __('Information', 'common/footer'); ?>
		</h3>
		<ul>
			<?php foreach ($informations as $information) { ?>
			<li><a href="<?php echo $information['href']; ?>"><?php echo $information['title']; ?>
			</a>
			</li>
			<?php } ?>
		</ul>
	</div>
	<?php } ?>
	<div class="column">
		<h3>
			<?php echo __('Customer Service', 'common/footer'); ?>
		</h3>
		<ul>
			<li><a href="<?php echo $contact; ?>"><?php echo __('Contact Us', 'common/footer'); ?>
			</a>
			</li>
			<li><a href="<?php echo $return; ?>"><?php echo __('Returns', 'common/footer'); ?>
			</a>
			</li>
			<li><a href="<?php echo $sitemap; ?>"><?php echo __('Site Map', 'common/footer'); ?>
			</a>
			</li>
		</ul>
	</div>
	<div class="column">
		<h3>
			<?php echo __('Extras', 'common/footer'); ?>
		</h3>
		<ul>
			<li><a href="<?php echo $manufacturer; ?>"><?php echo __('Brands', 'common/footer'); ?>
			</a>
			</li>
			<li><a href="<?php echo $voucher; ?>"><?php echo __('Gift Vouchers', 'common/footer'); ?>
			</a>
			</li>
			<li><a href="<?php echo $affiliate; ?>"><?php echo __('Affiliates', 'common/footer'); ?>
			</a>
			</li>
			<li><a href="<?php echo $special; ?>"><?php echo __('Specials', 'common/footer'); ?>
			</a>
			</li>
		</ul>
	</div>
	<div class="column">
		<h3>
			<?php echo __('My Account', 'common/footer'); ?>
		</h3>
		<ul>
			<li><a href="<?php echo $account; ?>"><?php echo __('My Account', 'common/footer'); ?>
			</a>
			</li>
			<li><a href="<?php echo $order; ?>"><?php echo __('Order History', 'common/footer'); ?>
			</a>
			</li>
			<li><a href="<?php echo $wishlist; ?>"><?php echo __('Wish List', 'common/footer'); ?>
			</a>
			</li>
			<li><a href="<?php echo $newsletter; ?>"><?php echo __('Newsletter', 'common/footer'); ?>
			</a>
			</li>
		</ul>
	</div>
</div>
<!--
OpenCart is open source software and you are free to remove the powered by OpenCart if you want, but its generally accepted practise to make a small donation.
Please donate via PayPal to donate@opencart.com
//-->
<div id="powered">
	<?php echo $powered; ?>
</div>
<!--
OpenCart is open source software and you are free to remove the powered by OpenCart if you want, but its generally accepted practise to make a small donation.
Please donate via PayPal to donate@opencart.com
//-->
</div>
</body>
</html>
