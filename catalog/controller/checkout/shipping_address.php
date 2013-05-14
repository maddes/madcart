<?php 
class ControllerCheckoutShippingAddress extends Controller {
	public function index() {
		$this->language->load('checkout/checkout');
		
		$this->data['text_address_existing'] = __('text_address_existing');
		$this->data['text_address_new'] = __('text_address_new');
		$this->data['text_select'] = __('text_select');
		$this->data['text_none'] = __('text_none');
		$this->data['text_modify'] = __('text_modify');

		$this->data['entry_firstname'] = __('entry_firstname');
		$this->data['entry_lastname'] = __('entry_lastname');
		$this->data['entry_company'] = __('entry_company');
		$this->data['entry_address_1'] = __('entry_address_1');
		$this->data['entry_address_2'] = __('entry_address_2');
		$this->data['entry_postcode'] = __('entry_postcode');
		$this->data['entry_city'] = __('entry_city');
		$this->data['entry_country'] = __('entry_country');
		$this->data['entry_zone'] = __('entry_zone');
	
		$this->data['button_continue'] = __('button_continue');
			
		if (isset($this->session->data['shipping_address']['address_id'])) {
			$this->data['address_id'] = $this->session->data['shipping_address']['address_id'];
		} else {
			$this->data['address_id'] = $this->customer->getAddressId();
		}

		$this->load->model('account/address');

		$this->data['addresses'] = $this->model_account_address->getAddresses();

		if (isset($this->session->data['shipping_address']['postcode'])) {
			$this->data['postcode'] = $this->session->data['shipping_address']['postcode'];		
		} else {
			$this->data['postcode'] = '';
		}
				
		if (isset($this->session->data['shipping_address']['country_id'])) {
			$this->data['country_id'] = $this->session->data['shipping_address']['country_id'];		
		} else {
			$this->data['country_id'] = $this->config->get('config_country_id');
		}
				
		if (isset($this->session->data['shipping_address']['zone_id'])) {
			$this->data['zone_id'] = $this->session->data['shipping_address']['zone_id'];		
		} else {
			$this->data['zone_id'] = '';
		}
						
		$this->load->model('localisation/country');
		
		$this->data['countries'] = $this->model_localisation_country->getCountries();

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/shipping_address.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/checkout/shipping_address.tpl';
		} else {
			$this->template = 'default/template/checkout/shipping_address.tpl';
		}
				
		$this->response->setOutput($this->render());
  	}	
	
	public function save() {
		$this->language->load('checkout/checkout');
		
		$json = array();
		
		// Validate if customer is logged in.
		if (!$this->customer->isLogged()) {
			$json['redirect'] = $this->url->link('checkout/checkout', '', 'SSL');
		}
		
		// Validate if shipping is required. If not the customer should not have reached this page.
		if (!$this->cart->hasShipping()) {
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
			if (isset($this->request->post['shipping_address']) && $this->request->post['shipping_address'] == 'existing') {
				$this->load->model('account/address');
				
				if (empty($this->request->post['address_id'])) {
					$json['error']['warning'] = __('error_address');
				} elseif (!in_array($this->request->post['address_id'], array_keys($this->model_account_address->getAddresses()))) {
					$json['error']['warning'] = __('error_address');
				}
						
				if (!$json) {			
					// Default Shipping Address
					$this->load->model('account/address');

					$this->session->data['shipping_address'] = $this->model_account_address->getAddress($this->request->post['address_id']);
										
					unset($this->session->data['shipping_method']);							
					unset($this->session->data['shipping_methods']);
				}
			} else {
				if ((utf8_strlen($this->request->post['firstname']) < 1) || (utf8_strlen($this->request->post['firstname']) > 32)) {
					$json['error']['firstname'] = __('error_firstname');
				}
		
				if ((utf8_strlen($this->request->post['lastname']) < 1) || (utf8_strlen($this->request->post['lastname']) > 32)) {
					$json['error']['lastname'] = __('error_lastname');
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
				
				if (!$json) {						
					// Default Shipping Address
					$this->load->model('account/address');		
					
					$address_id = $this->model_account_address->addAddress($this->request->post);
					
					$this->session->data['shipping_address'] = $this->model_account_address->getAddress($address_id);
									
					unset($this->session->data['shipping_method']);						
					unset($this->session->data['shipping_methods']);
				}
			}
		}
		
		$this->response->setOutput(json_encode($json));
	}
}
?>