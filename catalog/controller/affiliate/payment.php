<?php
class ControllerAffiliatePayment extends Controller {
	private $error = array();

	public function index() {
		if (!$this->affiliate->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('affiliate/payment', '', 'SSL');

			$this->redirect($this->url->link('affiliate/login', '', 'SSL'));
		}

		$this->language->load('affiliate/payment');

		$this->document->setTitle(__('Payment Method','affiliate/payment'));

		$this->load->model('affiliate/affiliate');

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$this->model_affiliate_affiliate->editPayment($this->request->post);
				
			$this->session->data['success'] = __('Success: Your account has been successfully updated.','affiliate/payment');

			$this->redirect($this->url->link('affiliate/account', '', 'SSL'));
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
				'text' => __('text_home'),
				'href' => $this->url->link('common/home')
		);

		$this->data['breadcrumbs'][] = array(
				'text' => __('Account','affiliate/payment'),
				'href' => $this->url->link('affiliate/account', '', 'SSL')
		);

		$this->data['breadcrumbs'][] = array(
				'text' => __('Payment','affiliate/payment'),
				'href' => $this->url->link('affiliate/payment', '', 'SSL')
		);

		$this->data['heading_title'] = __('Payment Method','affiliate/payment');

		$this->data['text_your_payment'] = __('Payment Information','affiliate/payment');
		$this->data['text_cheque'] = __('Cheque','affiliate/payment');
		$this->data['text_paypal'] = __('PayPal','affiliate/payment');
		$this->data['text_bank'] = __('Bank Transfer','affiliate/payment');

		$this->data['entry_tax'] = __('Tax ID:','affiliate/payment');
		$this->data['entry_payment'] = __('Payment Method:','affiliate/payment');
		$this->data['entry_cheque'] = __('Cheque Payee Name:','affiliate/payment');
		$this->data['entry_paypal'] = __('PayPal Email Account:','affiliate/payment');
		$this->data['entry_bank_name'] = __('Bank Name:','affiliate/payment');
		$this->data['entry_bank_branch_number'] = __('ABA/BSB number (Branch Number):','affiliate/payment');
		$this->data['entry_bank_swift_code'] = __('SWIFT Code:','affiliate/payment');
		$this->data['entry_bank_account_name'] = __('Account Name:','affiliate/payment');
		$this->data['entry_bank_account_number'] = __('Account Number:','affiliate/payment');

		$this->data['button_continue'] = __('button_continue');
		$this->data['button_back'] = __('button_back');

		$this->data['action'] = $this->url->link('affiliate/payment', '', 'SSL');

		if ($this->request->server['REQUEST_METHOD'] != 'POST') {
			$affiliate_info = $this->model_affiliate_affiliate->getAffiliate($this->affiliate->getId());
		}

		if (isset($this->request->post['tax'])) {
			$this->data['tax'] = $this->request->post['tax'];
		} elseif (!empty($affiliate_info)) {
			$this->data['tax'] = $affiliate_info['tax'];
		} else {
			$this->data['tax'] = '';
		}

		if (isset($this->request->post['payment'])) {
			$this->data['payment'] = $this->request->post['payment'];
		} elseif (!empty($affiliate_info)) {
			$this->data['payment'] = $affiliate_info['payment'];
		} else {
			$this->data['payment'] = 'cheque';
		}

		if (isset($this->request->post['cheque'])) {
			$this->data['cheque'] = $this->request->post['cheque'];
		} elseif (!empty($affiliate_info)) {
			$this->data['cheque'] = $affiliate_info['cheque'];
		} else {
			$this->data['cheque'] = '';
		}

		if (isset($this->request->post['paypal'])) {
			$this->data['paypal'] = $this->request->post['paypal'];
		} elseif (!empty($affiliate_info)) {
			$this->data['paypal'] = $affiliate_info['paypal'];
		} else {
			$this->data['paypal'] = '';
		}

		if (isset($this->request->post['bank_name'])) {
			$this->data['bank_name'] = $this->request->post['bank_name'];
		} elseif (!empty($affiliate_info)) {
			$this->data['bank_name'] = $affiliate_info['bank_name'];
		} else {
			$this->data['bank_name'] = '';
		}

		if (isset($this->request->post['bank_branch_number'])) {
			$this->data['bank_branch_number'] = $this->request->post['bank_branch_number'];
		} elseif (!empty($affiliate_info)) {
			$this->data['bank_branch_number'] = $affiliate_info['bank_branch_number'];
		} else {
			$this->data['bank_branch_number'] = '';
		}

		if (isset($this->request->post['bank_swift_code'])) {
			$this->data['bank_swift_code'] = $this->request->post['bank_swift_code'];
		} elseif (!empty($affiliate_info)) {
			$this->data['bank_swift_code'] = $affiliate_info['bank_swift_code'];
		} else {
			$this->data['bank_swift_code'] = '';
		}

		if (isset($this->request->post['bank_account_name'])) {
			$this->data['bank_account_name'] = $this->request->post['bank_account_name'];
		} elseif (!empty($affiliate_info)) {
			$this->data['bank_account_name'] = $affiliate_info['bank_account_name'];
		} else {
			$this->data['bank_account_name'] = '';
		}

		if (isset($this->request->post['bank_account_number'])) {
			$this->data['bank_account_number'] = $this->request->post['bank_account_number'];
		} elseif (!empty($affiliate_info)) {
			$this->data['bank_account_number'] = $affiliate_info['bank_account_number'];
		} else {
			$this->data['bank_account_number'] = '';
		}

		$this->data['back'] = $this->url->link('affiliate/account', '', 'SSL');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/affiliate/payment.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/affiliate/payment.tpl';
		} else {
			$this->template = 'default/template/affiliate/payment.tpl';
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