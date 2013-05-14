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
		<?php echo __('Site Map', 'information/sitemap'); ?>
	</h1>
	<div class="sitemap-info">
		<div class="left">
			<ul>
				<?php foreach ($categories as $category_1) { ?>
				<li><a href="<?php echo $category_1['href']; ?>"><?php echo $category_1['name']; ?>
				</a> <?php if ($category_1['children']) { ?>
					<ul>
						<?php foreach ($category_1['children'] as $category_2) { ?>
						<li><a href="<?php echo $category_2['href']; ?>"><?php echo $category_2['name']; ?>
						</a> <?php if ($category_2['children']) { ?>
							<ul>
								<?php foreach ($category_2['children'] as $category_3) { ?>
								<li><a href="<?php echo $category_3['href']; ?>"><?php echo $category_3['name']; ?>
								</a></li>
								<?php } ?>
							</ul> <?php } ?>
						</li>
						<?php } ?>
					</ul> <?php } ?>
				</li>
				<?php } ?>
			</ul>
		</div>
		<div class="right">
			<ul>
				<li><a href="<?php echo $special; ?>"><?php echo __('Special Offers', 'information/sitemap'); ?>
				</a></li>
				<li><a href="<?php echo $account; ?>"><?php echo __('My Account', 'information/sitemap'); ?>
				</a>
					<ul>
						<li><a href="<?php echo $edit; ?>"><?php echo __('Account Information', 'information/sitemap'); ?>
						</a></li>
						<li><a href="<?php echo $password; ?>"><?php echo __('Password', 'information/sitemap'); ?>
						</a></li>
						<li><a href="<?php echo $address; ?>"><?php echo __('Address Book', 'information/sitemap'); ?>
						</a></li>
						<li><a href="<?php echo $history; ?>"><?php echo __('Order History', 'information/sitemap'); ?>
						</a></li>
						<li><a href="<?php echo $download; ?>"><?php echo __('Downloads', 'information/sitemap'); ?>
						</a></li>
					</ul>
				</li>
				<li><a href="<?php echo $cart; ?>"><?php echo __('Shopping Cart', 'information/sitemap'); ?>
				</a></li>
				<li><a href="<?php echo $checkout; ?>"><?php echo __('Checkout', 'information/sitemap'); ?>
				</a></li>
				<li><a href="<?php echo $search; ?>"><?php echo __('Search', 'information/sitemap'); ?>
				</a></li>
				<li><?php echo __('Information', 'information/sitemap'); ?>
					<ul>
						<?php foreach ($informations as $information) { ?>
						<li><a href="<?php echo $information['href']; ?>"><?php echo $information['title']; ?>
						</a></li>
						<?php } ?>
						<li><a href="<?php echo $contact; ?>"><?php echo __('Contact Us', 'information/sitemap'); ?>
						</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
	<?php echo $content_bottom; ?>
</div>
<?php echo $footer; ?>