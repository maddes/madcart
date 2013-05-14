<?php 
class ControllerCommonHeader extends Controller {
	protected function index() {
		$this->data['title'] = $this->document->getTitle();

		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$this->data['base'] = HTTPS_SERVER;
		} else {
			$this->data['base'] = HTTP_SERVER;
		}

		$this->data['description'] = $this->document->getDescription();
		$this->data['keywords'] = $this->document->getKeywords();
		$this->data['links'] = $this->document->getLinks();
		$this->data['styles'] = $this->document->getStyles();
		$this->data['scripts'] = $this->document->getScripts();
		$this->data['lang'] = __('code');
		$this->data['direction'] = __('direction');

		$this->language->load('common/header');

		$this->data['heading_title'] = __('heading_title');

		$this->data['text_affiliate'] = __('text_affiliate');
		$this->data['text_attribute'] = __('text_attribute');
		$this->data['text_attribute_group'] = __('text_attribute_group');
		$this->data['text_backup'] = __('text_backup');
		$this->data['text_banner'] = __('text_banner');
		$this->data['text_catalog'] = __('text_catalog');
		$this->data['text_category'] = __('text_category');
		$this->data['text_confirm'] = __('text_confirm');
		$this->data['text_contact'] = __('text_contact');
		$this->data['text_country'] = __('text_country');
		$this->data['text_coupon'] = __('text_coupon');
		$this->data['text_currency'] = __('text_currency');
		$this->data['text_customer'] = __('text_customer');
		$this->data['text_customer_group'] = __('text_customer_group');
		$this->data['text_customer_field'] = __('text_customer_field');
		$this->data['text_customer_ban_ip'] = __('text_customer_ban_ip');
		$this->data['text_custom_field'] = __('text_custom_field');
		$this->data['text_sale'] = __('text_sale');
		$this->data['text_design'] = __('text_design');
		$this->data['text_documentation'] = __('text_documentation');
		$this->data['text_download'] = __('text_download');
		$this->data['text_error_log'] = __('text_error_log');
		$this->data['text_extension'] = __('text_extension');
		$this->data['text_feed'] = __('text_feed');
		$this->data['text_filter'] = __('text_filter');
		$this->data['text_front'] = __('text_front');
		$this->data['text_geo_zone'] = __('text_geo_zone');
		$this->data['text_dashboard'] = __('text_dashboard');
		$this->data['text_help'] = __('text_help');
		$this->data['text_information'] = __('text_information');
		$this->data['text_installer'] = __('text_installer');
		$this->data['text_language'] = __('text_language');
		$this->data['text_layout'] = __('text_layout');
		$this->data['text_localisation'] = __('text_localisation');
		$this->data['text_location'] = __('text_location');
		$this->data['text_logout'] = __('text_logout');
		$this->data['text_modification'] = __('text_modification');
		$this->data['text_manufacturer'] = __('text_manufacturer');
		$this->data['text_module'] = __('text_module');
		$this->data['text_option'] = __('text_option');
		$this->data['text_order'] = __('text_order');
		$this->data['text_order_status'] = __('text_order_status');
		$this->data['text_opencart'] = __('text_opencart');
		$this->data['text_payment'] = __('text_payment');
		$this->data['text_product'] = __('text_product');
		$this->data['text_profile'] = __('text_profile');
		$this->data['text_reports'] = __('text_reports');
		$this->data['text_report_sale_order'] = __('text_report_sale_order');
		$this->data['text_report_sale_tax'] = __('text_report_sale_tax');
		$this->data['text_report_sale_shipping'] = __('text_report_sale_shipping');
		$this->data['text_report_sale_return'] = __('text_report_sale_return');
		$this->data['text_report_sale_coupon'] = __('text_report_sale_coupon');
		$this->data['text_report_product_viewed'] = __('text_report_product_viewed');
		$this->data['text_report_product_purchased'] = __('text_report_product_purchased');
		$this->data['text_report_customer_online'] = __('text_report_customer_online');
		$this->data['text_report_customer_order'] = __('text_report_customer_order');
		$this->data['text_report_customer_reward'] = __('text_report_customer_reward');
		$this->data['text_report_customer_credit'] = __('text_report_customer_credit');
		$this->data['text_report_affiliate_commission'] = __('text_report_affiliate_commission');
		$this->data['text_report_sale_return'] = __('text_report_sale_return');
		$this->data['text_report_product_viewed'] = __('text_report_product_viewed');
		$this->data['text_report_customer_order'] = __('text_report_customer_order');
		$this->data['text_review'] = __('text_review');
		$this->data['text_return'] = __('text_return');
		$this->data['text_return_action'] = __('text_return_action');
		$this->data['text_return_reason'] = __('text_return_reason');
		$this->data['text_return_status'] = __('text_return_status');
		$this->data['text_support'] = __('text_support');
		$this->data['text_shipping'] = __('text_shipping');
		$this->data['text_setting'] = __('text_setting');
		$this->data['text_stock_status'] = __('text_stock_status');
		$this->data['text_system'] = __('text_system');
		$this->data['text_tax'] = __('text_tax');
		$this->data['text_tax_class'] = __('text_tax_class');
		$this->data['text_tax_rate'] = __('text_tax_rate');
		$this->data['text_total'] = __('text_total');
		$this->data['text_user'] = __('text_user');
		$this->data['text_user_group'] = __('text_user_group');
		$this->data['text_users'] = __('text_users');
		$this->data['text_voucher'] = __('text_voucher');
		$this->data['text_voucher_theme'] = __('text_voucher_theme');
		$this->data['text_weight_class'] = __('text_weight_class');
		$this->data['text_length_class'] = __('text_length_class');
		$this->data['text_zone'] = __('text_zone');

