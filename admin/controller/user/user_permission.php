<?php
class ControllerUserUserPermission extends Controller {
	private $error = array();
 
	public function index() {
		$this->language->load('user/user_group');
 
		$this->document->setTitle(__('heading_title'));
 		
		$this->load->model('user/user_group');
		
		$this->getList();
	}

	public function insert() {
		$this->language->load('user/user_group');

		$this->document->setTitle(__('heading_title'));
		
		$this->load->model('user/user_group');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_user_user_group->addUserGroup($this->request->post);
			
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
						
			$this->redirect($this->url->link('user/user_permission', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function update() {
		$this->language->load('user/user_group');

		$this->document->setTitle(__('heading_title'));
		
		$this->load->model('user/user_group');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_user_user_group->editUserGroup($this->request->get['user_group_id'], $this->request->post);
			
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
						
			$this->redirect($this->url->link('user/user_permission', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() { 
		$this->language->load('user/user_group');

		$this->document->setTitle(__('heading_title'));
		
		$this->load->model('user/user_group');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
      		foreach ($this->request->post['selected'] as $user_group_id) {
				$this->model_user_user_group->deleteUserGroup($user_group_id);	
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
						
			$this->redirect($this->url->link('user/user_permission', 'token=' . $this->session->data['token'] . $url, 'SSL'));
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
			'href' => $this->url->link('user/user_permission', 'token=' . $this->session->data['token'] . $url, 'SSL')
   		);
							
		$this->data['insert'] = $this->url->link('user/user_permission/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('user/user_permission/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');	
	
		$this->data['user_groups'] = array();

		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);
		
		$user_group_total = $this->model_user_user_group->getTotalUserGroups();
		
		$results = $this->model_user_user_group->getUserGroups($data);

		foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => __('text_edit'),
				'href' => $this->url->link('user/user_permission/update', 'token=' . $this->session->data['token'] . '&user_group_id=' . $result['user_group_id'] . $url, 'SSL')
			);		
		
			$this->data['user_groups'][] = array(
				'user_group_id' => $result['user_group_id'],
				'name'          => $result['name'],
				'selected'      => isset($this->request->post['selected']) && in_array($result['user_group_id'], $this->request->post['selected']),
				'action'        => $action
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

		$this->data['sort_name'] = $this->url->link('user/user_permission', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');
		
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
				
		$pagination = new Pagination();
		$pagination->total = $user_group_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->url = $this->url->link('user/user_permission', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
		
		$this->data['pagination'] = $pagination->render();				
		
		$this->data['results'] = sprintf(__('text_pagination'), ($user_group_total) ? (($page - 1) * $this->config->get('config_admin_limit')) + 1 : 0, ((($page - 1) * $this->config->get('config_admin_limit')) > ($user_group_total - $this->config->get('config_admin_limit'))) ? $user_group_total : ((($page - 1) * $this->config->get('config_admin_limit')) + $this->config->get('config_admin_limit')), $user_group_total, ceil($user_group_total / $this->config->get('config_admin_limit')));

		$this->data['sort'] = $sort; 
		$this->data['order'] = $order;

		$this->template = 'user/user_group_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
 	}

	protected function getForm() {
		$this->data['heading_title'] = __('heading_title');
		
		$this->data['text_select_all'] = __('text_select_all');
		$this->data['text_unselect_all'] = __('text_unselect_all');
				
		$this->data['entry_name'] = __('entry_name');
		$this->data['entry_access'] = __('entry_access');
		$this->data['entry_modify'] = __('entry_modify');
		
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
			'href' => $this->url->link('user/user_permission', 'token=' . $this->session->data['token'] . $url, 'SSL')
   		);
			
		if (!isset($this->request->get['user_group_id'])) {
			$this->data['action'] = $this->url->link('user/user_permission/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('user/user_permission/update', 'token=' . $this->session->data['token'] . '&user_group_id=' . $this->request->get['user_group_id'] . $url, 'SSL');
		}
		  
    	$this->data['cancel'] = $this->url->link('user/user_permission', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['user_group_id']) && $this->request->server['REQUEST_METHOD'] != 'POST') {
			$user_group_info = $this->model_user_user_group->getUserGroup($this->request->get['user_group_id']);
		}

		if (isset($this->request->post['name'])) {
			$this->data['name'] = $this->request->post['name'];
		} elseif (!empty($user_group_info)) {
			$this->data['name'] = $user_group_info['name'];
		} else {
			$this->data['name'] = '';
		}
		
		$ignore = array(
			'common/home',
			'common/startup',
			'common/login',
			'common/logout',
			'common/forgotten',
			'common/reset',			
			'error/not_found',
			'error/permission',
			'common/footer',
			'common/header'
		);
				
		$this->data['permissions'] = array();
		
		$files = glob(DIR_APPLICATION . 'controller/*/*.php');
		
		foreach ($files as $file) {
			$data = explode('/', dirname($file));
			
			$permission = end($data) . '/' . basename($file, '.php');
			
			if (!in_array($permission, $ignore)) {
				$this->data['permissions'][] = $permission;
			}
		}
		
		if (isset($this->request->post['permission']['access'])) {
			$this->data['access'] = $this->request->post['permission']['access'];
		} elseif (isset($user_group_info['permission']['access'])) {
			$this->data['access'] = $user_group_info['permission']['access'];
		} else { 
			$this->data['access'] = array();
		}

		if (isset($this->request->post['permission']['modify'])) {
			$this->data['modify'] = $this->request->post['permission']['modify'];
		} elseif (isset($user_group_info['permission']['modify'])) {
			$this->data['modify'] = $user_group_info['permission']['modify'];
		} else { 
			$this->data['modify'] = array();
		}
	
		$this->template = 'user/user_group_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'user/user_permission')) {
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
		if (!$this->user->hasPermission('modify', 'user/user_permission')) {
			$this->error['warning'] = __('error_permission');
		}
		
		$this->load->model('user/user');
      	
		foreach ($this->request->post['selected'] as $user_group_id) {
			$user_total = $this->model_user_user->getTotalUsersByGroupId($user_group_id);

			if ($user_total) {
				$this->error['warning'] = sprintf(__('error_user'), $user_total);
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