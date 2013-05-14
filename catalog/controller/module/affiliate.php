<?php  
class ControllerModuleAffiliate extends Controller {
	protected function index() {
		$this->language->load('module/affiliate');

		$this->data['heading_title'] = __('Affiliate','module/affiliate');
		 
		$this->data['text_register'] = __('Register','module/affiliate');
		$this->data['text_login'] = __('Login','module/affiliate');
		$this->data['text_logout'] = __('Logout','module/affiliate');
		$this->data['text_forgotten'] = __('Forgotten Password','module/affiliate');
		$this->data['text_account'] = __('My Account','module/affiliate');
		$this->data['text_edit'] = __('Edit Account','module/affiliate');
		$this->data['text_password'] = __('Password','module/affiliate');
		$this->data['text_payment'] = __('Payment Options','module/affiliate');
		$this->data['text_tracking'] = __('Affiliate Tracking','module/affiliate');
		$this->data['text_transaction'] = __('Transactions','module/affiliate');

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