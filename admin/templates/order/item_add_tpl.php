<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h4>Chi tiết đơn hàng</h4>
                </div>
            </div>
        </div>
    </section>

    <form class="frm-admin content" method="post" action="index.php?com=<?=$com?>&act=save&type=<?=$type?>&p=<?=$p?>" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline card-danger">
                    <div class="card-header d-flex">
                        <h3 class="card-title">Thông tin người đặt</h3>
                    </div>

                    <div class="card-body row">
                        <div class="form-group col-sm-6">
                            <label>Tên</label>
                            <input type="text" class="form-control" name="data[name]" value="<?=@$item['name']?>"/>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Email</label>
                            <input type="text" class="form-control" name="data[email]" value="<?=@$item['email']?>"/>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Điện thoại</label>
                            <input type="text" class="form-control" name="data[phone]" value="<?=@$item['phone']?>"/>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Địa chỉ</label>
                            <input type="text" class="form-control" name="data[address]" value="<?=@$item['address']?>"/>
                        </div>
                        <div class="form-group col-sm-6">
                            <label class="col-form-label">Thành phố</label>
                            <?=get_ajax_place("place_city", "id_city", "Chọn Thành phố", "place_dist")?>
                        </div><div class="form-group col-sm-6">
                            <label class="col-form-label">Quận</label>
                            <?=get_ajax_place("place_dist", "id_dist", "Chọn Quận")?>
                        </div>
                        <div class="form-group col-sm-12">
                            <label>Nội dung</label>
                            <textarea class="form-control" name="data[content]" rows="5"/><?=@$item['content']?></textarea>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-form-label">Hình thức thanh toán</label>
                                <?=get_payments($item['id'], $item['id_payments'])?>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-form-label">Trạng thái</label>
                                <?=get_status($item['id'], $item['status'])?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card card-outline card-danger">
                    <div class="card-header d-flex">
                        <h3 class="card-title">Sản phẩm</h3>
                    </div>

                    <div class="card-body">
                        <table class="table table-responsive table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Hình ảnh</th>
                                    <th class="name">Tên</th>
                                    <th class="attr">Số lượng</th>
                                    <th class="attr">Giá</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($order_detail as $i => $detail_item) {?>
                                    <?php
                                        $size = $d->rawQueryOne("select id, name from #_attribute where id=?", array($detail_item['id_size']));
                                        $color = $d->rawQueryOne("select id, name from #_attribute where id=?", array($detail_item['id_color']));
                                    ?>
                                    <tr class="item-<?=$detail_item['id']?><?=$item['id']?>">
                                        <td style="width: 8%;"><img src="<?=CACHE?>70x70x1/<?=UPLOAD_PRODUCT_L.$detail_item['photo']?>"/></td>
                                        <td class="name">
                                            <strong><?=@$detail_item['name']?></strong>
                                            <?php if(@$size) { ?><div>Size: <?=@$size['name']?></div><?php } ?>
                                            <?php if(@$color) { ?><div>Màu: <?=@$color['name']?></div><?php } ?>
                                        </td>
                                        <td class="attr"><?=$detail_item['qty']?></td>
                                        <td class="attr"><?=$func->money(@$detail_item['price'])?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="attr text-right">Tổng tiền</th>
                                    <th colspan="1" class="attr total"><?=$func->money(@$item['total'])?></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="cover-button d-flex">
            <input type="hidden" name="id" value="<?=$item['id']?>" />
            <button type="button" class="btn btn-primary" onclick="submit_admin()"><i class="far fa-save mr-1"></i>Hoàn tất</button>
            <button type="button" class="btn btn-danger"><a href="index.php"><i class="fas fa-sign-out-alt mr-1"></i>Thoát</a></button>
        </div>

    </form>
</div>