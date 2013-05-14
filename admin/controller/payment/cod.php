<?php 
class ControllerPaymentCod extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('payment/cod');

		$this->document->setTitle(__('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('cod', $this->request->post);

			$this->session->data['success'] = __('text_success');
				
			$this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->data['heading_title'] = __('heading_title');

		$this->data['text_enabled'] = __('text_enabled');
		$this->data['text_disabled'] = __('text_disabled');
		$this->data['text_all_zones'] = __('text_all_zones');

		$this->data['entry_order_status'] = __('entry_order_status');
		$this->data['entry_total'] = __('entry_total');
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
				'href' => $this->url->link('payment/cod', 'token=' . $this->session->data['token'], 'SSL')
		);

		$this->data['action'] = $this->url->link('payment/cod', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['cod_total'])) {
			$this->data['cod_total'] = $this->request->post['cod_total'];
		} else {
			$this->data['cod_total'] = $this->config->get('cod_total');
		}

		if (isset($this->request->post['cod_order_status_id'])) {
			$this->data['cod_order_status_id'] = $this->request->post['cod_order_status_id'];
		} else {
			$this->data['cod_order_status_id'] = $this->config->get('cod_order_status_id');
		}

		$this->load->model('localisation/order_status');

		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['cod_geo_zone_id'])) {
			$this->data['cod_geo_zone_id'] = $this->request->post['cod_geo_zone_id'];
		} else {
			$this->data['cod_geo_zone_id'] = $this->config->get('cod_geo_zone_id');
		}

		$this->load->model('localisation/geo_zone');

		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['cod_status'])) {
			$this->data['cod_status'] = $this->request->post['cod_status'];
		} else {
			$this->data['cod_status'] = $this->config->get('cod_status');
		}

		if (isset($this->request->post['cod_sort_order'])) {
			$this->data['cod_sort_order'] = $this->request->post['cod_sort_order'];
		} else {
			$this->data['cod_sort_order'] = $this->config->get('cod_sort_order');
		}

		$this->template = 'payment/cod.tpl';
		$this->children = array(
				'common/header',
				'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'payment/cod')) {
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