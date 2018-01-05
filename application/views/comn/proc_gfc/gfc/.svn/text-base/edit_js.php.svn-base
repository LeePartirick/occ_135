<!-- 加载jquery -->
<script type="text/javascript">

//载入数据
var data_<?=$time?>=<?=$data?>;
var arr_view<?=$time?>=<?=$field_view;?>;
var arr_edit<?=$time?>=<?=$field_edit;?>;
var arr_required<?=$time?>=<?=$field_required;?>;

//初始化
$(document).ready(function(){

	load_win_loading('win_loading<?=$time?>');
	
	//添加禁用
	fun_l_disable_class('tab_edit_<?=$time?>',<?=$op_disable;?>);
	
	//项目组成员
	load_table_pm_c<?=$time?>();
	
	//开票回款计划
	load_table_gfc_bp<?=$time?>();

	//预算表
	load_table_gfc_bud<?=$time?>();
	
	//设备清单
	load_table_gfc_eli<?=$time?>();

	//指定评审人
	load_table_gfc_cr<?=$time?>();

	//评审文件
//	load_table_gfc_cr_file<?=$time?>();

	if('<?=$ppo?>' == '<?=GFC_PPO_REVIEW?>')
	{
		setTimeout(function(){
		$('#l_<?=$time?>').layout();
		$('#l_<?=$time?>').layout('collapse','south');
		},1000);
	}

	setTimeout(function(){

		//添加只读，编辑,必填
		fun_form_operate('f_<?=$time?>',arr_view<?=$time?>,arr_edit<?=$time?>,arr_required<?=$time?>,'<?=$flag_edit_more?>');

		//载入数据
		load_form_data_<?=$time?>();

		flag_load_cr<?=$time?> = 1;
		
		load_tab_gfc<?=$time?>();

		//归档文件
		load_table_gfc_return_file<?=$time?>();
		
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
	
	$('#f_<?=$time?>').attr('log',1);

	fun_show_err_tab_gfc<?=$time?>('有变更');
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

			$('#table_gfc_bud_sum<?=$time?>').datagrid('loadData',[]);
			
			fun_load_gfc_bud_other<?=$time?>();
			
			var data_form = fun_get_data_from_f('f_<?=$time?>');
			
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

				$('#win_loading<?=$time?>').window('open');

				param.btn=btn;
				param['content[gfc_area]'] = data_form['content[gfc_area]']
				+','+data_form['content[gfc_area_1]']+','+data_form['content[gfc_area_2]'];

				param['content[gfc_area_show]'] = $('#txtb_gfc_area<?=$time?>').combobox('getText')
				+','+$('#txtb_gfc_area_1<?=$time?>').combobox('getText')
				+','+$('#txtb_gfc_area_2<?=$time?>').combobox('getText');

				param['content[pm_c]'] = data_form['content[pm_c]'];
				
				param['content[gfc_bp]'] = data_form['content[gfc_bp]'];
				
				param['content[gfc_eli]'] = data_form['content[gfc_eli]'];
				
				param['content[gfc_bud_sum]'] = data_form['content[gfc_bud]'];

				param['content[gfc_cr]'] = data_form['content[gfc_cr]'];

				param['content[gfc_ou_tj]'] = data_form['content[gfc_ou_tj]'];

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

				fun_show_err_tab_gfc<?=$time?>('存在错误');

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

				if(json.err.file)
				{
					$.messager.show({
						title:'警告',
						msg: json.err.file,
						timeout:1500,
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

				fun_show_err_tab_gfc<?=$time?>('存在错误');
			}
			else
			{
				$('#f_<?=$time?> .div_input_require').removeClass('div_input_require');
				fun_show_err_tab_gfc<?=$time?>();
				
				if('<?=$fun_no_db?>')
				{
					eval("<?=$fun_no_db?>('f_<?=$time?>','"+btn+"')")
					return;
				}
				
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
						var gfcs_c_check = $('#txtb_gfcs_c_check<?=$time?>').combobox('getText');
						
						$.messager.show({
							title:'通知',
							msg:'操作成功！标密申请单自动提交给审核人-'+gfcs_c_check+'!',
							timeout:500,
							showType:'show',
							border:'thin',
							style:{
								right:'',
								bottom:'',
							}
						});
						
						url=url.replace('/act/1','');
						url+='/act/<?=STAT_ACT_EDIT?>/gfc_id/'+json.id

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
								reload_page<?=$time?>(url);	
							break;
						}
					}
				}
			}
		}
	});
}

