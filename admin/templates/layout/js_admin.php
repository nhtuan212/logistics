<script src="<?= LIB ?>sweetalert2/sweetalert2.min.js"></script>
<script src="<?= LIB ?>bootstrap/bootstrap.bundle.min.js"></script>
<script src="<?= ASSETS ?>plugins/validationEngine/jquery.validationEngine.js"></script>
<script src="<?= ASSETS ?>plugins/validationEngine/jquery.validationEngine-vi.js"></script>
<script src="<?= ASSETS ?>plugins/holdon/HoldOn.min.js"></script>
<script src="<?= ASSETS ?>plugins/adminlte/adminlte.js"></script>

<script type="text/javascript">
	function readImage(inputFile, elementPhoto) {
		console.log(parseInt(inputFile[0].files[0].size));
		if (inputFile[0].files[0]) {
			console.log(inputFile[0].files[0].size);
			if (inputFile[0].files[0].name.match(/.(jpg|jpeg|png|gif)$/i)) {
				var size = parseInt(inputFile[0].files[0].size) / 1024;

				if (size <= 4096) {
					var reader = new FileReader();
					reader.onload = function(e) {
						elementPhoto.attr('src', e.target.result);
					}
					reader.readAsDataURL(inputFile[0].files[0]);
				} else {
					alertNotice("Dung lượng hình ảnh lớn. Dung lượng cho phép <= 4MB ~ 4096KB");
					return false;
				}
			} else {
				alertNotice("Sai định dạng hình ảnh");
				return false;
			}
		} else {
			alertNotice("Dữ liệu không hợp lệ");
			return false;
		}
	}

	function photoZone(eDrag, iDrag, eLoad) {
		if (eDrag.length) {
			/* Drag over */
			eDrag.on("dragover", function() {
				$(this).addClass("drag-over");
				return false;
			});

			/* Drag leave */
			eDrag.on("dragleave", function() {
				$(this).removeClass("drag-over");
				return false;
			});

			/* Drop */
			eDrag.on("drop", function(e) {
				e.preventDefault();
				$(this).removeClass("drag-over");

				var lengthZone = e.originalEvent.dataTransfer.files.length;

				if (lengthZone == 1) {
					iDrag.prop("files", e.originalEvent.dataTransfer.files);
					readImage(iDrag, eLoad);
				} else if (lengthZone > 1) {
					alertNotice("Bạn chỉ được chọn 1 hình ảnh để upload");
					return false;
				} else {
					alertNotice("Dữ liệu không hợp lệ");
					return false;
				}
			});

			/* File zone */
			iDrag.change(function() {
				readImage($(this), eLoad);
			});
		}
	}
	$(document).ready(function() {
		$(".photoUpload").each(function(index) {
			var childrendClass = "." + $(this).attr('data-childrendClass');
			var photozone = $(this).find(childrendClass);
			var filezone = $(this).find(childrendClass).find('input');
			var previewzone = $(this).find(childrendClass).find('img.rounded');
			photoZone(photozone, filezone, previewzone);
		});
	});
</script>

<script type="text/javascript">
	$(document).ready(function() {
		// Ẩn menu nếu không tồn tại
		$.fn.exists = function() {
			return this.length > 0;
		}
		$(".has-treeview").each(function() {
			if ($(this).find("ul").find("li").exists() == false) {
				$(this).hide();
			}
		});

		// Active Click menu
		if ($(".menu-open ul li").find('.nav-link').hasClass("active"))
			$(".menu-open ul li").parents('.menu-open').find('.nav-title').addClass('active');
		else
			$(".menu-open ul li").parents('.menu-open').find('.nav-title').removeClass('active');
	})
</script>

