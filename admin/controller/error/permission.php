<?php    
class ControllerErrorPermission extends Controller {
	public function index() {
		$this->language->load('error/permission');

		$this->document->setTitle(__('heading_title'));

		$this->data['heading_title'] = __('heading_title');

		$this->data['text_permission'] = __('text_permission');
			
		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
				'text' => __('text_home'),
				'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL')
		);

		$this->data['breadcrumbs'][] = array(
				'text' => __('heading_title'),
				'href' => $this->url->link('error/permission', 'token=' . $this->session->data['token'], 'SSL')
		);

		$this->template = 'error/permission.tpl';
		$this->children = array(
				'common/header',
				'common/footer'
		);

		$this->response->setOutput($this->render());
	}
}
?>