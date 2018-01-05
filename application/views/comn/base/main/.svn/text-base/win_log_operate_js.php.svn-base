<!-- 加载jquery -->
<script type="text/javascript">

//初始化
$(document).ready(function(){

	//加载索引列表
	load_table_index<?=$time?>();

});

//加载流程列表
function load_table_index<?=$time?>()
{
	var no_page = '1'
		
	if('<?=$no_page?>') 
		no_page='<?=$no_page?>';

	$('#table_index<?=$time?>').attr("no_page",no_page);
		
	var col=[[    
				{field:'log_note',title:'备注',width:200,halign:'center',align:'left',sortable:true,
					formatter: fun_index_formatter<?=$time?>
				},
//				{field:'a_login_id',title:'账户',width:120,halign:'center',align:'center',sortable:true,
//					formatter: fun_index_formatter<?=$time?>
//				},
			   	{field:'log_client_ip',title:'来源IP',width:150,halign:'center',align:'center',sortable:true,
			   		formatter: fun_index_formatter<?=$time?>
			   	},
			   	{field:'log_user_agent',title:'客户端',width:200,halign:'center',align:'left',sortable:true,
			   		formatter: fun_index_formatter<?=$time?>
			   	},
				]];
	
	if('<?=$columns?>') 
	{
		col=JSON.parse(base64_decode('<?=$columns?>'));
		for(var i=0;i<col[0].length;i++)
		{
			col[0][i].formatter=fun_index_formatter<?=$time?>;
		}
	}
	
	var fcol=[[
				{field:'log_time',title:'时间',width:150,halign:'center',align:'center',sortable:true,
					formatter: fun_index_formatter<?=$time?>
				},
				{field:'c_name',title:'操作人',width:120,halign:'center',align:'center',sortable:true,
					formatter: fun_index_formatter<?=$time?>
			   	},
				{field:'log_act',title:'操作类型',width:80,halign:'center',align:'center',sortable:true,
			   		formatter: fun_index_formatter<?=$time?>
			   	},
			]]
	
	if('<?=$frozenColumns?>')
	{
		fcol=JSON.parse(base64_decode('<?=$frozenColumns?>'));
		for(var i=0;i<fcol[0].length;i++)
		{
			fcol[0][i].formatter=fun_index_formatter<?=$time?>;
		}
	}

	//数据库字段表
	$('#table_index<?=$time?>').attr("no_load",1);

	var url = 'base/main/get_json_log_operate/op_id/<?=$op_id?>';

	if('<?=$table?>') url+='/table/<?=$table?>';

	if('<?=$fun_f?>') url+='/fun_p/<?=$fun_p?>/fun_m/<?=$fun_m?>/fun_f/<?=$fun_f?>';
	
	$('#table_index<?=$time?>').datagrid({
		fit:true,
		toolbar:'#table_index_tool<?=$time?>',
		title:'操作日志',
		url:url,
		idField:'log_id',
		sort:'<?=$sort?>',
		order:'<?=$order?>',
		rownumbers:true,
		singleSelect:true,
		selectOnCheck:false,
		checkOnSelect:false,
		pagination:true,
//		nowrap:false,
		striped:true,
		border:false,
		pagePosition:'top',
		pageSize:40,
		pageList:[40,80,200],
		columns:col,
		frozenColumns:fcol,
		onBeforeLoad: function(param)
		{
			if( $(this).attr("no_load") == 1)
			return false
		},
		onLoadSuccess: function(data)
		{

			if( ! data.time )
			data.time=0;
			
			if($(this).attr("no_page") != 1)
			{
				var p=$(this).datagrid('getPager'); 
				$(p).pagination({ 
					displayMsg: '显示{from}到{to},共 {total}记录,耗时'+data.time+'s'
				}); 
			} 
			else
			{
				$('#td_page<?=$time?>').html('共'+data.total+'记录,耗时'+data.time+'s');
			}
		}
	});

	if('<?=$sort?>')
	{
		$('#table_index<?=$time?>').datagrid('sort',{
			sortName: '<?=$sort?>',
			sortOrder: '<?=$order?>'
		});
	}

	if(no_page == 1)
	{
		$('#table_index<?=$time?>').datagrid({
			view: bufferview,
			pagination:false,
		 	})
	}
	else
	{
		var p=$('#table_index<?=$time?>').datagrid('getPager'); 
		$(p).pagination({ 
			layout:['list','manual','first','prev','links','next','last'],
			afterPageText:'页，共{pages}页，'
		});  
	}

	$('#table_index<?=$time?>').datagrid('getPanel').panel({
		tools:[{
			iconCls:'icon-back',
			handler:function(){
				if('<?=$parent_id?>')
				$('#<?=$parent_id?>').tabs('select',0);
			}
		}]
	})
	
	//载入流程查询
	load_table_search<?=$time?>();

	//查询
	fun_table_search<?=$time?>();
}

