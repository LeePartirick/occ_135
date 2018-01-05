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

	//预收账款
	load_table_bsi<?=$time?>();
			
	//开票申请明细条目表
	load_table_bei<?=$time?>();

	//开票批准发票条目表
	load_table_bdi<?=$time?>();

	//关联单据
	load_table_bill_link<?=$time?>()
			
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
	
	fun_load_title(title_conf);

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

			if('<?=$flag_wl_win?>')
			$('#<?=$fun_open_id?>').window('close');
			
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

				param['content[bill_tax_sum]'] = data_form['content[bill_tax_sum_s]'];
				param['content[bill_takings]'] = data_form['content[bill_takings_s]'];

				param['content[bsi]'] = data_form['content[bsi]'];
				param['content[bei]'] = data_form['content[bei]'];
				param['content[bdi]'] = data_form['content[bdi]'];

				param['wl[wl_comment]']='';
				if($('#wl_comment<?=$time?>').length>0 
				&& $('#wl_comment<?=$time?>').attr('have_focus') == 1)
				{
					param['wl[wl_comment]']= self<?=$time?>.ue_wl_comment.getContent();
				}
				else
				{
					param['wl[wl_comment]']='';
				}
			}
			else
			{
				$(this).form('enableValidation').form('validate');
				
				return false;
			}

		},
		success: function(data){

//			alert(data);
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
					fun_send_wl(json);
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
						url+='/act/<?=STAT_ACT_EDIT?>/bill_id/'+json.id

						fun_send_wl(json);
						reload_page<?=$time?>(url);
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
								fun_send_wl(json);
								reload_page<?=$time?>(url);	
							break;
						}
					}
				}
			}
		}
	});
}

