<?php
class ControllerPaymentKlarnaInvoice extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('payment/klarna_invoice');

		$this->document->setTitle(__('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$status = false;
				
			foreach ($this->request->post['klarna_invoice'] as $klarna_invoice) {
				if ($klarna_invoice['status']) {
					$status = true;
						
					break;
				}
			}
				
			$data = array(
					'klarna_invoice_pclasses' => $this->pclasses,
					'klarna_invoice_status'   => $status
			);
				
			$this->model_setting_setting->editSetting('klarna_invoice', array_merge($this->request->post, $data));
				
			$this->session->data['success'] = __('text_success');

			$this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->data['heading_title'] = __('heading_title');

		$this->data['text_enabled'] = __('text_enabled');
		$this->data['text_disabled'] = __('text_disabled');
		$this->data['text_all_zones'] = __('text_all_zones');
		$this->data['text_live'] = __('text_live');
		$this->data['text_beta'] = __('text_beta');
		$this->data['text_sweden'] = __('text_sweden');
		$this->data['text_norway'] = __('text_norway');
		$this->data['text_finland'] = __('text_finland');
		$this->data['text_denmark'] = __('text_denmark');
		$this->data['text_germany'] = __('text_germany');
		$this->data['text_netherlands'] = __('text_netherlands');

		$this->data['entry_merchant'] = __('entry_merchant');
		$this->data['entry_secret'] = __('entry_secret');
		$this->data['entry_server'] = __('entry_server');
		$this->data['entry_total'] = __('entry_total');
		$this->data['entry_pending_status'] = __('entry_pending_status');
		$this->data['entry_accepted_status'] = __('entry_accepted_status');
		$this->data['entry_geo_zone'] = __('entry_geo_zone');
		$this->data['entry_status'] = __('entry_status');
		$this->data['entry_sort_order'] = __('entry_sort_order');

		$this->data['help_merchant'] = __('help_merchant');
		$this->data['help_secret'] = __('help_secret');
		$this->data['help_total'] = __('help_total');

		$this->data['button_save'] = __('button_save');
		$this->data['button_cancel'] = __('button_cancel');
		$this->data['button_clear'] = __('button_clear');

		$this->data['tab_general'] = __('tab_general');
		$this->data['tab_log'] = __('tab_log');
		 
		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
				'text' => __('text_home'),
				'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL')
		);

		$this->data['breadcrumbs'][] = array(
				'text' => __('text_payment'),
				'href' => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL')
		);

		$this->data['breadcrumbs'][] = array(
				'text' => __('heading_title'),
				'href' => $this->url->link('payment/klarna_invoice', 'token=' . $this->session->data['token'], 'SSL')
		);

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$this->data['action'] = $this->url->link('payment/klarna_invoice', 'token=' . $this->session->data['token'], 'SSL');
		 
		$this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['countries'] = array();

		$this->data['countries'][] = array(
				'name' => __('text_germany'),
				'code' => 'DEU'
		);

		$this->data['countries'][] = array(
				'name' => __('text_netherlands'),
				'code' => 'NLD'
		);

		$this->data['countries'][] = array(
				'name' => __('text_denmark'),
				'code' => 'DNK'
		);

		$this->data['countries'][] = array(
				'name' => __('text_sweden'),
				'code' => 'SWE'
		);

		$this->data['countries'][] = array(
				'name' => __('text_norway'),
				'code' => 'NOR'
		);

		$this->data['countries'][] = array(
				'name' => __('text_finland'),
				'code' => 'FIN'
		);

		if (isset($this->request->post['klarna_invoice'])) {
			$this->data['klarna_invoice'] = $this->request->post['klarna_invoice'];
		} else {
			$this->data['klarna_invoice'] = $this->config->get('klarna_invoice');
		}

		$this->load->model('localisation/geo_zone');
			
		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		$this->load->model('localisation/order_status');
			
		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		$file = DIR_LOGS . 'klarna_invoice.log';

		if (file_exists($file)) {
			$this->data['log'] = file_get_contents($file, FILE_USE_INCLUDE_PATH, null);
		} else {
			$this->data['log'] = '';
		}

		$this->data['clear'] = $this->url->link('payment/klarna_invoice/clear', 'token=' . $this->session->data['token'], 'SSL');

		$this->template = 'payment/klarna_invoice.tpl';
		$this->children = array(
				'common/header',
				'common/footer',
		);

		$this->response->setOutput($this->render());
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'payment/klarna_invoice')) {
			$this->error['warning'] = __('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	private function parseResponse($node, $document) {
		$child = $node;

		switch ($child->nodeName) {
			case 'string':
				$value = $child->nodeValue;
				break;

			case 'boolean':
				$value = (string) $child->nodeValue;

				if ($value == '0') {
					$value = false;
				} elseif ($value == '1') {
					$value = true;
				} else {
					$value = null;
				}

				break;

			case 'integer':
			case 'int':
			case 'i4':
			case 'i8':
				$value = (int) $child->nodeValue;
				break;

			case 'array':
				$value = array();

				$xpath = new DOMXPath($document);
				$entries = $xpath->query('.//array/data/value', $child);

				for ($i = 0; $i < $entries->length; $i++) {
					$value[] = $this->parseResponse($entries->item($i)->firstChild, $document);
				}

				break;

			default:
				$value = null;
		}

		return $value;
	}

	public function clear() {
		$this->language->load('payment/klarna_invoice');

		$file = DIR_LOGS . 'klarna_invoice.log';

		$handle = fopen($file, 'w+');

		fclose($handle);

		$this->session->data['success'] = __('text_success');

		$this->redirect($this->url->link('payment/klarna_invoice', 'token=' . $this->session->data['token'], 'SSL'));
	}
}
?>