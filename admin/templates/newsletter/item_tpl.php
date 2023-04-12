<div class="content-wrapper">
	<form class="frm-admin content" name="frm" method="post" action="<?=$send?>" enctype="multipart/form-data">
		<div class="row">
			<div class="col-12">
				<div class="card card-outline card-danger">
					<div class="card-header">
						<h3 class="card-title"><?=$config['newsletter'][$type]['title']?></h3>
					</div>

					<div class="card-header sticky-top bg-white border-bottom border-danger">
						<div class="box-control row">
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

									<?php foreach($config['newsletter'][$type]['text'] as $text => $value) { ?>
										<td class="<?=$value['col']?>"><?=$value['text']?></td>
									<?php } ?>

									<td class="act-btn">Thao tác</td>
								</tr>
							</thead>
							
							<tbody>
								<?php foreach($newsletter as $i => $items) { ?>
									<?php
	                                    if(@$items['id']) $href = "&id=".$items['id']."";
	                                    if(@$items['type']) $href .= "&type=".$items['type']."";
	                                    if(@$_REQUEST['p']) $href .= "&p=".$_REQUEST['p']."";
	                                    @$options = (isset($items['options']) && $items['options'] != '') ? json_decode($items['options'],true) : null;
	                                ?>
									<tr>
										<td>
											<a class="check" data-id="<?=$items['id']?>"></a>
										</td>

										<td class="number onchange-number form-number">
											<input type="text" class="form-control" data-id="<?=$items['id']?>" data-tbl="<?=$com?>" data-attr="number" value="<?=$items['number']?>" onkeypress="return OnlyNumber(event)">
										</td>

										<?php foreach($config['newsletter'][$type]['text'] as $text => $value) { ?>
											<td class="<?=$value['col']?>"><?=@$options[$text]?></td>
										<?php } ?>

										<td class="act-btn">
											<a onClick='alertConfirm("Bạn có chắc chắn muốn xóa?", "deleteCheck", "index.php?com=<?=$com?>&act=delete<?=$href?>");' href="javascript:"><i class="far fa-trash-alt"></i></a>
										</td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>

					<div class="pagination"><?=$paging?></div>
				</div>
				
				<?php if($config['newsletter'][$type]['send_email'] == 'true') { ?>
					<div class="card card-outline card-danger">
						<div class="card-header"><h3 class="card-title">Soạn email:</h3></div>
						<div class="card-body">
							<div class="form-group">
								<label>Chủ đề</label>
								<input class="form-control validate[required]" name="data[topic]" type="text"/>
							</div>
							<div class="form-group">
								<label>Nội dung</label>
								<textarea class="form-control editor" name="data[content]" /></textarea>
							</div>
							<div class="form-group">
								<div class="btn btn-default btn-file">
									<i class="fa fa-paperclip mr5"></i><span>File đính kèm</span>
									<input type="file" name="file">
								</div>
								<p class="help-block">Max. 5MB</p>
							</div>
						</div>
						<div class="card-footer">
							<input class="listID" type="hidden" name="data[listID]" value="">
							<button type="button" class="btn btn-primary chose-all"><i class="fa fa-envelope-o"></i> Send</button>
						</div>
					</div>
					<script>
						$(document).ready(function() {
							$(".chose-all").click(function(){
								var listID = "";
								$(".check").each(function(){
									if($(this).hasClass('active')) listID = listID + "," + $(this).attr("data-id");
								});
								listID = listID.substr(1);
								$("input.listID").val(listID);
								if(listID == "")
								{
									alert("Vui lòng chọn mail gửi");
									return false;
								}
								else
								{
									$(".frm-admin").validationEngine();
									$('.frm-admin').submit();
								}
							});
						});
					</script>
				<?php } ?>
			</div>
		</div>
	</form>
</div>