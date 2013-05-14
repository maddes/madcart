<?php 
class ControllerPaymentPPPro extends Controller {
	private $error = array(); 

	public function index() {
		$this->language->load('payment/pp_pro');

		$this->document->setTitle(__('heading_title'));
		
		$this->load->model('setting/setting');
			
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('pp_pro', $this->request->post);				
			
			$this->session->data['success'] = __('text_success');

			$this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->data['heading_title'] = __('heading_title');

		$this->data['text_enabled'] = __('text_enabled');
		$this->data['text_disabled'] = __('text_disabled');
		$this->data['text_all_zones'] = __('text_all_zones');
		$this->data['text_yes'] = __('text_yes');
		$this->data['text_no'] = __('text_no');
		$this->data['text_authorization'] = __('text_authorization');
		$this->data['text_sale'] = __('text_sale');
		
		$this->data['entry_username'] = __('entry_username');
		$this->data['entry_password'] = __('entry_password');
		$this->data['entry_signature'] = __('entry_signature');
		$this->data['entry_test'] = __('entry_test');
		$this->data['entry_transaction'] = __('entry_transaction');
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

 		if (isset($this->error['username'])) {
			$this->data['error_username'] = $this->error['username'];
		} else {
			$this->data['error_username'] = '';
		}
		
 		if (isset($this->error['password'])) {
			$this->data['error_password'] = $this->error['password'];
		} else {
			$this->data['error_password'] = '';
		}
		
 		if (isset($this->error['signature'])) {
			$this->data['error_signature'] = $this->error['signature'];
		} else {
			$this->data['error_signature'] = '';
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
			'href' => $this->url->link('payment/pp_pro', 'token=' . $this->session->data['token'], 'SSL')
   		);
				
		$this->data['action'] = $this->url->link('payment/pp_pro', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['pp_pro_username'])) {
			$this->data['pp_pro_username'] = $this->request->post['pp_pro_username'];
		} else {
			$this->data['pp_pro_username'] = $this->config->get('pp_pro_username');
		}
		
		if (isset($this->request->post['pp_pro_password'])) {
			$this->data['pp_pro_password'] = $this->request->post['pp_pro_password'];
		} else {
			$this->data['pp_pro_password'] = $this->config->get('pp_pro_password');
		}
				
		if (isset($this->request->post['pp_pro_signature'])) {
			$this->data['pp_pro_signature'] = $this->request->post['pp_pro_signature'];
		} else {
			$this->data['pp_pro_signature'] = $this->config->get('pp_pro_signature');
		}
		
		if (isset($this->request->post['pp_pro_test'])) {
			$this->data['pp_pro_test'] = $this->request->post['pp_pro_test'];
		} else {
			$this->data['pp_pro_test'] = $this->config->get('pp_pro_test');
		}
		
		if (isset($this->request->post['pp_pro_method'])) {
			$this->data['pp_pro_transaction'] = $this->request->post['pp_pro_transaction'];
		} else {
			$this->data['pp_pro_transaction'] = $this->config->get('pp_pro_transaction');
		}
		
		if (isset($this->request->post['pp_pro_total'])) {
			$this->data['pp_pro_total'] = $this->request->post['pp_pro_total'];
		} else {
			$this->data['pp_pro_total'] = $this->config->get('pp_pro_total'); 
		} 
				
		if (isset($this->request->post['pp_pro_order_status_id'])) {
			$this->data['pp_pro_order_status_id'] = $this->request->post['pp_pro_order_status_id'];
		} else {
			$this->data['pp_pro_order_status_id'] = $this->config->get('pp_pro_order_status_id'); 
		} 

		$this->load->model('localisation/order_status');
		
		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
		
		if (isset($this->request->post['pp_pro_geo_zone_id'])) {
			$this->data['pp_pro_geo_zone_id'] = $this->request->post['pp_pro_geo_zone_id'];
		} else {
			$this->data['pp_pro_geo_zone_id'] = $this->config->get('pp_pro_geo_zone_id'); 
		} 
		
		$this->load->model('localisation/geo_zone');
										
		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
		
		if (isset($this->request->post['pp_pro_status'])) {
			$this->data['pp_pro_status'] = $this->request->post['pp_pro_status'];
		} else {
			$this->data['pp_pro_status'] = $this->config->get('pp_pro_status');
		}
		
		if (isset($this->request->post['pp_pro_sort_order'])) {
			$this->data['pp_pro_sort_order'] = $this->request->post['pp_pro_sort_order'];
		} else {
			$this->data['pp_pro_sort_order'] = $this->config->get('pp_pro_sort_order');
		}

		$this->template = 'payment/pp_pro.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'payment/pp_pro')) {
			$this->error['warning'] = __('error_permission');
		}
		
		if (!$this->request->post['pp_pro_username']) {
			$this->error['username'] = __('error_username');
		}

		if (!$this->request->post['pp_pro_password']) {
			$this->error['password'] = __('error_password');
		}

		if (!$this->request->post['pp_pro_signature']) {
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