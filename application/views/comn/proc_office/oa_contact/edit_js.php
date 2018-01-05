<!-- 加载jquery -->
<script type="text/javascript">

//载入数据
var data_<?=$time?>=<?=$data?>;
var arr_view<?=$time?>=<?=$field_view;?>;
var arr_edit<?=$time?>=<?=$field_edit;?>;
var arr_required<?=$time?>=<?=$field_required;?>;

//初始化
$(document).ready(function(){

	load_win_loading('win_loading<?=$time?>')

	//添加禁用
	fun_l_disable_class('tab_edit_<?=$time?>',<?=$op_disable;?>);

	load_table_offa_item<?=$time?>();
			
	setTimeout(function(){

		//添加只读，编辑,必填
		fun_form_operate('f_<?=$time?>',<?=$field_view;?>,<?=$field_edit;?>,<?=$field_required?>);
		
		//载入数据
		load_form_data_<?=$time?>();

	},500);

	//标题
	var title_conf = {};
	title_conf.fun_open ='<?=$fun_open?>';
	title_conf.fun_open_id = '<?=$fun_open_id?>';
	title_conf.title = '<?=$title;?>';
	title_conf.type = 'edit';

	fun_load_title(title_conf)
});

//载入数据
function load_form_data_<?=$time?>()
{
	$('#f_<?=$time?>').form('clear');

	//载入数据
	$('#f_<?=$time?>').form('load',data_<?=$time?>);

	//载入数据(其他控件)
	fun_form_load_data_other('f_<?=$time?>',data_<?=$time?>);

	if( ! '<?=$log_time?>') return;

	//添加日志
	var log=<?=$log?>;

	$("#hd_err_f_<?=$time?>").val(1);

	fun_show_errmsg_of_form('f_<?=$time?>',log);

	$('#f_<?=$time?>').form('enableValidation').form('validate');
}

//刷新页面
function reload_page<?=$time?>(url_reload)
{
	var url = url_reload;
	if( ! url )
		url = '<?=$url;?>';

	switch('<?=$fun_open?>')
	{
		case 'win':
			$('#<?=$fun_open_id?>').attr('reload',1);
			$('#<?=$fun_open_id?>').window('refresh',url);
			break;
		case 'tab':
			var tab =$('#<?=$fun_open_id?>').tabs('getSelected');
			tab.panel('refresh',url);
			break;
		case 'winopen':
		case '':
			window.location.href = url
			break;
	}
}

//提交数据
function f_submit_<?=$time?>(btn)
{
	$("#hd_err_f_<?=$time?>").val('');

	$('#f_<?=$time?>').form('submit',{
		url:'<?=$url;?>',
		onSubmit:function(param){

			if( btn == 'save' || btn == 'next' )
			{
				var check= $(this).form('enableValidation').form('validate');
			}
			else
			{
				var check=true;
				$(this).form('disableValidation');
			}

			if(check)
			{
				var data_form = fun_get_data_from_f('f_<?=$time?>');

				$('#win_loading<?=$time?>').window('open');

				param.btn=btn;
				param['content[offa_item]']=data_form['content[offa_item]'];

			}
			else
			{
				$(this).form('enableValidation').form('validate');

				return false;
			}

		},
		success: function(data){

			alert(data);
			$('#win_loading<?=$time?>').window('close');

			var json={};
			var act='<?=$act?>'
			if(data) json=JSON.parse(data);

			if( ! json.rtn)
			{
				$("#hd_err_f_<?=$time?>").val(1);

				if(json.err.db_time_update)
				{
					$.messager.show({
						title:'警告',
						msg: json.err.db_time_update,
						timeout:1500,
						showType:'show',
						border:'thin',
						style:{
							right:'',
							bottom:'',
						}
					});

					//刷新页面
					setTimeout("reload_page<?=$time?>();",1500);

					return;
				}

				//遍历form 错误消息添加
				fun_show_errmsg_of_form('f_<?=$time?>',json.err);

				$(this).form('enableValidation').form('validate');
			}
			else
			{
				//删除
				if(btn == 'del')
				{
					switch('<?=$fun_open?>')
					{
						case 'win':
							$('#<?=$fun_open_id?>').attr('reload',1);
							$('#<?=$fun_open_id?>').window('close');
							break;
						case 'tab':
							var tab =$('#<?=$fun_open_id?>').tabs('getSelected');
							var index = $('#<?=$fun_open_id?>').tabs('getTabIndex',tab);
							$('#<?=$fun_open_id?>').tabs('close',index);
							break;
						case 'winopen':
						case '':
							window.close();
							break;
					}
				}
				else
				{
					var url=trim('<?=$url?>','.html');

					//创建
					if('<?=$act?>'=='<?=STAT_ACT_CREATE?>')
					{
						url=url.replace('/act/1','');
						url+='/act/<?=STAT_ACT_EDIT?>/c_id/'+json.id

						reload_page<?=$time?>(url)
					}
					//编辑
					else
					{
						$.messager.show({
							title:'通知',
							msg:'操作成功！',
							timeout:500,
							showType:'show',
							border:'thin',
							style:{
								right:'',
								bottom:'',
							}
						});
						$('#f_<?=$time?> .db_time_update').val(json.db_time_update);
					}
				}
			}
		}
	});
}

