<?php 
class ControllerAccountRegister extends Controller {
	public function index() {
		if ($this->customer->isLogged()) {
			$this->redirect($this->url->link('account/account', '', 'SSL'));
		}

		// $this->language->load('account/register');
		$this->document->setTitle(__('heading_title','account/register'));
		$this->data['text_account_already'] = sprintf(__('text_account_already','account/register'), $this->url->link('account/login', '', 'SSL'));

		$this->document->addScript('catalog/view/javascript/jquery/colorbox/jquery.colorbox-min.js');
		$this->document->addStyle('catalog/view/javascript/jquery/colorbox/colorbox.css');

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
				'text' => __('text_home','account/register'),
				'href' => $this->url->link('common/home')
		);

		$this->data['breadcrumbs'][] = array(
				'text' => __('text_account','account/register'),
				'href' => $this->url->link('account/account', '', 'SSL')
		);

		$this->data['breadcrumbs'][] = array(
				'text' => __('text_register','account/register'),
				'href' => $this->url->link('account/register', '', 'SSL')
		);


		$this->load->model('account/customer_group');

		$this->data['customer_groups'] = array();

		if (is_array($this->config->get('config_customer_group_display'))) {
			$customer_groups = $this->model_account_customer_group->getCustomerGroups();
				
			foreach ($customer_groups as $customer_group) {
				if (in_array($customer_group['customer_group_id'], $this->config->get('config_customer_group_display'))) {
					$this->data['customer_groups'][] = $customer_group;
				}
			}
		}

		$this->data['customer_group_id'] = $this->config->get('config_customer_group_id');

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

		if ($this->config->get('config_account_id')) {
			$this->load->model('catalog/information');
				
			$information_info = $this->model_catalog_information->getInformation($this->config->get('config_account_id'));
				
			if ($information_info) {
				$this->data['text_agree'] = sprintf(__('text_agree','account/register'), $this->url->link('information/information/info', 'information_id=' . $this->config->get('config_account_id'), 'SSL'), $information_info['title'], $information_info['title']);
			} else {
				$this->data['text_agree'] = '';
			}
		} else {
			$this->data['text_agree'] = '';
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/register.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/account/register.tpl';
		} else {
			$this->template = 'default/template/account/register.tpl';
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

	public function save() {
		$this->language->load('account/register');

		$json = array();

		// Validate if customer is already logged out.
		if ($this->customer->isLogged()) {
			$json['redirect'] = $this->url->link('account/account', '', 'SSL');
		}

		if (!$json) {
			$this->load->model('account/customer');
				
			if ((utf8_strlen($this->request->post['firstname']) < 1) || (utf8_strlen($this->request->post['firstname']) > 32)) {
				$json['error']['firstname'] = __('error_firstname','account/register');
			}

			if ((utf8_strlen($this->request->post['lastname']) < 1) || (utf8_strlen($this->request->post['lastname']) > 32)) {
				$json['error']['lastname'] = __('error_lastname','account/register');
			}

			if ((utf8_strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['email'])) {
				$json['error']['email'] = __('error_email','account/register');
			}

			if ($this->model_account_customer->getTotalCustomersByEmail($this->request->post['email'])) {
				$json['error']['warning'] = __('error_exists','account/register');
			}
				
			if ((utf8_strlen($this->request->post['telephone']) < 3) || (utf8_strlen($this->request->post['telephone']) > 32)) {
				$json['error']['telephone'] = __('error_telephone','account/register');
			}
				
			if ((utf8_strlen($this->request->post['address_1']) < 3) || (utf8_strlen($this->request->post['address_1']) > 128)) {
				$json['error']['address_1'] = __('error_address_1','account/register');
			}

			if ((utf8_strlen($this->request->post['city']) < 2) || (utf8_strlen($this->request->post['city']) > 128)) {
				$json['error']['city'] = __('error_city','account/register');
			}

			$this->load->model('localisation/country');
				
			$country_info = $this->model_localisation_country->getCountry($this->request->post['country_id']);
				
			if ($country_info && $country_info['postcode_required'] && (utf8_strlen($this->request->post['postcode']) < 2) || (utf8_strlen($this->request->post['postcode']) > 10)) {
				$json['error']['postcode'] = __('error_postcode','account/register');
			}

			if ($this->request->post['country_id'] == '') {
				$json['error']['country'] = __('error_country','account/register');
			}
				
			if (!isset($this->request->post['zone_id']) || $this->request->post['zone_id'] == '') {
				$json['error']['zone'] = __('error_zone','account/register');
			}

			if ((utf8_strlen($this->request->post['password']) < 4) || (utf8_strlen($this->request->post['password']) > 20)) {
				$json['error']['password'] = __('error_password','account/register');
			}

			if ($this->request->post['confirm'] != $this->request->post['password']) {
				$json['error']['confirm'] = __('error_confirm','account/register');
			}
				
			// Custom Fields
			$this->load->model('account/custom_field');

			$custom_fields = $this->model_account_custom_field->getCustomFields('customer', $this->request->get['customer_group_id']);

			foreach ($custom_fields as $custom_field) {
				if ($custom_field['required'] && empty($this->request->post['custom_field'][$custom_field['custom_field_id']])) {
					$json['error']['custom_field'][$custom_field['custom_field_id']] = sprintf(__('error_required','account/register'), $custom_field['name']);
				}
			}
				
			if ($this->config->get('config_account_id')) {
				$this->load->model('catalog/information');

				$information_info = $this->model_catalog_information->getInformation($this->config->get('config_account_id'));

				if ($information_info && !isset($this->request->post['agree'])) {
					$json['error']['warning'] = sprintf(__('error_agree','account/register'), $information_info['title']);
				}
			}
		}

		if (!$json) {
			$this->model_account_customer->addCustomer($this->request->post);

			$this->customer->login($this->request->post['email'], $this->request->post['password']);
				
			unset($this->session->data['guest']);
				
			// Default Addresses
			$this->load->model('account/address');

			if ($this->config->get('config_tax_customer') == 'payment') {
				$this->session->data['payment_addess'] = $this->model_account_address->getAddress($this->customer->getAddressId());
			}

			if ($this->config->get('config_tax_customer') == 'shipping') {
				$this->session->data['shipping_addess'] = $this->model_account_address->getAddress($this->customer->getAddressId());
			}

			$json['redirect'] = $this->url->link('account/success');
		}

		$this->response->setOutput(json_encode($json));
	}

	public function custom_field() {
		$json = array();

		$this->data['custom_fields'] = array();

		$this->load->model('account/custom_field');
			
		$custom_fields = $this->model_account_custom_field->getCustomFields('customer', $this->request->get['customer_group_id']);
			
		foreach ($custom_fields as $custom_field) {
			$custom_field_value_data = array();
				
			foreach ($custom_field['custom_field_value'] as $option_value) {
				$custom_field_value_data[] = array(
						'custom_field_value_id' => $option_value['custom_field_value_id'],
						'name'                  => $option_value['name']
				);
			}
				
			$json[] = array(
					'custom_field_id'    => $custom_field['custom_field_id'],
					'custom_field_value' => $custom_field_value_data,
					'name'               => $custom_field['name'],
					'type'               => $custom_field['type'],
					'value'              => $custom_field['value'],
					'required'           => $custom_field['required'],
					'location'           => $custom_field['location'],
					'position'           => $custom_field['position']
			);
		}

		$this->response->setOutput(json_encode($json));
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