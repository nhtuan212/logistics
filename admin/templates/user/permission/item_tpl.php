<div class="content-wrapper">
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-danger">
                <div class="card-header">
                    <h3 class="card-title">Quản lý Phân quyền</h3>
                </div>

                <div class="card-header sticky-top bg-white border-bottom border-danger">
                    <div class="box-control row">
                        <button type="button" class="btn btn-primary" onclick="location.href='index.php?com=<?=$com?>&act=add'">Thêm</button>

                        <button type="button" class="btn btn-danger delete-all"><i class="far fa-trash-alt mr-1"></i>Xoá chọn</button>

                        <div class="search form-control d-flex">
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
                                <td class="number">Thứ tự</td>
                                <td class="name">Quyền</td>
                                <td class="attr">Hiển thị</td>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php foreach ($permission as $i => $items) { ?>
                                <?php
                                    if(@$items['id']) $href = "&id=".$items['id']."";
                                    if(@$items['type']) $href .= "&type=".$items['type']."";
                                    if(@$_REQUEST['p']) $href .= "&p=".$_REQUEST['p']."";
                                ?>
                                <tr>
                                    <td><a class="check" data-id="<?=$items['id']?>"></a></td>

                                    <td class="onchange-number form-number">
                                        <input type="text" class="form-control" data-id="<?=$items['id']?>" data-tbl="<?=$com?>" data-attr="number" value="<?=$items['number']?>" onkeypress="return OnlyNumber(event)">
                                    </td>

                                    <td class="name">
                                        <a href="index.php?com=<?=$com?>&act=edit<?=$href?>"><?=$items['name']?></a>
                                        <div class="box-link d-flex flex-wrap">
                                            <a class="card-link text-primary" href="index.php?com=<?=$com?>&act=edit<?=$href?>"><i class="far fa-edit"></i>Edit</a>
                                            <a class="card-link text-danger" onClick='alertConfirm("Bạn có chắc chắn muốn xóa?", "deleteCheck", "index.php?com=<?=$com?>&act=delete<?=$href?>");' href="javascript:"><i class="far fa-trash-alt"></i>Delete</a>
                                        </div>
                                    </td>

                                    <td class="attr">
                                        <a class="check-attr <?=(in_array('display', explode(',', $items['status']))) ? 'active' : ''?>" data-id="<?=$items['id']?>" data-tbl="<?=$tbl?>" data-attr="<?='display'?>"></a>
                                    </td>
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