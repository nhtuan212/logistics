<section class="cover-detail">
    <div class="box-detail row">
        <div class="img-detail col-md-5 col-sm-5">
            <a class="MagicZoom" id="zoom" href="<?=$watermark_link.UPLOAD_PRODUCT_L.$pro_detail['photo']?>">
                <?=$func->get_photo(array('dir' => $theme->getDir(),'photo' => $pro_detail['photo'],'name' => $pro_detail['name'],'resize' => $watermark_resize,)); ?>
            </a>

            <?php if(count($pro_gallery)>0) { ?>
                <div class="gallery-product">
                    <div class="slick__page" :show="4" :arrows="true" :autoplay="false" :infinite="false">
                        <a data-zoom-id="zoom" href="<?=$watermark_link.UPLOAD_PRODUCT_L.$pro_detail['photo']?>">
                            <?=$func->get_photo(array('dir' => $theme->getDir(),'photo' => $pro_detail['photo'],'name' => $pro_detail['name'],'resize' => $watermark_resize,)); ?>
                        </a>
                        <?php foreach ($pro_gallery as $i => $gallery_item) { ?>
                            <a data-zoom-id="zoom" href="<?=$watermark_link.UPLOAD_GALLERY_L.$gallery_item['photo']?>">
                                <?=$func->get_photo(array('dir' => UPLOAD_GALLERY_L,'photo' => $gallery_item['photo'],'name' => $gallery_item['name'],'resize' => $watermark_resize,)); ?>
                            </a>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>

        <div class="info-detail col-md-7 col-sm-7">
            <h3 class="name-detail"><?=$pro_detail['name']?></h3>

            <?php if($pro_detail['code'] != '') { ?>
                <div class="group-detail">
                   <span class="font-weight-bold mr-2"><?=_masanpham?>: </span>
                   <span><?=$pro_detail['code']?></span>
                </div>
            <?php } ?>

            <div class="group-detail">
                <div class="price"><?=$func->price($pro_detail['price'], $pro_detail['old_price'])?></div>
            </div>

            <?php /* ?>
            <?php if(!empty($size)) { ?>
                <div class="group-detail size option-detail">
                    <label><?=_chonsize?>:</label>
                    <div class="row">
                        <?php foreach($size as $i => $item) { ?>
                            <div class="item">
                                <div class="product-attribute rounded position-relative" data-id="<?=$item['id']?>">
                                    <span><?=$item['name']?></span>
                                    <div class="svg-group"><svg enable-background="new 0 0 12 12" viewBox="0 0 12 12" x="0" y="0" class="svg-icon"><g><path d="m5.2 10.9c-.2 0-.5-.1-.7-.2l-4.2-3.7c-.4-.4-.5-1-.1-1.4s1-.5 1.4-.1l3.4 3 5.1-7c .3-.4 1-.5 1.4-.2s.5 1 .2 1.4l-5.7 7.9c-.2.2-.4.4-.7.4 0-.1 0-.1-.1-.1z"></path></g></svg></div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>

            <?php if(!empty($color)) { ?>
                <div class="group-detail color option-detail">
                    <label><?=_chonmau?>:</label>
                    <div class="row">
                        <?php foreach($color as $i => $item) { ?>
                            <div class="item">
                                <div class="product-attribute rounded position-relative" data-id="<?=$item['id']?>">
                                    <span><?=$item['name']?></span>
                                    <div class="svg-group"><svg enable-background="new 0 0 12 12" viewBox="0 0 12 12" x="0" y="0" class="svg-icon"><g><path d="m5.2 10.9c-.2 0-.5-.1-.7-.2l-4.2-3.7c-.4-.4-.5-1-.1-1.4s1-.5 1.4-.1l3.4 3 5.1-7c .3-.4 1-.5 1.4-.2s.5 1 .2 1.4l-5.7 7.9c-.2.2-.4.4-.7.4 0-.1 0-.1-.1-.1z"></path></g></svg></div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>

            <div class="group-detail option-detail">
                <label>Số lượng</label>
                <div class="quantity d-flex ml-3">
                    <span class="quantity-down"><i class="fas fa-minus"></i></span>
                    <input type="number" min="1" value="1"/>
                    <span class="quantity-up"><i class="fas fa-plus"></i></span>
                </div>
            </div>
            <div class="group-detail row">
                <div class="col-md-4 col-6">
                    <button class="btn w-100 btn-danger btn-cart" data-id='<?=$pro_detail['id']?>' data-kind='buy' type="button">Mua ngay</button>
                </div>
                <div class="col-md-4 col-6">
                    <button class="btn w-100 btn-success btn-cart" data-id='<?=$pro_detail['id']?>' data-kind='add' type="button"><?=_chonmua?></button>
                </div>
            </div>
            <input type="hidden" class="template" value="product_detail">
            <?php */ ?>

            <?php if($pro_detail['descript'] != '') { ?>
                <aside class="desc-detail mt-2"><?=$func->decode($func->down_line($pro_detail['descript']))?></aside>
            <?php } ?>

            <div class="share-toolbox"></div>
        </div>
    </div>

    <div class="detail-content py-3">
        <div class="title-content d-flex">
            <p class="active"><?=_thongtinsanpham?></p>
        </div>
        <aside><?=$func->decode($pro_detail['content'])?></aside>
        <div class="fb-comments" data-href="<?=$func->getCurrentPageURL()?>" data-numposts="5" data-width="100%"></div>
    </div>
</section>

<?php if(count($product) > 0) { ?>
    <p class="title"><?=$title_other?></p>
    <div class="row">
        <?php foreach ($product as $i => $item) {
            $funcLayout->setTbl('product');
            $funcLayout->setClass('item-custom item-product text-center');
            $funcLayout->setHvr('hvr-zoom');
            $funcLayout->infoTheme($type);
            $funcLayout->item($item);
            $funcLayout->setType($type);
            $funcLayout->setImage($theme->getDir(), $theme->getColumn(), $theme->getResize());
            echo $funcLayout->getTheme();
        } ?>
    </div>
    <div class="pagination"><?=$paging?></div>
<?php } ?>