//展示选项卡错误
function fun_show_err_tab_gfc<?=$time?>(msg)
{
	$('#sp_gfc<?=$time?>').hide();
	if( msg && $('#table_f_<?=$time?> .div_input_require').length > 0)
	{
		$('#sp_gfc<?=$time?>').text(msg);
		$('#sp_gfc<?=$time?>').show();
		$('#tab_gfc<?=$time?>').tabs('select','项目跟踪');
	}

	$('#sp_kpbp<?=$time?>').hide();
	if( msg && $('#table_bp_<?=$time?> .div_input_require').length > 0 )
	{
		$('#sp_kpbp<?=$time?>').text(msg);
		$('#sp_kpbp<?=$time?>').show();
		$('#tab_gfc<?=$time?>').tabs('select','开票回款分解');
	}

	$('#sp_eq_list<?=$time?>').hide();
	if( msg && $('#table_el_<?=$time?> .div_input_require').length > 0 )
	{
		$('#sp_eq_list<?=$time?>').text(msg);
		$('#sp_eq_list<?=$time?>').show();
		$('#tab_gfc<?=$time?>').tabs('select','设备清单');
	}

	$('#sp_bud<?=$time?>').hide();
	if( msg && $('#table_bud_<?=$time?> .div_input_require').length > 0 )
	{
		$('#sp_bud<?=$time?>').text(msg);
		$('#sp_bud<?=$time?>').show();
		$('#tab_gfc<?=$time?>').tabs('select','预算表');
	}

	$('#sp_sercet<?=$time?>').hide();
	if( msg && $('#table_secret_<?=$time?> .div_input_require').length > 0 )
	{
		$('#sp_sercet<?=$time?>').text(msg);
		$('#sp_sercet<?=$time?>').show();
		$('#tab_gfc<?=$time?>').tabs('select','标密申请单');
	}

	$('#sp_check_person<?=$time?>').hide();
	if( msg && $('#table_cr_<?=$time?> .div_input_require').length > 0 )
	{
		$('#sp_check_person<?=$time?>').text(msg);
		$('#sp_check_person<?=$time?>').show();
		$('#tab_gfc<?=$time?>').tabs('select','指定评审人');
	}
}

