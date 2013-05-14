<?php 
class ControllerAffiliateLogin extends Controller {
	private $error = array();

	public function index() {
		if ($this->affiliate->isLogged()) {
			$this->redirect($this->url->link('affiliate/account', '', 'SSL'));
		}

		$this->language->load('affiliate/login');

		$this->document->setTitle(__('Affiliate Program','affiliate/login'));

		$this->load->model('affiliate/affiliate');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && isset($this->request->post['email']) && isset($this->request->post['password']) && $this->validate()) {
			// Added strpos check to pass McAfee PCI compliance test (http://forum.opencart.com/viewtopic.php?f=10&t=12043&p=151494#p151295)
			if (isset($this->request->post['redirect']) && (strpos($this->request->post['redirect'], $this->config->get('config_url')) !== false || strpos($this->request->post['redirect'], $this->config->get('config_ssl')) !== false)) {
				$this->redirect(str_replace('&amp;', '&', $this->request->post['redirect']));
			} else {
				$this->redirect($this->url->link('affiliate/account', '', 'SSL'));
			}
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
				'text' => __('text_home'),
				'href' => $this->url->link('common/home')
		);

		$this->data['breadcrumbs'][] = array(
				'text' => __('Account','affiliate/login'),
				'href' => $this->url->link('affiliate/account', '', 'SSL')
		);

		$this->data['breadcrumbs'][] = array(
				'text' => __('Login','affiliate/login'),
				'href' => $this->url->link('affiliate/login', '', 'SSL')
		);

		$this->data['heading_title'] = __('Affiliate Program','affiliate/login');

		$this->data['text_description'] = sprintf(__('<p>%s affiliate program is free and enables members to earn revenue by placing a link or links on their web site which advertises %s or specific products on it. Any sales made to customers who have clicked on those links will earn the affiliate commission. The standard commission rate is currently %s.</p><p>For more information, visit our FAQ page or see our Affiliate terms &amp; conditions.</p>','affiliate/login'), $this->config->get('config_name'), $this->config->get('config_name'), $this->config->get('config_commission') . '%');
		$this->data['text_new_affiliate'] = __('New Affiliate','affiliate/login');
		$this->data['text_register_account'] = __('<p>I am not currently an affiliate.</p><p>Click Continue below to create a new affiliate account. Please note that this is not connected in any way to your customer account.</p>','affiliate/login');
		$this->data['text_returning_affiliate'] = __('Affiliate Login','affiliate/login');
		$this->data['text_i_am_returning_affiliate'] = __('I am a returning affiliate.','affiliate/login');
		$this->data['text_forgotten'] = __('Forgotten Password','affiliate/login');

		$this->data['entry_email'] = __('Affiliate E-Mail:','affiliate/login');
		$this->data['entry_password'] = __('Password:','affiliate/login');

		$this->data['button_continue'] = __('button_continue');
		$this->data['button_login'] = __('button_login');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		$this->data['action'] = $this->url->link('affiliate/login', '', 'SSL');
		$this->data['register'] = $this->url->link('affiliate/register', '', 'SSL');
		$this->data['forgotten'] = $this->url->link('affiliate/forgotten', '', 'SSL');
		 
		if (isset($this->request->post['redirect'])) {
			$this->data['redirect'] = $this->request->post['redirect'];
		} elseif (isset($this->session->data['redirect'])) {
			$this->data['redirect'] = $this->session->data['redirect'];
			 
			unset($this->session->data['redirect']);
		} else {
			$this->data['redirect'] = '';
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		if (isset($this->request->post['email'])) {
			$this->data['email'] = $this->request->post['email'];
		} else {
			$this->data['email'] = '';
		}

		if (isset($this->request->post['password'])) {
			$this->data['password'] = $this->request->post['password'];
		} else {
			$this->data['password'] = '';
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/affiliate/login.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/affiliate/login.tpl';
		} else {
			$this->template = 'default/template/affiliate/login.tpl';
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
		if (!$this->affiliate->login($this->request->post['email'], $this->request->post['password'])) {
			$this->error['warning'] = __('Warning: No match for E-Mail Address and/or Password.','affiliate/login');
		}

		$affiliate_info = $this->model_affiliate_affiliate->getAffiliateByEmail($this->request->post['email']);

		if ($affiliate_info && !$affiliate_info['approved']) {
			$this->error['warning'] = __('Warning: Your account requires approval before you can login.','affiliate/login');
		}
			
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>