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
	var no_page = '1';

	if('<?=$no_page?>') 
		no_page='<?=$no_page?>';

	$('#table_index<?=$time?>').attr("no_page",no_page);
		
	var col=[[

        {field:'doc_efftime_start',title:'有效期',width:200,halign:'center',align:'center',sortable:true,
            formatter: fun_index_formatter<?=$time?>,
            sorter:function(a,b){
                a = a.split('-');
                b = b.split('-');
                if (a[0] == b[0]){
                    if (a[1] == b[1]){
                        return (a[2]>b[2]?1:-1);
                    } else {
                        return (a[1]>b[1]?1:-1);
                    }
                } else {
                    return (a[0]>b[0]?1:-1);
                }
            }
        },
        {field:'doc_sub_person_s',title:'递交人',width:200,halign:'center',align:'center',sortable:true,
            formatter: fun_index_formatter<?=$time?>
        },
        {field:'doc_keep_person_s',title:'档案保管人',width:200,halign:'center',align:'center',sortable:true,
            formatter: fun_index_formatter<?=$time?>
        },
        {field:'doc_protect_person_s',title:'档案维护人',width:200,halign:'center',align:'center',sortable:true,
            formatter: fun_index_formatter<?=$time?>
        },
        {field:'doc_alert_time',title:'提醒日期',width:200,halign:'center',align:'center',sortable:true,
            formatter: fun_index_formatter<?=$time?>,
            sorter:function(a,b){
                a = a.split('-');
                b = b.split('-');
                if (a[0] == b[0]){
                    if (a[1] == b[1]){
                        return (a[2]>b[2]?1:-1);
                    } else {
                        return (a[1]>b[1]?1:-1);
                    }
                } else {
                    return (a[0]>b[0]?1:-1);
                }
            }
        },
        {field:'doc_key_word',title:'关键字',width:200,halign:'center',align:'center',sortable:true,
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
				{field:'doc_id',title:'',checkbox:true,halign:'center',align:'center',
					formatter: fun_index_formatter<?=$time?>
				},
				{field:'doc_name',title:'档案名称',width:200,halign:'center',align:'left',sortable:true,
					formatter: fun_index_formatter<?=$time?>
				},
                {field:'doc_org_s',title:'归属公司',width:200,halign:'center',align:'left',sortable:true,
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
		title:'档案列表',
		toolbar:'#table_index_tool<?=$time?>',
		url:'proc_doc/doc/get_json.html',
		idField:'doc_id',
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

	load_table_search('table_search<?=$time?>',field_search_value_dispaly,field_search_rule,field_search_start,<?=$field_search_rule_default?>,'<?=$conf_search?>')

}

//列格式化输出
function fun_index_formatter<?=$time?>(value,row,index){

	value=base64_decode(value);
	switch(this.field)
	{
        case 'doc_name':

            var url='proc_doc/doc/edit/act/2/doc_id/'+base64_decode(row.doc_id);
            value='<a href="javascript:void(0);" class="link" onClick="fun_index_win_open<?=$time?>(\''+base64_decode(row.doc_id).substring(0,10)+'\',\'win\',\''+url+'\');">'+value+'</a>';

            break;

        case 'doc_efftime_start':

            if(row.doc_efftime_start){
                value =base64_decode(row.doc_efftime_start) +' 至 '+base64_decode(row.doc_efftime_end);
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
	var url = 'proc_doc/doc/edit/act/'+act;

	if(op_id)
		url+='/doc_id/'+op_id

	fun_index_win_open<?=$time?>('创建价格审核表','win',url)
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
		var id=op_list[i]['doc_id'];

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
        url:"app/run_back/proc_doc/doc/fun_operate_more.html",
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
            	fun_win_sys_msg('【机构批量操作】操作结果:',msg)

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

//提交人（保管人，维护人）查询
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

//部门查询
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
			rows:10,
			data_search:JSON.stringify(json)
		},
  	  onSelect: function (suggestion) {

			$('#table_search<?=$time?>').propertygrid('updateRow',{
				index: index_s,
				row: {
					value: base64_decode(suggestion.data.org_id),
					value_s: base64_decode(suggestion.data.org_name)
				}
			});
		}
	});

	$(ed.target).combobox('textbox').focus();
}
</script>