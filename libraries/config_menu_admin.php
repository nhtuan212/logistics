<?php if (!defined('LIB')) die("Error");
$type_menu = 'logo';
$config['photo_static'][$type_menu]['title'] = 'Logo';
$config['photo_static'][$type_menu]['photo'] = true;
$config['photo_static'][$type_menu]['photo_width'] = 100;
$config['photo_static'][$type_menu]['photo_height'] = 100;
$config['photo_static'][$type_menu]['photo_type'] = FORMAT_IMAGE;
$config['photo_static'][$type_menu]['link'] = false;
$config['photo_static'][$type_menu]['attr'] = array("display" => "Hiển thị");
$config['photo_static'][$type_menu]['text'] = array();

$type_menu = 'banner';
$config['photo_static'][$type_menu]['title'] = 'Banner';
$config['photo_static'][$type_menu]['photo'] = true;
$config['photo_static'][$type_menu]['photo_width'] = 300;
$config['photo_static'][$type_menu]['photo_height'] = 100;
$config['photo_static'][$type_menu]['photo_type'] = FORMAT_IMAGE;
$config['photo_static'][$type_menu]['link'] = false;
$config['photo_static'][$type_menu]['attr'] = array("display" => "Hiển thị");
$config['photo_static'][$type_menu]['text'] = array();

// $type_menu = 'bg-header';
// $config['photo_static'][$type_menu]['title'] = 'Background Header';
// $config['photo_static'][$type_menu]['photo'] = true;
// $config['photo_static'][$type_menu]['photo_width'] = 1366;
// $config['photo_static'][$type_menu]['photo_height'] = 200;
// $config['photo_static'][$type_menu]['photo_type'] = FORMAT_IMAGE;
// $config['photo_static'][$type_menu]['link'] = false;
// $config['photo_static'][$type_menu]['attr'] = array("display"=>"Hiển thị");
// $config['photo_static'][$type_menu]['text'] = array();

$type_menu = 'moit';
$config['photo_static'][$type_menu]['title'] = 'Bộ công thương';
$config['photo_static'][$type_menu]['photo'] = true;
$config['photo_static'][$type_menu]['photo_width'] = 160;
$config['photo_static'][$type_menu]['photo_height'] = 60;
$config['photo_static'][$type_menu]['photo_type'] = FORMAT_IMAGE;
$config['photo_static'][$type_menu]['link'] = true;
$config['photo_static'][$type_menu]['attr'] = array("display" => "Hiển thị");
$config['photo_static'][$type_menu]['text'] = array();

// $type_menu = 'watermark';
// $config['photo_static'][$type_menu]['title'] = 'Đóng dấu';
// $config['photo_static'][$type_menu]['photo'] = true;
// $config['photo_static'][$type_menu]['photo_width'] = 120;
// $config['photo_static'][$type_menu]['photo_height'] = 50;
// $config['photo_static'][$type_menu]['photo_type'] = FORMAT_IMAGE;
// $config['photo_static'][$type_menu]['watermark'] = true;
// $config['photo_static'][$type_menu]['link'] = false;
// $config['photo_static'][$type_menu]['attr'] = array("display"=>"Hiển thị");
// $config['photo_static'][$type_menu]['text'] = array();

$type_menu = 'slider';
$config['photo_multi'][$type_menu]['title'] = 'Slider';
$config['photo_multi'][$type_menu]['count'] = 4;
$config['photo_multi'][$type_menu]['photo'] = true;
$config['photo_multi'][$type_menu]['photo_width'] = 1366;
$config['photo_multi'][$type_menu]['photo_height'] = 500;
$config['photo_multi'][$type_menu]['photo_type'] = FORMAT_IMAGE;
$config['photo_multi'][$type_menu]['link'] = true;
$config['photo_multi'][$type_menu]['video'] = false;
$config['photo_multi'][$type_menu]['attr'] = array("display" => "Hiển thị");
$config['photo_multi'][$type_menu]['text'] = array();

