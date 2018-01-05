<!-- 加载jquery -->
<script type="text/javascript">

function load_hr_code<?=$time?>()
{
	var opt = $('#txtb_hr_code<?=$time?>').textbox('options');

	if(  opt.readonly ) return;

	var data_form = fun_get_data_from_f('f_<?=$time?>');

	$('#txtb_hr_code<?=$time?>').textbox({
		icons: [{
			iconCls:'icon-reload',
			handler: function(e){

				 //保存配置
				$.ajax({
			        url:"proc_hr/hr_info/fun_reload_hr_code.html",
			        type:"POST",
			        async:false,
			        data:{
			        	c_id: '<?=$c_id?>',
			        	'content[c_hr_org]': data_form['content[c_hr_org]'],
			        	'content[c_ou_2]': data_form['content[c_ou_2]'],
			        	'content[hr_type_work]': data_form['content[hr_type_work]'],
					},
			        success:function(data){
				        
				        var json = {};
				        if(data) json = JSON.parse(data);

				        $('#txtb_hr_code<?=$time?>').textbox('setValue',json.hr_code);
				        $('#txtb_hr_code_pre<?=$time?>').textbox('setValue',json.hr_code_pre);
					}
			    });
			}
		}]
	});
}

function load_c_ou_2_s<?=$time?>()
{
	var opt = $('#txtb_c_ou_2_s<?=$time?>').textbox('options');

	if(  opt.readonly ) return;

	$('#txtb_c_ou_2_s<?=$time?>').textbox({
		buttonIcon:'icon-clear',
    	onClickButton:function()
        {
			$(this).textbox('clear');
			$('#txtb_c_ou_2<?=$time?>').val('');
        }
	});

	var c_org = $('#txtb_c_org<?=$time?>').combobox('getValue');
	
	var json = [
		{"field":"ou_tag","rule":"find_in_set","value":"2"}
	]

	if(c_org) json.push({"field":"ou_org","rule":"=","value":c_org})
	
	$('#txtb_c_ou_2_s<?=$time?>').textbox('textbox').autocomplete({
        serviceUrl: 'base/auto/get_json_ou',
        width:'300',
        params:{
			rows:10,
			data_search:JSON.stringify(json)
		},
        onSelect: function (suggestion) {
			$('#txtb_c_ou_2_s<?=$time?>').textbox('setValue',base64_decode(suggestion.data.ou_name));
			$('#txtb_c_ou_2<?=$time?>').val(base64_decode(suggestion.data.ou_id));

			$('#txtb_c_ou_3_s<?=$time?>').textbox('setValue',base64_decode(suggestion.data.ou_name));
			$('#txtb_c_ou_3<?=$time?>').val(base64_decode(suggestion.data.ou_id))
			
			$('#txtb_c_ou_4_s<?=$time?>').textbox('setValue',base64_decode(suggestion.data.ou_name));
			$('#txtb_c_ou_4<?=$time?>').val(base64_decode(suggestion.data.ou_id))
			
			load_c_ou_3_s<?=$time?>();
		}
	});
}

function load_c_ou_3_s<?=$time?>()
{
	var opt = $('#txtb_c_ou_3_s<?=$time?>').textbox('options');

	if(  opt.readonly ) return;

	$('#txtb_c_ou_3_s<?=$time?>').textbox({
		buttonIcon:'icon-clear',
    	onClickButton:function()
        {
			$(this).textbox('clear');
			$('#txtb_c_ou_3<?=$time?>').val('');
        }
	});

	var c_org = $('#txtb_c_org<?=$time?>').combobox('getValue');
	var c_ou_2 = $('#txtb_c_ou_2<?=$time?>').val();
	
	var json = [
    	{"field":"ou_parent_path","rule":"find_in_set","value":c_ou_2},
    	{"field":"ou_tag","rule":"find_in_set","value":"2"}
    ]

	if(c_org) json.push({"field":"ou_org","rule":"=","value":c_org})
    
    $('#txtb_c_ou_3_s<?=$time?>').textbox('textbox').autocomplete({
        serviceUrl: 'base/auto/get_json_ou',
        width:'300',
        params:{
			rows:10,
			data_search:JSON.stringify(json)
		},
        onSelect: function (suggestion) {
			$('#txtb_c_ou_3_s<?=$time?>').textbox('setValue',base64_decode(suggestion.data.ou_name));
			$('#txtb_c_ou_3<?=$time?>').val(base64_decode(suggestion.data.ou_id));

			$('#txtb_c_ou_4_s<?=$time?>').textbox('setValue',base64_decode(suggestion.data.ou_name));
			$('#txtb_c_ou_4<?=$time?>').val(base64_decode(suggestion.data.ou_id))
			
			load_c_ou_4_s<?=$time?>();
		}
	});
}

