<div class="content-wrapper">
	<div class="d-flex">
		<div class="col-12">
			<div class="card card-outline card-danger">
				<div class="card-header">
					<h3 class="card-title"><?=$config['product'][$type]['title']?></h3>
				</div>

				<div class="card-header sticky-top bg-white border-bottom border-danger">
					<div class="box-control row">
						<button type="button" class="btn btn-primary mb-2" onclick="location.href='index.php?com=<?=$com?>&act=add&type=<?=$type?>'"><i class="fas fa-plus mr-1"></i>Thêm</button>

						<button type="button" class="btn btn-danger delete-all mb-2"><i class="far fa-trash-alt mr-1"></i>Xoá chọn</button>
						
						<div class="search form-control d-flex mr-2 mb-2">
							<input type="text" class="keyword" onKeyPress="EnterSearch(event,'keyword');" placeholder="Nhập từ khóa tìm kiếm" value="<?=isset($_GET['keyword']) ? $_GET['keyword'] : ""?>" >
                            <i class="fas fa-search bg-success" onclick="SearchAdmin();"></i>
						</div>
						
						<?php for($i=0; $i < $config['product'][$type]['level']; $i++) { ?>
							<div class="category mr-2 mb-2">
								<div class="col-sm-12">
									<?=get_link_category("category", "id_lv".($i+1)."", $i+1)?>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>

				<div class="card-body table-responsive table-hover p-0">
					<table class="table">
						<thead>
							<tr>
								<td class="box-all"><a class="check-all"></a></td>
								<td class="number">Thứ tự</td>
								<?php if($config['product'][$type]['photo']=='true') { ?>
									<td class="img">Hình ảnh</td>
								<?php } ?>
								<td class="name">Tên</td>
								<?php foreach($config['product'][$type]['attr'] as $attr => $attr_value) { ?>
                                    <td class="attr"><?=$attr_value?></td>
                                <?php } ?>
							</tr>
						</thead>
						
						<tbody>
							<?php foreach($product as $i => $items) { ?>
								<?php
									if(@$items['id']) $href = "&id=".$items['id']."";
                                    if(@$items['type']) $href .= "&type=".$items['type']."";
                                    if(@$items['level']) $href .= "&level=".$items['level']."";
                                    if(@$items['id_lv1']) $href .= "&id_lv1=".$items['id_lv1']."";
                                    if(@$items['id_lv2']) $href .= "&id_lv2=".$items['id_lv2']."";
                                    if(@$items['id_lv3']) $href .= "&id_lv3=".$items['id_lv3']."";
                                    if(@$items['id_place_from']) $href .= "&id_place_from=".$items['id_place_from']."";
                                    if(@$items['id_place_to']) $href .= "&id_place_to=".$items['id_place_to']."";
                                    if(@$_REQUEST['p']) $href .= "&p=".$_REQUEST['p']."";
                                ?>
								<tr>
									<td>
										<a class="check" data-id="<?=$items['id']?>"></a>
	                    			</a>
									</td>

									<td class="number form-number onchange-number">
										<input type="text" class="form-control" data-id="<?=$items['id']?>" data-tbl="<?=$com?>" data-attr="number" value="<?=$items['number']?>" onkeypress="return OnlyNumber(event)">
									</td>
									<?php if($config['product'][$type]['photo']=='true') { ?>
										<td class="img">
											<a href="index.php?com=<?=$com?>&act=edit<?=$href?>">
												<?=$func->get_photo(array('dir' => UPLOAD_PRODUCT_L,'photo' => $items['photo'],'name' => $items['name'],'resize' => $resize,)); ?>
											</a>
										</td>
									<?php } ?>

									<td class="name">
										<a href="index.php?com=<?=$com?>&act=edit<?=$href?>"><?=$items['name']?></a>
										<div class="box-link d-flex flex-wrap">
											<?php if($config['product'][$type]['view']=='true') { ?>
												<a class="card-link text-primary" href="<?=$config_url_http.$items['tenkhongdau']?>" target="blank"><i class="far fa-eye"></i>View</a>
											<?php } ?>
											<a class="card-link text-primary" href="index.php?com=<?=$com?>&act=edit<?=$href?>"><i class="far fa-edit"></i>Edit</a>
											<a class="card-link text-danger" onClick='alertConfirm("Bạn có chắc chắn muốn xóa?", "deleteCheck", "index.php?com=<?=$com?>&act=delete<?=$href?>");' href="javascript:"><i class="far fa-trash-alt"></i>Delete</a>
											<?php if(@$config['developer']['copy']=='true') { ?>
												<li class="card-link dropdown">
													<a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="text-success dropdown-toggle"><i class="far fa-copy"></i>Copy</a>
													<ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow" style="left: 0px; right: inherit;">
														<li><a href="#" class="dropdown-item" onclick="copyNow('<?=$tbl?>', '<?=$items['id']?>')"><i class="fas fa-caret-right"></i>Sao chép ngay</a></li>
														<li class="dropdown-divider"></li>
														<li><a href="index.php?com=<?=$com?>&act=copy<?=$href?>" class="dropdown-item"><i class="fas fa-caret-right"></i>Sao chép chỉnh sửa</a></li>
													</ul>
												</li>
											<?php } ?>
										</div>
										
										<?php if(@$config['attribute']['size']) { ?>
											<?php $size = $d->rawQuery("select id, id_parent, name$lang as name, price, type from #_attribute where id_parent='".$items['id']."' and type='size' and FIND_IN_SET('display', status) order by number, id desc"); ?>
											<div class="attribute-group mt-1">
												<div class="d-flex flex-wrap">
													<label class="mr-2"><a class="card-link text-success text-left" href="index.php?com=attribute&act=man&type=size&id_parent=<?=$items['id']?>"><i class="fas fa-long-arrow-alt-right"></i>Size</a></label>
													<?php foreach($size as $j => $value_size) { ?>
														<a class="item-attribute" href="index.php?com=attribute&act=edit&id=<?=$value_size['id']?>&id_parent=<?=$items['id']?>&type=<?=$value_size['type']?>"><?=$value_size['name']?></a>
														<div class="line mx-2">-</div>
													<?php } ?>
												</div>
											</div>
										<?php } ?>
										
										<?php if(@$config['attribute']['color']) { ?>
											<?php
												$color = $d->rawQuery("select id, id_parent, name$lang as name, price, attribute, type from #_attribute where id_parent='".$items['id']."' and type='color' and FIND_IN_SET('display', status) order by number, id desc");
											?>
											<div class="attribute-group mt-1">
												<div class="d-flex flex-wrap">
													<label class="mr-2"><a class="card-link text-success text-left" href="index.php?com=attribute&act=man&type=color&id_parent=<?=$items['id']?>"><i class="fas fa-long-arrow-alt-right"></i>Màu sắc</a></label>
													<?php foreach($color as $j => $color_items) { ?>
														<a class="item-attribute" href="index.php?com=attribute&act=edit&id=<?=$color_items['id']?>&id_parent=<?=$items['id']?>&type=<?=$color_items['type']?>"><?=$color_items['name']?></a>
														<div class="line mx-2">-</div>
													<?php } ?>
												</div>
											</div>
										<?php } ?>
									</td>

									<?php foreach($config['product'][$type]['attr'] as $attr => $attr_value) { ?>
										<td class="attr">
                                            <a class="check-attr <?=(in_array($attr, explode(',', $items['status']))) ? 'active' : ''?>" data-id="<?=$items['id']?>" data-tbl="<?=$tbl?>" data-attr="<?=$attr?>"></a>
                                        </td>
                                    <?php } ?>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>

				<div class="pagination"><?=$paging?></div>
			</div>
		</div>
	</div>
</div>	