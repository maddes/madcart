<?php
class ControllerShippingFlat extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('shipping/flat');

		$this->document->setTitle(__('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('flat', $this->request->post);
				
			$this->session->data['success'] = __('text_success');

			$this->redirect($this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->data['heading_title'] = __('heading_title');

		$this->data['text_enabled'] = __('text_enabled');
		$this->data['text_disabled'] = __('text_disabled');
		$this->data['text_all_zones'] = __('text_all_zones');
		$this->data['text_none'] = __('text_none');

		$this->data['entry_cost'] = __('entry_cost');
		$this->data['entry_tax_class'] = __('entry_tax_class');
		$this->data['entry_geo_zone'] = __('entry_geo_zone');
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
				'text' => __('text_shipping'),
				'href' => $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL')
		);

		$this->data['breadcrumbs'][] = array(
				'text' => __('heading_title'),
				'href' => $this->url->link('shipping/flat', 'token=' . $this->session->data['token'], 'SSL')
		);

		$this->data['action'] = $this->url->link('shipping/flat', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['flat_cost'])) {
			$this->data['flat_cost'] = $this->request->post['flat_cost'];
		} else {
			$this->data['flat_cost'] = $this->config->get('flat_cost');
		}

		if (isset($this->request->post['flat_tax_class_id'])) {
			$this->data['flat_tax_class_id'] = $this->request->post['flat_tax_class_id'];
		} else {
			$this->data['flat_tax_class_id'] = $this->config->get('flat_tax_class_id');
		}

		$this->load->model('localisation/tax_class');

		$this->data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();

		if (isset($this->request->post['flat_geo_zone_id'])) {
			$this->data['flat_geo_zone_id'] = $this->request->post['flat_geo_zone_id'];
		} else {
			$this->data['flat_geo_zone_id'] = $this->config->get('flat_geo_zone_id');
		}

		$this->load->model('localisation/geo_zone');

		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['flat_status'])) {
			$this->data['flat_status'] = $this->request->post['flat_status'];
		} else {
			$this->data['flat_status'] = $this->config->get('flat_status');
		}

		if (isset($this->request->post['flat_sort_order'])) {
			$this->data['flat_sort_order'] = $this->request->post['flat_sort_order'];
		} else {
			$this->data['flat_sort_order'] = $this->config->get('flat_sort_order');
		}

		$this->template = 'shipping/flat.tpl';
		$this->children = array(
				'common/header',
				'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'shipping/flat')) {
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