<?php if (@$template != 'index' && @$template != 'user/login') { ?>

	<script type="text/javascript">
		var url = "<?= @$current_url ?>";
	</script>

	<!-- Input -->
	<script type="text/javascript">
		function deleteCheck(link) {
			document.location = link;
		}

		function deleteAllCheck(list_check) {
			document.location = "<?= @$delete ?>" + "&list_check=" + list_check;
		}
		$(document).ready(function(e) {
			// Click check
			var lastChecked = null;
			var $check = $('.check');
			$check.click(function(e) {
				if ($(this).hasClass('active')) {
					$(this).removeClass('active');
					$(this).has("input[type='checkbox']")
					$(this).find("input[type='checkbox']").prop('checked', false);
				} else {
					$(this).addClass('active');
					$(this).has("input[type='checkbox']")
					$(this).find("input[type='checkbox']").prop('checked', true);
				}
				if (!lastChecked) {
					lastChecked = this;
					return;
				}
				if (e.ctrlKey) {
					var start = $check.index(this);
					var end = $check.index(lastChecked);
					$check.slice(Math.min(start, end), Math.max(start, end) + 1).addClass('active');
				}
				lastChecked = this;
			});

			// Click check all
			$("body").on("click", ".check-all", function() {
				if ($(this).hasClass('active')) {
					$(this).removeClass('active');
					$(".check").removeClass('active');
				} else {
					$(this).addClass('active');
					$(".check").addClass('active');
				}
			});

			$("body").on("click", "a.check-attr", function() {
				var id = $(this).attr("data-id");
				var tbl = $(this).attr("data-tbl");
				var attr = $(this).attr("data-attr");
				if ($(this).hasClass("active")) $(this).removeClass('active');
				else $(this).addClass('active');
				$.ajax({
					type: "POST",
					url: "ajax/ajax_attr.php",
					data: {
						id: id,
						tbl: tbl,
						attr: attr,
						action: "status"
					},
				});
			});

			$("body").on("click", "a.check-items", function() {
				var attr = $(this).attr('data-attr');
				if ($(this).hasClass("active")) {
					$(this).removeClass('active');
					$(this).find("input").val("");
				} else {
					$(this).addClass('active');
					$(this).find("input").val(attr);
				}
			});

			// Change Number
			$("body").on("change", ".onchange-number input", function() {
				var id = $(this).attr("data-id");
				var tbl = $(this).attr("data-tbl");
				var attr = $(this).attr("data-attr");
				var value = $(this).val();
				if (id != "") {
					$.ajax({
						type: "POST",
						url: "ajax/ajax_attr.php",
						data: {
							id: id,
							tbl: tbl,
							attr: attr,
							value: value
						},
					});
				}
			});

			// Delete all
			$("body").on("click", ".delete-all", function() {
				var list_check = "";

				$(".check").each(function() {
					if ($(this).hasClass('active')) list_check = list_check + "," + $(this).attr("data-id");
				});
				list_check = list_check.substr(1);
				if (list_check == "") {
					alertNotice("Bạn chưa chọn mục nào");
					return false;
				}
				alertConfirm("Bạn có chắc chắn muốn xóa?", "deleteAllCheck", list_check);
			});
		});
	</script>

	<?php if (@$config[$com][$type]['size'] == 'true') { ?>
		<!-- Size Product -->
		<script type="text/javascript">
			$(document).ready(function(e) {
				$("body").on("click", ".item-size", function() {
					var size_group = "";
					if ($(this).hasClass('active')) $(this).removeClass('active');
					else $(this).addClass('active');
					$('.item-size.active').each(function(index, element) {
						size_group += $(this).attr('data-idsize') + ",";
					});
					$(".size_group").val(size_group);
				});
			});
		</script>
	<?php } ?>

	<?php if (@$config[$com][$type]['color'] == 'true') { ?>
		<!-- Color Product -->
		<script type="text/javascript">
			$(document).ready(function(e) {
				$("body").on("click", ".item-color", function() {
					var color_group = "";
					if ($(this).hasClass('active')) $(this).removeClass('active');
					else $(this).addClass('active');
					$('.item-color.active').each(function(index, element) {
						color_group += $(this).data('idcolor') + ",";
					});
					$(".color_group").val(color_group);
				});
			});
		</script>
	<?php } ?>

	<?php if (@$config[$com][$type]['tags'] == 'true') { ?>
		<!-- Tags -->
		<script src="<?= ASSETS ?>plugins/sumoselect/sumoselect.js"></script>
		<link href="<?= ASSETS ?>plugins/sumoselect/sumoselect.css" rel="stylesheet" />
		<script type="text/javascript">
			$(document).ready(function(e) {
				window.asd = $('.SlectBox').SumoSelect({
					csvDispCount: false,
				});
			});
		</script>
	<?php } ?>

	<?php if (count($config['website']['lang']) > 1) { ?>
		<!-- Tab Lang -->
		<script type="text/javascript">
			$(document).ready(function() {
				$(".nav-tabs-custom").find(".tab-content").hide();
				$(".nav-tabs-custom").find(".nav-pills .item-tab:first a").addClass("active").show();
				$(".nav-tabs-custom").find(".tab-content:first").show();

				$('body').on("click", ".item-tab", function() {
					$('.item-tab').find('a').removeClass('active');
					$(this).find('a').addClass('active');
					$(this).parent().parent().find(".tab-content").hide();

					var lang = $(this).find("a").attr("data-lang");
					$(".content-" + lang).show();
				});
			});
		</script>
	<?php } ?>

	<?php if (@$config['photo_multi'][$type]['video'] == 'true') { ?>
		<!-- Load Video -->
		<script type="text/javascript">
			function youtube_parse(url) {
				var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
				var match = url.match(regExp);
				return (match && match[7].length == 11) ? match[7] : false;
			}
			$(document).ready(function() {
				$(".change-video").change(function() {
					var url = youtube_parse($(this).val());
					$(this).parents(".form-group").find("iframe").attr("src", "//www.youtube.com/embed/" + url).css("height", "300px");
				})
			});
		</script>
	<?php } ?>

	<?php if ((@$config[$com][$type]['gallery'] == 'true' && $level == 0) || (@$config[$com . '-lv' . $level][$type]['gallery'] == 'true' && @$level > 0)) { ?>
		<script src="<?= ASSETS ?>plugins/filer/jquery.filer.min.js" type="text/javascript"></script>
		<script src="<?= ASSETS ?>plugins/filer/custom.js" type="text/javascript"></script>
		<script src="<?= ASSETS ?>plugins/sortable/Sortable.js"></script>
		<script type="text/javascript">
			function deleteGallery(id) {
				$.ajax({
					type: "POST",
					url: "ajax/ajax_delete_gallery.php",
					data: {
						id: id
					},
					success: function(data) {
						$jdata = $.parseJSON(data);
						$(".jFiler-item-" + id).fadeOut(500);
						setTimeout(function() {
							$(".jFiler-item-" + id).remove();
						}, 1000);
					}
				})
			}

			function deleteListGallery() {
				var item = "";
				var listCheck = $(".gallery").find('input.custom-control-input:checked');
				listCheck.each(function() {
					item += $(this).val() + ",";
				});
				if (item == "") alertNotice("Vui lòng chọn mục để xóa");
				else {
					$.ajax({
						type: "POST",
						url: "ajax/ajax_delete_gallery.php",
						dataType: 'json',
						data: {
							item: item,
							"act": "deleteAll"
						},
						success: function(data) {
							arrID = data.arrID;
							for (i = 0; i < arrID.length; i++) {
								$(".jFiler-item-" + arrID[i]).fadeOut(500);
							}
						}
					});
				}
			}
			$(document).ready(function(e) {
				var parent = $(".gallery");
				var findchoseAllGallery = parent.find('.choseAllGallery');
				var findDelete = parent.find('.deleteGallery');
				var findChoseItem = parent.find('.choseItem');
				var findInput = parent.find('input.custom-control-input');

				$("body").on("click", ".choseGallery", function() {
					if (!$(this).hasClass('active')) {
						$(this).addClass('active');
						$(this).siblings('button.sortGallery').attr("disabled", true);
						findchoseAllGallery.addClass('d-inline-block');
						findDelete.addClass('d-inline-block');
						findChoseItem.addClass('d-block');
						$(this).find("i").attr("class", "far fa-check-square mr-2");
					} else {
						$(this).removeClass("active");
						$(this).siblings('button.sortGallery').attr("disabled", false);
						findchoseAllGallery.removeClass('d-inline-block active');
						findchoseAllGallery.find("i").attr("class", "far fa-square mr-2");
						findDelete.removeClass('d-inline-block');
						findChoseItem.removeClass('d-block');
						findInput.each(function() {
							$(this).prop('checked', false);
						});
						$(this).find("i").attr("class", "far fa-square mr-2");
					}
				});
				$("body").on("click", ".choseAllGallery", function() {
					if (!$(this).hasClass('active')) {
						$(this).addClass('active');
						findInput.each(function() {
							$(this).prop('checked', true);
						});
						$(this).find("i").attr("class", "far fa-check-square mr-2");
					} else {
						$(this).removeClass("active");
						findInput.each(function() {
							$(this).prop('checked', false);
						});
						$(this).find("i").attr("class", "far fa-square mr-2");
					}
				});
				$("body").on("change", ".update-gallery", function() {
					var tbl = $(this).attr("data-tbl");
					var id = $(this).attr("data-id");
					var attr = $(this).attr("data-attr");
					var value = $(this).val();
					$.ajax({
						type: "POST",
						url: "ajax/ajax_attr.php",
						data: {
							tbl: tbl,
							id: id,
							attr: attr,
							value: value
						},
					});
				});

				<?php if ($_GET['act'] == 'edit' || $_GET['act'] == 'edit_category') { ?>
					var sortable = Sortable.create(sortGallery, {
						animation: 500,
						swap: true,
						disabled: true,
						multiDrag: false,
						selectedClass: 'selected',
						fallbackTolerance: 6,
						onEnd: function() {
							var idGallery_arr = [];
							$('.jFiler-item').each(function() {
								var id = $(this).attr('data-id');
								idGallery_arr.push(id);
							});
							$.ajax({
								type: "POST",
								url: "ajax/ajax_moveGallery.php",
								dataType: 'json',
								data: {
									'id': '<?= @$_GET['id'] ?>',
									'idGallery_arr': idGallery_arr,
									'type': '<?= @$_GET['type'] ?>',
									'level': '<?= @$_GET['level'] ?>'
								},
								success: function(rs) {
									if (rs) {
										stt = rs.stt;
										id = rs.id;
										for (i = 0; i < stt.length; i++) {
											$('.jFiler-number-' + id[i]).val(stt[i]);
										}
									}
								}
							});
						},
					});
				<?php } ?>

				$("body").on("click", ".sortGallery", function() {
					var disabled = sortable.option("disabled");
					var multiDrag = sortable.option("multiDrag");
					sortable.option("disabled", !disabled);
					sortable.option("multiDrag", !multiDrag);
					if (!$(this).hasClass('active')) {
						$(this).addClass('active');
						$(this).siblings('button.choseGallery').attr("disabled", true);
						$(this).siblings('div.text-sort').html("Có thể click chọn nhiều hình để sắp xếp");
						$(this).siblings('ul.jFiler-items-grid').find('.jFiler-item').addClass('active-move');
						$(this).siblings('ul.jFiler-items-grid').find('input').attr('readonly', 'true');
						$(this).siblings('ul.jFiler-items-grid').find('a.delete-gallery').addClass("d-none");
					} else {
						$(this).removeClass('active');
						$(this).siblings('button.choseGallery').attr("disabled", false);
						$(this).siblings('div.text-sort').html("");
						$(this).siblings('ul.jFiler-items-grid').find('.jFiler-item').removeClass('active-move');
						$(this).siblings('ul.jFiler-items-grid').find('input').removeAttr('readonly', 'true');
						$(this).siblings('ul.jFiler-items-grid').find('a.delete-gallery').addClass("d-block");
					}
				});
			});
		</script>
	<?php } ?>

	<?php if (@$config['permission'] == 'true') { ?>
		<script type="text/javascript">
			function AllPermission() {
				$(".check").addClass('active');
				$(".item-permission").find("input[type='checkbox']").prop('checked', true);
			}

			function UnAllPermission() {
				$(".check").removeClass('active');
				$(".item-permission").find("input[type='checkbox']").prop('checked', false);
			}
			$(document).ready(function() {
				$("body").on("click", ".PermissionTitle", function() {
					if ($(this).hasClass('active')) {
						$(this).parents(".item-permission").find(".check-permission .check").addClass('active');
						$(this).parents(".item-permission").find(".check-permission .check input[type='checkbox']").prop('checked', true);
					} else {
						$(this).parents(".item-permission").find(".check-permission .check").removeClass('active');
						$(this).parents(".item-permission").find(".check-permission .check input[type='checkbox']").prop('checked', false);
					}
				});
			});
			$(document).ready(function() {
				$("body").on("click", ".PermissionGroup", function() {
					if ($(this).hasClass('active')) {
						$(this).parents(".card").find(".check").addClass('active');
						$(this).parents(".card").find(".check-permission .check input[type='checkbox']").prop('checked', true);
					} else {
						$(this).parents(".card").find(".check").removeClass('active');
						$(this).parents(".card").find(".check-permission .check input[type='checkbox']").prop('checked', false);
					}
				});
			});
		</script>
	<?php } ?>

	<!-- Ckeditor -->
	<script src="<?= ASSETS ?>plugins/ckeditor/ckeditor.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('.editor').each(function(index, el) {
				var name = $(this).attr('name');
				CKEDITOR.replace(name, {});
			});
		});
	</script>