function load_c_ou_4_s<?=$time?>()
{
	var opt = $('#txtb_c_ou_4_s<?=$time?>').textbox('options');

	if(  opt.readonly ) return;

	$('#txtb_c_ou_4_s<?=$time?>').textbox({
		buttonIcon:'icon-clear',
    	onClickButton:function()
        {
			$(this).textbox('clear');
			$('#txtb_c_ou_4<?=$time?>').val('');
        }
	});

	var c_org = $('#txtb_c_org<?=$time?>').combobox('getValue');
	var c_ou_3 = $('#txtb_c_ou_3<?=$time?>').val();
	
	var json = [
		{"field":"ou_parent_path","rule":"find_in_set","value":c_ou_3},
		{"field":"ou_tag","rule":"find_in_set","value":"2"}
	]

	if(c_org) json.push({"field":"ou_org","rule":"=","value":c_org})
	
	$('#txtb_c_ou_4_s<?=$time?>').textbox('textbox').autocomplete({
        serviceUrl: 'base/auto/get_json_ou',
        width:'300',
        params:{
			rows:10,
			data_search:JSON.stringify(json)
		},
        onSelect: function (suggestion) {
			$('#txtb_c_ou_4_s<?=$time?>').textbox('setValue',base64_decode(suggestion.data.ou_name));
			$('#txtb_c_ou_4<?=$time?>').val(base64_decode(suggestion.data.ou_id))
		}
	});
}

//职位
function load_c_job_s<?=$time?>()
{
	var opt = $('#txtb_c_job_s<?=$time?>').textbox('options');

	if(  opt.readonly ) return;

	$('#txtb_c_job_s<?=$time?>').textbox({
    	onClickButton:function()
        {
			$(this).textbox('clear');
			$('#txtb_c_job<?=$time?>').val('');
        },
		icons: [{
			iconCls:'icon-add',
			handler: function(e){
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
					maximizable:false,
					onClose: function()
					{
						$('#'+win_id).window('destroy');
						$('#'+win_id).remove();
					}
				})
				
				var url='proc_hr/hr_job/edit'
				$('#'+win_id).window('refresh',url+'/fun_open/win/fun_open_id/'+win_id);
			}
		}]
	});
		
	$('#txtb_c_job_s<?=$time?>').textbox('textbox').autocomplete({
        serviceUrl: 'proc_hr/hr_job/get_json',
        width:'300',
        params:{
			rows:10
		},
        onSelect: function (suggestion) {
			$('#txtb_c_job_s<?=$time?>').textbox('setValue',base64_decode(suggestion.data.job_name));
			$('#txtb_c_job<?=$time?>').val(base64_decode(suggestion.data.job_id))
		}
	});
}

