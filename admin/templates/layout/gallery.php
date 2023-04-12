<?php
    if($level)
    {
        $edit_act = 'edit_category';
        $where = " and level=".$level."";
    }
    else
    {
        $edit_act = 'edit';
        $where = " and level=0";
    }
    @$gallery = $d->rawQuery("select * from #_gallery where id_parent=? and type=? $where order by number, id desc", array($item['id'], $type));
    if($level > 0) $com_type = $com.'-lv'.$level;
    else $com_type = $com;
?>
<div class="form-group gallery">
    <label class="w-100">Hình đính kèm</label>
    <?php if($gallery) { ?>
        <button type="button" class="btn btn-sm btn-primary mr-1 mb-1 choseGallery" href="javascript:"><i class="far fa-square mr-2"></i>Chọn</button>
        <button type="button" class="btn btn-sm btn-success mr-1 mb-1 sortGallery" id="switcher" href="javascript:"><i class="fas fa-random mr-2"></i></i>Sắp xếp</button>
        <div class="form-group mb-2">
            <button type="button" class="btn btn-sm btn-primary mr-1 choseAllGallery d-none" href="javascript:"><i class="far fa-square mr-2"></i>Chọn tất cả</button>
            <button type="button" class="btn btn-sm btn-danger mr-1 deleteGallery d-none" href="javascript:" onclick='alertConfirm("Bạn có chắc chắn muốn xóa !", "deleteListGallery")'><i class="far fa-trash-alt mr-2"></i>Xóa chọn</button>
        </div>
        <div class="text-sort font-italic font-weight-bold text-danger mb-1"></div>
    <?php } ?>
    <?php if($act == $edit_act) { ?>
        <ul class="jFiler-item-list jFiler-items-grid row" id="sortGallery">
            <?php foreach ($gallery as $i => $value) { ?>
                <li class="jFiler-item jFiler-item-<?=$value['id']?> col-xl-6 col-lg-6 col-md-6 col-sm-3 col-6 mb-2" data-id="<?=$value['id']?>">
                    <div class="jFiler-item-container">
                        <div class="choseItem custom-control custom-checkbox d-none">
                            <input class="custom-control-input" type="checkbox" id="check-gallery-<?=$value['id']?>" value="<?=$value['id']?>">
                            <label for="check-gallery-<?=$value['id']?>" class="custom-control-label"></label>
                        </div>
                        <div class="jFiler-item-inner">
                            <div class="jFiler-item-thumb">
                                <?php $resize = $config[$com_type][$type]['gallery_width'].'x'.$config[$com_type][$type]['gallery_height'].'x1'; ?>
                                <?=$func->get_photo(array('dir' => UPLOAD_GALLERY_L,'photo' => $value['photo'],'resize' => $resize,));?>
                                <a class="delete-gallery list-inline text-danger" onclick='alertConfirm("Bạn có chắc chắn muốn xóa !", "deleteGallery", "<?=$value['id']?>")' href="javascript:"><i class="far fa-trash-alt"></i></a>
                                <div class="sortMove d-none">
                                    <div class="icon-move d-flex justify-content-center align-items-center text-warning">
                                        <i class="fas fa-arrows-alt"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <input class="update-gallery jFiler-number form-control jFiler-number-<?=$value['id']?>" data-tbl="gallery" data-attr="number" data-id="<?=$value['id']?>" type="text" onkeypress="return OnlyNumber(event)" value="<?=$value['number']?>"/>
                            </div>
                            <div class="form-group">
                                <input class="update-gallery jFiler-number form-control" data-tbl="gallery" data-attr="name" data-id="<?=$value['id']?>" type="text" value="<?=$value['name']?>" placeholder="Tên hình"/>
                            </div>
                        </div>
                    </div>
                </li>
            <?php } ?>
        </ul>
    <?php } ?>
</div>
<input type="file" name="files[]" id="filer-input" multiple="multiple">

<div class="note center">
    Width: <?=$config[$com_type][$type]['gallery_width']?>px - Height: <?=$config[$com_type][$type]['gallery_height']?>px ( <?=$config[$com_type][$type]['photo_type']?> )
</div>