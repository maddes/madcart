<?php
class ControllerAccountForgotten extends Controller {
	private $error = array();

	public function index() {
		if ($this->customer->isLogged()) {
			$this->redirect($this->url->link('account/account', '', 'SSL'));
		}

		$this->language->load('account/forgotten');

		$this->document->setTitle(__('heading_title'));
		
		$this->load->model('account/customer');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->language->load('mail/forgotten');
			
			$password = substr(sha1(uniqid(mt_rand(), true)), 0, 10);
			
			$this->model_account_customer->editPassword($this->request->post['email'], $password);
			
			$subject = sprintf(__('text_subject'), $this->config->get('config_name'));
			
			$message  = sprintf(__('text_greeting'), $this->config->get('config_name')) . "\n\n";
			$message .= __('text_password') . "\n\n";
			$message .= $password;

			$mail = new Mail();
			$mail->protocol = $this->config->get('config_mail_protocol');
			$mail->parameter = $this->config->get('config_mail_parameter');
			$mail->hostname = $this->config->get('config_smtp_host');
			$mail->username = $this->config->get('config_smtp_username');
			$mail->password = $this->config->get('config_smtp_password');
			$mail->port = $this->config->get('config_smtp_port');
			$mail->timeout = $this->config->get('config_smtp_timeout');				
			$mail->setTo($this->request->post['email']);
			$mail->setFrom($this->config->get('config_email'));
			$mail->setSender($this->config->get('config_name'));
			$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
			$mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
			$mail->send();
			
			$this->session->data['success'] = __('text_success');

			$this->redirect($this->url->link('account/login', '', 'SSL'));
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
        	'text' => __('text_forgotten'),
			'href' => $this->url->link('account/forgotten', '', 'SSL')
      	);
		
		$this->data['heading_title'] = __('heading_title');

		$this->data['text_your_email'] = __('text_your_email');
		$this->data['text_email'] = __('text_email');

		$this->data['entry_email'] = __('entry_email');

		$this->data['button_continue'] = __('button_continue');
		$this->data['button_back'] = __('button_back');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		$this->data['action'] = $this->url->link('account/forgotten', '', 'SSL');
 
		$this->data['back'] = $this->url->link('account/login', '', 'SSL');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/forgotten.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/account/forgotten.tpl';
		} else {
			$this->template = 'default/template/account/forgotten.tpl';
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
		if (!isset($this->request->post['email'])) {
			$this->error['warning'] = __('error_email');
		} elseif (!$this->model_account_customer->getTotalCustomersByEmail($this->request->post['email'])) {
			$this->error['warning'] = __('error_email');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>