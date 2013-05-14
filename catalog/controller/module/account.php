<?php  
class ControllerModuleAccount extends Controller {
	protected function index() {
		$this->language->load('module/account');
		
    	$this->data['heading_title'] = __('heading_title');
    	
		$this->data['text_register'] = __('text_register');
    	$this->data['text_login'] = __('text_login');
		$this->data['text_logout'] = __('text_logout');
		$this->data['text_forgotten'] = __('text_forgotten');
		$this->data['text_account'] = __('text_account');
		$this->data['text_edit'] = __('text_edit');
		$this->data['text_password'] = __('text_password');
		$this->data['text_address'] = __('text_address');
		$this->data['text_wishlist'] = __('text_wishlist');
		$this->data['text_order'] = __('text_order');
		$this->data['text_download'] = __('text_download');
		$this->data['text_return'] = __('text_return');
		$this->data['text_transaction'] = __('text_transaction');
		$this->data['text_newsletter'] = __('text_newsletter');
		
		$this->data['logged'] = $this->customer->isLogged();
		$this->data['register'] = $this->url->link('account/register', '', 'SSL');
    	$this->data['login'] = $this->url->link('account/login', '', 'SSL');
		$this->data['logout'] = $this->url->link('account/logout', '', 'SSL');
		$this->data['forgotten'] = $this->url->link('account/forgotten', '', 'SSL');
		$this->data['account'] = $this->url->link('account/account', '', 'SSL');
		$this->data['edit'] = $this->url->link('account/edit', '', 'SSL');
		$this->data['password'] = $this->url->link('account/password', '', 'SSL');
		$this->data['address'] = $this->url->link('account/address', '', 'SSL');
		$this->data['wishlist'] = $this->url->link('account/wishlist');
		$this->data['order'] = $this->url->link('account/order', '', 'SSL');
		$this->data['download'] = $this->url->link('account/download', '', 'SSL');
		$this->data['return'] = $this->url->link('account/return', '', 'SSL');
		$this->data['transaction'] = $this->url->link('account/transaction', '', 'SSL');
		$this->data['newsletter'] = $this->url->link('account/newsletter', '', 'SSL');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/account.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/account.tpl';
		} else {
			$this->template = 'default/template/module/account.tpl';
		}
		
		$this->render();
	}
}
?>