<?php } ?>

<?php if (@$template == 'index') { ?>
	<script src="<?= ASSETS ?>/plugins/apexcharts/apexcharts.min.js"></script>
	<script type="text/javascript">
		var color_ = '37a000';
		var apexMixedChart;
		$(document).ready(function() {
			var options = {
				colors: ['#37a000'],
				chart: {
					id: 'apexMixedChart',
					height: 375,
					type: 'line',
					dropShadow: {
						enabled: true,
						color: '#000',
						top: 18,
						left: 7,
						blur: 10,
						opacity: 0.2
					}
				},
				series: [{
					name: 'Thống kê truy cập tháng <?= $month ?>',
					type: 'line',
					data: [
						<?php for ($i = 0; $i < count($gth); $i++) {
							echo $gth[$i];
							if ($i < count($gth) - 1) echo ",";
						} ?>
					]
				}],
				stroke: {
					curve: 'smooth'
				},
				grid: {
					borderColor: '#e7e7e7',
					row: {
						colors: ['#f3f3f3', 'transparent'],
						opacity: 0.5
					},
				},
				markers: {
					size: 1
				},
				dataLabels: {
					enabled: false
				},
				labels: [<?php for ($i = 1; $i <= $daysInMonth; $i++) : ?> 'D<?= $i ?>'
						<?php if ($i < $daysInMonth) { ?>, <?php } ?><?php endfor; ?>
						],
				legend: {
					position: 'top',
					horizontalAlign: 'right',
					floating: true,
					offsetY: -25,
					offsetX: -5
				}
			}
			apexMixedChart = new ApexCharts(document.querySelector("#apexMixedChart"), options);
			apexMixedChart.render();
			color_ = localStorage.getItem('c');
			if (null === color_) {
				apexMixedChart.updateOptions({
					colors: ['#37a000']
				});
			} else {
				apexMixedChart.updateOptions({
					colors: ['#' + color_]
				});
			}
		});
	</script>
<?php } ?>

