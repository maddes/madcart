<?php 
class ControllerCheckoutRegister extends Controller {
	public function index() {
		$this->language->load('checkout/checkout');

		$this->data['text_checkout_payment_address'] = __('text_checkout_payment_address');
		$this->data['text_your_details'] = __('text_your_details');
		$this->data['text_your_address'] = __('text_your_address');
		$this->data['text_your_password'] = __('text_your_password');
		$this->data['text_select'] = __('text_select');
		$this->data['text_none'] = __('text_none');
		$this->data['text_modify'] = __('text_modify');

		$this->data['entry_firstname'] = __('entry_firstname');
		$this->data['entry_lastname'] = __('entry_lastname');
		$this->data['entry_email'] = __('entry_email');
		$this->data['entry_telephone'] = __('entry_telephone');
		$this->data['entry_fax'] = __('entry_fax');
		$this->data['entry_company'] = __('entry_company');
		$this->data['entry_customer_group'] = __('entry_customer_group');
		$this->data['entry_address_1'] = __('entry_address_1');
		$this->data['entry_address_2'] = __('entry_address_2');
		$this->data['entry_postcode'] = __('entry_postcode');
		$this->data['entry_city'] = __('entry_city');
		$this->data['entry_country'] = __('entry_country');
		$this->data['entry_zone'] = __('entry_zone');
		$this->data['entry_newsletter'] = sprintf(__('entry_newsletter'), $this->config->get('config_name'));
		$this->data['entry_password'] = __('entry_password');
		$this->data['entry_confirm'] = __('entry_confirm');
		$this->data['entry_shipping'] = __('entry_shipping');

		$this->data['button_continue'] = __('button_continue');

		$this->data['customer_groups'] = array();

		if (is_array($this->config->get('config_customer_group_display'))) {
			$this->load->model('account/customer_group');
				
			$customer_groups = $this->model_account_customer_group->getCustomerGroups();
				
			foreach ($customer_groups  as $customer_group) {
				if (in_array($customer_group['customer_group_id'], $this->config->get('config_customer_group_display'))) {
					$this->data['customer_groups'][] = $customer_group;
				}
			}
		}

		$this->data['customer_group_id'] = $this->config->get('config_customer_group_id');

		if (isset($this->session->data['shipping_addess']['postcode'])) {
			$this->data['postcode'] = $this->session->data['shipping_addess']['postcode'];
		} else {
			$this->data['postcode'] = '';
		}

		if (isset($this->session->data['shipping_addess']['country_id'])) {
			$this->data['country_id'] = $this->session->data['shipping_addess']['country_id'];
		} else {
			$this->data['country_id'] = $this->config->get('config_country_id');
		}

		if (isset($this->session->data['shipping_addess']['zone_id'])) {
			$this->data['zone_id'] = $this->session->data['shipping_addess']['zone_id'];
		} else {
			$this->data['zone_id'] = '';
		}

		$this->load->model('localisation/country');

		$this->data['countries'] = $this->model_localisation_country->getCountries();

		if ($this->config->get('config_account_id')) {
			$this->load->model('catalog/information');
				
			$information_info = $this->model_catalog_information->getInformation($this->config->get('config_account_id'));
				
			if ($information_info) {
				$this->data['text_agree'] = sprintf(__('text_agree'), $this->url->link('information/information/info', 'information_id=' . $this->config->get('config_account_id'), 'SSL'), $information_info['title'], $information_info['title']);
			} else {
				$this->data['text_agree'] = '';
			}
		} else {
			$this->data['text_agree'] = '';
		}

		$this->data['shipping_required'] = $this->cart->hasShipping();
			
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/register.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/checkout/register.tpl';
		} else {
			$this->template = 'default/template/checkout/register.tpl';
		}

