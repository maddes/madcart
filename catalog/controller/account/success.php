<?php 
class ControllerAccountSuccess extends Controller {
	public function index() {
		$this->language->load('account/success');

		$this->document->setTitle(__('heading_title'));

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
				'text' => __('text_home'),
				'href' => $this->url->link('common/home')
		);

		$this->data['breadcrumbs'][] = array(
				'text' => __('text_account'),
				'href' => $this->url->link('account/account', '', 'SSL')
		);

		$this->data['breadcrumbs'][] = array(
				'text' => __('text_success'),
				'href' => $this->url->link('account/success')
		);

		$this->data['heading_title'] = __('heading_title');

		$this->load->model('account/customer_group');

		$customer_group = $this->model_account_customer_group->getCustomerGroup($this->customer->getCustomerGroupId());

		if ($customer_group && !$customer_group['approval']) {
			$this->data['text_message'] = sprintf(__('text_message'), $this->url->link('information/contact'));
		} else {
			$this->data['text_message'] = sprintf(__('text_approval'), $this->config->get('config_name'), $this->url->link('information/contact'));
		}

		$this->data['button_continue'] = __('button_continue');

		if ($this->cart->hasProducts()) {
			$this->data['continue'] = $this->url->link('checkout/cart');
		} else {
			$this->data['continue'] = $this->url->link('account/account', '', 'SSL');
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/success.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/common/success.tpl';
		} else {
			$this->template = 'default/template/common/success.tpl';
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