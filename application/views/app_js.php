<!-- 加载jquery -->
<script type="text/javascript">

//初始化
$(document).ready(function(){

	//判断html5是否可使用
	if (typeof(Worker) !== "undefined")   
    {   
		//载入主界面	
		$("#p_main").panel({
			border:false,
			loadingMessage:'',
			href:"<?=$url;?>",
			onLoadError: function()
			{
				$("#p_main").panel('refresh','app/show_404.html');
			}
		});

    }  
	else
	{
		alert("该浏览器不支持html5！请使用可以运行html5的浏览器！");   
	}	
	
})
	
</script>