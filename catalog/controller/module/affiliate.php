<?php  
class ControllerModuleAffiliate extends Controller {
	protected function index() {
		$this->language->load('module/affiliate');
		
    	$this->data['heading_title'] = __('heading_title');
    	
		$this->data['text_register'] = __('text_register');
    	$this->data['text_login'] = __('text_login');
		$this->data['text_logout'] = __('text_logout');
		$this->data['text_forgotten'] = __('text_forgotten');	
		$this->data['text_account'] = __('text_account');
		$this->data['text_edit'] = __('text_edit');
		$this->data['text_password'] = __('text_password');
		$this->data['text_payment'] = __('text_payment');
		$this->data['text_tracking'] = __('text_tracking');
		$this->data['text_transaction'] = __('text_transaction');
		
		$this->data['logged'] = $this->affiliate->isLogged();
		$this->data['register'] = $this->url->link('affiliate/register', '', 'SSL');
    	$this->data['login'] = $this->url->link('affiliate/login', '', 'SSL');
		$this->data['logout'] = $this->url->link('affiliate/logout', '', 'SSL');
		$this->data['forgotten'] = $this->url->link('affiliate/forgotten', '', 'SSL');
		$this->data['account'] = $this->url->link('affiliate/account', '', 'SSL');
		$this->data['edit'] = $this->url->link('affiliate/edit', '', 'SSL');
		$this->data['password'] = $this->url->link('affiliate/password', '', 'SSL');
		$this->data['payment'] = $this->url->link('affiliate/payment', '', 'SSL');
		$this->data['tracking'] = $this->url->link('affiliate/tracking', '', 'SSL');
		$this->data['transaction'] = $this->url->link('affiliate/transaction', '', 'SSL');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/affiliate.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/affiliate.tpl';
		} else {
			$this->template = 'default/template/module/affiliate.tpl';
		}
		
		$this->render();
	}
}
?>