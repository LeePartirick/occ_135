<!-- 加载jquery -->
<script type="text/javascript">

//初始化
$(document).ready(function(){

	//加载索引列表
	load_table_index<?=$time?>();

	//标题
	var title_conf = {};
	title_conf.fun_open ='<?=$fun_open?>';
	title_conf.fun_open_id = '<?=$fun_open_id?>';
	title_conf.title = '<?=$title;?>';
	title_conf.type = 'index';

	fun_load_title(title_conf)

});

//加载流程列表
function load_table_index<?=$time?>()
{

	var no_page = '1'

	if('<?=$no_page?>')
		no_page='<?=$no_page?>';

	$('#table_index<?=$time?>').attr("no_page",no_page);

	var col=[[
		{field:'sub_parent_s',title:'上级科目',width:150,halign:'center',align:'center',sortable:true,
			formatter: fun_index_formatter<?=$time?>
		},
		{field:'sub_class',title:'科目分类',width:150,halign:'center',align:'center',sortable:true,
			formatter: fun_index_formatter<?=$time?>
		},
		{field:'sub_type',title:'科目属性',width:150,halign:'center',align:'center',sortable:true,
			formatter: fun_index_formatter<?=$time?>
		},
		{field:'sub_tag',title:'标签',width:150,halign:'center',align:'left',sortable:true,
			formatter: fun_index_formatter<?=$time?>
		},
		{field:'sub_note',title:'备注',width:150,halign:'center',align:'center',sortable:true,
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
		{field:'sub_id',title:'',checkbox:true,halign:'center',align:'center',
			formatter: fun_index_formatter<?=$time?>
		},
		{field:'sub_code',title:'科目编号',width:100,halign:'center',align:'left',sortable:true,
			formatter: fun_index_formatter<?=$time?>
		},
		{field:'sub_name',title:'科目名称',width:150,halign:'center',align:'left',sortable:true,
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
	$('#table_index<?=$time?>').datagrid({
		fit:true,
		title:'预算科目列表',
		toolbar:'#table_index_tool<?=$time?>',
		url:'proc_bud/subject/get_json.html',
		idField:'sub_id',
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
		case 'sub_code':

			var url='proc_bud/subject/edit/act/2/sub_id/'+base64_decode(row.sub_id);
			value='<a href="javascript:void(0);" class="link" onClick="fun_index_win_open<?=$time?>(\'预算科目-'+value+'\',\'win\',\''+url+'\');">'+value+'</a>';

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

	//数据库字段表
	$('#table_index<?=$time?>').datagrid('load',{
		data_search: JSON.stringify(field)
	});
}

//界面
function fun_index_win_open<?=$time?>(title,fun,url)
{
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

			break;
		case 'winopen':

			window.open(url+'/fun_open/winopen');

			break;
	}
}

//编辑
function load_win_edit<?=$time?>(op_id,act)
{
	var url = 'proc_bud/subject/edit/act/'+act;

	if(op_id)
		url+='/sub_id/'+op_id

	fun_index_win_open<?=$time?>('创建预算科目','win',url)
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

    switch(btn)
    {
        case 'edit':
            fun_index_win_open<?=$time?>('批量编辑','win','proc_bud/subject/edit/act/2/flag_edit_more/1/fun_no_db/fun_edit_more<?=$time?>');
            return;
            break;
    }

	$('#table_index<?=$time?>').datagrid('loading');

	var list=[];

	for(var i=0;i<op_list.length;i++)
	{
		var id=op_list[i]['sub_id'];

		list.push(base64_decode(id))
	}

	list=list.join(',');
	msg_err<?=$time?>='';
	fun_operate_more<?=$time?>(list,btn)

}


//批量编辑
function fun_edit_more<?=$time?>(f_id,btn)
{
  var form_data = fun_get_data_from_f(f_id,1);
  var json_save={};

  //特殊控件标记添加
  if( form_data.sub_parent_s_check == 1)
      form_data.sub_parent_check = 1;

  json_save.content=form_data;
  json_save.flag_edit_more = 1;

  $('#'+f_id).closest('.op_window').window('close');

  $('#table_index<?=$time?>').datagrid('loading');

  var op_list=$('#table_index<?=$time?>').datagrid('getChecked');

  var list=[];

  for(var i=0;i<op_list.length;i++)
  {
      var id=op_list[i]['sub_id'];

      list.push(base64_decode(id))
  }

  list=list.join(',');

  msg_err<?=$time?>='';

  fun_operate_more<?=$time?>(list,'save',JSON.stringify(json_save))

}

function fun_operate_more<?=$time?>(list,btn,json_save)
{
	 //保存配置
	$.ajax({
        url:"app/run_back/proc_bud/subject/fun_operate_more.html",
        type:"POST",
        data:{
			list : list,
			btn : btn,
			json_save: json_save,
			msg_err: msg_err<?=$time?>
        },
        success:function(data){
			//alert(data)
        	if( ! data ) return;

            var json = JSON.parse(data);

            msg_err<?=$time?>+=json.msg_err;

            if(json.rs)
            {
            	var msg='批量操作完成！<br/><div style="font-size:12px;"><br/>'+msg_err<?=$time?>+'</div>'
            	fun_win_sys_msg('【预算科目批量操作】操作结果:',msg)

            	msg_err<?=$time?>='';
            	$('#table_index<?=$time?>').datagrid('loaded');
            	$('#table_index<?=$time?>').datagrid('reload');
            	$('#table_index<?=$time?>').datagrid('clearChecked');
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

//读取上级科目树
function load_sub_parent_search<?=$time?>()
{
	var row_s =  $('#table_search<?=$time?>').propertygrid('getSelected');
	var index_s = $('#table_search<?=$time?>').propertygrid('getRowIndex',row_s);

	var ed=$('#table_search<?=$time?>').propertygrid('getEditor',{index: index_s,field:'value'});

	if(row_s.value)
		$(ed.target).combobox('setText',row_s.value_s)

	$(ed.target).combobox('textbox').autocomplete({
		serviceUrl: 'proc_bud/subject/get_json',
		width:'300',
		params:{
			rows:10
		},
		onSelect: function (suggestion) {

			$('#table_search<?=$time?>').propertygrid('updateRow',{
				index: index_s,
				row: {
					value: base64_decode(suggestion.data.sub_id),
					value_s: base64_decode(suggestion.data.sub_name)
				}
			});
		}
	});

	$(ed.target).combobox('textbox').focus();
}
</script>