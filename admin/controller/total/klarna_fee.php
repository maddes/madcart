<?php
class ControllerTotalKlarnaFee extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('total/klarna_fee');

		$this->document->setTitle(__('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$status = false;
				
			foreach ($this->request->post['klarna_fee'] as $klarna_account) {
				if ($klarna_account['status']) {
					$status = true;
						
					break;
				}
			}

			$this->model_setting_setting->editSetting('klarna_fee', array_merge($this->request->post, array('klarna_fee_status' => $status)));

			$this->session->data['success'] = __('text_success');

			$this->redirect($this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->data['heading_title'] = __('heading_title');

		$this->data['text_enabled'] = __('text_enabled');
		$this->data['text_disabled'] = __('text_disabled');
		$this->data['text_none'] = __('text_none');

		$this->data['entry_total'] = __('entry_total');
		$this->data['entry_fee'] = __('entry_fee');
		$this->data['entry_tax_class'] = __('entry_tax_class');
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
				'href' => $this->url->link('total/klarna_fee', 'token=' . $this->session->data['token'], 'SSL')
		);

		$this->data['action'] = $this->url->link('total/klarna_fee', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['countries'] = array();

		$this->data['countries'][] = array(
				'name' => __('text_germany'),
				'code' => 'DEU'
		);

		$this->data['countries'][] = array(
				'name' => __('text_netherlands'),
				'code' => 'NLD'
		);

		$this->data['countries'][] = array(
				'name' => __('text_denmark'),
				'code' => 'DNK'
		);

		$this->data['countries'][] = array(
				'name' => __('text_sweden'),
				'code' => 'SWE'
		);

		$this->data['countries'][] = array(
				'name' => __('text_norway'),
				'code' => 'NOR'
		);

		$this->data['countries'][] = array(
				'name' => __('text_finland'),
				'code' => 'FIN'
		);

		if (isset($this->request->post['klarna_fee'])) {
			$this->data['klarna_fee'] = $this->request->post['klarna_fee'];
		} else {
			$this->data['klarna_fee'] = $this->config->get('klarna_fee');
		}
		 
		$this->load->model('localisation/tax_class');

		$this->data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();

		$this->template = 'total/klarna_fee.tpl';
		$this->children = array(
				'common/header',
				'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'total/klarna_fee')) {
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