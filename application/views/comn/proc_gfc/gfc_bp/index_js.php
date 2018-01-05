<!-- 加载jquery -->
<script type="text/javascript">

//初始化
$(document).ready(function(){

	$('#txtb_time_node<?=$time?>').datebox();

	//加载索引列表
	load_table_index<?=$time?>();
	
	setTimeout(function(){
		$('#txtb_time_node<?=$time?>').datebox('textbox').bind('focus',
		function(){
			$(this).parent().prev().datebox('showPanel');
		});

	},500)

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
		{field:'gfc_org_jia_s',title:'甲方单位',width:150,halign:'center',align:'center',sortable:true,
			formatter: fun_index_formatter<?=$time?>
		},
		{field:'gfc_c_tj_s',title:'项目统计人',width:120,halign:'center',align:'center',sortable:true,
			formatter: fun_index_formatter<?=$time?>
		},
		{field:'gfc_finance_code',title:'财务编号',width:120,halign:'center',align:'center',sortable:true,
			formatter: fun_index_formatter<?=$time?>
		},
		{field:'gfc_ou_s',title:'部门',width:150,halign:'center',align:'center',sortable:true,
			formatter: fun_index_formatter<?=$time?>
		},
		{field:'gfc_ou_tj_s',title:'统计部门',width:150,halign:'center',align:'center',
			formatter: fun_index_formatter<?=$time?>
		},
		{field:'gfc_category_main',title:'项目属性',width:100,halign:'center',align:'center',sortable:true,
			formatter: fun_index_formatter<?=$time?>
		},
		{field:'gfc_category_extra',title:'附加属性',width:100,halign:'center',align:'center',sortable:true,
			formatter: fun_index_formatter<?=$time?>
		},
		{field:'gfc_category_statistic',title:'附加属性II',width:100,halign:'center',align:'center',sortable:true,
			formatter: fun_index_formatter<?=$time?>
		},
		{field:'gfc_category_subc',title:'总分包类型',width:100,halign:'center',align:'center',sortable:true,
			formatter: fun_index_formatter<?=$time?>
		},
		{field:'gfc_time_node_sign',title:'统计时间',width:100,halign:'center',align:'center',sortable:true,
			formatter: fun_index_formatter<?=$time?>
		},
		{field:'gfc_sum_final_extra',title:'未开票<br>未回款',width:120,halign:'center',align:'right',
			formatter: fun_index_formatter<?=$time?>
		},
		{field:'gfc_sum_lv',title:'开票率<br>回款率',width:80,halign:'center',align:'right',
			formatter: fun_index_formatter<?=$time?>
		},
		{field:'gfc_sum_plan',title:'开票计划<br>回款计划',width:80,halign:'center',align:'right',
			formatter: fun_index_formatter<?=$time?>
		},
		{field:'gfc_sum_plan_1',title:'<span id = "gfc_sum_plan_1<?=$time?>"></span>',width:120,halign:'center',align:'right',
			formatter: fun_index_formatter<?=$time?>
		},
		{field:'gfc_sum_plan_2',title:'<span id = "gfc_sum_plan_2<?=$time?>"></span>',width:120,halign:'center',align:'right',
			formatter: fun_index_formatter<?=$time?>
		},
		{field:'gfc_sum_plan_3',title:'<span id = "gfc_sum_plan_3<?=$time?>"></span>',width:120,halign:'center',align:'right',
			formatter: fun_index_formatter<?=$time?>
		},
		{field:'gfc_sum_plan_4',title:'<span id = "gfc_sum_plan_4<?=$time?>"></span>',width:120,halign:'center',align:'right',
			formatter: fun_index_formatter<?=$time?>
		},
		{field:'gfc_sum_plan_5',title:'<span id = "gfc_sum_plan_5<?=$time?>"></span>',width:120,halign:'center',align:'right',
			formatter: fun_index_formatter<?=$time?>
		},
		{field:'gfc_sum_plan_6',title:'<span id = "gfc_sum_plan_6<?=$time?>"></span>',width:120,halign:'center',align:'right',
			formatter: fun_index_formatter<?=$time?>
		},
		{field:'gfc_sum_plan_7',title:'<span id = "gfc_sum_plan_7<?=$time?>"></span>',width:120,halign:'center',align:'right',
			formatter: fun_index_formatter<?=$time?>
		},
		{field:'gfc_sum_plan_8',title:'<span id = "gfc_sum_plan_8<?=$time?>"></span>',width:120,halign:'center',align:'right',
			formatter: fun_index_formatter<?=$time?>
		},
		{field:'gfc_sum_plan_9',title:'<span id = "gfc_sum_plan_9<?=$time?>"></span>',width:120,halign:'center',align:'right',
			formatter: fun_index_formatter<?=$time?>
		},
		{field:'gfc_sum_plan_10',title:'<span id = "gfc_sum_plan_10<?=$time?>"></span>',width:120,halign:'center',align:'right',
			formatter: fun_index_formatter<?=$time?>
		},
		{field:'gfc_sum_plan_11',title:'<span id = "gfc_sum_plan_11<?=$time?>"></span>',width:120,halign:'center',align:'right',
			formatter: fun_index_formatter<?=$time?>
		},
		{field:'gfc_sum_plan_12',title:'<span id = "gfc_sum_plan_12<?=$time?>"></span>',width:120,halign:'center',align:'right',
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
		{field:'gfc_id',title:'',checkbox:true,halign:'center',align:'center',
			formatter: fun_index_formatter<?=$time?>
		},
		{field:'gfc_name',title:'项目全称',width:200,halign:'center',align:'left',sortable:true,
			formatter: fun_index_formatter<?=$time?>
		},
		{field:'gfc_c_s',title:'项目负责人',width:120,halign:'center',align:'center',sortable:true,
			formatter: fun_index_formatter<?=$time?>
		},
		{field:'gfc_sum',title:'合同总额',width:120,halign:'center',align:'right',sortable:true,
			formatter: fun_index_formatter<?=$time?>
		},
		{field:'gfc_sum_final',title:'已开票<br>已回款',width:120,halign:'center',align:'right',
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
		title:'财务编号',
		toolbar:'#table_index_tool<?=$time?>',
		url:'proc_gfc/gfc_bp/get_json.html',
		idField:'gfc_id',
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
		rowStyler: function(index,row)
		{
			return 'height:45px;'
		},
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

			$('#l_index_<?=$time?> .prog_gfc_bp_plan<?=$time?>').progressbar();
			$('#l_index_<?=$time?> .prog_gfc_bp_plan<?=$time?>').find('.progressbar-text').css('text-align','right');
		},
		onResizeColumn: function(field, width)
		{
			if(field.indexOf('gfc_sum_plan_')> -1)
			$('#l_index_<?=$time?> .prog_gfc_bp_plan<?=$time?>').progressbar();
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

	fun_load_time_node<?=$time?>('');
	
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
		case 'gfc_name':

			var url='proc_gfc/gfc_bp/edit/act/2/gfc_id/'+base64_decode(row.gfc_id);
			value='<a href="javascript:void(0);" class="link" onClick="fun_index_win_open<?=$time?>(\'财务编号-'+value+'\',\'win\',\''+url+'\');">'+value+'</a>';

			break;
		case 'gfc_sum':
			value = num_parse(value);
			break;
		case 'gfc_sum_final':

			value = '';
			
			var sum = base64_decode(row.gfc_sum);
			var sum_kp = base64_decode(row.gfc_sum_kp);
			var per = parseFloat(sum_kp/sum*100).toFixed(2);

			var gfc_finance_code = base64_decode(row.gfc_finance_code)
			
			if(gfc_finance_code)
			{
				var url='proc_bill/bill/index/ppo/0/gfc_finance_code/'+gfc_finance_code;
				
				value += '<div class="easyui-progressbar prog_gfc_bp_plan<?=$time?>" data-options="value:'+per+',text:\'<a href=\\\'javascript:void(0);\\\' class = \\\'m_link\\\'>'+num_parse(sum_kp)+'</a>\'" style="width:100%;" onClick="fun_index_win_open<?=$time?>(\'开票-'+gfc_finance_code+'\',\'win\',\''+url+'\');"></div> '
				
				var sum_hk = base64_decode(row.gfc_sum_hk);
				var per = parseFloat(sum_hk/sum*100).toFixed(2);
	
				var url='proc_bs/bs_item/index/gfc_finance_code/'+gfc_finance_code;
				
				value += '<div class="easyui-progressbar prog_gfc_bp_plan<?=$time?>" data-options="value:'+per+',text:\'<a href=\\\'javascript:void(0);\\\' class = \\\'m_link\\\'>'+num_parse(sum_hk)+'</a>\'" style="width:100%;" onClick="fun_index_win_open<?=$time?>(\'回款-'+gfc_finance_code+'\',\'win\',\''+url+'\');"></div> '
			}
			
			break;
		case 'gfc_sum_lv':

			value = '<div style="height:20px;width:100%">'+base64_decode(row.gfc_sum_kp_lv)+'%</div><div style="height:20px;width:100%">'+base64_decode(row.gfc_sum_hk_lv)+'%</div>'
				
			break;
		case 'gfc_sum_final_extra':

			value = '<div style="height:20px;width:100%">'+num_parse(base64_decode(row.gfc_sum_kp_wei))+'</div><div style="height:20px;width:100%">'+num_parse(base64_decode(row.gfc_sum_hk_wei))+'</div>'
				
			break;
		case 'gfc_sum_plan':
			value = '<div style="height:20px;width:100%">开票计划</div><div style="height:20px;width:100%">回款计划</div>'
			break;
		case 'gfc_sum_plan_1':
		case 'gfc_sum_plan_2':
		case 'gfc_sum_plan_3':
		case 'gfc_sum_plan_4':
		case 'gfc_sum_plan_5':
		case 'gfc_sum_plan_6':
		case 'gfc_sum_plan_7':
		case 'gfc_sum_plan_8':
		case 'gfc_sum_plan_9':
		case 'gfc_sum_plan_10':
		case 'gfc_sum_plan_11':
		case 'gfc_sum_plan_12':
			
			var time = $('#'+this.field+'<?=$time?>').html();

			value = '';

			var gfc_finance_code = base64_decode(row.gfc_finance_code)
			
			if(row['sum_kp_plan_'+time])
			{
				var sum_kp_plan = base64_decode(row['sum_kp_plan_'+time]);
				var sum_kp_have = base64_decode(row['sum_kp_have_'+time]);
				var sum_kp = base64_decode(row['sum_kp_now_'+time]);
				var per = parseFloat(sum_kp_have/sum_kp_plan*100).toFixed(2);
				
				var url='proc_gfc/bp/index/flag_bill/1/gfc_finance_code/'+gfc_finance_code;

				if(gfc_finance_code)
					value += '<div class="easyui-progressbar prog_gfc_bp_plan<?=$time?>" data-options="value:'+per+',text:\'<a href=\\\'javascript:void(0);\\\' class = \\\'m_link\\\'>'+num_parse(sum_kp)+'</a>\'" style="width:100%;" onClick="fun_index_win_open<?=$time?>(\'开票计划-'+gfc_finance_code+'\',\'win\',\''+url+'\');"></div> '
				else
					value += '<div style="height:20px;width:100%">'+num_parse(sum_kp)+'</div>'	
			}
			else if(row['sum_hk_plan_'+time])
			{
				value += '<div style="height:20px;width:100%"></div>'
			}

			if(row['sum_hk_plan_'+time])
			{
				var sum_hk_plan = base64_decode(row['sum_hk_plan_'+time]);
				var sum_hk_have = base64_decode(row['sum_hk_have_'+time]);
				var sum_hk = base64_decode(row['sum_hk_now_'+time]);
				var per = parseFloat(sum_hk_have/sum_hk_plan*100).toFixed(2);

				if(gfc_finance_code)
					value += '<div class="easyui-progressbar prog_gfc_bp_plan<?=$time?>" data-options="value:'+per+',text:\''+num_parse(sum_hk)+'\'" style="width:100%;"></div> '
				else
					value += '<div style="height:20px;width:100%">'+num_parse(sum_hk)+'</div>'	
			}
			else if(row['sum_kp_plan_'+time])
			{
				value += '<div style="height:20px;width:100%"></div>'
			}
			
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

	var time_node = $('#txtb_time_node<?=$time?>').datebox('getValue');
	
	//数据库字段表
	$('#table_index<?=$time?>').datagrid('load',{
		data_search: JSON.stringify(field),
		time_node: time_node
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
				title: title,
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
			$('#'+win_id).window('open');
			break;
		case 'winopen':

			window.open(url+'/fun_open/winopen');

			break;
	}
}

//编辑
function load_win_edit<?=$time?>(op_id,act)
{
	var url = 'proc_gfc/gfc_bp/edit/act/'+act;

	if(op_id)
		url+='/gfc/'+op_id

	fun_index_win_open<?=$time?>('创建财务编号','win',url)
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
			fun_index_win_open<?=$time?>('批量编辑','win','proc_gfc/gfc/edit/act/2/flag_edit_more/1/fun_no_db/fun_edit_more<?=$time?>');
			return;
			break;
	}

	$('#table_index<?=$time?>').datagrid('loading');

	var list=[];

	for(var i=0;i<op_list.length;i++)
	{
		var id=op_list[i]['gfc_id'];

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
		var id=op_list[i]['gfc_id'];

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
        url:"app/run_back/proc_gfc/gfc/fun_operate_more.html",
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
            	fun_win_sys_msg('【财务编号批量操作】操作结果:',msg)

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

//所属机构查询
function load_gfc_org_search<?=$time?>()
{
	var row_s =  $('#table_search<?=$time?>').propertygrid('getSelected');
	var index_s = $('#table_search<?=$time?>').propertygrid('getRowIndex',row_s);
	
	var ed=$('#table_search<?=$time?>').propertygrid('getEditor',{index: index_s,field:'value'});

	$(ed.target).combotree('reload','base/auto/get_json_hr_org/from/combobox/field_id/ou_id/field_text/ou_name')
	
}

function fun_end_gfc_org_search<?=$time?>()
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

//甲方单位查询
function load_gfc_org_jia_search<?=$time?>()
{
	var row_s =  $('#table_search<?=$time?>').propertygrid('getSelected');
	var index_s = $('#table_search<?=$time?>').propertygrid('getRowIndex',row_s);
	
	var ed=$('#table_search<?=$time?>').propertygrid('getEditor',{index: index_s,field:'value'});

	if(row_s.value)
	$(ed.target).combobox('setText',row_s.value_s)
	
	$(ed.target).combobox('textbox').autocomplete({
	  serviceUrl: 'base/auto/get_json_org',
	  width:'300',
	  params:{
			rows:10
	  },
  	  onSelect: function (suggestion) {

			$('#table_search<?=$time?>').propertygrid('updateRow',{
				index: index_s,
				row: {
					value: base64_decode(suggestion.data.o_id_standard),
					value_s: base64_decode(suggestion.data.o_name)
				}
			});
		}
	});

	$(ed.target).combobox('textbox').focus();
}

//负责人查询
function load_gfc_c_search<?=$time?>()
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
		},
	    onSelect: function (suggestion) {

			$('#table_search<?=$time?>').propertygrid('updateRow',{
				index: index_s,
				row: {
					value: base64_decode(suggestion.data.c_id),
					value_s: base64_decode(suggestion.data.c_show)
				}
			});
		}
	});

	$(ed.target).combobox('textbox').focus();
}

//部门查询
function load_gfc_ou_search<?=$time?>()
{
	var row_s =  $('#table_search<?=$time?>').propertygrid('getSelected');
	var index_s = $('#table_search<?=$time?>').propertygrid('getRowIndex',row_s);
	
	var ed=$('#table_search<?=$time?>').propertygrid('getEditor',{index: index_s,field:'value'});

	if(row_s.value)
	$(ed.target).combobox('setText',row_s.value_s)
	
	var json = [
		{"field":"ou_tag","rule":"find_in_set","value":"1"}
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

function fun_load_time_node<?=$time?>(value)
{
	if( ! value ) value = fun_get_date('Y-m');

	var Y = value.split('-')[0];
	var m = value.split('-')[1];
	if(m.length != 2 && m.indexOf(0)<0) m='0'+m;

	$('#gfc_sum_plan_4<?=$time?>').html(Y+'-'+m);

	var time_tmp = Y+'-'+m+'-01';
	for(var i= 3 ;i > 0; i-- )
	{
		time_tmp = getNewDay(time_tmp,-1);
		
		var Y_tmp = time_tmp.split('-')[0];
		var m_tmp = time_tmp.split('-')[1];
		if(m.length != 2 && m.indexOf(0)<0) m='0'+m;
		
		$('#gfc_sum_plan_'+i+'<?=$time?>').html(Y_tmp+'-'+m_tmp);
		
		time_tmp = Y_tmp+'-'+m_tmp+'-01';
	}

	var time_tmp = Y+'-'+m+'-28';
	
	for(var i= 5 ;i < 13; i++ )
	{
		time_tmp = getNewDay(time_tmp,+5);
		
		var Y_tmp = time_tmp.split('-')[0];
		var m_tmp = time_tmp.split('-')[1];
		if(m.length != 2 && m.indexOf(0)<0) m='0'+m;
		
		$('#gfc_sum_plan_'+i+'<?=$time?>').html(Y_tmp+'-'+m_tmp);

		time_tmp = Y_tmp+'-'+m_tmp+'-28';
	}
}


//导出培训记录
function load_table_export<?=$time?>()
{
  var no_page = '1'

  if('<?=$no_page?>')
      no_page='<?=$no_page?>';

  $('#table_export<?=$time?>').attr("no_page",no_page);

  var arr_time = [];
  for(var i= 1 ;i < 13; i++ )
  {
	var tmp_time = $('#gfc_sum_plan_'+i+'<?=$time?>').text();

	arr_time.push(tmp_time)
  }

  var col=[[
    {field:'gfc_org_jia_s',title:'甲方单位',width:150,halign:'center',align:'center',sortable:true,
    	formatter: fun_index_export_formatter<?=$time?>
    },
    {field:'gfc_c_tj_s',title:'项目统计人',width:120,halign:'center',align:'center',sortable:true,
    	formatter: fun_index_export_formatter<?=$time?>
    },
    {field:'gfc_finance_code',title:'财务编号',width:120,halign:'center',align:'center',sortable:true,
    	formatter: fun_index_export_formatter<?=$time?>
    },
    {field:'gfc_ou_s',title:'部门',width:150,halign:'center',align:'center',sortable:true,
    	formatter: fun_index_export_formatter<?=$time?>
    },
    {field:'gfc_ou_tj_s',title:'统计部门',width:150,halign:'center',align:'center',sortable:true,
    	formatter: fun_index_export_formatter<?=$time?>
    },
    {field:'gfc_category_main',title:'项目属性',width:100,halign:'center',align:'center',sortable:true,
    	formatter: fun_index_export_formatter<?=$time?>
    },
    {field:'gfc_category_extra',title:'附加属性',width:100,halign:'center',align:'center',sortable:true,
    	formatter: fun_index_export_formatter<?=$time?>
    },
    {field:'gfc_category_statistic',title:'附加属性II',width:100,halign:'center',align:'center',sortable:true,
    	formatter: fun_index_export_formatter<?=$time?>
    },
    {field:'gfc_category_subc',title:'总分包类型',width:100,halign:'center',align:'center',sortable:true,
    	formatter: fun_index_export_formatter<?=$time?>
    },
    {field:'gfc_time_node_sign',title:'统计时间',width:100,halign:'center',align:'center',sortable:true,
    	formatter: fun_index_export_formatter<?=$time?>
    },
    {field:'gfc_sum_kp',title:'已开票',width:120,halign:'center',align:'right',
    	formatter: fun_index_export_formatter<?=$time?>
    },
    {field:'gfc_sum_kp_wei',title:'未开票',width:120,halign:'center',align:'right',
    	formatter: fun_index_export_formatter<?=$time?>
    },
    {field:'gfc_sum_kp_lv',title:'开票率',width:80,halign:'center',align:'right',
    	formatter: fun_index_export_formatter<?=$time?>
    },
    {field:'gfc_plan_kp',title:'开票计划',width:80,halign:'center',align:'right',
    	formatter: fun_index_export_formatter<?=$time?>
    },
    {field:'gfc_sum_kp_plan_1',title:arr_time[0],width:120,halign:'center',align:'right',
    	formatter: fun_index_export_formatter<?=$time?>
    },
    {field:'gfc_sum_kp_plan_2',title:arr_time[1],width:120,halign:'center',align:'right',
    	formatter: fun_index_export_formatter<?=$time?>
    },
    {field:'gfc_sum_kp_plan_3',title:arr_time[2],width:120,halign:'center',align:'right',
    	formatter: fun_index_export_formatter<?=$time?>
    },
    {field:'gfc_sum_kp_plan_4',title:arr_time[3],width:120,halign:'center',align:'right',
    	formatter: fun_index_export_formatter<?=$time?>
    },
    {field:'gfc_sum_kp_plan_5',title:arr_time[4],width:120,halign:'center',align:'right',
    	formatter: fun_index_export_formatter<?=$time?>
    },
    {field:'gfc_sum_kp_plan_6',title:arr_time[5],width:120,halign:'center',align:'right',
    	formatter: fun_index_export_formatter<?=$time?>
    },
    {field:'gfc_sum_kp_plan_7',title:arr_time[6],width:120,halign:'center',align:'right',
    	formatter: fun_index_export_formatter<?=$time?>
    },
    {field:'gfc_sum_kp_plan_8',title:arr_time[7],width:120,halign:'center',align:'right',
    	formatter: fun_index_export_formatter<?=$time?>
    },
    {field:'gfc_sum_kp_plan_9',title:arr_time[8],width:120,halign:'center',align:'right',
    	formatter: fun_index_export_formatter<?=$time?>
    },
    {field:'gfc_sum_kp_plan_10',title:arr_time[9],width:120,halign:'center',align:'right',
    	formatter: fun_index_export_formatter<?=$time?>
    },
    {field:'gfc_sum_kp_plan_11',title:arr_time[10],width:120,halign:'center',align:'right',
    	formatter: fun_index_export_formatter<?=$time?>
    },
    {field:'gfc_sum_kp_plan_12',title:arr_time[11],width:120,halign:'center',align:'right',
    	formatter: fun_index_export_formatter<?=$time?>
    },
    {field:'gfc_sum_hk',title:'已回款',width:120,halign:'center',align:'right',
    	formatter: fun_index_export_formatter<?=$time?>
    },
    {field:'gfc_sum_hk_wei',title:'未回款',width:120,halign:'center',align:'right',
    	formatter: fun_index_export_formatter<?=$time?>
    },
    {field:'gfc_sum_hk_lv',title:'回款率',width:80,halign:'center',align:'right',
    	formatter: fun_index_export_formatter<?=$time?>
    },
    {field:'gfc_plan_hk',title:'回款计划',width:80,halign:'center',align:'right',
    	formatter: fun_index_export_formatter<?=$time?>
    },
    {field:'gfc_sum_hk_plan_1',title:arr_time[0],width:120,halign:'center',align:'right',
    	formatter: fun_index_export_formatter<?=$time?>
    },
    {field:'gfc_sum_hk_plan_2',title:arr_time[1],width:120,halign:'center',align:'right',
    	formatter: fun_index_export_formatter<?=$time?>
    },
    {field:'gfc_sum_hk_plan_3',title:arr_time[2],width:120,halign:'center',align:'right',
    	formatter: fun_index_export_formatter<?=$time?>
    },
    {field:'gfc_sum_hk_plan_4',title:arr_time[3],width:120,halign:'center',align:'right',
    	formatter: fun_index_export_formatter<?=$time?>
    },
    {field:'gfc_sum_hk_plan_5',title:arr_time[4],width:120,halign:'center',align:'right',
    	formatter: fun_index_export_formatter<?=$time?>
    },
    {field:'gfc_sum_hk_plan_6',title:arr_time[5],width:120,halign:'center',align:'right',
    	formatter: fun_index_export_formatter<?=$time?>
    },
    {field:'gfc_sum_hk_plan_7',title:arr_time[6],width:120,halign:'center',align:'right',
    	formatter: fun_index_export_formatter<?=$time?>
    },
    {field:'gfc_sum_hk_plan_8',title:arr_time[7],width:120,halign:'center',align:'right',
    	formatter: fun_index_export_formatter<?=$time?>
    },
    {field:'gfc_sum_hk_plan_9',title:arr_time[8],width:120,halign:'center',align:'right',
    	formatter: fun_index_export_formatter<?=$time?>
    },
    {field:'gfc_sum_hk_plan_10',title:arr_time[9],width:120,halign:'center',align:'right',
    	formatter: fun_index_export_formatter<?=$time?>
    },
    {field:'gfc_sum_hk_plan_11',title:arr_time[10],width:120,halign:'center',align:'right',
    	formatter: fun_index_export_formatter<?=$time?>
    },
    {field:'gfc_sum_hk_plan_12',title:arr_time[11],width:120,halign:'center',align:'right',
    	formatter: fun_index_export_formatter<?=$time?>
    },
    ]];

    if('<?=$columns?>')
    {
    col=JSON.parse(base64_decode('<?=$columns?>'));
    for(var i=0;i<col[0].length;i++)
    {
    	col[0][i].formatter=fun_index_export_formatter<?=$time?>;
    }
    }

    var fcol=[[
	    {field:'gfc_id',title:'',checkbox:true,halign:'center',align:'center',
	    	formatter: fun_index_export_formatter<?=$time?>
	    },
	    {field:'gfc_name',title:'项目全称',width:200,halign:'center',align:'left',sortable:true,
	    	formatter: fun_index_export_formatter<?=$time?>
	    },
	    {field:'gfc_c_s',title:'项目负责人',width:120,halign:'center',align:'center',sortable:true,
	    	formatter: fun_index_export_formatter<?=$time?>
	    },
	    {field:'gfc_sum',title:'合同总额',width:120,halign:'center',align:'right',sortable:true,
	    	formatter: fun_index_export_formatter<?=$time?>
	    },
    ]]

  if('<?=$frozenColumns?>')
  {
      fcol=JSON.parse(base64_decode('<?=$frozenColumns?>'));
      for(var i=0;i<fcol[0].length;i++)
      {
          fcol[0][i].formatter=fun_index_export_formatter<?=$time?>;
      }
  }

  //数据库字段表
  $('#table_export<?=$time?>').attr("no_load",1);
  $('#table_export<?=$time?>').datagrid({
      fit:true,
      title:'开票回款计划',
      url:'proc_gfc/gfc_bp/get_json.html',
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
      $('#table_export<?=$time?>').datagrid('sort',{
          sortName: '<?=$sort?>',
          sortOrder: '<?=$order?>'
      });
  }

  if(no_page == 1)
  {
      $('#table_export<?=$time?>').datagrid({
          view: bufferview,
          pagination:false,
          pageSize:200,
      })
  }
  else
  {
      var p=$('#table_export<?=$time?>').datagrid('getPager');
      $(p).pagination({
          layout:['list','manual','first','prev','links','next','last'],
          afterPageText:'页，共{pages}页，'
      });
  }

	//载入流程查询
	load_table_search<?=$time?>();

	//查询
	fun_table_export_search<?=$time?>();

}

function fun_index_export_formatter<?=$time?>(value,row,index){
  value=base64_decode(value);

  switch(this.field)
  {
  }

  return value;
}

function fun_table_export_search<?=$time?>()
{
  $('#table_export<?=$time?>').attr("no_load",0);

  // 排序字段
  $('#table_search<?=$time?>').propertygrid('sort',
      {
          sortName: 'field',
          sortOrder: 'asc'
      }
  );

  var field=$('#table_search<?=$time?>').propertygrid('getRows');

  //数据库字段表
  $('#table_export<?=$time?>').datagrid('load',{
      data_search: JSON.stringify(field)
  });
}
</script>