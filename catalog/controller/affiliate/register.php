<?php 
class ControllerAffiliateRegister extends Controller {
	private $error = array();
	      
  	public function index() {
		if ($this->affiliate->isLogged()) {
	  		$this->redirect($this->url->link('affiliate/account', '', 'SSL'));
    	}

    	$this->language->load('affiliate/register');
		
		$this->document->setTitle(__('heading_title'));
		$this->document->addScript('catalog/view/javascript/jquery/colorbox/jquery.colorbox-min.js');
		$this->document->addStyle('catalog/view/javascript/jquery/colorbox/colorbox.css');
					
		$this->load->model('affiliate/affiliate');
		
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_affiliate_affiliate->addAffiliate($this->request->post);

			$this->affiliate->login($this->request->post['email'], $this->request->post['password']);

	  		$this->redirect($this->url->link('affiliate/success'));
    	} 

      	$this->data['breadcrumbs'] = array();

      	$this->data['breadcrumbs'][] = array(
        	'text' => __('text_home'),
			'href' => $this->url->link('common/home')
      	); 

      	$this->data['breadcrumbs'][] = array(
        	'text' => __('text_account'),
			'href' => $this->url->link('affiliate/account', '', 'SSL')
      	);
		
      	$this->data['breadcrumbs'][] = array(
        	'text' => __('text_register'),
			'href' => $this->url->link('affiliate/register', '', 'SSL')
      	);
		
    	$this->data['heading_title'] = __('heading_title');

		$this->data['text_select'] = __('text_select');
		$this->data['text_none'] = __('text_none');
		$this->data['text_account_already'] = sprintf(__('text_account_already'), $this->url->link('affiliate/login', '', 'SSL'));
    	$this->data['text_signup'] = __('text_signup');
		$this->data['text_your_details'] = __('text_your_details');
    	$this->data['text_your_address'] = __('text_your_address');
		$this->data['text_payment'] = __('text_payment');
    	$this->data['text_your_password'] = __('text_your_password');
		$this->data['text_cheque'] = __('text_cheque');
		$this->data['text_paypal'] = __('text_paypal');
		$this->data['text_bank'] = __('text_bank');
				
    	$this->data['entry_firstname'] = __('entry_firstname');
    	$this->data['entry_lastname'] = __('entry_lastname');
    	$this->data['entry_email'] = __('entry_email');
    	$this->data['entry_telephone'] = __('entry_telephone');
    	$this->data['entry_fax'] = __('entry_fax');
    	$this->data['entry_company'] = __('entry_company');
		$this->data['entry_website'] = __('entry_website');
    	$this->data['entry_address_1'] = __('entry_address_1');
    	$this->data['entry_address_2'] = __('entry_address_2');
    	$this->data['entry_postcode'] = __('entry_postcode');
    	$this->data['entry_city'] = __('entry_city');
    	$this->data['entry_country'] = __('entry_country');
    	$this->data['entry_zone'] = __('entry_zone');
		$this->data['entry_tax'] = __('entry_tax');
		$this->data['entry_payment'] = __('entry_payment');
		$this->data['entry_cheque'] = __('entry_cheque');
		$this->data['entry_paypal'] = __('entry_paypal');
		$this->data['entry_bank_name'] = __('entry_bank_name');
		$this->data['entry_bank_branch_number'] = __('entry_bank_branch_number');
		$this->data['entry_bank_swift_code'] = __('entry_bank_swift_code');
		$this->data['entry_bank_account_name'] = __('entry_bank_account_name');
		$this->data['entry_bank_account_number'] = __('entry_bank_account_number');
    	$this->data['entry_password'] = __('entry_password');
    	$this->data['entry_confirm'] = __('entry_confirm');

		$this->data['button_continue'] = __('button_continue');
    
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
		
		if (isset($this->error['password'])) {
			$this->data['error_password'] = $this->error['password'];
		} else {
			$this->data['error_password'] = '';
		}
		
