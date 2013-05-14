<div class="box">
	<div class="box-heading">
		<?php echo __('Affiliate', 'module/affiliate'); ?>
	</div>
	<div class="box-content">
		<ul>
			<?php if (!$logged) { ?>
			<li><a href="<?php echo $login; ?>"><?php echo __('Login', 'module/affiliate'); ?>
			</a> / <a href="<?php echo $register; ?>"><?php echo __('Register', 'module/affiliate'); ?>
			</a>
			</li>
			<li><a href="<?php echo $forgotten; ?>"><?php echo __('Forgotten Password', 'module/affiliate'); ?>
			</a>
			</li>
			<?php } ?>
			<li><a href="<?php echo $account; ?>"><?php echo __('My Account', 'module/affiliate'); ?>
			</a>
			</li>
			<?php if ($logged) { ?>
			<li><a href="<?php echo $edit; ?>"><?php echo __('Edit Account', 'module/affiliate'); ?>
			</a>
			</li>
			<li><a href="<?php echo $password; ?>"><?php echo __('Password', 'module/affiliate'); ?>
			</a>
			</li>
			<?php } ?>
			<li><a href="<?php echo $payment; ?>"><?php echo __('Payment Options', 'module/affiliate'); ?>
			</a>
			</li>
			<li><a href="<?php echo $tracking; ?>"><?php echo __('Affiliate Tracking', 'module/affiliate'); ?>
			</a>
			</li>
			<li><a href="<?php echo $transaction; ?>"><?php echo __('Transactions', 'module/affiliate'); ?>
			</a>
			</li>
			<?php if ($logged) { ?>
			<li><a href="<?php echo $logout; ?>"><?php echo __('Logout', 'module/affiliate'); ?>
			</a>
			</li>
			<?php } ?>
		</ul>
	</div>
</div>