//关联项目
function load_gfc_id<?=$time?>()
{
	var opt = $('#txtb_gfc_name<?=$time?>').textbox('options');

	if(  opt.readonly ) return;

	$('#txtb_gfc_name<?=$time?>').textbox({
		onClickButton:function()
		{
			$('#txtb_gfc_name<?=$time?>').textbox('clear');
			$('#txtb_gfc_id<?=$time?>').val('');
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

	$('#txtb_gfc_name<?=$time?>').textbox('textbox').autocomplete({
		serviceUrl: 'proc_gfc/gfc/get_json/search_gfc_finance_code/1/',
		params:{
			rows:10,
			field_s:'gfc_name,gfc_finance_code,gfc_c,gfc_sum,gfc_org,gfc_org_jia,gfc_tax'
		},
		onSelect: function (suggestion) {
			
			$('#txtb_gfc_name<?=$time?>').textbox('setValue',base64_decode(suggestion.data.gfc_name));

			var gfc_id = base64_decode(suggestion.data.gfc_id)
			$('#txtb_gfc_id<?=$time?>').val(gfc_id);

			$("#table_f_<?=$time?> [oaname='content[gfc_finance_code]']").html(base64_decode(suggestion.data.gfc_finance_code));

			var gfc_org_jia_s = base64_decode(suggestion.data.gfc_org_jia_s);
			var gfc_org_jia = base64_decode(suggestion.data.gfc_org_jia);
			$("#table_f_<?=$time?> [oaname='content[gfc_org_jia_s]']").html(gfc_org_jia_s);
			$("#table_f_<?=$time?> [oaname='content[gfc_sum]']").html(num_parse(base64_decode(suggestion.data.gfc_sum)));

			var gfc_c_s = base64_decode(suggestion.data.gfc_c_s);
			var gfc_c = base64_decode(suggestion.data.gfc_c);
			$("#table_f_<?=$time?> [oaname='content[gfc_c_s]']").html(base64_decode(suggestion.data.gfc_c_s));
			
			var url = 'proc_gfc/gfc/get_json_bp/flag_bill/1/search_gfc_id/'+gfc_id;
			$('#txtb_bp_id<?=$time?>').combogrid('grid').datagrid('reload',url);
			$('#txtb_bp_id<?=$time?>').combogrid('showPanel');

			$('#txtb_bill_org_customer_s<?=$time?>').textbox('setValue',gfc_org_jia_s);
			$('#txtb_bill_org_customer<?=$time?>').val(gfc_org_jia);

			$('#txtb_bill_contact_manager_s<?=$time?>').textbox('setValue',gfc_c_s);
			$('#txtb_bill_contact_manager<?=$time?>').val(gfc_c);

			$('#txtb_bill_tax_s<?=$time?>').textbox('setValue',base64_decode(suggestion.data.gfc_tax_s));
			var gfc_tax = base64_decode(suggestion.data.gfc_tax)
			$('#txtb_bill_tax<?=$time?>').val(gfc_tax);

			$('#txtb_bill_category<?=$time?>').combobox('reload','proc_bud/invoice_type/get_json/from/combobox/field_id/it_id/field_text/it_name/search_t_id/'+gfc_tax)
					
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
	
	$('#txtb_gfc_name<?=$time?>').textbox('setValue',base64_decode(row.gfc_name));

	var gfc_id = base64_decode(row.gfc_id)
	$('#txtb_gfc_id<?=$time?>').val(gfc_id);

	$("#table_f_<?=$time?> [oaname='content[gfc_finance_code]']").html(base64_decode(row.gfc_finance_code));

	var gfc_org_jia_s = base64_decode(row.gfc_org_jia_s);
	var gfc_org_jia = base64_decode(row.gfc_org_jia);
	$("#table_f_<?=$time?> [oaname='content[gfc_org_jia_s]']").html(gfc_org_jia_s);
	$("#table_f_<?=$time?> [oaname='content[gfc_sum]']").html(num_parse(base64_decode(row.gfc_sum)));

	var gfc_c_s = base64_decode(row.gfc_c_s);
	var gfc_c = base64_decode(row.gfc_c);
	$("#table_f_<?=$time?> [oaname='content[gfc_c_s]']").html(base64_decode(row.gfc_c_s));
	
	var url = 'proc_gfc/gfc/get_json_bp/flag_bill/1/search_gfc_id/'+gfc_id;
	$('#txtb_bp_id<?=$time?>').combogrid('grid').datagrid('reload',url);
	$('#txtb_bp_id<?=$time?>').combogrid('showPanel');

	$('#txtb_bill_org_customer_s<?=$time?>').textbox('setValue',gfc_org_jia_s);
	$('#txtb_bill_org_customer<?=$time?>').val(gfc_org_jia);

	$('#txtb_bill_contact_manager_s<?=$time?>').textbox('setValue',gfc_c_s);
	$('#txtb_bill_contact_manager<?=$time?>').val(gfc_c);

	$('#txtb_bill_tax_s<?=$time?>').textbox('setValue',base64_decode(row.gfc_tax_s));
	var gfc_tax = base64_decode(row.gfc_tax)
	$('#txtb_bill_tax<?=$time?>').val(gfc_tax);

	$('#txtb_bill_category<?=$time?>').combobox('reload','proc_bud/invoice_type/get_json/from/combobox/field_id/it_id/field_text/it_name/search_t_id/'+gfc_tax)
}

//开票计划
function load_bp_id<?=$time?>()
{
	var gfc_id = data_<?=$time?>['content[gfc_id]'];

	if(gfc_id)
	{
		var url = 'proc_gfc/gfc/get_json_bp/flag_bill/1/search_gfc_id/'+gfc_id;
		$('#txtb_bp_id<?=$time?>').combogrid('grid').datagrid('reload',url);
	}
}

//开票计划列格式化输出
function fun_index_bp_formatter<?=$time?>(value,row,index){
	value=base64_decode(value);
	switch(this.field)
	{
		case 'bp_sum':

			var bp_sum = parseFloat(value);
			var bp_sum_kp = parseFloat(base64_decode(row.bp_sum_kp));
			
			var per = parseFloat(bp_sum_kp/bp_sum*100).toFixed(2);
			
			value = num_parse(value);
			
			value = '<div class="easyui-progressbar prog_bp_sum<?=$time?>" data-options="value:'+per+',text:\''+value+'\'" style="width:100%;"></div> '
			break;
	}

	return value;
}

//客户名称自动补全
function load_bill_org_customer<?=$time?>()
{
	var opt = $('#txtb_bill_org_customer_s<?=$time?>').textbox('options');

	if(  opt.readonly ) return;

	$('#txtb_bill_org_customer_s<?=$time?>').textbox({
		onClickButton:function()
		{
			$(this).textbox('clear');
			$('#txtb_bill_org_customer<?=$time?>').val('');
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

				var org = $('#txtb_bill_org_customer<?=$time?>').val();

				if( ! org )
				{ 
					$.messager.show({
						title:'警告',
						msg:'请填写客户名称！',
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
	
	$('#txtb_bill_org_customer_s<?=$time?>').textbox('textbox').autocomplete({
		serviceUrl: 'base/auto/get_json_org/search_o_status/1',
		params:{
			rows:10,
		},
		onSelect: function (suggestion) {
			
			$('#txtb_bill_org_customer_s<?=$time?>').textbox('setValue',base64_decode(suggestion.data.o_id_standard_s));
			$('#txtb_bill_org_customer<?=$time?>').val(base64_decode(suggestion.data.o_id_standard));
		}
	});
}

//载入开票计划执行
function load_gfc_bp_prog<?=$time?>()
{
	var sum = $('#txtb_bill_sum<?=$time?>').numberbox('getValue');

	var row = $('#txtb_bp_id<?=$time?>').combogrid('grid').datagrid('getSelected');
	var bp_id = row.bp_id

	if( ! bp_id ) return; 
	
	$.ajax({
        url:"proc_gfc/bp/get_bp_final",
        type:"POST",
        data:{
			'content[bp_id]' : bp_id,
			'content[id]': '<?=$bill_id?>'
        },
        success:function(data){

        	if( ! data ) return;

            var json = JSON.parse(data);

            var sum_bp_kp = parseFloat(base64_decode(row.bp_sum_kp));
            var sum_bp_kp_no = parseFloat(json.sum_bp_kp_no);
            var sum_bp = parseFloat(base64_decode(row.bp_sum));

            var per_final = parseFloat(sum_bp_kp/sum_bp*100).toFixed(2);
            var per_final_no = parseFloat(sum_bp_kp_no/sum_bp*100).toFixed(2);
            var per_sum = parseFloat(sum/sum_bp*100).toFixed(2);
            
            var html = '<div class="sui-progress" >'
           	   +'<div style="width: '+per_final+'%;" class="bar " onmouseenter="layer.tips(\'已开票:'+num_parse(sum_bp_kp)+'\', this);"></div>'
           	   +'<div style="width: '+per_sum+'%;" class="bar bar-success" onmouseenter="layer.tips(\'本次金额:'+num_parse(sum)+'\', this);"></div>'
           	   +'<div style="width: '+per_final_no+'%;" class="bar bar-warning" onmouseenter="layer.tips(\'未开票:'+num_parse(sum_bp_kp_no)+'\', this);"></div>'
           	   +'<div style="position:absolute; left:0px;width:100%;text-align:center;">计划金额:'+num_parse(sum_bp)+' </div>'
           	   +'</div>'
           	   
         	$('#gfc_bp_prog<?=$time?>').html(html);
		}
    });
}

//发票类型
function load_bill_category<?=$time?>()
{
	var bill_tax = data_<?=$time?>['content[bill_tax]'];//$('#txtb_bill_tax<?=$time?>').val();
	var bill_category = data_<?=$time?>['content[bill_category]'];
	
	$('#txtb_bill_category<?=$time?>').combobox('reload','proc_bud/invoice_type/get_json/from/combobox/field_id/it_id/field_text/it_name/search_t_id/'+bill_tax+'/search_it_id/'+bill_category);
//	$('#txtb_bill_category<?=$time?>').combobox('setValue',bill_category)
}

//开票金额
function load_bill_sum<?=$time?>()
{
	$('#txtb_bill_sum<?=$time?>').numberbox('textbox').css('text-align','right');
}

//流转税
function load_bill_tax<?=$time?>()
{
	$('#txtb_bill_tax_s<?=$time?>').textbox({
		readonly:true,
		buttonIcon:'icon-lock',
		onClickIcon:function()
		{

		}
	})
}

//营业收入
function load_bill_takings_s<?=$time?>()
{
	$('#txtb_bill_takings_s<?=$time?>').numberbox('textbox').css('text-align','right');
}

//税金
function load_bill_tax_sum_s<?=$time?>()
{
	$('#txtb_bill_tax_sum_s<?=$time?>').numberbox('textbox').css('text-align','right');
}

//计算
function fun_bill_count<?=$time?>()
{
	var bill_sum = $('#txtb_bill_sum<?=$time?>').numberbox('getValue');
	
	var bill_takings = 0;
	var bill_tax = 0;

	var it_taking_count = $('#txtb_it_taking_count<?=$time?>').val();
	var it_tax_count = $('#txtb_it_tax_count<?=$time?>').val();

	if(it_taking_count)
	{
		it_taking_count = it_taking_count.replace(/,/g, '');
		it_taking_count = it_taking_count.replace(/sum/g, bill_sum);
		bill_takings = eval(it_taking_count);
	}

	if(it_tax_count)
	{
		it_tax_count = it_tax_count.replace(/,/g, '');
		it_tax_count = it_tax_count.replace(/takings/g, bill_takings);
		bill_tax = eval(it_tax_count);
	}
	
	$('#txtb_bill_takings_s<?=$time?>').numberbox('setValue',bill_takings);
	$('#txtb_bill_tax_sum_s<?=$time?>').numberbox('setValue',bill_tax);
}

//应收账款
function load_bill_ending_sum<?=$time?>()
{
	$('#txtb_bill_ending_sum<?=$time?>').numberbox('textbox').css('text-align','right');
}

//开票统计人自动补全
function load_bill_contact_manager<?=$time?>()
{
	$('#txtb_bill_contact_manager_s<?=$time?>').textbox({
		readonly:true,
		buttonIcon:'icon-lock',
		onClickIcon:function()
		{

		}
	});
	
	var opt = $('#txtb_bill_contact_manager_s<?=$time?>').textbox('options');

	if(  opt.readonly ) return;

	$('#txtb_bill_contact_manager_s<?=$time?>').textbox({
		onClickButton:function()
		{
			$(this).textbox('clear');
			$('#txtb_bill_contact_manager<?=$time?>').val('');
		}
	});
	
	$('#txtb_bill_contact_manager_s<?=$time?>').textbox('textbox').autocomplete({
		serviceUrl: 'base/auto/get_json_contact/search_c_login_id/1',
		width:'300',
		params:{
			rows:10,
		},
		onSelect: function (suggestion) {
			$('#txtb_bill_contact_manager_s<?=$time?>').textbox('setValue',base64_decode(suggestion.data.c_show));
			$('#txtb_bill_contact_manager<?=$time?>').val(base64_decode(suggestion.data.c_id))
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

//预收账款--载入
function load_table_bsi<?=$time?>()
{
	var flag_change = '';
    $('#table_bsi<?=$time?>').edatagrid({
        width:'100%',
        height:'120',
//        toolbar:'#table_bsi_tool<?=$time?>',
        singleSelect:true,
        selectOnCheck:false,
        checkOnSelect:false,
        striped:true,
        remoteSort: false,
        idField:'bsi_id',
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
            {field:'bs_code',title:'单据编号',width:120,halign:'center',align:'left',
                formatter: fun_table_bsi_formatter<?=$time?>,
            },
            {field:'bs_time',title:'回款时间',width:80,halign:'center',align:'center',
                formatter: fun_table_bsi_formatter<?=$time?>,
            },
            {field:'bs_company_out_s',title:'回款单位',width:250,halign:'center',align:'center',
                formatter: fun_table_bsi_formatter<?=$time?>,
            },
            {field:'bsi_sum',title:'回款金额',width:120,halign:'center',align:'right',
                formatter: fun_table_bsi_formatter<?=$time?>,
            },
            {field:'bsi_sum_link',title:'关联金额',width:120,halign:'center',align:'right',
                formatter: fun_table_bsi_formatter<?=$time?>,
                editor:{
					type:'numberbox',
					options:{
                		err:err,
                		required:true,
                		precision:2,
		   				min:0,
		   				groupSeparator:',',
		   				buttonIcon:'icon-clear',
	            		onClickButton:function()
	            		{
	            			$(this).numberbox('clear');
	            		}
					}
				} 
            },
        ]],
        rowStyler: function(index,row){
            if (row.act == <?=STAT_ACT_CREATE?>)
                return 'background:#ffd2d2';
            if (row.act == <?=STAT_ACT_REMOVE?>)
                return 'background:#e0e0e0';

            if( '<?=$ppo?>' != 1 && ! '<?=$log_time?>' && row.bsi_sum_link > 0)
            	return 'background:#ffd2d2';
        },
        onLoadSuccess: function(data)
        {
            if(flag_change) return;
            
            if(data.total > 0) 
            {
            	fun_tr_title_show($('#table_f_<?=$time?>'),'title_bsi',1);

            	if(data_<?=$time?>['content[bsi]'])
            	{
					var rows = JSON.parse(data_<?=$time?>['content[bsi]']);

					for(var i=0; i<rows.length; i++)
					{
						rows[i].bsi_id = base64_encode(rows[i].bsi_id);
						var index = $(this).datagrid('getRowIndex',rows[i].bsi_id)
						if(index > -1)
						{
							$(this).datagrid('updateRow',{
								index : index,
								row:{ bsi_sum_link: rows[i].bsi_sum_link }
							})
						}
					}
            	}
            }
            else if(data.total == 0)
            {
            	fun_tr_title_show($('#table_f_<?=$time?>'),'title_bsi');
            }
        },
        onBeginEdit: function(index,row)
        {
        	var ed_list=$(this).datagrid('getEditors',index);

			for(var i = 0;i < ed_list.length; i++)
			{
				switch(ed_list[i].field)
				{
					case 'bsi_sum_link':
						$(ed_list[i].target).numberbox({
							max:row.bsi_sum
						});
						$(ed_list[i].target).numberbox('textbox').css('text-align','right');
    					break;
				}
			}
        },
        onEndEdit: function(index, row, changes)
        {
        	var ed_list=$(this).datagrid('getEditors',index);

//			for(var i = 0;i < ed_list.length; i++)
//			{
//				switch(ed_list[i].field)
//				{
//				}
//			}

        	flag_change = 1;
        },
    });

    if(data_<?=$time?>['content[bp_id]'])
    {
    	var url = 'proc_bs/bs_item/get_json/search_bp_id/'+data_<?=$time?>['content[bp_id]'];
    	$('#table_bsi<?=$time?>').datagrid('reload',url);
    }

    if( arr_view<?=$time?>.indexOf('content[bsi]')>-1 )
    {
    	$('#table_bsi<?=$time?>').edatagrid('disableEditing');
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
function fun_table_bsi_formatter<?=$time?>(value,row,index){

    switch(this.field)
    {
	    case 'bs_code':
		    
	    	var url='proc_bs/bs/edit/act/2/bs_id/'+base64_decode(row.bs_id);
			value='<a href="javascript:void(0);" class="link" onClick="fun_index_win_open<?=$time?>(\''+base64_decode(row.bs_code)+'\',\'win\',\''+url+'\');">'+base64_decode(value)+'</a>';
			
	    	break;
    	case 'bsi_sum':
    		value = base64_decode(value);
    	case 'bsi_sum_link':
    		value = num_parse(value);
        	break;
        	
        default:
            value = base64_decode(value);
    }

    if( ! value ) value = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ;
    return '<span id="table_bsi<?=$time?>_'+index+'_'+this.field+'" class="table_bsi<?=$time?>" >'+value+'</span>';
}

//开票申请明细条目表--载入
function load_table_bei<?=$time?>()
{
    $('#table_bei<?=$time?>').edatagrid({
        width:'100%',
        height:'150',
        toolbar:'#table_bei_tool<?=$time?>',
        singleSelect:true,
        selectOnCheck:false,
        checkOnSelect:false,
        striped:true,
        remoteSort: false,
        idField:'bei_id',
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
            {field:'bei_id',title:'',width:50,align:'center',checkbox:true},
            {field:'bei_name',title:'货物名称',width:150,halign:'center',align:'left',
                formatter: fun_table_bei_formatter<?=$time?>,
                editor:{
					type:'textbox',
					options:{
                		required:true,
                		buttonIcon:'icon-clear',
                		onClickButton:function()
                		{
                			$(this).textbox('clear');
                		}
					}
				} 
            },
            {field:'bei_model',title:'货物规格',width:200,halign:'center',align:'center',
                formatter: fun_table_bei_formatter<?=$time?>,
                editor:{
					type:'textbox',
					options:{
	                	buttonIcon:'icon-clear',
	            		onClickButton:function()
	            		{
	            			$(this).textbox('clear');
	            		}
					}
				} 
            },
            {field:'bei_number',title:'货物数量',width:100,halign:'center',align:'center',
                formatter: fun_table_bei_formatter<?=$time?>,
                editor:{
					type:'numberbox',
					options:{
                		required:true,
                		precision:2,
		   				min:0,
		   				groupSeparator:',',
		   				buttonIcon:'icon-clear',
	            		onClickButton:function()
	            		{
	            			$(this).numberbox('clear');
	            		}
					}
				} 
            },
            {field:'bei_unit_price',title:'货物单价',width:150,halign:'center',align:'right',
                formatter: fun_table_bei_formatter<?=$time?>,
                editor:{
					type:'numberbox',
					options:{
                		required:true,
                		precision:2,
		   				min:0,
		   				groupSeparator:',',
		   				buttonIcon:'icon-clear',
	            		onClickButton:function()
	            		{
	            			$(this).numberbox('clear');
	            		}
					}
				} 
            },
            {field:'bei_sum',title:'价税合计',width:150,halign:'center',align:'right',
                formatter: fun_table_bei_formatter<?=$time?>,
                editor:{
					type:'numberbox',
					options:{
                		err:err,
                		required:true,
                		readonly:true,
                		precision:2,
		   				min:0,
		   				groupSeparator:',',
		   				buttonIcon:'icon-lock',
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
            
        },
        onBeginEdit: function(index,row)
        {
        	var ed_list=$(this).datagrid('getEditors',index);

        	var ed_bei_number='';
        	var ed_bei_unit_price='';
        	var ed_bei_sum='';
			for(var i = 0;i < ed_list.length; i++)
			{
				switch(ed_list[i].field)
				{
					case 'bei_number':
						ed_bei_number =ed_list[i].target;
    					break;
					case 'bei_unit_price':
						ed_bei_unit_price =ed_list[i].target;
    					break;
					case 'bei_sum':
						ed_bei_sum =ed_list[i].target;
    					break;
				}
			}

			$(ed_bei_number).numberbox({
				onChange:function(newValue,oldValue)
				{
					var bei_unit_price = $(ed_bei_unit_price).numberbox('getValue');
					var bei_sum = parseFloat(bei_unit_price)*parseFloat(newValue);

					$(ed_bei_sum).numberbox('setValue',bei_sum)
				}
			});

			$(ed_bei_unit_price).numberbox({
				onChange:function(newValue,oldValue)
				{
					var bei_number = $(ed_bei_number).numberbox('getValue');
					var bei_sum = parseFloat(bei_number)*parseFloat(newValue);
	
					$(ed_bei_sum).numberbox('setValue',bei_sum)
				}
			});

			var bei_sum_all = get_bei_sum_all<?=$time?>();
	        var sum = $('#txtb_bill_sum<?=$time?>').numberbox('getValue');
			max = parseFloat(sum-bei_sum_all);
			if( row.bei_sum )
			max+=parseFloat(row.bei_sum);

			$(ed_bei_sum).numberbox({
				validType:'max['+max+']'
			});

			$(ed_bei_unit_price).numberbox('textbox').css('text-align','right');
			$(ed_bei_sum).numberbox('textbox').css('text-align','right');

        },
        onEndEdit: function(index, row, changes)
        {
        	var ed_list=$(this).datagrid('getEditors',index);

//			for(var i = 0;i < ed_list.length; i++)
//			{
//				switch(ed_list[i].field)
//				{
//				}
//			}

			load_bei_prog<?=$time?>();
        },
    });

    if( arr_view<?=$time?>.indexOf('content[bei]')>-1 )
    {
    	$('#table_bei<?=$time?>').edatagrid('disableEditing');
        $('#table_bei_tool<?=$time?> .oa_op').hide();
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
function fun_table_bei_formatter<?=$time?>(value,row,index){

    switch(this.field)
    {
    	case 'bei_unit_price':
    	case 'bei_sum':
    		value = num_parse(value);
        	break;
        	
        default:
            if(row[this.field+'_s'])
                value = row[this.field+'_s'];
    }

    if( ! value ) value = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ;
    return '<span id="table_bei<?=$time?>_'+index+'_'+this.field+'" class="table_bei<?=$time?>" >'+value+'</span>';
}

//开票申请明细条目表--操作
function fun_table_bei_operate<?=$time?>(btn)
{
    switch(btn)
    {
        case 'add':

        	var row_s = $('#table_bei<?=$time?>').datagrid('getSelected');
        	var index_s = $('#table_bei<?=$time?>').datagrid('getRowIndex',row_s);
        	if( index_s > -1)
        	{
				if($('#table_bei<?=$time?>').datagrid('validateRow',index_s))
					$('#table_bei<?=$time?>').datagrid('endEdit',index_s)
				else
					return;//$('#table_bei<?=$time?>').datagrid('cancelEdit',index_s)
        	}
        	
        	var bei_sum_all = get_bei_sum_all<?=$time?>();

            var sum = $('#txtb_bill_sum<?=$time?>').numberbox('getValue');

    		var sum_remain = sum - bei_sum_all;

        	if( sum_remain <= 0 ) return;
        	
        	var op_id = get_guid();
			$('#table_bei<?=$time?>').edatagrid('addRow',{
				index:0,
				row:{
					bei_id: op_id,
				}
			});

            break;
        case 'del':

            var op_list=$('#table_bei<?=$time?>').datagrid('getChecked');

            var row_s = $('#table_bei<?=$time?>').datagrid('getSelected');
            var index_s = $('#table_bei<?=$time?>').datagrid('getRowIndex',row_s);

            if($('#table_bei<?=$time?>').datagrid('validateRow',index_s))
            {
                $('#table_bei<?=$time?>').datagrid('endEdit',index_s);
            }
            else
            {
                $('#table_bei<?=$time?>').datagrid('cancelEdit',index_s);
            }

            for(var i=op_list.length-1;i>-1;i--)
            {
                var index = $('#table_bei<?=$time?>').datagrid('getRowIndex',op_list[i]);
                $('#table_bei<?=$time?>').datagrid('deleteRow',index);
            }

            load_bei_prog<?=$time?>();
                    
            break;
    }

}

function get_bei_sum_all<?=$time?>()
{
	var op_list=$('#table_bei<?=$time?>').datagrid('getRows');

	var bei_sum_all = 0;
	for(var i=0;i<op_list.length;i++)
	{
		if(op_list[i].bei_sum)
		bei_sum_all+=parseFloat(op_list[i].bei_sum);
	}

	return bei_sum_all;
}

function load_bei_prog<?=$time?>()
{
    var bei_sum_all = get_bei_sum_all<?=$time?>();

        var sum = $('#txtb_bill_sum<?=$time?>').numberbox('getValue');

	var sum_remain = sum - bei_sum_all;

	$('#bei_prog<?=$time?>').progressbar({
		value: bei_sum_all/sum*100,
		text: num_parse(bei_sum_all)
	})
}

//开票批准发票条目表--载入
function load_table_bdi<?=$time?>()
{
    $('#table_bdi<?=$time?>').edatagrid({
        width:'100%',
        height:'150',
        toolbar:'#table_bdi_tool<?=$time?>',
        singleSelect:true,
        selectOnCheck:false,
        checkOnSelect:false,
        striped:true,
        remoteSort: false,
        idField:'bdi_id',
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
            {field:'bdi_id',title:'',width:50,align:'center',checkbox:true},
            {field:'bdi_invoice_code',title:'发票号码',width:200,halign:'center',align:'left',
                formatter: fun_table_bdi_formatter<?=$time?>,
                editor:{
					type:'textbox',
					options:{
                		required:true,
                		buttonIcon:'icon-clear',
                		onClickButton:function()
                		{
                			$(this).textbox('clear');
                		}
					}
				} 
            },
            {field:'bdi_time_kp',title:'预计开票时间',width:125,halign:'center',align:'center',sortable:true,
                formatter: fun_table_bdi_formatter<?=$time?>,
                editor:{
					type:'datebox',
					options:{
						 required:true,
                    	 buttonIcon:'icon-clear',
			     	   	 onClickButton:function()
			         	 {
							$(this).datebox('clear');
			         	 },
					}
				},
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
            {field:'bdi_invoice_sum',title:'发票金额',width:200,halign:'center',align:'right',
                formatter: fun_table_bdi_formatter<?=$time?>,
                editor:{
					type:'numberbox',
					options:{
                		err:err,
                		required:true,
                		precision:2,
		   				min:0,
		   				groupSeparator:',',
		   				buttonIcon:'icon-clear',
			     	   	onClickButton:function()
			         	{
							$(this).numberbox('clear');
			         	},
			         	icons:[{
  					    	iconCls:'icon-per',
   							handler: function(e){
   								var sum=$(e.data.target).numberbox('getValue');
   								if( sum > 0 && sum <= 100 )
   									sum = parseFloat($('#txtb_bill_sum<?=$time?>').numberbox('getValue') * sum / 100).toFixed(2);
	   								
   								$(e.data.target).numberbox('setValue',sum);
   							}
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
            
        },
        onBeginEdit: function(index,row)
        {
        	var ed_list=$(this).datagrid('getEditors',index);

			for(var i = 0;i < ed_list.length; i++)
			{
				switch(ed_list[i].field)
				{
					case 'bdi_time_kp':
						$(ed_list[i].target).datebox('textbox').bind('focus',
								function(){
							$(this).parent().prev().datebox('showPanel');
						});
    					break;
					case 'bdi_invoice_sum':
						
						var bdi_sum_all = get_bdi_sum_all<?=$time?>();
				        var sum = $('#txtb_bill_sum<?=$time?>').numberbox('getValue');
						max = parseFloat(sum-bdi_sum_all);
						if( row.bdi_invoice_sum)
						max+=parseFloat(row.bdi_invoice_sum);
    					
    					if( max == 0 )
    					{
    						$('#table_bdi<?=$time?>').datagrid('cancelEdit',index);
    					}
    					
    					$(ed_list[i].target).numberbox({
							max:parseFloat(max)
        				});
    					
    					if( ! row.bdi_invoice_sum )
    						$(ed_list[i].target).numberbox('setValue',max);
        					
						$(ed_list[i].target).numberbox('textbox').css('text-align','right');
    					break;
				}
			}

        },
        onEndEdit: function(index, row, changes)
        {
        	var ed_list=$(this).datagrid('getEditors',index);

//			for(var i = 0;i < ed_list.length; i++)
//			{
//				switch(ed_list[i].field)
//				{
//				}
//			}

			load_bdi_prog<?=$time?>();
        },
    });

    if( arr_view<?=$time?>.indexOf('content[bdi]')>-1 )
    {
    	$('#table_bdi<?=$time?>').edatagrid('disableEditing');
        $('#table_bdi_tool<?=$time?> .oa_op').hide();
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
function fun_table_bdi_formatter<?=$time?>(value,row,index){

    switch(this.field)
    {
    	case 'bdi_invoice_sum':
    		value = num_parse(value);
        	break;
        		
        default:
            if(row[this.field+'_s'])
                value = row[this.field+'_s'];
    }

    if( ! value ) value = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ;
    return '<span id="table_bdi<?=$time?>_'+index+'_'+this.field+'" class="table_bdi<?=$time?>" >'+value+'</span>';
}

//开票批准发票条目表--操作
function fun_table_bdi_operate<?=$time?>(btn)
{
    switch(btn)
    {
        case 'add':

        	var row_s = $('#table_bdi<?=$time?>').datagrid('getSelected');
        	var index_s = $('#table_bdi<?=$time?>').datagrid('getRowIndex',row_s);
        	if( index_s > -1)
        	{
				if($('#table_bdi<?=$time?>').datagrid('validateRow',index_s))
					$('#table_bdi<?=$time?>').datagrid('endEdit',index_s)
				else
					return;//$('#table_bdi<?=$time?>').datagrid('cancelEdit',index_s)
        	}
        	
        	var bdi_sum_all = get_bdi_sum_all<?=$time?>();

            var sum = $('#txtb_bill_sum<?=$time?>').numberbox('getValue');

    		var sum_remain = sum - bdi_sum_all;

        	if( sum_remain <= 0 ) return;
        	
        	var op_id = get_guid();
			$('#table_bdi<?=$time?>').edatagrid('addRow',{
				index:0,
				row:{
					bdi_id: op_id,
				}
			});

            break;
        case 'del':

            var op_list=$('#table_bdi<?=$time?>').datagrid('getChecked');

            var row_s = $('#table_bdi<?=$time?>').datagrid('getSelected');
            var index_s = $('#table_bdi<?=$time?>').datagrid('getRowIndex',row_s);

            if($('#table_bdi<?=$time?>').datagrid('validateRow',index_s))
            {
                $('#table_bdi<?=$time?>').datagrid('endEdit',index_s);
            }
            else
            {
                $('#table_bdi<?=$time?>').datagrid('cancelEdit',index_s);
            }

            for(var i=op_list.length-1;i>-1;i--)
            {
                var index = $('#table_bdi<?=$time?>').datagrid('getRowIndex',op_list[i]);
                $('#table_bdi<?=$time?>').datagrid('deleteRow',index);
            }

            load_bdi_prog<?=$time?>();
                    
            break;
    }

}

function get_bdi_sum_all<?=$time?>()
{
	var op_list=$('#table_bdi<?=$time?>').datagrid('getRows');

	var bdi_sum_all = 0;
	for(var i=0;i<op_list.length;i++)
	{
		if(op_list[i].bdi_invoice_sum)
		bdi_sum_all+=parseFloat(op_list[i].bdi_invoice_sum);
	}

	return bdi_sum_all;
}

function load_bdi_prog<?=$time?>()
{
    var bdi_sum_all = get_bdi_sum_all<?=$time?>();
	
    var sum = $('#txtb_bill_sum<?=$time?>').numberbox('getValue');

	var sum_remain = sum - bdi_sum_all;

	$('#bdi_prog<?=$time?>').progressbar({
		value: bdi_sum_all/sum*100,
		text: num_parse(bdi_sum_all)
	})
}

//关联单据
function load_table_bill_link<?=$time?>()
{
  $('#table_bill_link<?=$time?>').datagrid({
      width:'100%',
      height:'120',
//      toolbar:'#table_bill_link_tool<?=$time?>',
      singleSelect:true,
      selectOnCheck:false,
      checkOnSelect:false,
      striped:true,
      remoteSort: false,
      idField:'bill_link_id',
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
		  {field:'l_type',title:'单据类型',width:100,halign:'center',align:'left',
		      formatter: fun_table_bill_link_formatter<?=$time?>,
		  },      
          {field:'l_code',title:'单据编号',width:120,halign:'center',align:'left',
              formatter: fun_table_bill_link_formatter<?=$time?>,
          },
          {field:'l_time',title:'时间',width:80,halign:'center',align:'center',
              formatter: fun_table_bill_link_formatter<?=$time?>,
          },
          {field:'l_sum',title:'关联金额',width:120,halign:'center',align:'right',
              formatter: fun_table_bill_link_formatter<?=$time?>,
          },
      ]],
      rowStyler: function(index,row){
      },
      onLoadSuccess: function(data)
      {
      },
      onBeginEdit: function(index,row)
      {
      },
      onEndEdit: function(index, row, changes)
      {

      },
  });


  if('<?=$ppo?>' == 0 )
  {
	  $('#table_bill_link<?=$time?>').datagrid('reload','proc_bill/bill/get_json_link/search_bill_id/<?=$bill_id?>')
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
function fun_table_bill_link_formatter<?=$time?>(value,row,index){

	  value = base64_decode(value);
	  switch(this.field)
	  {
	    case 'l_code':
	    	var url='proc_bs/bs/edit/act/2/bs_id/'+base64_decode(row.l_id);
			value='<a href="javascript:void(0);" class="link" onClick="fun_index_win_open<?=$time?>(\''+base64_decode(row.bs_code)+'\',\'win\',\''+url+'\');">'+value+'</a>';
	    	break;
	  	case 'l_sum':
	  		value = num_parse(value);
	      	break;
	      default:
		      if(row[this.field+'_s'])
	          value = row[this.field+'_s'];
	  }
	
	  return value;
}
</script>