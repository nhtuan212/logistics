<?php
	header("Content-Type: application/xml; charset=utf-8");
	echo '<?xml version="1.0" encoding="UTF-8"?>';
	echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';

	echo "<url>";
	echo "<loc>".$config_url_http."</loc>";
	echo "<changefreq>daily</changefreq>";
	echo "<lastmod>".date('c',time())."</lastmod>";
	echo "<priority>1</priority>";
	echo "</url>";

	for($i=0; $i < count(@$arr_sitemap); $i++) {
		if(!empty($arr_sitemap[$i]['com'])) CreateXML_Com($arr_sitemap[$i]['com']);
		if(isset($arr_sitemap[$i]['type'])) CreateXML($arr_sitemap[$i]['tbl'],$arr_sitemap[$i]['type'],$arr_sitemap[$i]['level']);
	}

	echo '</urlset>';
?>