<?php if (($source == 'attribute' && @$config['attribute'][$type]['color'] == 'true') || @$config['product']['product']['color'] == 'true') { ?>
	<script src="<?= ASSETS ?>plugins/colorpicker/jquery.minicolors.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('.colorpicker-element').each(function() {
				$(this).minicolors();
			});
			$('body').on('change', '.colorpicker-element', function(event) {
				var val = $(this).val();
				$(this).parents(".form-group").find("input.form-control").val(val);
			});
		});
	</script>
<?php } ?>

<?php if ($source == 'order') { ?>
	<script src="<?= ASSETS ?>plugins/daterangepicker/moment.min.js"></script>
	<script src="<?= ASSETS ?>plugins/daterangepicker/daterangepicker.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('.daterange').daterangepicker({
				callback: this.render,
				autoUpdateInput: false,
				locale: {
					format: 'D/M/Y',
				}
			});
			$('.daterange').on('apply.daterangepicker', function(ev, picker) {
				$(this).val(picker.startDate.format('D/M/Y') + ' - ' + picker.endDate.format('D/M/Y'));
			});
			$('.daterange').on('cancel.daterangepicker', function(ev, picker) {
				$(this).val(picker.startDate.format('D/M/Y'));
			});
		});
	</script>

	<script src="<?= ASSETS ?>plugins/rangeSlider/ion.rangeSlider.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('.rangePrice').ionRangeSlider({
				min: 0,
				max: "<?= $rangeMax ?>",
				from: "<?= ($priceFrom) ? $priceFrom : 0 ?>",
				to: "<?= ($priceTo) ? $priceTo : $rangeMax ?>",
				type: 'double',
				step: 1,
				postfix: ' đ',
				// prefix  : 'đ',
				prettify: false,
				hasGrid: true
			});
		});
	</script>
