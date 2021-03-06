<?php 
class ControllerProductSpecial extends Controller {
	public function index() {
		$this->language->load('product/special');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'p.sort_order';
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

		if (isset($this->request->get['limit'])) {
			$limit = $this->request->get['limit'];
		} else {
			$limit = $this->config->get('config_catalog_limit');
		}
		 
		$this->document->setTitle(__('Special Offers','product/special'));
		$this->document->addScript('catalog/view/javascript/jquery/jquery.cookie.js');
		$this->document->addScript('catalog/view/javascript/jquery/jquery.total-storage.min.js');

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
				'text' => __('text_home'),
				'href' => $this->url->link('common/home')
		);

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

		if (isset($this->request->get['limit'])) {
			$url .= '&limit=' . $this->request->get['limit'];
		}
			
		$this->data['breadcrumbs'][] = array(
				'text' => __('Special Offers','product/special'),
				'href' => $this->url->link('product/special', $url)
		);

		$this->data['heading_title'] = __('Special Offers','product/special');
		 
		$this->data['text_empty'] = __('There are no special offer products to list.','product/special');
		$this->data['text_quantity'] = __('Qty:','product/special');
		$this->data['text_manufacturer'] = __('Brand:','product/special');
		$this->data['text_model'] = __('Product Code:','product/special');
		$this->data['text_price'] = __('Price:','product/special');
		$this->data['text_tax'] = __('Ex Tax:','product/special');
		$this->data['text_points'] = __('Reward Points:','product/special');
		$this->data['text_compare'] = sprintf(__('Product Compare (%s)','product/special'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
		$this->data['text_display'] = __('Display:','product/special');
		$this->data['text_list'] = __('List','product/special');
		$this->data['text_grid'] = __('Grid','product/special');
		$this->data['text_sort'] = __('Sort By:','product/special');
		$this->data['text_limit'] = __('Show:','product/special');

		$this->data['button_cart'] = __('button_cart');
		$this->data['button_wishlist'] = __('button_wishlist');
		$this->data['button_compare'] = __('button_compare');

		$this->data['compare'] = $this->url->link('product/compare');

		$this->data['products'] = array();

		$data = array(
				'sort'  => $sort,
				'order' => $order,
				'start' => ($page - 1) * $limit,
				'limit' => $limit
		);
			
		$product_total = $this->model_catalog_product->getTotalProductSpecials($data);
			
		$results = $this->model_catalog_product->getProductSpecials($data);
			
		foreach ($results as $result) {
			if ($result['image']) {
				$image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
			} else {
				$image = false;
			}
				
			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$price = false;
			}
				
			if ((float)$result['special']) {
				$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$special = false;
			}
				
			if ($this->config->get('config_tax')) {
				$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price']);
			} else {
				$tax = false;
			}
				
			if ($this->config->get('config_review_status')) {
				$rating = (int)$result['rating'];
			} else {
				$rating = false;
			}

			$this->data['products'][] = array(
					'product_id'  => $result['product_id'],
					'thumb'       => $image,
					'name'        => $result['name'],
					'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_list_description_limit')) . '..',
					'price'       => $price,
					'special'     => $special,
					'tax'         => $tax,
					'rating'      => $result['rating'],
					'reviews'     => sprintf(__('Based on %s reviews.','product/special'), (int)$result['reviews']),
					'href'        => $this->url->link('product/product', 'product_id=' . $result['product_id'] . $url)
			);
		}

		$url = '';

		if (isset($this->request->get['limit'])) {
			$url .= '&limit=' . $this->request->get['limit'];
		}
			
		$this->data['sorts'] = array();

		$this->data['sorts'][] = array(
				'text'  => __('Default','product/special'),
				'value' => 'p.sort_order-ASC',
				'href'  => $this->url->link('product/special', 'sort=p.sort_order&order=ASC' . $url)
		);

		$this->data['sorts'][] = array(
				'text'  => __('Name (A - Z)','product/special'),
				'value' => 'pd.name-ASC',
				'href'  => $this->url->link('product/special', 'sort=pd.name&order=ASC' . $url)
		);

		$this->data['sorts'][] = array(
				'text'  => __('Name (Z - A)','product/special'),
				'value' => 'pd.name-DESC',
				'href'  => $this->url->link('product/special', 'sort=pd.name&order=DESC' . $url)
		);

		$this->data['sorts'][] = array(
				'text'  => __('Price (Low &gt; High)','product/special'),
				'value' => 'ps.price-ASC',
				'href'  => $this->url->link('product/special', 'sort=ps.price&order=ASC' . $url)
		);

		$this->data['sorts'][] = array(
				'text'  => __('Price (High &gt; Low)','product/special'),
				'value' => 'ps.price-DESC',
				'href'  => $this->url->link('product/special', 'sort=ps.price&order=DESC' . $url)
		);

		if ($this->config->get('config_review_status')) {
			$this->data['sorts'][] = array(
					'text'  => __('Rating (Highest)','product/special'),
					'value' => 'rating-DESC',
					'href'  => $this->url->link('product/special', 'sort=rating&order=DESC' . $url)
			);

			$this->data['sorts'][] = array(
					'text'  => __('Rating (Lowest)','product/special'),
					'value' => 'rating-ASC',
					'href'  => $this->url->link('product/special', 'sort=rating&order=ASC' . $url)
			);
		}

		$this->data['sorts'][] = array(
				'text'  => __('Model (A - Z)','product/special'),
				'value' => 'p.model-ASC',
				'href'  => $this->url->link('product/special', 'sort=p.model&order=ASC' . $url)
		);

		$this->data['sorts'][] = array(
				'text'  => __('Model (Z - A)','product/special'),
				'value' => 'p.model-DESC',
				'href'  => $this->url->link('product/special', 'sort=p.model&order=DESC' . $url)
		);

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
			
		$this->data['limits'] = array();

		$limits = array_unique(array($this->config->get('config_catalog_limit'), 25, 50, 75, 100));

		sort($limits);

		foreach($limits as $limits){
			$this->data['limits'][] = array(
					'text'  => $limits,
					'value' => $limits,
					'href'  => $this->url->link('product/special', $url . '&limit=' . $limits)
			);
		}
			
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['limit'])) {
			$url .= '&limit=' . $this->request->get['limit'];
		}

		$pagination = new Pagination();
		$pagination->total = $product_total;
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->url = $this->url->link('product/special', $url . '&page={page}');
			
		$this->data['pagination'] = $pagination->render();

		$this->data['results'] = sprintf(__('text_pagination'), ($product_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($product_total - $limit)) ? $product_total : ((($page - 1) * $limit) + $limit), $product_total, ceil($product_total / $limit));

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;
		$this->data['limit'] = $limit;

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/special.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/product/special.tpl';
		} else {
			$this->template = 'default/template/product/special.tpl';
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
}
?>