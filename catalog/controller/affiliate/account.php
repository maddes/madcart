<?php 
class ControllerAffiliateAccount extends Controller {
	public function index() {
		if (!$this->affiliate->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('affiliate/account', '', 'SSL');
			 
			$this->redirect($this->url->link('affiliate/login', '', 'SSL'));
		}

		$this->language->load('affiliate/account');

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
				'text' => __('text_home'),
				'href' => $this->url->link('common/home')
		);

		$this->data['breadcrumbs'][] = array(
				'text' => __('Account','affiliate/account'),
				'href' => $this->url->link('affiliate/account', '', 'SSL')
		);

		$this->document->setTitle(__('My Affiliate Account','affiliate/account'));

		$this->data['heading_title'] = __('My Affiliate Account','affiliate/account');

		$this->data['text_my_account'] = __('My Affiliate Account','affiliate/account');
		$this->data['text_my_tracking'] = __('My Tracking Information','affiliate/account');
		$this->data['text_my_transactions'] = __('My Transactions','affiliate/account');
		$this->data['text_edit'] = __('Edit your account information','affiliate/account');
		$this->data['text_password'] = __('Change your password','affiliate/account');
		$this->data['text_payment'] = __('Change your payment preferences','affiliate/account');
		$this->data['text_tracking'] = __('Custom Affiliate Tracking Code','affiliate/account');
		$this->data['text_transaction'] = __('View your transaction history','affiliate/account');

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
				
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$this->data['edit'] = $this->url->link('affiliate/edit', '', 'SSL');
		$this->data['password'] = $this->url->link('affiliate/password', '', 'SSL');
		$this->data['payment'] = $this->url->link('affiliate/payment', '', 'SSL');
		$this->data['tracking'] = $this->url->link('affiliate/tracking', '', 'SSL');
		$this->data['transaction'] = $this->url->link('affiliate/transaction', '', 'SSL');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/affiliate/account.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/affiliate/account.tpl';
		} else {
			$this->template = 'default/template/affiliate/account.tpl';
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