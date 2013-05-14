<?php    
class ControllerCatalogManufacturer extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('catalog/manufacturer');

		$this->document->setTitle(__('heading_title'));
			
		$this->load->model('catalog/manufacturer');

		$this->getList();
	}

	public function insert() {
		$this->language->load('catalog/manufacturer');

		$this->document->setTitle(__('heading_title'));

		$this->load->model('catalog/manufacturer');
			
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_manufacturer->addManufacturer($this->request->post);

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
				
			$this->redirect($this->url->link('catalog/manufacturer', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}
	 
	public function update() {
		$this->language->load('catalog/manufacturer');

		$this->document->setTitle(__('heading_title'));

		$this->load->model('catalog/manufacturer');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_manufacturer->editManufacturer($this->request->get['manufacturer_id'], $this->request->post);

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
				
			$this->redirect($this->url->link('catalog/manufacturer', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->language->load('catalog/manufacturer');

		$this->document->setTitle(__('heading_title'));

		$this->load->model('catalog/manufacturer');
			
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $manufacturer_id) {
				$this->model_catalog_manufacturer->deleteManufacturer($manufacturer_id);
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
				
			$this->redirect($this->url->link('catalog/manufacturer', 'token=' . $this->session->data['token'] . $url, 'SSL'));
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
				'href' => $this->url->link('catalog/manufacturer', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);
			
		$this->data['insert'] = $this->url->link('catalog/manufacturer/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('catalog/manufacturer/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$this->data['manufacturers'] = array();

		$data = array(
				'sort'  => $sort,
				'order' => $order,
				'start' => ($page - 1) * $this->config->get('config_admin_limit'),
				'limit' => $this->config->get('config_admin_limit')
		);

		$manufacturer_total = $this->model_catalog_manufacturer->getTotalManufacturers();

		$results = $this->model_catalog_manufacturer->getManufacturers($data);

		foreach ($results as $result) {
			$action = array();
				
			$action[] = array(
					'text' => __('text_edit'),
					'href' => $this->url->link('catalog/manufacturer/update', 'token=' . $this->session->data['token'] . '&manufacturer_id=' . $result['manufacturer_id'] . $url, 'SSL')
			);

			$this->data['manufacturers'][] = array(
					'manufacturer_id' => $result['manufacturer_id'],
					'name'            => $result['name'],
					'sort_order'      => $result['sort_order'],
					'selected'        => isset($this->request->post['selected']) && in_array($result['manufacturer_id'], $this->request->post['selected']),
					'action'          => $action
			);
		}

		$this->data['heading_title'] = __('heading_title');

		$this->data['text_no_results'] = __('text_no_results');

		$this->data['column_name'] = __('column_name');
		$this->data['column_sort_order'] = __('column_sort_order');
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

		$this->data['sort_name'] = $this->url->link('catalog/manufacturer', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');
		$this->data['sort_sort_order'] = $this->url->link('catalog/manufacturer', 'token=' . $this->session->data['token'] . '&sort=sort_order' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $manufacturer_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->url = $this->url->link('catalog/manufacturer', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();

		$this->data['results'] = sprintf(__('text_pagination'), ($manufacturer_total) ? (($page - 1) * $this->config->get('config_admin_limit')) + 1 : 0, ((($page - 1) * $this->config->get('config_admin_limit')) > ($manufacturer_total - $this->config->get('config_admin_limit'))) ? $manufacturer_total : ((($page - 1) * $this->config->get('config_admin_limit')) + $this->config->get('config_admin_limit')), $manufacturer_total, ceil($manufacturer_total / $this->config->get('config_admin_limit')));

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'catalog/manufacturer_list.tpl';
		$this->children = array(
				'common/header',
				'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function getForm() {
		$this->data['heading_title'] = __('heading_title');

		$this->data['text_enabled'] = __('text_enabled');
		$this->data['text_disabled'] = __('text_disabled');
		$this->data['text_default'] = __('text_default');
		$this->data['text_image_manager'] = __('text_image_manager');
		$this->data['text_browse'] = __('text_browse');
		$this->data['text_clear'] = __('text_clear');
		$this->data['text_percent'] = __('text_percent');
		$this->data['text_amount'] = __('text_amount');

		$this->data['entry_name'] = __('entry_name');
		$this->data['entry_store'] = __('entry_store');
		$this->data['entry_keyword'] = __('entry_keyword');
		$this->data['entry_image'] = __('entry_image');
		$this->data['entry_sort_order'] = __('entry_sort_order');
		$this->data['entry_customer_group'] = __('entry_customer_group');

		$this->data['help_keyword'] = __('help_keyword');

		$this->data['button_save'] = __('button_save');
		$this->data['button_cancel'] = __('button_cancel');
			
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
				'href' => $this->url->link('catalog/manufacturer', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);
			
		if (!isset($this->request->get['manufacturer_id'])) {
			$this->data['action'] = $this->url->link('catalog/manufacturer/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('catalog/manufacturer/update', 'token=' . $this->session->data['token'] . '&manufacturer_id=' . $this->request->get['manufacturer_id'] . $url, 'SSL');
		}

		$this->data['cancel'] = $this->url->link('catalog/manufacturer', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['manufacturer_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($this->request->get['manufacturer_id']);
		}

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->request->post['name'])) {
			$this->data['name'] = $this->request->post['name'];
		} elseif (!empty($manufacturer_info)) {
			$this->data['name'] = $manufacturer_info['name'];
		} else {
			$this->data['name'] = '';
		}

		$this->load->model('setting/store');

		$this->data['stores'] = $this->model_setting_store->getStores();

		if (isset($this->request->post['manufacturer_store'])) {
			$this->data['manufacturer_store'] = $this->request->post['manufacturer_store'];
		} elseif (isset($this->request->get['manufacturer_id'])) {
			$this->data['manufacturer_store'] = $this->model_catalog_manufacturer->getManufacturerStores($this->request->get['manufacturer_id']);
		} else {
			$this->data['manufacturer_store'] = array(0);
		}

		if (isset($this->request->post['keyword'])) {
			$this->data['keyword'] = $this->request->post['keyword'];
		} elseif (!empty($manufacturer_info)) {
			$this->data['keyword'] = $manufacturer_info['keyword'];
		} else {
			$this->data['keyword'] = '';
		}

		if (isset($this->request->post['image'])) {
			$this->data['image'] = $this->request->post['image'];
		} elseif (!empty($manufacturer_info)) {
			$this->data['image'] = $manufacturer_info['image'];
		} else {
			$this->data['image'] = '';
		}

		$this->load->model('tool/image');

		if (isset($this->request->post['image']) && is_file(DIR_IMAGE . $this->request->post['image'])) {
			$this->data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		} elseif (!empty($manufacturer_info) && $manufacturer_info['image'] && is_file(DIR_IMAGE . $manufacturer_info['image'])) {
			$this->data['thumb'] = $this->model_tool_image->resize($manufacturer_info['image'], 100, 100);
		} else {
			$this->data['thumb'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}

		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);

		if (isset($this->request->post['sort_order'])) {
			$this->data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($manufacturer_info)) {
			$this->data['sort_order'] = $manufacturer_info['sort_order'];
		} else {
			$this->data['sort_order'] = '';
		}

		$this->template = 'catalog/manufacturer_form.tpl';
		$this->children = array(
				'common/header',
				'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/manufacturer')) {
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
		if (!$this->user->hasPermission('modify', 'catalog/manufacturer')) {
			$this->error['warning'] = __('error_permission');
		}

		$this->load->model('catalog/product');

		foreach ($this->request->post['selected'] as $manufacturer_id) {
			$product_total = $this->model_catalog_product->getTotalProductsByManufacturerId($manufacturer_id);

			if ($product_total) {
				$this->error['warning'] = sprintf(__('error_product'), $product_total);
			}
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name'])) {
			$this->load->model('catalog/manufacturer');
				
			$data = array(
					'filter_name' => $this->request->get['filter_name'],
					'start'       => 0,
					'limit'       => 5
			);
				
			$results = $this->model_catalog_manufacturer->getManufacturers($data);

			foreach ($results as $result) {
				$json[] = array(
						'manufacturer_id' => $result['manufacturer_id'],
						'name'            => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
				);
			}
		}

		$sort_order = array();
		 
		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['name'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->setOutput(json_encode($json));
	}
}
?>