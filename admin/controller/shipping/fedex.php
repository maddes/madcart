<?php
class ControllerShippingFedex extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('shipping/fedex');

		$this->document->setTitle(__('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('fedex', $this->request->post);
				
			$this->session->data['success'] = __('text_success');

			$this->redirect($this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->data['heading_title'] = __('heading_title');

		$this->data['text_enabled'] = __('text_enabled');
		$this->data['text_disabled'] = __('text_disabled');
		$this->data['text_yes'] = __('text_yes');
		$this->data['text_no'] = __('text_no');
		$this->data['text_select_all'] = __('text_select_all');
		$this->data['text_unselect_all'] = __('text_unselect_all');
		$this->data['text_all_zones'] = __('text_all_zones');
		$this->data['text_none'] = __('text_none');
		$this->data['text_regular_pickup'] = __('text_regular_pickup');
		$this->data['text_request_courier'] = __('text_request_courier');
		$this->data['text_drop_box'] = __('text_drop_box');
		$this->data['text_business_service_center'] = __('text_business_service_center');
		$this->data['text_station'] = __('text_station');

		$this->data['text_fedex_envelope'] = __('text_fedex_envelope');
		$this->data['text_fedex_pak'] = __('text_fedex_pak');
		$this->data['text_fedex_box'] = __('text_fedex_box');
		$this->data['text_fedex_tube'] = __('text_fedex_tube');
		$this->data['text_fedex_10kg_box'] = __('text_fedex_10kg_box');
		$this->data['text_fedex_25kg_box'] = __('text_fedex_25kg_box');
		$this->data['text_your_packaging'] = __('text_your_packaging');
		$this->data['text_list_rate'] = __('text_list_rate');
		$this->data['text_account_rate'] = __('text_account_rate');

		$this->data['entry_key'] = __('entry_key');
		$this->data['entry_password'] = __('entry_password');
		$this->data['entry_account'] = __('entry_account');
		$this->data['entry_meter'] = __('entry_meter');
		$this->data['entry_postcode'] = __('entry_postcode');
		$this->data['entry_test'] = __('entry_test');
		$this->data['entry_service'] = __('entry_service');
		$this->data['entry_dropoff_type'] = __('entry_dropoff_type');
		$this->data['entry_packaging_type'] = __('entry_packaging_type');
		$this->data['entry_rate_type'] = __('entry_rate_type');
		$this->data['entry_display_time'] = __('entry_display_time');
		$this->data['entry_display_weight'] = __('entry_display_weight');
		$this->data['entry_weight_class'] = __('entry_weight_class');
		$this->data['entry_tax_class'] = __('entry_tax_class');
		$this->data['entry_geo_zone'] = __('entry_geo_zone');
		$this->data['entry_status'] = __('entry_status');
		$this->data['entry_sort_order'] = __('entry_sort_order');

		$this->data['help_display_time'] = __('help_display_time');
		$this->data['help_display_weight'] = __('help_display_weight');
		$this->data['help_weight_class'] = __('help_weight_class');

		$this->data['button_save'] = __('button_save');
		$this->data['button_cancel'] = __('button_cancel');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['key'])) {
			$this->data['error_key'] = $this->error['key'];
		} else {
			$this->data['error_key'] = '';
		}

		if (isset($this->error['password'])) {
			$this->data['error_password'] = $this->error['password'];
		} else {
			$this->data['error_password'] = '';
		}

		if (isset($this->error['account'])) {
			$this->data['error_account'] = $this->error['account'];
		} else {
			$this->data['error_account'] = '';
		}
			
		if (isset($this->error['meter'])) {
			$this->data['error_meter'] = $this->error['meter'];
		} else {
			$this->data['error_meter'] = '';
		}

		if (isset($this->error['postcode'])) {
			$this->data['error_postcode'] = $this->error['postcode'];
		} else {
			$this->data['error_postcode'] = '';
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
				'href' => $this->url->link('shipping/fedex', 'token=' . $this->session->data['token'], 'SSL')
		);

		$this->data['action'] = $this->url->link('shipping/fedex', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['fedex_key'])) {
			$this->data['fedex_key'] = $this->request->post['fedex_key'];
		} else {
			$this->data['fedex_key'] = $this->config->get('fedex_key');
		}

		if (isset($this->request->post['fedex_password'])) {
			$this->data['fedex_password'] = $this->request->post['fedex_password'];
		} else {
			$this->data['fedex_password'] = $this->config->get('fedex_password');
		}
			
		if (isset($this->request->post['fedex_account'])) {
			$this->data['fedex_account'] = $this->request->post['fedex_account'];
		} else {
			$this->data['fedex_account'] = $this->config->get('fedex_account');
		}

		if (isset($this->request->post['fedex_meter'])) {
			$this->data['fedex_meter'] = $this->request->post['fedex_meter'];
		} else {
			$this->data['fedex_meter'] = $this->config->get('fedex_meter');
		}

		if (isset($this->request->post['fedex_postcode'])) {
			$this->data['fedex_postcode'] = $this->request->post['fedex_postcode'];
		} else {
			$this->data['fedex_postcode'] = $this->config->get('fedex_postcode');
		}

		if (isset($this->request->post['fedex_test'])) {
			$this->data['fedex_test'] = $this->request->post['fedex_test'];
		} else {
			$this->data['fedex_test'] = $this->config->get('fedex_test');
		}

		if (isset($this->request->post['fedex_service'])) {
			$this->data['fedex_service'] = $this->request->post['fedex_service'];
		} elseif ($this->config->has('fedex_service')) {
			$this->data['fedex_service'] = $this->config->get('fedex_service');
		} else {
			$this->data['fedex_service'] = array();
		}

		$this->data['services'] = array();

		$this->data['services'][] = array(
				'text'  => __('text_europe_first_international_priority'),
				'value' => 'EUROPE_FIRST_INTERNATIONAL_PRIORITY'
		);
			
		$this->data['services'][] = array(
				'text'  => __('text_fedex_1_day_freight'),
				'value' => 'FEDEX_1_DAY_FREIGHT'
		);

		$this->data['services'][] = array(
				'text'  => __('text_fedex_2_day'),
				'value' => 'FEDEX_2_DAY'
		);

		$this->data['services'][] = array(
				'text'  => __('text_fedex_2_day_am'),
				'value' => 'FEDEX_2_DAY_AM'
		);

		$this->data['services'][] = array(
				'text'  => __('text_fedex_2_day_freight'),
				'value' => 'FEDEX_2_DAY_FREIGHT'
		);

		$this->data['services'][] = array(
				'text'  => __('text_fedex_3_day_freight'),
				'value' => 'FEDEX_3_DAY_FREIGHT'
		);

		$this->data['services'][] = array(
				'text'  => __('text_fedex_express_saver'),
				'value' => 'FEDEX_EXPRESS_SAVER'
		);
		 
		$this->data['services'][] = array(
				'text'  => __('text_fedex_first_freight'),
				'value' => 'FEDEX_FIRST_FREIGHT'
		);

		$this->data['services'][] = array(
				'text'  => __('text_fedex_freight_economy'),
				'value' => 'FEDEX_FREIGHT_ECONOMY'
		);

		$this->data['services'][] = array(
				'text'  => __('text_fedex_freight_priority'),
				'value' => 'FEDEX_FREIGHT_PRIORITY'
		);

		$this->data['services'][] = array(
				'text'  => __('text_fedex_ground'),
				'value' => 'FEDEX_GROUND'
		);

		$this->data['services'][] = array(
				'text'  => __('text_first_overnight'),
				'value' => 'FIRST_OVERNIGHT'
		);

		$this->data['services'][] = array(
				'text'  => __('text_ground_home_delivery'),
				'value' => 'GROUND_HOME_DELIVERY'
		);

		$this->data['services'][] = array(
				'text'  => __('text_international_economy'),
				'value' => 'INTERNATIONAL_ECONOMY'
		);

		$this->data['services'][] = array(
				'text'  => __('text_international_economy_freight'),
				'value' => 'INTERNATIONAL_ECONOMY_FREIGHT'
		);

		$this->data['services'][] = array(
				'text'  => __('text_international_first'),
				'value' => 'INTERNATIONAL_FIRST'
		);

		$this->data['services'][] = array(
				'text'  => __('text_international_priority'),
				'value' => 'INTERNATIONAL_PRIORITY'
		);

		$this->data['services'][] = array(
				'text'  => __('text_international_priority_freight'),
				'value' => 'INTERNATIONAL_PRIORITY_FREIGHT'
		);

		$this->data['services'][] = array(
				'text'  => __('text_priority_overnight'),
				'value' => 'PRIORITY_OVERNIGHT'
		);

		$this->data['services'][] = array(
				'text'  => __('text_smart_post'),
				'value' => 'SMART_POST'
		);

		$this->data['services'][] = array(
				'text'  => __('text_standard_overnight'),
				'value' => 'STANDARD_OVERNIGHT'
		);

		if (isset($this->request->post['fedex_dropoff_type'])) {
			$this->data['fedex_dropoff_type'] = $this->request->post['fedex_dropoff_type'];
		} else {
			$this->data['fedex_dropoff_type'] = $this->config->get('fedex_dropoff_type');
		}

		if (isset($this->request->post['fedex_packaging_type'])) {
			$this->data['fedex_packaging_type'] = $this->request->post['fedex_packaging_type'];
		} else {
			$this->data['fedex_packaging_type'] = $this->config->get('fedex_packaging_type');
		}

		if (isset($this->request->post['fedex_rate_type'])) {
			$this->data['fedex_rate_type'] = $this->request->post['fedex_rate_type'];
		} else {
			$this->data['fedex_rate_type'] = $this->config->get('fedex_rate_type');
		}
			
		if (isset($this->request->post['fedex_destination_type'])) {
			$this->data['fedex_destination_type'] = $this->request->post['fedex_destination_type'];
		} else {
			$this->data['fedex_destination_type'] = $this->config->get('fedex_destination_type');
		}

		if (isset($this->request->post['fedex_display_time'])) {
			$this->data['fedex_display_time'] = $this->request->post['fedex_display_time'];
		} else {
			$this->data['fedex_display_time'] = $this->config->get('fedex_display_time');
		}

		if (isset($this->request->post['fedex_display_weight'])) {
			$this->data['fedex_display_weight'] = $this->request->post['fedex_display_weight'];
		} else {
			$this->data['fedex_display_weight'] = $this->config->get('fedex_display_weight');
		}

		if (isset($this->request->post['fedex_weight_class_id'])) {
			$this->data['fedex_weight_class_id'] = $this->request->post['fedex_weight_class_id'];
		} else {
			$this->data['fedex_weight_class_id'] = $this->config->get('fedex_weight_class_id');
		}

		$this->load->model('localisation/weight_class');

		$this->data['weight_classes'] = $this->model_localisation_weight_class->getWeightClasses();

		if (isset($this->request->post['fedex_tax_class_id'])) {
			$this->data['fedex_tax_class_id'] = $this->request->post['fedex_tax_class_id'];
		} else {
			$this->data['fedex_tax_class_id'] = $this->config->get('fedex_tax_class_id');
		}

		$this->load->model('localisation/tax_class');

		$this->data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();

		if (isset($this->request->post['fedex_geo_zone_id'])) {
			$this->data['fedex_geo_zone_id'] = $this->request->post['fedex_geo_zone_id'];
		} else {
			$this->data['fedex_geo_zone_id'] = $this->config->get('fedex_geo_zone_id');
		}

		$this->load->model('localisation/geo_zone');

		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['fedex_status'])) {
			$this->data['fedex_status'] = $this->request->post['fedex_status'];
		} else {
			$this->data['fedex_status'] = $this->config->get('fedex_status');
		}

		if (isset($this->request->post['fedex_sort_order'])) {
			$this->data['fedex_sort_order'] = $this->request->post['fedex_sort_order'];
		} else {
			$this->data['fedex_sort_order'] = $this->config->get('fedex_sort_order');
		}

		$this->template = 'shipping/fedex.tpl';
		$this->children = array(
				'common/header',
				'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'shipping/fedex')) {
			$this->error['warning'] = __('error_permission');
		}

		if (!$this->request->post['fedex_key']) {
			$this->error['key'] = __('error_key');
		}

		if (!$this->request->post['fedex_password']) {
			$this->error['password'] = __('error_password');
		}

		if (!$this->request->post['fedex_account']) {
			$this->error['account'] = __('error_account');
		}

		if (!$this->request->post['fedex_meter']) {
			$this->error['meter'] = __('error_meter');
		}

		if (!$this->request->post['fedex_postcode']) {
			$this->error['postcode'] = __('error_postcode');
		}

		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}
?>