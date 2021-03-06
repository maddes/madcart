<?php
class ControllerCheckoutCheckout extends Controller {
	public function index() {
		// Validate cart has products and has stock.
		if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
			$this->redirect($this->url->link('checkout/cart'));
		}

		// Validate minimum quantity requirments.
		$products = $this->cart->getProducts();

		foreach ($products as $product) {
			$product_total = 0;

			foreach ($products as $product_2) {
				if ($product_2['product_id'] == $product['product_id']) {
					$product_total += $product_2['quantity'];
				}
			}
				
			if ($product['minimum'] > $product_total) {
				$this->redirect($this->url->link('checkout/cart'));
			}
		}

		$this->language->load('checkout/checkout');

		$this->document->setTitle(__('Checkout','checkout/checkout'));

		$this->document->addScript('catalog/view/javascript/jquery/colorbox/jquery.colorbox-min.js');
		$this->document->addStyle('catalog/view/javascript/jquery/colorbox/colorbox.css');
			
		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
				'text' => __('text_home'),
				'href' => $this->url->link('common/home')
		);

		$this->data['breadcrumbs'][] = array(
				'text' => __('Shopping Cart','checkout/checkout'),
				'href' => $this->url->link('checkout/cart')
		);

		$this->data['breadcrumbs'][] = array(
				'text' => __('Checkout','checkout/checkout'),
				'href' => $this->url->link('checkout/checkout', '', 'SSL')
		);
			
		$this->data['heading_title'] = __('Checkout','checkout/checkout');

		$this->data['text_checkout_option'] = __('Step 1: Checkout Options','checkout/checkout');
		$this->data['text_checkout_account'] = __('Step 2: Account &amp; Billing Details','checkout/checkout');
		$this->data['text_checkout_payment_address'] = __('Step 2: Billing Details','checkout/checkout');
		$this->data['text_checkout_shipping_address'] = __('Step 3: Delivery Details','checkout/checkout');
		$this->data['text_checkout_shipping_method'] = __('Step 4: Delivery Method','checkout/checkout');
		$this->data['text_checkout_payment_method'] = __('Step 5: Payment Method','checkout/checkout');
		$this->data['text_checkout_confirm'] = __('Step 6: Confirm Order','checkout/checkout');

		$this->data['logged'] = $this->customer->isLogged();
		$this->data['shipping_required'] = $this->cart->hasShipping();

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/checkout.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/checkout/checkout.tpl';
		} else {
			$this->template = 'default/template/checkout/checkout.tpl';
		}

		$this->children = array(
				'common/column_left',
				'common/column_right',
				'common/content_top',
				'common/content_bottom',
				'common/footer',
				'common/header'
		);

		$this->response->setOutput($this->render());
	}

	public function country() {
		$json = array();

		$this->load->model('localisation/country');

		$country_info = $this->model_localisation_country->getCountry($this->request->get['country_id']);

		if ($country_info) {
			$this->load->model('localisation/zone');

			$json = array(
					'country_id'        => $country_info['country_id'],
					'name'              => $country_info['name'],
					'iso_code_2'        => $country_info['iso_code_2'],
					'iso_code_3'        => $country_info['iso_code_3'],
					'address_format'    => $country_info['address_format'],
					'postcode_required' => $country_info['postcode_required'],
					'zone'              => $this->model_localisation_zone->getZonesByCountryId($this->request->get['country_id']),
					'status'            => $country_info['status']
			);
		}

		$this->response->setOutput(json_encode($json));
	}
}
?>