<?php
class ControllerSaleCustomField extends Controller {
	private $error = array();  
 
	public function index() {
		$this->language->load('sale/custom_field');

		$this->document->setTitle(__('heading_title'));
		
		$this->load->model('sale/custom_field');
		
		$this->getList();
	}

	public function insert() {
		$this->language->load('sale/custom_field');

		$this->document->setTitle(__('heading_title'));
		
		$this->load->model('sale/custom_field');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_sale_custom_field->addCustomField($this->request->post);
			
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
			
			$this->redirect($this->url->link('sale/custom_field', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function update() {
		$this->language->load('sale/custom_field');

		$this->document->setTitle(__('heading_title'));
		
		$this->load->model('sale/custom_field');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_sale_custom_field->editCustomField($this->request->get['custom_field_id'], $this->request->post);
			
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
			
			$this->redirect($this->url->link('sale/custom_field', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->language->load('sale/custom_field');

		$this->document->setTitle(__('heading_title'));
 		
		$this->load->model('sale/custom_field');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $custom_field_id) {
				$this->model_sale_custom_field->deleteCustomField($custom_field_id);
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
			
			$this->redirect($this->url->link('sale/custom_field', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'cfd.name';
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
			'href' => $this->url->link('sale/custom_field', 'token=' . $this->session->data['token'] . $url, 'SSL')
   		);
		
		$this->data['insert'] = $this->url->link('sale/custom_field/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('sale/custom_field/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
		 
		$this->data['custom_fields'] = array();
		
		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);
		
		$custom_field_total = $this->model_sale_custom_field->getTotalCustomFields();
		
		$results = $this->model_sale_custom_field->getCustomFields($data);
		
		foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => __('text_edit'),
				'href' => $this->url->link('sale/custom_field/update', 'token=' . $this->session->data['token'] . '&custom_field_id=' . $result['custom_field_id'] . $url, 'SSL')
			);
			
			$type = '';
			
			switch ($result['type']) {
				case 'select':
					$type = __('text_select');
					break;
				case 'radio':
					$type = __('text_radio');
					break;
				case 'checkbox':
					$type = __('text_checkbox');
					break;
				case 'input':
					$type = __('text_input');
					break;
				case 'text':
					$type = __('text_text');
					break;
				case 'textarea':
					$type = __('text_textarea');
					break;
				case 'file':
					$type = __('text_file');
					break;
				case 'date':
					$type = __('text_date');
					break;																														
				case 'datetime':
					$type = __('text_datetime');
					break;	
				case 'time':
					$type = __('text_time');
					break;																	
			}
			
			$location = '';
			
			switch ($result['location']) {
				case 'customer':
					$location = __('text_customer');
					break;
				case 'address':
					$location = __('text_address');
					break;
				case 'payment_address':
					$location = __('text_payment_address');
					break;
				case 'shipping_address':
					$location = __('text_shipping_address');
					break;										
			}			
		
			$this->data['custom_fields'][] = array(
				'custom_field_id' => $result['custom_field_id'],
				'name'            => $result['name'],
				'type'            => $type,
				'location'        => $location,
				'status'          => $result['status'],
				'sort_order'      => $result['sort_order'],
				'selected'        => isset($this->request->post['selected']) && in_array($result['custom_field_id'], $this->request->post['selected']),
				'action'          => $action
			);
		}

		$this->data['heading_title'] = __('heading_title');
		
		$this->data['text_no_results'] = __('text_no_results');
		
		$this->data['column_name'] = __('column_name');
		$this->data['column_type'] = __('column_type');
		$this->data['column_location'] = __('column_location');
		$this->data['column_status'] = __('column_status');
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
		
		$this->data['sort_name'] = $this->url->link('sale/custom_field', 'token=' . $this->session->data['token'] . '&sort=cfd.name' . $url, 'SSL');
		$this->data['sort_type'] = $this->url->link('sale/custom_field', 'token=' . $this->session->data['token'] . '&sort=cf.type' . $url, 'SSL');
		$this->data['sort_location'] = $this->url->link('sale/custom_field', 'token=' . $this->session->data['token'] . '&sort=cf.name' . $url, 'SSL');
		$this->data['sort_status'] = $this->url->link('sale/custom_field', 'token=' . $this->session->data['token'] . '&sort=cf.status' . $url, 'SSL');
		$this->data['sort_sort_order'] = $this->url->link('sale/custom_field', 'token=' . $this->session->data['token'] . '&sort=cf.sort_order' . $url, 'SSL');
		
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $custom_field_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->url = $this->url->link('sale/custom_field', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();
		
		$this->data['results'] = sprintf(__('text_pagination'), ($custom_field_total) ? (($page - 1) * $this->config->get('config_admin_limit')) + 1 : 0, ((($page - 1) * $this->config->get('config_admin_limit')) > ($custom_field_total - $this->config->get('config_admin_limit'))) ? $custom_field_total : ((($page - 1) * $this->config->get('config_admin_limit')) + $this->config->get('config_admin_limit')), $custom_field_total, ceil($custom_field_total / $this->config->get('config_admin_limit')));
		
		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'sale/custom_field_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}

	protected function getForm() {
		$this->data['heading_title'] = __('heading_title');
		
		$this->data['text_choose'] = __('text_choose');
		$this->data['text_select'] = __('text_select');
		$this->data['text_radio'] = __('text_radio');
		$this->data['text_checkbox'] = __('text_checkbox');
		$this->data['text_input'] = __('text_input');
		$this->data['text_text'] = __('text_text');
		$this->data['text_textarea'] = __('text_textarea');
		$this->data['text_file'] = __('text_file');
		$this->data['text_date'] = __('text_date');
		$this->data['text_datetime'] = __('text_datetime');
		$this->data['text_time'] = __('text_time');
		$this->data['text_customer'] = __('text_customer');
		$this->data['text_address'] = __('text_address');
		$this->data['text_payment_address'] = __('text_payment_address');
		$this->data['text_shipping_address'] = __('text_shipping_address');
		
		$this->data['text_enabled'] = __('text_enabled');
		$this->data['text_disabled'] = __('text_disabled');
		$this->data['text_begining'] = __('text_begining');
		$this->data['text_firstname'] = __('text_firstname');
		$this->data['text_lastname'] = __('text_lastname');
		$this->data['text_email'] = __('text_email');
		$this->data['text_telephone'] = __('text_telephone');
		$this->data['text_fax'] = __('text_fax');
		$this->data['text_company'] = __('text_company');
		$this->data['text_customer_group'] = __('text_customer_group');
		$this->data['text_address_1'] = __('text_address_1');
		$this->data['text_address_2'] = __('text_address_2');
		$this->data['text_city'] = __('text_city');
		$this->data['text_postcode'] = __('text_postcode');
		$this->data['text_country'] = __('text_country');
		$this->data['text_zone'] = __('text_zone');	
		
		$this->data['entry_name'] = __('entry_name');
		$this->data['entry_type'] = __('entry_type');
		$this->data['entry_value'] = __('entry_value');
		$this->data['entry_custom_value'] = __('entry_custom_value');
		$this->data['entry_customer_group'] = __('entry_customer_group');
		$this->data['entry_required'] = __('entry_required');
		$this->data['entry_location'] = __('entry_location');
		$this->data['entry_position'] = __('entry_position');
		$this->data['entry_status'] = __('entry_status');
		$this->data['entry_sort_order'] = __('entry_sort_order');

		$this->data['help_position'] = __('help_position');

		$this->data['button_save'] = __('button_save');
		$this->data['button_cancel'] = __('button_cancel');
		$this->data['button_add_custom_field_value'] = __('button_add_custom_field_value');
		$this->data['button_remove'] = __('button_remove');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
 		if (isset($this->error['name'])) {
			$this->data['error_name'] = $this->error['name'];
		} else {
			$this->data['error_name'] = array();
		}	
				
 		if (isset($this->error['custom_field_value'])) {
			$this->data['error_custom_field_value'] = $this->error['custom_field_value'];
		} else {
			$this->data['error_custom_field_value'] = array();
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
			'href' => $this->url->link('sale/custom_field', 'token=' . $this->session->data['token'] . $url, 'SSL')
   		);
		
		if (!isset($this->request->get['custom_field_id'])) {
			$this->data['action'] = $this->url->link('sale/custom_field/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else { 
			$this->data['action'] = $this->url->link('sale/custom_field/update', 'token=' . $this->session->data['token'] . '&custom_field_id=' . $this->request->get['custom_field_id'] . $url, 'SSL');
		}

		$this->data['cancel'] = $this->url->link('sale/custom_field', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['custom_field_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$custom_field_info = $this->model_sale_custom_field->getCustomField($this->request->get['custom_field_id']);
    	}
		
		$this->data['token'] = $this->session->data['token'];
		
		$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		
		if (isset($this->request->post['custom_field_description'])) {
			$this->data['custom_field_description'] = $this->request->post['custom_field_description'];
		} elseif (isset($this->request->get['custom_field_id'])) {
			$this->data['custom_field_description'] = $this->model_sale_custom_field->getCustomFieldDescriptions($this->request->get['custom_field_id']);
		} else {
			$this->data['custom_field_description'] = array();
		}	
						
		if (isset($this->request->post['type'])) {
			$this->data['type'] = $this->request->post['type'];
		} elseif (!empty($custom_field_info)) {
			$this->data['type'] = $custom_field_info['type'];
		} else {
			$this->data['type'] = '';
		}
		
		if (isset($this->request->post['value'])) {
			$this->data['value'] = $this->request->post['value'];
		} elseif (!empty($custom_field_info)) {
			$this->data['value'] = $custom_field_info['value'];
		} else {
			$this->data['value'] = '';
		}
				
		if (isset($this->request->post['custom_field_customer_group'])) {
			$custom_field_customer_groups = $this->request->post['custom_field_customer_group'];
		} elseif (isset($this->request->get['custom_field_id'])) {
			$custom_field_customer_groups = $this->model_sale_custom_field->getCustomFieldCustomerGroups($this->request->get['custom_field_id']);
		} else {
			$custom_field_customer_groups = array();
		}
		
		$this->data['custom_field_customer_group'] = array();
		
		foreach ($custom_field_customer_groups as $custom_field_customer_group) {
			if (isset($custom_field_customer_group['customer_group_id'])) {
				$this->data['custom_field_customer_group'][] = $custom_field_customer_group['customer_group_id'];
			}
		}
		
		$this->data['custom_field_required'] = array();
		
		foreach ($custom_field_customer_groups as $custom_field_customer_group) {
			if (isset($custom_field_customer_group['required'])) {
				$this->data['custom_field_required'][] = $custom_field_customer_group['required'];
			}
		}
		
		$this->load->model('sale/customer_group');
		
		$this->data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups();	
								
		if (isset($this->request->post['location'])) {
			$this->data['location'] = $this->request->post['location'];
		} elseif (!empty($custom_field_info)) {
			$this->data['location'] = $custom_field_info['location'];
		} else {
			$this->data['location'] = '';
		}
		
		if (isset($this->request->post['position'])) {
			$this->data['position'] = $this->request->post['position'];
		} elseif (!empty($custom_field_info)) {
			$this->data['position'] = $custom_field_info['position'];
		} else {
			$this->data['position'] = '';
		}
			
		if (isset($this->request->post['status'])) {
			$this->data['status'] = $this->request->post['status'];
		} elseif (!empty($custom_field_info)) {
			$this->data['status'] = $custom_field_info['status'];
		} else {
			$this->data['status'] = '';
		}
					
		if (isset($this->request->post['sort_order'])) {
			$this->data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($custom_field_info)) {
			$this->data['sort_order'] = $custom_field_info['sort_order'];
		} else {
			$this->data['sort_order'] = '';
		}
		
		if (isset($this->request->post['custom_field_value'])) {
			$custom_field_values = $this->request->post['custom_field_value'];
		} elseif (isset($this->request->get['custom_field_id'])) {
			$custom_field_values = $this->model_sale_custom_field->getCustomFieldValueDescriptions($this->request->get['custom_field_id']);
		} else {
			$custom_field_values = array();
		}
		
		$this->data['custom_field_values'] = array();
		 
		foreach ($custom_field_values as $custom_field_value) {
			$this->data['custom_field_values'][] = array(
				'custom_field_value_id'          => $custom_field_value['custom_field_value_id'],
				'custom_field_value_description' => $custom_field_value['custom_field_value_description'],
				'sort_order'                     => $custom_field_value['sort_order']
			);
		}

		$this->template = 'sale/custom_field_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'sale/custom_field')) {
			$this->error['warning'] = __('error_permission');
		}

		foreach ($this->request->post['custom_field_description'] as $language_id => $value) {
			if ((utf8_strlen($value['name']) < 1) || (utf8_strlen($value['name']) > 128)) {
				$this->error['name'][$language_id] = __('error_name');
			}
		}

		if (($this->request->post['type'] == 'select' || $this->request->post['type'] == 'radio' || $this->request->post['type'] == 'checkbox') && !isset($this->request->post['custom_field_value'])) {
			$this->error['warning'] = __('error_type');
		}

		if (isset($this->request->post['custom_field_value'])) {
			foreach ($this->request->post['custom_field_value'] as $custom_field_value_id => $custom_field_value) {
				foreach ($custom_field_value['custom_field_value_description'] as $language_id => $custom_field_value_description) {
					if ((utf8_strlen($custom_field_value_description['name']) < 1) || (utf8_strlen($custom_field_value_description['name']) > 128)) {
						$this->error['custom_field_value'][$custom_field_value_id][$language_id] = __('error_custom_value'); 
					}					
				}
			}	
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'sale/custom_field')) {
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