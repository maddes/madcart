<div class="box">
	<div class="box-heading">
		<?php echo __('Choose a Store', 'module/store'); ?>
	</div>
	<div class="box-content">
		<p style="text-align: center;">
			<?php echo __('Please choose the store you wish to visit.', 'module/store'); ?>
		</p>
		<?php foreach ($stores as $store) { ?>
		<?php if ($store['store_id'] == $store_id) { ?>
		<a href="<?php echo $store['url']; ?>"><b><?php echo $store['name']; ?>
		</b>
		</a><br />
		<?php } else { ?>
		<a href="<?php echo $store['url']; ?>"><?php echo $store['name']; ?>
		</a><br />
		<?php } ?>
		<?php } ?>
		<br />
	</div>
</div>
