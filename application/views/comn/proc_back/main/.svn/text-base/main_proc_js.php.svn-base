<!-- 加载jquery -->
<script type="text/javascript">

//初始化
$(document).ready(function(){

	//加载流程列表
	load_table_proc();
	
});


//加载流程列表
function load_table_proc()
{
	var no_page = '1'
		
	if('<?=$no_page?>') 
		no_page='<?=$no_page?>';

	$('#table_proc').attr("no_page",no_page);
		
	var col=[[    
				{field:'p_class',title:'分类',width:100,halign:'center',align:'center',sortable:true,
					formatter: fun_index_proc_formatter
				},
				{field:'p_note',title:'流程描述',width:200,halign:'center',align:'left',sortable:true,
					formatter: fun_index_proc_formatter
			   	},
				{field:'db_time_create',title:'创建时间',width:150,halign:'center',align:'center',sortable:true,
			   		formatter: fun_index_proc_formatter
			   	},
				{field:'db_time_update',title:'更新时间',width:150,halign:'center',align:'center',sortable:true,
			   		formatter: fun_index_proc_formatter
			   	},
				]];
	
	if('<?=$columns?>') 
	{
		col=JSON.parse(base64_decode('<?=$columns?>'));
		for(var i=0;i<col[0].length;i++)
		{
			col[0][i].formatter=fun_index_proc_formatter;
		}
	}
	
	var fcol=[[
				{field:'op',title:'操作',width:120,halign:'center',align:'center',
					formatter: fun_index_proc_formatter
				},
				{field:'p_id',title:'p_id',width:100,halign:'center',align:'left',sortable:true,
					formatter: fun_index_proc_formatter
				},
				{field:'p_name',title:'流程名称',width:150,halign:'center',align:'left',sortable:true,
					formatter: fun_index_proc_formatter
			   	},
				{field:'p_status_run',title:'启用状态',width:80,halign:'center',align:'center',sortable:true,
			   		formatter: fun_index_proc_formatter
			   	},
			]]
	
	if('<?=$frozenColumns?>')
	{
		fcol=JSON.parse(base64_decode('<?=$frozenColumns?>'));
		for(var i=0;i<fcol[0].length;i++)
		{
			fcol[0][i].formatter=fun_index_proc_formatter;
		}
	}

	//数据库字段表
	$('#table_proc').attr("no_load",1);
	$('#table_proc').datagrid({
		fit:true,
		title:'模块列表',
		toolbar:'#table_proc_tool',
		url:'proc_back/main/get_json_proc.html',
		idField:'p_id',
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
				$('#td_proc_page').html('共'+data.total+'记录,耗时'+data.time+'s');
			}
		}
	});

	if('<?=$sort?>')
	{
		$('#table_proc').datagrid('sort',{
			sortName: '<?=$sort?>',
			sortOrder: '<?=$order?>'
		});
	}

	if(no_page == 1)
	{
		$('#table_proc').datagrid({
			view: bufferview,
			pagination:false,
		 	})
	}
	else
	{
		var p=$('#table_proc').datagrid('getPager'); 
		$(p).pagination({ 
			layout:['list','manual','first','prev','links','next','last'],
			afterPageText:'页，共{pages}页，'
		});  
	}

	//载入流程查询
	load_table_proc_search();

	//查询
	fun_table_proc_search();
}

//载入流程查询
function load_table_proc_search()
{
	var field_search_value_dispaly=JSON.parse('<?=$field_search_value_dispaly?>');
	var field_search_rule=[<?=$field_search_rule;?>]

	//载入初始查询字段
	var field_search_start='<?=$field_search_start?>'.split(',');

	load_table_search('table_proc_search',field_search_value_dispaly,field_search_rule,field_search_start,<?=$field_search_rule_default?>,'<?=$conf_search?>')
	
}

//列格式化输出
function fun_index_proc_formatter(value,row,index){
	value=base64_decode(value);

	if( this.field == 'op')
	{
		if(base64_decode(row.p_status_run) == '停用')
		return '<button href="javascript:void(0);" class="sui-btn btn-success" onClick="fun_proc_operate(\''+base64_decode(row.p_id)+'\')" style="width:60px;">启用</button>';
		else
		return '<button href="javascript:void(0);" class="sui-btn btn-warn"  onClick="fun_proc_operate(\''+base64_decode(row.p_id)+'\')" style="width:60px;">停用</button>';
	}
	
	return value;
}

//查询清空
function fun_proc_search_clear()
{
	var rows=$('#table_proc_search').propertygrid('getRows');

	for(var i=0;i<rows.length;i++)
	{
		$('#table_proc_search').propertygrid('updateRow',{
 			index: i,
 			row: {
				value : '', 
				value_s : '' 
 			}
 		});
	}
}

//流程查询
function fun_table_proc_search()
{
	$('#table_proc').attr("no_load",0);
	
	// 排序字段
	$('#table_proc_search').propertygrid('sort', 
			{
			 sortName: 'field',
			 sortOrder: 'asc'
			}
	);    
	
	var field=$('#table_proc_search').propertygrid('getRows');
	
	//数据库字段表
	$('#table_proc').datagrid('load',{
		data_search: JSON.stringify(field)
	});
}

//流程控制
function fun_proc_operate(p_id)
{
	 //保存配置
	$.ajax({
        url:"proc_back/main/fun_proc_operate.html",
        type:"POST",
        async:false,
        data:{ 
        	p_id: p_id
        },
        success:function(data){

        	alert(data);
        	var json={};
        	if(data) json=JSON.parse(data);
        	
        	var index = $('#table_proc').datagrid('getRowIndex',base64_encode(p_id));

        	var p_status_run = base64_encode(json.p_status_run)
        	
        	$('#table_proc').datagrid('updateRow',{
     			index: index,
     			row: {
        			p_status_run: p_status_run
     			}
     		});
     		
		}
    });
}

</script>