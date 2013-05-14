<?php
class ControllerPaymentPayza extends Controller {
	private $error = array(); 

	public function index() {
		$this->language->load('payment/payza');

		$this->document->setTitle(__('heading_title'));
		
		$this->load->model('setting/setting');
			
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('payza', $this->request->post);				
			
			$this->session->data['success'] = __('text_success');

			$this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->data['heading_title'] = __('heading_title');

		$this->data['text_enabled'] = __('text_enabled');
		$this->data['text_disabled'] = __('text_disabled');
		$this->data['text_all_zones'] = __('text_all_zones');
		
		$this->data['entry_merchant'] = __('entry_merchant');
		$this->data['entry_security'] = __('entry_security');
		$this->data['entry_callback'] = __('entry_callback');
		$this->data['entry_total'] = __('entry_total');	
		$this->data['entry_order_status'] = __('entry_order_status');		
		$this->data['entry_geo_zone'] = __('entry_geo_zone');
		$this->data['entry_status'] = __('entry_status');
		$this->data['entry_sort_order'] = __('entry_sort_order');

		$this->data['help_callback'] = __('help_callback');
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

 		if (isset($this->error['security'])) {
			$this->data['error_security'] = $this->error['security'];
		} else {
			$this->data['error_security'] = '';
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
			'href' => $this->url->link('payment/payza', 'token=' . $this->session->data['token'], 'SSL')
   		);
				
		$this->data['action'] = $this->url->link('payment/payza', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');
		
		if (isset($this->request->post['payza_merchant'])) {
			$this->data['payza_merchant'] = $this->request->post['payza_merchant'];
		} else {
			$this->data['payza_merchant'] = $this->config->get('payza_merchant');
		}

		if (isset($this->request->post['payza_security'])) {
			$this->data['payza_security'] = $this->request->post['payza_security'];
		} else {
			$this->data['payza_security'] = $this->config->get('payza_security');
		}
		
		$this->data['callback'] = HTTP_CATALOG . 'index.php?route=payment/payza/callback';
		
		if (isset($this->request->post['payza_total'])) {
			$this->data['payza_total'] = $this->request->post['payza_total'];
		} else {
			$this->data['payza_total'] = $this->config->get('payza_total'); 
		} 
				
		if (isset($this->request->post['payza_order_status_id'])) {
			$this->data['payza_order_status_id'] = $this->request->post['payza_order_status_id'];
		} else {
			$this->data['payza_order_status_id'] = $this->config->get('payza_order_status_id'); 
		} 
		
		$this->load->model('localisation/order_status');
		
		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
		
		if (isset($this->request->post['payza_geo_zone_id'])) {
			$this->data['payza_geo_zone_id'] = $this->request->post['payza_geo_zone_id'];
		} else {
			$this->data['payza_geo_zone_id'] = $this->config->get('payza_geo_zone_id'); 
		} 

		$this->load->model('localisation/geo_zone');
										
		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
		
		if (isset($this->request->post['payza_status'])) {
			$this->data['payza_status'] = $this->request->post['payza_status'];
		} else {
			$this->data['payza_status'] = $this->config->get('payza_status');
		}
		
		if (isset($this->request->post['payza_sort_order'])) {
			$this->data['payza_sort_order'] = $this->request->post['payza_sort_order'];
		} else {
			$this->data['payza_sort_order'] = $this->config->get('payza_sort_order');
		}

		$this->template = 'payment/payza.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'payment/payza')) {
			$this->error['warning'] = __('error_permission');
		}
		
		if (!$this->request->post['payza_merchant']) {
			$this->error['merchant'] = __('error_merchant');
		}

		if (!$this->request->post['payza_security']) {
			$this->error['security'] = __('error_security');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>