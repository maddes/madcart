<?php 
class ControllerDesignLayout extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('design/layout');

		$this->document->setTitle(__('heading_title'));

		$this->load->model('design/layout');

		$this->getList();
	}

	public function insert() {
		$this->language->load('design/layout');

		$this->document->setTitle(__('heading_title'));

		$this->load->model('design/layout');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_design_layout->addLayout($this->request->post);
				
			$this->session->data['success'] = __('text_success');

			$url = '';
				
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
				
			$this->redirect($this->url->link('design/layout', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function update() {
		$this->language->load('design/layout');

		$this->document->setTitle(__('heading_title'));

		$this->load->model('design/layout');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_design_layout->editLayout($this->request->get['layout_id'], $this->request->post);

			$this->session->data['success'] = __('text_success');

			$url = '';
				
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
				
			$this->redirect($this->url->link('design/layout', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->language->load('design/layout');

		$this->document->setTitle(__('heading_title'));

		$this->load->model('design/layout');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $layout_id) {
				$this->model_design_layout->deleteLayout($layout_id);
			}
				
			$this->session->data['success'] = __('text_success');

			$url = '';
				
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('design/layout', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'name';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
			
		$url = '';
			
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
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
				'href' => $this->url->link('design/layout', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		$this->data['insert'] = $this->url->link('design/layout/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('design/layout/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
			
		$this->data['layouts'] = array();

		$data = array(
				'sort'  => $sort,
				'order' => $order,
				'start' => ($page - 1) * $this->config->get('config_admin_limit'),
				'limit' => $this->config->get('config_admin_limit')
		);

		$layout_total = $this->model_design_layout->getTotalLayouts();

		$results = $this->model_design_layout->getLayouts($data);

		foreach ($results as $result) {
			$action = array();
				
			$action[] = array(
					'text' => __('text_edit'),
					'href' => $this->url->link('design/layout/update', 'token=' . $this->session->data['token'] . '&layout_id=' . $result['layout_id'] . $url, 'SSL')
			);

			$this->data['layouts'][] = array(
					'layout_id' => $result['layout_id'],
					'name'      => $result['name'],
					'selected'  => isset($this->request->post['selected']) && in_array($result['layout_id'], $this->request->post['selected']),
					'action'    => $action
			);
		}

		$this->data['heading_title'] = __('heading_title');

		$this->data['text_no_results'] = __('text_no_results');

		$this->data['column_name'] = __('column_name');
		$this->data['column_action'] = __('column_action');

		$this->data['button_insert'] = __('button_insert');
		$this->data['button_delete'] = __('button_delete');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$this->data['sort_name'] = $this->url->link('design/layout', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $layout_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->url = $this->url->link('design/layout', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['results'] = sprintf(__('text_pagination'), ($layout_total) ? (($page - 1) * $this->config->get('config_admin_limit')) + 1 : 0, ((($page - 1) * $this->config->get('config_admin_limit')) > ($layout_total - $this->config->get('config_admin_limit'))) ? $layout_total : ((($page - 1) * $this->config->get('config_admin_limit')) + $this->config->get('config_admin_limit')), $layout_total, ceil($layout_total / $this->config->get('config_admin_limit')));

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'design/layout_list.tpl';
		$this->children = array(
				'common/header',
				'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function getForm() {
		$this->data['heading_title'] = __('heading_title');

		$this->data['text_default'] = __('text_default');

		$this->data['entry_name'] = __('entry_name');
		$this->data['entry_store'] = __('entry_store');
		$this->data['entry_route'] = __('entry_route');

		$this->data['button_save'] = __('button_save');
		$this->data['button_cancel'] = __('button_cancel');
		$this->data['button_add_route'] = __('button_add_route');
		$this->data['button_remove'] = __('button_remove');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$this->data['error_name'] = $this->error['name'];
		} else {
			$this->data['error_name'] = '';
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
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
				'href' => $this->url->link('design/layout', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);
			
		if (!isset($this->request->get['layout_id'])) {
			$this->data['action'] = $this->url->link('design/layout/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('design/layout/update', 'token=' . $this->session->data['token'] . '&layout_id=' . $this->request->get['layout_id'] . $url, 'SSL');
		}

		$this->data['cancel'] = $this->url->link('design/layout', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['layout_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$layout_info = $this->model_design_layout->getLayout($this->request->get['layout_id']);
		}

		if (isset($this->request->post['name'])) {
			$this->data['name'] = $this->request->post['name'];
		} elseif (!empty($layout_info)) {
			$this->data['name'] = $layout_info['name'];
		} else {
			$this->data['name'] = '';
		}

		$this->load->model('setting/store');

		$this->data['stores'] = $this->model_setting_store->getStores();

		if (isset($this->request->post['layout_route'])) {
			$this->data['layout_routes'] = $this->request->post['layout_route'];
		} elseif (isset($this->request->get['layout_id'])) {
			$this->data['layout_routes'] = $this->model_design_layout->getLayoutRoutes($this->request->get['layout_id']);
		} else {
			$this->data['layout_routes'] = array();
		}

		$this->template = 'design/layout_form.tpl';
		$this->children = array(
				'common/header',
				'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'design/layout')) {
			$this->error['warning'] = __('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = __('error_name');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'design/layout')) {
			$this->error['warning'] = __('error_permission');
		}

		$this->load->model('setting/store');
		$this->load->model('catalog/product');
		$this->load->model('catalog/category');
		$this->load->model('catalog/information');

		foreach ($this->request->post['selected'] as $layout_id) {
			if ($this->config->get('config_layout_id') == $layout_id) {
				$this->error['warning'] = __('error_default');
			}
				
			$store_total = $this->model_setting_store->getTotalStoresByLayoutId($layout_id);

			if ($store_total) {
				$this->error['warning'] = sprintf(__('error_store'), $store_total);
			}
				
			$product_total = $this->model_catalog_product->getTotalProductsByLayoutId($layout_id);

			if ($product_total) {
				$this->error['warning'] = sprintf(__('error_product'), $product_total);
			}

			$category_total = $this->model_catalog_category->getTotalCategoriesByLayoutId($layout_id);

			if ($category_total) {
				$this->error['warning'] = sprintf(__('error_category'), $category_total);
			}
				
			$information_total = $this->model_catalog_information->getTotalInformationsByLayoutId($layout_id);

			if ($information_total) {
				$this->error['warning'] = sprintf(__('error_information'), $information_total);
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