<script>

//初始化
$(document).ready(function(){

	$("#btn_img_check").change(function () {
        var filepath = $("#btn_img_check").val();
        var extStart = filepath.lastIndexOf(".");
        var ext = filepath.substring(extStart, filepath.length).toUpperCase();
        if (ext != ".BMP" && ext != ".PNG" && ext != ".GIF" && ext != ".JPG" && ext != ".JPEG") {
        	$.messager.show({
		    	title:'警告',
		    	msg:'请选择.JPG,.JPEG,.PNG,.BMP,.GIF格式图片!',
		    	timeout:2000,
		    	showType:'show',
		    	border:'thin',
                style:{
                    right:'',
                    bottom:'',
                }
		    });
            return false;
        } 
        var size_limit=<?=$size?>;
        
        var file_size =this.files[0].size;
        if(file_size > size_limit )
        {
        	$.messager.show({
		    	title:'警告',
		    	msg:'选择图片'+$.filesize(file_size)+',图片大小不可超出'+$.filesize(size_limit)+'!',
		    	timeout:2000,
		    	showType:'show',
		    	border:'thin',
                style:{
                    right:'',
                    bottom:'',
                }
		    });

        	return false;
        }
        
        return true;
    });
	
	$("#img_upload").photoClip({
		width: <?=$img_w?>,
		height: <?=$img_h?>,
		file: "#btn_img_check",
		view: "#img_view",
		ok: "#btn_img_cut",
		loadStart: function() {
			console.log("照片读取中");
		},
		loadComplete: function() {
			console.log("照片读取完成");
		},
		clipFinish: function(dataURL) {
			console.log(dataURL);
		}
	});
	
});

</script>
	 
