<?php  
class ControllerCommonFooter extends Controller {
	protected function index() {
		$this->language->load('common/footer');

		$this->data['text_information'] = __('Information','common/footer');
		$this->data['text_service'] = __('Customer Service','common/footer');
		$this->data['text_extra'] = __('Extras','common/footer');
		$this->data['text_contact'] = __('Contact Us','common/footer');
		$this->data['text_return'] = __('Returns','common/footer');
		$this->data['text_sitemap'] = __('Site Map','common/footer');
		$this->data['text_manufacturer'] = __('Brands','common/footer');
		$this->data['text_voucher'] = __('Gift Vouchers','common/footer');
		$this->data['text_affiliate'] = __('Affiliates','common/footer');
		$this->data['text_special'] = __('Specials','common/footer');
		$this->data['text_account'] = __('My Account','common/footer');
		$this->data['text_order'] = __('Order History','common/footer');
		$this->data['text_wishlist'] = __('Wish List','common/footer');
		$this->data['text_newsletter'] = __('Newsletter','common/footer');

		$this->load->model('catalog/information');

		$this->data['informations'] = array();

		foreach ($this->model_catalog_information->getInformations() as $result) {
			if ($result['bottom']) {
				$this->data['informations'][] = array(
						'title' => $result['title'],
						'href'  => $this->url->link('information/information', 'information_id=' . $result['information_id'])
				);
			}
		}

		$this->data['contact'] = $this->url->link('information/contact');
		$this->data['return'] = $this->url->link('account/return/insert', '', 'SSL');
		$this->data['sitemap'] = $this->url->link('information/sitemap');
		$this->data['manufacturer'] = $this->url->link('product/manufacturer');
		$this->data['voucher'] = $this->url->link('account/voucher', '', 'SSL');
		$this->data['affiliate'] = $this->url->link('affiliate/account', '', 'SSL');
		$this->data['special'] = $this->url->link('product/special');
		$this->data['account'] = $this->url->link('account/account', '', 'SSL');
		$this->data['order'] = $this->url->link('account/order', '', 'SSL');
		$this->data['wishlist'] = $this->url->link('account/wishlist', '', 'SSL');
		$this->data['newsletter'] = $this->url->link('account/newsletter', '', 'SSL');

		$this->data['powered'] = sprintf(__('Powered By <a href="http://www.opencart.com">OpenCart</a><br /> %s &copy; %s','common/footer'), $this->config->get('config_name'), date('Y', time()));

		// Whos Online
		if ($this->config->get('config_customer_online')) {
			$this->load->model('tool/online');

			if (isset($this->request->server['REMOTE_ADDR'])) {
				$ip = $this->request->server['REMOTE_ADDR'];
			} else {
				$ip = '';
			}
				
			if (isset($this->request->server['HTTP_HOST']) && isset($this->request->server['REQUEST_URI'])) {
				$url = 'http://' . $this->request->server['HTTP_HOST'] . $this->request->server['REQUEST_URI'];
			} else {
				$url = '';
			}
				
			if (isset($this->request->server['HTTP_REFERER'])) {
				$referer = $this->request->server['HTTP_REFERER'];
			} else {
				$referer = '';
			}

			$this->model_tool_online->whosonline($ip, $this->customer->getId(), $url, $referer);
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/footer.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/common/footer.tpl';
		} else {
			$this->template = 'default/template/common/footer.tpl';
		}

		$this->render();
	}
}
?>