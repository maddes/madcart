<?php
class ControllerAffiliatePassword extends Controller {
	private $error = array();
	     
  	public function index() {	
    	if (!$this->affiliate->isLogged()) {
      		$this->session->data['redirect'] = $this->url->link('affiliate/password', '', 'SSL');

      		$this->redirect($this->url->link('affiliate/login', '', 'SSL'));
    	}

		$this->language->load('affiliate/password');

    	$this->document->setTitle(__('heading_title'));
			  
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->load->model('affiliate/affiliate');
			
			$this->model_affiliate_affiliate->editPassword($this->affiliate->getEmail(), $this->request->post['password']);
 
      		$this->session->data['success'] = __('text_success');
	  
	  		$this->redirect($this->url->link('affiliate/account', '', 'SSL'));
    	}

      	$this->data['breadcrumbs'] = array();

      	$this->data['breadcrumbs'][] = array(
        	'text' => __('text_home'),
			'href' => $this->url->link('common/home')
      	); 

      	$this->data['breadcrumbs'][] = array(
        	'text' => __('text_account'),
			'href' => $this->url->link('affiliate/account', '', 'SSL')
      	);
		
      	$this->data['breadcrumbs'][] = array(
        	'text' => __('heading_title'),
			'href' => $this->url->link('affiliate/password', '', 'SSL')
      	);
			
    	$this->data['heading_title'] = __('heading_title');

    	$this->data['text_password'] = __('text_password');

    	$this->data['entry_password'] = __('entry_password');
    	$this->data['entry_confirm'] = __('entry_confirm');

    	$this->data['button_continue'] = __('button_continue');
    	$this->data['button_back'] = __('button_back');
    	
		if (isset($this->error['password'])) { 
			$this->data['error_password'] = $this->error['password'];
		} else {
			$this->data['error_password'] = '';
		}

		if (isset($this->error['confirm'])) { 
			$this->data['error_confirm'] = $this->error['confirm'];
		} else {
			$this->data['error_confirm'] = '';
		}
	
    	$this->data['action'] = $this->url->link('affiliate/password', '', 'SSL');
		
		if (isset($this->request->post['password'])) {
    		$this->data['password'] = $this->request->post['password'];
		} else {
			$this->data['password'] = '';
		}

		if (isset($this->request->post['confirm'])) {
    		$this->data['confirm'] = $this->request->post['confirm'];
		} else {
			$this->data['confirm'] = '';
		}

    	$this->data['back'] = $this->url->link('affiliate/account', '', 'SSL');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/affiliate/password.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/affiliate/password.tpl';
		} else {
			$this->template = 'default/template/affiliate/password.tpl';
		}
		
		$this->children = array(
			'common/column_left',
			'common/column_right',
			'common/content_top',
			'common/content_bottom',
			'common/footer',
			'common/header'	
		);
								
		$this->response->setOutput($this->render());				
  	}
  
  	protected function validate() {
    	if ((utf8_strlen($this->request->post['password']) < 4) || (utf8_strlen($this->request->post['password']) > 20)) {
      		$this->error['password'] = __('error_password');
    	}

    	if ($this->request->post['confirm'] != $this->request->post['password']) {
      		$this->error['confirm'] = __('error_confirm');
    	}  
	
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}
  	}
}
?>
