<?php  
class ControllerProductCompare extends Controller {
	public function index() {
		$this->language->load('product/compare');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');

		if (!isset($this->session->data['compare'])) {
			$this->session->data['compare'] = array();
		}

		if (isset($this->request->get['remove'])) {
			$key = array_search($this->request->get['remove'], $this->session->data['compare']);

			if ($key !== false) {
				unset($this->session->data['compare'][$key]);
			}

			$this->session->data['success'] = __('Success: You have modified your product comparison!','product/compare');

			$this->redirect($this->url->link('product/compare'));
		}

		$this->document->setTitle(__('Product Comparison','product/compare'));

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
				'text' => __('text_home'),
				'href' => $this->url->link('common/home')
		);

		$this->data['breadcrumbs'][] = array(
				'text' => __('Product Comparison','product/compare'),
				'href' => $this->url->link('product/compare')
		);

		$this->data['heading_title'] = __('Product Comparison','product/compare');

		$this->data['text_product'] = __('Product Details','product/compare');
		$this->data['text_name'] = __('Product','product/compare');
		$this->data['text_image'] = __('Image','product/compare');
		$this->data['text_price'] = __('Price','product/compare');
		$this->data['text_model'] = __('Model','product/compare');
		$this->data['text_manufacturer'] = __('Brand','product/compare');
		$this->data['text_availability'] = __('Availability','product/compare');
		$this->data['text_rating'] = __('Rating','product/compare');
		$this->data['text_summary'] = __('Summary','product/compare');
		$this->data['text_weight'] = __('Weight','product/compare');
		$this->data['text_dimension'] = __('Dimensions (L x W x H)','product/compare');
		$this->data['text_empty'] = __('You have not chosen any products to compare.','product/compare');

		$this->data['button_continue'] = __('button_continue');
		$this->data['button_cart'] = __('button_cart');
		$this->data['button_remove'] = __('button_remove');

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
				
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$this->data['review_status'] = $this->config->get('config_review_status');

		$this->data['products'] = array();

		$this->data['attribute_groups'] = array();

		foreach ($this->session->data['compare'] as $key => $product_id) {
			$product_info = $this->model_catalog_product->getProduct($product_id);
				
			if ($product_info) {
				if ($product_info['image']) {
					$image = $this->model_tool_image->resize($product_info['image'], $this->config->get('config_image_compare_width'), $this->config->get('config_image_compare_height'));
				} else {
					$image = false;
				}

				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$price = false;
				}

				if ((float)$product_info['special']) {
					$special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$special = false;
				}
					
				if ($product_info['quantity'] <= 0) {
					$availability = $product_info['stock_status'];
				} elseif ($this->config->get('config_stock_display')) {
					$availability = $product_info['quantity'];
				} else {
					$availability = __('In Stock','product/compare');
				}

				$attribute_data = array();

				$attribute_groups = $this->model_catalog_product->getProductAttributes($product_id);

				foreach ($attribute_groups as $attribute_group) {
					foreach ($attribute_group['attribute'] as $attribute) {
						$attribute_data[$attribute['attribute_id']] = $attribute['text'];
					}
				}
					
				$this->data['products'][$product_id] = array(
						'product_id'   => $product_info['product_id'],
						'name'         => $product_info['name'],
						'thumb'        => $image,
						'price'        => $price,
						'special'      => $special,
						'description'  => utf8_substr(strip_tags(html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8')), 0, 200) . '..',
						'model'        => $product_info['model'],
						'manufacturer' => $product_info['manufacturer'],
						'availability' => $availability,
						'rating'       => (int)$product_info['rating'],
						'reviews'      => sprintf(__('Based on %s reviews.','product/compare'), (int)$product_info['reviews']),
						'weight'       => $this->weight->format($product_info['weight'], $product_info['weight_class_id']),
						'length'       => $this->length->format($product_info['length'], $product_info['length_class_id']),
						'width'        => $this->length->format($product_info['width'], $product_info['length_class_id']),
						'height'       => $this->length->format($product_info['height'], $product_info['length_class_id']),
						'attribute'    => $attribute_data,
						'href'         => $this->url->link('product/product', 'product_id=' . $product_id),
						'remove'       => $this->url->link('product/compare', 'remove=' . $product_id)
				);

				foreach ($attribute_groups as $attribute_group) {
					$this->data['attribute_groups'][$attribute_group['attribute_group_id']]['name'] = $attribute_group['name'];
						
					foreach ($attribute_group['attribute'] as $attribute) {
						$this->data['attribute_groups'][$attribute_group['attribute_group_id']]['attribute'][$attribute['attribute_id']]['name'] = $attribute['name'];
					}
				}
			} else {
				unset($this->session->data['compare'][$key]);
			}
		}

		$this->data['continue'] = $this->url->link('common/home');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/compare.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/product/compare.tpl';
		} else {
			$this->template = 'default/template/product/compare.tpl';
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

	public function add() {
		$this->language->load('product/compare');

		$json = array();

		if (!isset($this->session->data['compare'])) {
			$this->session->data['compare'] = array();
		}

		if (isset($this->request->post['product_id'])) {
			$product_id = $this->request->post['product_id'];
		} else {
			$product_id = 0;
		}

		$this->load->model('catalog/product');

		$product_info = $this->model_catalog_product->getProduct($product_id);

		if ($product_info) {
			if (!in_array($this->request->post['product_id'], $this->session->data['compare'])) {
				if (count($this->session->data['compare']) >= 4) {
					array_shift($this->session->data['compare']);
				}

				$this->session->data['compare'][] = $this->request->post['product_id'];
			}

			$json['success'] = sprintf(__('Success: You have added <a href="%s">%s</a> to your <a href="%s">product comparison</a>!','product/compare'), $this->url->link('product/product', 'product_id=' . $this->request->post['product_id']), $product_info['name'], $this->url->link('product/compare'));

			$json['total'] = sprintf(__('Product Compare (%s)','product/compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
		}

		$this->response->setOutput(json_encode($json));
	}
}
?>