<?php
class BreadCrumbs{
	private $db;
	public function __construct($db){
		$this->db = @$db;
	}
	public function setPage($com, $title, $tbl, $type, $levelCur=0)
	{
		$this->com = $com;
		$this->title = $title;
		$this->tbl = $tbl;
		$this->type = $type;
		$this->levelCur = $levelCur;
	}
	private function getThemes($href, $title)
	{
		if($href) $link = 'href="'.$href.'"';
		@$breadcumb .='
		<li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
			<a itemprop="item" '.$link.'>
				<span itemprop="name">'.$title.'</span>
			</a>
			<meta itemprop="position" content="1" />
		</li>';
		return $breadcumb;
	}
	private function getThemesList()
	{
		global $com, $lang, $func;
		$breadcumb = "";
		if(isset($this->levelCur)) {
			@$row_category = $this->db->rawQueryOne("select *, name$lang as name FROM #_category where ".$func->findInSet('display', 'status')." and tenkhongdau='".$com."'");
			@$row_detail = $this->db->rawQueryOne("select *, name$lang as name FROM #_".$this->tbl." where ".$func->findInSet('display', 'status')." and tenkhongdau='".$com."'");

			for($i=0; $i < $this->levelCur; $i++) {
				($row_detail || (($i+1) < $this->levelCur)) ? $ext = "_lv".($i+1) : $ext = "";
				if($row_category) $attrID = $row_category['id'.$ext];
				if($row_detail) $attrID = $row_detail['id'.$ext];
				if($attrID > 0)
				{
					$whereIN = " and id IN(select id FROM #_category where id='".$attrID."' and level='".($i+1)."')";
					$level_arr = $this->db->rawQueryOne("select name$lang as name, tenkhongdau FROM #_category where level='".($i+1)."' and type='".$this->type."' $whereIN and ".$func->findInSet('display', 'status')."");
					$breadcumb .= $this->getThemes($level_arr['tenkhongdau'], $level_arr['name']);
				}
			}
			if($row_detail) $breadcumb .= $this->getThemes($row_detail['tenkhongdau'], $row_detail['name']);
			return $breadcumb;
		}
	}
	public function getBreadcrumbs()
	{
		global $config_url_http;

		$breadcumb = '<ol class="d-flex flex-wrap" itemscope itemtype="http://schema.org/BreadcrumbList">';
		$breadcumb .= $this->getThemes($config_url_http, _trangchu);
		$breadcumb .= $this->getThemes($this->com, $this->title);
		$breadcumb .= $this->getThemesList();
		$breadcumb .='</ol>';
		return $this->Minify_Html($breadcumb);
	}
	static function Minify_Html($Html){
		$Search = array(
			'/(\n|^)(\x20+|\t)/',
			'/(\n|^)\/\/(.*?)(\n|$)/',
			'/\n/',
			'/\<\!--.*?-->/',
			'/(\x20+|\t)/',
			'/\>\s+\</',
			'/(\"|\')\s+\>/',
			'/=\s+(\"|\')/'
		);

		$Replace = array(
			"\n",
			"\n",
			" ",
			"",
			" ",
			"><",
			"$1>",
			"=$1"
		);
		$Html = preg_replace($Search,$Replace,$Html);
		return $Html;
	}
}
?>