$type_menu = 'social';
$config['photo_multi'][$type_menu]['title'] = 'Mạng xã hội';
$config['photo_multi'][$type_menu]['count'] = 4;
$config['photo_multi'][$type_menu]['photo'] = true;
$config['photo_multi'][$type_menu]['photo_width'] = 35;
$config['photo_multi'][$type_menu]['photo_height'] = 35;
$config['photo_multi'][$type_menu]['photo_type'] = FORMAT_IMAGE;
$config['photo_multi'][$type_menu]['link'] = true;
$config['photo_multi'][$type_menu]['video'] = false;
$config['photo_multi'][$type_menu]['attr'] = array("display" => "Hiển thị");
$config['photo_multi'][$type_menu]['text'] = array();

$type_menu = 'partner';
$config['photo_multi'][$type_menu]['title'] = 'Đối tác';
$config['photo_multi'][$type_menu]['count'] = 4;
$config['photo_multi'][$type_menu]['photo'] = true;
$config['photo_multi'][$type_menu]['photo_width'] = 250;
$config['photo_multi'][$type_menu]['photo_height'] = 150;
$config['photo_multi'][$type_menu]['photo_type'] = FORMAT_IMAGE;
$config['photo_multi'][$type_menu]['link'] = true;
$config['photo_multi'][$type_menu]['video'] = false;
$config['photo_multi'][$type_menu]['attr'] = array("display" => "Hiển thị");
$config['photo_multi'][$type_menu]['text'] = array();

$type_menu = 'video';
$config['photo_multi'][$type_menu]['title'] = 'Video';
$config['photo_multi'][$type_menu]['count'] = 4;
$config['photo_multi'][$type_menu]['photo'] = false;
$config['photo_multi'][$type_menu]['photo_width'] = 1366;
$config['photo_multi'][$type_menu]['photo_height'] = 500;
$config['photo_multi'][$type_menu]['photo_type'] = FORMAT_IMAGE;
$config['photo_multi'][$type_menu]['link'] = true;
$config['photo_multi'][$type_menu]['video'] = true;
$config['photo_multi'][$type_menu]['attr'] = array("display" => "Hiển thị");
$config['photo_multi'][$type_menu]['text'] = array(
	"name" => array("text" => "Tên", "lang" => true, "ckeditor" => false, "rows" => 1, "type" => 'input', "validate" => false, "data_type" => "varchar", "length" => "(255)",),
);

// $type_menu = 'about';
// $config['static'][$type_menu]['title'] = "Giới thiệu";
// $config['static'][$type_menu]['photo'] = true;
// $config['static'][$type_menu]['photo_width'] = 500;
// $config['static'][$type_menu]['photo_height'] = 400;
// $config['static'][$type_menu]['photo_type'] = FORMAT_IMAGE;
// $config['static'][$type_menu]['seo'] = true;
// $config['static'][$type_menu]['attr'] = array("display"=>"Hiển thị");
// $config['static'][$type_menu]['text'] = array(
// 	"name" => array("text" => "Tên","lang" => true,"ckeditor" => false,"rows" => 1,"type" => 'input',"validate" => true,"data_type" => "varchar","length" => "(255)",),
// 	"descript" => array("text" => "Mô tả","lang" => true,"ckeditor" => true,"rows" => 5,"type" => 'textarea',"data_type" => "text","length" => "",),
// 	"content" => array("text" => "Nội dung","lang" => true,"ckeditor" => true,"rows" => 5,"type" => 'textarea',"data_type" => "text","length" => "",),
// );

$type_menu = 'contact';
$config['static'][$type_menu]['title'] = "Liên hệ";
$config['static'][$type_menu]['photo'] = true;
$config['static'][$type_menu]['photo_width'] = 200;
$config['static'][$type_menu]['photo_height'] = 200;
$config['static'][$type_menu]['photo_type'] = FORMAT_IMAGE;
$config['static'][$type_menu]['seo'] = true;
$config['static'][$type_menu]['attr'] = array("display" => "Hiển thị");
$config['static'][$type_menu]['text'] = array(
	"content" => array("text" => "Nội dung", "lang" => true, "ckeditor" => true, "rows" => 5, "type" => 'textarea', "data_type" => "text", "length" => "",),
);

