<?php 
class ControllerCheckoutCart extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('checkout/cart');

		if (!isset($this->session->data['vouchers'])) {
			$this->session->data['vouchers'] = array();
		}

		// Update
		if (!empty($this->request->post['quantity'])) {
			foreach ($this->request->post['quantity'] as $key => $value) {
				$this->cart->update($key, $value);
			}
				
			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
			unset($this->session->data['payment_method']);
			unset($this->session->data['payment_methods']);
			unset($this->session->data['reward']);
				
			$this->redirect($this->url->link('checkout/cart'));
		}

		// Remove
		if (isset($this->request->get['remove'])) {
			$this->cart->remove($this->request->get['remove']);
				
			unset($this->session->data['vouchers'][$this->request->get['remove']]);
				
			$this->session->data['success'] = __('Success: You have modified your shopping cart!','checkout/cart');

			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
			unset($this->session->data['payment_method']);
			unset($this->session->data['payment_methods']);
			unset($this->session->data['reward']);

			$this->redirect($this->url->link('checkout/cart'));
		}
			
		// Coupon
		if (isset($this->request->post['coupon']) && $this->validateCoupon()) {
			$this->session->data['coupon'] = $this->request->post['coupon'];

			$this->session->data['success'] = __('Success: Your coupon discount has been applied!','checkout/cart');
				
			$this->redirect($this->url->link('checkout/cart'));
		}

		// Voucher
		if (isset($this->request->post['voucher']) && $this->validateVoucher()) {
			$this->session->data['voucher'] = $this->request->post['voucher'];

			$this->session->data['success'] = __('Success: Your gift voucher discount has been applied!','checkout/cart');

			$this->redirect($this->url->link('checkout/cart'));
		}

		// Reward
		if (isset($this->request->post['reward']) && $this->validateReward()) {
			$this->session->data['reward'] = abs($this->request->post['reward']);

			$this->session->data['success'] = __('Success: Your reward points discount has been applied!','checkout/cart');

			$this->redirect($this->url->link('checkout/cart'));
		}

		// Shipping
		if (isset($this->request->post['shipping_method']) && $this->validateShipping()) {
			$shipping = explode('.', $this->request->post['shipping_method']);
				
			$this->session->data['shipping_method'] = $this->session->data['shipping_methods'][$shipping[0]]['quote'][$shipping[1]];
				
			$this->session->data['success'] = __('Success: Your shipping estimate has been applied!','checkout/cart');
				
			$this->redirect($this->url->link('checkout/cart'));
		}

		$this->document->setTitle(__('Shopping Cart','checkout/cart'));
		$this->document->addScript('catalog/view/javascript/jquery/colorbox/jquery.colorbox-min.js');
		$this->document->addStyle('catalog/view/javascript/jquery/colorbox/colorbox.css');
			
		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
				'href' => $this->url->link('common/home'),
				'text' => __('text_home')
		);

		$this->data['breadcrumbs'][] = array(
				'href' => $this->url->link('checkout/cart'),
				'text' => __('Shopping Cart','checkout/cart')
		);
			
		if ($this->cart->hasProducts() || !empty($this->session->data['vouchers'])) {
			$points = $this->customer->getRewardPoints();
				
			$points_total = 0;
				
			foreach ($this->cart->getProducts() as $product) {
				if ($product['points']) {
					$points_total += $product['points'];
				}
			}

			$this->data['heading_title'] = __('Shopping Cart','checkout/cart');
				
			$this->data['text_next'] = __('What would you like to do next?','checkout/cart');
			$this->data['text_next_choice'] = __('Choose if you have a discount code or reward points you want to use or would like to estimate your delivery cost.','checkout/cart');
			$this->data['text_use_coupon'] = __('Use Coupon Code','checkout/cart');
			$this->data['text_use_voucher'] = __('Use Gift Voucher','checkout/cart');
			$this->data['text_use_reward'] = sprintf(__('Use Reward Points (Available %s)','checkout/cart'), $points);
			$this->data['text_shipping_estimate'] = __('Estimate Shipping &amp; Taxes','checkout/cart');
			$this->data['text_shipping_detail'] = __('Enter your destination to get a shipping estimate.','checkout/cart');
			$this->data['text_shipping_method'] = __('Please select the preferred shipping method to use on this order.','checkout/cart');
			$this->data['text_select'] = __('text_select');
			$this->data['text_none'] = __('text_none');

			$this->data['column_image'] = __('Image','checkout/cart');
			$this->data['column_name'] = __('Product Name','checkout/cart');
			$this->data['column_model'] = __('Model','checkout/cart');
			$this->data['column_quantity'] = __('Quantity','checkout/cart');
			$this->data['column_price'] = __('Unit Price','checkout/cart');
			$this->data['column_total'] = __('Total','checkout/cart');
				
			$this->data['entry_coupon'] = __('Enter your coupon here:','checkout/cart');
			$this->data['entry_voucher'] = __('Enter your gift voucher code here:','checkout/cart');
			$this->data['entry_reward'] = sprintf(__('Points to use (Max %s):','checkout/cart'), $points_total);
			$this->data['entry_country'] = __('Country:','checkout/cart');
			$this->data['entry_zone'] = __('Region / State:','checkout/cart');
			$this->data['entry_postcode'] = __('Post Code:','checkout/cart');

			$this->data['button_update'] = __('button_update');
			$this->data['button_remove'] = __('button_remove');
			$this->data['button_coupon'] = __('button_coupon');
			$this->data['button_voucher'] = __('button_voucher');
			$this->data['button_reward'] = __('button_reward');
			$this->data['button_quote'] = __('button_quote');
			$this->data['button_shipping'] = __('button_shipping');
			$this->data['button_shopping'] = __('button_shopping');
			$this->data['button_checkout'] = __('button_checkout');
				
			if (isset($this->error['warning'])) {
				$this->data['error_warning'] = $this->error['warning'];
			} elseif (!$this->cart->hasStock() && (!$this->config->get('config_stock_checkout') || $this->config->get('config_stock_warning'))) {
				$this->data['error_warning'] = __('Products marked with *** are not available in the desired quantity or not in stock!','checkout/cart');
			} else {
				$this->data['error_warning'] = '';
			}
				
			if ($this->config->get('config_customer_price') && !$this->customer->isLogged()) {
				$this->data['attention'] = sprintf(__('Attention: You must <a href="%s">login</a> or <a href="%s">create an account</a> to view prices!','checkout/cart'), $this->url->link('account/login'), $this->url->link('account/register'));
			} else {
				$this->data['attention'] = '';
			}

			if (isset($this->session->data['success'])) {
				$this->data['success'] = $this->session->data['success'];
					
				unset($this->session->data['success']);
			} else {
				$this->data['success'] = '';
			}
				
			$this->data['action'] = $this->url->link('checkout/cart');

			if ($this->config->get('config_cart_weight')) {
				$this->data['weight'] = $this->weight->format($this->cart->getWeight(), $this->config->get('config_weight_class_id'), __('decimal_point'), __('thousand_point'));
			} else {
				$this->data['weight'] = '';
			}
				
			$this->load->model('tool/image');
				
			$this->data['products'] = array();
				
			$products = $this->cart->getProducts();

			foreach ($products as $product) {
				$product_total = 0;
					
				foreach ($products as $product_2) {
					if ($product_2['product_id'] == $product['product_id']) {
						$product_total += $product_2['quantity'];
					}
				}

				if ($product['minimum'] > $product_total) {
					$this->data['error_warning'] = sprintf(__('Minimum order amount for %s is %s!','checkout/cart'), $product['name'], $product['minimum']);
				}
					
				if ($product['image']) {
					$image = $this->model_tool_image->resize($product['image'], $this->config->get('config_image_cart_width'), $this->config->get('config_image_cart_height'));
				} else {
					$image = '';
				}

				$option_data = array();

				foreach ($product['option'] as $option) {
					if ($option['type'] != 'file') {
						$value = $option['value'];
					} else {
						$filename = $this->encryption->decrypt($option['value']);

						$value = utf8_substr($filename, 0, utf8_strrpos($filename, '.'));
					}
						
					$option_data[] = array(
							'name'  => $option['name'],
							'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value)
					);
				}

				// Display prices
				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$price = false;
				}

				// Display prices
				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$total = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')) * $product['quantity']);
				} else {
					$total = false;
				}

				$this->data['products'][] = array(
						'key'      => $product['key'],
						'thumb'    => $image,
						'name'     => $product['name'],
						'model'    => $product['model'],
						'option'   => $option_data,
						'quantity' => $product['quantity'],
						'stock'    => $product['stock'] ? true : !(!$this->config->get('config_stock_checkout') || $this->config->get('config_stock_warning')),
						'reward'   => ($product['reward'] ? sprintf(__('Reward Points: %s','checkout/cart'), $product['reward']) : ''),
						'price'    => $price,
						'total'    => $total,
						'href'     => $this->url->link('product/product', 'product_id=' . $product['product_id']),
						'remove'   => $this->url->link('checkout/cart', 'remove=' . $product['key'])
				);
			}
				
			// Gift Voucher
			$this->data['vouchers'] = array();
				
			if (!empty($this->session->data['vouchers'])) {
				foreach ($this->session->data['vouchers'] as $key => $voucher) {
					$this->data['vouchers'][] = array(
							'key'         => $key,
							'description' => $voucher['description'],
							'amount'      => $this->currency->format($voucher['amount']),
							'remove'      => $this->url->link('checkout/cart', 'remove=' . $key)
					);
				}
			}

			if (isset($this->request->post['next'])) {
				$this->data['next'] = $this->request->post['next'];
			} else {
				$this->data['next'] = '';
			}
				
			$this->data['coupon_status'] = $this->config->get('coupon_status');
				
			if (isset($this->request->post['coupon'])) {
				$this->data['coupon'] = $this->request->post['coupon'];
			} elseif (isset($this->session->data['coupon'])) {
				$this->data['coupon'] = $this->session->data['coupon'];
			} else {
				$this->data['coupon'] = '';
			}
				
			$this->data['voucher_status'] = $this->config->get('voucher_status');
				
			if (isset($this->request->post['voucher'])) {
				$this->data['voucher'] = $this->request->post['voucher'];
			} elseif (isset($this->session->data['voucher'])) {
				$this->data['voucher'] = $this->session->data['voucher'];
			} else {
				$this->data['voucher'] = '';
			}
				
			$this->data['reward_status'] = ($points && $points_total && $this->config->get('reward_status'));
				
			if (isset($this->request->post['reward'])) {
				$this->data['reward'] = $this->request->post['reward'];
			} elseif (isset($this->session->data['reward'])) {
				$this->data['reward'] = $this->session->data['reward'];
			} else {
				$this->data['reward'] = '';
			}

			$this->data['shipping_status'] = $this->config->get('shipping_status') && $this->config->get('shipping_estimator') && $this->cart->hasShipping();

			if (isset($this->request->post['country_id'])) {
				$this->data['country_id'] = $this->request->post['country_id'];
			} elseif (isset($this->session->data['shipping_address']['country_id'])) {
				$this->data['country_id'] = $this->session->data['shipping_address']['country_id'];
			} else {
				$this->data['country_id'] = $this->config->get('config_country_id');
			}

			$this->load->model('localisation/country');
				
			$this->data['countries'] = $this->model_localisation_country->getCountries();

			if (isset($this->request->post['zone_id'])) {
				$this->data['zone_id'] = $this->request->post['zone_id'];
			} elseif (isset($this->session->data['shipping_address']['zone_id'])) {
				$this->data['zone_id'] = $this->session->data['shipping_address']['zone_id'];
			} else {
				$this->data['zone_id'] = '';
			}
				
			if (isset($this->request->post['postcode'])) {
				$this->data['postcode'] = $this->request->post['postcode'];
			} elseif (isset($this->session->data['shipping_address']['postcode'])) {
				$this->data['postcode'] = $this->session->data['shipping_address']['postcode'];
			} else {
				$this->data['postcode'] = '';
			}
				
			if (isset($this->request->post['shipping_method'])) {
				$this->data['shipping_method'] = $this->request->post['shipping_method'];
			} elseif (isset($this->session->data['shipping_method'])) {
				$this->data['shipping_method'] = $this->session->data['shipping_method']['code'];
			} else {
				$this->data['shipping_method'] = '';
			}

			// Totals
			$this->load->model('setting/extension');
				
			$total_data = array();
			$total = 0;
			$taxes = $this->cart->getTaxes();
				
			// Display prices
			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$sort_order = array();

				$results = $this->model_setting_extension->getExtensions('total');

				foreach ($results as $key => $value) {
					$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
				}

				array_multisort($sort_order, SORT_ASC, $results);

				foreach ($results as $result) {
					if ($this->config->get($result['code'] . '_status')) {
						$this->load->model('total/' . $result['code']);
							
						$this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
					}
				}

				$sort_order = array();
					
				foreach ($total_data as $key => $value) {
					$sort_order[$key] = $value['sort_order'];
				}

				array_multisort($sort_order, SORT_ASC, $total_data);
			}
				
			$this->data['totals'] = $total_data;

			$this->data['continue'] = $this->url->link('common/home');

			$this->data['checkout'] = $this->url->link('checkout/checkout');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/cart.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/checkout/cart.tpl';
			} else {
				$this->template = 'default/template/checkout/cart.tpl';
			}
				
			$this->children = array(
					'common/column_left',
					'common/column_right',
					'common/content_bottom',
					'common/content_top',
					'common/footer',
					'common/header'
			);

			$this->response->setOutput($this->render());
		} else {
			$this->data['heading_title'] = __('Shopping Cart','checkout/cart');

			$this->data['text_error'] = __('Your shopping cart is empty!','checkout/cart');

			$this->data['button_continue'] = __('button_continue');
				
			$this->data['continue'] = $this->url->link('common/home');

			unset($this->session->data['success']);

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/error/not_found.tpl';
			} else {
				$this->template = 'default/template/error/not_found.tpl';
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

	protected function validateCoupon() {
		$this->load->model('checkout/coupon');

		$coupon_info = $this->model_checkout_coupon->getCoupon($this->request->post['coupon']);

		if (!$coupon_info) {
			$this->error['warning'] = __('Warning: Coupon is either invalid, expired or reached it\'s usage limit!','checkout/cart');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	protected function validateVoucher() {
		$this->load->model('checkout/voucher');

		$voucher_info = $this->model_checkout_voucher->getVoucher($this->request->post['voucher']);

		if (!$voucher_info) {
			$this->error['warning'] = __('Warning: Gift Voucher is either invalid or the balance has been used up!','checkout/cart');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	protected function validateReward() {
		$points = $this->customer->getRewardPoints();

		$points_total = 0;

		foreach ($this->cart->getProducts() as $product) {
			if ($product['points']) {
				$points_total += $product['points'];
			}
		}

		if (empty($this->request->post['reward'])) {
			$this->error['warning'] = __('Warning: Please enter the amount of reward points to use!','checkout/cart');
		}

		if ($this->request->post['reward'] > $points) {
			$this->error['warning'] = sprintf(__('Warning: You don\'t have %s reward points!','checkout/cart'), $this->request->post['reward']);
		}

		if ($this->request->post['reward'] > $points_total) {
			$this->error['warning'] = sprintf(__('Warning: The maximum number of points that can be applied is %s!','checkout/cart'), $points_total);
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	protected function validateShipping() {
		if (!empty($this->request->post['shipping_method'])) {
			$shipping = explode('.', $this->request->post['shipping_method']);
				
			if (!isset($shipping[0]) || !isset($shipping[1]) || !isset($this->session->data['shipping_methods'][$shipping[0]]['quote'][$shipping[1]])) {
				$this->error['warning'] = __('Warning: Shipping method required!','checkout/cart');
			}
		} else {
			$this->error['warning'] = __('Warning: Shipping method required!','checkout/cart');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	public function add() {
		$this->language->load('checkout/cart');

		$json = array();

		if (isset($this->request->post['product_id'])) {
			$product_id = $this->request->post['product_id'];
		} else {
			$product_id = 0;
		}

		$this->load->model('catalog/product');

		$product_info = $this->model_catalog_product->getProduct($product_id);

		if ($product_info) {
			if (isset($this->request->post['quantity'])) {
				$quantity = $this->request->post['quantity'];
			} else {
				$quantity = 1;
			}

			if (isset($this->request->post['option'])) {
				$option = array_filter($this->request->post['option']);
			} else {
				$option = array();
			}
				
			$product_options = $this->model_catalog_product->getProductOptions($this->request->post['product_id']);
				
			foreach ($product_options as $product_option) {
				if ($product_option['required'] && empty($option[$product_option['product_option_id']])) {
					$json['error']['option'][$product_option['product_option_id']] = sprintf(__('%s required!','checkout/cart'), $product_option['name']);
				}
			}
				
			if (!$json) {
				$this->cart->add($this->request->post['product_id'], $quantity, $option);

				$json['success'] = sprintf(__('Success: You have added <a href="%s">%s</a> to your <a href="%s">shopping cart</a>!','checkout/cart'), $this->url->link('product/product', 'product_id=' . $this->request->post['product_id']), $product_info['name'], $this->url->link('checkout/cart'));

				unset($this->session->data['shipping_method']);
				unset($this->session->data['shipping_methods']);
				unset($this->session->data['payment_method']);
				unset($this->session->data['payment_methods']);

				// Totals
				$this->load->model('setting/extension');

				$total_data = array();
				$total = 0;
				$taxes = $this->cart->getTaxes();

				// Display prices
				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$sort_order = array();
						
					$results = $this->model_setting_extension->getExtensions('total');
						
					foreach ($results as $key => $value) {
						$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
					}
						
					array_multisort($sort_order, SORT_ASC, $results);
						
					foreach ($results as $result) {
						if ($this->config->get($result['code'] . '_status')) {
							$this->load->model('total/' . $result['code']);

							$this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
						}
					}
						
					$sort_order = array();

					foreach ($total_data as $key => $value) {
						$sort_order[$key] = $value['sort_order'];
					}

					array_multisort($sort_order, SORT_ASC, $total_data);
				}

				$json['total'] = sprintf(__('%s item(s) - %s','checkout/cart'), $this->cart->countProducts() + (isset($this->session->data['vouchers']) ? count($this->session->data['vouchers']) : 0), $this->currency->format($total));
			} else {
				$json['redirect'] = str_replace('&amp;', '&', $this->url->link('product/product', 'product_id=' . $this->request->post['product_id']));
			}
		}

		$this->response->setOutput(json_encode($json));
	}

	public function quote() {
		$this->language->load('checkout/cart');

		$json = array();

		if (!$this->cart->hasProducts()) {
			$json['error']['warning'] = __('Warning: There are no products in your cart!','checkout/cart');
		}

		if (!$this->cart->hasShipping()) {
			$json['error']['warning'] = sprintf(__('Warning: No Shipping options are available. Please <a href="%s">contact us</a> for assistance!','checkout/cart'), $this->url->link('information/contact'));
		}

		if ($this->request->post['country_id'] == '') {
			$json['error']['country'] = __('Please select a country!','checkout/cart');
		}

		if (!isset($this->request->post['zone_id']) || $this->request->post['zone_id'] == '') {
			$json['error']['zone'] = __('Please select a region / state!','checkout/cart');
		}
			
		$this->load->model('localisation/country');

		$country_info = $this->model_localisation_country->getCountry($this->request->post['country_id']);

		if ($country_info && $country_info['postcode_required'] && (utf8_strlen($this->request->post['postcode']) < 2) || (utf8_strlen($this->request->post['postcode']) > 10)) {
			$json['error']['postcode'] = __('Postcode must be between 2 and 10 characters!','checkout/cart');
		}

		if (!$json) {
			$this->tax->setShippingAddress($this->request->post['country_id'], $this->request->post['zone_id']);

			if ($country_info) {
				$country = $country_info['name'];
				$iso_code_2 = $country_info['iso_code_2'];
				$iso_code_3 = $country_info['iso_code_3'];
				$address_format = $country_info['address_format'];
			} else {
				$country = '';
				$iso_code_2 = '';
				$iso_code_3 = '';
				$address_format = '';
			}
				
			$this->load->model('localisation/zone');

			$zone_info = $this->model_localisation_zone->getZone($this->request->post['zone_id']);
				
			if ($zone_info) {
				$zone = $zone_info['name'];
				$zone_code = $zone_info['code'];
			} else {
				$zone = '';
				$zone_code = '';
			}
				
			$this->session->data['shipping_address'] = array(
					'firstname'      => '',
					'lastname'       => '',
					'company'        => '',
					'address_1'      => '',
					'address_2'      => '',
					'postcode'       => $this->request->post['postcode'],
					'city'           => '',
					'zone_id'        => $this->request->post['zone_id'],
					'zone'           => $zone,
					'zone_code'      => $zone_code,
					'country_id'     => $this->request->post['country_id'],
					'country'        => $country,
					'iso_code_2'     => $iso_code_2,
					'iso_code_3'     => $iso_code_3,
					'address_format' => $address_format
			);

			$quote_data = array();
				
			$this->load->model('setting/extension');
				
			$results = $this->model_setting_extension->getExtensions('shipping');
				
			foreach ($results as $result) {
				if ($this->config->get($result['code'] . '_status')) {
					$this->load->model('shipping/' . $result['code']);
						
					$quote = $this->{'model_shipping_' . $result['code']}->getQuote($this->session->data['shipping_address']);

					if ($quote) {
						$quote_data[$result['code']] = array(
								'title'      => $quote['title'],
								'quote'      => $quote['quote'],
								'sort_order' => $quote['sort_order'],
								'error'      => $quote['error']
						);
					}
				}
			}

			$sort_order = array();

			foreach ($quote_data as $key => $value) {
				$sort_order[$key] = $value['sort_order'];
			}

			array_multisort($sort_order, SORT_ASC, $quote_data);
				
			$this->session->data['shipping_methods'] = $quote_data;
				
			if ($this->session->data['shipping_methods']) {
				$json['shipping_method'] = $this->session->data['shipping_methods'];
			} else {
				$json['error']['warning'] = sprintf(__('Warning: No Shipping options are available. Please <a href="%s">contact us</a> for assistance!','checkout/cart'), $this->url->link('information/contact'));
			}
		}

		$this->response->setOutput(json_encode($json));
	}

	public function country() {
		$json = array();

		$this->load->model('localisation/country');

		$country_info = $this->model_localisation_country->getCountry($this->request->get['country_id']);

		if ($country_info) {
			$this->load->model('localisation/zone');

			$json = array(
					'country_id'        => $country_info['country_id'],
					'name'              => $country_info['name'],
					'iso_code_2'        => $country_info['iso_code_2'],
					'iso_code_3'        => $country_info['iso_code_3'],
					'address_format'    => $country_info['address_format'],
					'postcode_required' => $country_info['postcode_required'],
					'zone'              => $this->model_localisation_zone->getZonesByCountryId($this->request->get['country_id']),
					'status'            => $country_info['status']
			);
		}

		$this->response->setOutput(json_encode($json));
	}
}
?>