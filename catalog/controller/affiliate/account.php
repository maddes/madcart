<?php 
class ControllerAffiliateAccount extends Controller { 
	public function index() {
		if (!$this->affiliate->isLogged()) {
	  		$this->session->data['redirect'] = $this->url->link('affiliate/account', '', 'SSL');
	  
	  		$this->redirect($this->url->link('affiliate/login', '', 'SSL'));
    	} 
	
		$this->language->load('affiliate/account');

      	$this->data['breadcrumbs'] = array();

      	$this->data['breadcrumbs'][] = array(
        	'text' => __('text_home'),
			'href' => $this->url->link('common/home')
      	); 

      	$this->data['breadcrumbs'][] = array(       	
        	'text' => __('text_account'),
			'href' => $this->url->link('affiliate/account', '', 'SSL')
      	);

		$this->document->setTitle(__('heading_title'));

    	$this->data['heading_title'] = __('heading_title');

    	$this->data['text_my_account'] = __('text_my_account');
    	$this->data['text_my_tracking'] = __('text_my_tracking');
		$this->data['text_my_transactions'] = __('text_my_transactions');
		$this->data['text_edit'] = __('text_edit');
		$this->data['text_password'] = __('text_password');
		$this->data['text_payment'] = __('text_payment');
		$this->data['text_tracking'] = __('text_tracking');
		$this->data['text_transaction'] = __('text_transaction');
		
		if (isset($this->session->data['success'])) {
    		$this->data['success'] = $this->session->data['success'];
			
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

    	$this->data['edit'] = $this->url->link('affiliate/edit', '', 'SSL');
		$this->data['password'] = $this->url->link('affiliate/password', '', 'SSL');
		$this->data['payment'] = $this->url->link('affiliate/payment', '', 'SSL');
		$this->data['tracking'] = $this->url->link('affiliate/tracking', '', 'SSL');
    	$this->data['transaction'] = $this->url->link('affiliate/transaction', '', 'SSL');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/affiliate/account.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/affiliate/account.tpl';
		} else {
			$this->template = 'default/template/affiliate/account.tpl';
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
}
?>