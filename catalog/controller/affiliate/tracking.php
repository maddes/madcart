<?php 
class ControllerAffiliateTracking extends Controller {
	public function index() {
		if (!$this->affiliate->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('affiliate/tracking', '', 'SSL');
			 
			$this->redirect($this->url->link('affiliate/login', '', 'SSL'));
		}

		$this->language->load('affiliate/tracking');

		$this->document->setTitle(__('Affiliate Tracking','affiliate/tracking'));

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
				'text' => __('text_home'),
				'href' => $this->url->link('common/home')
		);

		$this->data['breadcrumbs'][] = array(
				'text' => __('Account','affiliate/tracking'),
				'href' => $this->url->link('affiliate/account', '', 'SSL')
		);

		$this->data['breadcrumbs'][] = array(
				'text' => __('Affiliate Tracking','affiliate/tracking'),
				'href' => $this->url->link('affiliate/tracking', '', 'SSL')
		);

		$this->data['heading_title'] = __('Affiliate Tracking','affiliate/tracking');

		$this->data['text_description'] = sprintf(__('To make sure you get paid for referrals you send to us we need to track the referral by placing a tracking code in the URL\'s linking to us. You can use the tools below to generate links to the %s web site.','affiliate/tracking'), $this->config->get('config_name'));
		$this->data['text_code'] = __('<b>Your Tracking Code:</b>','affiliate/tracking');
		$this->data['text_generator'] = __('<b>Tracking Link Generator</b><br />Type in the name of a product you would like to link to:','affiliate/tracking');
		$this->data['text_link'] = __('<b>Tracking Link:</b>','affiliate/tracking');

		$this->data['button_continue'] = __('button_continue');

		$this->data['code'] = $this->affiliate->getCode();

		$this->data['continue'] = $this->url->link('affiliate/account', '', 'SSL');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/affiliate/tracking.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/affiliate/tracking.tpl';
		} else {
			$this->template = 'default/template/affiliate/tracking.tpl';
		}

		$this->children = array(
				'common/column_left',
				'common/column_right',
				'common/content_top',
				'common/content_bottom',
				'common/footer',
				'common/header'
		);

		$this->response->setOutput($this->render());
	}

	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name'])) {
			$this->load->model('catalog/product');

			$data = array(
					'filter_name' => $this->request->get['filter_name'],
					'start'       => 0,
					'limit'       => 20
			);
				
			$results = $this->model_catalog_product->getProducts($data);
				
			foreach ($results as $result) {
				$json[] = array(
						'name' => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
						'link' => str_replace('&amp;', '&', $this->url->link('product/product', 'product_id=' . $result['product_id'] . '&tracking=' . $this->affiliate->getCode()))
				);
			}
		}

		$this->response->setOutput(json_encode($json));
	}
}
?>