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

    //
    load_table_pa_eq<?=$time?>();

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
                param['content[pa_eq]']=data_form['content[pa_eq]'];
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
                if(json.err.pa_eq)
                {
                    $.messager.show({
                        title:'警告',
                        msg: json.err.pa_eq,
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
						url+='/act/<?=STAT_ACT_EDIT?>/pa_id/'+json.id

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

//自研产品--获取
function load_table_pa_eq<?=$time?>()
{
    $('#table_pa_eq<?=$time?>').edatagrid({
        width:'100%',
        height:'150',
        toolbar:'#table_pa_eq_tool<?=$time?>',
        singleSelect:true,
        selectOnCheck:false,
        checkOnSelect:false,
        striped:true,
        rownumbers:true,
        showFooter:false,
        idField:'pa_id',
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
        frozenColumns:[[
            {field:'pa_id',title:'',width:50,align:'center',checkbox:true},
            {field:'pa_eq_id',title:'设备名称',width:150,halign:'center',align:'left',
                formatter: fun_table_pa_eq_formatter<?=$time?>,
                editor:{
                    type:'combobox',
                    options:{
                        panelHeight:'0',
                        required:true,
                        valueField: 'id',
                        textField: 'text',
                        hasDownArrow:false,
                        buttonIcon:'icon-clear',
                        onClickButton:function()
                        {
                            $(this).combobox('clear');
                        }
                    }
                }
            },
            {field:'pa_eq_model',title:'设备型号',width:200,halign:'center',align:'left',formatter: fun_table_pa_eq_formatter<?=$time?>,
                editor:{
                    type:'textbox',
                    options:{
                        readonly:true,
                        icons:[{
                            iconCls:'icon-lock'
                        }]
                    }
                }
            },
        ]],
        columns:[[
            {field:'pa_eq_price',title:'单价',width:100,halign:'center',align:'right',formatter: fun_table_pa_eq_formatter<?=$time?>,
                editor:{
                    type:'numberbox',
                    options:{
                        precision:2,
                        decimalSeparator:'.',
                        groupSeparator:',',
                        required : true,
                        icons:[{
                            iconCls:'icon-clear',

                        }]
                    }
                }
            },
            {field:'pa_eq_num',title:'数量',width:100,halign:'center',align:'right',formatter: fun_table_pa_eq_formatter<?=$time?>,
                editor:{
                    type:'numberbox',
                    options:{
                        required : true,
                        icons:[{
                            iconCls:'icon-clear',

                        }]
                    }
                }
            },
            {field:'pa_eq_total',title:'小计',width:150,halign:'center',align:'right',formatter: fun_table_pa_eq_formatter<?=$time?>,
                editor:{
                    type:'numberbox',
                    options:{
                        precision:2,
                        decimalSeparator:'.',
                        groupSeparator:',',
                        readonly : true,
                        icons:[{
                            iconCls:'icon-lock'
                        }]
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
            var rows=$('#table_pa_eq<?=$time?>').datagrid('getRows');
            var total_price=0;
            for(var i=0 ; i<rows.length;i++){
                total_price+=parseInt(rows[i]['pa_eq_total'])
            }
            document.getElementById("eq_total<?=$time?>").innerText = total_price;
        },
        onBeginEdit: function(index,row)
        {
            var eq_list=$(this).datagrid('getEditors',index);

            var pa_eq_id = '';
            var pa_eq_model = '';
            var pa_eq_total = '';
            var pa_eq_price = '';
            for(var i = 0;i < eq_list.length; i++)
            {

                switch(eq_list[i].field)
                {
                    case 'pa_eq_id':

                        pa_eq_id = eq_list[i].target;

                        if(row.pa_eq_id) $(eq_list[i].target).combobox('setValue',row.pa_eq_id);
                        if(row.pa_eq_id_s) $(eq_list[i].target).combobox('setText',row.pa_eq_id_s);

                        break;
                    case 'pa_eq_model':

                        pa_eq_model = eq_list[i].target;

                        break;
                    case 'pa_eq_price':

                        pa_eq_price = eq_list[i].target;
                        $(eq_list[i].target).numberbox('textbox').css('text-align','right');
                        break;
                    case 'pa_eq_num':
                        $(eq_list[i].target).numberbox('textbox').css('text-align','right');
                        break;

                }
            }
            $(pa_eq_id).combobox('textbox').autocomplete({
                serviceUrl: 'base/auto/get_json_eq',
                width:'150',
                params:{
                    rows:10,
                },
                onSelect: function (suggestion) {
                    var eq_id = base64_decode(suggestion.data.eq_id);
                    var eq_name = base64_decode(suggestion.data.eq_name);
                    var index = $('#table_pa_eq<?=$time?>').datagrid('getRowIndex',base64_decode(suggestion.data.eq_id));

//                    if(index > -1)
//                    {
//                        layer.tips(eq_name+'已存在！'
//                            , $(pa_eq_id).combobox('textbox')
//                            ,{
//                                tips: [1],
//                                time: 2000
//                            }
//                        );
//                        $(pa_eq_id).combobox('clear');
//                        return;
//                    }

                    $(pa_eq_id).combobox('setValue',base64_decode(suggestion.data.eq_id));
                    $(pa_eq_id).combobox('setText',base64_decode(suggestion.data.eq_name));

//                    $(pa_eq_model).textbox('setText',base64_decode(suggestion.data.eq_model));
                    $(pa_eq_model).textbox('setValue',base64_decode(suggestion.data.eq_model));
                }
            });
        },
        onEndEdit: function(index, row, changes)
        {
            var eq_list=$(this).datagrid('getEditors',index);

            for(var i = 0;i < eq_list.length; i++)
            {
                switch(eq_list[i].field)
                {
                    case 'pa_eq_id':

                        row.pa_eq_id_s = $(eq_list[i].target).combobox('getText');
                        row.pa_eq_id = $(eq_list[i].target).combobox('getValue');
                        break;
                    case 'pa_eq_model':
                        row.pa_eq_model=$(eq_list[i].target).textbox('getValue');
                        break;
                    case 'pa_eq_price':
                        var price=$(eq_list[i].target).numberbox('getValue');
                        break;
                    case 'pa_eq_num':
                        var num=$(eq_list[i].target).numberbox('getValue');
                        var total=num*price;

                        row.pa_eq_total = num*price;

                        break;



                }
            }


            var rows=$('#table_pa_eq<?=$time?>').datagrid('getRows');
            var total_price=0;
            for(var i=0 ; i<rows.length;i++){
                total_price+=parseInt(rows[i]['pa_eq_total'])
            }
            document.getElementById("eq_total<?=$time?>").innerText = total_price;
        }

    });
}
//自研产品--列格式化
function fun_table_pa_eq_formatter<?=$time?>(value,row,index){

    switch(this.field)
    {

        default:
            if(row[this.field+'_s'])
                value = row[this.field+'_s'];
    }

    if( ! value ) value = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ;
    return '<span id="table_pa_eq<?=$time?>_'+index+'_'+this.field+'" class="table_pa_eq<?=$time?>" >'+value+'</span>';
}

//自研产品--操作
function fun_table_pa_eq_operate<?=$time?>(btn)
{
    switch(btn)
    {
        case 'add':
            var op_id = get_guid();
            $('#table_pa_eq<?=$time?>').edatagrid('addRow',{
                index:0,
                row:{
                    pa_id: op_id
                }
            });

            break;
        case 'add_more':
            var win_id=fun_get_new_win();

            $('#'+win_id).window({
                title: '添加设备',
                inline:true,
                modal:true,
//    			closed:true,
                border:'thin',
                draggable:false,
                resizable:false,
                collapsible:false,
                minimizable:false,
                maximizable:false,
            })

            $('#'+win_id).window('refresh','proc_eq/eq/index/search_c_type/1/fun_open/window/fun_open_id/'+win_id+'/flag_select/1/fun_select/fun_pa_eq_add<?=$time?>');
            $('#'+win_id).window('center');
            break;

        case 'del':

            var op_list=$('#table_pa_eq<?=$time?>').datagrid('getChecked');

            var row_s = $('#table_pa_eq<?=$time?>').datagrid('getSelected');
            var index_s = $('#table_pa_eq<?=$time?>').datagrid('getRowIndex',row_s);

            if($('#table_pa_eq<?=$time?>').datagrid('validateRow',index_s))
            {
                $('#table_pa_eq<?=$time?>').datagrid('endEdit',index_s);
            }
            else
            {
                $('#table_pa_eq<?=$time?>').datagrid('cancelEdit',index_s);
            }

            for(var i=op_list.length-1;i>-1;i--)
            {
                var index = $('#table_pa_eq<?=$time?>').datagrid('getRowIndex',op_list[i]);
                $('#table_pa_eq<?=$time?>').datagrid('deleteRow',index);
            }

            break;
    }
}
//批量添加
function fun_pa_eq_add<?=$time?>(op)
{
    $(op).closest('.op_window').window('close');

    var list=$(op).datagrid('getChecked');

    for(var i=0;i<list.length;i++)
    {
        var row = {};
        row.pa_id = get_guid();
        row.pa_eq_id = base64_decode(list[i].eq_id);
        row.pa_eq_id_s = base64_decode(list[i].eq_name);
        row.pa_eq_model = base64_decode(list[i].eq_model);
        row.pa_eq_price = base64_decode(list[i].eq_price);

        var index = $('#table_pa_eq<?=$time?>').datagrid('getRowIndex',row.pa_eq_id);

        if(index < 0)
            $('#table_pa_eq<?=$time?>').datagrid('appendRow',row);
    }

    $(op).closest('.op_window').window('destroy').remove();
}


function load_win_edit<?=$time?>(op_id,act)
{
    var url = 'proc_eq/eq/edit/act/'+act;

    if(op_id)
        url+='/eq_id/'+op_id

    fun_index_win_open<?=$time?>('创建设备','win',url)
}
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

function load_pa_gfc_id<?=$time?>()
{
    var opt = $('#txtb_pa_gfc_id_s<?=$time?>').textbox('options');

    if(  opt.readonly ) return;


    $('#txtb_pa_gfc_id_s<?=$time?>').textbox('textbox').autocomplete({
        serviceUrl: 'base/auto/get_json_gfc',
        params:{
            rows:10,
        },
        onSelect: function (suggestion) {

            $('#txtb_pa_gfc_id_s<?=$time?>').textbox('setValue',base64_decode(suggestion.data.gfc_finance_code));
            $('#txtb_pa_gfc_id<?=$time?>').val(base64_decode(suggestion.data.gfc_id));

        }
    });

}










</script>