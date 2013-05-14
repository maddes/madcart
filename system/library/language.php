<?php

function __ ($key, $domain = false) {
	if ($domain) Language::$default->load($domain);
	return Language::$default->get($key);
}

function _e ($key, $domain) {
	echo __($key, $domain);
}

class Language {
	private $directory;
	private $data = array();
	private $loaded = array();
	public static $default;

	public function __construct($directory) {
		$this->directory = $directory;
	}

	public function get($key) {
		return (isset($this->data[$key]) ? $this->data[$key] : $key);
	}

	public function load($filename) {
		if (in_array($filename,$this->loaded)) return $this->data;
		
		$file = DIR_LANGUAGE . $this->directory . '/' . $filename . '.php';

		if (file_exists($file)) {
			$_ = array();

			require($file);

			$this->data = array_merge($this->data, $_);

			return $this->data;
		} else {
			trigger_error('Error: Could not load language ' . $filename . '!');
		}
	}
	
	public function setAsDefault() {
		Language::$default = $this;
	}
}
?>
