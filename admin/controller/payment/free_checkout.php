<?php 
class ControllerPaymentFreeCheckout extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('payment/free_checkout');

		$this->document->setTitle(__('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('free_checkout', $this->request->post);

			$this->session->data['success'] = __('text_success');
				
			$this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->data['heading_title'] = __('heading_title');

		$this->data['text_enabled'] = __('text_enabled');
		$this->data['text_disabled'] = __('text_disabled');
		$this->data['text_all_zones'] = __('text_all_zones');

		$this->data['entry_order_status'] = __('entry_order_status');
		$this->data['entry_status'] = __('entry_status');
		$this->data['entry_sort_order'] = __('entry_sort_order');

		$this->data['button_save'] = __('button_save');
		$this->data['button_cancel'] = __('button_cancel');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
				'text' => __('text_home'),
				'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL')
		);

		$this->data['breadcrumbs'][] = array(
				'text' => __('text_payment'),
				'href' => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL')
		);

		$this->data['breadcrumbs'][] = array(
				'text' => __('heading_title'),
				'href' => $this->url->link('payment/free_checkout', 'token=' . $this->session->data['token'], 'SSL')
		);

		$this->data['action'] = $this->url->link('payment/free_checkout', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['free_checkout_order_status_id'])) {
			$this->data['free_checkout_order_status_id'] = $this->request->post['free_checkout_order_status_id'];
		} else {
			$this->data['free_checkout_order_status_id'] = $this->config->get('free_checkout_order_status_id');
		}

		$this->load->model('localisation/order_status');

		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['free_checkout_status'])) {
			$this->data['free_checkout_status'] = $this->request->post['free_checkout_status'];
		} else {
			$this->data['free_checkout_status'] = $this->config->get('free_checkout_status');
		}

		if (isset($this->request->post['free_checkout_sort_order'])) {
			$this->data['free_checkout_sort_order'] = $this->request->post['free_checkout_sort_order'];
		} else {
			$this->data['free_checkout_sort_order'] = $this->config->get('free_checkout_sort_order');
		}

		$this->template = 'payment/free_checkout.tpl';
		$this->children = array(
				'common/header',
				'common/footer'
		);
			
		$this->response->setOutput($this->render());
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'payment/free_checkout')) {
			$this->error['warning'] = __('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>