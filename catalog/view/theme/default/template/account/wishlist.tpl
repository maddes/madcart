<?php echo $header; ?>
<?php if ($success) { ?>
<div class="alert alert-success">
	<?php echo $success; ?>
	<img src="catalog/view/theme/default/image/close.png" alt=""
		class="close" />
</div>
<?php } ?>
<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content">
	<?php echo $content_top; ?>
	<ul class="breadcrumb">
		<?php foreach ($breadcrumbs as $breadcrumb) { ?>
		<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?>
		</a></li>
		<?php } ?>
	</ul>
	<h1>
		<?php echo __('My Wish List', 'account/wishlist'); ?>
	</h1>
	<?php if ($products) { ?>
	<div class="wishlist-info">
		<table>
			<thead>
				<tr>
					<td class="image"><?php echo __('Image', 'account/wishlist'); ?></td>
					<td class="name"><?php echo __('Product Name', 'account/wishlist'); ?>
					</td>
					<td class="model"><?php echo __('Model', 'account/wishlist'); ?></td>
					<td class="stock"><?php echo __('Stock', 'account/wishlist'); ?></td>
					<td class="price"><?php echo __('Unit Price', 'account/wishlist'); ?>
					</td>
					<td class="action"><?php echo __('Action', 'account/wishlist'); ?>
					</td>
				</tr>
			</thead>
			<?php foreach ($products as $product) { ?>
			<tbody id="wishlist-row<?php echo $product['product_id']; ?>">
				<tr>
					<td class="image"><?php if ($product['thumb']) { ?> <a
						href="<?php echo $product['href']; ?>"><img
							src="<?php echo $product['thumb']; ?>"
							alt="<?php echo $product['name']; ?>"
							title="<?php echo $product['name']; ?>" /> </a> <?php } ?></td>
					<td class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?>
					</a></td>
					<td class="model"><?php echo $product['model']; ?></td>
					<td class="stock"><?php echo $product['stock']; ?></td>
					<td class="price"><?php if ($product['price']) { ?>
						<div class="price">
							<?php if (!$product['special']) { ?>
							<?php echo $product['price']; ?>
							<?php } else { ?>
							<s><?php echo $product['price']; ?> </s> <b><?php echo $product['special']; ?>
							</b>
							<?php } ?>
						</div> <?php } ?></td>
					<td class="action"><img
						src="catalog/view/theme/default/image/cart-add.png"
						alt="<?php echo $button_cart; ?>"
						title="<?php echo $button_cart; ?>"
						onclick="addToCart('<?php echo $product['product_id']; ?>');" />&nbsp;&nbsp;<a
						href="<?php echo $product['remove']; ?>"><img
							src="catalog/view/theme/default/image/remove.png"
							alt="<?php echo $button_remove; ?>"
							title="<?php echo $button_remove; ?>" /> </a></td>
				</tr>
			</tbody>
			<?php } ?>
		</table>
	</div>
	<div class="buttons">
		<div class="right">
			<a href="<?php echo $continue; ?>" class="btn"><?php echo $button_continue; ?>
			</a>
		</div>
	</div>
	<?php } else { ?>
	<div class="content">
		<?php echo __('Your wish list is empty.', 'account/wishlist'); ?>
	</div>
	<div class="buttons">
		<div class="right">
			<a href="<?php echo $continue; ?>" class="btn"><?php echo $button_continue; ?>
			</a>
		</div>
	</div>
	<?php } ?>
	<?php echo $content_bottom; ?>
</div>
<?php echo $footer; ?>