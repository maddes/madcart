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
		<?php echo __('The page you requested cannot be found!', 'error/not_found'); ?>
	</h1>
	<div class="content">
		<?php echo __('The page you requested cannot be found.', 'error/not_found'); ?>
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