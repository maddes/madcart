<?php 
class ControllerPaymentPerpetualPayments extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('payment/perpetual_payments');

		$this->document->setTitle(__('heading_title'));

		$this->load->model('setting/setting');
			
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('perpetual_payments', $this->request->post);
				
			$this->session->data['success'] = __('text_success');

			$this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->data['heading_title'] = __('heading_title');

		$this->data['text_enabled'] = __('text_enabled');
		$this->data['text_disabled'] = __('text_disabled');
		$this->data['text_all_zones'] = __('text_all_zones');
		$this->data['text_yes'] = __('text_yes');
		$this->data['text_no'] = __('text_no');

		$this->data['entry_auth_id'] = __('entry_auth_id');
		$this->data['entry_auth_pass'] = __('entry_auth_pass');
		$this->data['entry_test'] = __('entry_test');
		$this->data['entry_total'] = __('entry_total');
		$this->data['entry_order_status'] = __('entry_order_status');
		$this->data['entry_geo_zone'] = __('entry_geo_zone');
		$this->data['entry_status'] = __('entry_status');
		$this->data['entry_sort_order'] = __('entry_sort_order');

		$this->data['help_test'] = __('help_test');
		$this->data['help_total'] = __('help_total');

		$this->data['button_save'] = __('button_save');
		$this->data['button_cancel'] = __('button_cancel');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['auth_id'])) {
			$this->data['error_auth_id'] = $this->error['auth_id'];
		} else {
			$this->data['error_auth_id'] = '';
		}

		if (isset($this->error['auth_pass'])) {
			$this->data['error_auth_pass'] = $this->error['auth_pass'];
		} else {
			$this->data['error_auth_pass'] = '';
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
				'href' => $this->url->link('payment/perpetual_payments', 'token=' . $this->session->data['token'], 'SSL')
		);

		$this->data['action'] = $this->url->link('payment/perpetual_payments', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['perpetual_payments_auth_id'])) {
			$this->data['perpetual_payments_auth_id'] = $this->request->post['perpetual_payments_auth_id'];
		} else {
			$this->data['perpetual_payments_auth_id'] = $this->config->get('perpetual_payments_auth_id');
		}

		if (isset($this->request->post['perpetual_payments_auth_pass'])) {
			$this->data['perpetual_payments_auth_pass'] = $this->request->post['perpetual_payments_auth_pass'];
		} else {
			$this->data['perpetual_payments_auth_pass'] = $this->config->get('perpetual_payments_auth_pass');
		}

		if (isset($this->request->post['perpetual_payments_test'])) {
			$this->data['perpetual_payments_test'] = $this->request->post['perpetual_payments_test'];
		} else {
			$this->data['perpetual_payments_test'] = $this->config->get('perpetual_payments_test');
		}

		if (isset($this->request->post['perpetual_payments_total'])) {
			$this->data['perpetual_payments_total'] = $this->request->post['perpetual_payments_total'];
		} else {
			$this->data['perpetual_payments_total'] = $this->config->get('perpetual_payments_total');
		}

		if (isset($this->request->post['perpetual_payments_order_status_id'])) {
			$this->data['perpetual_payments_order_status_id'] = $this->request->post['perpetual_payments_order_status_id'];
		} else {
			$this->data['perpetual_payments_order_status_id'] = $this->config->get('perpetual_payments_order_status_id');
		}

		$this->load->model('localisation/order_status');

		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['perpetual_payments_geo_zone_id'])) {
			$this->data['perpetual_payments_geo_zone_id'] = $this->request->post['perpetual_payments_geo_zone_id'];
		} else {
			$this->data['perpetual_payments_geo_zone_id'] = $this->config->get('perpetual_payments_geo_zone_id');
		}

		$this->load->model('localisation/geo_zone');

		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['perpetual_payments_status'])) {
			$this->data['perpetual_payments_status'] = $this->request->post['perpetual_payments_status'];
		} else {
			$this->data['perpetual_payments_status'] = $this->config->get('perpetual_payments_status');
		}

		if (isset($this->request->post['perpetual_payments_sort_order'])) {
			$this->data['perpetual_payments_sort_order'] = $this->request->post['perpetual_payments_sort_order'];
		} else {
			$this->data['perpetual_payments_sort_order'] = $this->config->get('perpetual_payments_sort_order');
		}

		$this->template = 'payment/perpetual_payments.tpl';
		$this->children = array(
				'common/header',
				'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'payment/perpetual_payments')) {
			$this->error['warning'] = __('error_permission');
		}

		if (!$this->request->post['perpetual_payments_auth_id']) {
			$this->error['auth_id'] = __('error_auth_id');
		}

		if (!$this->request->post['perpetual_payments_auth_pass']) {
			$this->error['auth_pass'] = __('error_auth_pass');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>