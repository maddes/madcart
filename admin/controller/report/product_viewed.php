<?php
class ControllerReportProductViewed extends Controller {
	public function index() {
		$this->language->load('report/product_viewed');

		$this->document->setTitle(__('heading_title'));

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

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
				'href' => $this->url->link('report/product_viewed', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		$this->load->model('report/product');

		$data = array(
				'start' => ($page - 1) * $this->config->get('config_admin_limit'),
				'limit' => $this->config->get('config_admin_limit')
		);

		$product_viewed_total = $this->model_report_product->getTotalProductsViewed($data);

		$product_views_total = $this->model_report_product->getTotalProductViews();

		$this->data['products'] = array();

		$results = $this->model_report_product->getProductsViewed($data);

		foreach ($results as $result) {
			if ($result['viewed']) {
				$percent = round($result['viewed'] / $product_views_total * 100, 2);
			} else {
				$percent = 0;
			}
				
			$this->data['products'][] = array(
					'name'    => $result['name'],
					'model'   => $result['model'],
					'viewed'  => $result['viewed'],
					'percent' => $percent . '%'
			);
		}
			
		$this->data['heading_title'] = __('heading_title');
			
		$this->data['text_no_results'] = __('text_no_results');

		$this->data['column_name'] = __('column_name');
		$this->data['column_model'] = __('column_model');
		$this->data['column_viewed'] = __('column_viewed');
		$this->data['column_percent'] = __('column_percent');

		$this->data['button_reset'] = __('button_reset');

		$url = '';

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$this->data['reset'] = $this->url->link('report/product_viewed/reset', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$pagination = new Pagination();
		$pagination->total = $product_viewed_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->url = $this->url->link('report/product_viewed', 'token=' . $this->session->data['token'] . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();

		$this->data['results'] = sprintf(__('text_pagination'), ($product_viewed_total) ? (($page - 1) * $this->config->get('config_admin_limit')) + 1 : 0, ((($page - 1) * $this->config->get('config_admin_limit')) > ($product_viewed_total - $this->config->get('config_admin_limit'))) ? $product_viewed_total : ((($page - 1) * $this->config->get('config_admin_limit')) + $this->config->get('config_admin_limit')), $product_viewed_total, ceil($product_viewed_total / $this->config->get('config_admin_limit')));
			
		$this->template = 'report/product_viewed.tpl';
		$this->children = array(
				'common/header',
				'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	public function reset() {
		$this->language->load('report/product_viewed');

		$this->load->model('report/product');

		$this->model_report_product->reset();

		$this->session->data['success'] = __('text_success');

		$this->redirect($this->url->link('report/product_viewed', 'token=' . $this->session->data['token'], 'SSL'));
	}
}
?>