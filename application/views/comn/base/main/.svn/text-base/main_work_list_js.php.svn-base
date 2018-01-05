<!-- 加载jquery -->
<script type="text/javascript">

//界面
function fun_index_win_open<?=$time?>(title,fun,url,type)
{
	switch(fun)
	{
		case 'win':

			var win_id=fun_get_new_win();

			$('#'+win_id).window({
				title: 'title',
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
				onMinimize: function()
				{
					$(this).window('close');
					$(this).window('clear');
					fun_index_win_open<?=$time?>(title,'tab',url)
				},
				onClose: function()
				{
					if($('#'+win_id).attr('reload') == 1)
					{
						$('#table_wlist_'+type+'<?=$time?>').datagrid('reload');
						switch(type)
						{
							case 'to_do':
								$('#table_wlist_have_do<?=$time?>').datagrid('reload');
								break;
						}
					}
					
					$('#'+win_id).window('destroy');
					$('#'+win_id).remove();
				}
			})
			

			$('#'+win_id).window('refresh',url+'/flag_wl_win/1/fun_open/win/fun_open_id/'+win_id);

			break;
		case 'winopen':

			window.open(url+'/fun_open/winopen');

			break;
	}
}

//待办事项
function load_table_wlist_to_do<?=$time?>()
{
	$('#table_wlist_to_do<?=$time?>').datagrid({
		toolbar:'#table_wlist_to_do_tool<?=$time?>',
		fit:true,
		border:false,
		view: bufferview,
//		rownumbers:true,
		singleSelect:true,
//		nowrap:false,
		striped:true,
		pagination:false,
		url: 'base/main/get_json_win_work_list',
		pageSize:100,
		columns:[[
			{field:'wl_code',title:'单据编号',width:120,halign:'center',align:'left',sortable:true,
				formatter: function(value,row,index)
				{
					value='<a href="javascript:void(0);" class="link" onClick="fun_index_win_open<?=$time?>(\'待办事项-'+value+'\',\'win\',\''+row.wl_url+'\',\'to_do\');">'+value+'</a>';
					return value;
				}
			},
			{field:'db_time_create',title:'生成时间',width:150,halign:'center',align:'center',sortable:true,
			},
			{field:'c_name',title:'发送人',width:150,halign:'center',align:'center',sortable:true,
			},
			{field:'wl_event',title:'事务',width:100,halign:'center',align:'left',
			},
			{field:'wl_note',title:'工单简述',width:250,halign:'center',align:'left',
				formatter: function(value,row,index)
				{
					return base64_decode(value);
				}
			},
		]],
//		rowStyler: function(index,row){
//			return 'background-color:#FFECEC;';
//		},
		onLoadSuccess: function(data)
		{
			if( ! data.time )
			data.time=0;
			
			$('#table_wlist_to_do_tool<?=$time?> .table_page').html('共'+data.total+'记录,耗时'+data.time+'s')

			$('.wl_to_do').hide();
			if(data.total > 0)
			{
				$('.wl_to_do').show();
				$('.wl_to_do').html(data.total);
			}
		},
	})
}

//已办事项
function load_table_wlist_have_do<?=$time?>()
{
	$('#table_wlist_have_do<?=$time?>').datagrid({
			toolbar:'#table_wlist_have_do_tool<?=$time?>',
			fit:true,
			border:false,
			view: bufferview,
//			rownumbers:true,
			singleSelect:true,
//			nowrap:false,
			striped:true,
			pagination:false,
			url: 'base/main/get_json_win_work_list/wl_type/finish',
			pageSize:100,
			columns:[[
				{field:'wl_code',title:'单据编号',width:120,halign:'center',align:'left',sortable:true,
					formatter: function(value,row,index)
					{
						value='<a href="javascript:void(0);" class="link" onClick="fun_index_win_open<?=$time?>(\'已办事项-'+value+'\',\'win\',\''+row.wl_url+'\',\'have_do\');">'+value+'</a>';
						return value;
					}
				},
				{field:'wl_time_do',title:'处理时间',width:150,halign:'center',align:'center',sortable:true,
				},
				{field:'c_name',title:'发送人',width:150,halign:'center',align:'center',sortable:true,
				},
				{field:'wl_event',title:'事务',width:100,halign:'center',align:'left',
				},
				{field:'wl_note',title:'工单简述',width:250,halign:'center',align:'left',
					formatter: function(value,row,index)
					{
						return base64_decode(value);
					}
				},
			]],
			onLoadSuccess: function(data)
			{
				if( ! data.time )
				data.time=0;
				
				$('#table_wlist_have_do_tool<?=$time?> .table_page').html('共'+data.total+'记录,耗时'+data.time+'s')

			},
		})
}

