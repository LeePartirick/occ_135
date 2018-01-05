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
		{field:'bill_ending_sum',title:'应收账款',width:120,halign:'center',align:'right',sortable:true,
			formatter: fun_index_formatter<?=$time?>
		}, 
		{field:'bill_contact_manager_s',title:'开票统计人',width:120,halign:'center',align:'center',sortable:true,
			formatter: fun_index_formatter<?=$time?>
		},
		{field:'bill_category_s',title:'发票类型',width:150,halign:'center',align:'center',sortable:true,
			formatter: fun_index_formatter<?=$time?>
		},
		{field:'bill_time_node_kp',title:'开票时间',width:125,halign:'center',align:'center',sortable:true,
			formatter: fun_index_formatter<?=$time?>
		},
		{field:'bill_time_return',title:'预计回款时间',width:125,halign:'center',align:'center',sortable:true,
			formatter: fun_index_formatter<?=$time?>
		},
		{field:'gfc_name',title:'项目名称',width:200,halign:'center',align:'center',sortable:true,
			formatter: fun_index_formatter<?=$time?>
		},
		{field:'gfc_c_s',title:'项目负责人',width:120,halign:'center',align:'center',sortable:true,
			formatter: fun_index_formatter<?=$time?>
		},
		{field:'gfc_finance_code',title:'财务编号',width:120,halign:'center',align:'left',sortable:true,
			formatter: fun_index_formatter<?=$time?>
		},
		{field:'gfc_sum',title:'合同总额',width:120,halign:'center',align:'right',sortable:true,
			formatter: fun_index_formatter<?=$time?>
		},
		{field:'gfc_ou_tj_s',title:'统计部门',width:150,halign:'center',align:'center',
			formatter: fun_index_formatter<?=$time?>
		},
		{field:'gfc_category_extra',title:'附加属性',width:100,halign:'center',align:'center',sortable:true,
			formatter: fun_index_formatter<?=$time?>
		},
		{field:'gfc_org_s',title:'所属机构',width:250,halign:'center',align:'center',sortable:true,
			formatter: fun_index_formatter<?=$time?>
		},
		{field:'ppo',title:'流程节点',width:120,halign:'center',align:'center',sortable:true,
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
				{field:'bill_id',title:'bill_id',checkbox:true,halign:'center',align:'center',
					formatter: fun_index_formatter<?=$time?>
				},
				{field:'bill_code',title:'单据编号',width:120,halign:'center',align:'left',sortable:true,
					formatter: fun_index_formatter<?=$time?>
				},
				{field:'bill_org_customer_s',title:'客户名称',width:200,halign:'center',align:'left',sortable:true,
					formatter: fun_index_formatter<?=$time?>
				},
				{field:'bill_sum',title:'开票金额',width:120,halign:'center',align:'right',sortable:true,
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

	var url = 'proc_bill/bill/get_json'

	if('<?=$search_bill_ending_sum?>')
	url+='/search_bill_ending_sum/1';

	//数据库字段表
	$('#table_index<?=$time?>').attr("no_load",1);
	$('#table_index<?=$time?>').datagrid({
		fit:true,
		title:'开票列表',
		toolbar:'#table_index_tool<?=$time?>',
		url:url,
		idField:'bill_id',
		sort:'<?=$sort?>',
		order:'<?=$order?>',
		rownumbers:true,
		singleSelect:true,
		selectOnCheck:false,
		checkOnSelect:false,
		showFooter:true,
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

			$('#l_index_<?=$time?> .prog_bill_ending_sum<?=$time?>').progressbar();
			$('#l_index_<?=$time?> .prog_bill_ending_sum<?=$time?>').find('.progressbar-text').css('text-align','right');
		},
		onResizeColumn: function(field, width)
		{
			if(field == 'bill_ending_sum')
			$('#l_index_<?=$time?> .prog_bill_ending_sum<?=$time?>').progressbar();
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
		case 'gfc_finance_code':

			if( ! value) break;
			var url='proc_gfc/gfc/edit/act/2/gfc_id/'+base64_decode(row.gfc_id);
			value='<a href="javascript:void(0);" class="link" onClick="fun_index_win_open<?=$time?>(\''+base64_decode(row.gfc_finance_code)+'\',\'win\',\''+url+'\');">'+value+'</a>';

			break;
			
		case 'bill_code':

			if( ! value) break;
			var url='proc_bill/bill/edit/act/2/bill_id/'+base64_decode(row.bill_id);
			value='<a href="javascript:void(0);" class="link" onClick="fun_index_win_open<?=$time?>(\''+base64_decode(row.bill_code)+'\',\'win\',\''+url+'\');">'+value+'</a>';
			
			break;
			
		case 'bill_ending_sum':
			var bill_ending_sum = base64_decode(row.bill_ending_sum);
			var bill_sum = base64_decode(row.bill_sum);
			var per = parseFloat(bill_ending_sum/bill_sum*100).toFixed(2);
			
			value = num_parse(bill_ending_sum);
			value = '<div class="easyui-progressbar prog_bill_ending_sum<?=$time?>" data-options="value:'+per+',text:\''+value+'\'" style="width:100%;"></div> '

			break;
		case 'bill_sum':
		case 'gfc_sum':
			value = num_parse(value);
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

								$.messager.confirm('确认', '是否需要打开新窗口？<br>当前未保存数据不做保留！', function(r){
									if (r){
										window.open(url);
										var tab =$('#l_index_<?=$time?>').tabs('getTab',title);
										var index = $('#l_index_<?=$time?>').tabs('getTabIndex',tab);
										$('#l_index_<?=$time?>').tabs('close',index);
									}
								});
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
					$.messager.confirm('确认', '是否需要新建标签页？<br>当前未保存数据不做保留！', function(r){
						if (r){
							$('#'+win_id).window('close');
							$('#'+win_id).window('clear');
							fun_index_win_open<?=$time?>(title,'tab',url)
						}
						else{
							$('#'+win_id).window('open');
						}
					});
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
	var url = 'proc_bill/bill/edit/act/'+act;

	if(op_id)
		url+='/bill_id/'+op_id

	fun_index_win_open<?=$time?>('创建开票','win',url)
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

	$('#table_index<?=$time?>').datagrid('loading');

	var list=[];

	for(var i=0;i<op_list.length;i++)
	{
		var id=op_list[i]['bill_id'];

		list.push(base64_decode(id))
	}

	list=list.join(',');
	msg_err<?=$time?>='';
	fun_operate_more<?=$time?>(list,btn)

}

function fun_operate_more<?=$time?>(list,btn)
{
	 //保存配置
	$.ajax({
        url:"app/run_back/proc_bill/bill/fun_operate_more.html",
        type:"POST",
        data:{
			list : list,
			btn : btn,
			msg_err: msg_err<?=$time?>
        },
        success:function(data){

        	if( ! data ) return;
        	
            var json = JSON.parse(data);

            msg_err<?=$time?>+=json.msg_err;

            if(json.rs)
            {
            	var msg='批量操作完成！<br/><div style="font-size:12px;"><br/>'+msg_err<?=$time?>+'</div>'
            	fun_win_sys_msg('【开票批量操作】操作结果:',msg)

            	msg_err<?=$time?>='';
            	$('#table_index<?=$time?>').datagrid('loaded');
            	$('#table_index<?=$time?>').datagrid('reload');
            	$('#table_index<?=$time?>').datagrid('clearChecked');
            }
            else
            {            
            	list=json.list;
            	fun_operate_more<?=$time?>(list,btn)
            }
		}
    });
}

//所属机构查询
function load_ou_org_search<?=$time?>()
{
	var row_s =  $('#table_search<?=$time?>').propertygrid('getSelected');
	var index_s = $('#table_search<?=$time?>').propertygrid('getRowIndex',row_s);
	
	var ed=$('#table_search<?=$time?>').propertygrid('getEditor',{index: index_s,field:'value'});

	$(ed.target).combotree('reload','base/auto/get_json_hr_org/from/combobox/field_id/ou_id/field_text/ou_name')
	
}

function fun_end_ou_org_search<?=$time?>()
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

//客户名称查询
function load_org_search<?=$time?>()
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
function load_c_search<?=$time?>()
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

//发票类型
function load_bill_category_search<?=$time?>()
{
	var row_s =  $('#table_search<?=$time?>').propertygrid('getSelected');
	var index_s = $('#table_search<?=$time?>').propertygrid('getRowIndex',row_s);
	
	var ed=$('#table_search<?=$time?>').propertygrid('getEditor',{index: index_s,field:'value'});

	$(ed.target).combotree('reload','proc_bud/invoice_type/get_json/from/combobox/field_id/it_id/field_text/it_name')
	
}

function fun_end_bill_category_search<?=$time?>()
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

//部门查询
function load_ou_search<?=$time?>()
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
</script>