		$this->response->setOutput($this->render());
	}

	public function save() {
		$this->language->load('checkout/checkout');

		$json = array();

		// Validate if customer is already logged out.
		if ($this->customer->isLogged()) {
			$json['redirect'] = $this->url->link('checkout/checkout', '', 'SSL');
		}

		// Validate cart has products and has stock.
		if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
			$json['redirect'] = $this->url->link('checkout/cart');
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
				$json['redirect'] = $this->url->link('checkout/cart');

				break;
			}
		}

		if (!$json) {
			$this->load->model('account/customer');
				
			if ((utf8_strlen($this->request->post['firstname']) < 1) || (utf8_strlen($this->request->post['firstname']) > 32)) {
				$json['error']['firstname'] = __('error_firstname');
			}

			if ((utf8_strlen($this->request->post['lastname']) < 1) || (utf8_strlen($this->request->post['lastname']) > 32)) {
				$json['error']['lastname'] = __('error_lastname');
			}

			if ((utf8_strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['email'])) {
				$json['error']['email'] = __('error_email');
			}

			if ($this->model_account_customer->getTotalCustomersByEmail($this->request->post['email'])) {
				$json['error']['warning'] = __('error_exists');
			}
				
			if ((utf8_strlen($this->request->post['telephone']) < 3) || (utf8_strlen($this->request->post['telephone']) > 32)) {
				$json['error']['telephone'] = __('error_telephone');
			}
				
			// Customer Group
			$this->load->model('account/customer_group');

			if (isset($this->request->post['customer_group_id']) && is_array($this->config->get('config_customer_group_display')) && in_array($this->request->post['customer_group_id'], $this->config->get('config_customer_group_display'))) {
				$customer_group_id = $this->request->post['customer_group_id'];
			} else {
				$customer_group_id = $this->config->get('config_customer_group_id');
			}
				
			$customer_group = $this->model_account_customer_group->getCustomerGroup($customer_group_id);

			if ($customer_group) {
					
			}

			if ((utf8_strlen($this->request->post['address_1']) < 3) || (utf8_strlen($this->request->post['address_1']) > 128)) {
				$json['error']['address_1'] = __('error_address_1');
			}

			if ((utf8_strlen($this->request->post['city']) < 2) || (utf8_strlen($this->request->post['city']) > 128)) {
				$json['error']['city'] = __('error_city');
			}

			$this->load->model('localisation/country');
				
			$country_info = $this->model_localisation_country->getCountry($this->request->post['country_id']);
				
			if ($country_info && $country_info['postcode_required'] && (utf8_strlen($this->request->post['postcode']) < 2) || (utf8_strlen($this->request->post['postcode']) > 10)) {
				$json['error']['postcode'] = __('error_postcode');
			}

			if ($this->request->post['country_id'] == '') {
				$json['error']['country'] = __('error_country');
			}
				
			if (!isset($this->request->post['zone_id']) || $this->request->post['zone_id'] == '') {
				$json['error']['zone'] = __('error_zone');
			}

			if ((utf8_strlen($this->request->post['password']) < 4) || (utf8_strlen($this->request->post['password']) > 20)) {
				$json['error']['password'] = __('error_password');
			}

			if ($this->request->post['confirm'] != $this->request->post['password']) {
				$json['error']['confirm'] = __('error_confirm');
			}
				
			if ($this->config->get('config_account_id')) {
				$this->load->model('catalog/information');

				$information_info = $this->model_catalog_information->getInformation($this->config->get('config_account_id'));

				if ($information_info && !isset($this->request->post['agree'])) {
					$json['error']['warning'] = sprintf(__('error_agree'), $information_info['title']);
				}
			}
		}

		if (!$json) {
			$this->model_account_customer->addCustomer($this->request->post);
				
			$this->session->data['account'] = 'register';
				
			if ($customer_group && !$customer_group['approval']) {
				$this->customer->login($this->request->post['email'], $this->request->post['password']);

				// Default Payment Address
				$this->load->model('account/address');
					
				$this->session->data['payment_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());

				if (!empty($this->request->post['shipping_address'])) {
					$this->session->data['shipping_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
				}
			} else {
				$json['redirect'] = $this->url->link('account/success');
			}
				
			unset($this->session->data['guest']);
			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
			unset($this->session->data['payment_method']);
			unset($this->session->data['payment_methods']);
		}

		$this->response->setOutput(json_encode($json));
	}
}
?>