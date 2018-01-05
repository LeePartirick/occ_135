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
	
	//公司培训记录
	load_table_hr_train_org<?=$time?>();
	
	//培训记录
	load_table_hr_train<?=$time?>();
	
	//工作经历
	load_table_c_work<?=$time?>();
	//奖惩记录
	load_table_hr_reward<?=$time?>();
	
	//身份证件
	load_table_hr_idcard<?=$time?>();
	
	//卡帐信息
	load_table_hr_card<?=$time?>();
	
	//教育信息
	load_table_hr_edu<?=$time?>();
	
	//家庭信息
	load_table_hr_family<?=$time?>();
	
	//家庭信息_犯罪
	load_table_hr_family_crime<?=$time?>();
	load_table_hr_family_card_gat<?=$time?>();
	load_table_hr_family_card<?=$time?>();
	
    //合同信息
    load_table_hr_contract<?=$time?>();

    //信息系统
    load_table_office<?=$time?>();

	//添加禁用
	fun_l_disable_class('tab_edit_<?=$time?>',<?=$op_disable;?>);

	setTimeout(function(){
		
		//添加只读，编辑,必填
		fun_form_operate('f_<?=$time?>',arr_view<?=$time?>,arr_edit<?=$time?>,arr_required<?=$time?>,'<?=$flag_edit_more?>');

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

	switch('<?=$fun_open?>')
	{
		case 'win':
			$('#<?=$fun_open_id?>').window('resize',{width:1100});
			$('#<?=$fun_open_id?>').window('center');
			break;
	}
});

