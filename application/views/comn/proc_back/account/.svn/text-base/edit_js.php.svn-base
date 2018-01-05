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

	//载入角色列表
	load_table_role<?=$time?>();
	
	setTimeout(function(){
		
		//添加只读，编辑,必填
		fun_form_operate('f_<?=$time?>',arr_view<?=$time?>,arr_edit<?=$time?>,arr_required<?=$time?>);

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
				
				param['content[role]']=data_form['content[role]'];
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

				if(json.err.msg)
				{
					$.messager.show({
				    	title:'警告',
				    	msg: json.err.msg,
				    	timeout:5000,
				    	showType:'show',
				    	border:'thin',
		                style:{
		                    right:'',
		                    bottom:'',
		                }
				    });
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
							$('#<?=$fun_open_id?>').window('close');
							$('#<?=$fun_open_id?>').window('destroy');
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
						url+='/act/<?=STAT_ACT_EDIT?>/a_id/'+json.id

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

//载入关联角色
function load_table_role<?=$time?>()
{
	$('#txtb_search_role<?=$time?>').combobox({
		width:'200',
		panelHeight:0,
		hasDownArrow:false,
		buttonIcon:'icon-clear',
		onClickButton:function()
		{
			$(this).combobox('clear');
		},
		icons: [{
			iconCls:'icon-search',
			handler: function(e){
			
				var id = $(e.data.target).combobox('getValue');

				var index=$('#table_role<?=$time?>').datalist('getRowIndex',id);

				if(index > -1)
				{
					$('#table_role<?=$time?>').datalist('scrollTo',index);
					$('#table_role<?=$time?>').datalist('selectRow',index);
				}
			}
		}]
	})
	
	$('#txtb_search_role<?=$time?>').combobox('textbox').autocomplete({
        serviceUrl: 'proc_back/role/get_json.html',
        width:'auto',
        onSelect: function (suggestion) {

			$(this).parent().prev().combobox('setValue',base64_decode(suggestion.data.role_id));
			$(this).parent().prev().combobox('setText',base64_decode(suggestion.data.role_name));
			
			var index=$('#table_role<?=$time?>').datalist('getRowIndex',base64_decode(suggestion.data.role_id));
	
			if(index > -1)
			{
				$('#table_role<?=$time?>').datalist('scrollTo',index);
				$('#table_role<?=$time?>').datalist('selectRow',index);
			}
		}
	});
	
	$('#table_role<?=$time?>').edatagrid({    
		width:'100%',
		height:'200',
		toolbar:'#table_role_tool<?=$time?>',
		singleSelect:true,
		selectOnCheck:false,
		checkOnSelect:false,
		striped:true,
//		autoSave:true,
		idField:'role_id',
		data: [],
		destroyMsg:{
			norecord:{    // 在没有记录选择的时候执行
				title:'警告',
				msg:'没有选择要删除的行！'
			},
			confirm:{       // 在选择一行的时候执行		
				title:'确认',
				msg:'确定要删除此行吗?',
			}
		},
		columns:[[    
		    {field:'ra_id',title:'',width:50,align:'center',checkbox:true,
		     formatter: fun_role_index_formatter<?=$time?>
	    	},
		    {field:'role_id',title:'角色',width:150,halign:'center',align:'left',
             formatter: fun_role_index_formatter<?=$time?>
		    },
		    {field:'ra_note',title:'备注',width:400,halign:'center',align:'left',
			 editor:{
			   type:'textbox',
			   options:{
			    	buttonIcon:'icon-clear',
					onClickButton:function()
					{
						$(this).textbox('clear');
					}
				}
			 },
			 formatter: fun_role_index_formatter<?=$time?>
            } 
		]],
		onBeginEdit: function(index,row)
		{
		},
		onEndEdit: function(index, row, changes)
		{
		}
	});  

	if( arr_view<?=$time?>.indexOf('content[role]')>-1 )
	{
		$('#table_role<?=$time?>').edatagrid('disableEditing');
		$('#table_role_tool<?=$time?> .oa_op').hide();
	}
}

//列格式化输出
function fun_role_index_formatter<?=$time?>(value,row,index){

	var value_s = value;
	switch(this.field)
	{
		case 'role_id':
			value_s = row.role_s;
			break;
	}

	return value_s;
}

//操作关联角色
function fun_table_role_operate<?=$time?>(btn)
{
	switch(btn)
	{
		case 'add':

			var url = 'proc_back/role/index';

			var win_id=fun_get_new_win()
	    	
			$('#'+win_id).window({
				title: '添加角色',
				border:'thin',
				resizable:false,  
				minimizable:false,
				maximizable:false,
				collapsible:false,
			    inline:true,
			    modal:true
			})

			
			$('#'+win_id).window('refresh', url+'/flag_select/1/fun_select/fun_role_add<?=$time?>/fun_open/win/fun_open_id/'+win_id);
			$('#'+win_id).window('center');
			
			break;
		case 'del':

			var op_list=$('#table_role<?=$time?>').datagrid('getChecked');

			var row_s = $('#table_role<?=$time?>').datagrid('getSelected');
			var index_s = $('#table_role<?=$time?>').datagrid('getRowIndex',row_s);

			if($('#table_role<?=$time?>').datagrid('validateRow',index_s))
			{
				$('#table_role<?=$time?>').datagrid('endEdit',index_s);
			}
			else
			{
				$('#table_role<?=$time?>').datagrid('cancelEdit',index_s);
			}
			
			for(var i=op_list.length-1;i>-1;i--)
			{
				var index = $('#table_role<?=$time?>').datagrid('getRowIndex',op_list[i]);
				$('#table_role<?=$time?>').datagrid('deleteRow',index);
			}

			break;
	}
}

//批量添加角色
function fun_role_add<?=$time?>(op)
{
	$(op).closest('.op_window').window('close');
	
	var list=$(op).datagrid('getChecked');

	for(var i=0;i<list.length;i++)
	{
		var role = {};
		role.ra_id = get_guid();
		role.role_id = base64_decode(list[i].role_id);
		role.role_s = base64_decode(list[i].role_name);

		var index = $('#table_role<?=$time?>').datagrid('getRowIndex',role.role_id);

		if(index < 0)
		$('#table_role<?=$time?>').datagrid('appendRow',role);
	}

	$(op).closest('.op_window').window('destroy').remove();
	
}
</script>