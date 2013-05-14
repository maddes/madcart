<?php 
class ControllerAffiliateLogout extends Controller {
	public function index() {
		if ($this->affiliate->isLogged()) {
			$this->affiliate->logout();
				
			$this->redirect($this->url->link('affiliate/logout', '', 'SSL'));
		}

		$this->language->load('affiliate/logout');

		$this->document->setTitle(__('heading_title'));
		 
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
				'text' => __('text_logout'),
				'href' => $this->url->link('affiliate/logout', '', 'SSL')
		);

		$this->data['heading_title'] = __('heading_title');

		$this->data['text_message'] = __('text_message');

		$this->data['button_continue'] = __('button_continue');

		$this->data['continue'] = $this->url->link('common/home');

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
}
?>