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

	//个人借款
	load_table_loan_ending<?=$time?>();

	//关联冲账
	load_table_loan_cz<?=$time?>();
	
	setTimeout(function(){
		
		//添加只读，编辑,必填
		fun_form_operate('f_<?=$time?>',arr_view<?=$time?>,arr_edit<?=$time?>,arr_required<?=$time?>);

		//载入数据
		load_form_data_<?=$time?>();

		load_sub<?=$time?>();

		load_loan_bud<?=$time?>()

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
			var act='<?=$act?>';
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

					return;
				}

				//遍历form 错误消息添加
				fun_show_errmsg_of_form('f_<?=$time?>',json.err);

				$(this).form('enableValidation').form('validate');
			}
			else
			{
				fun_send_wl(json);
				
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
						url+='/act/<?=STAT_ACT_EDIT?>/loan_id/'+json.id

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

    				    switch(btn)
						{
							case 'yj':
								url=url.replace('/act/2','/act/3');
							case 'next':
							case 'pnext':
								reload_page<?=$time?>(url);	
							break;
						}
					}
				}
			}
		}
	});
}

//界面
function fun_index_win_open<?=$time?>(title,fun,url)
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

//个人借款--载入
function load_table_loan_ending<?=$time?>()
{
    $('#table_loan_ending<?=$time?>').datagrid({
        width:'100%',
        height:'120',
//        toolbar:'#table_loan_ending_tool<?=$time?>',
        singleSelect:true,
        selectOnCheck:false,
        checkOnSelect:false,
        striped:true,
        remoteSort: false,
        idField:'loan_id',
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
            {field:'loan_code',title:'单据编号',width:120,halign:'center',align:'left',
                formatter: fun_table_loan_ending_formatter<?=$time?>,
            },
            {field:'loan_sum',title:'金额',width:120,halign:'center',align:'right',
                formatter: fun_table_loan_ending_formatter<?=$time?>,
            },
            {field:'loan_ending_sum',title:'未冲账金额',width:120,halign:'center',align:'right',
                formatter: fun_table_loan_ending_formatter<?=$time?>,
            },
            {field:'loan_sub_s',title:'预算科目',width:120,halign:'center',align:'center',
                formatter: fun_table_loan_ending_formatter<?=$time?>,
            },
            {field:'loan_time_node',title:'日期',width:80,halign:'center',align:'center',
                formatter: fun_table_loan_ending_formatter<?=$time?>,
            },
            {field:'loan_return_month',title:'预计归还月',width:80,halign:'center',align:'center',
                formatter: fun_table_loan_ending_formatter<?=$time?>,
            },
            {field:'ppo',title:'流程节点',width:100,halign:'center',align:'center',
                formatter: fun_table_loan_ending_formatter<?=$time?>,
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
//            if(data.total > 0) 
//            {
//            	fun_tr_title_show($('#table_f_<?=$time?>'),'title_loan_ending',1);
//            }
//            else if(data.total == 0)
//            {
//            	fun_tr_title_show($('#table_f_<?=$time?>'),'title_loan_ending');
//            }

            $('#l_<?=$time?> .prog_loan_ending_sum<?=$time?>').progressbar();
			$('#l_<?=$time?> .prog_loan_ending_sum<?=$time?>').find('.progressbar-text').css('text-align','right');
		},
		onResizeColumn: function(field, width)
		{
			if(field == 'loan_ending_sum')
			$('#l_<?=$time?> .prog_loan_ending_sum<?=$time?>').progressbar();
		},
        onBeginEdit: function(index,row)
        {
        	var ed_list=$(this).datagrid('getEditors',index);

			for(var i = 0;i < ed_list.length; i++)
			{
				
			}
        },
    });

    if(data_<?=$time?>['content[loan_c_id]'])
    {
    	var url = 'proc_loan/loan/get_json/flag_ending/1/search_c_id/'+data_<?=$time?>['content[loan_c_id]'];
    	$('#table_loan_ending<?=$time?>').datagrid('reload',url);
    }

    if( arr_view<?=$time?>.indexOf('content[loan_ending]')>-1 )
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
function fun_table_loan_ending_formatter<?=$time?>(value,row,index){

	value = base64_decode(value);
    switch(this.field)
    {
	    case 'loan_code':
		    
	    	var url='proc_loan/loan/edit/act/2/loan_id/'+base64_decode(row.loan_id);
			value='<a href="javascript:void(0);" class="link" onClick="fun_index_win_open<?=$time?>(\''+base64_decode(row.loan_code)+'\',\'win\',\''+url+'\');">'+value+'</a>';
			
	    	break;
	    case 'loan_sum':
			value = num_parse(value);
		    break;
	    case 'loan_ending_sum':
			var loan_ending_sum = base64_decode(row.loan_ending_sum);
			var loan_sum = base64_decode(row.loan_sum);
			var per = parseFloat(loan_ending_sum/loan_sum*100).toFixed(2);
			
			value = num_parse(loan_ending_sum);
			value = '<div class="easyui-progressbar prog_loan_ending_sum<?=$time?>" data-options="value:'+per+',text:\''+value+'\'" style="width:100%;"></div> '

			break;
    }

    if( ! value ) value = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ;
    return '<span id="table_loan_ending<?=$time?>_'+index+'_'+this.field+'" class="table_loan_ending<?=$time?>" >'+value+'</span>';
}

//关联冲账--载入
function load_table_loan_cz<?=$time?>()
{
    $('#table_loan_cz<?=$time?>').datagrid({
        width:'100%',
        height:'120',
//        toolbar:'#table_loan_cz_tool<?=$time?>',
        singleSelect:true,
        selectOnCheck:false,
        checkOnSelect:false,
        striped:true,
        remoteSort: false,
        idField:'loan_id',
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
            {field:'code',title:'单据编号',width:150,halign:'center',align:'left',
                formatter: fun_table_loan_cz_formatter<?=$time?>,
            },
            {field:'time',title:'时间',width:120,halign:'center',align:'center',
                formatter: fun_table_loan_cz_formatter<?=$time?>,
            },
            {field:'sum',title:'金额',width:120,halign:'center',align:'right',
                formatter: fun_table_loan_cz_formatter<?=$time?>,
            },
            {field:'ppo',title:'流程节点',width:100,halign:'center',align:'center',
                formatter: fun_table_loan_cz_formatter<?=$time?>,
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
//            if(data.total > 0) 
//            {
//            	fun_tr_title_show($('#table_f_<?=$time?>'),'title_loan_cz',1);
//            }
//            else if(data.total == 0)
//            {
//            	fun_tr_title_show($('#table_f_<?=$time?>'),'title_loan_cz');
//            }

		},
        onBeginEdit: function(index,row)
        {
        	var ed_list=$(this).datagrid('getEditors',index);

			for(var i = 0;i < ed_list.length; i++)
			{
				
			}
        },
    });

    if('<?=$ppo?>' == '<?=LOAN_PPO_END?>')
    {
    	var url = 'proc_loan/loan/get_json_cz/loan_id/<?=$loan_id?>';
    	$('#table_loan_cz<?=$time?>').datagrid('reload',url);
    }

    if( arr_view<?=$time?>.indexOf('content[loan_cz]')>-1 )
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
function fun_table_loan_cz_formatter<?=$time?>(value,row,index){

	value = base64_decode(value);
    switch(this.field)
    {
	    case 'code':

		    if(row.bs_id)
		    {
		    	var url='proc_bs/bs/edit/act/2/bs_id/'+base64_decode(row.bs_id);
		    }
		    else
		    {
		    	var url='proc_bal/bal/edit/act/2/bal_id/'+base64_decode(row.bal_id);
		    }

		    value='<a href="javascript:void(0);" class="link" onClick="fun_index_win_open<?=$time?>(\''+value+'\',\'win\',\''+url+'\');">'+value+'</a>';
	    	break;
	    	
	    case 'sum':
			value = num_parse(value);
		    break;
    }

    if( ! value ) value = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ;
    return '<span id="table_loan_cz<?=$time?>_'+index+'_'+this.field+'" class="table_loan_cz<?=$time?>" >'+value+'</span>';
}

//申请人自动补全
function load_c<?=$time?>()
{
	var opt = $('#txtb_loan_c_id_s<?=$time?>').textbox('options');

	if(  opt.readonly ) return;

	$('#txtb_loan_c_id_s<?=$time?>').textbox({
		onClickButton:function()
        {
			$(this).textbox('clear');
			$('#txtb_loan_c_id<?=$time?>').val('');
			$('#txtb_loan_c_id_org<?=$time?>').val('');
        }
	});

	$('#txtb_loan_c_id_s<?=$time?>').textbox('textbox').autocomplete({
		serviceUrl: 'base/auto/get_json_contact/search_c_login_id/1',
		width:'300',
		params:{
			rows:10,
		},
		onSelect: function (suggestion) {
			var c_id = base64_decode(suggestion.data.c_id)
			$('#txtb_loan_c_id_s<?=$time?>').textbox('setValue',base64_decode(suggestion.data.c_show));
			$('#txtb_loan_c_id<?=$time?>').val(c_id);

			$('#txtb_loan_ou_s<?=$time?>').textbox('setValue',base64_decode(suggestion.data.c_ou_bud_s));
			$('#txtb_loan_ou<?=$time?>').val(base64_decode(suggestion.data.c_ou_bud));

			$('#txtb_loan_c_id_org<?=$time?>').val(base64_decode(suggestion.data.c_org));

			var url = 'proc_loan/loan/get_json/flag_ending/1/search_c_id/'+c_id;
			$('#table_loan_ending<?=$time?>').datagrid('reload',url);
		}
	});
}

//部门自动补全
function load_ou<?=$time?>()
{
	var opt = $('#txtb_loan_ou_s<?=$time?>').textbox('options');

	if(  opt.readonly ) return;

	$('#txtb_loan_ou_s<?=$time?>').textbox({
		onClickButton:function()
        {
			$(this).textbox('clear');
			$('#txtb_loan_ou<?=$time?>').val('');
        }
	});

	var gfc_org = $('#txtb_loan_c_id_org<?=$time?>').val();

	var json = [
		{"field":"ou_org","rule":"=","value":gfc_org},
		{"field":"ou_tag","rule":"find_in_set","value":"1"}
	]

	$('#txtb_loan_ou_s<?=$time?>').textbox('textbox').autocomplete({
        serviceUrl: 'base/auto/get_json_ou',
        width:'400',
        params:{
			rows:10,
			data_search:JSON.stringify(json)
		},
        onSelect: function (suggestion) {

			var ou_id = base64_decode(suggestion.data.ou_id);

			$('#txtb_loan_ou_s<?=$time?>').textbox('setValue',base64_decode(suggestion.data.ou_name));
			$('#txtb_loan_ou<?=$time?>').val(ou_id);
		}
	});
}

//关联项目
function load_gfc_id<?=$time?>()
{
	var opt = $('#txtb_loan_gfc_id_s<?=$time?>').textbox('options');

	if(  opt.readonly ) return;

	$('#txtb_loan_gfc_id_s<?=$time?>').textbox({
		onClickButton:function()
		{
			$('#txtb_loan_gfc_id_s<?=$time?>').textbox('clear');
			$('#txtb_loan_gfc_id<?=$time?>').val('');

			fun_tr_title_show($('#table_f_<?=$time?>'),'title_gfc');

			$('#txtb_loan_sub_s<?=$time?>').textbox('clear');
			$('#txtb_loan_sub<?=$time?>').val('');
			
			load_sub<?=$time?>();
		},
		onChange:function(newValue, oldValue)
		{
			if( ! newValue )
			{
				$('#txtb_loan_gfc_id_s<?=$time?>').textbox('clear');
				$('#txtb_loan_gfc_id<?=$time?>').val('');

				fun_tr_title_show($('#table_f_<?=$time?>'),'title_gfc');

				$('#txtb_loan_sub_s<?=$time?>').textbox('clear');
				$('#txtb_loan_sub<?=$time?>').val('');
				
				load_sub<?=$time?>();
			}
		},
		icons: [{
			iconCls:'icon-search',
			handler: function(e){
			
				var win_id=fun_get_new_win();
				
			    $('#'+win_id).window({
			     	title: '请选择项目',
			     	inline:true,
			     	modal:true,
			     	border:'thin',
			     	draggable:false,
			     	resizable:false,
			     	collapsible:false,
			     	minimizable: false,
			     	maximizable: false,
			     	onClose: function()
			     	{
			     		$('#'+win_id).window('destroy');
			     		$('#'+win_id).remove();
			     	}
			     })
		
			     $('#'+win_id).window('refresh','proc_gfc/gfc/index/fun_open/window/fun_open_id/'+win_id+'/flag_select/2/fun_select/fun_get_gfc_id<?=$time?>/search_gfc_finance_code/1');
			     $('#'+win_id).window('center');
			}
		}]
	});

	$('#txtb_loan_gfc_id_s<?=$time?>').textbox('textbox').autocomplete({
		serviceUrl: 'proc_gfc/gfc/get_json/search_gfc_finance_code/1/',
		params:{
			rows:10,
			field_s:'gfc_name,gfc_finance_code,gfc_sum'
		},
		onSelect: function (suggestion) {
			
			$('#txtb_loan_gfc_id_s<?=$time?>').textbox('setValue',base64_decode(suggestion.data.gfc_finance_code));

			var gfc_id = base64_decode(suggestion.data.gfc_id)
			$('#txtb_loan_gfc_id<?=$time?>').val(gfc_id);

			$("#table_f_<?=$time?> [oaname='content[gfc_name]']").html(base64_decode(suggestion.data.gfc_name));

			$("#table_f_<?=$time?> [oaname='content[gfc_finance_code]']").html(base64_decode(suggestion.data.gfc_finance_code));
			$("#table_f_<?=$time?> [oaname='content[gfc_sum]']").html(num_parse(base64_decode(suggestion.data.gfc_sum)));

			$("#table_f_<?=$time?> [oaname='content[gfc_ou_tj]']").html(base64_decode(suggestion.data.gfc_ou_tj_s));

			start_ou_tj<?=$time?> = base64_decode(suggestion.data.gfc_ou_tj);
			start_ou_tj_s<?=$time?> = base64_decode(suggestion.data.gfc_ou_tj_s);
			$('#txtb_loan_ou_tj<?=$time?>').combobox('setValue',start_ou_tj<?=$time?>);
			$('#txtb_loan_ou_tj<?=$time?>').combobox('setText',start_ou_tj_s<?=$time?>);

			fun_tr_title_show($('#table_f_<?=$time?>'),'title_gfc',1);

			$('#txtb_loan_sub_s<?=$time?>').textbox('clear');
			$('#txtb_loan_sub<?=$time?>').val('');
			
			load_sub<?=$time?>();
		}
	});
}

//选择项目
function fun_get_gfc_id<?=$time?>(op)
{
	var row_c=$(op).datagrid('getChecked');
	 
	if( row_c.length == 0) 
	{
		$.messager.show({
	    	title:'警告',
	    	msg:'请选择项目！',
	    	timeout:1500,
	    	showType:'show',
	    	border:'thin',
          style:{
              right:'',
              bottom:'',
          }
	    });
		return;
	}

	var row = row_c[0];

	$(op).closest('.op_window').window('close');
	
	$('#txtb_loan_gfc_id_s<?=$time?>').textbox('setValue',base64_decode(row.gfc_finance_code));

	var gfc_id = base64_decode(row.gfc_id)
	$('#txtb_loan_gfc_id<?=$time?>').val(gfc_id);

	$("#table_f_<?=$time?> [oaname='content[gfc_name]']").html(base64_decode(row.gfc_name));

	$("#table_f_<?=$time?> [oaname='content[gfc_finance_code]']").html(base64_decode(row.gfc_finance_code));
	$("#table_f_<?=$time?> [oaname='content[gfc_sum]']").html(num_parse(base64_decode(row.gfc_sum)));

	$("#table_f_<?=$time?> [oaname='content[gfc_ou_tj]']").html(base64_decode(row.gfc_ou_tj_s));

	fun_tr_title_show($('#table_f_<?=$time?>'),'title_gfc',1);

	$('#txtb_loan_sub_s<?=$time?>').textbox('clear');
	$('#txtb_loan_sub<?=$time?>').val('');
	
	load_sub<?=$time?>();
}

//预算科目
function load_sub<?=$time?>()
{
	var opt = $('#txtb_loan_sub_s<?=$time?>').textbox('options');

	if(  opt.readonly ) return;

	$('#txtb_loan_sub_s<?=$time?>').textbox({
		onClickButton:function()
		{
			$('#txtb_loan_sub_s<?=$time?>').textbox('clear');
			$('#txtb_loan_sub<?=$time?>').val('');
		},
	});
	
	var gfc_id = $('#txtb_loan_gfc_id<?=$time?>').val();

	var url = 'base/auto/get_json_sub/search_sub_class/3'

	if(gfc_id)
		url = 'base/auto/get_json_sub/search_gfc_id/'+gfc_id;
		
	$('#txtb_loan_sub_s<?=$time?>').textbox('textbox').autocomplete({
      serviceUrl: url,
      width:'300',
      params:{
			rows:10,
	  },
      onSelect: function (suggestion) {
	      	var sub = base64_decode(suggestion.data.sub_id);
	      	
			$('#txtb_loan_sub_s<?=$time?>').textbox('setValue',base64_decode(suggestion.data.sub_name));
			$('#txtb_loan_sub<?=$time?>').val(sub);

			var sum = $('#txtb_loan_sum<?=$time?>').numberbox('getValue');
			var sub = sub;
			
			if( sub && sum)
			{
				var url = 'proc_bud/bl_ppo/get_json_ou/from/combobox/field_id/link_id/field_text/ou_name/search_sub/'+sub+'/search_sum/'+sum;
				$('#txtb_loan_ou_tj<?=$time?>').combobox('reload',url);
//				$('#txtb_loan_ou_tj<?=$time?>').combobox('clear');

				load_loan_bud<?=$time?>();
			}
		}
	});
}

//金额右侧输入
function load_loan_sum<?=$time?>()
{
    $('#txtb_loan_sum<?=$time?>').numberbox('textbox').css('text-align','right');
}

//金额右侧输入
function load_loan_ending_sum<?=$time?>()
{
    $('#txtb_loan_ending_sum<?=$time?>').numberbox('textbox').css('text-align','right');
}

//预算
function load_loan_bud<?=$time?>()
{
	var sum = $('#txtb_loan_sum<?=$time?>').numberbox('getValue');
	var sub_id = $('#txtb_loan_sub<?=$time?>').val();
	var gfc_id = $('#txtb_loan_gfc_id<?=$time?>').val();

	if( ! gfc_id || ! sub_id) return; 
	
	$.ajax({
        url:"proc_gfc/gfc/get_bud_final",
        type:"POST",
        data:{
			'content[gfc_id]' : gfc_id,
			'content[sub_id]' : sub_id,
			'content[id]': '<?=$loan_id?>'
        },
        success:function(data){

        	if( ! data ) return;

            var json = JSON.parse(data);

            json.sum_final_no = parseFloat(json.sum_final_no);
            
            var per_final = parseFloat(json.sum_final/json.sum_bud*100).toFixed(2);
            var per_final_no = parseFloat(json.sum_final_no/json.sum_bud*100).toFixed(2);
            var per_sum = parseFloat(sum/json.sum_bud*100).toFixed(2);
            
            var html = '<div class="sui-progress" >'
                	   +'<div style="width: '+per_final+'%;" class="bar " onmouseenter="layer.tips(\'已执行:'+num_parse(json.sum_final)+'\', this);"></div>'
                	   +'<div style="width: '+per_sum+'%;" class="bar bar-success" onmouseenter="layer.tips(\'本次金额:'+num_parse(sum)+'\', this);"></div>'
                	   +'<div style="width: '+per_final_no+'%;" class="bar bar-warning" onmouseenter="layer.tips(\'未过账:'+num_parse(json.sum_final_no)+'\', this);"></div>'
                	   +'<div style="position:absolute; left:0px;width:100%;text-align:center;">预算:'+num_parse(json.sum_bud)+' </div>'
                	   +'</div>'
                	   
            $('#loan_bud<?=$time?>').html(html);

		}
    });
}

//统计部门自动补全
var check_loan_ou_tj<?=$time?> = 1;
var start_ou_tj<?=$time?> = '';
var start_ou_tj_s<?=$time?> = '';
function load_loan_ou_tj<?=$time?>()
{
	var sum = data_<?=$time?>['content[loan_sum]'];
	var sub = data_<?=$time?>['content[loan_sub]'];
	var ou = data_<?=$time?>['content[loan_ou_tj]'];
	var ou_s = data_<?=$time?>['content[loan_ou_tj_s]'];
	
	if( sub )
	{
		var url = 'proc_bud/bl_ppo/get_json_ou/from/combobox/field_id/link_id/field_text/ou_name/search_sub/'+sub+'/search_sum/'+sum;
		if( ou ) url += '/search_ou/'+ou;
		
		$('#txtb_loan_ou_tj<?=$time?>').combobox('reload',url);
	}

	start_ou_tj<?=$time?> = ou;
	start_ou_tj_s<?=$time?> = ou_s;
}

function load_loan_ou_tj_combobox<?=$time?>()
{
	var opt = $('#txtb_loan_ou_tj<?=$time?>').combobox('options');

	if(  opt.readonly ) return;
	if(  opt.hasDownArrow ) return;
	
	check_loan_ou_tj<?=$time?> = 0;
	
	$('#txtb_loan_ou_tj<?=$time?>').combobox({
		hasDownArrow:true,
		limitToList:true,
		buttonIcon:'icon-clear',
		onClickButton:function()
		{
			$(this).combobox('clear');
		}
	});

	$('#txtb_loan_ou_tj<?=$time?>').combobox('textbox').bind('focus',
	function(){
		$(this).parent().prev().combobox('showPanel');
	});

	check_loan_ou_tj<?=$time?> = 1;
}

function load_loan_ou_tj_auto<?=$time?>()
{
	var opt = $('#txtb_loan_ou_tj<?=$time?>').combobox('options');

	if(  opt.readonly ) return;

	check_loan_ou_tj<?=$time?> = 0;
	
	$('#txtb_loan_ou_tj<?=$time?>').combobox({
		hasDownArrow:false,
		limitToList:false,
		buttonIcon:'icon-clear',
		onClickButton:function()
		{
			$(this).combobox('clear');
		}
	});

	if(start_ou_tj<?=$time?>)
	{
		$('#txtb_loan_ou_tj<?=$time?>').combobox('setValue',start_ou_tj<?=$time?>);
		$('#txtb_loan_ou_tj<?=$time?>').combobox('setText',start_ou_tj_s<?=$time?>);
//		start_ou_tj<?=$time?> = '';
//		start_ou_tj_s<?=$time?> = '';
	}
	
	var json = [
		{"field":"ou_tag","rule":"find_in_set","value":"1"}
	]
	
	$('#txtb_loan_ou_tj<?=$time?>').combobox('textbox').autocomplete({
        serviceUrl: 'base/auto/get_json_ou',
        width:'400',
        params:{
			rows:10,
			data_search:JSON.stringify(json)
		},
        onSelect: function (suggestion) {

			var ou_id = base64_decode(suggestion.data.ou_id);
			var ou_name = base64_decode(suggestion.data.ou_name)

			$('#txtb_loan_ou_tj<?=$time?>').combobox('setValue',ou_id);
			$('#txtb_loan_ou_tj<?=$time?>').combobox('setText',ou_name);

			start_ou_tj<?=$time?> = ou_id;
			start_ou_tj_s<?=$time?> = ou_name;
		}
	});

	check_loan_ou_tj<?=$time?> = 1;
}

//付款单位自动补全
function load_loan_o_id<?=$time?>()
{
	var opt = $('#txtb_loan_o_id_s<?=$time?>').textbox('options');

	if(  opt.readonly ) return;

	$('#txtb_loan_o_id_s<?=$time?>').textbox({
		onClickButton: function()
		{
			$('#txtb_loan_o_id_s<?=$time?>').textbox('setValue','');
			$('#txtb_loan_o_id<?=$time?>').val('');
			$('#txtb_loan_oacc_bank<?=$time?>').combobox('clear');
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
					method:'post',
					onClose: function()
					{
						$('#'+win_id).window('destroy');
						$('#'+win_id).remove();
					}
				})
					
				var url = 'proc_org/org/edit/act/1';
				
				$('#'+win_id).window('refresh',url+'/fun_open/win/fun_open_id/'+win_id);
			}
		},{
			iconCls:'icon-edit',
			handler: function(e){

				var org = $('#txtb_loan_o_id<?=$time?>').val();

				if( ! org )
				{ 
					$.messager.show({
						title:'警告',
						msg:'请填写付款单位！',
						timeout:500,
						showType:'show',
						border:'thin',
						style:{
							right:'',
							bottom:'',
						}
					});
											
					return
				}
				
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
					method:'post',
					onClose: function()
					{
						$('#'+win_id).window('destroy');
						$('#'+win_id).remove();
					}
				})
					
				var url = 'proc_org/org/edit/act/2/o_id/'+org;
				
				$('#'+win_id).window('refresh',url+'/fun_open/win/fun_open_id/'+win_id);
			}
		}]
	})
	
	$('#txtb_loan_o_id_s<?=$time?>').textbox('textbox').autocomplete({
		serviceUrl: 'base/auto/get_json_org/search_o_status/1',
		params:{
			rows:10,
		},
		onSelect: function (suggestion) {
			var o_id = base64_decode(suggestion.data.o_id_standard)
			$('#txtb_loan_o_id_s<?=$time?>').textbox('setValue',base64_decode(suggestion.data.o_id_standard_s));
			$('#txtb_loan_o_id<?=$time?>').val(o_id);
			
			var url = 'proc_org/org/get_json_account/from/combobox/field_id/oacc_id/field_text/oacc_show/search_o_id/'+o_id
	    	$('#txtb_loan_oacc_bank<?=$time?>').combobox('reload',url);
		}
	});
}

//开户行
function load_loan_oacc_bank<?=$time?>(){

    var opt=$('#txtb_loan_oacc_bank<?=$time?>').textbox('options');

    var o_id = data_<?=$time?>['content[loan_o_id]']
    if(o_id)
    {
        var url = 'proc_org/org/get_json_account/from/combobox/field_id/oacc_id/field_text/oacc_show/search_o_id/'+o_id
    	$('#txtb_loan_oacc_bank<?=$time?>').combobox('reload',url);
    }
}

</script>