//技术方向
function load_hr_tec<?=$time?>()
{
	var opt = $('#txtb_hr_tec<?=$time?>').tagbox('options');

	if(  opt.readonly ) return;

	$('#txtb_hr_tec<?=$time?>').tagbox({
		icons:[{
			iconCls:'icon-add',
			handler: function(e){
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
				maximizable:false,
				onClose: function()
				{
					$('#txtb_hr_tec<?=$time?>').tagbox('reload',opt.url_l)
					$('#'+win_id).window('destroy');
					$('#'+win_id).remove();
				}
			})
			
			var url='proc_hr/hr_tec/edit'
			$('#'+win_id).window('refresh',url+'/fun_open/win/fun_open_id/'+win_id);
			}
		}]
	});

	$('#txtb_hr_tec<?=$time?>').tagbox('textbox').bind('focus',function(){
		$(this).parent().prev().tagbox('showPanel');
	})
}

//公司培训记录--载入
function load_table_hr_train_org<?=$time?>()
{
	$('#table_hr_train_org<?=$time?>').datagrid({
		width:'100%',
		height:'150',
		toolbar:'#table_hr_train_org_tool<?=$time?>',
		singleSelect:true,
		selectOnCheck:false,
		checkOnSelect:false,
		striped:true,
		remoteSort:false,
		idField:'hr_t_id',
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
			{field:'hr_t_ca_name',title:'证书名称',width:150,halign:'center',align:'center',
				formatter: fun_table_hr_train_org_formatter<?=$time?>,
			},
			{field:'hr_t_expense',title:'培训费用',width:100,halign:'center',align:'right',
				formatter: fun_table_hr_train_org_formatter<?=$time?>,
			},
			{field:'hr_t_date_work',title:'服务期期限',width:100,halign:'center',align:'center',
				formatter: fun_table_hr_train_org_formatter<?=$time?>,
			},
			{field:'hr_t_org',title:'培训单位',width:150,halign:'center',align:'center',
				formatter: fun_table_hr_train_org_formatter<?=$time?>,
			},
			{field:'hr_t_note',title:'备注',width:150,halign:'center',align:'left',
				formatter: fun_table_hr_train_org_formatter<?=$time?>,
			},
		]],
		frozenColumns:[[
			{field:'hr_t_id',title:'',width:50,align:'center',checkbox:true},
			{field:'hr_t_time_start',title:'培训时间',width:180,halign:'center',align:'left',
				formatter: fun_table_hr_train_org_formatter<?=$time?>,sortable:true,
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
			{field:'hr_t_name',title:'培训名称',width:150,halign:'center',align:'left',
				formatter: fun_table_hr_train_org_formatter<?=$time?>,
			},
		]],
		rowStyler: function(index,row){
			if (row.hide){
				return 'display:none'; 
			}
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

	if( arr_view<?=$time?>.indexOf('content[hr_train_org]')>-1 )
	{
		$('#table_hr_train_org_tool<?=$time?> .oa_op').hide();
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



}

//列格式化输出
function fun_table_hr_train_org_formatter<?=$time?>(value,row,index){

	switch(this.field)
	{
		case 'hr_t_time_start':
			value = row.hr_t_time_start+' 至 '+row.hr_t_time_end;

			var url='proc_hr/hr_train/edit/act/2/fun_no_db/fun_no_db_table_hr_train_org<?=$time?>';
			value='<a href="javascript:void(0);" class="link" onClick="fun_table_hr_train_org_win_open<?=$time?>(\''+row.hr_t_name.substring(0,10)+'\',\'win\',\''+url+'\',\''+row.hr_t_id+'\');">'+value+'</a>';
			
			break;
		case 'hr_t_expense':
			value = num_parse(value);
			break;
		default:
			if(row[this.field+'_s'])
				value = row[this.field+'_s'];
	}

	if( ! value ) value = '' ;
	return '<span id="table_hr_train_org<?=$time?>_'+index+'_'+this.field+'" class="table_hr_train_org<?=$time?>" >'+value+'</span>';
}

//界面
function fun_table_hr_train_org_win_open<?=$time?>(title,fun,url,id)
{
	switch(fun)
	{
		case 'win':

			var row ={};
			if(id)
			{
				 $('#table_hr_train_org<?=$time?>').datagrid('selectRecord',id);
				 row = $('#table_hr_train_org<?=$time?>').datagrid('getSelected');
			}
			
			var win_id=fun_get_new_win();

			var params={};
            params.data_db = base64_encode(JSON.stringify(row));

            if( '<?=$log_time?>' )
            {
                var log_content = $('#table_hr_train_org<?=$time?>').attr('log_content');

                if(log_content && id)
                {
                    log_content = JSON.parse(log_content);

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

//培训记录--操作
function fun_table_hr_train_org_operate<?=$time?>(btn)
{
	switch(btn)
	{
		case 'add':

			$('#table_hr_train_org<?=$time?>').datagrid('clearSelections');

			var url = 'proc_hr/hr_train/edit/fun_no_db/fun_no_db_table_hr_train_org<?=$time?>/act/1/hr_t_type/<?=HR_T_TYPE_ORG?>';

			fun_table_hr_train_org_win_open<?=$time?>('创建培训记录','win',url)

			break;
		case 'del':

			var op_list=$('#table_hr_train_org<?=$time?>').datagrid('getChecked');

			var row_s = $('#table_hr_train_org<?=$time?>').datagrid('getSelected');
			var index_s = $('#table_hr_train_org<?=$time?>').datagrid('getRowIndex',row_s);

			if($('#table_hr_train_org<?=$time?>').datagrid('validateRow',index_s))
			{
				$('#table_hr_train_org<?=$time?>').datagrid('endEdit',index_s);
			}
			else
			{
				$('#table_hr_train_org<?=$time?>').datagrid('cancelEdit',index_s);
			}

			for(var i=op_list.length-1;i>-1;i--)
			{
				var index = $('#table_hr_train_org<?=$time?>').datagrid('getRowIndex',op_list[i]);
				$('#table_hr_train_org<?=$time?>').datagrid('deleteRow',index);
			}

			break;
	}
}

function fun_no_db_table_hr_train_org<?=$time?>(f_id,btn)
{
	var row_s = $('#table_hr_train_org<?=$time?>').datagrid('getSelected');
	var row = fun_get_data_from_f(f_id,'1');

	$('#'+f_id).closest('.op_window').window('close');
	
	if( row_s )
	{
		var index_s = $('#table_hr_train_org<?=$time?>').datagrid('getRowIndex',row_s);

		if(btn == 'del')
		{
			$('#table_hr_train_org<?=$time?>').datagrid('deleteRow',index_s);
			return;
		}
		
		$('#table_hr_train_org<?=$time?>').datagrid('updateRow',{
			index: index_s,
			row: row
		});
	}
	else
	{
		row.hr_t_id = get_guid();
		
		$('#table_hr_train_org<?=$time?>').datagrid('appendRow',row);
	}
}

//公司奖惩记录
function load_table_hr_reward<?=$time?>()
{
	$('#table_hr_reward<?=$time?>').datagrid({
		width:'100%',
		height:'150',
		toolbar:'#table_hr_reward_tool<?=$time?>',
		singleSelect:true,
		selectOnCheck:false,
		checkOnSelect:false,
		remoteSort:false,
		striped:true,
		idField:'hr_rp_id',
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
			{field:'hr_rp_date',title:'开始时间',width:100,halign:'center',align:'center',
				formatter: fun_table_hr_reward_formatter<?=$time?>,sortable:true,
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
			{field:'hr_rp_type',title:'奖惩类别',width:80,halign:'center',align:'center',
				formatter: fun_table_hr_reward_formatter<?=$time?>,
			},
			{field:'hr_rp_content',title:'奖惩内容',width:150,halign:'center',align:'center',
				formatter: fun_table_hr_reward_formatter<?=$time?>,
			},
			{field:'hr_rp_cause',title:'奖惩原因',width:150,halign:'center',align:'center',
				formatter: fun_table_hr_reward_formatter<?=$time?>,
			},
			{field:'hr_rp_ou_approve',title:'批准部门',width:150,halign:'center',align:'center',
				formatter: fun_table_hr_reward_formatter<?=$time?>,
			},
			{field:'hr_rp_person_approve',title:'批准人',width:150,halign:'center',align:'center',
				formatter: fun_table_hr_reward_formatter<?=$time?>,
			},
		]],
		frozenColumns:[[
			{field:'hr_rp_id',title:'',width:50,align:'center',checkbox:true},
			{field:'hr_rp_doc_code',title:'文件号',width:180,halign:'center',align:'left',
				formatter: fun_table_hr_reward_formatter<?=$time?>,
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

	if( arr_view<?=$time?>.indexOf('content[hr_reward]')>-1 )
	{
		$('#table_hr_reward_tool<?=$time?> .oa_op').hide();
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



}

//列格式化输出
function fun_table_hr_reward_formatter<?=$time?>(value,row,index){

	switch(this.field)
	{
		case 'hr_rp_doc_code':

			value = row.hr_rp_doc_code;

			var c_org = $('#txtb_c_org<?=$time?>').combobox('getValue');
			var url = 'proc_hr/hr_reward/edit/act/2/fun_no_db/fun_no_db_table_hr_reward<?=$time?>/c_id/<?=$c_id?>/c_org/'+c_org;
			value='<a href="javascript:void(0);" class="link" onClick="fun_table_hr_reward_win_open<?=$time?>(\''+row.hr_rp_type.substring(0,10)+'\',\'win\',\''+url+'\',\''+row.hr_rp_id+'\');">'+value+'</a>';

			break;
		case 'hr_rp_type':
			switch(value){
				case '<?=HR_RP_TYPE_JIANG?>':
					value = '奖';
					break;
				case '<?=HR_RP_TYPE_CHENG?>':
					value = '惩';
					break;
			}
			break;


		default:
			if(row[this.field+'_s'])
				value = row[this.field+'_s'];
	}

	if( ! value ) value = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ;
	return '<span id="table_hr_reward<?=$time?>_'+index+'_'+this.field+'" class="table_hr_reward<?=$time?>" >'+value+'</span>';
}

//界面
function fun_table_hr_reward_win_open<?=$time?>(title,fun,url,id)
{
	switch(fun)
	{
		case 'win':

			var row ={};
			if(id)
			{
				$('#table_hr_reward<?=$time?>').datagrid('selectRecord',id);
				row = $('#table_hr_reward<?=$time?>').datagrid('getSelected');
			}

			var win_id=fun_get_new_win();

			var params={};
            params.data_db = base64_encode(JSON.stringify(row));

            if( '<?=$log_time?>' )
            {
                var log_content = $('#table_hr_reward<?=$time?>').attr('log_content');

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

//奖惩记录--操作
function fun_table_hr_reward_operate<?=$time?>(btn)
{
	switch(btn)
	{
		case 'add':

			$('#table_hr_reward<?=$time?>').datagrid('clearSelections');

			var c_org = $('#txtb_c_org<?=$time?>').combobox('getValue');
			var url = 'proc_hr/hr_reward/edit/fun_no_db/fun_no_db_table_hr_reward<?=$time?>/act/1/c_id/<?=$c_id?>/c_org/'+c_org;

			fun_table_hr_reward_win_open<?=$time?>('创建奖惩记录','win',url)

			break;
		case 'del':

			var op_list=$('#table_hr_reward<?=$time?>').datagrid('getChecked');

			var row_s = $('#table_hr_reward<?=$time?>').datagrid('getSelected');
			var index_s = $('#table_hr_reward<?=$time?>').datagrid('getRowIndex',row_s);

			if($('#table_hr_reward<?=$time?>').datagrid('validateRow',index_s))
			{
				$('#table_hr_reward<?=$time?>').datagrid('endEdit',index_s);
			}
			else
			{
				$('#table_hr_reward<?=$time?>').datagrid('cancelEdit',index_s);
			}

			for(var i=op_list.length-1;i>-1;i--)
			{
				var index = $('#table_hr_reward<?=$time?>').datagrid('getRowIndex',op_list[i]);
				$('#table_hr_reward<?=$time?>').datagrid('deleteRow',index);
			}

			break;
	}
}

function fun_no_db_table_hr_reward<?=$time?>(f_id,btn)
{
	var row_s = $('#table_hr_reward<?=$time?>').datagrid('getSelected');
	var row = fun_get_data_from_f(f_id,'1');

	$('#'+f_id).closest('.op_window').window('close');

	if( row_s )
	{
		var index_s = $('#table_hr_reward<?=$time?>').datagrid('getRowIndex',row_s);

		if(btn == 'del')
		{
			$('#table_hr_reward<?=$time?>').datagrid('deleteRow',index_s);
			return;
		}

		row.c_id = '<?=$c_id?>';
		$('#table_hr_reward<?=$time?>').datagrid('updateRow',{
			index: index_s,
			row: row
		});
	}
	else
	{
		row.hr_rp_id = get_guid();

		$('#table_hr_reward<?=$time?>').datagrid('appendRow',row);
	}
}

//合同信息
function load_table_hr_contract<?=$time?>()
{
    $('#table_hr_contract<?=$time?>').datagrid({
        width:'100%',
        height:'150',
        toolbar:'#table_hr_contract_tool<?=$time?>',
        singleSelect:true,
        selectOnCheck:false,
        checkOnSelect:false,
        remoteSort:false,
        striped:true,
        idField:'cont_id',
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
            {field:'cont_year',title:'合同年限',width:100,halign:'center',align:'center',
                formatter: fun_table_hr_contract_formatter<?=$time?>
            },
//            {field:'c_name_s',title:'员工姓名',width:150,halign:'center',align:'center',
//                formatter: fun_table_hr_contract_formatter<?=$time?>,
//            },
            {field:'cont_hr_type',title:'人员类别',width:150,halign:'center',align:'center',
                formatter: fun_table_hr_contract_formatter<?=$time?>,
            },
            {field:'cont_hr_type_work',title:'用工形式',width:150,halign:'center',align:'center',
                formatter: fun_table_hr_contract_formatter<?=$time?>,
            },
            {field:'cont_type',title:'合同性质',width:150,halign:'center',align:'center',
                formatter: fun_table_hr_contract_formatter<?=$time?>,
            },
        ]],
        frozenColumns:[[
            {field:'cont_id',title:'',width:50,align:'center',checkbox:true},
            {field:'cont_time_start',title:'合同时间',width:180,halign:'center',align:'left',
                formatter: fun_table_hr_contract_formatter<?=$time?>,sortable:true,
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
        ]],
        rowStyler: function(index,row){
            if (row.act == <?=STAT_ACT_CREATE?>)
                return 'background:#ffd2d2';
            if (row.act == <?=STAT_ACT_REMOVE?>)
                return 'background:#e0e0e0';
        },
        onLoadSuccess: function(data)
        {
            var row = $('#table_hr_contract<?=$time?>').datagrid('getRows');
        },
        onBeginEdit: function(index,row)
        {
        },
        onEndEdit: function(index, row, changes)
        {
            
        }

    });

    if( arr_view<?=$time?>.indexOf('content[hr_contract]')>-1 )
    {
        $('#table_hr_contract_tool<?=$time?> .oa_op').hide();
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



}

//列格式化输出
function fun_table_hr_contract_formatter<?=$time?>(value,row,index){
    switch(this.field)
    {
        case 'cont_time_start':
            value=row.cont_time_start+'至'+row.cont_time_end;

            var url='proc_hr/hr_contract/edit/act/2/fun_no_db/fun_no_db_table_hr_contract<?=$time?>';

            value='<a href="javascript:void(0);" class="link" onClick="fun_table_hr_contract_win_open<?=$time?>(\''+row.cont_time_end.substring(0,10)+'\',\'win\',\''+url+'\',\''+row.cont_id+'\');">'+value+'</a>';
            break;
        case 'c_id':
            if(row.c_name_s)
                value=row.c_name_s;

            break;

        default:
            if(row[this.field+'_s'])
                value = row[this.field+'_s'];
    }

    if( ! value ) value = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ;
    return '<span id="table_hr_contract<?=$time?>_'+index+'_'+this.field+'" class="table_hr_contract<?=$time?>" >'+value+'</span>';
}

//界面
function fun_table_hr_contract_win_open<?=$time?>(title,fun,url,id)
{
    switch(fun)
    {
        case 'win':

            var row ={};
            if(id)
            {
                $('#table_hr_contract<?=$time?>').datagrid('selectRecord',id);
                row = $('#table_hr_contract<?=$time?>').datagrid('getSelected');
            }

            var win_id=fun_get_new_win();

            var params={};
            params.data_db = base64_encode(JSON.stringify(row));

            if( '<?=$log_time?>' )
            {
                var log_content = $('#table_hr_contract<?=$time?>').attr('log_content');

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

//合同信息--操作
function fun_table_hr_contract_operate<?=$time?>(btn)
{
    switch(btn)
    {
        case 'add':

            $('#table_hr_contract<?=$time?>').datagrid('clearSelections');

            var c_org = $('#txtb_c_org<?=$time?>').combobox('getValue');
            var url = 'proc_hr/hr_contract/edit/fun_no_db/fun_no_db_table_hr_contract<?=$time?>/act/1/c_id/<?=$c_id?>/c_org/'+c_org;

            fun_table_hr_contract_win_open<?=$time?>('创建合同信息','win',url)

            break;
        case 'del':

            var op_list=$('#table_hr_contract<?=$time?>').datagrid('getChecked');

            var row_s = $('#table_hr_contract<?=$time?>').datagrid('getSelected');
            var index_s = $('#table_hr_contract<?=$time?>').datagrid('getRowIndex',row_s);

            if($('#table_hr_contract<?=$time?>').datagrid('validateRow',index_s))
            {
                $('#table_hr_contract<?=$time?>').datagrid('endEdit',index_s);
            }
            else
            {
                $('#table_hr_contract<?=$time?>').datagrid('cancelEdit',index_s);
            }

            for(var i=op_list.length-1;i>-1;i--)
            {
                var index = $('#table_hr_contract<?=$time?>').datagrid('getRowIndex',op_list[i]);
                $('#table_hr_contract<?=$time?>').datagrid('deleteRow',index);
            }

            break;
    }
}

function fun_no_db_table_hr_contract<?=$time?>(f_id,btn)
{
    var row_s = $('#table_hr_contract<?=$time?>').datagrid('getSelected');
    var row = fun_get_data_from_f(f_id,'1');

    $('#'+f_id).closest('.op_window').window('close');

    if( row_s )
    {
        var index_s = $('#table_hr_contract<?=$time?>').datagrid('getRowIndex',row_s);

        if(btn == 'del')
        {
            $('#table_hr_contract<?=$time?>').datagrid('deleteRow',index_s);
            fun_load_hr_contract<?=$time?>();
            return;
        }

        row.c_id = '<?=$c_id?>';
        $('#table_hr_contract<?=$time?>').datagrid('updateRow',{
            index: index_s,
            row: row
        });
    }
    else
    {
        row.cont_id = get_guid();

        $('#table_hr_contract<?=$time?>').datagrid('appendRow',row);
    }

    fun_load_hr_contract<?=$time?>();
}

function fun_load_hr_contract<?=$time?>()
{
	$('#table_hr_contract<?=$time?>').datagrid('sort',  {	        
		sortName: 'cont_time_start',
		sortOrder: 'desc'
	});
	
	var rows = $('#table_hr_contract<?=$time?>').datagrid('getRows');

	if(rows.length > 0)
	{
		var row = rows[0];

		$("#table_hr_work<?=$time?> [oaname='content[hr_time_ht]']").html(row.cont_time_start);
		$("#table_hr_work<?=$time?> [oaname='content[hr_time_htdq]']").html(row.cont_time_end);
		$("#table_hr_work<?=$time?> [oaname='content[hr_ht_year]']").html(row.cont_year);

		var hr_num_xq = 0;
		if(rows.length > 1) hr_num_xq = rows.length-1;
		$("#table_hr_work<?=$time?> [oaname='content[hr_num_xq]']").html(hr_num_xq);
		
		$("#table_hr_work<?=$time?> [oaname='content[hr_type]']").combobox('setValue',row.cont_hr_type);
		$("#table_hr_work<?=$time?> [oaname='content[hr_type_work]']").combobox('setValue',row.cont_hr_type_work);
	}
	else
	{
		$("#table_hr_work<?=$time?> [oaname='content[hr_time_ht]']").html('');
		$("#table_hr_work<?=$time?> [oaname='content[hr_time_htdq]']").html('');
		$("#table_hr_work<?=$time?> [oaname='content[hr_ht_year]']").html('');
		$("#table_hr_work<?=$time?> [oaname='content[hr_num_xq]']").html('');
	}
}

//信息系统
function load_table_office<?=$time?>()
{
  $('#table_office<?=$time?>').datagrid({
      width:'100%',
      height:'150',
      singleSelect:true,
      selectOnCheck:false,
      checkOnSelect:false,
//      remoteSort:false,
      striped:true,
      idField:'offai_id',
      url: 'proc_office/oa_offai/get_json/search_c_id/<?=$c_id?>/flag_start/1',
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
	    	{field:'offai_start_info',title:'开通信息',width:200,halign:'center',align:'left',
	    		formatter: fun_table_office_formatter<?=$time?>,
	    	},
//	    	{field:'offai_end_info',title:'注销信息',width:150,halign:'center',align:'left',
//	    		formatter: fun_table_office_formatter<?=$time?>,
//	    	},
	    	{field:'offai_note',title:'备注',width:200,halign:'center',align:'center',
	    		formatter: fun_table_office_formatter<?=$time?>,
	    	},
      ]],
      frozenColumns:[[
	    	{field:'offai_id',title:'',width:50,align:'center',checkbox:true},
	    	{field:'offai_offi_id',title:'信息系统',width:200,halign:'center',align:'left',
	    		formatter: fun_table_office_formatter<?=$time?>,
	    	},
	    	{field:'offai_model',title:'模块',width:200,halign:'center',align:'left',
	    		formatter: fun_table_office_formatter<?=$time?>,
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
          var row = $('#table_office<?=$time?>').datagrid('getRows');
      },
      onBeginEdit: function(index,row)
      {
      },
      onEndEdit: function(index, row, changes)
      {
          
      }

  });

  if( arr_view<?=$time?>.indexOf('content[office]')>-1 )
  {
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
}

//列格式化输出
function fun_table_office_formatter<?=$time?>(value,row,index){

	value = base64_decode(value);
  switch(this.field)
  {
	   case 'offai_offi_id':
			
			if(row.offai_offi_id)
				value= base64_decode(row.offai_offi_id_s);
			
			break;
		case 'offai_start_info':
			if(row.offai_person_start)
				value = base64_decode(row.offai_time_start)+'<br>'+base64_decode(row.offai_person_start_s)+'开通 ';
			break;
	
		case 'offai_end_info':
			if(row.offai_person_end)
				value = base64_decode(row.offai_time_end)+'<br>'+base64_decode(row.offai_person_end_s)+'注销 ';
	
			break;
      default:
          if(row[this.field+'_s'])
              value = row[this.field+'_s'];
  }

  if( ! value ) value = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ;
  return '<span id="table_office<?=$time?>_'+index+'_'+this.field+'" class="table_office<?=$time?>" >'+value+'</span>';
}

</script>