<?php if(!defined('LIB')) die("Error");
	class ValidateURL
	{
		public function __construct($http, $config_url_http){
			$this->http = $http;
			$this->config_url_http = $config_url_http;
		}
		public function setUrl($str)
		{
			$this->setUrl = $this->config_url_http.$str.",";
		}
		public function resultURL()
		{
			if(in_array($this->getLink(), $this->getUrl())) redirect($this->config_url_http);
		}
		private function getUrl()
		{
			$result = explode(",", rtrim($this->setUrl, ","));
			return $result;
		}
		private function getLink()
		{
			$result = $this->http.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			$result = str_replace("&", "&amp", $result);
			return $result;
		}
	}
?>