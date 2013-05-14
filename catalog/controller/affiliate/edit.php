<?php
class ControllerAffiliateEdit extends Controller {
	private $error = array();

	public function index() {
		if (!$this->affiliate->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('affiliate/edit', '', 'SSL');

			$this->redirect($this->url->link('affiliate/login', '', 'SSL'));
		}

		$this->language->load('affiliate/edit');

		$this->document->setTitle(__('My Account Information','affiliate/edit'));

		$this->load->model('affiliate/affiliate');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_affiliate_affiliate->editAffiliate($this->request->post);
				
			$this->session->data['success'] = __('Success: Your account has been successfully updated.','affiliate/edit');

			$this->redirect($this->url->link('affiliate/account', '', 'SSL'));
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
				'text' => __('text_home'),
				'href' => $this->url->link('common/home')
		);

		$this->data['breadcrumbs'][] = array(
				'text' => __('Account','affiliate/edit'),
				'href' => $this->url->link('affiliate/account', '', 'SSL')
		);

		$this->data['breadcrumbs'][] = array(
				'text' => __('Edit Information','affiliate/edit'),
				'href' => $this->url->link('affiliate/edit', '', 'SSL')
		);

		$this->data['heading_title'] = __('My Account Information','affiliate/edit');

		$this->data['text_select'] = __('text_select');
		$this->data['text_none'] = __('text_none');
		$this->data['text_your_details'] = __('Your Personal Details','affiliate/edit');
		$this->data['text_your_address'] = __('Your Address','affiliate/edit');

		$this->data['entry_firstname'] = __('First Name:','affiliate/edit');
		$this->data['entry_lastname'] = __('Last Name:','affiliate/edit');
		$this->data['entry_email'] = __('E-Mail:','affiliate/edit');
		$this->data['entry_telephone'] = __('Telephone:','affiliate/edit');
		$this->data['entry_fax'] = __('Fax:','affiliate/edit');
		$this->data['entry_company'] = __('Company:','affiliate/edit');
		$this->data['entry_website'] = __('Web Site:','affiliate/edit');
		$this->data['entry_address_1'] = __('Address 1:','affiliate/edit');
		$this->data['entry_address_2'] = __('Address 2:','affiliate/edit');
		$this->data['entry_postcode'] = __('Post Code:','affiliate/edit');
		$this->data['entry_city'] = __('City:','affiliate/edit');
		$this->data['entry_country'] = __('Country:','affiliate/edit');
		$this->data['entry_zone'] = __('Region / State:','affiliate/edit');

