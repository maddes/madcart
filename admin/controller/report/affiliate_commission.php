<?php
class ControllerReportAffiliateCommission extends Controller {
	public function index() {     
		$this->language->load('report/affiliate_commission');

		$this->document->setTitle(__('heading_title'));
		
		if (isset($this->request->get['filter_date_start'])) {
			$filter_date_start = $this->request->get['filter_date_start'];
		} else {
			$filter_date_start = '';
		}

		if (isset($this->request->get['filter_date_end'])) {
			$filter_date_end = $this->request->get['filter_date_end'];
		} else {
			$filter_date_end = '';
		}
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';
	
		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}
		
		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}
				
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
						
		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text' => __('text_home'),
			'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL')
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text' => __('heading_title'),
			'href' => $this->url->link('report/affiliate_commission', 'token=' . $this->session->data['token'] . $url, 'SSL')
   		);		
		
		$this->load->model('report/affiliate');
		
		$this->data['affiliates'] = array();
		
		$data = array(
			'filter_date_start'	=> $filter_date_start, 
			'filter_date_end'	=> $filter_date_end, 
			'start'             => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'             => $this->config->get('config_admin_limit')
		);
		
		$affiliate_total = $this->model_report_affiliate->getTotalCommission($data); 
		
		$results = $this->model_report_affiliate->getCommission($data);
		
		foreach ($results as $result) {
			$action = array();
		
			$action[] = array(
				'text' => __('text_edit'),
				'href' => $this->url->link('sale/affiliate/update', 'token=' . $this->session->data['token'] . '&affiliate_id=' . $result['affiliate_id'] . $url, 'SSL')
			);
						
			$this->data['affiliates'][] = array(
				'affiliate'  => $result['affiliate'],
				'email'      => $result['email'],
				'status'     => ($result['status'] ? __('text_enabled') : __('text_disabled')),
				'commission' => $this->currency->format($result['commission'], $this->config->get('config_currency')),
				'orders'     => $result['orders'],
				'total'      => $this->currency->format($result['total'], $this->config->get('config_currency')),
				'action'     => $action
			);
		}
					 
 		$this->data['heading_title'] = __('heading_title');
		 
		$this->data['text_no_results'] = __('text_no_results');
		
		$this->data['column_affiliate'] = __('column_affiliate');
		$this->data['column_email'] = __('column_email');
		$this->data['column_status'] = __('column_status');
		$this->data['column_commission'] = __('column_commission');
		$this->data['column_orders'] = __('column_orders');
		$this->data['column_total'] = __('column_total');
		$this->data['column_action'] = __('column_action');
		
		$this->data['entry_date_start'] = __('entry_date_start');
		$this->data['entry_date_end'] = __('entry_date_end');

		$this->data['button_filter'] = __('button_filter');
		
		$this->data['token'] = $this->session->data['token'];
		
		$url = '';
						
		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}
		
		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}
		
		$pagination = new Pagination();
		$pagination->total = $affiliate_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->url = $this->url->link('report/affiliate_commission', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();
		
		$this->data['results'] = sprintf(__('text_pagination'), ($affiliate_total) ? (($page - 1) * $this->config->get('config_admin_limit')) + 1 : 0, ((($page - 1) * $this->config->get('config_admin_limit')) > ($affiliate_total - $this->config->get('config_admin_limit'))) ? $affiliate_total : ((($page - 1) * $this->config->get('config_admin_limit')) + $this->config->get('config_admin_limit')), $affiliate_total, ceil($affiliate_total / $this->config->get('config_admin_limit')));
	
		$this->data['filter_date_start'] = $filter_date_start;
		$this->data['filter_date_end'] = $filter_date_end;	
				 
		$this->template = 'report/affiliate_commission.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
}
?>