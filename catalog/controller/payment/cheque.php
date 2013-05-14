<?php
class ControllerPaymentCheque extends Controller {
	protected function index() {
		$this->language->load('payment/cheque');

		$this->data['text_instruction'] = __('text_instruction');
		$this->data['text_payable'] = __('text_payable');
		$this->data['text_address'] = __('text_address');
		$this->data['text_payment'] = __('text_payment');

		$this->data['button_confirm'] = __('button_confirm');

		$this->data['payable'] = $this->config->get('cheque_payable');
		$this->data['address'] = nl2br($this->config->get('config_address'));

		$this->data['continue'] = $this->url->link('checkout/success');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/cheque.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/payment/cheque.tpl';
		} else {
			$this->template = 'default/template/payment/cheque.tpl';
		}

		$this->render();
	}

	public function confirm() {
		$this->language->load('payment/cheque');

		$this->load->model('checkout/order');

		$comment  = __('text_payable') . "\n";
		$comment .= $this->config->get('cheque_payable') . "\n\n";
		$comment .= __('text_address') . "\n";
		$comment .= $this->config->get('config_address') . "\n\n";
		$comment .= __('text_payment') . "\n";

		$this->model_checkout_order->confirm($this->session->data['order_id'], $this->config->get('cheque_order_status_id'), $comment, true);
	}
}
?>