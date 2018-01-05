<!-- 加载jquery -->
<script type="text/javascript">

//初始化
$(document).ready(function(){

	//加载索引列表
	load_table_index<?=$time?>();
    load_table_index_train<?=$time?>()
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
		{field:'c_age',title:'年龄',width:60,halign:'center',align:'center',sortable:true,
			formatter: fun_index_formatter<?=$time?>
		},
		{field:'c_code_person',title:'身份证号',width:140,halign:'center',align:'center',sortable:true,
			formatter: fun_index_formatter<?=$time?>
		},
		{field:'c_tel',title:'手机',width:100,halign:'center',align:'center',sortable:true,
			formatter: fun_index_formatter<?=$time?>
		},
		{field:'c_tel_code',title:'短号',width:60,halign:'center',align:'center',sortable:true,
			formatter: fun_index_formatter<?=$time?>
		},
		{field:'hr_time_rz',title:'入职日期',width:100,halign:'center',align:'center',sortable:true,
			formatter: fun_index_formatter<?=$time?>
		},
		{field:'hr_time_zz',title:'转正日期',width:100,halign:'center',align:'center',sortable:true,
			formatter: fun_index_formatter<?=$time?>
		},
		{field:'hr_vacation',title:'带薪年假',width:80,halign:'center',align:'center',sortable:true,
			formatter: fun_index_formatter<?=$time?>
		},
		{field:'c_job_s',title:'职位',width:120,halign:'center',align:'center',sortable:true,
			formatter: fun_index_formatter<?=$time?>
		},
		{field:'c_ou_2_s',title:'二级部门',width:150,halign:'center',align:'center',sortable:true,
			formatter: fun_index_formatter<?=$time?>
		},
		{field:'c_ou_3_s',title:'三级部门',width:150,halign:'center',align:'center',sortable:true,
			formatter: fun_index_formatter<?=$time?>
		},
		{field:'c_ou_4_s',title:'四级部门',width:150,halign:'center',align:'center',sortable:true,
			formatter: fun_index_formatter<?=$time?>
		},
		{field:'hr_type_work',title:'用工形式',width:100,halign:'center',align:'center',sortable:true,
			formatter: fun_index_formatter<?=$time?>
		},
		{field:'hr_type',title:'人员类别',width:100,halign:'center',align:'center',sortable:true,
			formatter: fun_index_formatter<?=$time?>
		},
		{field:'hr_tec_s',title:'技术方向',width:250,halign:'center',align:'center',sortable:true,
			formatter: fun_index_formatter<?=$time?>
		},
		{field:'c_org_s',title:'所属机构',width:250,halign:'center',align:'center',sortable:true,
			formatter: fun_index_formatter<?=$time?>
		},
		{field:'hr_info_finish',title:'是否补全',width:80,halign:'center',align:'center',sortable:true,
			formatter: fun_index_formatter<?=$time?>
		},
		{field:'hr_check',title:'信息审核',width:80,halign:'center',align:'center',sortable:true,
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
				{field:'c_id',title:'c_id',checkbox:true,halign:'center',align:'center',
					formatter: fun_index_formatter<?=$time?>
				},
				{field:'hr_code',title:'工号',width:100,halign:'center',align:'left',sortable:true,
					formatter: fun_index_formatter<?=$time?>
				},
				{field:'c_name',title:'姓名',width:100,halign:'center',align:'center',sortable:true,
					formatter: fun_index_formatter<?=$time?>
				},
				{field:'c_sex',title:'性别',width:60,halign:'center',align:'center',sortable:true,
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

	var url = 'proc_hr/hr_info/get_json';

	if('<?=$flag_zz?>')
		url += '/flag_zz/<?=$flag_zz?>'

	//数据库字段表
	$('#table_index<?=$time?>').attr("no_load",1);
	$('#table_index<?=$time?>').datagrid({
		fit:true,
		title:'员工索引',
		toolbar:'#table_index_tool<?=$time?>',
		url:url,
		idField:'c_id',
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
		onCheck: function(index, row)
		{
			if('<?=$flag_select?>' == 2)
			{
				var row_c = $(this).datagrid('getChecked');

				if(row_c.length > 1)
				{
					$(this).datagrid('uncheckAll');
					$(this).datagrid('checkRow',index);
				}
			}
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

	load_table_search('table_search<?=$time?>',field_search_value_dispaly,field_search_rule,field_search_start,<?=$field_search_rule_default?>,'<?=$conf_search?>')

}

//列格式化输出
function fun_index_formatter<?=$time?>(value,row,index){
	value=base64_decode(value);

	switch(this.field)
	{
		case 'hr_code':

			var url='proc_hr/hr_info/edit/act/2/c_id/'+base64_decode(row.c_id);
			value='<a href="javascript:void(0);" class="link" onClick="fun_index_win_open<?=$time?>(\''+base64_decode(row.c_name).substring(0,10)+'\',\'win\',\''+url+'\');">'+value+'</a>';

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
	var url = 'proc_hr/hr_info/edit/act/'+act;

	if(op_id)
		url+='/c_id/'+op_id

	fun_index_win_open<?=$time?>('创建员工信息','win',url)
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
            fun_index_win_open<?=$time?>('批量编辑','win','proc_hr/hr_info/edit/act/2/flag_edit_more/1/fun_no_db/fun_edit_more<?=$time?>');
            return;
            break;
    }

	$('#table_index<?=$time?>').datagrid('loading');

	var list=[];

	for(var i=0;i<op_list.length;i++)
	{
		var id=op_list[i]['c_id'];

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
  if( form_data.c_ou_2_s_check == 1)
	  form_data.c_ou_2_check = 1;
  
  if( form_data.c_ou_3_s_check == 1)
	  form_data.c_ou_3_check = 1;
  
  if( form_data.c_ou_4_s_check == 1)
	  form_data.c_ou_4_check = 1;

  if( form_data.c_job_s_check == 1)
	  form_data.c_job_check = 1;

  json_save.content=form_data;
  json_save.flag_edit_more = 1;

  $('#'+f_id).closest('.op_window').window('close');

  $('#table_index<?=$time?>').datagrid('loading');

  var op_list=$('#table_index<?=$time?>').datagrid('getChecked');

  var list=[];

  for(var i=0;i<op_list.length;i++)
  {
      var id=op_list[i]['c_id'];

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
        url:"app/run_back/proc_hr/hr_info/fun_operate_more.html",
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
            
            fun_send_wl(json);
            
            if(json.rs)
            {
            	var msg='批量操作完成！<br/><div style="font-size:12px;"><br/>'+msg_err<?=$time?>+'</div>'
            	fun_win_sys_msg('【员工录用批量操作】操作结果:',msg)

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

//部门查询
function load_c_ou_search<?=$time?>()
{
	var row_s =  $('#table_search<?=$time?>').propertygrid('getSelected');
	var index_s = $('#table_search<?=$time?>').propertygrid('getRowIndex',row_s);

	var ed=$('#table_search<?=$time?>').propertygrid('getEditor',{index: index_s,field:'value'});

	if(row_s.value)
	$(ed.target).combobox('setText',row_s.value_s)

	var json = [
		{"field":"ou_tag","rule":"find_in_set","value":"2"}
	]

	$(ed.target).combobox('textbox').autocomplete({
      serviceUrl: 'base/auto/get_json_ou',
      width:'300',
      params:{
			rows:10,
			data_search:JSON.stringify(json)
		},
      onSelect: function (suggestion) {

			$('#table_search<?=$time?>').propertygrid('updateRow',{
				index: index_s,
				row: {
					value: base64_decode(suggestion.data.ou_id),
					value_s: base64_decode(suggestion.data.ou_name)
				}
			});
		}
	});

	$(ed.target).combobox('textbox').focus();
}

//所属机构查询
function load_c_org_search<?=$time?>()
{
	var row_s =  $('#table_search<?=$time?>').propertygrid('getSelected');
	var index_s = $('#table_search<?=$time?>').propertygrid('getRowIndex',row_s);

	var ed=$('#table_search<?=$time?>').propertygrid('getEditor',{index: index_s,field:'value'});

	$(ed.target).combotree('reload','base/auto/get_json_hr_org/from/combobox/field_id/ou_id/field_text/ou_name')

}

function fun_end_c_org_search<?=$time?>()
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

//职位查询
function load_c_job_search<?=$time?>()
{
	var row_s =  $('#table_search<?=$time?>').propertygrid('getSelected');
	var index_s = $('#table_search<?=$time?>').propertygrid('getRowIndex',row_s);

	var ed=$('#table_search<?=$time?>').propertygrid('getEditor',{index: index_s,field:'value'});

	if(row_s.value)
	$(ed.target).combobox('setText',row_s.value_s)

	$(ed.target).combobox('textbox').autocomplete({
      serviceUrl: 'proc_hr/hr_job/get_json',
      width:'300',
      params:{
			rows:10,
//			data_search:JSON.stringify(json)
		},
      onSelect: function (suggestion) {

			$('#table_search<?=$time?>').propertygrid('updateRow',{
				index: index_s,
				row: {
					value: base64_decode(suggestion.data.job_id),
					value_s: base64_decode(suggestion.data.job_name)
				}
			});
		}
	});

	$(ed.target).combobox('textbox').focus();
}

function fun_end_hr_tec_search<?=$time?>()
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

//导出培训记录
function load_table_index_train<?=$time?>()
{
    var no_page = '1'

    if('<?=$no_page?>')
        no_page='<?=$no_page?>';

    $('#table_train<?=$time?>').attr("no_page",no_page);

    var col=[[
        {field:'c_job_s',title:'职位',width:120,halign:'center',align:'center',sortable:true,
            formatter: fun_index_train_formatter<?=$time?>
        },
        {field:'c_ou_2_s',title:'二级部门',width:150,halign:'center',align:'center',sortable:true,
            formatter: fun_index_train_formatter<?=$time?>
        },
        {field:'c_ou_3_s',title:'三级部门',width:150,halign:'center',align:'center',sortable:true,
            formatter: fun_index_train_formatter<?=$time?>
        },
        {field:'c_ou_4_s',title:'四级部门',width:150,halign:'center',align:'center',sortable:true,
            formatter: fun_index_train_formatter<?=$time?>
        },
        {field:'c_ou_bud_s',title:'预算部门',width:100,halign:'center',align:'center',sortable:true,
            formatter: fun_index_train_formatter<?=$time?>
        },
        {field:'hr_zw_1',title:'职务大类',width:150,halign:'center',align:'center',sortable:true,
            formatter: fun_index_train_formatter<?=$time?>
        },
        {field:'hr_zw_2',title:'职务中类',width:150,halign:'center',align:'center',sortable:true,
            formatter: fun_index_train_formatter<?=$time?>
        },
        {field:'hr_zw_3',title:'职务小类',width:100,halign:'center',align:'center',sortable:true,
            formatter: fun_index_train_formatter<?=$time?>
        },
        {field:'hr_t_time_start',title:'培训时间(始)',width:150,halign:'center',align:'center',sortable:true,
            formatter: fun_index_train_formatter<?=$time?>,
        },
        {field:'hr_t_time_end',title:'培训时间(止)',width:150,halign:'center',align:'center',sortable:true,
            formatter: fun_index_train_formatter<?=$time?>,
        },
        {field:'hr_t_name',title:'培训名称',width:100,halign:'center',align:'center',sortable:true,
            formatter: fun_index_train_formatter<?=$time?>
        },
        {field:'hr_t_org',title:'培训地点',width:150,halign:'center',align:'center',sortable:true,
            formatter: fun_index_train_formatter<?=$time?>
        },
        {field:'hr_t_ca_name',title:'证书名称',width:100,halign:'center',align:'center',sortable:true,
            formatter: fun_index_train_formatter<?=$time?>
        },
        {field:'hr_t_type_last',title:'是否续证',width:150,halign:'center',align:'center',sortable:true,
            formatter: fun_index_train_formatter<?=$time?>
        },
        {field:'hr_t_time_ca_end',title:'证书到期时间',width:100,halign:'center',align:'center',sortable:true,
            formatter: fun_index_train_formatter<?=$time?>
        },
    ]];

    if('<?=$columns?>')
    {
        col=JSON.parse(base64_decode('<?=$columns?>'));
        for(var i=0;i<col[0].length;i++)
        {
            col[0][i].formatter=fun_index_train_formatter<?=$time?>;
        }
    }

    var fcol=[[
        {field:'c_id',title:'c_id',checkbox:true,halign:'center',align:'center',
            formatter: fun_index_train_formatter<?=$time?>
        },
        {field:'hr_code',title:'工号',width:100,halign:'center',align:'left',sortable:true,
            formatter: fun_index_train_formatter<?=$time?>
        },
        {field:'c_name',title:'姓名',width:100,halign:'center',align:'center',sortable:true,
            formatter: fun_index_train_formatter<?=$time?>
        },
    ]]

    if('<?=$frozenColumns?>')
    {
        fcol=JSON.parse(base64_decode('<?=$frozenColumns?>'));
        for(var i=0;i<fcol[0].length;i++)
        {
            fcol[0][i].formatter=fun_index_train_formatter<?=$time?>;
        }
    }

    //数据库字段表
    $('#table_train<?=$time?>').attr("no_load",1);
    $('#table_train<?=$time?>').datagrid({
        fit:true,
        title:'员工培训索引',
//        toolbar:'#table_index_tool<?//=$time?>//',
        url:'proc_hr/hr_info/get_json_train.html',
        idField:'c_id',
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
            //if( $(this).attr("no_load") == 1)
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
        $('#table_train<?=$time?>').datagrid('sort',{
            sortName: '<?=$sort?>',
            sortOrder: '<?=$order?>'
        });
    }

    if(no_page == 1)
    {
        $('#table_train<?=$time?>').datagrid({
            view: bufferview,
            pagination:false,
            pageSize:200,
        })
    }
    else
    {
        var p=$('#table_train<?=$time?>').datagrid('getPager');
        $(p).pagination({
            layout:['list','manual','first','prev','links','next','last'],
            afterPageText:'页，共{pages}页，'
        });
    }

	//查询
	fun_table_train_search<?=$time?>();

}

function fun_index_train_formatter<?=$time?>(value,row,index){
    value=base64_decode(value);

    switch(this.field)
    {
    }

    return value;
}

function fun_table_train_search<?=$time?>()
{
    $('#table_train<?=$time?>').attr("no_load",0);

    // 排序字段
    $('#table_search<?=$time?>').propertygrid('sort',
        {
            sortName: 'field',
            sortOrder: 'asc'
        }
    );

    var field=$('#table_search<?=$time?>').propertygrid('getRows');

    //数据库字段表
    $('#table_train<?=$time?>').datagrid('load',{
        data_search: JSON.stringify(field)
    });
}
</script>