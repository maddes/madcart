<?php 
class ControllerAccountWishList extends Controller {
	public function index() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/wishlist', '', 'SSL');

			$this->redirect($this->url->link('account/login', '', 'SSL'));
		}

		$this->language->load('account/wishlist');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');

		if (!isset($this->session->data['wishlist'])) {
			$this->session->data['wishlist'] = array();
		}

		if (isset($this->request->get['remove'])) {
			$key = array_search($this->request->get['remove'], $this->session->data['wishlist']);
				
			if ($key !== false) {
				unset($this->session->data['wishlist'][$key]);
			}

			$this->session->data['success'] = __('Success: You have modified your wishlist!','account/wishlist');

			$this->redirect($this->url->link('account/wishlist'));
		}

		$this->document->setTitle(__('My Wish List','account/wishlist'));
		 
		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
				'text' => __('text_home'),
				'href' => $this->url->link('common/home')
		);

		$this->data['breadcrumbs'][] = array(
				'text' => __('Account','account/wishlist'),
				'href' => $this->url->link('account/account', '', 'SSL')
		);

		$this->data['breadcrumbs'][] = array(
				'text' => __('My Wish List','account/wishlist'),
				'href' => $this->url->link('account/wishlist')
		);

		$this->data['heading_title'] = __('My Wish List','account/wishlist');

		$this->data['text_empty'] = __('Your wish list is empty.','account/wishlist');

		$this->data['column_image'] = __('Image','account/wishlist');
		$this->data['column_name'] = __('Product Name','account/wishlist');
		$this->data['column_model'] = __('Model','account/wishlist');
		$this->data['column_stock'] = __('Stock','account/wishlist');
		$this->data['column_price'] = __('Unit Price','account/wishlist');
		$this->data['column_action'] = __('Action','account/wishlist');

		$this->data['button_continue'] = __('button_continue');
		$this->data['button_cart'] = __('button_cart');
		$this->data['button_remove'] = __('button_remove');

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
				
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
			
		$this->data['products'] = array();

		foreach ($this->session->data['wishlist'] as $key => $product_id) {
			$product_info = $this->model_catalog_product->getProduct($product_id);
				
			if ($product_info) {
				if ($product_info['image']) {
					$image = $this->model_tool_image->resize($product_info['image'], $this->config->get('config_image_wishlist_width'), $this->config->get('config_image_wishlist_height'));
				} else {
					$image = false;
				}

				if ($product_info['quantity'] <= 0) {
					$stock = $product_info['stock_status'];
				} elseif ($this->config->get('config_stock_display')) {
					$stock = $product_info['quantity'];
				} else {
					$stock = __('In Stock','account/wishlist');
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
					
				$this->data['products'][] = array(
						'product_id' => $product_info['product_id'],
						'thumb'      => $image,
						'name'       => $product_info['name'],
						'model'      => $product_info['model'],
						'stock'      => $stock,
						'price'      => $price,
						'special'    => $special,
						'href'       => $this->url->link('product/product', 'product_id=' . $product_info['product_id']),
						'remove'     => $this->url->link('account/wishlist', 'remove=' . $product_info['product_id'])
				);
			} else {
				unset($this->session->data['wishlist'][$key]);
			}
		}

		$this->data['continue'] = $this->url->link('account/account', '', 'SSL');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/wishlist.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/account/wishlist.tpl';
		} else {
			$this->template = 'default/template/account/wishlist.tpl';
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
		$this->language->load('account/wishlist');

		$json = array();

		if (!isset($this->session->data['wishlist'])) {
			$this->session->data['wishlist'] = array();
		}

		if (isset($this->request->post['product_id'])) {
			$product_id = $this->request->post['product_id'];
		} else {
			$product_id = 0;
		}

		$this->load->model('catalog/product');

		$product_info = $this->model_catalog_product->getProduct($product_id);

		if ($product_info) {
			if (!in_array($this->request->post['product_id'], $this->session->data['wishlist'])) {
				$this->session->data['wishlist'][] = $this->request->post['product_id'];
			}

			if ($this->customer->isLogged()) {
				$json['success'] = sprintf(__('Success: You have added <a href="%s">%s</a> to your <a href="%s">wish list</a>!','account/wishlist'), $this->url->link('product/product', 'product_id=' . $this->request->post['product_id']), $product_info['name'], $this->url->link('account/wishlist'));
			} else {
				$json['success'] = sprintf(__('You must <a href="%s">login</a> or <a href="%s">create an account</a> to save <a href="%s">%s</a> to your <a href="%s">wish list</a>!','account/wishlist'), $this->url->link('account/login', '', 'SSL'), $this->url->link('account/register', '', 'SSL'), $this->url->link('product/product', 'product_id=' . $this->request->post['product_id']), $product_info['name'], $this->url->link('account/wishlist'));
			}
				
			$json['total'] = sprintf(__('Wish List (%s)','account/wishlist'), (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0));
		}

		$this->response->setOutput(json_encode($json));
	}
}
?>