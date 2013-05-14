<?php
class ControllerPaymentBankTransfer extends Controller {
	protected function index() {
		$this->language->load('payment/bank_transfer');

		$this->data['text_instruction'] = __('text_instruction');
		$this->data['text_description'] = __('text_description');
		$this->data['text_payment'] = __('text_payment');

		$this->data['button_confirm'] = __('button_confirm');

		$this->data['bank'] = nl2br($this->config->get('bank_transfer_bank_' . $this->config->get('config_language_id')));

		$this->data['continue'] = $this->url->link('checkout/success');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/bank_transfer.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/payment/bank_transfer.tpl';
		} else {
			$this->template = 'default/template/payment/bank_transfer.tpl';
		}

		$this->render();
	}

	public function confirm() {
		$this->language->load('payment/bank_transfer');

		$this->load->model('checkout/order');

		$comment  = __('text_instruction') . "\n\n";
		$comment .= $this->config->get('bank_transfer_bank_' . $this->config->get('config_language_id')) . "\n\n";
		$comment .= __('text_payment');

		$this->model_checkout_order->confirm($this->session->data['order_id'], $this->config->get('bank_transfer_order_status_id'), $comment, true);
	}
}
?>