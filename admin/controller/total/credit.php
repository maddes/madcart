<?php 
class ControllerTotalCredit extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('total/credit');

		$this->document->setTitle(__('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('credit', $this->request->post);

			$this->session->data['success'] = __('text_success');
				
			$this->redirect($this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->data['heading_title'] = __('heading_title');

		$this->data['text_enabled'] = __('text_enabled');
		$this->data['text_disabled'] = __('text_disabled');

		$this->data['entry_status'] = __('entry_status');
		$this->data['entry_sort_order'] = __('entry_sort_order');
			
		$this->data['button_save'] = __('button_save');
		$this->data['button_cancel'] = __('button_cancel');

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
				'text' => __('text_total'),
				'href' => $this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL')
		);

		$this->data['breadcrumbs'][] = array(
				'text' => __('heading_title'),
				'href' => $this->url->link('total/credit', 'token=' . $this->session->data['token'], 'SSL')
		);

		$this->data['action'] = $this->url->link('total/credit', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['credit_status'])) {
			$this->data['credit_status'] = $this->request->post['credit_status'];
		} else {
			$this->data['credit_status'] = $this->config->get('credit_status');
		}

		if (isset($this->request->post['credit_sort_order'])) {
			$this->data['credit_sort_order'] = $this->request->post['credit_sort_order'];
		} else {
			$this->data['credit_sort_order'] = $this->config->get('credit_sort_order');
		}

		$this->template = 'total/credit.tpl';
		$this->children = array(
				'common/header',
				'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'total/credit')) {
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