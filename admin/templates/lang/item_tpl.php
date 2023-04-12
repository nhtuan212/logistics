<div class="content-wrapper">
    <div class="d-flex">
        <div class="col-12">
            <div class="card card-outline card-danger">
                <div class="card-header">
                    <h3 class="card-title">Quản lý Ngôn ngữ</h3>
                </div>

                <div class="card-header sticky-top bg-white border-bottom border-danger">
                    <div class="box-control row">
                        <button type="button" class="btn btn-success mb-2" onclick="location.href='index.php?com=<?=$com?>&act=create'"><i class="fas fa-file-export mr-1"></i>Export file</button>
                        <button type="button" class="btn btn-primary mb-2" onclick="location.href='index.php?com=<?=$com?>&act=add'"><i class="fas fa-plus mr-1"></i>Thêm</button>
                        <button type="button" class="btn btn-danger mb-2 delete-all"><i class="far fa-trash-alt mr-1"></i>Xoá chọn</button>
                        <div class="search form-control mb-2 d-flex">
                            <input type="text" class="keyword" onKeyPress="EnterSearch(event,'keyword');" placeholder="Nhập từ khóa tìm kiếm" value="<?=isset($_GET['keyword']) ? $_GET['keyword'] : ""?>" >
                            <i class="fas fa-search bg-success" onclick="SearchAdmin();"></i>
                        </div>
                    </div>
                </div>

                <div class="card-body table-responsive table-hover p-0">
                   <table class="table">
                        <thead>
                            <tr>
                                <td class="box-all">
                                    <a class="check-all"></a>
                                </td>
                                <td class="number onchange-number">Thứ tự</td>
                                <td class="name">Alias</td>
                                <?php foreach ($config['website']['lang'] as $lang => $value) { ?>
                                    <td class="name"><?=$value?></td>
                                <?php } ?>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php for($i=0; $i<count($items); $i++) { ?>
                                <?php
                                    if(@$items[$i]['id']) $href = "&id=".$items[$i]['id']."";
                                    if(@$_REQUEST['p']) $href .= "&p=".$_REQUEST['p']."";
                                ?>
                                <tr>
                                    <td><a class="check" data-id="<?=$items[$i]['id']?>"></a></td>
                                    <td class="number onchange-number form-number">
                                        <input type="text" class="form-control" data-id="<?=$items[$i]['id']?>" data-tbl="<?=$tbl?>" data-attr="number" value="<?=$items[$i]['number']?>" onkeypress="return OnlyNumber(event)">
                                    </td>
                                    <td class="name">
                                        <a href="index.php?com=<?=$com?>&act=edit<?=$href?>"><?=$items[$i]['str']?></a>
                                        <div class="box-link d-flex justify-content-start flex-wrap">
                                            <a class="card-link text-primary" href="index.php?com=<?=$com?>&act=edit<?=$href?>"><i class="far fa-edit"></i>Edit</a>
                                            <a class="card-link text-danger" onClick='alertConfirm("Bạn có chắc chắn muốn xóa?", "deleteCheck", "index.php?com=<?=$com?>&act=delete<?=$href?>");' href="javascript:"><i class="far fa-trash-alt"></i>Delete</a>
                                        </div>
                                    </td>
                                    <?php foreach ($config['website']['lang'] as $lang => $value) { ?>
                                        <?php if($lang == "") $lang = "vi"; ?>
                                        <td class="name"><?=$items[$i]['lang'.$lang]?></td>
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