<?php 
class ControllerInformationInformation extends Controller {
	public function index() {
		$this->language->load('information/information');

		$this->load->model('catalog/information');

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
				'text' => __('text_home'),
				'href' => $this->url->link('common/home')
		);

		if (isset($this->request->get['information_id'])) {
			$information_id = (int)$this->request->get['information_id'];
		} else {
			$information_id = 0;
		}

		$information_info = $this->model_catalog_information->getInformation($information_id);
		 
		if ($information_info) {
			$this->document->setTitle($information_info['title']);

			$this->data['breadcrumbs'][] = array(
					'text'      => $information_info['title'],
					'href' => $this->url->link('information/information', 'information_id=' .  $information_id)
			);

			$this->data['heading_title'] = $information_info['title'];

			$this->data['button_continue'] = __('button_continue');
				
			$this->data['description'] = html_entity_decode($information_info['description'], ENT_QUOTES, 'UTF-8');

			$this->data['continue'] = $this->url->link('common/home');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/information.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/information/information.tpl';
			} else {
				$this->template = 'default/template/information/information.tpl';
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
		} else {
			$this->data['breadcrumbs'][] = array(
					'text' => __('Information Page Not Found!','information/information'),
					'href' => $this->url->link('information/information', 'information_id=' . $information_id)
			);

			$this->document->setTitle(__('Information Page Not Found!','information/information'));
				
			$this->data['heading_title'] = __('Information Page Not Found!','information/information');

			$this->data['text_error'] = __('Information Page Not Found!','information/information');

			$this->data['button_continue'] = __('button_continue');

			$this->data['continue'] = $this->url->link('common/home');

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

	public function info() {
		$this->load->model('catalog/information');

		if (isset($this->request->get['information_id'])) {
			$information_id = (int)$this->request->get['information_id'];
		} else {
			$information_id = 0;
		}

		$information_info = $this->model_catalog_information->getInformation($information_id);

		if ($information_info) {
			$output  = '<html dir="ltr" lang="en">' . "\n";
			$output .= '<head>' . "\n";
			$output .= '  <title>' . $information_info['title'] . '</title>' . "\n";
			$output .= '  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">' . "\n";
			$output .= '  <meta name="robots" content="noindex">' . "\n";
			$output .= '</head>' . "\n";
			$output .= '<body>' . "\n";
			$output .= '  <h1>' . $information_info['title'] . '</h1>' . "\n";
			$output .= html_entity_decode($information_info['description'], ENT_QUOTES, 'UTF-8') . "\n";
			$output .= '  </body>' . "\n";
			$output .= '</html>' . "\n";

			$this->response->setOutput($output);
		}
	}
}
?>