<?php
class ControllerAccountTransaction extends Controller {
	public function index() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/transaction', '', 'SSL');
			
	  		$this->redirect($this->url->link('account/login', '', 'SSL'));
    	}		
		
		$this->language->load('account/transaction');

		$this->document->setTitle(__('heading_title'));

      	$this->data['breadcrumbs'] = array();

      	$this->data['breadcrumbs'][] = array(
        	'text' => __('text_home'),
			'href' => $this->url->link('common/home')
      	); 

      	$this->data['breadcrumbs'][] = array(       	
        	'text' => __('text_account'),
			'href' => $this->url->link('account/account', '', 'SSL')
      	);
		
      	$this->data['breadcrumbs'][] = array(       	
        	'text' => __('text_transaction'),
			'href' => $this->url->link('account/transaction', '', 'SSL')
      	);
		
		$this->load->model('account/transaction');

    	$this->data['heading_title'] = __('heading_title');
		
		$this->data['column_date_added'] = __('column_date_added');
		$this->data['column_description'] = __('column_description');
		$this->data['column_amount'] = sprintf(__('column_amount'), $this->config->get('config_currency'));
		
		$this->data['text_total'] = __('text_total');
		$this->data['text_empty'] = __('text_empty');
		
		$this->data['button_continue'] = __('button_continue');
				
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}		
		
		$this->data['transactions'] = array();
		
		$data = array(				  
			'sort'  => 'date_added',
			'order' => 'DESC',
			'start' => ($page - 1) * 10,
			'limit' => 10
		);
		
		$transaction_total = $this->model_account_transaction->getTotalTransactions($data);
	
		$results = $this->model_account_transaction->getTransactions($data);
 		
    	foreach ($results as $result) {
			$this->data['transactions'][] = array(
				'amount'      => $this->currency->format($result['amount'], $this->config->get('config_currency')),
				'description' => $result['description'],
				'date_added'  => date(__('date_format_short'), strtotime($result['date_added']))
			);
		}	

		$pagination = new Pagination();
		$pagination->total = $transaction_total;
		$pagination->page = $page;
		$pagination->limit = 10; 
		$pagination->url = $this->url->link('account/transaction', 'page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();
		
		$this->data['results'] = sprintf(__('text_pagination'), ($transaction_total) ? (($page - 1) * 10) + 1 : 0, ((($page - 1) * 10) > ($transaction_total - 10)) ? $transaction_total : ((($page - 1) * 10) + 10), $transaction_total, ceil($transaction_total / 10));
		
		$this->data['total'] = $this->currency->format($this->customer->getBalance());
		
		$this->data['continue'] = $this->url->link('account/account', '', 'SSL');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/transaction.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/account/transaction.tpl';
		} else {
			$this->template = 'default/template/account/transaction.tpl';
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