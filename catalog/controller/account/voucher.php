<?php 
class ControllerAccountVoucher extends Controller { 
	private $error = array();
	
	public function index() {
		$this->language->load('account/voucher');
		
		$this->document->setTitle(__('heading_title'));
		
		if (!isset($this->session->data['vouchers'])) {
			$this->session->data['vouchers'] = array();
		}
	
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->session->data['vouchers'][mt_rand()] = array(
				'description'      => sprintf(__('text_for'), $this->currency->format($this->currency->convert($this->request->post['amount'], $this->currency->getCode(), $this->config->get('config_currency'))), $this->request->post['to_name']),
				'to_name'          => $this->request->post['to_name'],
				'to_email'         => $this->request->post['to_email'],
				'from_name'        => $this->request->post['from_name'],
				'from_email'       => $this->request->post['from_email'],
				'voucher_theme_id' => $this->request->post['voucher_theme_id'],
				'message'          => $this->request->post['message'],
				'amount'           => $this->currency->convert($this->request->post['amount'], $this->currency->getCode(), $this->config->get('config_currency'))
			);
	  	  	
	  		$this->redirect($this->url->link('account/voucher/success'));
    	} 		

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
        	'text' => __('text_voucher'),
			'href' => $this->url->link('account/voucher', '', 'SSL')
      	);

    	$this->data['heading_title'] = __('heading_title');
		
		$this->data['text_description'] = __('text_description');
		$this->data['text_agree'] = __('text_agree');
		
		$this->data['entry_to_name'] = __('entry_to_name');
		$this->data['entry_to_email'] = __('entry_to_email');
		$this->data['entry_from_name'] = __('entry_from_name');
		$this->data['entry_from_email'] = __('entry_from_email');
		$this->data['entry_theme'] = __('entry_theme');
		$this->data['entry_message'] = __('entry_message');
		$this->data['entry_amount'] = sprintf(__('entry_amount'), $this->currency->format($this->config->get('config_voucher_min')), $this->currency->format($this->config->get('config_voucher_max')));
		
		$this->data['button_continue'] = __('button_continue');
		
		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset($this->error['to_name'])) {
			$this->data['error_to_name'] = $this->error['to_name'];
		} else {
			$this->data['error_to_name'] = '';
		}
		
		if (isset($this->error['to_email'])) {
			$this->data['error_to_email'] = $this->error['to_email'];
		} else {
			$this->data['error_to_email'] = '';
		}
				
		if (isset($this->error['from_name'])) {
			$this->data['error_from_name'] = $this->error['from_name'];
		} else {
			$this->data['error_from_name'] = '';
		}
		
		if (isset($this->error['from_email'])) {
			$this->data['error_from_email'] = $this->error['from_email'];
		} else {
			$this->data['error_from_email'] = '';
		}
		
		if (isset($this->error['theme'])) {
			$this->data['error_theme'] = $this->error['theme'];
		} else {
			$this->data['error_theme'] = '';
		}
						
		if (isset($this->error['amount'])) {
			$this->data['error_amount'] = $this->error['amount'];
		} else {
			$this->data['error_amount'] = '';
		}
					
		$this->data['action'] = $this->url->link('account/voucher', '', 'SSL');
								
		if (isset($this->request->post['to_name'])) {
			$this->data['to_name'] = $this->request->post['to_name'];
		} else {
			$this->data['to_name'] = '';
		}
		
		if (isset($this->request->post['to_email'])) {
			$this->data['to_email'] = $this->request->post['to_email'];
		} else {
			$this->data['to_email'] = '';
		}
				
		if (isset($this->request->post['from_name'])) {
			$this->data['from_name'] = $this->request->post['from_name'];
		} elseif ($this->customer->isLogged()) {
			$this->data['from_name'] = $this->customer->getFirstName() . ' '  . $this->customer->getLastName();
		} else {
			$this->data['from_name'] = '';
		}
		
		if (isset($this->request->post['from_email'])) {
			$this->data['from_email'] = $this->request->post['from_email'];
		} elseif ($this->customer->isLogged()) {
			$this->data['from_email'] = $this->customer->getEmail();		
		} else {
			$this->data['from_email'] = '';
		}
			
 		$this->load->model('checkout/voucher_theme');
			
		$this->data['voucher_themes'] = $this->model_checkout_voucher_theme->getVoucherThemes();

    	if (isset($this->request->post['voucher_theme_id'])) {
      		$this->data['voucher_theme_id'] = $this->request->post['voucher_theme_id'];
		} else {
      		$this->data['voucher_theme_id'] = '';
    	}	
					
		if (isset($this->request->post['message'])) {
			$this->data['message'] = $this->request->post['message'];
		} else {
			$this->data['message'] = '';
		}	
				
		if (isset($this->request->post['amount'])) {
			$this->data['amount'] = $this->request->post['amount'];
		} else {
			$this->data['amount'] = $this->currency->format(25, $this->config->get('config_currency'), false, false);
		}
				
		if (isset($this->request->post['agree'])) {
			$this->data['agree'] = $this->request->post['agree'];
		} else {
			$this->data['agree'] = false;
		}	
				
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/voucher.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/account/voucher.tpl';
		} else {
			$this->template = 'default/template/account/voucher.tpl';
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
	
  	public function success() {
		$this->language->load('account/voucher');

		$this->document->setTitle(__('heading_title')); 

      	$this->data['breadcrumbs'] = array();

      	$this->data['breadcrumbs'][] = array(
        	'text' => __('text_home'),
			'href' => $this->url->link('common/home')
      	);

      	$this->data['breadcrumbs'][] = array(
        	'text' => __('heading_title'),
			'href' => $this->url->link('account/voucher')
      	);	
		
    	$this->data['heading_title'] = __('heading_title');

    	$this->data['text_message'] = __('text_message');

    	$this->data['button_continue'] = __('button_continue');

    	$this->data['continue'] = $this->url->link('checkout/cart');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/success.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/common/success.tpl';
		} else {
			$this->template = 'default/template/common/success.tpl';
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
    	if ((utf8_strlen($this->request->post['to_name']) < 1) || (utf8_strlen($this->request->post['to_name']) > 64)) {
      		$this->error['to_name'] = __('error_to_name');
    	}    	
		
		if ((utf8_strlen($this->request->post['to_email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['to_email'])) {
      		$this->error['to_email'] = __('error_email');
    	}
		
    	if ((utf8_strlen($this->request->post['from_name']) < 1) || (utf8_strlen($this->request->post['from_name']) > 64)) {
      		$this->error['from_name'] = __('error_from_name');
    	}  
		
		if ((utf8_strlen($this->request->post['from_email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['from_email'])) {
      		$this->error['from_email'] = __('error_email');
    	}
		
		if (!isset($this->request->post['voucher_theme_id'])) {
      		$this->error['theme'] = __('error_theme');
    	}
				
		if (($this->currency->convert($this->request->post['amount'], $this->currency->getCode(), $this->config->get('config_currency')) < $this->config->get('config_voucher_min')) || ($this->currency->convert($this->request->post['amount'], $this->currency->getCode(), $this->config->get('config_currency')) > $this->config->get('config_voucher_max'))) {
      		$this->error['amount'] = sprintf(__('error_amount'), $this->currency->format($this->config->get('config_voucher_min')), $this->currency->format($this->config->get('config_voucher_max')) . ' ' . $this->currency->getCode());
    	}
				
		if (!isset($this->request->post['agree'])) {
      		$this->error['warning'] = __('error_agree');
		}
									
    	if (!$this->error) {
      		return true;
    	} else {
      		return false;
    	}				
	}
}
?>