 		if (isset($this->error['confirm'])) {
			$this->data['error_confirm'] = $this->error['confirm'];
		} else {
			$this->data['error_confirm'] = '';
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
								
    	$this->data['action'] = $this->url->link('affiliate/register', '', 'SSL');

		if (isset($this->request->post['firstname'])) {
    		$this->data['firstname'] = $this->request->post['firstname'];
		} else {
			$this->data['firstname'] = '';
		}

		if (isset($this->request->post['lastname'])) {
    		$this->data['lastname'] = $this->request->post['lastname'];
		} else {
			$this->data['lastname'] = '';
		}
		
		if (isset($this->request->post['email'])) {
    		$this->data['email'] = $this->request->post['email'];
		} else {
			$this->data['email'] = '';
		}
		
		if (isset($this->request->post['telephone'])) {
    		$this->data['telephone'] = $this->request->post['telephone'];
		} else {
			$this->data['telephone'] = '';
		}
		
		if (isset($this->request->post['fax'])) {
    		$this->data['fax'] = $this->request->post['fax'];
		} else {
			$this->data['fax'] = '';
		}
		
		if (isset($this->request->post['company'])) {
    		$this->data['company'] = $this->request->post['company'];
		} else {
			$this->data['company'] = '';
		}

		if (isset($this->request->post['website'])) {
    		$this->data['website'] = $this->request->post['website'];
		} else {
			$this->data['website'] = '';
		}
				
		if (isset($this->request->post['address_1'])) {
    		$this->data['address_1'] = $this->request->post['address_1'];
		} else {
			$this->data['address_1'] = '';
		}

		if (isset($this->request->post['address_2'])) {
    		$this->data['address_2'] = $this->request->post['address_2'];
		} else {
			$this->data['address_2'] = '';
		}

		if (isset($this->request->post['postcode'])) {
    		$this->data['postcode'] = $this->request->post['postcode'];
		} else {
			$this->data['postcode'] = '';
		}
		
		if (isset($this->request->post['city'])) {
    		$this->data['city'] = $this->request->post['city'];
		} else {
			$this->data['city'] = '';
		}

    	if (isset($this->request->post['country_id'])) {
      		$this->data['country_id'] = $this->request->post['country_id'];
		} else {	
      		$this->data['country_id'] = $this->config->get('config_country_id');
    	}

    	if (isset($this->request->post['zone_id'])) {
      		$this->data['zone_id'] = $this->request->post['zone_id']; 	
		} else {
      		$this->data['zone_id'] = '';
    	}
		
		$this->load->model('localisation/country');
		
    	$this->data['countries'] = $this->model_localisation_country->getCountries();

		if (isset($this->request->post['tax'])) {
    		$this->data['tax'] = $this->request->post['tax'];
		} else {
			$this->data['tax'] = '';
		}
		
		if (isset($this->request->post['payment'])) {
    		$this->data['payment'] = $this->request->post['payment'];
		} else {
			$this->data['payment'] = 'cheque';
		}

		if (isset($this->request->post['cheque'])) {
    		$this->data['cheque'] = $this->request->post['cheque'];
		} else {
			$this->data['cheque'] = '';
		}

		if (isset($this->request->post['paypal'])) {
    		$this->data['paypal'] = $this->request->post['paypal'];
		} else {
			$this->data['paypal'] = '';
		}

		if (isset($this->request->post['bank_name'])) {
    		$this->data['bank_name'] = $this->request->post['bank_name'];
		} else {
			$this->data['bank_name'] = '';
		}

		if (isset($this->request->post['bank_branch_number'])) {
    		$this->data['bank_branch_number'] = $this->request->post['bank_branch_number'];
		} else {
			$this->data['bank_branch_number'] = '';
		}

		if (isset($this->request->post['bank_swift_code'])) {
    		$this->data['bank_swift_code'] = $this->request->post['bank_swift_code'];
		} else {
			$this->data['bank_swift_code'] = '';
		}

		if (isset($this->request->post['bank_account_name'])) {
    		$this->data['bank_account_name'] = $this->request->post['bank_account_name'];
		} else {
			$this->data['bank_account_name'] = '';
		}
		
		if (isset($this->request->post['bank_account_number'])) {
    		$this->data['bank_account_number'] = $this->request->post['bank_account_number'];
		} else {
			$this->data['bank_account_number'] = '';
		}
																		
		if (isset($this->request->post['password'])) {
    		$this->data['password'] = $this->request->post['password'];
		} else {
			$this->data['password'] = '';
		}
		
		if (isset($this->request->post['confirm'])) {
    		$this->data['confirm'] = $this->request->post['confirm'];
		} else {
			$this->data['confirm'] = '';
		}

		if ($this->config->get('config_affiliate_id')) {
			$this->load->model('catalog/information');
			
			$information_info = $this->model_catalog_information->getInformation($this->config->get('config_affiliate_id'));
			
			if ($information_info) {
				$this->data['text_agree'] = sprintf(__('text_agree'), $this->url->link('information/information/info', 'information_id=' . $this->config->get('config_affiliate_id'), 'SSL'), $information_info['title'], $information_info['title']);
			} else {
				$this->data['text_agree'] = '';
			}
		} else {
			$this->data['text_agree'] = '';
		}
		
		if (isset($this->request->post['agree'])) {
      		$this->data['agree'] = $this->request->post['agree'];
		} else {
			$this->data['agree'] = false;
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/affiliate/register.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/affiliate/register.tpl';
		} else {
			$this->template = 'default/template/affiliate/register.tpl';
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
      		$this->error['firstname'] = __('error_firstname');
    	}

    	if ((utf8_strlen($this->request->post['lastname']) < 1) || (utf8_strlen($this->request->post['lastname']) > 32)) {
      		$this->error['lastname'] = __('error_lastname');
    	}

    	if ((utf8_strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['email'])) {
      		$this->error['email'] = __('error_email');
    	}

    	if ($this->model_affiliate_affiliate->getTotalAffiliatesByEmail($this->request->post['email'])) {
      		$this->error['warning'] = __('error_exists');
    	}
		
    	if ((utf8_strlen($this->request->post['telephone']) < 3) || (utf8_strlen($this->request->post['telephone']) > 32)) {
      		$this->error['telephone'] = __('error_telephone');
    	}

    	if ((utf8_strlen($this->request->post['address_1']) < 3) || (utf8_strlen($this->request->post['address_1']) > 128)) {
      		$this->error['address_1'] = __('error_address_1');
    	}

    	if ((utf8_strlen($this->request->post['city']) < 2) || (utf8_strlen($this->request->post['city']) > 128)) {
      		$this->error['city'] = __('error_city');
    	}
		
		$this->load->model('localisation/country');
		
		$country_info = $this->model_localisation_country->getCountry($this->request->post['country_id']);
		
		if ($country_info && $country_info['postcode_required'] && (utf8_strlen($this->request->post['postcode']) < 2) || (utf8_strlen($this->request->post['postcode']) > 10)) {
			$this->error['postcode'] = __('error_postcode');
		}

    	if ($this->request->post['country_id'] == '') {
      		$this->error['country'] = __('error_country');
    	}
		
    	if (!isset($this->request->post['zone_id']) || $this->request->post['zone_id'] == '') {
      		$this->error['zone'] = __('error_zone');
    	}

    	if ((utf8_strlen($this->request->post['password']) < 4) || (utf8_strlen($this->request->post['password']) > 20)) {
      		$this->error['password'] = __('error_password');
    	}

    	if ($this->request->post['confirm'] != $this->request->post['password']) {
      		$this->error['confirm'] = __('error_confirm');
    	}
		
		if ($this->config->get('config_affiliate_id')) {
			$this->load->model('catalog/information');
			
			$information_info = $this->model_catalog_information->getInformation($this->config->get('config_affiliate_id'));
			
			if ($information_info && !isset($this->request->post['agree'])) {
      			$this->error['warning'] = sprintf(__('error_agree'), $information_info['title']);
			}
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