//其他面板加载
function load_tab_gfc<?=$time?>()
{
	$('#tab_gfc<?=$time?>').tabs({
		onSelect: function(title,index)
		{
			var data_form = fun_get_data_from_f('f_<?=$time?>');
			switch(index)
			{
				//开票回款分解
				case 1:
					var sum = $('#txtb_gfc_sum<?=$time?>').numberbox('getValue');

					$('#txtb_gfc_bp_sum<?=$time?>').numberbox('setValue',sum);

					load_gfc_bp_prog<?=$time?>();
					
					$("#table_bp_<?=$time?> [oaname='content[gfc_org_s]']").html(data_form['content[gfc_org_s]']);
					$("#table_bp_<?=$time?> [oaname='content[gfc_name]']").html(data_form['content[gfc_name]']);
					$("#table_bp_<?=$time?> [oaname='content[gfc_org_jia_s]']").html(data_form['content[gfc_org_jia_s]']);
					break;
				//设备清单
				case 2:
					$("#table_el_<?=$time?> [oaname='content[gfc_org_s]']").html(data_form['content[gfc_org_s]']);
					$("#table_el_<?=$time?> [oaname='content[gfc_name]']").html(data_form['content[gfc_name]']);
					$("#table_el_<?=$time?> [oaname='content[gfc_finance_code]']").html(data_form['content[gfc_finance_code]']);

					$("#table_el_<?=$time?> [oaname='content[gfc_c_s]']").html(data_form['content[gfc_c_s]']);
					$("#table_el_<?=$time?> [oaname='content[gfc_ou_s]']").html(data_form['content[gfc_ou_s]']);
					$("#table_el_<?=$time?> [oaname='content[gfc_sum]']").html(num_parse(data_form['content[gfc_sum]']));
					$("#table_el_<?=$time?> [oaname='content[gfc_category_main]']").html(data_form['content[gfc_category_main_s]']);

					break;	
				//预算表		
				case 3:
					$("#table_bud_<?=$time?> [oaname='content[gfc_org_s]']").html(data_form['content[gfc_org_s]']);
					$("#table_bud_<?=$time?> [oaname='content[gfc_name]']").html(data_form['content[gfc_name]']);
					$("#table_bud_<?=$time?> [oaname='content[gfc_org_jia_s]']").html(data_form['content[gfc_org_jia_s]']);

					$("#table_bud_<?=$time?> [oaname='content[gfc_c_s]']").html(data_form['content[gfc_c_s]']);
					$("#table_bud_<?=$time?> [oaname='content[gfc_ou_s]']").html(data_form['content[gfc_ou_s]']);
					$("#table_bud_<?=$time?> [oaname='content[gfc_category_main]']").html(data_form['content[gfc_category_main_s]']);
					$("#table_bud_<?=$time?> [oaname='content[gfc_category_extra]']").html(data_form['content[gfc_category_extra_s]']);
					$("#table_bud_<?=$time?> [oaname='content[gfc_category_statistic]']").html(data_form['content[gfc_category_statistic_s]']);

					fun_load_eli_bud_sum<?=$time?>();
					
					break;	
				//标密申请单
				case 4:
					$("#table_secret_<?=$time?> [oaname='content[gfc_org_s]']").html(data_form['content[gfc_org_s]']);
					$("#table_secret_<?=$time?> [oaname='content[gfc_name]']").html(data_form['content[gfc_name]']);

					$("#table_secret_<?=$time?> [oaname='content[gfc_c_s]']").html(data_form['content[gfc_c_s]']);
					$("#table_secret_<?=$time?> [oaname='content[gfc_ou_s]']").html(data_form['content[gfc_ou_s]']);
					$("#table_secret_<?=$time?> [oaname='content[gfc_category_secret]']").html(data_form['content[gfc_category_secret_s]']);

					break;	
				//指定评审人
				case 5:
					$("#table_cr_<?=$time?> [oaname='content[gfc_org_s]']").html(data_form['content[gfc_org_s]']);
					$("#table_cr_<?=$time?> [oaname='content[gfc_name]']").html(data_form['content[gfc_name]']);

					$("#table_cr_<?=$time?> [oaname='content[gfc_c_s]']").html(data_form['content[gfc_c_s]']);
					$("#table_cr_<?=$time?> [oaname='content[gfc_ou_s]']").html(data_form['content[gfc_ou_s]']);

					$("#table_cr_<?=$time?> [oaname='content[gfc_category_main]']").html(data_form['content[gfc_category_main_s]']);
					$("#table_cr_<?=$time?> [oaname='content[gfc_category_extra]']").html(data_form['content[gfc_category_extra_s]']);
					$("#table_cr_<?=$time?> [oaname='content[gfc_category_statistic]']").html(data_form['content[gfc_category_statistic_s]']);
					
					$('#txtb_gfc_cr_sum<?=$time?>').numberbox('setValue',data_form['content[gfc_sum]']);

					$("#table_cr_<?=$time?> [oaname='content[gfc_c_jia_s]']").html(data_form['content[gfc_c_jia_s]']);
					$("#table_cr_<?=$time?> [oaname='content[gfc_c_jia_tel]']").html(data_form['content[gfc_c_jia_tel]']);

					var data_pm_c = data_form['content[pm_c]'];
					data_pm_c = JSON.parse(data_pm_c);
					var pm_c = '';
					for(var i=0;i < data_pm_c.length;i++)
					{
						var pmc_type = data_pm_c[i].pmc_type;
						if(pmc_type.indexOf('<?=PMC_TYPE_SS?>')>-1)
						pm_c+=data_pm_c[i].pmc_c_id_s+','
					}
					$("#table_cr_<?=$time?> [oaname='content[pm_c_s]']").html(pm_c);
					
					$("#table_cr_<?=$time?> [oaname='content[gfc_pt_plan_sign]']").html(data_form['content[gfc_pt_plan_sign]']);
					$("#table_cr_<?=$time?> [oaname='content[gfc_finance_code]']").html(data_form['content[gfc_finance_code]']);

					$("#table_cr_<?=$time?> [oaname='content[gfc_org_jia_s]']").html(data_form['content[gfc_org_jia_s]']);

					$("#table_cr_<?=$time?> [oaname='content[gfc_category_subc]']").html(data_form['content[gfc_category_subc_s]']);

					load_table_gfc_cr_file<?=$time?>();
					
					break;	
			}
		}
	})

	if('<?=$ppo?>' == '<?=GFC_PPO_REVIEW?>')
	{
		setTimeout(function(){
		$('#tab_gfc<?=$time?>').tabs('select','指定评审人');
		$('#txtb_gfc_org<?=$time?>').combobox('hidePanel');
		},1000);
	}

	if('<?=$flag_edit_more?>')
	{
		$('#tab_gfc<?=$time?>').tabs('disableTab',1);
		$('#tab_gfc<?=$time?>').tabs('disableTab',2);
		$('#tab_gfc<?=$time?>').tabs('disableTab',3);
		$('#tab_gfc<?=$time?>').tabs('disableTab',4);
		$('#tab_gfc<?=$time?>').tabs('disableTab',5);
	}
}

//统计部门自动补全
function load_gfc_ou_tj<?=$time?>()
{
	var opt = $('#txtb_gfc_ou_tj<?=$time?>').tagbox('options');

	if(  opt.readonly ) return;

	var json = [
		{"field":"ou_tag","rule":"find_in_set","value":"1"}
	]
	
	$('#txtb_gfc_ou_tj<?=$time?>').tagbox('textbox').autocomplete({
		serviceUrl: 'base/auto/get_json_ou',
		width:'400',
		params:{
			rows:10,
			data_search:JSON.stringify(json)
		},
		onSelect: function (suggestion) {

			$('#txtb_gfc_ou_tj<?=$time?>').tagbox('clear');
			var ou_id = base64_decode(suggestion.data.ou_id)
			var ou_name = base64_decode(suggestion.data.ou_name)
        	
        	var values=$('#txtb_gfc_ou_tj<?=$time?>').tagbox('getValues');

        	if(values.indexOf(ou_id) > -1 ) 
        	{
        		layer.tips(ou_name+'已存在！'
                		, $('#txtb_gfc_ou_tj<?=$time?>').tagbox('textbox')
                		,{
                		  tips: [1],
                		  time: 2000
        				 }
                		);
            	return;
        	}
        	
        	var data = $('#txtb_gfc_ou_tj<?=$time?>').tagbox('getData');

        	data.push({id: ou_id,text:ou_name});
        	$('#txtb_gfc_ou_tj<?=$time?>').tagbox('loadData',data);
        	
        	values.push(ou_id);
        	$('#txtb_gfc_ou_tj<?=$time?>').tagbox('setValues',values);
		}
	});
}

