<div class="content-wrapper">
	<div class="d-flex">
		<div class="col-12">
			<div class="card card-outline card-danger">
				<div class="card-header">
					<h3 class="card-title">Danh sách sản phẩm</h3>
				</div>

				<div class="card-header sticky-top bg-white border-bottom border-danger">
					<div class="box-control row">
						<button type="button" class="btn btn-primary mr-2 mb-2" onclick="location.href='index.php?com=<?=$com?>&act=add<?=$case?>&type=<?=$type?>'"><i class="fas fa-plus mr-1"></i>Thêm</button>

						<button type="button" class="btn btn-danger mr-2 mb-2 delete-all"><i class="far fa-trash-alt mr-1"></i>Xoá chọn</button>

						<div class="search form-control mr-2 mb-2 d-flex">
							<input type="text" class="keyword" onKeyPress="EnterSearch(event,'keyword');" placeholder="Nhập từ khóa tìm kiếm" value="<?=isset($_GET['keyword']) ? $_GET['keyword'] : ""?>" >
                            <i class="fas fa-search bg-success" onclick="SearchAdmin();"></i>
						</div>
					</div>
				</div>

				<div class="card-body table-responsive table-hover p-0">
					<table class="table">
						<thead>
							<tr>
								<td class="box-all">
									<a class="check-all"></a>
								</td>

								<td class="number">Thứ tự</td>

								<?php if(!empty($config['photo_multi'][$type]['text']['name'])) { ?>
									<td class="name">Tên</td>
								<?php } ?>

								<?php if($config['photo_multi'][$type]['photo']=='true') { ?>
									<td class="img">Hình ảnh</td>
								<?php } ?>

								<?php foreach($config['photo_multi'][$type]['attr'] as $attr => $attr_value) { ?>
									<td class="attr"><?=$attr_value?></td>
								<?php } ?>
								<td class="act-btn">Thao tác</td>
							</tr>
						</thead>
						
						<tbody>
							<?php foreach($photo_multi as $i => $items) { ?>
								<?php									
                                    if(@$items['id']) $href = "&id=".$items['id']."";
                                    if(@$items['type']) $href .= "&type=".$items['type']."";
                                    if(@$_REQUEST['p']) $href .= "&p=".$_REQUEST['p']."";
                                ?>
								<tr>
									<td><a class="check" data-id="<?=$items['id']?>"></a></td>

									<td class="number onchange-number form-number">
										<input type="text" class="form-control" data-id="<?=$items['id']?>" data-tbl="<?=$com?>" data-attr="number" value="<?=$items['number']?>">
									</td>

									<?php if(!empty($config['photo_multi'][$type]['text']['name'])) { ?>
										<td class="name"><a href="index.php?com=<?=$com?>&act=edit<?=$case?><?=$href?>"><?=$items['name']?></a></td>
									<?php } ?>
									
									<?php if($config['photo_multi'][$type]['photo']=='true') { ?>
										<td class="img">
											<a href="index.php?com=<?=$com?>&act=edit<?=$case?><?=$href?>" style="display: block;max-width: 300px;max-height: 150px;overflow: hidden">
												<?=$func->get_photo(array('dir' => UPLOAD_PHOTO_L,'photo' => $items['photo'],'name' => $items['name'],'resize' => $resize,)); ?>
											</a>
										</td>
									<?php } ?>

									<?php foreach($config['photo_multi'][$type]['attr'] as $attr => $attr_value) { ?>
										<td class="attr">
											<a class="check-attr <?=(in_array($attr, explode(',', $items['status']))) ? 'active' : ''?>" data-id="<?=$items['id']?>" data-tbl="<?=$tbl?>" data-attr="<?=$attr?>"></a>
										</td>
									<?php } ?>

									<td class="act-btn">
										<a href="index.php?com=<?=$com?>&act=edit<?=$case?><?=$href?>"><i class="far fa-edit"></i></a>
										<a onClick='alertConfirm("Bạn có chắc chắn muốn xóa?", "deleteCheck", "index.php?com=<?=$com?>&act=delete<?=$case?><?=$href?>");' href="javascript:"><i class="far fa-trash-alt"></i></a>
									</td>
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