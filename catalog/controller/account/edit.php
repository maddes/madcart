<?php
class ControllerAccountEdit extends Controller {
	public function index() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/edit', '', 'SSL');

			$this->redirect($this->url->link('account/login', '', 'SSL'));
		}

		$this->language->load('account/edit');

		$this->document->setTitle(__('My Account Information','account/edit'));

		$this->load->model('account/customer');

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
				'text' => __('text_home'),
				'href' => $this->url->link('common/home')
		);

		$this->data['breadcrumbs'][] = array(
				'text' => __('Account','account/edit'),
				'href' => $this->url->link('account/account', '', 'SSL')
		);

		$this->data['breadcrumbs'][] = array(
				'text' => __('Edit Information','account/edit'),
				'href' => $this->url->link('account/edit', '', 'SSL')
		);

		$this->data['heading_title'] = __('My Account Information','account/edit');

		$this->data['text_your_details'] = __('Your Personal Details','account/edit');

		$this->data['entry_firstname'] = __('First Name:','account/edit');
		$this->data['entry_lastname'] = __('Last Name:','account/edit');
		$this->data['entry_email'] = __('E-Mail:','account/edit');
		$this->data['entry_telephone'] = __('Telephone:','account/edit');
		$this->data['entry_fax'] = __('Fax:','account/edit');

		$this->data['button_continue'] = __('button_continue');
		$this->data['button_back'] = __('button_back');

		$customer_info = $this->model_account_customer->getCustomer($this->customer->getId());

		$this->data['firstname'] = $customer_info['firstname'];
		$this->data['lastname'] = $customer_info['lastname'];
		$this->data['email'] = $customer_info['email'];
		$this->data['telephone'] = $customer_info['telephone'];
		$this->data['fax'] = $customer_info['fax'];

		$this->data['back'] = $this->url->link('account/account', '', 'SSL');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/edit.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/account/edit.tpl';
		} else {
			$this->template = 'default/template/account/edit.tpl';
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
		$this->language->load('account/edit');

		$json = array();

		if (!$this->customer->isLogged()) {
			$json['redirect'] = $this->url->link('account/login', '', 'SSL');
		}

		if (!$json) {
			$this->load->model('account/customer');
				
			if ((utf8_strlen($this->request->post['firstname']) < 1) || (utf8_strlen($this->request->post['firstname']) > 32)) {
				$json['error']['firstname'] = __('First Name must be between 1 and 32 characters!','account/edit');
			}

			if ((utf8_strlen($this->request->post['lastname']) < 1) || (utf8_strlen($this->request->post['lastname']) > 32)) {
				$json['error']['lastname'] = __('Last Name must be between 1 and 32 characters!','account/edit');
			}

			if ((utf8_strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['email'])) {
				$json['error']['email'] = __('E-Mail Address does not appear to be valid!','account/edit');
			}
				
			if (($this->customer->getEmail() != $this->request->post['email']) && $this->model_account_customer->getTotalCustomersByEmail($this->request->post['email'])) {
				$json['error']['warning'] = __('Warning: E-Mail address is already registered!','account/edit');
			}

			if ((utf8_strlen($this->request->post['telephone']) < 3) || (utf8_strlen($this->request->post['telephone']) > 32)) {
				$json['error']['telephone'] = __('Telephone must be between 3 and 32 characters!','account/edit');
			}

			// Custom Fields
			$this->load->model('account/custom_field');

			$custom_fields = $this->model_account_custom_field->getCustomFields('edit', $this->customer->getCustomerGroupId());

			foreach ($custom_fields as $custom_field) {
				if ($custom_field['required'] && empty($this->request->post['custom_field'][$custom_field['custom_field_id']])) {
					$json['error']['custom_field'][$custom_field['custom_field_id']] = sprintf(__('error_required'), $custom_field['name']);
				}
			}
		}
			
		if (!$json) {
			$this->model_account_customer->editCustomer($this->request->post);
				
			$this->session->data['success'] = __('Success: Your account has been successfully updated.','account/edit');

			$json['redirect'] = $this->url->link('account/account', '', 'SSL');
		}

		$this->response->setOutput(json_encode($json));
	}
}
?>