//载入数据
function load_form_data_<?=$time?>()
{
	$('#f_<?=$time?>').form('clear');

	//载入数据
	$('#f_<?=$time?>').form('load',data_<?=$time?>);
	
	//载入数据(其他控件)
	fun_form_load_data_other('f_<?=$time?>',data_<?=$time?>);

	if( ! '<?=$log_time?>' && ! '<?=$flag_check?>') return;
	
	//添加日志
	var log=<?=$log?>;

	$("#hd_err_f_<?=$time?>").val(1);

	fun_show_errmsg_of_form('f_<?=$time?>',log);

	$('#f_<?=$time?>').form('enableValidation').form('validate');

	fun_show_err_tab_hr_info_other<?=$time?>('有变更');
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

				param['content[c_jg_show]'] = $('#txtb_c_jq<?=$time?>').combobox('getText');

				param['content[c_tel_info]']=data_form['content[c_tel_info]'];
				param['content[c_tel_2_info]']=data_form['content[c_tel_2_info]'];
				
				param['content[hr_tec]']=data_form['content[hr_tec]'];
				param['content[hr_train_org]']=data_form['content[hr_train_org]'];
				param['content[hr_train]']=data_form['content[hr_train]'];
				param['content[hr_work]']=data_form['content[hr_work]'];
				param['content[hr_reward]']=data_form['content[hr_reward]'];
				param['content[hr_idcard]']=data_form['content[hr_idcard]'];
				param['content[hr_card]']=data_form['content[hr_card]'];
				param['content[hr_edu]']=data_form['content[hr_edu]'];
				param['content[hr_family]']=data_form['content[hr_family]'];
				param['content[hr_family_crime]']=data_form['content[hr_family_crime]'];
				param['content[hr_family_card_gat]']=data_form['content[hr_family_card_gat]'];
				param['content[hr_family_card]']=data_form['content[hr_family_card]'];
                param['content[hr_contract]']=data_form['content[hr_contract]'];
			}
			else
			{
				$(this).form('enableValidation').form('validate');

				fun_show_err_tab_hr_info_other<?=$time?>('存在未填');
				
				return false;
			}

		},
		success: function(data){
			//alert(data);
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

				fun_show_err_tab_hr_info_other<?=$time?>('存在错误');
			}
			else
			{
				if('<?=$fun_no_db?>')
                {
                    eval("<?=$fun_no_db?>('f_<?=$time?>','"+btn+"')")
                    return;
                }
			
				$('#f_<?=$time?> .div_input_require').removeClass('div_input_require');
				fun_show_err_tab_hr_info_other<?=$time?>();

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
						url+='/act/<?=STAT_ACT_EDIT?>/c_id/'+json.id

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

//展示选项卡错误
function fun_show_err_tab_hr_info_other<?=$time?>(msg)
{

	$('#sp_hr_work<?=$time?>').hide();
	if( msg && $('#table_hr_work<?=$time?> .div_input_require').length > 0)
	{
		$('#sp_hr_work<?=$time?>').text(msg);
		$('#sp_hr_work<?=$time?>').show();
		$('#tab_hr_info_other<?=$time?>').tabs('select','工作信息');
	}

	$('#sp_card<?=$time?>').hide();
	if( msg && $('#table_card<?=$time?> .div_input_require').length > 0 )
	{
		$('#sp_card<?=$time?>').text(msg);
		$('#sp_card<?=$time?>').show();
		$('#tab_hr_info_other<?=$time?>').tabs('select','卡帐信息');
	}

	$('#sp_idcard<?=$time?>').hide();
	if( msg && $('#table_idcard<?=$time?> .div_input_require').length > 0 )
	{
		$('#sp_idcard<?=$time?>').text(msg);
		$('#sp_idcard<?=$time?>').show();
		$('#tab_hr_info_other<?=$time?>').tabs('select','身份证件');
	}

	$('#sp_doc<?=$time?>').hide();
	if( msg && $('#table_doc<?=$time?> .div_input_require').length > 0 )
	{
		$('#sp_doc<?=$time?>').text(msg);
		$('#sp_doc<?=$time?>').show();
		$('#tab_hr_info_other<?=$time?>').tabs('select','档案信息');
	}

	$('#sp_addr<?=$time?>').hide();
	if( msg && $('#table_addr<?=$time?> .div_input_require').length > 0 )
	{
		$('#sp_addr<?=$time?>').text(msg);
		$('#sp_addr<?=$time?>').show();
		$('#tab_hr_info_other<?=$time?>').tabs('select','居住信息');
	}

	$('#sp_family<?=$time?>').hide();
	if( msg && $('#table_family<?=$time?> .div_input_require').length > 0 )
	{
		$('#sp_family<?=$time?>').text(msg);
		$('#sp_family<?=$time?>').show();
		$('#tab_hr_info_other<?=$time?>').tabs('select','家庭信息');
	}

	$('#sp_edu<?=$time?>').hide();
	if( msg && $('#table_edu<?=$time?> .div_input_require').length > 0 )
	{
		$('#sp_edu<?=$time?>').text(msg);
		$('#sp_edu<?=$time?>').show();
		$('#tab_hr_info_other<?=$time?>').tabs('select','教育信息');
	}

	$('#sp_work<?=$time?>').hide();
	if( msg && $('#table_work<?=$time?> .div_input_require').length > 0 )
	{
		$('#sp_work<?=$time?>').text(msg);
		$('#sp_work<?=$time?>').show();
		$('#tab_hr_info_other<?=$time?>').tabs('select','工作经历');
	}

	$('#sp_train<?=$time?>').hide();
	if( msg && $('#table_train<?=$time?> .div_input_require').length > 0 )
	{
		$('#sp_train<?=$time?>').text(msg);
		$('#sp_train<?=$time?>').show();
		$('#tab_hr_info_other<?=$time?>').tabs('select','培训经历');
	}
}

function load_c_code_person<?=$time?>()
{
	$('#txtb_c_code_person<?=$time?>').textbox('textbox').bind('blur',
	function(){
		fun_c_birthday_readonly<?=$time?>()
	});

	fun_c_birthday_readonly<?=$time?>();
}

function fun_c_birthday_readonly<?=$time?>()
{
	var code=$('#txtb_c_code_person<?=$time?>').textbox('getValue');
	
	if(code)
	{
		var birth=getBirthFromIdCard(code);
		if(birth)
		{
			$('#txtb_c_birthday<?=$time?>').datebox({
				readonly:true,
				hasDownArrow:false,
				icons: [{
					iconCls:'icon-lock'
				}]
			});
			$('#txtb_c_birthday<?=$time?>').datebox('setValue',birth);
		}
		else
		{
			$('#txtb_c_birthday<?=$time?>').datebox({
				readonly:false,
				hasDownArrow:true,
				icons: [{
					iconCls:'icon-clear',
					handler: function(e){
						$(e.data.target).datebox('clear');
					}
				}]
			});

			$('#txtb_c_birthday<?=$time?>').datebox('textbox').bind('focus',
			function(){
				$(this).parent().prev().datebox('showPanel');
			});
		}
	}
}
</script>