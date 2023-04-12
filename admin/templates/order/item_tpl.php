<div class="content-wrapper cover-order">	
	<section class="content-header">
		<div class="container-fluid">
		</div>
	</section>
	<div class="d-flex">
		<div class="col-12">
			<div class="card card-outline card-danger">
				<div class="card-header">
					<h3 class="card-title">Đơn hàng</h3>
				</div>

				<div class="card-header">
					<div class="row">
						<div class="col-md-3 col-sm-6">
							<div class="info-box bg-warning">
								<span class="info-box-icon"><i class="fas fa-shopping-cart"></i></span>
								<div class="info-box-content">
									<span class="info-box-text font-weight-bold text-uppercase">Đơn hàng mới</span>
									<div class="info-box-text">Số Lượng: <span class="font-weight-bold"><?=$orderNew_count?></span></div>
									<div class="info-box-text">Tổng giá: <span class="font-weight-bold"><?=$func->money($orderNew_total)?></span></div>
									<div class="progress">
										<div class="progress-bar" style="width: <?=$orderNew_percent?>%"></div>
									</div>
									<span class="progress-description"><?=$orderNew_percent?>% Tổng đơn hàng</span>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-sm-6">
							<div class="info-box bg-primary">
								<span class="info-box-icon"><i class="far fa-thumbs-up"></i></span>
								<div class="info-box-content">
									<span class="info-box-text font-weight-bold text-uppercase">Đã xác nhận</span>
									<div class="info-box-text">Số Lượng: <span class="font-weight-bold"><?=$orderConfirm_count?></span></div>
									<div class="info-box-text">Tổng giá: <span class="font-weight-bold"><?=$func->money($orderConfirm_total)?></span></div>
									<div class="progress">
										<div class="progress-bar" style="width: <?=$orderConfirm_percent?>%"></div>
									</div>
									<span class="progress-description"><?=$orderConfirm_percent?>% Tổng đơn hàng</span>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-sm-6">
							<div class="info-box bg-danger">
								<span class="info-box-icon"><i class="fas fa-shipping-fast"></i></span>
								<div class="info-box-content">
									<span class="info-box-text font-weight-bold text-uppercase">Đang giao hàng</span>
									<div class="info-box-text">Số Lượng: <span class="font-weight-bold"><?=$orderShip_count?></span></div>
									<div class="info-box-text">Tổng giá: <span class="font-weight-bold"><?=$func->money($orderShip_total)?></span></div>
									<div class="progress">
										<div class="progress-bar" style="width: <?=$orderShip_percent?>%"></div>
									</div>
									<span class="progress-description"><?=$orderShip_percent?>% Tổng đơn hàng</span>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-sm-6">
							<div class="info-box bg-success">
								<span class="info-box-icon"><i class="fas fa-check"></i></span>
								<div class="info-box-content">
									<span class="info-box-text font-weight-bold text-uppercase">Hoàn tất</span>
									<div class="info-box-text">Số Lượng: <span class="font-weight-bold"><?=$orderSuccess_count?></span></div>
									<div class="info-box-text">Tổng giá: <span class="font-weight-bold"><?=$func->money($orderSuccess_total)?></span></div>
									<div class="progress">
										<div class="progress-bar" style="width: <?=$orderSuccess_percent?>%"></div>
									</div>
									<span class="progress-description"><?=$orderSuccess_percent?>% Tổng đơn hàng</span>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="card-header">
					<form class="form_gh" name="search" action="" method="POST">
						<div class="box-control row">
							<div class="col-lg-3 col-12 mb-2">
								<input type="text" class="form-control keyword" name="keyword" placeholder="Mã đơn hàng" value="<?=@$_GET['keyword']?>">
							</div>

							<div class="input-group col-lg-3 col-12 mb-2">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
								</div>
								<input type="text" class="form-control daterange" name="daterange" value="<?=@$_GET['daterange']?>">
							</div>

							<div class="col-lg-3 col-12 mb-2"><?=get_payments()?></div>
							<div class="col-lg-3 col-12 mb-2"><?=get_status()?></div>
							<div class="col-lg-3 col-12 mb-2"><?=get_order_place("place_city", "id_city", "Thành phố", "place_dist")?></div>
							<div class="col-lg-3 col-12 mb-2"><?=get_order_place("place_dist", "id_dist", "Quận/ Huyện")?></div>
							<div class="col-lg-6 col-12 mb-2">
								<input type="text" class="rangePrice" value="">
							</div>
						</div>
						<div class="text-center mb-2">
							<button type="button" class="btn btn-success mb-2 mr-2" onclick="searchOrder();"><i class="fas fa-search mr-2"></i>Tìm kiếm</button>
							<button type="button" class="btn btn-danger mb-2" onclick="location.href='index.php?com=<?=$com?>&act=<?=$act?>'"><i class="fas fa-times mr-2"></i>Hủy kết quả</button>
						</div>
						<div><button type="button" class="btn btn-danger delete-all mb-2"><i class="far fa-trash-alt mr-1"></i>Xoá chọn</button></div>
					</form>
				</div>

				<div class="card-body table-responsive table-hover p-0">
					<table class="table">
						<thead>
							<tr>
								<td class="box-all">
									<a class="check-all"></a>
								</td>
								<td class="number onchange-number">Thứ tự</td>
								<td class="attr">Mã đơn hàng</td>
								<td class="name">Tên</td>
								<td class="price">Giá</td>
								<td class="attr">Ngày tạo đơn</td>
								<td class="status">Tình trạng</td>
								<td class="attr">Hiển thị</td>
								<td class="act-btn">Thao tác</td>
							</tr>
						</thead>
						
						<tbody>
							<?php foreach($order as $i => $items) { ?>
								<?php
                                    if(@$items['id']) $href = "&id=".$items['id']."";
                                    if(@$items['id_city']) $href .= "&id_city=".$items['id_city']."";
                                    if(@$items['id_dist']) $href .= "&id_dist=".$items['id_dist']."";
                                    if(@$_REQUEST['p']) $href .= "&p=".$_REQUEST['p']."";
                                ?>
								<tr>
									<td><a class="check" data-id="<?=$items['id']?>"></a></td>
									<td class="number onchange-number form-number">
										<input type="text" class="form-control" data-id="<?=$items['id']?>" data-tbl="<?=$com?>" data-attr="number" value="<?=$items['number']?>" onkeypress="return OnlyNumber(event)">
									</td>
									<td class="attr"><a href="index.php?com=<?=$com?>&act=edit<?=$href?>"><?=$items['code']?></a></td>
									<td class="name"><?=$items['name']?></td>
									<td class="price"><?=$func->money($items['total'])?></td>
									<td class="attr"><?=date("d/m/Y", $items['date_created'])?></td>
									<td class="status"><?=get_status($items['id'], $items['status'])?></td>
									<td class="attr">
										<a class="check-attr <?=(strpos('display', $items['status']) !== false) ? 'active' : ''?>" data-id="<?=$items['id']?>" data-tbl="<?=$tbl?>" data-attr="<?='display'?>"></a>
									</td>
									<td class="act-btn">
										<a href="index.php?com=<?=$com?>&act=edit<?=$href?>"><i class="far fa-edit"></i></a>
										<a onClick='alertConfirm("Bạn có chắc chắn muốn xóa?", "deleteCheck", "index.php?com=<?=$com?>&act=delete<?=$href?>");' href="javascript:"><i class="far fa-trash-alt"></i></a>
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