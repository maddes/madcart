<div class="box">
	<div class="box-heading">
		<?php echo __('Information', 'module/information'); ?>
	</div>
	<div class="box-content">
		<ul>
			<?php foreach ($informations as $information) { ?>
			<li><a href="<?php echo $information['href']; ?>"><?php echo $information['title']; ?>
			</a>
			</li>
			<?php } ?>
			<li><a href="<?php echo $contact; ?>"><?php echo __('Contact Us', 'module/information'); ?>
			</a>
			</li>
			<li><a href="<?php echo $sitemap; ?>"><?php echo __('Site Map', 'module/information'); ?>
			</a>
			</li>
		</ul>
	</div>
</div>