$type_menu = 'footer';
$config['static'][$type_menu]['title'] = "Footer";
$config['static'][$type_menu]['photo'] = false;
$config['static'][$type_menu]['photo_width'] = 490;
$config['static'][$type_menu]['photo_height'] = 400;
$config['static'][$type_menu]['photo_type'] = FORMAT_IMAGE;
$config['static'][$type_menu]['seo'] = false;
$config['static'][$type_menu]['attr'] = array("display" => "Hiển thị");
$config['static'][$type_menu]['text'] = array(
	"content" => array("text" => "Nội dung", "lang" => true, "ckeditor" => true, "rows" => 5, "type" => 'textarea', "data_type" => "text", "length" => "",),
);

$type_menu = 'product';
for ($i = 0; $i < $config['theme'][$type_menu]['level']; $i++) {
	$config['product-lv' . ($i + 1)][$type_menu]['title'] = 'Sản phẩm cấp ' . ($i + 1);
	$config['product-lv' . ($i + 1)][$type_menu]['photo'] = false;
	$config['product-lv' . ($i + 1)][$type_menu]['photo_width'] = 280;
	$config['product-lv' . ($i + 1)][$type_menu]['photo_height'] = 220;
	$config['product-lv' . ($i + 1)][$type_menu]['gallery'] = false;
	$config['product-lv' . ($i + 1)][$type_menu]['gallery_width'] = 280;
	$config['product-lv' . ($i + 1)][$type_menu]['gallery_height'] = 220;
	$config['product-lv' . ($i + 1)][$type_menu]['photo_type'] = FORMAT_IMAGE;
	$config['product-lv' . ($i + 1)][$type_menu]['seo'] = true;
	$config['product-lv' . ($i + 1)][$type_menu]['slug'] = true;
	$config['product-lv' . ($i + 1)][$type_menu]['view'] = true;
	$config['product-lv' . ($i + 1)][$type_menu]['attr'] = array("display" => "Hiển thị", "hot" => "Nổi bật");
	$config['product-lv' . ($i + 1)][$type_menu]['text'] = array(
		"name" => array("text" => "Tên", "lang" => true, "ckeditor" => false, "rows" => 1, "type" => 'input', "validate" => true, "data_type" => "varchar", "length" => "(255)",),
	);
}

$config['product'][$type_menu]['title'] = 'Sản phẩm';
$config['product'][$type_menu]['level'] = $config['theme'][$type_menu]['level'];
$config['product'][$type_menu]['photo'] = true;
$config['product'][$type_menu]['photo_width'] = 500;
$config['product'][$type_menu]['photo_height'] = 400;
$config['product'][$type_menu]['photo_type'] = FORMAT_IMAGE;
$config['product'][$type_menu]['gallery'] = true;
$config['product'][$type_menu]['gallery_width'] = 500;
$config['product'][$type_menu]['gallery_height'] = 400;
$config['product'][$type_menu]['file'] = false;
$config['product'][$type_menu]['file_type'] = FORMAT_DOCUMENT;
$config['product'][$type_menu]['old_price'] = false;
$config['product'][$type_menu]['promotion'] = false;
$config['product'][$type_menu]['tags'] = false;
$config['product'][$type_menu]['seo'] = true;
$config['product'][$type_menu]['slug'] = true;
$config['product'][$type_menu]['view'] = true;
$config['product'][$type_menu]['place_from'] = true;
$config['product'][$type_menu]['place_to'] = true;
$config['product'][$type_menu]['attr'] = array("hot" => "Nổi bật", "display" => "Hiển thị");
$config['product'][$type_menu]['text'] = array(
	"name" => array("text" => "Tên", "lang" => true, "ckeditor" => false, "rows" => 1, "type" => 'input', "validate" => true, "data_type" => "varchar", "length" => "(255)",),
	// "place_from" => array("text" => "Nơi khởi hành", "lang" => true, "ckeditor" => false, "rows" => 1, "type" => 'input', "data_type" => "text", "length" => "",),
	// "place_to" => array("text" => "Nơi đến", "lang" => true, "ckeditor" => false, "rows" => 1, "type" => 'input', "data_type" => "text", "length" => "",),
	"place_to" => array("text" => "Điểm đến", "lang" => true, "ckeditor" => false, "rows" => 1, "type" => 'input', "data_type" => "text", "length" => "",),
	"date_tour" => array("text" => "Số ngày", "lang" => false, "ckeditor" => false, "rows" => 1, "type" => 'input', "data_type" => "text", "length" => "",),
	"remain" => array("text" => "Số chỗ còn lại", "lang" => true, "ckeditor" => false, "rows" => 1, "type" => 'input', "data_type" => "text", "length" => "",),
	"descript" => array("text" => "Mô tả", "lang" => true, "ckeditor" => false, "rows" => 5, "type" => 'textarea', "data_type" => "text", "length" => "",),
	"content" => array("text" => "Nội dung", "lang" => true, "ckeditor" => true, "rows" => 5, "type" => 'textarea', "data_type" => "text", "length" => "",),
);

