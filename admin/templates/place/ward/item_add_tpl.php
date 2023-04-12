<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h4><?=$config['place'][$type]['title']?></h4>
                </div>
            </div>
        </div>
    </section>  
    
    <form class="frm-admin content" method="post" action="index.php?com=<?=$com?>&act=save&type=<?=$type?>&p=<?=$p?>" enctype="multipart/form-data">
        <div class="row">
            <div class="col-12">
                <div class="card card-outline card-danger">
                    <div class="card-header d-flex">
                        <h3 class="card-title">Thông tin</h3>
                    </div>

                    <div class="card-body">
                        <div class="nav-tabs-custom">
                            <div class="form-group">
                                <label>Chọn Thành phố</label>
                                <?=get_ajax_place("place_city", "id_city", "Chọn Thành phố", "place_dist")?>
                            </div>

                            <div class="form-group">
                                <label>Chọn Quận/Huyện</label>
                                <?=get_ajax_place("place_dist", "id_dist", "Chọn Quận/Huyện")?>
                            </div>

                            <div class="form-group">
                                <label>Tên</label>
                                <input type="text" class="form-control validate[required]" value="<?=@$item['name']?>" name="data[name]"/>
                            </div>

                            <?php if($config['place'][$type]['ship'] == 'true') { ?>
                                <div class="form-group">
                                    <label>Ship</label>
                                    <input type="text" class="form-control" value="<?=@$item['ship']?>" name="data[ship]"/>
                                </div>
                            <?php } ?>
                            
                            <div class="form-group form-number d-flex">
                                <label>Số thứ tự</label>
                                <div class="number">
                                    <input type="text" class="form-control" name="data[number]" value="<?=($item['number']) ? $item['number'] : 1?>" onkeypress="return OnlyNumber(event)">
                                </div>
                            </div>

                            <div class="cover-check">
                                <?php $attr_array = explode(',', $item['status']); ?>
                                <div class="form-group">
                                    <label>Hiển thị</label>
                                    <a class="check-items <?=(in_array('display', $attr_array) || ($act == 'add'.$case)) ? 'active' : ''?>" data-attr="display">
                                        <input type="checkbox" name="status[display]" value="<?=(in_array('display', $attr_array) || ($act == 'add'.$case)) ? 'display' : ""?>" checked>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="cover-button d-flex">
            <input type="hidden" name="id" value="<?=$item['id']?>" />
            <input type="hidden" name="data[type]" value="<?=$type?>" />
            <button type="button" class="btn btn-primary" onclick="submit_admin()"><i class="far fa-save mr-1"></i>Hoàn tất</button>
            <button type="button" class="btn btn-danger"><a href="index.php"><i class="fas fa-sign-out-alt mr-1"></i>Thoát</a></button>
        </div>

    </form>
</div>