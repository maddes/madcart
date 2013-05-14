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
		<?php echo __('Special Offers', 'product/special'); ?>
	</h1>
	<?php if ($products) { ?>
	<div class="product-filter">
		<div class="display">
			<b><?php echo __('Display:', 'product/special'); ?> </b>
			<?php echo __('List', 'product/special'); ?>
			<b>/</b> <a onclick="display('grid');"><?php echo __('Grid', 'product/special'); ?>
			</a>
		</div>
		<div class="limit">
			<?php echo __('Show:', 'product/special'); ?>
			<select onchange="location = this.value;">
				<?php foreach ($limits as $limits) { ?>
				<?php if ($limits['value'] == $limit) { ?>
				<option value="<?php echo $limits['href']; ?>" selected="selected">
					<?php echo $limits['text']; ?>
				</option>
				<?php } else { ?>
				<option value="<?php echo $limits['href']; ?>">
					<?php echo $limits['text']; ?>
				</option>
				<?php } ?>
				<?php } ?>
			</select>
		</div>
		<div class="sort">
			<?php echo __('Sort By:', 'product/special'); ?>
			<select onchange="location = this.value;">
				<?php foreach ($sorts as $sorts) { ?>
				<?php if ($sorts['value'] == $sort . '-' . $order) { ?>
				<option value="<?php echo $sorts['href']; ?>" selected="selected">
					<?php echo $sorts['text']; ?>
				</option>
				<?php } else { ?>
				<option value="<?php echo $sorts['href']; ?>">
					<?php echo $sorts['text']; ?>
				</option>
				<?php } ?>
				<?php } ?>
			</select>
		</div>
	</div>
	<div class="product-compare">
		<a href="<?php echo $compare; ?>" id="compare-total"><?php echo $text_compare; ?>
		</a>
	</div>
	<div class="product-list">
		<?php foreach ($products as $product) { ?>
		<div>
			<?php if ($product['thumb']) { ?>
			<div class="image">
				<a href="<?php echo $product['href']; ?>"><img
					src="<?php echo $product['thumb']; ?>"
					title="<?php echo $product['name']; ?>"
					alt="<?php echo $product['name']; ?>" /> </a>
			</div>
			<?php } ?>
			<div class="name">
				<a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?>
				</a>
			</div>
			<div class="description">
				<?php echo $product['description']; ?>
			</div>
			<?php if ($product['price']) { ?>
			<div class="price">
				<?php if (!$product['special']) { ?>
				<?php echo $product['price']; ?>
				<?php } else { ?>
				<span class="price-old"><?php echo $product['price']; ?> </span> <span
					class="price-new"><?php echo $product['special']; ?> </span>
				<?php } ?>
				<?php if ($product['tax']) { ?>
				<br /> <span class="price-tax"><?php echo __('Ex Tax:', 'product/special'); ?>
					<?php echo $product['tax']; ?> </span>
				<?php } ?>
			</div>
			<?php } ?>
			<?php if ($product['rating']) { ?>
			<div class="rating">
				<img
					src="catalog/view/theme/default/image/stars-<?php echo $product['rating']; ?>.png"
					alt="<?php echo $product['reviews']; ?>" />
			</div>
			<?php } ?>
			<div class="cart">
				<input type="button" value="<?php echo $button_cart; ?>"
					onclick="addToCart('<?php echo $product['product_id']; ?>');"
					class="btn" />
			</div>
			<div class="wishlist">
				<a onclick="addToWishList('<?php echo $product['product_id']; ?>');"><?php echo $button_wishlist; ?>
				</a>
			</div>
			<div class="compare">
				<a onclick="addToCompare('<?php echo $product['product_id']; ?>');"><?php echo $button_compare; ?>
				</a>
			</div>
		</div>
		<?php } ?>
	</div>
	<div class="pagination">
		<?php echo $pagination; ?>
	</div>
	<div class="results">
		<?php echo $results; ?>
	</div>
	<?php } else { ?>
	<div class="content">
		<?php echo __('There are no special offer products to list.', 'product/special'); ?>
	</div>
	<?php }?>
	<?php echo $content_bottom; ?>
</div>
<script type="text/javascript"><!--
function display(view) {
	if (view == 'list') {
		$('.product-grid').attr('class', 'product-list');
		
		$('.product-list > div').each(function(index, element) {
			html  = '<div class="right">';
			html += '  <div class="cart">' + $(element).find('.cart').html() + '</div>';
			html += '  <div class="wishlist">' + $(element).find('.wishlist').html() + '</div>';
			html += '  <div class="compare">' + $(element).find('.compare').html() + '</div>';
			html += '</div>';			
			
			html += '<div class="left">';
			
			var image = $(element).find('.image').html();
			
			if (image != null) { 
				html += '<div class="image">' + image + '</div>';
			}
			
			var price = $(element).find('.price').html();
			
			if (price != null) {
				html += '<div class="price">' + price  + '</div>';
			}
					
			html += '  <div class="name">' + $(element).find('.name').html() + '</div>';
			html += '  <div class="description">' + $(element).find('.description').html() + '</div>';
			
			var rating = $(element).find('.rating').html();
			
			if (rating != null) {
				html += '<div class="rating">' + rating + '</div>';
			}
				
			html += '</div>';
						
			$(element).html(html);
		});		
		
		$('.display').html('<b><?php echo __('Display:', 'product/special'); ?></b> <?php echo __('List', 'product/special'); ?> <b>/</b> <a onclick="display(\'grid\');"><?php echo __('Grid', 'product/special'); ?></a>');
		
		$.totalStorage('display', 'list'); 
	} else {
		$('.product-list').attr('class', 'product-grid');
		
		$('.product-grid > div').each(function(index, element) {
			html = '';
			
			var image = $(element).find('.image').html();
			
			if (image != null) {
				html += '<div class="image">' + image + '</div>';
			}
			
			html += '<div class="name">' + $(element).find('.name').html() + '</div>';
			html += '<div class="description">' + $(element).find('.description').html() + '</div>';
			
			var price = $(element).find('.price').html();
			
			if (price != null) {
				html += '<div class="price">' + price  + '</div>';
			}
						
			var rating = $(element).find('.rating').html();
			
			if (rating != null) {
				html += '<div class="rating">' + rating + '</div>';
			}
						
			html += '<div class="cart">' + $(element).find('.cart').html() + '</div>';
			html += '<div class="wishlist">' + $(element).find('.wishlist').html() + '</div>';
			html += '<div class="compare">' + $(element).find('.compare').html() + '</div>';
			
			$(element).html(html);
		});	
					
		$('.display').html('<b><?php echo __('Display:', 'product/special'); ?></b> <a onclick="display(\'list\');"><?php echo __('List', 'product/special'); ?></a> <b>/</b> <?php echo __('Grid', 'product/special'); ?>');
		
		$.totalStorage('display', 'grid');
	}
}

view = $.totalStorage('display');

if (view) {
	display(view);
} else {
	display('list');
}
//--></script>
<?php echo $footer; ?>