$type_menu = 'news';
for ($i = 0; $i < $config['theme'][$type_menu]['level']; $i++) {
	$config['post-lv' . ($i + 1)][$type_menu]['title'] = 'Tin tức cấp ' . ($i + 1);
	$config['post-lv' . ($i + 1)][$type_menu]['photo'] = false;
	$config['post-lv' . ($i + 1)][$type_menu]['photo_width'] = 280;
	$config['post-lv' . ($i + 1)][$type_menu]['photo_height'] = 220;
	$config['post-lv' . ($i + 1)][$type_menu]['gallery'] = false;
	$config['post-lv' . ($i + 1)][$type_menu]['gallery_width'] = 280;
	$config['post-lv' . ($i + 1)][$type_menu]['gallery_height'] = 220;
	$config['post-lv' . ($i + 1)][$type_menu]['photo_type'] = FORMAT_IMAGE;
	$config['post-lv' . ($i + 1)][$type_menu]['seo'] = true;
	$config['post-lv' . ($i + 1)][$type_menu]['slug'] = true;
	$config['post-lv' . ($i + 1)][$type_menu]['view'] = true;
	$config['post-lv' . ($i + 1)][$type_menu]['attr'] = array("display" => "Hiển thị");
	$config['post-lv' . ($i + 1)][$type_menu]['text'] = array(
		"name" => array("text" => "Tên", "lang" => true, "ckeditor" => false, "rows" => 1, "type" => 'input', "validate" => true, "data_type" => "varchar", "length" => "(255)",),
	);
}

$config['post'][$type_menu]['title'] = 'Tin tức';
$config['post'][$type_menu]['level'] = $config['theme'][$type_menu]['level'];
$config['post'][$type_menu]['photo'] = true;
$config['post'][$type_menu]['photo_width'] = 500;
$config['post'][$type_menu]['photo_height'] = 400;
$config['post'][$type_menu]['photo_type'] = FORMAT_IMAGE;
$config['post'][$type_menu]['gallery'] = false;
$config['post'][$type_menu]['gallery_width'] = 500;
$config['post'][$type_menu]['gallery_height'] = 400;
$config['post'][$type_menu]['file'] = false;
$config['post'][$type_menu]['file_type'] = FORMAT_DOCUMENT;
$config['post'][$type_menu]['tags'] = false;
$config['post'][$type_menu]['seo'] = true;
$config['post'][$type_menu]['slug'] = true;
$config['post'][$type_menu]['view'] = true;
$config['post'][$type_menu]['attr'] = array("hot" => "Nổi bật", "display" => "Hiển thị");
$config['post'][$type_menu]['text'] = array(
	"name" => array("text" => "Tên", "lang" => true, "ckeditor" => false, "rows" => 1, "type" => 'input', "validate" => true, "data_type" => "varchar", "length" => "(255)",),
	"descript" => array("text" => "Mô tả", "lang" => true, "ckeditor" => false, "rows" => 5, "type" => 'textarea', "data_type" => "text", "length" => "",),
	"content" => array("text" => "Nội dung", "lang" => true, "ckeditor" => true, "rows" => 5, "type" => 'textarea', "data_type" => "text", "length" => "",),
);

