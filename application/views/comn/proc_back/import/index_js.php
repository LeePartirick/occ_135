<!-- 加载jquery -->
<script type="text/javascript">
//初始化
$(document).ready(function(){

	$('#win_sys_loading').window('close');
	fun_import<?=$time?>('import',1);
	
});

function fun_import<?=$time?>(btn,start)
{
	 //保存配置
	$.ajax({
        url:"<?=$url?>",
        type:"POST",
        async:false,
        data:{
			btn:btn,
			start:start
        },
        success:function(data){

			var json = JSON.parse(data);
			
			$('#bar_import<?=$time?>').width(json.per+'%');
			
			if(json.rtn == true )
			{
				
			}
			else
			{
				fun_import<?=$time?>('import',json.start)
			}
        }
	});
	
}
</script>