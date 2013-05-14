<?php 
class ControllerAccountAccount extends Controller {
	public function index() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/account', '', 'SSL');
			 
			$this->redirect($this->url->link('account/login', '', 'SSL'));
		}

		$this->language->load('account/account');

		$this->document->setTitle(__('My Account','account/account'));

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
				'text' => __('text_home'),
				'href' => $this->url->link('common/home')
		);

		$this->data['breadcrumbs'][] = array(
				'text' => __('Account','account/account'),
				'href' => $this->url->link('account/account', '', 'SSL')
		);

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
				
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$this->data['heading_title'] = __('My Account','account/account');

		$this->data['text_my_account'] = __('My Account','account/account');
		$this->data['text_my_orders'] = __('My Orders','account/account');
		$this->data['text_my_newsletter'] = __('Newsletter','account/account');
		$this->data['text_edit'] = __('Edit your account information','account/account');
		$this->data['text_password'] = __('Change your password','account/account');
		$this->data['text_address'] = __('Modify your address book entries','account/account');
		$this->data['text_wishlist'] = __('Modify your wish list','account/account');
		$this->data['text_order'] = __('View your order history','account/account');
		$this->data['text_download'] = __('Downloads','account/account');
		$this->data['text_reward'] = __('Your Reward Points','account/account');
		$this->data['text_return'] = __('View your return requests','account/account');
		$this->data['text_transaction'] = __('Your Transactions','account/account');
		$this->data['text_newsletter'] = __('Subscribe / unsubscribe to newsletter','account/account');

		$this->data['edit'] = $this->url->link('account/edit', '', 'SSL');
		$this->data['password'] = $this->url->link('account/password', '', 'SSL');
		$this->data['address'] = $this->url->link('account/address', '', 'SSL');
		$this->data['wishlist'] = $this->url->link('account/wishlist');
		$this->data['order'] = $this->url->link('account/order', '', 'SSL');
		$this->data['download'] = $this->url->link('account/download', '', 'SSL');
		$this->data['return'] = $this->url->link('account/return', '', 'SSL');
		$this->data['transaction'] = $this->url->link('account/transaction', '', 'SSL');
		$this->data['newsletter'] = $this->url->link('account/newsletter', '', 'SSL');

		if ($this->config->get('reward_status')) {
			$this->data['reward'] = $this->url->link('account/reward', '', 'SSL');
		} else {
			$this->data['reward'] = '';
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/account.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/account/account.tpl';
		} else {
			$this->template = 'default/template/account/account.tpl';
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
}
?>