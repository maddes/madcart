<?php 
class ControllerLocalisationLanguage extends Controller {
	private $error = array();
  
	public function index() {
		$this->language->load('localisation/language');
		
		$this->document->setTitle(__('heading_title'));
		
		$this->load->model('localisation/language');
		
		$this->getList();
	}

	public function insert() {
		$this->language->load('localisation/language');

		$this->document->setTitle(__('heading_title'));
		
		$this->load->model('localisation/language');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_localisation_language->addLanguage($this->request->post);
			
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
			
			$this->redirect($this->url->link('localisation/language', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function update() {
		$this->language->load('localisation/language');

		$this->document->setTitle(__('heading_title'));
		
		$this->load->model('localisation/language');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_localisation_language->editLanguage($this->request->get['language_id'], $this->request->post);
			
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
					
			$this->redirect($this->url->link('localisation/language', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->language->load('localisation/language');

		$this->document->setTitle(__('heading_title'));
		
		$this->load->model('localisation/language');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $language_id) {
				$this->model_localisation_language->deleteLanguage($language_id);
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

			$this->redirect($this->url->link('localisation/language', 'token=' . $this->session->data['token'] . $url, 'SSL'));
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
			'href' => $this->url->link('localisation/language', 'token=' . $this->session->data['token'] . $url, 'SSL')
   		);
	
		$this->data['insert'] = $this->url->link('localisation/language/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('localisation/language/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
	
		$this->data['languages'] = array();

		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);
		
		$language_total = $this->model_localisation_language->getTotalLanguages();
		
		$results = $this->model_localisation_language->getLanguages($data);

		foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => __('text_edit'),
				'href' => $this->url->link('localisation/language/update', 'token=' . $this->session->data['token'] . '&language_id=' . $result['language_id'] . $url, 'SSL')
			);
					
			$this->data['languages'][] = array(
				'language_id' => $result['language_id'],
				'name'        => $result['name'] . (($result['code'] == $this->config->get('config_language')) ? __('text_default') : null),
				'code'        => $result['code'],
				'sort_order'  => $result['sort_order'],
				'selected'    => isset($this->request->post['selected']) && in_array($result['language_id'], $this->request->post['selected']),
				'action'      => $action	
			);		
		}
	
		$this->data['heading_title'] = __('heading_title');
		
		$this->data['text_no_results'] = __('text_no_results');

		$this->data['column_name'] = __('column_name');
    	$this->data['column_code'] = __('column_code');
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
					
		$this->data['sort_name'] = $this->url->link('localisation/language', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');
		$this->data['sort_code'] = $this->url->link('localisation/language', 'token=' . $this->session->data['token'] . '&sort=code' . $url, 'SSL');
		$this->data['sort_sort_order'] = $this->url->link('localisation/language', 'token=' . $this->session->data['token'] . '&sort=sort_order' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
				
		$pagination = new Pagination();
		$pagination->total = $language_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->url = $this->url->link('localisation/language', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();
		
		$this->data['results'] = sprintf(__('text_pagination'), ($language_total) ? (($page - 1) * $this->config->get('config_admin_limit')) + 1 : 0, ((($page - 1) * $this->config->get('config_admin_limit')) > ($language_total - $this->config->get('config_admin_limit'))) ? $language_total : ((($page - 1) * $this->config->get('config_admin_limit')) + $this->config->get('config_admin_limit')), $language_total, ceil($language_total / $this->config->get('config_admin_limit')));
		
		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'localisation/language_list.tpl';
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
		
		$this->data['entry_name'] = __('entry_name');
		$this->data['entry_code'] = __('entry_code');
		$this->data['entry_locale'] = __('entry_locale');
		$this->data['entry_image'] = __('entry_image');
		$this->data['entry_directory'] = __('entry_directory');
		$this->data['entry_filename'] = __('entry_filename');
		$this->data['entry_sort_order'] = __('entry_sort_order');
		$this->data['entry_status'] = __('entry_status');

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

 		if (isset($this->error['code'])) {
			$this->data['error_code'] = $this->error['code'];
		} else {
			$this->data['error_code'] = '';
		}
		
 		if (isset($this->error['locale'])) {
			$this->data['error_locale'] = $this->error['locale'];
		} else {
			$this->data['error_locale'] = '';
		}		
		
 		if (isset($this->error['image'])) {
			$this->data['error_image'] = $this->error['image'];
		} else {
			$this->data['error_image'] = '';
		}	
		
 		if (isset($this->error['directory'])) {
			$this->data['error_directory'] = $this->error['directory'];
		} else {
			$this->data['error_directory'] = '';
		}	
		
 		if (isset($this->error['filename'])) {
			$this->data['error_filename'] = $this->error['filename'];
		} else {
			$this->data['error_filename'] = '';
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
			'href' => $this->url->link('localisation/language', 'token=' . $this->session->data['token'] . $url, 'SSL')
   		);
		
		if (!isset($this->request->get['language_id'])) {
			$this->data['action'] = $this->url->link('localisation/language/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('localisation/language/update', 'token=' . $this->session->data['token'] . '&language_id=' . $this->request->get['language_id'] . $url, 'SSL');
		}
		
		$this->data['cancel'] = $this->url->link('localisation/language', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['language_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$language_info = $this->model_localisation_language->getLanguage($this->request->get['language_id']);
		}

		if (isset($this->request->post['name'])) {
			$this->data['name'] = $this->request->post['name'];
		} elseif (!empty($language_info)) {
			$this->data['name'] = $language_info['name'];
		} else {
			$this->data['name'] = '';
		}

		if (isset($this->request->post['code'])) {
			$this->data['code'] = $this->request->post['code'];
		} elseif (!empty($language_info)) {
			$this->data['code'] = $language_info['code'];
		} else {
			$this->data['code'] = '';
		}

		if (isset($this->request->post['locale'])) {
			$this->data['locale'] = $this->request->post['locale'];
		} elseif (!empty($language_info)) {
			$this->data['locale'] = $language_info['locale'];
		} else {
			$this->data['locale'] = '';
		}
		
		if (isset($this->request->post['image'])) {
			$this->data['image'] = $this->request->post['image'];
		} elseif (!empty($language_info)) {
			$this->data['image'] = $language_info['image'];
		} else {
			$this->data['image'] = '';
		}

		if (isset($this->request->post['directory'])) {
			$this->data['directory'] = $this->request->post['directory'];
		} elseif (!empty($language_info)) {
			$this->data['directory'] = $language_info['directory'];
		} else {
			$this->data['directory'] = '';
		}

		if (isset($this->request->post['filename'])) {
			$this->data['filename'] = $this->request->post['filename'];
		} elseif (!empty($language_info)) {
			$this->data['filename'] = $language_info['filename'];
		} else {
			$this->data['filename'] = '';
		}

		if (isset($this->request->post['sort_order'])) {
			$this->data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($language_info)) {
			$this->data['sort_order'] = $language_info['sort_order'];
		} else {
			$this->data['sort_order'] = '';
		}

    	if (isset($this->request->post['status'])) {
      		$this->data['status'] = $this->request->post['status'];
    	} elseif (!empty($language_info)) {
			$this->data['status'] = $language_info['status'];
		} else {
      		$this->data['status'] = 1;
    	}

		$this->template = 'localisation/language_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
	
	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'localisation/language')) {
			$this->error['warning'] = __('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 32)) {
			$this->error['name'] = __('error_name');
		}

		if (utf8_strlen($this->request->post['code']) < 2) {
			$this->error['code'] = __('error_code');
		}

		if (!$this->request->post['locale']) {
			$this->error['locale'] = __('error_locale');
		}
		
		if (!$this->request->post['directory']) { 
			$this->error['directory'] = __('error_directory'); 
		}

		if (!$this->request->post['filename']) {
			$this->error['filename'] = __('error_filename');
		}
		
		if ((utf8_strlen($this->request->post['image']) < 3) || (utf8_strlen($this->request->post['image']) > 32)) {
			$this->error['image'] = __('error_image');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'localisation/language')) {
			$this->error['warning'] = __('error_permission');
		} 
		
		$this->load->model('setting/store');
		$this->load->model('sale/order');
		
		foreach ($this->request->post['selected'] as $language_id) {
			$language_info = $this->model_localisation_language->getLanguage($language_id);

			if ($language_info) {
				if ($this->config->get('config_language') == $language_info['code']) {
					$this->error['warning'] = __('error_default');
				}
				
				if ($this->config->get('config_admin_language') == $language_info['code']) {
					$this->error['warning'] = __('error_admin');
				}	
			
				$store_total = $this->model_setting_store->getTotalStoresByLanguage($language_info['code']);
	
				if ($store_total) {
					$this->error['warning'] = sprintf(__('error_store'), $store_total);
				}
			}
				
			$order_total = $this->model_sale_order->getTotalOrdersByLanguageId($language_id);

			if ($order_total) {
				$this->error['warning'] = sprintf(__('error_order'), $order_total);
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