<div class="content-wrapper">
    <div class="d-flex">
        <div class="col-12">
            <div class="card card-outline card-danger">
                <div class="card-header">
                    <h3 class="card-title"><?=$config[$com."-lv".$level][$type]['title']?></h3>
                </div>

                <div class="card-header sticky-top bg-white border-bottom border-danger">
                    <div class="box-control row">
                        <button type="button" class="btn btn-primary mb-2"><a href="index.php?com=<?=$com?>&act=add_category&type=<?=$type?>&level=<?=$level?>"><i class="fas fa-plus mr-1"></i>Thêm</a></button>

                        <button type="button" class="btn btn-danger delete-all mb-2"><i class="far fa-trash-alt mr-1"></i>Xoá chọn</button>

                        <div class="search form-control d-flex mr-2 mb-2">                       
                            <input type="text" class="keyword" onKeyPress="EnterSearch(event,'keyword');" placeholder="Nhập từ khóa tìm kiếm" value="<?=isset($_GET['keyword']) ? $_GET['keyword'] : ""?>" >
                            <i class="fas fa-search bg-success" onclick="SearchAdmin();"></i>
                        </div>
                    </div>
                </div>

                <div class="card-body table-responsive table-hover p-0">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <td class="box-all"><a class="check-all"></a></td>

                                <td class="number">Thứ tự</td>
                                
                                <?php for($i=0; $i < $level-1; $i++) { ?>
                                    <td class="category">
                                        <?=get_link_category($tbl, "id_lv".($i+1)."", $i+1)?>
                                    </td>
                                <?php } ?>

                                <?php if($config[$com.'-lv'.$level][$type]['photo']=='true') { ?>
                                    <td class="img">Hình ảnh</td>
                                <?php } ?>

                                <td class="name">Tên</td>

                                <?php foreach($config[$com.'-lv'.$level][$type]['attr'] as $attr => $attr_value) { ?>
                                    <td class="attr"><?=$attr_value?></td>
                                <?php } ?>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php foreach($category as $i => $items) { ?>
                                <?php
                                    if(@$items['id']) $href = "&id=".$items['id']."";
                                    if(@$items['type']) $href .= "&type=".$items['type']."";
                                    if(@$items['level']) $href .= "&level=".$items['level']."";
                                    if(@$items['id_lv1']) $href .= "&id_lv1=".$items['id_lv1']."";
                                    if(@$items['id_lv2']) $href .= "&id_lv2=".$items['id_lv2']."";
                                    if(@$items['id_lv3']) $href .= "&id_lv3=".$items['id_lv3']."";
                                    if(@$_REQUEST['p']) $href .= "&p=".$_REQUEST['p']."";
                                ?>
                                <tr>
                                    <td><a class="check" data-id="<?=$items['id']?>"></a></td>

                                    <td class="number onchange-number form-number">
                                        <input type="text" class="form-control" data-id="<?=$items['id']?>" data-tbl="<?=$tbl?>" data-attr="number" value="<?=$items['number']?>" onkeypress="return OnlyNumber(event)">
                                    </td>

                                    <?php if($level > 1) { ?>
                                        <?php for($j=1; $j < $level; $j++) { ?>
                                            <td class="category">
                                                <?php
                                                    @$category = $d->rawQueryOne("select name$lang as name from #_category where id=?", array($items['id_lv'.$j]));
                                                    echo $category['name'];
                                                ?>
                                            </td>
                                        <?php } ?>
                                    <?php } ?>
                                    
                                    <?php if($config[$com.'-lv'.$level][$type]['photo']=='true') { ?>
                                        <td class="img">
                                            <a href="index.php?com=<?=$com?>&act=edit_category<?=$href?>">
                                                <?=$func->get_photo(array('dir' => DIR_CATEGORY,'photo' => $items['photo'],'name' => $items['name'],'resize' => $resize,)); ?>
                                            </a>
                                        </td>
                                    <?php } ?>

                                    <td class="name">
                                        <a href="index.php?com=<?=$com?>&act=edit_category<?=$href?>"><?=$items['name']?></a>

                                        <div class="box-link d-flex flex-wrap">
                                            <?php if($config[$com.'-lv'.$level][$type]['view']=='true') { ?>
                                                <a class="card-link text-primary" href="<?=$config_url_http.$items['tenkhongdau']?>" target="blank"><i class="far fa-eye"></i>View</a>
                                            <?php } ?>
                                            <a class="card-link text-primary" href="index.php?com=<?=$com?>&act=edit_category<?=$href?>"><i class="far fa-edit"></i>Edit</a>
                                            <a class="card-link text-danger" onClick='alertConfirm("Bạn có chắc chắn muốn xóa?", "deleteCheck", "index.php?com=<?=$com?>&act=delete_category<?=$href?>");' href="javascript:"><i class="far fa-trash-alt"></i>Delete</a>
                                            <?php if(@$config['developer']['copy']=='true') { ?>
                                                <li class="card-link dropdown">
                                                    <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="text-success dropdown-toggle"><i class="far fa-copy"></i>Copy</a>
                                                    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow" style="left: 0px; right: inherit;">
                                                        <li><a href="#" class="dropdown-item" onclick="copyNow('<?=$tbl?>', '<?=$items['id']?>')"><i class="fas fa-caret-right"></i>Sao chép ngay</a></li>
                                                        <li class="dropdown-divider"></li>
                                                        <li><a href="index.php?com=<?=$com?>&act=copy_category<?=$href?>" class="dropdown-item"><i class="fas fa-caret-right"></i>Sao chép chỉnh sửa</a></li>
                                                    </ul>
                                                </li>
                                            <?php } ?>
                                        </div>
                                    </td>

                                    <?php foreach($config[$com.'-lv'.$level][$type]['attr'] as $attr => $attr_value) { ?>
                                        <td class="attr">
                                            <a class="check-attr <?=(in_array($attr, explode(',', $items['status']))) ? 'active' : ''?>" data-id="<?=$items['id']?>" data-tbl="<?=$tbl?>" data-attr="<?=$attr?>"></a>
                                        </td>
                                    <?php } ?>
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