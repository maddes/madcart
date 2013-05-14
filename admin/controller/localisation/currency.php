<?php 
class ControllerLocalisationCurrency extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('localisation/currency');

		$this->document->setTitle(__('heading_title'));

		$this->load->model('localisation/currency');

		$this->getList();
	}

	public function insert() {
		$this->language->load('localisation/currency');

		$this->document->setTitle(__('heading_title'));

		$this->load->model('localisation/currency');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_localisation_currency->addCurrency($this->request->post);
				
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

			$this->redirect($this->url->link('localisation/currency', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function update() {
		$this->language->load('localisation/currency');

		$this->document->setTitle(__('heading_title'));

		$this->load->model('localisation/currency');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_localisation_currency->editCurrency($this->request->get['currency_id'], $this->request->post);
				
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

			$this->redirect($this->url->link('localisation/currency', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->language->load('localisation/currency');

		$this->document->setTitle(__('heading_title'));

		$this->load->model('localisation/currency');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $currency_id) {
				$this->model_localisation_currency->deleteCurrency($currency_id);
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

			$this->redirect($this->url->link('localisation/currency', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'title';
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
				'href' => $this->url->link('localisation/currency', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		$this->data['insert'] = $this->url->link('localisation/currency/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('localisation/currency/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$this->data['currencies'] = array();

		$data = array(
				'sort'  => $sort,
				'order' => $order,
				'start' => ($page - 1) * $this->config->get('config_admin_limit'),
				'limit' => $this->config->get('config_admin_limit')
		);

		$currency_total = $this->model_localisation_currency->getTotalCurrencies();

		$results = $this->model_localisation_currency->getCurrencies($data);

		foreach ($results as $result) {
			$action = array();
				
			$action[] = array(
					'text' => __('text_edit'),
					'href' => $this->url->link('localisation/currency/update', 'token=' . $this->session->data['token'] . '&currency_id=' . $result['currency_id'] . $url, 'SSL')
			);

			$this->data['currencies'][] = array(
					'currency_id'   => $result['currency_id'],
					'title'         => $result['title'] . (($result['code'] == $this->config->get('config_currency')) ? __('text_default') : null),
					'code'          => $result['code'],
					'value'         => $result['value'],
					'date_modified' => date(__('date_format_short'), strtotime($result['date_modified'])),
					'selected'      => isset($this->request->post['selected']) && in_array($result['currency_id'], $this->request->post['selected']),
					'action'        => $action
			);
		}

		$this->data['heading_title'] = __('heading_title');

		$this->data['text_no_results'] = __('text_no_results');

		$this->data['column_title'] = __('column_title');
		$this->data['column_code'] = __('column_code');
		$this->data['column_value'] = __('column_value');
		$this->data['column_date_modified'] = __('column_date_modified');
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

		$this->data['sort_title'] = $this->url->link('localisation/currency', 'token=' . $this->session->data['token'] . '&sort=title' . $url, 'SSL');
		$this->data['sort_code'] = $this->url->link('localisation/currency', 'token=' . $this->session->data['token'] . '&sort=code' . $url, 'SSL');
		$this->data['sort_value'] = $this->url->link('localisation/currency', 'token=' . $this->session->data['token'] . '&sort=value' . $url, 'SSL');
		$this->data['sort_date_modified'] = $this->url->link('localisation/currency', 'token=' . $this->session->data['token'] . '&sort=date_modified' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $currency_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->url = $this->url->link('localisation/currency', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();

		$this->data['results'] = sprintf(__('text_pagination'), ($currency_total) ? (($page - 1) * $this->config->get('config_admin_limit')) + 1 : 0, ((($page - 1) * $this->config->get('config_admin_limit')) > ($currency_total - $this->config->get('config_admin_limit'))) ? $currency_total : ((($page - 1) * $this->config->get('config_admin_limit')) + $this->config->get('config_admin_limit')), $currency_total, ceil($currency_total / $this->config->get('config_admin_limit')));

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'localisation/currency_list.tpl';
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

		$this->data['entry_title'] = __('entry_title');
		$this->data['entry_code'] = __('entry_code');
		$this->data['entry_value'] = __('entry_value');
		$this->data['entry_symbol_left'] = __('entry_symbol_left');
		$this->data['entry_symbol_right'] = __('entry_symbol_right');
		$this->data['entry_decimal_place'] = __('entry_decimal_place');
		$this->data['entry_status'] = __('entry_status');

		$this->data['help_code'] = __('help_code');
		$this->data['help_value'] = __('help_value');

		$this->data['button_save'] = __('button_save');
		$this->data['button_cancel'] = __('button_cancel');

		$this->data['tab_general'] = __('tab_general');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['title'])) {
			$this->data['error_title'] = $this->error['title'];
		} else {
			$this->data['error_title'] = '';
		}

		if (isset($this->error['code'])) {
			$this->data['error_code'] = $this->error['code'];
		} else {
			$this->data['error_code'] = '';
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
				'href' => $this->url->link('localisation/currency', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		if (!isset($this->request->get['currency_id'])) {
			$this->data['action'] = $this->url->link('localisation/currency/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('localisation/currency/update', 'token=' . $this->session->data['token'] . '&currency_id=' . $this->request->get['currency_id'] . $url, 'SSL');
		}

		$this->data['cancel'] = $this->url->link('localisation/currency', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['currency_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$currency_info = $this->model_localisation_currency->getCurrency($this->request->get['currency_id']);
		}

		if (isset($this->request->post['title'])) {
			$this->data['title'] = $this->request->post['title'];
		} elseif (!empty($currency_info)) {
			$this->data['title'] = $currency_info['title'];
		} else {
			$this->data['title'] = '';
		}

		if (isset($this->request->post['code'])) {
			$this->data['code'] = $this->request->post['code'];
		} elseif (!empty($currency_info)) {
			$this->data['code'] = $currency_info['code'];
		} else {
			$this->data['code'] = '';
		}

		if (isset($this->request->post['symbol_left'])) {
			$this->data['symbol_left'] = $this->request->post['symbol_left'];
		} elseif (!empty($currency_info)) {
			$this->data['symbol_left'] = $currency_info['symbol_left'];
		} else {
			$this->data['symbol_left'] = '';
		}

		if (isset($this->request->post['symbol_right'])) {
			$this->data['symbol_right'] = $this->request->post['symbol_right'];
		} elseif (!empty($currency_info)) {
			$this->data['symbol_right'] = $currency_info['symbol_right'];
		} else {
			$this->data['symbol_right'] = '';
		}

		if (isset($this->request->post['decimal_place'])) {
			$this->data['decimal_place'] = $this->request->post['decimal_place'];
		} elseif (!empty($currency_info)) {
			$this->data['decimal_place'] = $currency_info['decimal_place'];
		} else {
			$this->data['decimal_place'] = '';
		}

		if (isset($this->request->post['value'])) {
			$this->data['value'] = $this->request->post['value'];
		} elseif (!empty($currency_info)) {
			$this->data['value'] = $currency_info['value'];
		} else {
			$this->data['value'] = '';
		}

		if (isset($this->request->post['status'])) {
			$this->data['status'] = $this->request->post['status'];
		} elseif (!empty($currency_info)) {
			$this->data['status'] = $currency_info['status'];
		} else {
			$this->data['status'] = '';
		}

		$this->template = 'localisation/currency_form.tpl';
		$this->children = array(
				'common/header',
				'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'localisation/currency')) {
			$this->error['warning'] = __('error_permission');
		}

		if ((utf8_strlen($this->request->post['title']) < 3) || (utf8_strlen($this->request->post['title']) > 32)) {
			$this->error['title'] = __('error_title');
		}

		if (utf8_strlen($this->request->post['code']) != 3) {
			$this->error['code'] = __('error_code');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'localisation/currency')) {
			$this->error['warning'] = __('error_permission');
		}

		$this->load->model('setting/store');
		$this->load->model('sale/order');

		foreach ($this->request->post['selected'] as $currency_id) {
			$currency_info = $this->model_localisation_currency->getCurrency($currency_id);

			if ($currency_info) {
				if ($this->config->get('config_currency') == $currency_info['code']) {
					$this->error['warning'] = __('error_default');
				}

				$store_total = $this->model_setting_store->getTotalStoresByCurrency($currency_info['code']);

				if ($store_total) {
					$this->error['warning'] = sprintf(__('error_store'), $store_total);
				}
			}
				
			$order_total = $this->model_sale_order->getTotalOrdersByCurrencyId($currency_id);

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