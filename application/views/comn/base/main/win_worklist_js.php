<script>
//初始化
$(document).ready(function(){

	$('#table_wl_comment<?=$time?>').datagrid({
//		toolbar:'#table_wl_comment_tool',
		title:'审批信息',
		fit:true,
		border:false,
		view: bufferview,
//		rownumbers:true,
		singleSelect:true,
		nowrap:false,
		striped:true,
		pagination:true,
		url: 'base/main/get_json_wl_comment/op_id/<?=$op_id?>/pp_id/<?=$pp_id?>',
		pageSize:40,
		showHeader:false,
		columns:[[
			{field:'wl_log_note',title:'',width:'100%',halign:'center',align:'left',
				formatter: function(value,row,index)
				{
					if( row.wl_comment)
					row.wl_comment=base64_decode(row.wl_comment);
					return '<p>'+row.wl_time_do+' '+row.c_name+'['+row.c_login_id+']</p><p>'+row.wl_log_note+'</p>'+row.wl_comment;
				}
			},
		]],
		onLoadSuccess: function(data)
		{
			$('#table_wl_comment<?=$time?>').datagrid('getPanel').removeClass('lines-both lines-no lines-right lines-bottom').addClass('lines-no');
		},
	})

	$('#table_wl_comment<?=$time?>').datagrid('getPanel').panel({
		tools:[{
			iconCls:'icon-back',
			handler:function(){
				if('<?=$parent_id?>')
				$('#<?=$parent_id?>').tabs('select',0);
			}
		}]
	})
	
});

</script>
	 
