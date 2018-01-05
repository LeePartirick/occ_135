<script>
//初始化
$(document).ready(function(){

	$('#table_file_list<?=$time?>').datagrid({
//		toolbar:'#table_wl_comment_tool',
		title:'关联文件',
		fit:true,
		border:false,
		view: bufferview,
//		rownumbers:true,
		singleSelect:true,
		nowrap:false,
		striped:true,
		pagination:true,
		url: 'proc_file/file/get_json/link_op_id/<?=$link_op_id?>',
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
	
});

</script>
	 
