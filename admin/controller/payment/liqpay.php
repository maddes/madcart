<?php 
class ControllerPaymentLiqPay extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('payment/liqpay');

		$this->document->setTitle(__('heading_title'));

		$this->load->model('setting/setting');
			
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('liqpay', $this->request->post);
				
			$this->session->data['success'] = __('text_success');

			$this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->data['heading_title'] = __('heading_title');

		$this->data['text_enabled'] = __('text_enabled');
		$this->data['text_disabled'] = __('text_disabled');
		$this->data['text_all_zones'] = __('text_all_zones');
		$this->data['text_pay'] = __('text_pay');
		$this->data['text_card'] = __('text_card');

		$this->data['entry_merchant'] = __('entry_merchant');
		$this->data['entry_signature'] = __('entry_signature');
		$this->data['entry_type'] = __('entry_type');
		$this->data['entry_total'] = __('entry_total');
		$this->data['entry_order_status'] = __('entry_order_status');
		$this->data['entry_geo_zone'] = __('entry_geo_zone');
		$this->data['entry_status'] = __('entry_status');
		$this->data['entry_sort_order'] = __('entry_sort_order');

		$this->data['help_total'] = __('help_total');

		$this->data['button_save'] = __('button_save');
		$this->data['button_cancel'] = __('button_cancel');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['merchant'])) {
			$this->data['error_merchant'] = $this->error['merchant'];
		} else {
			$this->data['error_merchant'] = '';
		}

		if (isset($this->error['signature'])) {
			$this->data['error_signature'] = $this->error['signature'];
		} else {
			$this->data['error_signature'] = '';
		}

		if (isset($this->error['type'])) {
			$this->data['error_type'] = $this->error['type'];
		} else {
			$this->data['error_type'] = '';
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
				'href' => $this->url->link('payment/liqpay', 'token=' . $this->session->data['token'], 'SSL')
		);

		$this->data['action'] = $this->url->link('payment/liqpay', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['liqpay_merchant'])) {
			$this->data['liqpay_merchant'] = $this->request->post['liqpay_merchant'];
		} else {
			$this->data['liqpay_merchant'] = $this->config->get('liqpay_merchant');
		}

		if (isset($this->request->post['liqpay_signature'])) {
			$this->data['liqpay_signature'] = $this->request->post['liqpay_signature'];
		} else {
			$this->data['liqpay_signature'] = $this->config->get('liqpay_signature');
		}

		if (isset($this->request->post['liqpay_type'])) {
			$this->data['liqpay_type'] = $this->request->post['liqpay_type'];
		} else {
			$this->data['liqpay_type'] = $this->config->get('liqpay_type');
		}

		if (isset($this->request->post['liqpay_total'])) {
			$this->data['liqpay_total'] = $this->request->post['liqpay_total'];
		} else {
			$this->data['liqpay_total'] = $this->config->get('liqpay_total');
		}

		if (isset($this->request->post['liqpay_order_status_id'])) {
			$this->data['liqpay_order_status_id'] = $this->request->post['liqpay_order_status_id'];
		} else {
			$this->data['liqpay_order_status_id'] = $this->config->get('liqpay_order_status_id');
		}

		$this->load->model('localisation/order_status');

		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['liqpay_geo_zone_id'])) {
			$this->data['liqpay_geo_zone_id'] = $this->request->post['liqpay_geo_zone_id'];
		} else {
			$this->data['liqpay_geo_zone_id'] = $this->config->get('liqpay_geo_zone_id');
		}

		$this->load->model('localisation/geo_zone');

		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['liqpay_status'])) {
			$this->data['liqpay_status'] = $this->request->post['liqpay_status'];
		} else {
			$this->data['liqpay_status'] = $this->config->get('liqpay_status');
		}

		if (isset($this->request->post['liqpay_sort_order'])) {
			$this->data['liqpay_sort_order'] = $this->request->post['liqpay_sort_order'];
		} else {
			$this->data['liqpay_sort_order'] = $this->config->get('liqpay_sort_order');
		}

		$this->template = 'payment/liqpay.tpl';
		$this->children = array(
				'common/header',
				'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'payment/liqpay')) {
			$this->error['warning'] = __('error_permission');
		}

		if (!$this->request->post['liqpay_merchant']) {
			$this->error['merchant'] = __('error_merchant');
		}

		if (!$this->request->post['liqpay_signature']) {
			$this->error['signature'] = __('error_signature');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>