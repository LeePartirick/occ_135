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
		{field:'db_time_create',title:'上传时间',width:150,halign:'center',align:'center',sortable:true,
			formatter: fun_index_formatter<?=$time?>
		},
		{field:'db_person_create_s',title:'上传人',width:120,halign:'center',align:'center',sortable:true,
			formatter: fun_index_formatter<?=$time?>
		},
		{field:'f_size',title:'文件大小',width:80,halign:'center',align:'right',sortable:true,
			formatter: fun_index_formatter<?=$time?>
		},
		{field:'f_type_s',title:'文件属性',width:100,halign:'center',align:'left',sortable:true,
			formatter: fun_index_formatter<?=$time?>
		},
		{field:'f_note',title:'备注',width:200,halign:'center',align:'center',sortable:true,
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
		{field:'f_id',title:'',checkbox:true,halign:'center',align:'center',
			formatter: fun_index_formatter<?=$time?>
		},
		{field:'f_name',title:'文件名',width:300,halign:'center',align:'left',sortable:true,
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

	var url = 'proc_file/file/get_json';
	url+='/link_op_id/<?=$link_op_id?>/link_op_field/<?=$field?>/link_op_table/<?=$table?>';
	
	$('#table_index<?=$time?>').datagrid({
		fit:true,
		title:'文件列表',
		toolbar:'#table_index_tool<?=$time?>',
		url:url,
		idField:'f_id',
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
		pageSize:200,
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
			pageSize:200,
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

				fun_table_search_clear<?=$time?>();
						
				if($('#hd_f_t_<?=$time?>').length > 0)
					$('#hd_f_t_<?=$time?>').val('');
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

	load_table_search('table_search<?=$time?>',field_search_value_dispaly,field_search_rule,field_search_start,<?=$field_search_rule_default?>,'<?=$conf_search?>');

}

//列格式化输出
function fun_index_formatter<?=$time?>(value,row,index){

	value=base64_decode(value);
	switch(this.field)
	{
		case 'f_name':

			var url='proc_file/file/edit/act/2/f_id/'+base64_decode(row.f_id);
			value='<a href="javascript:void(0);" class="link" onClick="fun_index_win_open<?=$time?>(\'文件-'+value+'\',\'win\',\''+url+'\');">'+value+'</a>';

			break;
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

	if($('#hd_f_t_<?=$time?>').length>0)
	{
		var str = $('#hd_f_t_<?=$time?>').val();
		
		var value = str.split(',')[0];
		var value_s = str.split(',')[1];
		var index = '';
		for(var i=0;i<field.length;i++)
		{
			if( field[i].field == 'f_type')
			{
				index = i;
				break;
			}
		}

		if( index == '' )
		{
			var rule = <?=$field_search_rule_f_type?>;
			$('#table_search<?=$time?>').propertygrid('appendRow',rule);
			index = field.length;
		}

		$('#table_search<?=$time?>').propertygrid('updateRow',{
			index: index,
			row:{
				value: value,
				value_s: value_s
			}
		});

		var field=$('#table_search<?=$time?>').propertygrid('getRows');
	}
	
	//数据库字段表
	$('#table_index<?=$time?>').datagrid('load',{
		data_search: JSON.stringify(field)
	});
}

//界面
function fun_index_win_open<?=$time?>(title,fun,url)
{
	url+='/link_op_id/<?=$link_op_id?>/link_op_field/<?=$field?>/link_op_table/<?=$table?>/search_f_t_proc/<?=$search_f_t_proc?>/flag_f_type_more/<?=$flag_f_type_more?>';

	if('<?=$fun_up?>')
	url+= '/fun_up/<?=$fun_up?>';

	if('<?=$fun_ck?>')
	url+= '/fun_ck/<?=$fun_ck?>';

	if('<?=$fun_ck?>' || '<?=$fun_up?>')
	url+= '/fun_m/<?=$fun_m?>';
	
	switch(fun)
	{
		case 'tab':
			var tab=$('#l_index_<?=$time?>').tabs('getTab',title);

			if(tab)
			{
				$('#l_index_<?=$time?>').tabs('select',title);
			}
			else
			{
				$('#l_index_<?=$time?>').tabs('add',{
					title: title,
					closable: true,
					href:url+'/fun_open/tab/fun_open_id/l_index_<?=$time?>',
					tools:[{
					        iconCls:'icon-win_max',
					        handler:function(){
								window.open(url);
								var tab =$('#l_index_<?=$time?>').tabs('getTab',title);
								var index = $('#l_index_<?=$time?>').tabs('getTabIndex',tab);
								$('#l_index_<?=$time?>').tabs('close',index);
					        }
					}]
				});
			}

			break;
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
				minimizable:true,
				maximizable:true,
				onMaximize: function()
				{
					$(this).window('close');
					$(this).window('clear');
					fun_index_win_open<?=$time?>(title,'winopen',url)
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
						$('#table_index<?=$time?>').datagrid('reload');
					
					$('#'+win_id).window('destroy');
					$('#'+win_id).remove();
				}
			})

			$('#'+win_id).window('refresh',url+'/fun_open/win/fun_open_id/'+win_id);
			$('#'+win_id).window('open')

			break;
		case 'winopen':

			window.open(url+'/fun_open/winopen');

			break;
	}
}

//编辑
function load_win_edit<?=$time?>(op_id,act)
{
	var url = 'proc_file/file/edit/act/'+act;

	if(op_id)
		url+='/f_id/'+op_id

	fun_index_win_open<?=$time?>('上传文件','win',url)
}

//批量操作
var msg_err<?=$time?>='';
function fun_operate_more_check<?=$time?>(btn)
{
	var op_list=$('#table_index<?=$time?>').datagrid('getChecked');

	if(op_list.length == 0 )
	{
		$.messager.show({
	    	title:'通知',
	    	msg:'请选择要批量操作的行！',
	    	timeout:500,
	    	showType:'show',
	    	border:'thin',
            style:{
                right:'',
                bottom:'',
            }
	    });

	    return;
	}

	var json_save={};

	switch(btn)
	{
		case 'edit':

			var url = 'proc_file/file/edit/act/2/flag_edit_more/1/fun_no_db/fun_edit_more<?=$time?>';
			url+='/link_op_id/<?=$link_op_id?>/link_op_field/<?=$field?>/link_op_table/<?=$table?>/search_f_t_proc/<?=$search_f_t_proc?>/flag_f_type_more/<?=$flag_f_type_more?>';
			
			fun_index_win_open<?=$time?>('批量编辑','win',url);
			return;
			break;
		case 'zip':
			json_save.zip = get_guid();
			break;	
	}

	$('#table_index<?=$time?>').datagrid('loading');

	var list=[];

	for(var i=0;i<op_list.length;i++)
	{
		var id=op_list[i]['f_id'];

		list.push(base64_decode(id))
	}

	list=list.join(',');
	msg_err<?=$time?>='';
	fun_operate_more<?=$time?>(list,btn,JSON.stringify(json_save))

}

//批量编辑
function fun_edit_more<?=$time?>(f_id,btn)
{
	var form_data = fun_get_data_from_f(f_id,1);

	var json_save={};

	//特殊控件标记添加
	if( form_data.f_t_parent_s_check == 1)
		form_data.f_t_parent_check = 1;

	json_save.content=form_data;
	json_save.flag_edit_more = 1;
	 
	$('#'+f_id).closest('.op_window').window('close');
	
	$('#table_index<?=$time?>').datagrid('loading');

	var op_list=$('#table_index<?=$time?>').datagrid('getChecked');
	
	var list=[];

	for(var i=0;i<op_list.length;i++)
	{
		var id=op_list[i]['f_id'];

		list.push(base64_decode(id))
	}

	list=list.join(',');
	
	msg_err<?=$time?>='';
	
	fun_operate_more<?=$time?>(list,'save',JSON.stringify(json_save))
	
}

function fun_operate_more<?=$time?>(list,btn,json_save)
{
	 //批量操作
	$.ajax({
        url:"app/run_back/proc_file/file/fun_operate_more.html",
        type:"POST",
        data:{
			list : list,
			btn : btn,
			json_save: json_save,
			msg_err: msg_err<?=$time?>
        },
        success:function(data){

        	if( ! data ) return;

            var json = JSON.parse(data);

            msg_err<?=$time?>+=json.msg_err;

            if(json.rs)
            {
            	var msg='批量操作完成！<br/><div style="font-size:12px;"><br/>'+msg_err<?=$time?>+'</div>'

            	msg_err<?=$time?>='';
            	$('#table_index<?=$time?>').datagrid('loaded');
            	$('#table_index<?=$time?>').datagrid('reload');
            	$('#table_index<?=$time?>').datagrid('clearChecked');

            	if(btn == 'zip')
            	{
            		json_save= json.json_save;
            		fun_file_download(json_save.zip+'.zip','file.zip','tmp')
            	}
            	else
            	{
            		fun_win_sys_msg('【文件批量操作】操作结果:',msg);
            	}
            }
            else
            {
            	list=json.list;
            	json_save= json.json_save;
            	fun_operate_more<?=$time?>(list,btn,json_save)
            }
		}
    });
}

//创建人
function load_db_person_create_search<?=$time?>()
{
	var row_s =  $('#table_search<?=$time?>').propertygrid('getSelected');
	var index_s = $('#table_search<?=$time?>').propertygrid('getRowIndex',row_s);
	
	var ed=$('#table_search<?=$time?>').propertygrid('getEditor',{index: index_s,field:'value'});

	if(row_s.value)
	$(ed.target).combobox('setText',row_s.value_s)
	
	$(ed.target).combobox('textbox').autocomplete({
      serviceUrl: 'base/auto/get_json_contact',
      width:'300',
      params:{
			rows:10,
//			data_search:JSON.stringify(json)
		},
      onSelect: function (suggestion) {

			$('#table_search<?=$time?>').propertygrid('updateRow',{
				index: index_s,
				row: {
					value: base64_decode(suggestion.data.c_id),
					value_s: base64_decode(suggestion.data.c_name)
				}
			});
		}
	});

	$(ed.target).combobox('textbox').focus();
}

//文件属性结束方法
function fun_end_f_type_search<?=$time?>()
{
	var row_s =  $('#table_search<?=$time?>').propertygrid('getSelected');
	var index_s = $('#table_search<?=$time?>').propertygrid('getRowIndex',row_s);
	
	var ed=$('#table_search<?=$time?>').propertygrid('getEditor',{index: index_s,field:'value'});

	var value_s = $(ed.target).combotree('getText');

	$('#table_search<?=$time?>').propertygrid('updateRow',{
		index: index_s,
		row: {
			value_s: value_s
		}
	});
}
</script>