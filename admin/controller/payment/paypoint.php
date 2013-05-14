<?php
class ControllerPaymentPayPoint extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('payment/paypoint');

		$this->document->setTitle(__('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('paypoint', $this->request->post);

			$this->session->data['success'] = __('text_success');

			$this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->data['heading_title'] = __('heading_title');

		$this->data['text_enabled'] = __('text_enabled');
		$this->data['text_disabled'] = __('text_disabled');
		$this->data['text_all_zones'] = __('text_all_zones');
		$this->data['text_yes'] = __('text_yes');
		$this->data['text_no'] = __('text_no');
		$this->data['text_live'] = __('text_live');
		$this->data['text_successful'] = __('text_successful');
		$this->data['text_fail'] = __('text_fail');

		$this->data['entry_merchant'] = __('entry_merchant');
		$this->data['entry_password'] = __('entry_password');
		$this->data['entry_test'] = __('entry_test');
		$this->data['entry_total'] = __('entry_total');
		$this->data['entry_order_status'] = __('entry_order_status');
		$this->data['entry_geo_zone'] = __('entry_geo_zone');
		$this->data['entry_status'] = __('entry_status');
		$this->data['entry_sort_order'] = __('entry_sort_order');

		$this->data['help_password'] = __('help_password');
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
			'href' => $this->url->link('payment/paypoint', 'token=' . $this->session->data['token'], 'SSL')
   		);

		$this->data['action'] = $this->url->link('payment/paypoint', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['paypoint_merchant'])) {
			$this->data['paypoint_merchant'] = $this->request->post['paypoint_merchant'];
		} else {
			$this->data['paypoint_merchant'] = $this->config->get('paypoint_merchant');
		}

		if (isset($this->request->post['paypoint_password'])) {
			$this->data['paypoint_password'] = $this->request->post['paypoint_password'];
		} else {
			$this->data['paypoint_password'] = $this->config->get('paypoint_password');
		}

		if (isset($this->request->post['paypoint_test'])) {
			$this->data['paypoint_test'] = $this->request->post['paypoint_test'];
		} else {
			$this->data['paypoint_test'] = $this->config->get('paypoint_test');
		}

		if (isset($this->request->post['paypoint_total'])) {
			$this->data['paypoint_total'] = $this->request->post['paypoint_total'];
		} else {
			$this->data['paypoint_total'] = $this->config->get('paypoint_total');
		}

		if (isset($this->request->post['paypoint_order_status_id'])) {
			$this->data['paypoint_order_status_id'] = $this->request->post['paypoint_order_status_id'];
		} else {
			$this->data['paypoint_order_status_id'] = $this->config->get('paypoint_order_status_id');
		}

		$this->load->model('localisation/order_status');

		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['paypoint_geo_zone_id'])) {
			$this->data['paypoint_geo_zone_id'] = $this->request->post['paypoint_geo_zone_id'];
		} else {
			$this->data['paypoint_geo_zone_id'] = $this->config->get('paypoint_geo_zone_id');
		}

		$this->load->model('localisation/geo_zone');

		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['paypoint_status'])) {
			$this->data['paypoint_status'] = $this->request->post['paypoint_status'];
		} else {
			$this->data['paypoint_status'] = $this->config->get('paypoint_status');
		}

		if (isset($this->request->post['paypoint_sort_order'])) {
			$this->data['paypoint_sort_order'] = $this->request->post['paypoint_sort_order'];
		} else {
			$this->data['paypoint_sort_order'] = $this->config->get('paypoint_sort_order');
		}

		$this->template = 'payment/paypoint.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'payment/paypoint')) {
			$this->error['warning'] = __('error_permission');
		}

		if (!$this->request->post['paypoint_merchant']) {
			$this->error['merchant'] = __('error_merchant');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>