<?php } ?>

<?php if ($source == 'product') { ?>
	<script src="<?= ASSETS ?>plugins/daterangepicker/moment.min.js"></script>
	<script src="<?= ASSETS ?>plugins/daterangepicker/daterangepicker.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('.daterange').daterangepicker({
				callback: this.render,
				singleDatePicker: true,
				autoUpdateInput: false,
				locale: {
					format: 'D/M/Y',
				}
			});
			$('.daterange').on('apply.daterangepicker', function(ev, picker) {
				$(this).val(picker.startDate.format('D/M/Y'));
			});
			$('.daterange').on('cancel.daterangepicker', function(ev, picker) {
				$(this).val(picker.startDate.format('D/M/Y'));
			});
		});
	</script>
<?php } ?>

<script type="text/javascript">
	<?php if ($com == 'product' || $com == 'post') { ?>

		function onchange_<?= $_GET['type'] ?>(attr, level) {
			var get_com = "index.php?com=<?= @$_GET['com'] ?>";
			var get_act = "&act=<?= @$_GET['act'] ?>";
			var get_type = "&type=<?= @$_GET['type'] ?>";
			var get_level = "<?= @$_GET['level'] ?>";
			if (get_level) get_level = "&level=<?= @$_GET['level'] ?>";
			var url = get_com + get_act + get_type + get_level;
			var href = "";
			for (i = 0; i < level; i++) {
				href += "&id_lv" + (i + 1) + "=" + $(".id_lv" + (i + 1)).val();
			}
			var result = url + href;
			window.location = result;
		}
	<?php } ?>

	function ajax_category(tbl, attr, type, level) {
		<?php @$_GET['com'] = ($_GET['com'] == 'photo') ? "photo_multi" : $_GET['com']; ?>
		var allLevel = "<?= @$config[$_GET['com']][$type]['level'] ?>";
		var id = $("." + attr).val();
		var lv_next = parseInt(level) + 1;
		if (level > 0 && lv_next > 0) {
			$.ajax({
				url: 'ajax/ajax_category.php',
				type: "POST",
				dataType: 'html',
				data: {
					tbl: tbl,
					id: id,
					attr: attr,
					type: type,
					level: level
				},
				success: function(rs) {
					for (i = 0; i < (allLevel - level); i++) {
						$('.id_lv' + (lv_next + i)).html(rs);
					}
				}
			});
		}
	}

	function onchange_place(attr) {
		var get_com = "index.php?com=<?= @$_GET['com'] ?>";
		var get_act = "&act=<?= @$_GET['act'] ?>";
		var get_type = "&type=<?= @$_GET['type'] ?>";
		var url = get_com + get_act + get_type;
		if (attr == 'id_city' || attr == 'id_dist') {
			var href = "&id_city=" + $(".id_city").val();
			if (attr == 'id_dist') var href = href + "&id_dist=" + $(".id_dist").val();
		}
		var result = url + href;
		window.location = result;
	}

	function ajax_place(tbl, attr, title, tbl_find = "") {
		var id = $("." + attr).val();
		var type = "<?= @$_GET['type'] ?>";
		if (tbl_find != '') {
			$.ajax({
				url: 'ajax/ajax_place.php',
				type: "POST",
				dataType: 'html',
				data: {
					tbl: tbl,
					id: id,
					attr: attr,
					title: title
				},
				success: function(rs) {
					$(".id_dist").html(rs);
				}
			});
		}
	}

	function OnlyNumber(evt) {
		var charCode = (evt.which) ? evt.which : event.keyCode
		if (charCode > 47 && charCode < 58) return true;
		return false;
	}

	function EnterSearch(evt) {
		var keyword;
		if (evt.keyCode == 13 || evt.which == 13) {
			SearchAdmin(evt);
		}
	}

	function SearchAdmin(evt) {
		var keyword = $('input.keyword').val();
		window.location = url + "&keyword=" + keyword;
		return false;
	}

	function ajax_order_place(tbl, attr, title, tbl_find = "") {
		var id = $("." + attr).val();
		var type = "<?= @$_GET['type'] ?>";
		if (tbl_find != '') {
			$.ajax({
				url: 'ajax/ajax_place.php',
				type: "POST",
				dataType: 'html',
				data: {
					tbl: tbl,
					id: id,
					attr: attr,
					title: title
				},
				success: function(rs) {
					$(".id_dist").html(rs);
				}
			});
		}
	}

	function submit_admin(check = false) {
		$(".frm-admin").validationEngine();
		(check == true) ? checkSlug("submit"): $('.frm-admin').submit();
	}

	function holdOn() {
		HoldOn.open({
			theme: "sk-falding-circle",
			message: 'Vui lòng đợi trong giây lát !',
			backgroundColor: "#000",
			textColor: "white",
		});
	}

	function alertNotice(val) {
		swal.fire({
			title: "",
			text: val,
			icon: 'warning',
		});
	}

	function alertConfirm(val, addFunction, attr = "") {
		const swalWithBootstrapButtons = Swal.mixin({
			customClass: {
				confirmButton: 'btn btn-success',
				cancelButton: 'btn btn-danger mr-2',
			},
			buttonsStyling: false,
		});
		swalWithBootstrapButtons.fire({
			title: "",
			text: val,
			icon: 'warning',
			showCloseButton: false,
			showCancelButton: true,
			confirmButtonText: '<i class="fas fa-check mr-2"></i>Đồng ý',
			cancelButtonText: '<i class="fas fa-times mr-2"></i>Hủy',
			reverseButtons: true,
		}).then((result) => {
			if (result.value) {
				if (addFunction == "deleteCheck") deleteCheck(attr);
				if (addFunction == "deleteAllCheck") deleteAllCheck(attr);
				if (addFunction == "deleteGallery") deleteGallery(attr);
				if (addFunction == "deleteListGallery") deleteListGallery();
				if (addFunction == "seoCreate") seoCreate();
			}
		});
	}

	function status_update(id) {
		var id_status = $('select.status' + id).val();
		var attr = "id_status";
		var tbl = "order";
		if (id > 0 && id_status > 0) {
			$.ajax({
				type: "POST",
				url: "ajax/ajax_attr.php",
				data: {
					id: id,
					value: id_status,
					attr: attr,
					tbl: tbl
				},
				success: function(rs) {
					// document.location.href = url;
				}
			});
		}
	}

	function order_update(id, id_order) {
		var qty = $("input.quantity-" + id).val();
		$.ajax({
			type: "POST",
			url: "ajax/ajax_order.php",
			dataType: 'json',
			data: {
				id: id,
				id_order: id_order,
				qty: qty,
				act: 'update'
			},
			success: function(rs) {
				$('.total').html(rs.total);
			}
		});
	}

	function searchOrder() {
		("<?= @$_GET['p'] ?>" > 1) ? p = "&p=<?= @$_GET['p'] ?>": p = "&p=1";
		var url = "index.php?com=<?= @$_GET['com'] ?>&act=<?= @$_GET['act'] ?>" + p;
		if ($(".keyword").val() != "") url = url + "&keyword=" + $(".keyword").val();
		if ($(".daterange").val() != "") url = url + "&daterange=" + $(".daterange").val();
		if ($(".id_payments").val() != "") url = url + "&id_payments=" + $(".payments").val();
		if ($(".id_status").val() != "") url = url + "&id_status=" + $(".id_status").val();
		if ($(".id_city").val() != "") url = url + "&id_city=" + $(".id_city").val();
		if ($(".id_dist").val() != "") url = url + "&id_dist=" + $(".id_dist").val();
		if ($(".rangePrice").val() != "") url = url + "&rangePrice=" + $(".rangePrice").val();
		location.href = url;
	}