//已结事项
function load_table_wlist_end<?=$time?>()
{
	$('#table_wlist_end<?=$time?>').datagrid({
		toolbar:'#table_wlist_end_tool<?=$time?>',
		fit:true,
		border:false,
		view: bufferview,
		url: 'base/main/get_json_win_work_list/wl_type/end',
//		rownumbers:true,
		singleSelect:true,
//		nowrap:false,
		striped:true,
		pagination:false,
		pageSize:100,
		columns:[[
			{field:'wl_code',title:'单据编号',width:120,halign:'center',align:'left',sortable:true,
				formatter: function(value,row,index)
				{
					value='<a href="javascript:void(0);" class="link" onClick="fun_index_win_open<?=$time?>(\'已结事项-'+value+'\',\'win\',\''+row.wl_url+'\',\'end\');">'+value+'</a>';
					return value;
				}
			},
			{field:'db_time_create',title:'创建时间',width:150,halign:'center',align:'center',sortable:true,
			},
			{field:'c_name',title:'创建人',width:150,halign:'center',align:'center',sortable:true,
			},
			{field:'db_time_run',title:'流转时间',width:150,halign:'center',align:'center',
			},
			{field:'wl_note',title:'工单简述',width:250,halign:'center',align:'left',
				formatter: function(value,row,index)
				{
					return base64_decode(value);
				}
			},
		]],
		onLoadSuccess: function(data)
		{
			if( ! data.time )
			data.time=0;
			
			$('#table_wlist_end_tool<?=$time?> .table_page').html('共'+data.total+'记录,耗时'+data.time+'s')

			if(data.num_news == 0)
			$('.wl_end').hide();

			if(data.num_news > 0)
			{
				$('.wl_end').show();
				$('.wl_end').html(data.num_news);
			}
		},
	})

	$('#table_wlist_end<?=$time?>').datagrid('reload','base/main/get_json_win_work_list/wl_type/end')
}

//我的请求
function load_table_wlist_i<?=$time?>()
{
	$('#table_wlist_i<?=$time?>').datagrid({
		toolbar:'#table_wlist_i_tool<?=$time?>',
		fit:true,
		border:false,
		view: bufferview,
//		rownumbers:true,
		singleSelect:true,
//		nowrap:false,
		striped:true,
		pagination:false,
		url: 'base/main/get_json_win_work_list/wl_type/<?=WL_TYPE_I?>',
		pageSize:100,
		columns:[[
			{field:'wl_code',title:'单据编号',width:120,halign:'center',align:'left',sortable:true,
				formatter: function(value,row,index)
				{
					value='<a href="javascript:void(0);" class="link" onClick="fun_index_win_open<?=$time?>(\'我的请求-'+value+'\',\'win\',\''+row.wl_url+'\',\'i\');">'+value+'</a>';
					return value;
				}
			},
			{field:'db_time_update',title:'更新时间',width:150,halign:'center',align:'center',sortable:true,
			},
			{field:'wl_note',title:'工单简述',width:250,halign:'center',align:'left',
				formatter: function(value,row,index)
				{
					return base64_decode(value);
				}
			},
			{field:'wl_log_note',title:'最新日志',width:250,halign:'center',align:'left',
				formatter: function(value,row,index)
				{
					return base64_decode(value);
				}
			},
		]],
		onLoadSuccess: function(data)
		{

			if( ! data.time )
			data.time=0;
			
			$('#table_wlist_i_tool<?=$time?> .table_page').html('共'+data.total+'记录,耗时'+data.time+'s')

			$('.wl_i').hide();
			if(data.total > 0)
			{
				$('.wl_i').show();
				$('.wl_i').html(data.total);
			}
		},
	})
}

//我的关注
function load_table_wlist_care<?=$time?>()
{
	$('#table_wlist_care<?=$time?>').datagrid({
		toolbar:'#table_wlist_care_tool<?=$time?>',
		fit:true,
		border:false,
		view: bufferview,
//		rownumbers:true,
		singleSelect:true,
//		nowrap:false,
		striped:true,
		pagination:false,
		url: 'base/main/get_json_win_work_list/wl_type/care',
		pageSize:100,
		columns:[[
			{field:'wl_code',title:'单据编号',width:120,halign:'center',align:'left',sortable:true,
				formatter: function(value,row,index)
				{
					value='<a href="javascript:void(0);" class="link" onClick="fun_index_win_open<?=$time?>(\'我的关注-'+value+'\',\'win\',\''+row.wl_url+'\',\'care\');">'+value+'</a>';
					return value;
				}
			},
			{field:'db_time_update',title:'更新时间',width:150,halign:'center',align:'center',sortable:true,
			},
			{field:'wl_note',title:'工单简述',width:250,halign:'center',align:'left',
				formatter: function(value,row,index)
				{
					return base64_decode(value);
				}
			},
			{field:'wl_log_note',title:'最新日志',width:250,halign:'center',align:'left',
				formatter: function(value,row,index)
				{
					return base64_decode(value);
				}
			},
			{field:'c_name',title:'创建人',width:150,halign:'center',align:'center',sortable:true,
			},
		]],
		onLoadSuccess: function(data)
		{
			if( ! data.time )
			data.time=0;

			$('#table_wlist_care_tool<?=$time?> .table_page').html('共'+data.total+'记录,耗时'+data.time+'s')
			
			$('.wl_care').hide();
			if(data.total > 0)
			{
				$('.wl_care').show();
				$('.wl_care').html(data.total);
			}
		}
	})
}

</script>