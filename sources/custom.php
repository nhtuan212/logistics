<?php
	if(!defined('SOURCE')) die("Error");
	// foreach ($category_group as $i => $category_item)
	// {
	// 	$custom_category[$category_item['type']][] = $category_item;
	// 	$level_category[$category_item['type']][$category_item['level']][] = $category_item;
	// 	if (strpos($category_item['status'], 'hot') !== false) $hot_category[$category_item['type']][] = $category_item;
	// }
	foreach ($product_group as $i => $product_item)
	{
		$custom_product[$product_item['type']][] = $product_item;
		if(strpos($product_item['status'], 'hot') !== false) $hot_product[$product_item['type']][] = $product_item;
	}
	foreach ($post_group as $i => $post_item)
	{
		$custom_post[$post_item['type']][] = $post_item;
		if(strpos($post_item['status'], 'hot') !== false) $hot_post[$post_item['type']][] = $post_item;
	}
	foreach ($photo_multi as $i => $multi_item)
	{
		$slider[$multi_item['type']][] = $multi_item;
		if ((strpos($multi_item['status'], 'display') !== false)) $display_slider[$multi_item['type']]['status'] = $multi_item['status'];
	}
	foreach ($static_group as $i => $static_item) $static[$static_item['type']] = $static_item;
?>