//载入查询
function load_table_search<?=$time?>()
{
	var field_search_value_dispaly=JSON.parse('<?=$field_search_value_dispaly?>');
	var field_search_rule=[<?=$field_search_rule;?>]

	//载入初始查询字段
	var field_search_start='<?=$field_search_start?>'.split(',');
	
	load_table_search('table_search<?=$time?>',field_search_value_dispaly,field_search_rule,field_search_start,<?=$field_search_rule_default?>,'<?=$conf_search?>')
	
}

//列格式化输出
function fun_index_formatter<?=$time?>(value,row,index){
	value=base64_decode(value);

	if( value && this.field == 'log_time')
	{
		value='<a href="javascript:void(0);" class="link" onClick="open_win_log_data_change<?=$time?>(\''+base64_encode(JSON.stringify(row))+'\');">'+value+'</a>';
	}

	if( value && this.field == 'c_name')
	{
		var a_login_id=base64_decode(row.a_login_id)
		if(a_login_id)
			value+='['+a_login_id+']';
	}
	
	return value;
}

//查询清空
function fun_table_search_clear<?=$time?>()
{
	var rows=$('#table_search<?=$time?>').propertygrid('getRows');

	for(var i=0;i<rows.length;i++)
	{
		$('#table_search<?=$time?>').propertygrid('updateRow',{
 			index: i,
 			row: {
				value : '', 
				value_s : '' 
 			}
 		});
	}
}

//查询
function fun_table_search<?=$time?>()
{
	$('#table_index<?=$time?>').attr("no_load",0);
	
	// 排序字段
	$('#table_search<?=$time?>').propertygrid('sort', 
			{
			 sortName: 'field',
			 sortOrder: 'asc'
			}
	);    
	
	var field=$('#table_search<?=$time?>').propertygrid('getRows');
	
	//数据库字段表
	$('#table_index<?=$time?>').datagrid('load',{
		data_search: JSON.stringify(field),
	});
}

//变更
function open_win_log_data_change<?=$time?>(row)
{
	var row=JSON.parse(base64_decode(row));

	var url=base64_decode(row.log_url)+'/act/<?=STAT_ACT_VIEW?>/fun_open/tab';
	
	$('#win_log_data_change<?=$time?>').window({
		title:'变更数据',
		fit:true,    
	    border: 'thin',
	    iconCls:'icon-log',
		resizable:false,  
		draggable:false,
		minimizable:false,
		maximizable:false,
		collapsible:false,
	    modal:true,
	    inline:true,
	    href: url,
	    method: 'POST',
	    queryParams:{
	    	flag_log:1,
			log_content:base64_decode(row.log_content),
			log_time: base64_decode(row.log_time),
			log_a_login_id: base64_decode(row.a_login_id),
			log_c_name: base64_decode(row.c_name),
			log_act: base64_decode(row.log_act),
			log_note: base64_decode(row.log_note),
		}
	})
}

</script>