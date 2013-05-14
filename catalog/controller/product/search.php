<?php
class ControllerProductSearch extends Controller {
	public function index() {
		$this->language->load('product/search');

		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');

		if (isset($this->request->get['search'])) {
			$search = $this->request->get['search'];
		} else {
			$search = '';
		}

		if (isset($this->request->get['tag'])) {
			$tag = $this->request->get['tag'];
		} elseif (isset($this->request->get['search'])) {
			$tag = $this->request->get['search'];
		} else {
			$tag = '';
		}

		if (isset($this->request->get['description'])) {
			$description = $this->request->get['description'];
		} else {
			$description = '';
		}

		if (isset($this->request->get['category_id'])) {
			$category_id = $this->request->get['category_id'];
		} else {
			$category_id = 0;
		}

		if (isset($this->request->get['sub_category'])) {
			$sub_category = $this->request->get['sub_category'];
		} else {
			$sub_category = '';
		}

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

		if (isset($this->request->get['search'])) {
			$this->document->setTitle(__('Search','product/search') .  ' - ' . $this->request->get['search']);
		} elseif (isset($this->request->get['tag'])) {
			$this->document->setTitle(__('Search','product/search') .  ' - ' . ' tag - ' . $this->request->get['tag']);
		} else {
			$this->document->setTitle(__('Search','product/search'));
		}

		$this->document->addScript('catalog/view/javascript/jquery/jquery.cookie.js');
		$this->document->addScript('catalog/view/javascript/jquery/jquery.total-storage.min.js');

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
				'text' => __('text_home'),
				'href' => $this->url->link('common/home')
		);

		$url = '';

