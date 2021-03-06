<?php
class ControllerCheckoutSuccess extends Controller {
	public function index() {
		if (isset($this->session->data['order_id'])) {
			$this->cart->clear();

			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
			unset($this->session->data['payment_method']);
			unset($this->session->data['payment_methods']);
			unset($this->session->data['guest']);
			unset($this->session->data['comment']);
			unset($this->session->data['order_id']);
			unset($this->session->data['coupon']);
			unset($this->session->data['reward']);
			unset($this->session->data['voucher']);
			unset($this->session->data['vouchers']);
		}

		$this->language->load('checkout/success');

		$this->document->setTitle(__('heading_title'));

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
				'text' => __('text_home'),
				'href' => $this->url->link('common/home')
		);

		$this->data['breadcrumbs'][] = array(
				'text' => __('text_basket'),
				'href' => $this->url->link('checkout/cart')
		);

		$this->data['breadcrumbs'][] = array(
				'text' => __('text_checkout'),
				'href' => $this->url->link('checkout/checkout', '', 'SSL')
		);
			
		$this->data['breadcrumbs'][] = array(
				'text' => __('text_success'),
				'href' => $this->url->link('checkout/success')
		);

		$this->data['heading_title'] = __('heading_title');

		if ($this->customer->isLogged()) {
			$this->data['text_message'] = sprintf(__('text_customer'), $this->url->link('account/account', '', 'SSL'), $this->url->link('account/order', '', 'SSL'), $this->url->link('account/download', '', 'SSL'), $this->url->link('information/contact'));
		} else {
			$this->data['text_message'] = sprintf(__('text_guest'), $this->url->link('information/contact'));
		}

		$this->data['button_continue'] = __('button_continue');

		$this->data['continue'] = $this->url->link('common/home');

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