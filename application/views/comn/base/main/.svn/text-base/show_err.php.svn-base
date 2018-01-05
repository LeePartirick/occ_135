<!--<div class="easyui-window div_filter" 
	 data-options="title:'错误提示',
	 			   width:500,
	 			   height:'auto',
	 			   resizable:false,
	 			   maximizable:false,
	 			   minimizable:false,
	 			   border:'thin',
	 			   collapsible:false">
<center>
<div class="img-err" style="height:32px;width:32px;margin:30px;"> </div>
<p style="font-size:15px;"><?=$msg;?>
</center>
</div>

-->
<script type="text/javascript">

//初始化
$(document).ready(function(){

	$.alert({title: '<div class="sui-msg msg-large msg-naked <?=$icon?>"><div class="msg-con">信息提示</div><s class="msg-icon"></s></div>',body:'<?=$msg;?>'});
	
	switch('<?=$fun_open?>')
	{
		case 'winopen':
		case '':
		
		break;
		case 'tab':
//			var  tab = $('#<?=$fun_open_id?>').tabs('getSelected');
//			var index = $('#<?=$fun_open_id?>').tabs('getTabIndex',tab);
//			$('#<?=$fun_open_id?>').tabs('close',index);
		break;
		case 'win':
			$('#<?=$fun_open_id?>').window('destroy');
			$('#<?=$fun_open_id?>').remove();
		break;
	}
});
</script>