$type_menu = 'service';
$config['post'][$type_menu]['title'] = 'Dịch vụ';
$config['post'][$type_menu]['level'] = $config['theme'][$type_menu]['level'];
$config['post'][$type_menu]['photo'] = true;
$config['post'][$type_menu]['photo_width'] = 500;
$config['post'][$type_menu]['photo_height'] = 400;
$config['post'][$type_menu]['photo_type'] = FORMAT_IMAGE;
$config['post'][$type_menu]['gallery'] = false;
$config['post'][$type_menu]['gallery_width'] = 500;
$config['post'][$type_menu]['gallery_height'] = 400;
$config['post'][$type_menu]['file'] = false;
$config['post'][$type_menu]['file_type'] = FORMAT_DOCUMENT;
$config['post'][$type_menu]['tags'] = false;
$config['post'][$type_menu]['seo'] = true;
$config['post'][$type_menu]['slug'] = true;
$config['post'][$type_menu]['view'] = true;
$config['post'][$type_menu]['attr'] = array("hot" => "Nổi bật", "display" => "Hiển thị");
$config['post'][$type_menu]['text'] = array(
	"name" => array("text" => "Tên", "lang" => true, "ckeditor" => false, "rows" => 1, "type" => 'input', "validate" => true, "data_type" => "varchar", "length" => "(255)",),
	"descript" => array("text" => "Mô tả", "lang" => true, "ckeditor" => false, "rows" => 5, "type" => 'textarea', "data_type" => "text", "length" => "",),
	"content" => array("text" => "Nội dung", "lang" => true, "ckeditor" => true, "rows" => 5, "type" => 'textarea', "data_type" => "text", "length" => "",),
);

// $type_menu = 'utilities';
// $config['post'][$type_menu]['title'] = 'Tiện ích';
// $config['post'][$type_menu]['level'] = $config['theme'][$type_menu]['level'];
// $config['post'][$type_menu]['photo'] = true;
// $config['post'][$type_menu]['photo_width'] = 500;
// $config['post'][$type_menu]['photo_height'] = 400;
// $config['post'][$type_menu]['photo_type'] = FORMAT_IMAGE;
// $config['post'][$type_menu]['gallery'] = false;
// $config['post'][$type_menu]['gallery_width'] = 500;
// $config['post'][$type_menu]['gallery_height'] = 400;
// $config['post'][$type_menu]['file'] = false;
// $config['post'][$type_menu]['file_type'] = FORMAT_DOCUMENT;
// $config['post'][$type_menu]['tags'] = false;
// $config['post'][$type_menu]['seo'] = true;
// $config['post'][$type_menu]['slug'] = true;
// $config['post'][$type_menu]['view'] = true;
// $config['post'][$type_menu]['attr'] = array("hot"=>"Nổi bật", "display"=>"Hiển thị");
// $config['post'][$type_menu]['text'] = array
// (
// 	"name" => array("text" => "Tên","lang" => true,"ckeditor" => false,"rows" => 1,"type" => 'input',"validate" => true,"data_type" => "varchar","length" => "(255)",),
// 	"descript" => array("text" => "Mô tả","lang" => true,"ckeditor" => false,"rows" => 5,"type" => 'textarea',"data_type" => "text","length" => "",),
// 	"content" => array("text" => "Nội dung","lang" => true,"ckeditor" => true,"rows" => 5,"type" => 'textarea',"data_type" => "text","length" => "",),
// );

