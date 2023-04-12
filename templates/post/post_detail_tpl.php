<h3 class="title"><?=$title?></h3>

<?php if(empty($post_detail['content'])) { ?>
    <div class="empty-page">** Nội dung đang được cập nhật ...</div>
<?php } ?>

<aside><?=$func->decode($post_detail['content'])?></aside>
<div class="share-toolbox"></div>

<?php if(count($post) > 0) { ?>
    <p class="title"><?=$title_other?></p>
    <div class="row">
        <?php foreach ($post as $i => $item) {
            $funcLayout->setTbl('post');
            $funcLayout->setClass('item-custom item-post');
            $funcLayout->setHvr('hvr-opa');
            $funcLayout->infoTheme('post');
            $funcLayout->item($item);
            $funcLayout->setType($type);
            $funcLayout->setImage($theme->getDir(), $theme->getColumn(), $theme->getResize());
            echo $funcLayout->getTheme();
        } ?>
    </div>
    <div class="pagination"><?=$paging?></div>
<?php } ?>