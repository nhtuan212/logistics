$(document).ready(function() {
	$('#filer-input').filer({
		limit: null,
		maxSize: null,
		extensions: null,
        changeInput: '<div class="jFiler-input-dragDrop"><div class="jFiler-input-icon"><i class="fas fa-cloud-upload-alt"></i></div><div class="jFiler-input-text"><h3>Upload here</h3></div></div>',
        showThumbs: true,
        templates: {
            box: '<ul class="jFiler-item-list jFiler-items-grid row"></ul>',
            item: '<li class="jFiler-item col-xl-6 col-lg-6 col-md-6 col-sm-3 col-6 mb-2">\
                        <div class="jFiler-item-container">\
                            <div class="jFiler-item-inner">\
                                <div class="jFiler-item-thumb">\
                                    {{fi-image}}\
                                    <ul class="list-inline">\
                                        <li><a class="jFiler-item-trash-action"><i class="far fa-trash-alt"></i></a></li>\
                                    </ul>\
                                </div>\
                                <div class="jFiler-item-info">\
                                    <span class="jFiler-item-title">{{fi-name | limitTo: 25}}</span>\
                                </div>\
                                <div class="jFiler-item-assets jFiler-row d-flex justify-content-between align-items-center">\
                                    <ul class="list-inline">\
                                        <li><span class="jFiler-item-others">{{fi-icon}} {{fi-size2}}</span></li>\
                                    </ul>\
                                </div>\
                                <div class="form-group">\
                                    <input type="text" name="number[]" class="jFiler-number form-control" placeholder="Stt"/>\
                                </div>\
                                <div class="form-group">\
                                    <input type="text" name="name[]" class="jFiler-number form-control" placeholder="Tên"/>\
                                </div>\
                            </div>\
                        </div>\
                    </li>',
            itemAppend: '<li class="jFiler-item col-xl-6 col-lg-6 col-md-6 col-sm-3 col-6 mb-2">\
                        <div class="jFiler-item-container">\
                            <div class="jFiler-item-inner">\
                                <div class="jFiler-item-thumb">\
                                	{{fi-image}}\
                                    <ul class="list-inline">\
                                        <li><a class="jFiler-item-trash-action"><i class="far fa-trash-alt"></i></a></li>\
                                    </ul>\
                                </div>\
                                <div class="jFiler-item-info">\
                                    <span class="jFiler-item-title">{{fi-name | limitTo: 25}}</span>\
                                </div>\
                                <div class="jFiler-item-assets jFiler-row d-flex justify-content-between align-items-center">\
                                    <ul class="list-inline">\
                                        <li><span class="jFiler-item-others">{{fi-icon}} {{fi-size2}}</span></li>\
                                    </ul>\
                                </div>\
                                <div class="form-group">\
                                    <input type="text" name="number[]" class="jFiler-number form-control" placeholder="Stt"/>\
                                </div>\
                                <div class="form-group">\
                                    <input type="text" name="name[]" class="jFiler-number form-control" placeholder="Tên"/>\
                                </div>\
                            </div>\
                        </div>\
                    </li>',
            progressBar: '<div class="bar"></div>',
            itemAppendToEnd: true,
            canvasImage: false,
            removeConfirmation: true,
            _selectors: {
                list: '.jFiler-item-list',
                item: '.jFiler-item',
                progressBar: '.bar',
                remove: '.jFiler-item-trash-action',
            }
        },
        addMore: true,
        allowDuplicates: true,
        clipBoardPaste: true,
        captions: {
        	button: "Thêm hình",
        	feedback: "Vui lòng chọn hình ảnh",
        	feedback2: "Những hình đã được chọn",
        	drop: "Kéo hình vào đây để upload",
        	removeConfirmation: "Bạn muốn xóa hình này ?",
        	errors: {
        		filesLimit: "Chỉ được upload mỗi lần {{fi-limit}} hình ảnh",
        		filesType: "Chỉ hỗ trợ tập tin là hình ảnh",
        		filesSize: "Hình {{fi-name}} có kích thước quá lớn. Vui lòng upload hình ảnh có kích thước tối đa {{fi-maxSize}} MB.",
        		filesSizeAll: "Những hình ảnh bạn chọn có kích thước quá lớn. Vui lòng chọn những hình ảnh có kích thước tối đa {{fi-maxSize}} MB."
        	}
        }
    });
});