$type_menu = 'support';
$config['post'][$type_menu]['title'] = 'Hướng dẫn';
$config['post'][$type_menu]['level'] = $config['theme'][$type_menu]['level'];
$config['post'][$type_menu]['photo'] = false;
$config['post'][$type_menu]['photo_width'] = 500;
$config['post'][$type_menu]['photo_height'] = 400;
$config['post'][$type_menu]['photo_type'] = FORMAT_IMAGE;
$config['post'][$type_menu]['gallery'] = false;
$config['post'][$type_menu]['gallery_width'] = 500;
$config['post'][$type_menu]['gallery_height'] = 400;
$config['post'][$type_menu]['file'] = false;
$config['post'][$type_menu]['file_type'] = FORMAT_DOCUMENT;
$config['post'][$type_menu]['tags'] = false;
$config['post'][$type_menu]['seo'] = true;
$config['post'][$type_menu]['slug'] = true;
$config['post'][$type_menu]['view'] = true;
$config['post'][$type_menu]['attr'] = array("hot" => "Nổi bật", "display" => "Hiển thị");
$config['post'][$type_menu]['text'] = array(
	"name" => array("text" => "Tên", "lang" => true, "ckeditor" => false, "rows" => 1, "type" => 'input', "validate" => true, "data_type" => "varchar", "length" => "(255)",),
	// "descript" => array("text" => "Mô tả","lang" => true,"ckeditor" => false,"rows" => 5,"type" => 'textarea',"data_type" => "text","length" => "",),
	"content" => array("text" => "Nội dung", "lang" => true, "ckeditor" => true, "rows" => 5, "type" => 'textarea', "data_type" => "text", "length" => "",),
);

// $type_menu = 'policy';
// $config['post'][$type_menu]['title'] = 'Chính sách';
// $config['post'][$type_menu]['level'] = $config['theme'][$type_menu]['level'];
// $config['post'][$type_menu]['photo'] = true;
// $config['post'][$type_menu]['photo_width'] = 500;
// $config['post'][$type_menu]['photo_height'] = 400;
// $config['post'][$type_menu]['photo_type'] = FORMAT_IMAGE;
// $config['post'][$type_menu]['gallery'] = false;
// $config['post'][$type_menu]['gallery_width'] = 500;
// $config['post'][$type_menu]['gallery_height'] = 400;
// $config['post'][$type_menu]['file'] = false;
// $config['post'][$type_menu]['file_type'] = FORMAT_DOCUMENT;
// $config['post'][$type_menu]['tags'] = false;
// $config['post'][$type_menu]['seo'] = true;
// $config['post'][$type_menu]['slug'] = true;
// $config['post'][$type_menu]['view'] = true;
// $config['post'][$type_menu]['attr'] = array("display"=>"Hiển thị");
// $config['post'][$type_menu]['text'] = array
// (
// 	"name" => array("text" => "Tên","lang" => true,"ckeditor" => false,"rows" => 1,"type" => 'input',"validate" => true,"data_type" => "varchar","length" => "(255)",),
// 	"content" => array("text" => "Nội dung","lang" => true,"ckeditor" => true,"rows" => 5,"type" => 'textarea',"data_type" => "text","length" => "",),
// );

// $type_menu = 'payments';
// $config['post'][$type_menu]['title'] = 'Hình thức thanh toán';
// $config['post'][$type_menu]['level'] = 0;
// $config['post'][$type_menu]['photo'] = false;
// $config['post'][$type_menu]['photo_width'] = 500;
// $config['post'][$type_menu]['photo_height'] = 400;
// $config['post'][$type_menu]['photo_type'] = FORMAT_IMAGE;
// $config['post'][$type_menu]['gallery'] = false;
// $config['post'][$type_menu]['gallery_width'] = 280;
// $config['post'][$type_menu]['gallery_height'] = 220;
// $config['post'][$type_menu]['file'] = false;
// $config['post'][$type_menu]['file_type'] = FORMAT_DOCUMENT;
// $config['post'][$type_menu]['tags'] = false;
// $config['post'][$type_menu]['slug'] = false;
// $config['post'][$type_menu]['seo'] = false;
// $config['post'][$type_menu]['view'] = false;
// $config['post'][$type_menu]['attr'] = array("display"=>"Hiển thị");
// $config['post'][$type_menu]['text'] = array
// (
// 	"name" => array("text" => "Tên","lang" => true,"ckeditor" => false,"rows" => 1,"type" => 'input',"validate" => true,"data_type" => "varchar","length" => "(255)",),
// 	"content" => array("text" => "Nội dung","lang" => true,"ckeditor" => true,"rows" => 5,"type" => 'textarea',"data_type" => "text","length" => "",),
// );

