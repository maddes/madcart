<?php
class ControllerModuleLatest extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('module/latest');

		$this->document->setTitle(__('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('latest', $this->request->post);
				
			$this->cache->delete('product');
				
			$this->session->data['success'] = __('text_success');

			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->data['heading_title'] = __('heading_title');

		$this->data['text_enabled'] = __('text_enabled');
		$this->data['text_disabled'] = __('text_disabled');
		$this->data['text_content_top'] = __('text_content_top');
		$this->data['text_content_bottom'] = __('text_content_bottom');
		$this->data['text_column_left'] = __('text_column_left');
		$this->data['text_column_right'] = __('text_column_right');

		$this->data['entry_limit'] = __('entry_limit');
		$this->data['entry_image'] = __('entry_image');
		$this->data['entry_width'] = __('entry_width');
		$this->data['entry_height'] = __('entry_height');
		$this->data['entry_layout'] = __('entry_layout');
		$this->data['entry_position'] = __('entry_position');
		$this->data['entry_status'] = __('entry_status');
		$this->data['entry_sort_order'] = __('entry_sort_order');

		$this->data['button_save'] = __('button_save');
		$this->data['button_cancel'] = __('button_cancel');
		$this->data['button_add_module'] = __('button_add_module');
		$this->data['button_remove'] = __('button_remove');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['image'])) {
			$this->data['error_image'] = $this->error['image'];
		} else {
			$this->data['error_image'] = array();
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
				'text' => __('text_home'),
				'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL')
		);

		$this->data['breadcrumbs'][] = array(
				'text' => __('text_module'),
				'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
		);

		$this->data['breadcrumbs'][] = array(
				'text' => __('heading_title'),
				'href' => $this->url->link('module/latest', 'token=' . $this->session->data['token'], 'SSL')
		);

		$this->data['action'] = $this->url->link('module/latest', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['modules'] = array();

		if (isset($this->request->post['latest_module'])) {
			$this->data['modules'] = $this->request->post['latest_module'];
		} elseif ($this->config->get('latest_module')) {
			$this->data['modules'] = $this->config->get('latest_module');
		}

		$this->load->model('design/layout');

		$this->data['layouts'] = $this->model_design_layout->getLayouts();

		$this->template = 'module/latest.tpl';
		$this->children = array(
				'common/header',
				'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/latest')) {
			$this->error['warning'] = __('error_permission');
		}

		if (isset($this->request->post['latest_module'])) {
			foreach ($this->request->post['latest_module'] as $key => $value) {
				if (!$value['image_width'] || !$value['image_height']) {
					$this->error['image'][$key] = __('error_image');
				}
			}
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>