//工作经历--载入
function load_table_offa_item<?=$time?>()
{
	$('#table_offa_item<?=$time?>').datagrid({
		width:'100%',
		height:'200',
		toolbar:'#table_offa_item_tool<?=$time?>',
		singleSelect:true,
		selectOnCheck:false,
		checkOnSelect:false,
		striped:true,
		idField:'offai_id',
		data: [],
		destroyMsg:{
			norecord:{    // 在没有记录选择的时候执行
				title:'警告',
				msg:'没有选择要删除的行！'
			},
			confirm:{       // 在选择一行的时候执行
				title:'确认',
				msg:'确定要删除此行吗?'
			}
		},
		columns:[[

			{field:'offai_start_info',title:'开通信息',width:150,halign:'center',align:'left',
				formatter: fun_table_offa_item_formatter<?=$time?>,
			},
			{field:'offai_end_info',title:'注销信息',width:150,halign:'center',align:'left',
				formatter: fun_table_offa_item_formatter<?=$time?>,
			},
			{field:'offai_note',title:'备注',width:150,halign:'center',align:'center',
				formatter: fun_table_offa_item_formatter<?=$time?>,
			},
		]],
		frozenColumns:[[
			{field:'offai_id',title:'',width:50,align:'center',checkbox:true},
			{field:'offai_offi_id',title:'信息系统',width:150,halign:'center',align:'left',
				formatter: fun_table_offa_item_formatter<?=$time?>,
			},
			{field:'offai_model',title:'模块',width:150,halign:'center',align:'left',
				formatter: fun_table_offa_item_formatter<?=$time?>,
			},
		]],
		rowStyler: function(index,row){
			if (row.act == <?=STAT_ACT_CREATE?>)
				return 'background:#ffd2d2';
			if (row.act == <?=STAT_ACT_REMOVE?>)
				return 'background:#e0e0e0';

		},
		onLoadSuccess: function(data)
		{
		},
		onBeginEdit: function(index,row)
		{
		},
		onEndEdit: function(index, row, changes)
		{

		}
	});

	if( arr_view<?=$time?>.indexOf('content[offa_item]')>-1 )
	{
		$('#table_offa_item_tool<?=$time?> .oa_op').hide();
	}

	switch('<?=$act?>')
	{
		case '<?=STAT_ACT_CREATE?>':

			break;
		case '<?=STAT_ACT_EDIT?>':

			break;
		case '<?=STAT_ACT_VIEW?>':

			break;
	}

	$('#table_offa_item<?=$time?>').edatagrid('freezeColumn','offai_offi_id');

}

//列格式化输出
function fun_table_offa_item_formatter<?=$time?>(value,row,index){

	switch(this.field)
	{
		case 'offai_offi_id':
			
			if(row.offai_offi_id)
				value= row.offai_offi_id_s;
			
			var url='proc_office/oa_offai/edit/act/2/fun_no_db/fun_no_db_table_offa_item<?=$time?>';

			value='<a href="javascript:void(0);" class="link" onClick="fun_table_offa_item_win_open<?=$time?>(\''+row.offai_offi_id_s.substring(0,10)+'\',\'win\',\''+url+'\',\''+row.offai_id+'\');">'+value+'</a>';
			break;
		case 'offai_start_info':
			if(row.offai_person_start)
				value = row.offai_time_start+'<br>'+row.offai_person_start_s+'开通 ';
			break;

		case 'offai_end_info':
			if(row.offai_person_end)
				value = row.offai_time_end+'<br>'+row.offai_person_end_s+'注销 ';

			break;
		default:
			if(row[this.field+'_s'])
				value = row[this.field+'_s'];
	}

	if( ! value ) value = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ;
	return '<span id="table_c_work<?=$time?>_'+index+'_'+this.field+'" class="table_c_work<?=$time?>" >'+value+'</span>';
}

