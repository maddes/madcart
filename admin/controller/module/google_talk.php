<?php
class ControllerModuleGoogleTalk extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->language->load('module/google_talk');

		$this->document->setTitle(__('heading_title'));
		
		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('google_talk', $this->request->post);		
					
			$this->session->data['success'] = __('text_success');
						
			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
				
		$this->data['heading_title'] = __('heading_title');

		$this->data['text_enabled'] = __('text_enabled');
		$this->data['text_disabled'] = __('text_disabled');
		$this->data['text_content_top'] = __('text_content_top');
		$this->data['text_content_bottom'] = __('text_content_bottom');		
		$this->data['text_column_left'] = __('text_column_left');
		$this->data['text_column_right'] = __('text_column_right');
		
		$this->data['entry_code'] = __('entry_code');
		$this->data['entry_layout'] = __('entry_layout');
		$this->data['entry_position'] = __('entry_position');
		$this->data['entry_status'] = __('entry_status');
		$this->data['entry_sort_order'] = __('entry_sort_order');
		
		$this->data['help_code'] = __('help_code');
		
		$this->data['button_save'] = __('button_save');
		$this->data['button_cancel'] = __('button_cancel');
		$this->data['button_add_module'] = __('button_add_module');
		$this->data['button_remove'] = __('button_remove');
		
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
 		if (isset($this->error['code'])) {
			$this->data['error_code'] = $this->error['code'];
		} else {
			$this->data['error_code'] = '';
		}
		
  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text' => __('text_home'),
			'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL')
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text' => __('text_module'),
			'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text' => __('heading_title'),
			'href' => $this->url->link('module/google_talk', 'token=' . $this->session->data['token'], 'SSL')
   		);
		
		$this->data['action'] = $this->url->link('module/google_talk', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['google_talk_code'])) {
			$this->data['google_talk_code'] = $this->request->post['google_talk_code'];
		} else {
			$this->data['google_talk_code'] = $this->config->get('google_talk_code');
		}	
		
		$this->data['modules'] = array();
		
		if (isset($this->request->post['google_talk_module'])) {
			$this->data['modules'] = $this->request->post['google_talk_module'];
		} elseif ($this->config->get('google_talk_module')) { 
			$this->data['modules'] = $this->config->get('google_talk_module');
		}			
				
		$this->load->model('design/layout');
		
		$this->data['layouts'] = $this->model_design_layout->getLayouts();

		$this->template = 'module/google_talk.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
	
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/google_talk')) {
			$this->error['warning'] = __('error_permission');
		}
		
		if (!$this->request->post['google_talk_code']) {
			$this->error['code'] = __('error_code');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>