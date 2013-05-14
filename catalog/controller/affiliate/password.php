<?php
class ControllerAffiliatePassword extends Controller {
	private $error = array();

	public function index() {
		if (!$this->affiliate->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('affiliate/password', '', 'SSL');

			$this->redirect($this->url->link('affiliate/login', '', 'SSL'));
		}

		$this->language->load('affiliate/password');

		$this->document->setTitle(__('Change Password','affiliate/password'));
			
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->load->model('affiliate/affiliate');
				
			$this->model_affiliate_affiliate->editPassword($this->affiliate->getEmail(), $this->request->post['password']);

			$this->session->data['success'] = __('Success: Your password has been successfully updated.','affiliate/password');
			 
			$this->redirect($this->url->link('affiliate/account', '', 'SSL'));
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
				'text' => __('text_home'),
				'href' => $this->url->link('common/home')
		);

		$this->data['breadcrumbs'][] = array(
				'text' => __('Account','affiliate/password'),
				'href' => $this->url->link('affiliate/account', '', 'SSL')
		);

		$this->data['breadcrumbs'][] = array(
				'text' => __('Change Password','affiliate/password'),
				'href' => $this->url->link('affiliate/password', '', 'SSL')
		);
			
		$this->data['heading_title'] = __('Change Password','affiliate/password');

		$this->data['text_password'] = __('Your Password','affiliate/password');

		$this->data['entry_password'] = __('Password:','affiliate/password');
		$this->data['entry_confirm'] = __('Password Confirm:','affiliate/password');

		$this->data['button_continue'] = __('button_continue');
		$this->data['button_back'] = __('button_back');
		 
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

		$this->data['action'] = $this->url->link('affiliate/password', '', 'SSL');

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

		$this->data['back'] = $this->url->link('affiliate/account', '', 'SSL');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/affiliate/password.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/affiliate/password.tpl';
		} else {
			$this->template = 'default/template/affiliate/password.tpl';
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
		if ((utf8_strlen($this->request->post['password']) < 4) || (utf8_strlen($this->request->post['password']) > 20)) {
			$this->error['password'] = __('Password must be between 4 and 20 characters!','affiliate/password');
		}

		if ($this->request->post['confirm'] != $this->request->post['password']) {
			$this->error['confirm'] = __('Password confirmation does not match password!','affiliate/password');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>
