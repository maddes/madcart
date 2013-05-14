<?php
class ControllerExtensionShipping extends Controller {
	private $error = array();
	
  	public function index() {
		$this->language->load('extension/shipping');
	
    	$this->document->setTitle(__('heading_title'));
		
		$this->load->model('setting/extension');
		
    	$this->getList();
  	}
	
	public function install() {
		$this->language->load('extension/shipping');
		
		$this->document->setTitle(__('heading_title'));
		
		$this->load->model('setting/extension');
		
		if ($this->validate()) {		
			$this->model_setting_extension->install('shipping', $this->request->get['extension']);

			$this->load->model('user/user_group');
		
			$this->model_user_user_group->addPermission($this->user->getId(), 'access', 'shipping/' . $this->request->get['extension']);
			$this->model_user_user_group->addPermission($this->user->getId(), 'modify', 'shipping/' . $this->request->get['extension']);
			
			$this->session->data['success'] = __('text_success');
			
			$this->redirect($this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$this->getList();
	}
	
	public function uninstall() {
		$this->language->load('extension/shipping');
		
		$this->document->setTitle(__('heading_title'));
		
		$this->load->model('setting/extension');
		
		if ($this->validate()) {	
			$this->model_setting_extension->uninstall('shipping', $this->request->get['extension']);
		
			$this->load->model('setting/setting');
		
			$this->model_setting_setting->deleteSetting($this->request->get['extension']);
			
			$this->session->data['success'] = __('text_success');
				
			$this->redirect($this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$this->getList();
	}
			
	public function getList() {
		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text' => __('text_home'),
			'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL')
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text' => __('heading_title'),
			'href' => $this->url->link('extension/shipping', 'token=' . $this->session->data['token'], 'SSL')
   		);		
		
		$this->data['heading_title'] = __('heading_title');

		$this->data['text_no_results'] = __('text_no_results');
		$this->data['text_confirm'] = __('text_confirm');
				
		$this->data['column_name'] = __('column_name');
		$this->data['column_status'] = __('column_status');
		$this->data['column_sort_order'] = __('column_sort_order');
		$this->data['column_action'] = __('column_action');
	
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
				
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
		
		$this->load->model('setting/extension');

		$extensions = $this->model_setting_extension->getInstalled('shipping');
		
		foreach ($extensions as $key => $value) {
			if (!file_exists(DIR_APPLICATION . 'controller/shipping/' . $value . '.php')) {
				$this->model_setting_extension->uninstall('shipping', $value);
				
				unset($extensions[$key]);
			}
		}
		
		$this->data['extensions'] = array();
		
		$files = glob(DIR_APPLICATION . 'controller/shipping/*.php');
		
		if ($files) {
			foreach ($files as $file) {
				$extension = basename($file, '.php');
				
				$this->language->load('shipping/' . $extension);
	
				$action = array();
				
				if (!in_array($extension, $extensions)) {
					$action[] = array(
						'text' => __('text_install'),
						'href' => $this->url->link('extension/shipping/install', 'token=' . $this->session->data['token'] . '&extension=' . $extension, 'SSL')
					);
				} else {
					$action[] = array(
						'text' => __('text_edit'),
						'href' => $this->url->link('shipping/' . $extension . '', 'token=' . $this->session->data['token'], 'SSL')
					);
								
					$action[] = array(
						'text' => __('text_uninstall'),
						'href' => $this->url->link('extension/shipping/uninstall', 'token=' . $this->session->data['token'] . '&extension=' . $extension, 'SSL')
					);
				}
										
				$this->data['extensions'][] = array(
					'name'       => __('heading_title'),
					'status'     => $this->config->get($extension . '_status') ? __('text_enabled') : __('text_disabled'),
					'sort_order' => $this->config->get($extension . '_sort_order'),
					'action'     => $action
				);
			}
		}

		$this->template = 'extension/shipping.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
	
	protected function validate() {
    	if (!$this->user->hasPermission('modify', 'extension/shipping')) {
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