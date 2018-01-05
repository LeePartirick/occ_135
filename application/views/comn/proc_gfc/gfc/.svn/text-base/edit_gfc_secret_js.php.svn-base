<!-- 加载jquery -->
<script type="text/javascript">

function fun_win_gfcs_open<?=$time?>()
{
	var win_id=fun_get_new_win();

	var url = 'proc_gfc/gfc_secret/edit/act/2/gfcs_id/'+data_<?=$time?>['content[gfcs_id]']
		
	$('#'+win_id).window({
		title: '标密申请单',
		inline:true,
		modal:true,
		closed:true,
		border:'thin',
		draggable:false,
		resizable:false,
		collapsible:false,
		minimizable:false,
		maximizable:true,
		onMaximize: function()
		{
			$.messager.confirm('确认', '是否需要打开新窗口？<br>当前未保存数据不做保留！', function(r){
				if (r){
					$('#'+win_id).window('close');
					$('#'+win_id).window('clear');
					fun_index_win_open<?=$time?>(title,'winopen',url)
				}
			});
		},
		onClose: function()
		{
			$('#'+win_id).window('destroy');
			$('#'+win_id).remove();
		}
	})

	$('#'+win_id).window('refresh',url+'/fun_open/win/fun_open_id/'+win_id);
}
</script>