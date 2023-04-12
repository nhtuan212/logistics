<div class="content-wrapper pd20-0">    
    <form class="frm-admin content" method="post" action="index.php?com=<?=$com?>&act=save&type=<?=$type?>" enctype="multipart/form-data">
        <div class="row">
            <div class="col-12">
                <div class="card card-outline card-danger">
                    <div class="card-header d-flex">
                        <h3 class="card-title">Thông tin</h3>
                    </div>

                    <div class="card-body">
                        <div class="nav-tabs-custom">
                            <div class="row">
                                <div class="col-md-4">
                                    <?php include LAYOUT."photo.php";?>
                                </div>
                                <div class="col-md-8 pl-5">
                                    <?php include LAYOUT."seo.php";?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>        

        <div class="cover-button d-flex justify-content-end">
            <input type="hidden" name="id" value="<?=$item['id']?>" />
            <input type="hidden" name="data[type]" value="<?=$type?>" />
            <button type="button" class="btn btn-primary" onclick="submit_admin()"><i class="far fa-save mr-1"></i>Hoàn tất</button>
            <button type="button" class="btn btn-danger"><a href="index.php"><i class="fas fa-sign-out-alt mr-1"></i>Thoát</a></button>
        </div>

    </form>
</div>