//甲方单位自动补全
function load_gfc_org_jia<?=$time?>()
{
	var opt = $('#txtb_gfc_org_jia_s<?=$time?>').textbox('options');

	if(  opt.readonly ) return;

	$('#txtb_gfc_org_jia_s<?=$time?>').textbox({
		buttonIcon:'icon-clear',
  	    onClickButton:function()
        {
			$(this).textbox('clear');
			$('#txtb_gfc_org_jia<?=$time?>').val('');
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

				var org_jia = $('#txtb_gfc_org_jia<?=$time?>').val();

				if( ! org_jia )
				{ 
					$.messager.show({
						title:'警告',
						msg:'请填写甲方单位！',
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
					
				var url = 'proc_org/org/edit/act/2/o_id/'+org_jia;
				
				$('#'+win_id).window('refresh',url+'/fun_open/win/fun_open_id/'+win_id);
			}
		}]
	})
	
	$('#txtb_gfc_org_jia_s<?=$time?>').textbox('textbox').autocomplete({
		serviceUrl: 'base/auto/get_json_org/search_o_status/1',
		params:{
			rows:10,
		},
		onSelect: function (suggestion) {
			
			$('#txtb_gfc_org_jia_s<?=$time?>').textbox('setValue',base64_decode(suggestion.data.o_id_standard_s));
			$('#txtb_gfc_org_jia<?=$time?>').val(base64_decode(suggestion.data.o_id_standard));
			
			load_gfc_c_jia<?=$time?>();

			$('#txtb_gfc_c_jia<?=$time?>').combobox('loadData',[]);
	 		$('#txtb_gfc_c_jia<?=$time?>').combobox('clear');
	 		$('#sp_gfc_c_jia_tel<?=$time?>').text('');
		}
	});
}

//甲方联系人
function load_gfc_c_jia<?=$time?>()
{
	var opt = $('#txtb_gfc_c_jia<?=$time?>').combobox('options');

	if(  opt.readonly ) return;

	var data = $('#txtb_gfc_org<?=$time?>').combobox('getData');

	var org_jia = $('#txtb_gfc_org_jia<?=$time?>').val();
	if( ! org_jia )
		org_jia = data_<?=$time?>['content[gfc_org_jia]'];

	var type_ou = false;
	
	for(var i=0;i<data.length;i++)
	{
		if(data[i].id == org_jia)
		{
			type_ou = true;
			break;
		}
	}

	if( type_ou == true) 
	{
		var gfc_c_jia = $('#txtb_gfc_c_jia<?=$time?>').combobox('getValue');
		
		$('#txtb_gfc_c_jia<?=$time?>').combobox({
			hasDownArrow:false,
			onShowPanel:function()
			{
				$(this).combobox('hidePanel');
			},
			icons: []
		});

		$('#txtb_gfc_c_jia<?=$time?>').combobox('setValue',gfc_c_jia);

		$('#txtb_gfc_c_jia<?=$time?>').combobox('textbox').autocomplete({
			serviceUrl: 'base/auto/get_json_contact/search_c_login_id/1/search_c_org/'+org_jia,
			width:'300',
			params:{
				rows:10,
			},
			onSelect: function (suggestion) {
				var data = [{
							'id': base64_decode(suggestion.data.c_id),
							'text':base64_decode(suggestion.data.c_show)
							}]
				
				$('#txtb_gfc_c_jia<?=$time?>').combobox('loadData',data);

				$('#txtb_gfc_c_jia<?=$time?>').combobox('setValue', base64_decode(suggestion.data.c_id));

				$("#sp_gfc_c_jia_tel<?=$time?>").text(base64_decode(suggestion.data.c_tel));
			}
		});
	}
	else
	{
		if( org_jia )
		$('#txtb_gfc_c_jia<?=$time?>').combobox('reload','base/auto/get_json_contact/from/combobox/field_id/c_id/field_text/c_show/search_c_org/'+org_jia);
		else
		return;

		var data_form = fun_get_data_from_f('f_<?=$time?>');
		
		$('#txtb_gfc_c_jia<?=$time?>').combobox({
			hasDownArrow:true,
			value:data_form['content[gfc_c_jia]'],
			icons: [{
				iconCls:'icon-add',
				handler: function(e){

					var org_jia = $('#txtb_gfc_org_jia<?=$time?>').val();
					var org_jia_s = $('#txtb_gfc_org_jia_s<?=$time?>').textbox('getValue');

					if( ! org_jia )
					{ 
						$.messager.show({
							title:'警告',
							msg:'请填写甲方单位！',
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
							$('#txtb_gfc_c_jia<?=$time?>').combobox('reload');
							$('#'+win_id).window('destroy');
							$('#'+win_id).remove();
						}
					})
						
					var url = 'proc_contact/contact/edit/act/1/from/org/c_org/'+org_jia+'/c_org_s/'+base64_encode(org_jia_s);
					
					$('#'+win_id).window('refresh',url+'/fun_open/win/fun_open_id/'+win_id);
				}
			}],
			onLoadSuccess:function()
			{
				$('#txtb_gfc_c_jia<?=$time?>').combobox('showPanel');
			},
			onShowPanel:function()
			{
				
			}
		});

		$('#txtb_gfc_org<?=$time?>').combobox('textbox').bind('mouseover',
		function(){
			$(this).parent().prev().combobox('showPanel');
		});
	}
}

//项目负责人自动补全
function load_gfc_c<?=$time?>()
{
	var opt = $('#txtb_gfc_c_s<?=$time?>').textbox('options');

	if(  opt.readonly ) return;

	$('#txtb_gfc_c_s<?=$time?>').textbox({
		onClickButton:function()
        {
			$(this).textbox('clear');
			$('#txtb_gfc_c<?=$time?>').val('');
			$('#txtb_gfc_c_org<?=$time?>').val('');
        }
	});

	$('#txtb_gfc_c_s<?=$time?>').textbox('textbox').autocomplete({
		serviceUrl: 'base/auto/get_json_contact/search_c_login_id/1',
		width:'300',
		params:{
			rows:10,
		},
		onSelect: function (suggestion) {
			$('#txtb_gfc_c_s<?=$time?>').textbox('setValue',base64_decode(suggestion.data.c_show));
			$('#txtb_gfc_c<?=$time?>').val(base64_decode(suggestion.data.c_id));

			$('#txtb_gfc_ou_s<?=$time?>').textbox('setValue',base64_decode(suggestion.data.c_ou_bud_s));
			$('#txtb_gfc_ou<?=$time?>').val(base64_decode(suggestion.data.c_ou_bud));

			$('#txtb_gfc_c_org<?=$time?>').val(base64_decode(suggestion.data.c_org));
		}
	});
}

//项目所属部门自动补全
function load_gfc_ou<?=$time?>()
{
	var opt = $('#txtb_gfc_ou_s<?=$time?>').textbox('options');

	if(  opt.readonly ) return;

	$('#txtb_gfc_ou_s<?=$time?>').textbox({
		onClickButton:function()
        {
			$(this).textbox('clear');
			$('#txtb_gfc_ou<?=$time?>').val('');
        }
	});

	var gfc_org = $('#txtb_gfc_c_org<?=$time?>').val();

	var json = [
		{"field":"ou_org","rule":"=","value":gfc_org},
		{"field":"ou_tag","rule":"find_in_set","value":"1"}
	]

	$('#txtb_gfc_ou_s<?=$time?>').textbox('textbox').autocomplete({
        serviceUrl: 'base/auto/get_json_ou',
        width:'400',
        params:{
			rows:10,
			data_search:JSON.stringify(json)
		},
        onSelect: function (suggestion) {

			var ou_id = base64_decode(suggestion.data.ou_id);
	        var gfc_ou = $('#txtb_gfc_ou<?=$time?>').val();

	        if('<?=$ppo?>' == '<?=GFC_PPO_START?>' && ! '<?=$gfcc_result?>' && ou_id && gfc_ou != ou_id)
	        {
	        	var data_form =  fun_get_data_from_f('f_<?=$time?>');
				var gfc_category_main = data_form['content[gfc_category_main]'];

				$('#table_gfc_cr<?=$time?>').datagrid('reload','proc_gfc/cr/get_json/search_cr_default/1/search_gfc_category_main/'+gfc_category_main+'/search_gfc_ou/'+ou_id)
	        }
	        
			$('#txtb_gfc_ou_s<?=$time?>').textbox('setValue',base64_decode(suggestion.data.ou_name));
			$('#txtb_gfc_ou<?=$time?>').val(ou_id);
		}
	});

}

//项目统计人自动补全
function load_gfc_c_tj_s<?=$time?>()
{
	var opt = $('#txtb_gfc_c_tj_s<?=$time?>').textbox('options');

	if(  opt.readonly ) return;

	$('#txtb_gfc_c_tj_s<?=$time?>').textbox('textbox').autocomplete({
		serviceUrl: 'base/auto/get_json_contact/search_c_login_id/1',
		width:'300',
		params:{
			rows:10,
		},
		onSelect: function (suggestion) {
			$('#txtb_gfc_c_tj_s<?=$time?>').textbox('setValue',base64_decode(suggestion.data.c_show));
			$('#txtb_gfc_c_tj<?=$time?>').val(base64_decode(suggestion.data.c_id))
		}
	});
}

//合同标的
function load_gfc_sum<?=$time?>()
{
	$('#txtb_gfc_sum<?=$time?>').numberbox('textbox').css('text-align','right');
}

//项目性质
function load_gfc_category_main<?=$time?>()
{
	var opt = $('#txtb_gfc_category_main<?=$time?>').combobox('options');

	if(opt.readonly) return;

	$('#txtb_gfc_category_main<?=$time?>').combobox({
		onSelect : function(record)
		{
		 	if('<?=$ppo?>' == '<?=GFC_PPO_START?>' && ! '<?=$gfcc_result?>')
	        {
	        	var data_form =  fun_get_data_from_f('f_<?=$time?>');
				var gfc_ou = data_form['content[gfc_ou]'];

				var gfc_category_main = record.id;

				$('#table_gfc_cr<?=$time?>').datagrid('reload','proc_gfc/cr/get_json/search_cr_default/1/search_gfc_category_main/'+gfc_category_main+'/search_gfc_ou/'+gfc_ou)
	        }
		}
	});

	$('#txtb_gfc_category_main<?=$time?>').combobox('textbox').bind('focus',
	function(){
		$(this).parent().prev().combobox('showPanel');
	});
}

//项目组成员
function load_table_pm_c<?=$time?>()
{
	$('#table_pm_c<?=$time?>').edatagrid({
        width:'100%',
        height:'200',
        toolbar:'#table_pm_c_tool<?=$time?>',
        singleSelect:true,
        selectOnCheck:false,
        checkOnSelect:false,
        striped:true,
        idField:'pmc_c_id',
        data: [],
        remoteSort: false,
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
			{field:'pmc_note',title:'备注',width:200,halign:'center',align:'center',
			    formatter: fun_table_pm_c_formatter<?=$time?>,
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
        ]],
        frozenColumns:[[
            {field:'pmc_id',title:'',width:50,align:'center',checkbox:true},
            {field:'pmc_c_id',title:'成员',width:150,halign:'center',align:'left',
                formatter: fun_table_pm_c_formatter<?=$time?>,
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
            {field:'pmc_c_tel',title:'手机',width:150,halign:'center',align:'left',
                formatter: fun_table_pm_c_formatter<?=$time?>,
                editor:{
					type:'textbox',
					options:{
						readonly:true,
						icons:[{
						   iconCls:'icon-lock',
					   }]
					}
				}
            },
            {field:'pmc_type',title:'角色',width:200,halign:'center',align:'left',
                formatter: fun_table_pm_c_formatter<?=$time?>,
                editor:{
					type:'combotree',
					options:{
	                	data: [<?=element('pmc_type',$json_field_define)?>],
	            		panelHeight:'auto',
						multiple:true,
						required:true,
						valueField: 'id',    
                        textField: 'text',  
                        buttonIcon:'icon-clear',
				    	onClickButton:function()
				        {
							$(this).combotree('clear');
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

            var pmc_type = $('#table_pm_c<?=$time?>').attr('search_pmc_type');

            if(pmc_type && row.pmc_type.indexOf(pmc_type) < 0)
            	return 'display:none';
        },
        onLoadSuccess: function(data)
        {
            
        },
        onBeginEdit: function(index,row)
        {
        	var ed_list=$(this).datagrid('getEditors',index);

        	var ed_pmc_c_id = '';
        	var ed_pmc_c_tel = '';
        	
			for(var i = 0;i < ed_list.length; i++)
			{
				switch(ed_list[i].field)
				{
					case 'pmc_c_id':

						ed_pmc_c_id = ed_list[i].target;

						if(row.pmc_c_id) $(ed_list[i].target).combobox('setValue',row.pmc_c_id);
						if(row.pmc_c_id_s) $(ed_list[i].target).combobox('setText',row.pmc_c_id_s);
						
						break;
					case 'pmc_c_tel':

						ed_pmc_c_tel = ed_list[i].target;
						
						break;
					case 'pmc_type':
						$(ed_list[i].target).combotree('textbox').bind('focus',
								function(){
							$(this).parent().prev().combotree('showPanel');
						});

						if(row.pmc_type)
						$(ed_list[i].target).combotree('setValues',row.pmc_type.split(','))
    					break;
				}
			}

			$(ed_pmc_c_id).combobox('textbox').autocomplete({
				serviceUrl: 'base/auto/get_json_contact/search_c_login_id/1',
				width:'300',
				params:{
					rows:10,
				},
				onSelect: function (suggestion) {
					var c_id = base64_decode(suggestion.data.c_id);
					var c_show = base64_decode(suggestion.data.c_show);
					var index = $('#table_pm_c<?=$time?>').datagrid('getRowIndex',c_id);

					if(index > -1)
					{
						layer.tips(c_show+'已存在！'
	                		, $(ed_pmc_c_id).combobox('textbox')
	                		,{
	                		  tips: [1],
	                		  time: 2000
	        				 }
	                		);
						$(ed_pmc_c_id).combobox('clear');
						return;
					}
					
					$(ed_pmc_c_id).combobox('setValue',c_id);
					$(ed_pmc_c_id).combobox('setText',c_show);

					$(ed_pmc_c_tel).textbox('setValue',base64_decode(suggestion.data.c_tel));
				}
			});
			

        },
        onEndEdit: function(index, row, changes)
        {
        	var ed_list=$(this).datagrid('getEditors',index);

			for(var i = 0;i < ed_list.length; i++)
			{
				switch(ed_list[i].field)
				{
					case 'pmc_c_id':
						row.pmc_c_id_s = $(ed_list[i].target).combobox('getText');
						row.pmc_c_id = $(ed_list[i].target).combobox('getValue');
						break;
    				case 'pmc_type':
    					row.pmc_type_s = $(ed_list[i].target).combotree('getText');
    					var pmc_type = $(ed_list[i].target).combotree('getValues');
    					row.pmc_type = pmc_type.join(',');
        				break;
				}
			}
        },
    });
    
    if( arr_view<?=$time?>.indexOf('content[pm_c]')>-1 )
    {
    	$('#table_pm_c<?=$time?>').edatagrid('disableEditing');
        $('#table_pm_c_tool<?=$time?> .oa_op').hide();
    }

    var data_pmc_type = [<?=element('pmc_type',$json_field_define)?>];

    for(var i = 0; i<data_pmc_type.length; i++)
    {
    	data_pmc_type[i].id = data_pmc_type[i].text ;
    }
    
    $('#table_pm_c<?=$time?>').datagrid('enableFilter', [{
    	field:'pmc_type',
    	type:'combotree',
    	options:{
	    	data: data_pmc_type,
	        valueField: 'text',    
	        textField: 'text', 
	        panelHeight:'auto',
	        multiple:true,
	        buttonIcon:'icon-clear',
	    	onClickButton:function()
	        {
				$(this).combotree('clear');
	        },
	        onChange:function(nV,oV)
	        {
    			if(nV)
    			{
    				$('#table_pm_c<?=$time?>').datagrid('addFilterRule', {
    					field: 'pmc_type',
    					op: 'contains',
    					value: nV.join(',')
    				});
        			$('#table_pm_c<?=$time?>').datagrid('doFilter');
    			}
    			else
    			{
    				$('#table_pm_c<?=$time?>').datagrid('removeFilterRule', 'pmc_type');
    				$('#table_pm_c<?=$time?>').datagrid('doFilter');
    			}
	        } 
    	},
    }]);

    var ed_pmc_type = $('#table_pm_c<?=$time?>').datagrid('getFilterComponent','pmc_type');
    $(ed_pmc_type).combotree('textbox').bind('focus',function(){
		$(this).parent().prev().combotree('showPanel');
	})

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
function fun_table_pm_c_formatter<?=$time?>(value,row,index){

    switch(this.field)
    {
        default:
            if(row[this.field+'_s'])
                value = row[this.field+'_s'];
    }

    if( ! value ) value = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ;
    return '<span id="table_pm_c<?=$time?>_'+index+'_'+this.field+'" class="table_pm_c<?=$time?>" >'+value+'</span>';
}

//项目组成员--操作
function fun_table_pm_c_operate<?=$time?>(btn)
{
	 var op_list=$('#table_pm_c<?=$time?>').datagrid('getChecked');
	
     var row_s = $('#table_pm_c<?=$time?>').datagrid('getSelected');
     var index_s = $('#table_pm_c<?=$time?>').datagrid('getRowIndex',row_s);

     if($('#table_pm_c<?=$time?>').datagrid('validateRow',index_s))
     {
         $('#table_pm_c<?=$time?>').datagrid('endEdit',index_s);
     }
     else
     {
         $('#table_pm_c<?=$time?>').datagrid('cancelEdit',index_s);
     }
     
    switch(btn)
    {
        case 'add':

//        	var win_id=fun_get_new_win();
//    		
//    		$('#'+win_id).window({
//    			title: '添加组成员',
//    			inline:true,
//    			modal:true,
////    			closed:true,
//    			border:'thin',
//    			draggable:false,
//    			resizable:false,
//    			collapsible:false,  
//    			minimizable:false,
//    			maximizable:false,
//    		})
//    		
//    		$('#'+win_id).window('refresh','proc_contact/contact/index/search_c_type/1/fun_open/window/fun_open_id/'+win_id+'/flag_select/1/fun_select/fun_pm_c_add<?=$time?>');
//    		$('#'+win_id).window('center');

			var op_id = get_guid();
    		$('#table_pm_c<?=$time?>').edatagrid('addRow',{
    			index:0,
    			row:{
    				pmc_id: op_id,
    			}
    		});

            break;
        case 'del':

            for(var i=op_list.length-1;i>-1;i--)
            {
                var index = $('#table_pm_c<?=$time?>').datagrid('getRowIndex',op_list[i]);
                $('#table_pm_c<?=$time?>').datagrid('deleteRow',index);
            }
                    
            break;
    }
}

//批量添加项目组成员
function fun_pm_c_add<?=$time?>(op)
{
	$(op).closest('.op_window').window('close');
	
	var list=$(op).datagrid('getChecked');

	for(var i=0;i<list.length;i++)
	{
		var row = {};
		row.pmc_id = get_guid();
		row.pmc_c_id = base64_decode(list[i].c_id);
		row.pmc_c_id_s = base64_decode(list[i].c_name);

		if(list[i].c_login_id)
			row.pmc_c_id_s +='['+base64_decode(list[i].c_login_id)+']';
		else if(list[i].c_tel)
			row.pmc_c_id_s +='['+base64_decode(list[i].c_tel)+']';

		row.pmc_c_tel = base64_decode(list[i].c_tel);
		
		var index = $('#table_pm_c<?=$time?>').datagrid('getRowIndex',row.pmc_c_id);

		if(index < 0)
		$('#table_pm_c<?=$time?>').datagrid('appendRow',row);
	}
	
	$(op).closest('.op_window').window('destroy').remove();
}

//归档文件链接
function load_table_gfc_return_file<?=$time?>()
{
    var data_form = fun_get_data_from_f('f_<?=$time?>');
    
    $('#table_gfc_return_file<?=$time?>').datagrid({
        width:'100%',
        height:'100',
        singleSelect:true,
        selectOnCheck:false,
        checkOnSelect:false,
        striped:true,
        showHeader:false,
        url:'proc_gfc/gfc/get_json_return_file',
        queryParams: {
        	gfc_id: '<?=$gfc_id?>',
    	},
        columns:[[
        	{field:'file1',title:'',width:'25%',halign:'center',align:'center',
             formatter: fun_table_gfc_return_file_formatter<?=$time?>,
            },
            {field:'file2',title:'',width:'25%',halign:'center',align:'center',
             formatter: fun_table_gfc_return_file_formatter<?=$time?>,
            },
            {field:'file3',title:'',width:'25%',halign:'center',align:'center',
             formatter: fun_table_gfc_return_file_formatter<?=$time?>,
            },
            {field:'file4',title:'',width:'25%',halign:'center',align:'center',
             formatter: fun_table_gfc_return_file_formatter<?=$time?>,
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
        onBeforeLoad: function(param)
        {
			if( ! '<?=$gfc_id?>' ) return false;
				
			var gfc_secret = $('#txtb_gfc_category_secret<?=$time?>').combobox('getValue');
            if( gfc_secret != 0 )
            {
            	$('#table_gfc_return_file<?=$time?>').datagrid('loadData',[]);
				return false;
            }
        }
    });
}

//列格式化输出
function fun_table_gfc_return_file_formatter<?=$time?>(value,row,index){

	value = base64_decode(value);
	
	if(value && row[this.field+'_sum'])
	{
		value = '<a href="javascript:void(0);" class="link" title="查看文件" onclick="fun_win_gfc_file_open<?=$time?>(\'view\',\''+row[this.field+'_id']+'\',\''+value+'\',\'return\')">'+value+'</a>';
	}
	else if(value)
	{
		value = '<a href="javascript:void(0);" class="link" style="color:red" title="上传文件" onclick="fun_win_gfc_file_open<?=$time?>(\'add\',\''+row[this.field+'_id']+'\',\''+value+'\',\'return\')">'+value+'</a>';
	}
	
    return value;
}

//打开评审文件界面
function fun_win_gfc_file_open<?=$time?>(act,f_t_id,f_t_name,table)
{
	var url = '';
	var params = {}
	switch(act)
	{
		case 'view':

			$('#hd_f_t_file_<?=$time?>').val(f_t_id+','+f_t_name);
			$('#tab_edit_<?=$time?>').tabs('select',3);

			if(fun_table_searchfile_<?=$time?> && typeof(fun_table_searchfile_<?=$time?>)=="function"){ 
				fun_table_searchfile_<?=$time?>();
			}
			
			return;
			break;
		case 'add':
			
			var url = 'proc_file/file/edit/act/<?=STAT_ACT_CREATE?>';

			url+='/link_op_id/<?=$gfc_id?>/link_op_field/gfc_id/link_op_table/pm_given_financial_code/search_f_t_proc/<?=$proc_id?>/flag_f_type_more/false';

			url+='/f_type/'+f_t_id;
			
			break;
	}

	var win_id=fun_get_new_win();
	
	$('#'+win_id).window({
		title: '上传文件',
		inline:true,
		modal:true,
		border:'thin',
		draggable:false,
		resizable:false,
		collapsible:false,
		minimizable:false,
		maximizable:false,
		onClose: function()
		{
			eval('load_table_gfc_'+table+'_file<?=$time?>()');

			$('#'+win_id).window('destroy');
			$('#'+win_id).remove();
		}
	})
	
	$('#'+win_id).window('refresh',url+'/fun_open/win/fun_open_id/'+win_id);
}

</script>