		if (!isset($this->request->get['token']) || !isset($this->session->data['token']) && ($this->request->get['token'] != $this->session->data['token'])) {
			$this->data['logged'] = false;
				
			$this->data['home'] = $this->url->link('common/home', '', 'SSL');
		} else {
			$this->data['logged'] = $this->user->isLogged();
				
			$this->data['home'] = $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['affiliate'] = $this->url->link('sale/affiliate', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['attribute'] = $this->url->link('catalog/attribute', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['attribute_group'] = $this->url->link('catalog/attribute_group', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['backup'] = $this->url->link('tool/backup', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['banner'] = $this->url->link('design/banner', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['category'] = $this->url->link('catalog/category', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['country'] = $this->url->link('localisation/country', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['contact'] = $this->url->link('sale/contact', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['coupon'] = $this->url->link('sale/coupon', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['currency'] = $this->url->link('localisation/currency', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['customer'] = $this->url->link('sale/customer', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['customer_fields'] = $this->url->link('sale/customer_field', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['customer_group'] = $this->url->link('sale/customer_group', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['customer_ban_ip'] = $this->url->link('sale/customer_ban_ip', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['custom_field'] = $this->url->link('sale/custom_field', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['download'] = $this->url->link('catalog/download', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['error_log'] = $this->url->link('tool/error_log', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['feed'] = $this->url->link('extension/feed', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['filter'] = $this->url->link('catalog/filter', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['geo_zone'] = $this->url->link('localisation/geo_zone', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['information'] = $this->url->link('catalog/information', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['installer'] = $this->url->link('extension/installer', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['language'] = $this->url->link('localisation/language', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['layout'] = $this->url->link('design/layout', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['location'] = $this->url->link('localisation/location', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['logout'] = $this->url->link('common/logout', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['modification'] = $this->url->link('extension/modification', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['manufacturer'] = $this->url->link('catalog/manufacturer', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['module'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['option'] = $this->url->link('catalog/option', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['order'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['order_status'] = $this->url->link('localisation/order_status', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['payment'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['product'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['profile'] = $this->url->link('user/user/update', 'token=' . $this->session->data['token'] . '&user_id=' . $this->user->getId(), 'SSL');
			$this->data['report_sale_order'] = $this->url->link('report/sale_order', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['report_sale_tax'] = $this->url->link('report/sale_tax', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['report_sale_shipping'] = $this->url->link('report/sale_shipping', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['report_sale_return'] = $this->url->link('report/sale_return', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['report_sale_coupon'] = $this->url->link('report/sale_coupon', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['report_product_viewed'] = $this->url->link('report/product_viewed', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['report_product_purchased'] = $this->url->link('report/product_purchased', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['report_customer_online'] = $this->url->link('report/customer_online', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['report_customer_order'] = $this->url->link('report/customer_order', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['report_customer_reward'] = $this->url->link('report/customer_reward', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['report_customer_credit'] = $this->url->link('report/customer_credit', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['report_affiliate_commission'] = $this->url->link('report/affiliate_commission', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['review'] = $this->url->link('catalog/review', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['return'] = $this->url->link('sale/return', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['return_action'] = $this->url->link('localisation/return_action', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['return_reason'] = $this->url->link('localisation/return_reason', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['return_status'] = $this->url->link('localisation/return_status', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['shipping'] = $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['setting'] = $this->url->link('setting/store', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['store'] = HTTP_CATALOG;
			$this->data['stock_status'] = $this->url->link('localisation/stock_status', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['tax_class'] = $this->url->link('localisation/tax_class', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['tax_rate'] = $this->url->link('localisation/tax_rate', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['total'] = $this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['user'] = $this->url->link('user/user', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['user_group'] = $this->url->link('user/user_permission', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['voucher'] = $this->url->link('sale/voucher', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['voucher_theme'] = $this->url->link('sale/voucher_theme', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['weight_class'] = $this->url->link('localisation/weight_class', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['length_class'] = $this->url->link('localisation/length_class', 'token=' . $this->session->data['token'], 'SSL');
			$this->data['zone'] = $this->url->link('localisation/zone', 'token=' . $this->session->data['token'], 'SSL');
				
			$this->data['stores'] = array();
				
			$this->load->model('setting/store');
				
			$results = $this->model_setting_store->getStores();
				
			foreach ($results as $result) {
				$this->data['stores'][] = array(
						'name' => $result['name'],
						'href' => $result['url']
				);
			}
		}

		$this->template = 'common/header.tpl';

		$this->render();
	}
}
?>