<footer class="cover-footer py-4 text-white">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-footer col-md-4">
                <aside><?=$func->decode($static['footer']['content'])?></aside>
                <div class="social d-flex justify-content-start mt-3">
                    <?php if (!empty($slider['social'])) { ?>
                        <?php foreach($slider['social'] as $i => $item) { ?> 
                            <a class="hvr-bounce mr-2" href="<?=$item['link']?>" target="blank">
                                <?=$func->get_photo(array('dir' => UPLOAD_PHOTO_L,'photo' => $item['photo'],'resize' => '35x35x1',));?>
                            </a>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>

            <div class="col-footer col-md-2 col-sm-6">
                <p class="title title-footer text-white text-left">Chính sách</p>
                <?php if (!empty($custom_post['policy'])) { ?>
                    <?php foreach ($custom_post['policy'] as $i => $item) { ?>
                        <a class="name font-weight-normal mt-1" href="<?=$item['tenkhongdau']?>"><?=$item['name']?></a>
                    <?php } ?>
                <?php } ?>
                <?=$func->get_photoSelect('moit', '160x60x1', true)?>
            </div>

            <div class="col-footer col-md-3 col-sm-6">
                <p class="title title-footer text-white text-left">Fanpage</p>
                <?=$addon->addonOnline($optsetting['fanpage'], 500, 200, "fanpage-timeline")?>

                <?php /* ?>
                <p class="title title-footer text-white text-left mt-2"><?=_thongketruycap?></p>
                <div class="statistic-footer">
                    <p class="mt-2">
                        <i class="far fa-user-circle text-xl mr-1"></i>
                        Online: <span><?=$online_statistic['dangxem']?></span>
                    </p>
                    <p class="mt-2">
                        <i class="fas fa-calendar-day text-xl mr-1"></i>
                        <?=_thongketuan?>: <span><?=$result_statistic['week']?></span>
                    </p>
                    <p class="mt-2">
                        <i class="far fa-chart-bar text-xl mr-1"></i>
                        <?=_thongkethang?>: <span><?=$result_statistic['month']?></span>
                    </p>
                    <p class="mt-2">
                        <i class="fas fa-chart-line text-xl mr-1"></i>
                        <?=_tongtruycap?>: <span><?=$result_statistic['total']?></span>
                    </p>
                </div>
                <?php */ ?>
            </div>
        </div>
    </div>
</footer>

<section class="copyright text-white py-2">
    <div class="container">
        <div class="d-flex justify-content-between flex-wrap">
            <div class="info">
                Copyright @ 2021 by<span class="mx-1"><?=$optsetting['name'.$lang]?></span>All rights reserved. Design by Nina Co.,Ltd
            </div>
            <div class="statistic d-flex justify-content-start">
                <p>Online: <span><?=$online_statistic['dangxem']?></span></p>
                <p class="line mx-3">|</p>
                <p><?=_tongtruycap?>: <span><?=$result_statistic['total']?></span></p>
            </div>
        </div>
    </div>
</section>

<?php /* ?>
<?=($com != 'lien-he') ? $addon->addonOnline('iframe', 500, 400, "map") : ""?>
<?php */ ?>