		$this->data['button_continue'] = __('button_continue');
		$this->data['button_back'] = __('button_back');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['firstname'])) {
			$this->data['error_firstname'] = $this->error['firstname'];
		} else {
			$this->data['error_firstname'] = '';
		}

		if (isset($this->error['lastname'])) {
			$this->data['error_lastname'] = $this->error['lastname'];
		} else {
			$this->data['error_lastname'] = '';
		}

		if (isset($this->error['email'])) {
			$this->data['error_email'] = $this->error['email'];
		} else {
			$this->data['error_email'] = '';
		}

		if (isset($this->error['telephone'])) {
			$this->data['error_telephone'] = $this->error['telephone'];
		} else {
			$this->data['error_telephone'] = '';
		}
		if (isset($this->error['address_1'])) {
			$this->data['error_address_1'] = $this->error['address_1'];
		} else {
			$this->data['error_address_1'] = '';
		}
		 
		if (isset($this->error['city'])) {
			$this->data['error_city'] = $this->error['city'];
		} else {
			$this->data['error_city'] = '';
		}

		if (isset($this->error['postcode'])) {
			$this->data['error_postcode'] = $this->error['postcode'];
		} else {
			$this->data['error_postcode'] = '';
		}

		if (isset($this->error['country'])) {
			$this->data['error_country'] = $this->error['country'];
		} else {
			$this->data['error_country'] = '';
		}

		if (isset($this->error['zone'])) {
			$this->data['error_zone'] = $this->error['zone'];
		} else {
			$this->data['error_zone'] = '';
		}

		$this->data['action'] = $this->url->link('affiliate/edit', '', 'SSL');

		if ($this->request->server['REQUEST_METHOD'] != 'POST') {
			$affiliate_info = $this->model_affiliate_affiliate->getAffiliate($this->affiliate->getId());
		}

		if (isset($this->request->post['firstname'])) {
			$this->data['firstname'] = $this->request->post['firstname'];
		} elseif (!empty($affiliate_info)) {
			$this->data['firstname'] = $affiliate_info['firstname'];
		} else {
			$this->data['firstname'] = '';
		}

		if (isset($this->request->post['lastname'])) {
			$this->data['lastname'] = $this->request->post['lastname'];
		} elseif (!empty($affiliate_info)) {
			$this->data['lastname'] = $affiliate_info['lastname'];
		} else {
			$this->data['lastname'] = '';
		}

		if (isset($this->request->post['email'])) {
			$this->data['email'] = $this->request->post['email'];
		} elseif (!empty($affiliate_info)) {
			$this->data['email'] = $affiliate_info['email'];
		} else {
			$this->data['email'] = '';
		}

		if (isset($this->request->post['telephone'])) {
			$this->data['telephone'] = $this->request->post['telephone'];
		} elseif (!empty($affiliate_info)) {
			$this->data['telephone'] = $affiliate_info['telephone'];
		} else {
			$this->data['telephone'] = '';
		}

		if (isset($this->request->post['fax'])) {
			$this->data['fax'] = $this->request->post['fax'];
		} elseif (!empty($affiliate_info)) {
			$this->data['fax'] = $affiliate_info['fax'];
		} else {
			$this->data['fax'] = '';
		}

		if (isset($this->request->post['company'])) {
			$this->data['company'] = $this->request->post['company'];
		} elseif (!empty($affiliate_info)) {
			$this->data['company'] = $affiliate_info['company'];
		} else {
			$this->data['company'] = '';
		}

		if (isset($this->request->post['website'])) {
			$this->data['website'] = $this->request->post['website'];
		} elseif (!empty($affiliate_info)) {
			$this->data['website'] = $affiliate_info['website'];
		} else {
			$this->data['website'] = '';
		}

		if (isset($this->request->post['address_1'])) {
			$this->data['address_1'] = $this->request->post['address_1'];
		} elseif (!empty($affiliate_info)) {
			$this->data['address_1'] = $affiliate_info['address_1'];
		} else {
			$this->data['address_1'] = '';
		}

		if (isset($this->request->post['address_2'])) {
			$this->data['address_2'] = $this->request->post['address_2'];
		} elseif (!empty($affiliate_info)) {
			$this->data['address_2'] = $affiliate_info['address_2'];
		} else {
			$this->data['address_2'] = '';
		}

		if (isset($this->request->post['postcode'])) {
			$this->data['postcode'] = $this->request->post['postcode'];
		} elseif (!empty($affiliate_info)) {
			$this->data['postcode'] = $affiliate_info['postcode'];
		} else {
			$this->data['postcode'] = '';
		}

		if (isset($this->request->post['city'])) {
			$this->data['city'] = $this->request->post['city'];
		} elseif (!empty($affiliate_info)) {
			$this->data['city'] = $affiliate_info['city'];
		} else {
			$this->data['city'] = '';
		}

		if (isset($this->request->post['country_id'])) {
			$this->data['country_id'] = $this->request->post['country_id'];
		} elseif (!empty($affiliate_info)) {
			$this->data['country_id'] = $affiliate_info['country_id'];
		} else {
			$this->data['country_id'] = $this->config->get('config_country_id');
		}

		if (isset($this->request->post['zone_id'])) {
			$this->data['zone_id'] = $this->request->post['zone_id'];
		} elseif (!empty($affiliate_info)) {
			$this->data['zone_id'] = $affiliate_info['zone_id'];
		} else {
			$this->data['zone_id'] = '';
		}

		$this->load->model('localisation/country');

		$this->data['countries'] = $this->model_localisation_country->getCountries();

		$this->data['back'] = $this->url->link('affiliate/account', '', 'SSL');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/affiliate/edit.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/affiliate/edit.tpl';
		} else {
			$this->template = 'default/template/affiliate/edit.tpl';
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

	protected function validate() {
		if ((utf8_strlen($this->request->post['firstname']) < 1) || (utf8_strlen($this->request->post['firstname']) > 32)) {
			$this->error['firstname'] = __('First Name must be between 1 and 32 characters!','affiliate/edit');
		}

		if ((utf8_strlen($this->request->post['lastname']) < 1) || (utf8_strlen($this->request->post['lastname']) > 32)) {
			$this->error['lastname'] = __('Last Name must be between 1 and 32 characters!','affiliate/edit');
		}

		if ((utf8_strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['email'])) {
			$this->error['email'] = __('E-Mail Address does not appear to be valid!','affiliate/edit');
		}

		if (($this->affiliate->getEmail() != $this->request->post['email']) && $this->model_affiliate_affiliate->getTotalAffiliatesByEmail($this->request->post['email'])) {
			$this->error['warning'] = __('Warning: E-Mail address is already registered!','affiliate/edit');
		}

		if ((utf8_strlen($this->request->post['telephone']) < 3) || (utf8_strlen($this->request->post['telephone']) > 32)) {
			$this->error['telephone'] = __('Telephone must be between 3 and 32 characters!','affiliate/edit');
		}
		if ((utf8_strlen($this->request->post['address_1']) < 3) || (utf8_strlen($this->request->post['address_1']) > 128)) {
			$this->error['address_1'] = __('Address 1 must be between 3 and 128 characters!','affiliate/edit');
		}

		if ((utf8_strlen($this->request->post['city']) < 2) || (utf8_strlen($this->request->post['city']) > 128)) {
			$this->error['city'] = __('City must be between 2 and 128 characters!','affiliate/edit');
		}

		$this->load->model('localisation/country');

		$country_info = $this->model_localisation_country->getCountry($this->request->post['country_id']);

		if ($country_info && $country_info['postcode_required'] && (utf8_strlen($this->request->post['postcode']) < 2) || (utf8_strlen($this->request->post['postcode']) > 10)) {
			$this->error['postcode'] = __('Postcode must be between 2 and 10 characters!','affiliate/edit');
		}

		if ($this->request->post['country_id'] == '') {
			$this->error['country'] = __('Please select a country!','affiliate/edit');
		}

		if (!isset($this->request->post['zone_id']) || $this->request->post['zone_id'] == '') {
			$this->error['zone'] = __('Please select a region / state!','affiliate/edit');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
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