$type_menu = 'contact';
$config['newsletter'][$type_menu]['title'] = "Liên hệ";
$config['newsletter'][$type_menu]['send_email'] = false;
$config['newsletter'][$type_menu]['text'] = array(
	"name" => array("text" => "Tên", "ckeditor" => false, "rows" => 1, "col" => 'attr', "type" => 'input', "data_type" => "varchar", "length" => "(100)",),
	"phone" => array("text" => "Điện thoại", "ckeditor" => false, "rows" => 1, "col" => 'attr', "type" => 'input', "data_type" => "varchar", "length" => "(15)",),
	"email" => array("text" => "Email", "ckeditor" => false, "rows" => 1, "col" => 'attr', "type" => 'input', "data_type" => "varchar", "length" => "(100)",),
	"address" => array("text" => "Địa chỉ", "ckeditor" => false, "rows" => 1, "col" => 'attr', "type" => 'input', "data_type" => "varchar", "length" => "(100)",),
	"topic" => array("text" => "Chủ đề", "ckeditor" => false, "rows" => 1, "col" => 'attr', "type" => 'input', "data_type" => "varchar", "length" => "(100)",),
	"content" => array("text" => "Nội dung", "ckeditor" => false, "rows" => 1, "col" => 'attr', "type" => 'input', "data_type" => "varchar", "length" => "(255)",),
);

$type_menu = 'newsletter';
$config['newsletter'][$type_menu]['title'] = "Đăng ký nhận tin";
$config['newsletter'][$type_menu]['send_email'] = true;
$config['newsletter'][$type_menu]['text'] = array("email" => array("text" => "Email", "ckeditor" => false, "rows" => 1, "col" => 'name', "type" => 'input', "data_type" => "varchar", "length" => "(100)",),);

$config['setting']['setting']['title'] = "Cấu hình Website";
$config['setting']['setting']['photo_width'] = 300;
$config['setting']['setting']['photo_height'] = 200;
$config['setting']['setting']['photo_type'] = FORMAT_IMAGE;
$config['setting']['setting']['text'] = array();

$config['seo']['page'] = array(
	"page_product" => "Sản phẩm",
	"page_service" => "Dịch vụ",
	"page_news" => "Tin tức",
);
if (isset($_GET['type'])) {
	$config['seo'][$_GET['type']]['photo_width'] = 300;
	$config['seo'][$_GET['type']]['photo_height'] = 200;
	$config['seo'][$_GET['type']]['photo_type'] = FORMAT_IMAGE;
}

// $type_menu = 'color';
// $config['attribute'][$type_menu]['lang'] = false;
// $config['attribute'][$type_menu]['title'] = 'Màu';
// $config['attribute'][$type_menu]['photo'] = false;
// $config['attribute'][$type_menu]['photo_width'] = 500;
// $config['attribute'][$type_menu]['photo_height'] = 400;
// $config['attribute'][$type_menu]['photo_type'] = FORMAT_IMAGE;
// $config['attribute'][$type_menu]['price'] = true;
// $config['attribute'][$type_menu]['old_price'] = true;
// $config['attribute'][$type_menu]['color'] = true;
// $config['attribute'][$type_menu]['attr'] = array("display"=>"Hiển thị");
// $config['attribute'][$type_menu]['text'] = array
// (
// 	"name" => array("text" => "Màu","lang" => false,"ckeditor" => false,"col" => "col-md-4","rows" => 1,"type" => 'input',"validate" => true,"data_type" => "varchar","length" => "(255)",),
// );

