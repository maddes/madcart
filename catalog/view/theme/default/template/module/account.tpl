<div class="box">
	<div class="box-heading">
		<?php echo __('Account', 'module/account'); ?>
	</div>
	<div class="box-content">
		<ul>
			<?php if (!$logged) { ?>
			<li><a href="<?php echo $login; ?>"><?php echo __('Login', 'module/account'); ?>
			</a> / <a href="<?php echo $register; ?>"><?php echo __('Register', 'module/account'); ?>
			</a>
			</li>
			<li><a href="<?php echo $forgotten; ?>"><?php echo __('Forgotten Password', 'module/account'); ?>
			</a>
			</li>
			<?php } ?>
			<li><a href="<?php echo $account; ?>"><?php echo __('My Account', 'module/account'); ?>
			</a>
			</li>
			<?php if ($logged) { ?>
			<li><a href="<?php echo $edit; ?>"><?php echo __('Edit Account', 'module/account'); ?>
			</a>
			</li>
			<li><a href="<?php echo $password; ?>"><?php echo __('Password', 'module/account'); ?>
			</a>
			</li>
			<?php } ?>
			<li><a href="<?php echo $address; ?>"><?php echo __('Address Books', 'module/account'); ?>
			</a>
			</li>
			<li><a href="<?php echo $wishlist; ?>"><?php echo __('Wish List', 'module/account'); ?>
			</a>
			</li>
			<li><a href="<?php echo $order; ?>"><?php echo __('Order History', 'module/account'); ?>
			</a>
			</li>
			<li><a href="<?php echo $download; ?>"><?php echo __('Downloads', 'module/account'); ?>
			</a>
			</li>
			<li><a href="<?php echo $return; ?>"><?php echo __('Returns', 'module/account'); ?>
			</a>
			</li>
			<li><a href="<?php echo $transaction; ?>"><?php echo __('Transactions', 'module/account'); ?>
			</a>
			</li>
			<li><a href="<?php echo $newsletter; ?>"><?php echo __('Newsletter', 'module/account'); ?>
			</a>
			</li>
			<?php if ($logged) { ?>
			<li><a href="<?php echo $logout; ?>"><?php echo __('Logout', 'module/account'); ?>
			</a>
			</li>
			<?php } ?>
		</ul>
	</div>
</div>
