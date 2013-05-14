<?php   
class ControllerErrorNotFound extends Controller {
	public function index() {		
		$this->language->load('error/not_found');
		
		$this->document->setTitle(__('heading_title'));
		
		$this->data['breadcrumbs'] = array();
 
      	$this->data['breadcrumbs'][] = array(
        	'text' => __('text_home'),
			'href' => $this->url->link('common/home')
      	);		
		
		if (isset($this->request->get['route'])) {
			$data = $this->request->get;
			
			unset($data['_route_']);
			
			$route = $data['route'];
			
			unset($data['route']);
			
			$url = '';
			
			if ($data) {
				$url = '&' . urldecode(http_build_query($data, '', '&'));
			}	
			
			if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
				$connection = 'SSL';
			} else {
				$connection = 'NONSSL';
			}
											
       		$this->data['breadcrumbs'][] = array(
				'text' => __('heading_title'),
				'href' => $this->url->link($route, $url, $connection)
      		);	   	
		}
		
		$this->data['heading_title'] = __('heading_title');
		
		$this->data['text_error'] = __('text_error');
		
		$this->data['button_continue'] = __('button_continue');
		
		$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . '/1.1 404 Not Found');
		
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
?>