</script>

<?php if ((@$_GET['act'] == 'man' || @$_GET['act'] == 'man_category') && @$_GET['act'] != 'copy') { ?>
	<!-- Copy now -->
	<script type="text/javascript">
		function copyNow(tbl, id) {
			var com = "<?= @$_GET['com'] ?>";
			var act = "<?= @$_GET['act'] ?>";
			var type = "<?= @$_GET['type'] ?>";
			var level = "<?= @$_GET['level'] ?>";
			var p = "<?= @$_GET['p'] ?>";
			if ("<?= @$_GET['level'] ?>") level = '&level=' + level + '';
			$.ajax({
				url: 'ajax/ajax_copyNow.php',
				type: "POST",
				data: {
					tbl: tbl,
					id: id
				},
				beforeSend: function() {
					holdOn();
				},
				success: function(rs) {
					document.location.href = 'index.php?com=' + com + '&act=' + act + '&type=' + type + level + '&p=' + p;
				}
			});
		}
	</script>
<?php } ?>

<?php if (@$_GET['com'] == 'admin') { ?>
	<script type="text/javascript">
		function random(count) {
			for (var b = "", c = 0; c < count; c++) {
				b += "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890".charAt(Math.floor(Math.random() * 62));
			}
			return b;
		}

		function random_password(count) {
			var result = random(count);
			$('.form-group input[name="new-pass"]').val(result);
			$('.form-group input[name="renew-pass"]').val(result);
			$('.show-random').html(result);
		}
	</script>
<?php } ?>

