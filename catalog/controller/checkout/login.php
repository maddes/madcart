<?php  
class ControllerCheckoutLogin extends Controller { 
	public function index() {
		$this->language->load('checkout/checkout');
		
		$this->data['text_checkout_account'] = __('text_checkout_account');
		$this->data['text_checkout_payment_address'] = __('text_checkout_payment_address');
		$this->data['text_new_customer'] = __('text_new_customer');
		$this->data['text_returning_customer'] = __('text_returning_customer');
		$this->data['text_checkout'] = __('text_checkout');
		$this->data['text_register'] = __('text_register');
		$this->data['text_guest'] = __('text_guest');
		$this->data['text_i_am_returning_customer'] = __('text_i_am_returning_customer');
		$this->data['text_register_account'] = __('text_register_account');
		$this->data['text_forgotten'] = __('text_forgotten');
 		$this->data['text_modify'] = __('text_modify');
 		
		$this->data['entry_email'] = __('entry_email');
		$this->data['entry_password'] = __('entry_password');
		
		$this->data['button_continue'] = __('button_continue');
		$this->data['button_login'] = __('button_login');
		
		$this->data['guest_checkout'] = ($this->config->get('config_guest_checkout') && !$this->config->get('config_customer_price') && !$this->cart->hasDownload());
		
		if (isset($this->session->data['account'])) {
			$this->data['account'] = $this->session->data['account'];
		} else {
			$this->data['account'] = 'register';
		}
		
		$this->data['forgotten'] = $this->url->link('account/forgotten', '', 'SSL');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/login.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/checkout/login.tpl';
		} else {
			$this->template = 'default/template/checkout/login.tpl';
		}
				
		$this->response->setOutput($this->render());
	}
	
	public function save() {
		$this->language->load('checkout/checkout');
		
		$json = array();
		
		if ($this->customer->isLogged()) {
			$json['redirect'] = $this->url->link('checkout/checkout', '', 'SSL');			
		}
		
		if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
			$json['redirect'] = $this->url->link('checkout/cart');
		}	
		
		if (!$json) {
			if (!$this->customer->login($this->request->post['email'], $this->request->post['password'])) {
				$json['error']['warning'] = __('error_login');
			}
		
			$this->load->model('account/customer');
		
			$customer_info = $this->model_account_customer->getCustomerByEmail($this->request->post['email']);
			
			if ($customer_info && !$customer_info['approved']) {
				$json['error']['warning'] = __('error_approved');
			}		
		}
		
		if (!$json) {
			unset($this->session->data['guest']);
				
			$this->load->model('account/address');
				
			if ($this->config->get('config_tax_customer') == 'payment') {
				$this->session->data['payment_addess'] = $this->model_account_address->getAddress($this->customer->getAddressId());						
			}
			
			if ($this->config->get('config_tax_customer') == 'shipping') {
				$this->session->data['shipping_addess'] = $this->model_account_address->getAddress($this->customer->getAddressId());	
			}	
			
			$json['redirect'] = $this->url->link('checkout/checkout', '', 'SSL');
		}
					
		$this->response->setOutput(json_encode($json));		
	}
}
?>