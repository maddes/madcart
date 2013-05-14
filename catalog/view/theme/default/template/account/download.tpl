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
		<?php echo __('Account Downloads', 'account/download'); ?>
	</h1>
	<?php foreach ($downloads as $download) { ?>
	<div class="download-list">
		<div class="download-id">
			<b><?php echo __('Order ID:', 'account/download'); ?> </b>
			<?php echo $download['order_id']; ?>
		</div>
		<div class="download-status">
			<b><?php echo __('Size:', 'account/download'); ?> </b>
			<?php echo $download['size']; ?>
		</div>
		<div class="download-content">
			<div>
				<b><?php echo __('Name:', 'account/download'); ?> </b>
				<?php echo $download['name']; ?>
				<br /> <b><?php echo __('Date Added:', 'account/download'); ?> </b>
				<?php echo $download['date_added']; ?>
			</div>
			<div>
				<b><?php echo __('Remaining:', 'account/download'); ?> </b>
				<?php echo $download['remaining']; ?>
			</div>
			<div class="download-info">
				<?php if ($download['remaining'] > 0) { ?>
				<a href="<?php echo $download['href']; ?>"><img
					src="catalog/view/theme/default/image/download.png"
					alt="<?php echo $button_download; ?>"
					title="<?php echo $button_download; ?>" /> </a>
				<?php } ?>
			</div>
		</div>
	</div>
	<?php } ?>
	<div class="pagination">
		<?php echo $pagination; ?>
	</div>
	<div class="results">
		<?php echo $results; ?>
	</div>
	<div class="buttons">
		<div class="right">
			<a href="<?php echo $continue; ?>" class="btn"><?php echo $button_continue; ?>
			</a>
		</div>
	</div>
	<?php echo $content_bottom; ?>
</div>
<?php echo $footer; ?>