<?php if (@$_GET['act'] != 'man' && @$_GET['act'] != 'man_category') { ?>
	<!-- Slug -->
	<?php (@$level < 1) ? $com = $com : $com = $com . "-lv" . $level ?>
	<?php if (@$config[$com][$type]['slug'] == true) { ?>
		<script type="text/javascript">
			function checkSlug(type) {
				var id = $("#idSlug").val();
				var name = $("#name").val();
				var slug = $("#slug").val();
				var checkBox = document.getElementById("customCheckbox1");
				var act = "<?= $_GET['act'] ?>";
				if (act == 'add' || act == 'add_category') $('.frm-admin').submit();
				if (slug) {
					$.ajax({
						url: 'ajax/ajax_slug.php',
						type: "POST",
						dataType: 'json',
						data: {
							id: id,
							name: name,
							slug: slug,
							type: type,
							act: act
						},
						success: function(rs) {
							var slug = $("#slug");
							if (type == 'check') {
								var name = $("#name");
								var checked = checkBox.checked;
								if (checked == true) {
									slug.attr("readonly", true);
									name.attr("readonly", true);
								} else {
									slug.attr("readonly", false);
									name.attr("readonly", false);
								}
							}
							if (rs.rs == 'invalid') {
								slug.val(rs.slug);
								slug.addClass("is-invalid");
								slug.removeClass("border-primary");
								$('.notification-slug').addClass("text-danger");
								$('.notification-slug').html("Đường dẫn đã tồn tại. Vui lòng nhập đường dẫn khác");
							}
							if (rs.rs == 'success') {
								if (type == 'check') slug.val(rs.slug);
								slug.addClass("is-valid");
								slug.removeClass("border-primary");
								slug.removeClass("is-invalid");
								$('.notification-slug').removeClass("text-danger");
								$('.notification-slug').addClass("text-success");
								$('.notification-slug').html("Đường dẫn hợp lệ");
								$(".current-link p span").html(rs.slug);
								if (type == 'submit') $('.frm-admin').submit();
							}
						}
					});
				} else {
					$("#slug").addClass("is-invalid");
					$("#slug").removeClass("border-primary");
					$('.notification-slug').addClass("text-danger");
					$('.notification-slug').html("Đường dẫn không được để trống");
				}
			}
		</script>
	<?php } else { ?>
		<script>
			function checkSlug(type) {
				$('.frm-admin').submit();
			};
		</script>
	<?php } ?>
<?php } ?>

<?php if (@$config[$com][$type]['seo'] == true || @$com == 'company') { ?>
	<script type="text/javascript">
		function seoExist() {
			var result = false;
			var elementSeo = $('.card-seo .form-seo');
			elementSeo.each(function(index) {
				var input = $(this).attr('id');
				value = $("#" + input).val();
				if (value) result = true;
			});
			return result;
		}

		function seoCount(obj) {
			var countseo = parseInt(obj.val().toString().length);
			countseo = (countseo) ? countseo++ : 0;
			obj.parents(".card-seo > .form-group").find("label > span").html(countseo);
		}

		function seoCreate() {
			var elementSeo = $('.card-seo .form-seo');
			elementSeo.each(function(index) {
				var element = $(this).attr('id');
				if (element != 'description-seo') {
					var text = $('#name').val();
					var count = 70;
				} else {
					var text = $('#content').val();
					var count = 160;
				}
				text = text.replace(/(<([^>]+)>)/ig, "");
				text = text.substr(0, count);
				text = text.trim();
				text = text.replace(/[\r\n]+/gm, " ");
				$("." + element).val(text);
				$(".review-" + element).html(text);
				seoCount($("." + element));
			});
		}
		// function seoChange()
		// {
		//     var elementSeo = $('.card-seo .form-seo');
		//     elementSeo.each(function(index){
		//         var element = $(this).attr('id');
		//         var val = $("#"+element);
		//         if($("#"+element).length){
		//             $('body').on("keyup","#"+element,function(){
		//                 $(".review-"+element).html(val.val());
		//             });
		//         }
		//     });
		// }

		// seoChange();
		// $(document).ready(function(){
		//     $('body').on("keyup",".title-seo, .keywords-seo, .description-seo",function(){
		//         seoCount($(this));
		//     });
		// })
	</script>
<?php } ?>

