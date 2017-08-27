$(function(){
	var delParent;
	var defaults = {
		fileType         : ["jpg","png","bmp","jpeg"],   // 上传文件的类型
		fileSize         : 1024 * 1024 * 10                  // 上传文件的大小 10M
	};
		/*点击图片的文本框*/
	$("#upload-input").change(function(){
		var idFile = $(this).attr("id");
		var file = document.getElementById(idFile);
		var imgContainer = $(this).parents(".image-box"); //存放图片的父亲元素
		var fileList = file.files; //获取的图片文件
		var input = $(this).parent();//文本框的父亲元素
		var imgArr = [];
		//遍历得到的图片文件
		var numUp = imgContainer.find(".image-section").length;
		var totalNum = numUp + fileList.length;  //总的数量
		if(fileList.length > 3 || totalNum > 30 ){
			alert("上传图片数目不可以超过30个");  //一次选择上传超过5个 或者是已经上传和这次上传的到的总数也不可以超过5个
		}
		else if(numUp < 50){
			fileList = validateUp(fileList);
			for(var i = 0;i<fileList.length;i++){
			 var imgUrl = window.URL.createObjectURL(fileList[i]);
			     imgArr.push(imgUrl);
			 var $section = $("<section class='image-section loading'></section>");
			     imgContainer.prepend($section);
			 var $span = $("<div class='image-shade'></div>");
			     $span.appendTo($section);
			
		     var $img0 = $("<div class='image-delete'></div>").on("click",function(event){
				    event.preventDefault();
					event.stopPropagation();
					$(".delete-mask").show();
					delParent = $(this).parent();
				});   
				$img0.appendTo($section);
		     var $img = $("<img class='image-show up-opcity' />");
		         $img.attr("src",imgArr[i]);
		         $img.appendTo($section);
		     var $input = $("<input id='src' name='src' value='' type='hidden'>");
		         $input.appendTo($section);

		      
		   }
		}
		setTimeout(function(){
             $(".image-section").removeClass("loading");
		 	 $(".image-show").removeClass("up-opcity");
		 },450);

	});
	

    $(".image-box").delegate(".image-delete","click",function(){
     	  $(".delete-mask").show();
     	  delParent = $(this).parent();
	});
		
	$(".confirm-btn").click(function(){

		$(".delete-mask").hide();

		 delParent.remove();
	});
	
	$(".cancel-btn").click(function(){
		$(".delete-mask").hide();
	});
		
	function validateUp(files){

		var arrFiles = [];//替换的文件数组
		for(var i = 0, file; file = files[i]; i++){
			//获取文件上传的后缀名
			var newStr = file.name.split("").reverse().join("");
			if(newStr.split(".")[0] != null){
					var type = newStr.split(".")[0].split("").reverse().join("");
					console.log(type+"===type===");
					if(jQuery.inArray(type, defaults.fileType) > -1){
						// 类型符合，可以上传
						if (file.size >= defaults.fileSize) {
							alert('您这个"'+ file.name +'"文件大小过大');
						} else {
							// 在这里需要判断当前所有文件中
							arrFiles.push(file);
						}
					}else{
						alert('您这个"'+ file.name +'"上传类型不符合');
					}
				}else{
					alert('您这个"'+ file.name +'"没有类型, 无法识别');
				}
		}

		return arrFiles;

	}
		
	
	
})