//界面
function fun_table_offa_item_win_open<?=$time?>(title,fun,url,id)
{
	switch(fun)
	{
		case 'win':

			var row ={};
			if(id)
			{
				$('#table_offa_item<?=$time?>').datagrid('selectRecord',id);
				row = $('#table_offa_item<?=$time?>').datagrid('getSelected');
			}

			var win_id=fun_get_new_win();

			var params={};
			params.data_db = base64_encode(JSON.stringify(row));

			if( '<?=$log_time?>' ||  '<?=$flag_check?>')
			{
				var log_content = $('#table_c_work<?=$time?>').attr('log_content');

				if(log_content && id)
				{
					log_content = JSON.parse(log_content);

					if( ! ( id in log_content ) )
					{
						log_content[id] = {};
						log_content[id]['old'] = {};
						log_content[id]['old']['content'] = {};
					}

					JSON.parse(JSON.stringify(row), function (key, value) {
						if( ! (key in log_content[id]['old'].content) )
							log_content[id]['old'].content[key] = value
					});

					log_content[id]['new'] = {};
					log_content[id]['new'].content = row;

					params.log_content = JSON.stringify(log_content[id]);

					if( '<?=$log_time?>' )
					{
						params.flag_log = 1;
						params.log_time = '<?=$log_time?>';
						params.log_a_login_id = '<?=$log_a_login_id?>';
						params.log_c_name = '<?=$log_c_name?>';
						params.log_act = '<?=$log_act?>';
						params.log_note = '<?=$log_note?>';
					}
					else
						params.flag_check = 1;
				}
			}

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
				maximizable:false,
				method:'post',
				queryParams: params,
				onClose: function()
				{
					$('#'+win_id).window('destroy');
					$('#'+win_id).remove();
				}
			})

			$('#'+win_id).window('refresh',url+'/fun_open/win/fun_open_id/'+win_id);

			break;
	}
}

//工作经历--操作
function fun_table_offa_item_operate<?=$time?>(btn)
{
	switch(btn)
	{
		case 'add':

			$('#table_offa_item<?=$time?>').datagrid('clearSelections');

			var url = 'proc_office/oa_offai/edit/fun_no_db/fun_no_db_table_offa_item<?=$time?>/act/1/offai_c_id/<?=$c_id?>';

			url+='/c_org/'+data_<?=$time?>['content[c_org]'];
			
			fun_table_offa_item_win_open<?=$time?>('创建信息系统','win',url)

			break;
		case 'del':

			var op_list=$('#table_offa_item<?=$time?>').datagrid('getChecked');

			var row_s = $('#table_offa_item<?=$time?>').datagrid('getSelected');
			var index_s = $('#table_offa_item<?=$time?>').datagrid('getRowIndex',row_s);

			if($('#table_offa_item<?=$time?>').datagrid('validateRow',index_s))
			{
				$('#table_offa_item<?=$time?>').datagrid('endEdit',index_s);
			}
			else
			{
				$('#table_offa_item<?=$time?>').datagrid('cancelEdit',index_s);
			}

			for(var i=op_list.length-1;i>-1;i--)
			{
				var index = $('#table_offa_item<?=$time?>').datagrid('getRowIndex',op_list[i]);
				$('#table_offa_item<?=$time?>').datagrid('deleteRow',index);
			}

			break;
	}
}

function fun_no_db_table_offa_item<?=$time?>(f_id,btn)
{
	var row_s = $('#table_offa_item<?=$time?>').datagrid('getSelected');
	var row = fun_get_data_from_f(f_id,'1');

	$('#'+f_id).closest('.op_window').window('close');

	if( row_s )
	{
		var index_s = $('#table_offa_item<?=$time?>').datagrid('getRowIndex',row_s);

		if(btn == 'del')
		{
			$('#table_offa_item<?=$time?>').datagrid('deleteRow',index_s);
			return;
		}

		row.c_id = '<?=$c_id?>';
		$('#table_offa_item<?=$time?>').datagrid('updateRow',{
			index: index_s,
			row: row
		});
	}
	else
	{
		row.offai_id = get_guid();

		$('#table_offa_item<?=$time?>').datagrid('appendRow',row);
	}
}


</script>