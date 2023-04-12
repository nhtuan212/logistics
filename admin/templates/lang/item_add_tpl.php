<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h4>Ngôn ngữ</h4>
                </div>
            </div>
        </div>
    </section>  
    
    <form class="frm-admin content" method="post" action="index.php?com=<?=$com?>&act=save&type=<?=@$type?>&p=<?=$p?>" enctype="multipart/form-data">
        <div class="row">
            <div class="col-12">
                <div class="card card-outline card-danger">
                    <div class="card-header d-flex">
                        <h3 class="card-title">Thông tin</h3>
                    </div>

                    <div class="card-body">
                        <div class="nav-tabs-custom">
                            <div class="form-group">
                                <label>Tên</label>
                                <input type="text" class="form-control validate[required]" value="<?=@$item['str']?>" name="data[str]"/>
                            </div>
                            <?php foreach ($config['website']['lang'] as $lang => $value) { ?>
                                <?php $setLang = ($lang=='') ? 'vi' : $lang ?>
                                <div class="form-group">
                                    <label><?=$value?></label>
                                    <input type="text" class="form-control" value="<?=@$item['lang'.$setLang]?>" name="data[lang<?=$setLang?>]"/>
                                </div>
                            <?php } ?>                            
                            <div class="form-group form-number d-flex justify-content-start">
                                <label>Số thứ tự</label>
                                <div class="number">
                                    <input type="text" class="form-control" name="data[number]" value="<?=(@$item['number']>0) ? $item['number'] : 1?>" onkeypress="return OnlyNumber(event)">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="cover-button d-flex justify-content-end">
            <input type="hidden" name="id" value="<?=@$item['id']?>" />
            <button type="button" class="btn btn-primary" onclick="submit_admin()"><i class="far fa-save mr-1"></i>Hoàn tất</button>
            <button type="button" class="btn btn-danger"><a href="index.php"><i class="fas fa-sign-out-alt mr-1"></i>Thoát</a></button>
        </div>

    </form>
</div>