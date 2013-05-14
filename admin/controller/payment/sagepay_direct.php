<?php 
class ControllerPaymentSagepayDirect extends Controller {
	private $error = array(); 

	public function index() {
		$this->language->load('payment/sagepay_direct');

		$this->document->setTitle(__('heading_title'));
		
		$this->load->model('setting/setting');
			
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('sagepay_direct', $this->request->post);				
			
			$this->session->data['success'] = __('text_success');

			$this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->data['heading_title'] = __('heading_title');

		$this->data['text_enabled'] = __('text_enabled');
		$this->data['text_disabled'] = __('text_disabled');
		$this->data['text_all_zones'] = __('text_all_zones');
		$this->data['text_sim'] = __('text_sim');
		$this->data['text_test'] = __('text_test');
		$this->data['text_live'] = __('text_live');
		$this->data['text_payment'] = __('text_payment');
		$this->data['text_defered'] = __('text_defered');
		$this->data['text_authenticate'] = __('text_authenticate');
		
		$this->data['entry_vendor'] = __('entry_vendor');
		$this->data['entry_test'] = __('entry_test');
		$this->data['entry_transaction'] = __('entry_transaction');
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

 		if (isset($this->error['vendor'])) {
			$this->data['error_vendor'] = $this->error['vendor'];
		} else {
			$this->data['error_vendor'] = '';
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
			'href' => $this->url->link('payment/sagepay_direct', 'token=' . $this->session->data['token'], 'SSL')
   		);
				
		$this->data['action'] = $this->url->link('payment/sagepay_direct', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');
		
		if (isset($this->request->post['sagepay_direct_vendor'])) {
			$this->data['sagepay_direct_vendor'] = $this->request->post['sagepay_direct_vendor'];
		} else {
			$this->data['sagepay_direct_vendor'] = $this->config->get('sagepay_direct_vendor');
		}
		
		if (isset($this->request->post['sagepay_direct_password'])) {
			$this->data['sagepay_direct_password'] = $this->request->post['sagepay_direct_password'];
		} else {
			$this->data['sagepay_direct_password'] = $this->config->get('sagepay_direct_password');
		}


		if (isset($this->request->post['sagepay_direct_test'])) {
			$this->data['sagepay_direct_test'] = $this->request->post['sagepay_direct_test'];
		} else {
			$this->data['sagepay_direct_test'] = $this->config->get('sagepay_direct_test');
		}
		
		if (isset($this->request->post['sagepay_direct_transaction'])) {
			$this->data['sagepay_direct_transaction'] = $this->request->post['sagepay_direct_transaction'];
		} else {
			$this->data['sagepay_direct_transaction'] = $this->config->get('sagepay_direct_transaction');
		}
		
		if (isset($this->request->post['sagepay_direct_total'])) {
			$this->data['sagepay_direct_total'] = $this->request->post['sagepay_direct_total'];
		} else {
			$this->data['sagepay_direct_total'] = $this->config->get('sagepay_direct_total'); 
		} 
				
		if (isset($this->request->post['sagepay_direct_order_status_id'])) {
			$this->data['sagepay_direct_order_status_id'] = $this->request->post['sagepay_direct_order_status_id'];
		} else {
			$this->data['sagepay_direct_order_status_id'] = $this->config->get('sagepay_direct_order_status_id'); 
		} 

		$this->load->model('localisation/order_status');
		
		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
		
		if (isset($this->request->post['sagepay_direct_geo_zone_id'])) {
			$this->data['sagepay_direct_geo_zone_id'] = $this->request->post['sagepay_direct_geo_zone_id'];
		} else {
			$this->data['sagepay_direct_geo_zone_id'] = $this->config->get('sagepay_direct_geo_zone_id'); 
		} 
		
		$this->load->model('localisation/geo_zone');
										
		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
		
		if (isset($this->request->post['sagepay_direct_status'])) {
			$this->data['sagepay_direct_status'] = $this->request->post['sagepay_direct_status'];
		} else {
			$this->data['sagepay_direct_status'] = $this->config->get('sagepay_direct_status');
		}
		
		if (isset($this->request->post['sagepay_direct_sort_order'])) {
			$this->data['sagepay_direct_sort_order'] = $this->request->post['sagepay_direct_sort_order'];
		} else {
			$this->data['sagepay_direct_sort_order'] = $this->config->get('sagepay_direct_sort_order');
		}

		$this->template = 'payment/sagepay_direct.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'payment/sagepay_direct')) {
			$this->error['warning'] = __('error_permission');
		}
		
		if (!$this->request->post['sagepay_direct_vendor']) {
			$this->error['vendor'] = __('error_vendor');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>