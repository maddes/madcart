<?php echo $header; ?>
<div id="content">
	<ul class="breadcrumb">
		<?php foreach ($breadcrumbs as $breadcrumb) { ?>
		<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?>
		</a></li>
		<?php } ?>
	</ul>
	<?php if ($error_warning) { ?>
	<div class="alert alert-error">
		<i class="icon-exclamation-sign"></i>
		<?php echo $error_warning; ?>
		<button type="button" class="close" data-dismiss="alert">&times;</button>
	</div>
	<?php } ?>
	<div class="box">
		<div class="box-heading">
			<h1>
				<i class="icon-edit"></i>
				<?php echo $heading_title; ?>
			</h1>
		</div>
		<div class="box-content">
			<form action="<?php echo $action; ?>" method="post"
				enctype="multipart/form-data" class="form-horizontal">
				<?php foreach ($languages as $language) { ?>
				<div class="control-group">
					<label class="control-label"
						for="input-bank<?php echo $language['language_id']; ?>"><span
						class="required">*</span> <?php echo $entry_bank; ?> </label>
					<div class="controls">
						<textarea
							name="bank_transfer_bank<?php echo $language['language_id']; ?>"
							cols="80" rows="10" placeholder="<?php echo $entry_bank; ?>"
							id="input-bank<?php echo $language['language_id']; ?>">
							<?php echo isset(${
								'bank_transfer_bank_' . $language['language_id']}) ? ${
'bank_transfer_bank_' . $language['language_id']} : ''; ?>
						</textarea>
						<img src="view/image/flags/<?php echo $language['image']; ?>"
							title="<?php echo $language['name']; ?>"
							style="vertical-align: top;" /><br />
						<?php if (isset(${
'error_bank_' . $language['language_id']})) { ?>
						<span class="error"><?php echo ${
							'error_bank_' . $language['language_id']}; ?>
						</span>
						<?php } ?>
					</div>
				</div>
				<?php } ?>
				<div class="control-group">
					<label class="control-label" for="input-total"><?php echo $entry_total; ?>
					</label>
					<div class="controls">
						<input type="text" name="bank_transfer_total"
							value="<?php echo $bank_transfer_total; ?>"
							placeholder="<?php echo $entry_total; ?>" id="input-total" /> <a
							data-toggle="tooltip" title="<?php echo $help_total; ?>"><i
							class="icon-info-sign"></i> </a>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="input-order-status"><?php echo $entry_order_status; ?>
					</label>
					<div class="controls">
						<select name="bank_transfer_order_status_id"
							id="input-order-status">
							<?php foreach ($order_statuses as $order_status) { ?>
							<?php if ($order_status['order_status_id'] == $bank_transfer_order_status_id) { ?>
							<option value="<?php echo $order_status['order_status_id']; ?>"
								selected="selected">
								<?php echo $order_status['name']; ?>
							</option>
							<?php } else { ?>
							<option value="<?php echo $order_status['order_status_id']; ?>">
								<?php echo $order_status['name']; ?>
							</option>
							<?php } ?>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="input-geo-zone"><?php echo $entry_geo_zone; ?>
					</label>
					<div class="controls">
						<select name="bank_transfer_geo_zone_id" id="input-geo-zone">
							<option value="0">
								<?php echo $text_all_zones; ?>
							</option>
							<?php foreach ($geo_zones as $geo_zone) { ?>
							<?php if ($geo_zone['geo_zone_id'] == $bank_transfer_geo_zone_id) { ?>
							<option value="<?php echo $geo_zone['geo_zone_id']; ?>"
								selected="selected">
								<?php echo $geo_zone['name']; ?>
							</option>
							<?php } else { ?>
							<option value="<?php echo $geo_zone['geo_zone_id']; ?>">
								<?php echo $geo_zone['name']; ?>
							</option>
							<?php } ?>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="input-status"><?php echo $entry_status; ?>
					</label>
					<div class="controls">
						<select name="bank_transfer_status" id="input-status">
							<?php if ($bank_transfer_status) { ?>
							<option value="1" selected="selected">
								<?php echo $text_enabled; ?>
							</option>
							<option value="0">
								<?php echo $text_disabled; ?>
							</option>
							<?php } else { ?>
							<option value="1">
								<?php echo $text_enabled; ?>
							</option>
							<option value="0" selected="selected">
								<?php echo $text_disabled; ?>
							</option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="input-sort-order"><?php echo $entry_sort_order; ?>
					</label>
					<div class="controls">
						<input type="text" name="bank_transfer_sort_order"
							value="<?php echo $bank_transfer_sort_order; ?>"
							placeholder="<?php echo $entry_sort_order; ?>"
							id="input-sort-order" class="input-mini" />
					</div>
				</div>
				<div class="buttons">
					<button type="submit" class="btn">
						<i class="icon-ok"></i>
						<?php echo $button_save; ?>
					</button>
					<a href="<?php echo $cancel; ?>" class="btn"><i class="icon-remove"></i>
						<?php echo $button_cancel; ?> </a>
				</div>
			</form>
		</div>
	</div>
</div>
<?php echo $footer; ?>