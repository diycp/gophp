(function($){
    $.fn.uploadView = function(options){

        var defaults = {

            data: null,
            url: '',
            allowType: ["gif", "jpeg", "jpg", "bmp",'png'],
            maxNum: 5,
            maxSize: 1, //设置允许上传图片的最大尺寸，单位M
            success:$.noop, //上传成功时的回调函数
            error:$.noop //上传失败时的回调函数

        };

        var thisObj = $(this);
        var config  = $.extend(defaults, options);

        var imageBox     = $(".image-box");
        var inputName    = thisObj.attr('name');

        thisObj.each(function(i){
            thisObj.change(function(){
                handleFileSelect();
            });
        });

        var handleFileSelect = function(){

            if (typeof FileReader == "undefined") {
                return false;
            }

            // 获取最新的
            var imageNum  = $('.image-section').length;

            var postUrl   = config.url;
            var maxNum    = config.maxNum;
            var maxSize   = config.maxSize;
            var allowType = config.allowType;

            if(!postUrl){
                alert('请设置要上传的服务端地址');
                return false;
            }

            if(imageNum + 1 > maxNum ){
                alert("上传图片数目不可以超过"+maxNum+"个");
                return;
            }

            var files    = thisObj[0].files;
            var fileObj  = files[0];
            var fileName = fileObj.name;
            var fileSize = (fileObj.size)/(1024*1024);

            if (!isAllowFile(fileName, allowType)) {

                alert("图片类型必须是" + allowType.join("，") + "中的一种");
                return false;

            }

            if(fileSize > maxSize){

                alert('上传图片不能超过' + maxSize + 'M，当前上传图片的大小为'+fileSize.toFixed(2) + 'M');
                return false;

            }

            createImageSection();

            ajaxUpload();

        };

        var ajaxUpload = function () {

            // 获取最新的
            var imageSection = $('.image-section');
            var imageShow    = $('.image-show:first');

            var formData = new FormData();

            var fileData = thisObj[0].files;

            if(fileData){

                // 目前仅支持单图上传
                formData.append(inputName, fileData[0]);

            }

            var postData = config.data;

            if (postData) {
                for (var i in postData) {

                    formData.append(i, postData[i]);

                }
            }

            // 上传过程中禁用上传按钮
            thisObj.attr('disabled', true);

            // ajax提交表单对象
            $.ajax({
                url: config.url,
                type: "post",
                data: formData,
                processData: false,
                contentType: false,
                success:function(json){

                    imageSection.removeClass("image-loading");

                    imageShow.removeClass("image-opcity").attr('src', json.url);

                    // 上传成功恢复上传按钮
                    thisObj.attr('disabled', false);

                    var callback = config.success;
                    callback(json);

                },
                error:function(e){

                    var callback = config.error;
                    callback(e);

                }
            });

        };

        var createDeleteModal = function () {

            var deleteModal   = $("<aside class='delete-modal'><div class='modal-content'><p class='modal-tip'>您确定要删除作品图片吗？</p><p class='modal-btn'> <span class='confirm-btn'>确定</span><span class='cancel-btn'>取消</span></p></div></aside>");
            // 创建删除模态框
            deleteModal.appendTo('.image-box');

            // 显示弹框
            $(".image-box").delegate(".image-delete","click",function(){
                deleteModal.show();
            });

            // 确认删除
            $(".confirm-btn").click(function(){

                deleteModal.hide();

            });

            // 取消删除
            $(".cancel-btn").click(function(){
                deleteModal.hide();
            });

        }

        var createImageSection = function () {

            var imageSection = $("<section class='image-section image-loading'></section>");
            var imageShade   = $("<div class='image-shade'></div>");
            var imageShow    = $("<img class='image-show image-opcity' />");
            var imageInput   = $("<input class='" + inputName + "' name='" + inputName + "[]' value='' type='hidden'>");

            var imageDelete  = $("<div class='image-delete'></div>");

            imageBox.prepend(imageSection);

            imageShade.appendTo(imageSection);

            imageDelete.appendTo(imageSection);

            imageShow.appendTo(imageSection);
            imageInput.appendTo(imageSection);

            return imageSection;

        };

        //获取上传文件的后缀名
        var getFileExt = function(fileName){
            if (!fileName) {
                return '';
            }

            var _index = fileName.lastIndexOf('.');
            if (_index < 1) {
                return '';
            }

            return fileName.substr(_index+1);
        };

        //是否是允许上传文件格式
        var isAllowFile = function(fileName, allowType){

            var fileExt = getFileExt(fileName).toLowerCase();
            if (!allowType) {
                allowType = ['jpg', 'jpeg', 'png', 'gif', 'bmp'];
            }

            if ($.inArray(fileExt, allowType) != -1) {
                return true;
            }
            return false;

        };

        createDeleteModal();

    };




})(jQuery);