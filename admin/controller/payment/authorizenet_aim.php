<?php 
class ControllerPaymentAuthorizenetAim extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('payment/authorizenet_aim');

		$this->document->setTitle(__('heading_title'));

		$this->load->model('setting/setting');
			
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('authorizenet_aim', $this->request->post);
				
			$this->session->data['success'] = __('text_success');

			$this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->data['heading_title'] = __('heading_title');

		$this->data['text_enabled'] = __('text_enabled');
		$this->data['text_disabled'] = __('text_disabled');
		$this->data['text_all_zones'] = __('text_all_zones');
		$this->data['text_test'] = __('text_test');
		$this->data['text_live'] = __('text_live');
		$this->data['text_authorization'] = __('text_authorization');
		$this->data['text_capture'] = __('text_capture');

		$this->data['entry_login'] = __('entry_login');
		$this->data['entry_key'] = __('entry_key');
		$this->data['entry_hash'] = __('entry_hash');
		$this->data['entry_server'] = __('entry_server');
		$this->data['entry_mode'] = __('entry_mode');
		$this->data['entry_method'] = __('entry_method');
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

		if (isset($this->error['login'])) {
			$this->data['error_login'] = $this->error['login'];
		} else {
			$this->data['error_login'] = '';
		}

		if (isset($this->error['key'])) {
			$this->data['error_key'] = $this->error['key'];
		} else {
			$this->data['error_key'] = '';
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
				'href' => $this->url->link('payment/authorizenet_aim', 'token=' . $this->session->data['token'], 'SSL')
		);

		$this->data['action'] = $this->url->link('payment/authorizenet_aim', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['authorizenet_aim_login'])) {
			$this->data['authorizenet_aim_login'] = $this->request->post['authorizenet_aim_login'];
		} else {
			$this->data['authorizenet_aim_login'] = $this->config->get('authorizenet_aim_login');
		}

		if (isset($this->request->post['authorizenet_aim_key'])) {
			$this->data['authorizenet_aim_key'] = $this->request->post['authorizenet_aim_key'];
		} else {
			$this->data['authorizenet_aim_key'] = $this->config->get('authorizenet_aim_key');
		}

		if (isset($this->request->post['authorizenet_aim_hash'])) {
			$this->data['authorizenet_aim_hash'] = $this->request->post['authorizenet_aim_hash'];
		} else {
			$this->data['authorizenet_aim_hash'] = $this->config->get('authorizenet_aim_hash');
		}

		if (isset($this->request->post['authorizenet_aim_server'])) {
			$this->data['authorizenet_aim_server'] = $this->request->post['authorizenet_aim_server'];
		} else {
			$this->data['authorizenet_aim_server'] = $this->config->get('authorizenet_aim_server');
		}

		if (isset($this->request->post['authorizenet_aim_mode'])) {
			$this->data['authorizenet_aim_mode'] = $this->request->post['authorizenet_aim_mode'];
		} else {
			$this->data['authorizenet_aim_mode'] = $this->config->get('authorizenet_aim_mode');
		}

		if (isset($this->request->post['authorizenet_aim_method'])) {
			$this->data['authorizenet_aim_method'] = $this->request->post['authorizenet_aim_method'];
		} else {
			$this->data['authorizenet_aim_method'] = $this->config->get('authorizenet_aim_method');
		}

		if (isset($this->request->post['authorizenet_aim_total'])) {
			$this->data['authorizenet_aim_total'] = $this->request->post['authorizenet_aim_total'];
		} else {
			$this->data['authorizenet_aim_total'] = $this->config->get('authorizenet_aim_total');
		}

		if (isset($this->request->post['authorizenet_aim_order_status_id'])) {
			$this->data['authorizenet_aim_order_status_id'] = $this->request->post['authorizenet_aim_order_status_id'];
		} else {
			$this->data['authorizenet_aim_order_status_id'] = $this->config->get('authorizenet_aim_order_status_id');
		}

		$this->load->model('localisation/order_status');

		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['authorizenet_aim_geo_zone_id'])) {
			$this->data['authorizenet_aim_geo_zone_id'] = $this->request->post['authorizenet_aim_geo_zone_id'];
		} else {
			$this->data['authorizenet_aim_geo_zone_id'] = $this->config->get('authorizenet_aim_geo_zone_id');
		}

		$this->load->model('localisation/geo_zone');

		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['authorizenet_aim_status'])) {
			$this->data['authorizenet_aim_status'] = $this->request->post['authorizenet_aim_status'];
		} else {
			$this->data['authorizenet_aim_status'] = $this->config->get('authorizenet_aim_status');
		}

		if (isset($this->request->post['authorizenet_aim_sort_order'])) {
			$this->data['authorizenet_aim_sort_order'] = $this->request->post['authorizenet_aim_sort_order'];
		} else {
			$this->data['authorizenet_aim_sort_order'] = $this->config->get('authorizenet_aim_sort_order');
		}

		$this->template = 'payment/authorizenet_aim.tpl';
		$this->children = array(
				'common/header',
				'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'payment/authorizenet_aim')) {
			$this->error['warning'] = __('error_permission');
		}

		if (!$this->request->post['authorizenet_aim_login']) {
			$this->error['login'] = __('error_login');
		}

		if (!$this->request->post['authorizenet_aim_key']) {
			$this->error['key'] = __('error_key');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>