// $type_menu = 'size';
// $config['attribute'][$type_menu]['lang'] = false;
// $config['attribute'][$type_menu]['title'] = 'Size';
// $config['attribute'][$type_menu]['photo'] = false;
// $config['attribute'][$type_menu]['photo_width'] = 500;
// $config['attribute'][$type_menu]['photo_height'] = 400;
// $config['attribute'][$type_menu]['photo_type'] = FORMAT_IMAGE;
// $config['attribute'][$type_menu]['gallery'] = false;
// $config['attribute'][$type_menu]['gallery_width'] = 500;
// $config['attribute'][$type_menu]['gallery_height'] = 400;
// $config['attribute'][$type_menu]['price'] = true;
// $config['attribute'][$type_menu]['old_price'] = false;
// $config['attribute'][$type_menu]['color'] = false;
// $config['attribute'][$type_menu]['attr'] = array("display"=>"Hiển thị");
// $config['attribute'][$type_menu]['text'] = array
// (
// 	"name" => array("text" => "Size","lang" => false,"ckeditor" => false,"col" => "col-md-4","rows" => 1,"type" => 'input',"validate" => true,"data_type" => "varchar","length" => "(255)",),
// );

// $type_menu = 'user';
// $config['user'][$type_menu]['title'] = "Quản lý User";
// $config['user'][$type_menu]['photo'] = true;
// $config['user'][$type_menu]['photo_width'] = 200;
// $config['user'][$type_menu]['photo_height'] = 200;
// $config['user'][$type_menu]['photo_type'] = FORMAT_IMAGE;
// $config['user'][$type_menu]['permission'] = false;

// $type_menu = 'admin';
// $config['user'][$type_menu]['title'] = "Quản lý User quản trị";
// $config['user'][$type_menu]['photo'] = true;
// $config['user'][$type_menu]['photo_width'] = 200;
// $config['user'][$type_menu]['photo_height'] = 200;
// $config['user'][$type_menu]['photo_type'] = FORMAT_IMAGE;
// $config['user'][$type_menu]['permission'] = false;
// $config['user'][$type_menu]['attr'] = array("display"=>"Hiển thị");
// $config['user'][$type_menu]['text'] = array
// (
// 	"name" => array("text" => "Tên","ckeditor" => false,"col" => "col-md-3","rows" => 1,"validate" => false,),
// 	"email" => array("text" => "Email","ckeditor" => false,"col" => "col-md-3","rows" => 1,"validate" => false,),
// 	"phone" => array("text" => "Điện thoại","ckeditor" => false,"col" => "col-md-3","rows" => 1,"validate" => false,),
// 	"address" => array("text" => "Địa chỉ","ckeditor" => false,"col" => "col-md-3","rows" => 1,"validate" => false,),
// );

// $config['permission'] = false;

// $type_menu = 'city';
// $config['place'][$type_menu]['title'] = "Thành phố";
// $config['place'][$type_menu]['ship'] = false;

// $type_menu = 'dist';
// $config['place'][$type_menu]['title'] = "Quận/Huyện";
// $config['place'][$type_menu]['ship'] = false;

// $type_menu = 'ward';
// $config['place'][$type_menu]['title'] = "Phường";
// $config['place'][$type_menu]['ship'] = false;

$stack_group = array();
$current_group = array();
    // $config['group'] = array(
    // 	"Group Sản Phẩm" => array(
    // 		"product" => array('product'),
    // 		"attribute" => array('product_tags'),
    // 		"order" => array('order'),
    // 		"post" => array('payments'),
    // 	),
    // );
    // if(!empty($config['group'])) {
    // 	foreach($config['group'] as $i => $group) {
    // 		foreach($group as $j => $type_indepent)
    // 		{
    // 			foreach($type_indepent as $k)
    // 			{
    // 				array_push($stack_group, $k);
    // 			}
    // 		}
    // 	}
    // }