<?php if (!isset($_SESSION[$login_admin]) || ($_SESSION[$login_admin] == false)) { ?>
	<script type="text/javascript">
		$(document).ready(function(e) {
			$('body').on('click', '.show-password', function() {
				if (!$(this).hasClass('active')) {
					$(this).addClass('active');
					$(this).parent().siblings('input.password').attr('type', 'text');
					$(this).find('span').attr('class', 'far fa-eye-slash');
				} else {
					$(this).removeClass('active');
					$(this).parent().siblings('input.password').attr('type', 'password');
					$(this).find('span').attr('class', 'far fa-eye');
				}
			});

			$('body').on('click', '.loginBtn', function() {
				var username = $('.username').val();
				var password = $('.password').val();
				if (username && password) {
					$.ajax({
						type: 'POST',
						url: 'ajax/ajax_login.php',
						data: {
							'username': username,
							'password': password
						},
						dataType: 'json',
						beforeSend: function() {
							$(".username").attr("disabled", true);
							$(".password").attr("disabled", true);
							$(".loginBtn").attr("disabled", true);
							$(".show-password").addClass("disabled");
						},
						success: function(rs) {
							if (rs.success) window.location = "index.php";
							else {
								$(".username").attr("disabled", false);
								$(".password").attr("disabled", false);
								$(".loginBtn").attr("disabled", false);
								$(".show-password").removeClass("disabled");
								$("#loginError").html(rs.failed);
							}
						}
					});
				} else $('#loginError').html('Vui lòng nhập đủ thông tin !!');
				return false;
			});
		});
	</script>
<?php } ?>

<?php if (@$config['photo_static'][$type]['watermark'] == true) { ?>
	<script type="text/javascript">
		$(document).ready(function(e) {
			/* Watermark */
			$(".watermark-position label").click(function() {
				if ($(".photoUpload img").length) {
					var img = $(".photoUpload img").attr("src");
					if (img) {
						$(".watermark-position label img").attr("src", "images/noimage.png");
						$(this).find("img").attr("src", img);
						$(this).find("img").show();
					}
				} else {
					alertNotice("Dữ liệu hình ảnh không hợp lệ");
					return false;
				}
			})
		});

		/* Watermark */
		function toDataURL(url, callback) {
			var xhr = new XMLHttpRequest();
			xhr.onload = function() {
				var reader = new FileReader();
				reader.onloadend = function() {
					callback(reader.result);
				}
				reader.readAsDataURL(xhr.response);
			};
			xhr.open('GET', url);
			xhr.responseType = 'blob';
			xhr.send();
		}

		function previewWatermark() {
			$o = $("#form-watermark");
			var formData = new FormData();
			formData.append('file', $('#photo')[0].files[0]);
			formData.append('data', $o.serialize());

			$.ajax({
				type: 'POST',
				url: "index.php?com=photo&act=save-watermark&type=<?= (isset($type) && $type != '') ? $type : '' ?>",
				data: formData,
				cache: false,
				contentType: false,
				processData: false,
				dataType: "json",
				success: function(data) {
					Swal.fire({
						imageUrl: "images/ajax-loader.gif",
						customClass: {
							confirmButton: 'btn btn-sm bg-gradient-primary text-sm',
						},
						buttonsStyling: false,
						confirmButtonText: '<i class="fas fa-check mr-2"></i>Đồng ý',
						showClass: {
							popup: 'animated fadeInDown faster'
						},
						hideClass: {
							popup: 'animated fadeOutUp faster'
						}
					})

					toDataURL('index.php?com=photo&act=preview-watermark&type=<?= (isset($type) && $type != '') ? $type : '' ?>&position=' + data.position + '&img=' + data.image + '&watermark=' + data.path + '&upload=' + data.upload + '&opacity=' + data.data.opacity + '&per=' + data.data.per + '&small_per=' + data.data.small_per + '&min=' + data.data.min + '&max=' + data.data.max + "&t=" + data.time, function(dataUrl) {
						$(".swal2-image").attr("src", dataUrl);
					})
				},
				error: function(data) {
					console.log("error");
				}
			});

			return false;
		}
	</script>
<?php } ?>