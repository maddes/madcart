<?php
class ControllerModuleSlideshow extends Controller {
	private $error = array(); 
	
	public function index() {   
		$this->language->load('module/slideshow');

		$this->document->setTitle(__('heading_title'));
		
		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('slideshow', $this->request->post);		
					
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

		$this->data['entry_banner'] = __('entry_banner');
		$this->data['entry_dimension'] = __('entry_dimension');
		$this->data['entry_width'] = __('entry_width');
		$this->data['entry_height'] = __('entry_height');			
		$this->data['entry_layout'] = __('entry_layout');
		$this->data['entry_position'] = __('entry_position');
		$this->data['entry_status'] = __('entry_status');
		$this->data['entry_sort_order'] = __('entry_sort_order');
		
		$this->data['button_save'] = __('button_save');
		$this->data['button_cancel'] = __('button_cancel');
		$this->data['button_add_module'] = __('button_add_module');
		$this->data['button_remove'] = __('button_remove');
		
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset($this->error['dimension'])) {
			$this->data['error_dimension'] = $this->error['dimension'];
		} else {
			$this->data['error_dimension'] = array();
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
			'href' => $this->url->link('module/slideshow', 'token=' . $this->session->data['token'], 'SSL')
   		);
		
		$this->data['action'] = $this->url->link('module/slideshow', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['modules'] = array();
		
		if (isset($this->request->post['slideshow_module'])) {
			$this->data['modules'] = $this->request->post['slideshow_module'];
		} elseif ($this->config->get('slideshow_module')) { 
			$this->data['modules'] = $this->config->get('slideshow_module');
		}	
						
		$this->load->model('design/layout');
		
		$this->data['layouts'] = $this->model_design_layout->getLayouts();

		$this->load->model('design/banner');
		
		$this->data['banners'] = $this->model_design_banner->getBanners();
		
		$this->template = 'module/slideshow.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
	
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/slideshow')) {
			$this->error['warning'] = __('error_permission');
		}
		
		if (isset($this->request->post['slideshow_module'])) {
			foreach ($this->request->post['slideshow_module'] as $key => $value) {
				if (!$value['width'] || !$value['height']) {
					$this->error['dimension'][$key] = __('error_dimension');
				}				
			}
		}	
						
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>