		if (isset($this->request->get['search'])) {
			$url .= '&search=' . urlencode(html_entity_decode($this->request->get['search'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['tag'])) {
			$url .= '&tag=' . urlencode(html_entity_decode($this->request->get['tag'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['description'])) {
			$url .= '&description=' . $this->request->get['description'];
		}

		if (isset($this->request->get['category_id'])) {
			$url .= '&category_id=' . $this->request->get['category_id'];
		}

		if (isset($this->request->get['sub_category'])) {
			$url .= '&sub_category=' . $this->request->get['sub_category'];
		}

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
				'text' => __('Search','product/search'),
				'href' => $this->url->link('product/search', $url)
		);

		if (isset($this->request->get['search'])) {
			$this->data['heading_title'] = __('Search','product/search') .  ' - ' . $this->request->get['search'];
		} else {
			$this->data['heading_title'] = __('Search','product/search');
		}

		$this->data['text_empty'] = __('There is no product that matches the search criteria.','product/search');
		$this->data['text_critea'] = __('Search Criteria','product/search');
		$this->data['text_search'] = __('Products meeting the search criteria','product/search');
		$this->data['text_keyword'] = __('Keywords','product/search');
		$this->data['text_category'] = __('All Categories','product/search');
		$this->data['text_sub_category'] = __('Search in subcategories','product/search');
		$this->data['text_quantity'] = __('Qty:','product/search');
		$this->data['text_manufacturer'] = __('Brand:','product/search');
		$this->data['text_model'] = __('Product Code:','product/search');
		$this->data['text_price'] = __('Price:','product/search');
		$this->data['text_tax'] = __('Ex Tax:','product/search');
		$this->data['text_points'] = __('Reward Points:','product/search');
		$this->data['text_compare'] = sprintf(__('Product Compare (%s)','product/search'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
		$this->data['text_display'] = __('Display:','product/search');
		$this->data['text_list'] = __('List','product/search');
		$this->data['text_grid'] = __('Grid','product/search');
		$this->data['text_sort'] = __('Sort By:','product/search');
		$this->data['text_limit'] = __('Show:','product/search');

		$this->data['entry_search'] = __('Search:','product/search');
		$this->data['entry_description'] = __('Search in product descriptions','product/search');

		$this->data['button_search'] = __('button_search');
		$this->data['button_cart'] = __('button_cart');
		$this->data['button_wishlist'] = __('button_wishlist');
		$this->data['button_compare'] = __('button_compare');

		$this->data['compare'] = $this->url->link('product/compare');

		$this->load->model('catalog/category');

		// 3 Level Category Search
		$this->data['categories'] = array();

		$categories_1 = $this->model_catalog_category->getCategories(0);

		foreach ($categories_1 as $category_1) {
			$level_2_data = array();

			$categories_2 = $this->model_catalog_category->getCategories($category_1['category_id']);

			foreach ($categories_2 as $category_2) {
				$level_3_data = array();

				$categories_3 = $this->model_catalog_category->getCategories($category_2['category_id']);

				foreach ($categories_3 as $category_3) {
					$level_3_data[] = array(
							'category_id' => $category_3['category_id'],
							'name'        => $category_3['name'],
					);
				}

				$level_2_data[] = array(
						'category_id' => $category_2['category_id'],
						'name'        => $category_2['name'],
						'children'    => $level_3_data
				);
			}

			$this->data['categories'][] = array(
					'category_id' => $category_1['category_id'],
					'name'        => $category_1['name'],
					'children'    => $level_2_data
			);
		}

		$this->data['products'] = array();

		if (isset($this->request->get['search']) || isset($this->request->get['tag'])) {
			$data = array(
					'filter_name'         => $search,
					'filter_tag'          => $tag,
					'filter_description'  => $description,
					'filter_category_id'  => $category_id,
					'filter_sub_category' => $sub_category,
					'sort'                => $sort,
					'order'               => $order,
					'start'               => ($page - 1) * $limit,
					'limit'               => $limit
			);

			$results = $this->model_catalog_product->getProducts($data);
				
			$product_total = $this->model_catalog_product->getFoundProducts();

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
						'reviews'     => sprintf(__('Based on %s reviews.','product/search'), (int)$result['reviews']),
						'href'        => $this->url->link('product/product', 'product_id=' . $result['product_id'] . $url)
				);
			}

			$url = '';

			if (isset($this->request->get['search'])) {
				$url .= '&search=' . urlencode(html_entity_decode($this->request->get['search'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['tag'])) {
				$url .= '&tag=' . urlencode(html_entity_decode($this->request->get['tag'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['description'])) {
				$url .= '&description=' . $this->request->get['description'];
			}

			if (isset($this->request->get['category_id'])) {
				$url .= '&category_id=' . $this->request->get['category_id'];
			}

			if (isset($this->request->get['sub_category'])) {
				$url .= '&sub_category=' . $this->request->get['sub_category'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$this->data['sorts'] = array();

			$this->data['sorts'][] = array(
					'text'  => __('Default','product/search'),
					'value' => 'p.sort_order-ASC',
					'href'  => $this->url->link('product/search', 'sort=p.sort_order&order=ASC' . $url)
			);

			$this->data['sorts'][] = array(
					'text'  => __('Name (A - Z)','product/search'),
					'value' => 'pd.name-ASC',
					'href'  => $this->url->link('product/search', 'sort=pd.name&order=ASC' . $url)
			);

			$this->data['sorts'][] = array(
					'text'  => __('Name (Z - A)','product/search'),
					'value' => 'pd.name-DESC',
					'href'  => $this->url->link('product/search', 'sort=pd.name&order=DESC' . $url)
			);

			$this->data['sorts'][] = array(
					'text'  => __('Price (Low &gt; High)','product/search'),
					'value' => 'p.price-ASC',
					'href'  => $this->url->link('product/search', 'sort=p.price&order=ASC' . $url)
			);

			$this->data['sorts'][] = array(
					'text'  => __('Price (High &gt; Low)','product/search'),
					'value' => 'p.price-DESC',
					'href'  => $this->url->link('product/search', 'sort=p.price&order=DESC' . $url)
			);

			if ($this->config->get('config_review_status')) {
				$this->data['sorts'][] = array(
						'text'  => __('Rating (Highest)','product/search'),
						'value' => 'rating-DESC',
						'href'  => $this->url->link('product/search', 'sort=rating&order=DESC' . $url)
				);

				$this->data['sorts'][] = array(
						'text'  => __('Rating (Lowest)','product/search'),
						'value' => 'rating-ASC',
						'href'  => $this->url->link('product/search', 'sort=rating&order=ASC' . $url)
				);
			}

			$this->data['sorts'][] = array(
					'text'  => __('Model (A - Z)','product/search'),
					'value' => 'p.model-ASC',
					'href'  => $this->url->link('product/search', 'sort=p.model&order=ASC' . $url)
			);

			$this->data['sorts'][] = array(
					'text'  => __('Model (Z - A)','product/search'),
					'value' => 'p.model-DESC',
					'href'  => $this->url->link('product/search', 'sort=p.model&order=DESC' . $url)
			);

			$url = '';

			if (isset($this->request->get['search'])) {
				$url .= '&search=' . urlencode(html_entity_decode($this->request->get['search'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['tag'])) {
				$url .= '&tag=' . urlencode(html_entity_decode($this->request->get['tag'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['description'])) {
				$url .= '&description=' . $this->request->get['description'];
			}

			if (isset($this->request->get['category_id'])) {
				$url .= '&category_id=' . $this->request->get['category_id'];
			}

			if (isset($this->request->get['sub_category'])) {
				$url .= '&sub_category=' . $this->request->get['sub_category'];
			}

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
						'href'  => $this->url->link('product/search', $url . '&limit=' . $limits)
				);
			}

			$url = '';

			if (isset($this->request->get['search'])) {
				$url .= '&search=' . urlencode(html_entity_decode($this->request->get['search'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['tag'])) {
				$url .= '&tag=' . urlencode(html_entity_decode($this->request->get['tag'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['description'])) {
				$url .= '&description=' . $this->request->get['description'];
			}

			if (isset($this->request->get['category_id'])) {
				$url .= '&category_id=' . $this->request->get['category_id'];
			}

			if (isset($this->request->get['sub_category'])) {
				$url .= '&sub_category=' . $this->request->get['sub_category'];
			}

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
			$pagination->url = $this->url->link('product/search', $url . '&page={page}');

			$this->data['pagination'] = $pagination->render();
				
			$this->data['results'] = sprintf(__('text_pagination'), ($product_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($product_total - $limit)) ? $product_total : ((($page - 1) * $limit) + $limit), $product_total, ceil($product_total / $limit));
		}

		$this->data['search'] = $search;
		$this->data['description'] = $description;
		$this->data['category_id'] = $category_id;
		$this->data['sub_category'] = $sub_category;

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;
		$this->data['limit'] = $limit;

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/search.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/product/search.tpl';
		} else {
			$this->template = 'default/template/product/search.tpl';
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
