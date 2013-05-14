<?php    
class ControllerErrorNotFound extends Controller {
	public function index() {
		$this->language->load('error/not_found');

		$this->document->setTitle(__('heading_title'));

		$this->data['heading_title'] = __('heading_title');

		$this->data['text_not_found'] = __('text_not_found');

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
				'text' => __('text_home'),
				'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL')
		);

		$this->data['breadcrumbs'][] = array(
				'text' => __('heading_title'),
				'href' => $this->url->link('error/not_found', 'token=' . $this->session->data['token'], 'SSL')
		);

		$this->template = 'error/not_found.tpl';
		$this->children = array(
				'common/header',
				'common/footer'
		);

		$this->response->setOutput($this->render());
	}
}
?>