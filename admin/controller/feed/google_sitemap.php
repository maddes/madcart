<?php 
class ControllerFeedGoogleSitemap extends Controller {
	private $error = array(); 
	
	public function index() {
		$this->language->load('feed/google_sitemap');

		$this->document->setTitle(__('heading_title'));
		
		$this->load->model('setting/setting');
			
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('google_sitemap', $this->request->post);				
			
			$this->session->data['success'] = __('text_success');

			$this->redirect($this->url->link('extension/feed', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->data['heading_title'] = __('heading_title');
		
		$this->data['text_enabled'] = __('text_enabled');
		$this->data['text_disabled'] = __('text_disabled');
		
		$this->data['entry_status'] = __('entry_status');
		$this->data['entry_data_feed'] = __('entry_data_feed');
		
		$this->data['button_save'] = __('button_save');
		$this->data['button_cancel'] = __('button_cancel');

		$this->data['tab_general'] = __('tab_general');

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
       		'text' => __('text_feed'),
			'href' => $this->url->link('extension/feed', 'token=' . $this->session->data['token'], 'SSL')
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text' => __('heading_title'),
			'href' => $this->url->link('feed/google_sitemap', 'token=' . $this->session->data['token'], 'SSL')
   		);
				
		$this->data['action'] = $this->url->link('feed/google_sitemap', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/feed', 'token=' . $this->session->data['token'], 'SSL');
		
		if (isset($this->request->post['google_sitemap_status'])) {
			$this->data['google_sitemap_status'] = $this->request->post['google_sitemap_status'];
		} else {
			$this->data['google_sitemap_status'] = $this->config->get('google_sitemap_status');
		}
		
		$this->data['data_feed'] = HTTP_CATALOG . 'index.php?route=feed/google_sitemap';

		$this->template = 'feed/google_sitemap.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	} 
	
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'feed/google_sitemap')) {
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