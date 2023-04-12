<?php
	class Seo{
		private $db;
		public function __construct($db){
			$this->db = @$db;
		}
		private function Push($data)
		{
			global $config_url_http, $com;
			$seo = $this->db->rawQueryOne("select id, photo, title, keywords, description from #_seo where type=? and level=?", array($data['type'], $data['level']));
			$data['photo'] = (!empty($seo['photo'])) ? $config_url_http.CACHE.'300x200x2/'.UPLOAD_PHOTO_L.$seo['photo'] : $data['photo'];
			$this->path = ($data['photo']) ? getimagesize($data['photo']) : '';

			$data = array_merge(
				$data, array(
					"mime" => ($data['photo']) ? $this->path['mime'] : '',
					"width" => ($data['photo']) ? $this->path[0] : '',
					"height" => ($data['photo']) ? $this->path[1] : '',
					"title" => $seo['title'],
					"keywords" => $seo['keywords'],
					"description" => $seo['description'],
					"url" => $config_url_http.$com,
				)
			);
			return $data;
		}
		public function Set($data)
		{
			foreach($this->Push($data) as $key => $value) $this->data[$key] = $value;
		}
		public function Get($key)
		{
			@$result = $this->data[$key];
			return $result;
		}
	}
?>