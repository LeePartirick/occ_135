<!-- 加载jquery -->
<script type="text/javascript">

function fun_load_table_proc_list<?=$time?>(op,p_class)
{
	var opt=$(op).linkbutton('options')
	if(opt.selected)
	{
		$(op).linkbutton({selected:false})
		$(op).linkbutton('unselect')
		$(op).removeClass('l-btn-selected')
		$('#tabs_org<?=$time?>').tabs('select',0)
	}
	else
	{
		$('#tabs_org<?=$time?>').tabs('select',1)
		var tab = $('#tabs_org<?=$time?>').tabs('getTab',1)
		tab.panel('refresh', 'base/main/load_win_proc_table/p_class/'+p_class);
	}
	
}	

</script>