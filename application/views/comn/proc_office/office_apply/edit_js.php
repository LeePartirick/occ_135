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

	//载入信息系统
	load_table_office<?=$time?>();
			
	setTimeout(function(){

		//添加只读，编辑,必填
		fun_form_operate('f_<?=$time?>',<?=$field_view;?>,<?=$field_edit;?>,<?=$field_required?>);

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

				param['content[office]']=data_form['content[office]'];

			}
			else
			{
				$(this).form('enableValidation').form('validate');

				return false;
			}

		},
		success: function(data){
			$('#win_loading<?=$time?>').window('close');
			//alert(data);
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
						url+='/act/<?=STAT_ACT_EDIT?>/offa_id/'+json.id

						fun_send_wl(json);
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

//申请人自动补全
function load_offa_c_apply<?=$time?>()
{
	var opt = $('#txtb_offa_c_apply_s<?=$time?>').textbox('options');

	if(  opt.readonly ) return;

	$('#txtb_offa_c_apply_s<?=$time?>').textbox('textbox').autocomplete({
		serviceUrl: 'base/auto/get_json_contact/search_c_login_id/1',
		width:'300',
		params:{
			rows:10,
		},
		onSelect: function (suggestion) {
			$('#txtb_offa_c_apply_s<?=$time?>').textbox('setValue',base64_decode(suggestion.data.c_name));
			$('#txtb_offa_c_apply<?=$time?>').val(base64_decode(suggestion.data.c_id))
		}
	});
}

//系统所有人自动补全
function load_offa_c_id<?=$time?>()
{
	var opt = $('#txtb_offa_c_id_s<?=$time?>').textbox('options');

	if(  opt.readonly ) return;

	$('#txtb_offa_c_id_s<?=$time?>').textbox('textbox').autocomplete({
		serviceUrl: 'base/auto/get_json_contact/search_c_login_id/1',
		width:'300',
		params:{
			rows:10,
		},
		onSelect: function (suggestion) {
			$('#txtb_offa_c_id_s<?=$time?>').textbox('setValue',base64_decode(suggestion.data.c_name));
			$('#txtb_offa_c_id<?=$time?>').val(base64_decode(suggestion.data.c_id));
			$('#txtb_c_org<?=$time?>').val(base64_decode(suggestion.data.c_org));
		}
	});
}

//信息系统--载入
var c_login_id = '<?=$c_login_id?>';
function load_table_office<?=$time?>()
{
	$('#table_office<?=$time?>').edatagrid({
		width:'100%',
		height:'200',
		toolbar:'#table_office_tool<?=$time?>',
		singleSelect:true,
		selectOnCheck:false,
		checkOnSelect:false,
		striped:true,
		idField:'offai_id',
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
			{field:'offai_offi_id',title:'信息系统',width:200,halign:'center',align:'left',
				formatter: fun_table_office_formatter<?=$time?>,
				editor:{
					type:'combobox',
					options:{
						limitToList:true,
						valueField:'id',
						textField:'text',
						panelHeight:'auto',
						panelMaxHeight:120,
						required : true,
						buttonIcon:'icon-clear',
				    	onClickButton:function()
				        {
							$(this).combobox('clear');
				        },
					    onLoadSuccess: function()
					    {
							$(this).combobox('textbox').bind('focus',
							function(){
								$(this).parent().prev().combobox('showPanel');
							});

							var row_s = $('#table_office<?=$time?>').datagrid('getSelected');
							$(this).combobox('setValue',row_s.offai_offi_id);
					    }
					}
				}
			},
			{field:'offai_model',title:'开通',width:200,halign:'center',align:'left',
				formatter: fun_table_office_formatter<?=$time?>,
				editor:{
					type:'textbox',
					options:{
						buttonIcon:'icon-clear',
				    	onClickButton:function()
				        {
							$(this).textbox('clear');
				        },
					}
				}
			},  
			{field:'offai_start_info',title:'开通信息',width:150,halign:'center',align:'left',
				formatter: fun_table_office_formatter<?=$time?>,
			},
			{field:'offai_flag_alert',
			 title:'<label data-toggle="checkbox" class="checkbox-pretty"><input type="checkbox" onClick="fun_office_check<?=$time?>(this,\'offai_flag_alert\');"><span>提醒</span></label>',
			 width:60,halign:'center',align:'center',
				formatter: fun_table_office_formatter<?=$time?>,
				editor:{
					"type":"checkbox",
	        		"options":{
	        			"on":'1',
	        			"off":''
	        		}
				}
			},
			{field:'offai_note',title:'备注',width:200,halign:'center',align:'left',
				formatter: fun_table_office_formatter<?=$time?>,
				editor:{
					type:'textbox',
					options:{
						buttonIcon:'icon-clear',
				    	onClickButton:function()
				        {
							$(this).textbox('clear');
				        },
					}
				}
			},
		]],
		frozenColumns:[[
			{field:'offai_id',title:'',width:50,align:'center',checkbox:true},
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
			var ed_list=$(this).datagrid('getEditors',index);

			for(var i = 0;i < ed_list.length; i++)
			{
				switch(ed_list[i].field)
				{
					case 'offai_offi_id':

						if('<?=$ppo?>' == '<?=OA_OFFA_PPO_START?>')
						{
							var url = 'proc_office/oa_office/get_json/from/combobox/field_id/offi_id/field_text/offi_name';

							if(row.c_org) url+='/search_org/'+row.c_org;
							if(row.offai_offi_id) url+='/search_offi_id/'+row.offai_offi_id;

							$(ed_list[i].target).combobox('reload',url);
						}
						else
						{
							$(ed_list[i].target).combobox({
								readonly:true,
								required:false,
								hasDownArrow:false,
								buttonIcon:'icon-lock',
						    	onClickButton:function()
						        {
						        },
							});
							$(ed_list[i].target).combobox('setValue',row.offai_offi_id)
							$(ed_list[i].target).combobox('setText',row.offai_offi_id_s)
						}

						break;

					case 'offai_model':
						//信息系统
						switch(row.offai_offi_id)
						{
							//LDAP账户
							case '26B028F103FD5AE7C1018A214D79E9EC':

								if('<?=$ppo?>' == '<?=OA_OFFA_PPO_ACCOUNT?>')
								{
									$(ed_list[i].target).combobox({
										width:'100%',
										hasDownArrow:false,
										panelHeight:0,
										required:true,
										buttonIcon:'icon-clear',
								    	onClickButton:function()
								        {
								        	$(this).combobox('clear');
								        },
										icons:[{
											iconCls:'icon-add',
											handler: function(e){

												var win_id=fun_get_new_win();
												var url = 'proc_back/account/edit/act/1';

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
														$(this).window('close');
														$(this).window('clear');
														window.open(url+'/fun_open/winopen');
													},
													onClose: function()
													{
														$('#'+win_id).window('destroy');
														$('#'+win_id).remove();
													}
												})

												$('#'+win_id).window('refresh',url+'/fun_open/win/fun_open_id/'+win_id);
											}
										},{
											iconCls:'icon-edit',
											handler: function(e){
												var win_id=fun_get_new_win();

												var a_id=$(e.data.target).combobox('getValue');
												if( ! a_id ) return;

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

												var url='proc_back/account/edit/act/2/a_id/'+a_id;
												$('#'+win_id).window('refresh',url+'/fun_open/win/fun_open_id/'+win_id);
											}
										}]
									});

									$(ed_list[i].target).combobox('textbox').autocomplete({
								        serviceUrl: 'base/auto/get_json_account',
								        width:'200',
								        params:{
											rows:5
										},
								        onSelect: function (suggestion) {

											c_login_id = base64_decode(suggestion.data.a_login_id);

											$(this).parent().prev().combobox('setValue',base64_decode(suggestion.data.a_id))
											$(this).parent().prev().combobox('setText',base64_decode(suggestion.data.a_login_id));

										}
									});
								}
								else
								{
									$(ed_list[i].target).combobox({
										width:'100%',
										hasDownArrow:false,
										panelHeight:0,
										readonly:true,
										buttonIcon:'icon-lock',
								    	onClickButton:function()
								        {
								        },
									});
								}

								$(ed_list[i].target).combobox('setValue',row.a_id)
								$(ed_list[i].target).combobox('setText',row.c_login_id);

								break;
							//短号
							case 'E733D2DF8A3A4D08E10F0604DD1689B0':
								$(ed_list[i].target).numberbox({
									required:true,
									width:'100%',
									buttonIcon:'icon-clear',
							    	onClickButton:function()
							        {
							        	$(this).numberbox('clear');
							        }
								});

								$(ed_list[i].target).numberbox('setValue',row.c_tel_code);

								break;
							//邮箱
							case 'BC952B1E100717A078BDD79B45CC0736':

								$(ed_list[i].target).textbox({
									icons:[{
										iconCls:'icon-ok',
										handler: function(e){
											if(c_login_id)
											$(e.data.target).textbox('setValue',c_login_id+'@30wish.net');
										}
									}],
									validType: 'email',
								});

								$(ed_list[i].target).textbox('setValue',row.c_email_sys);

								break;
							//工资邮箱
							case '53AB852B7054D11DBC846C5A6DBCE359':

								$(ed_list[i].target).textbox({
									icons:[{
										iconCls:'icon-ok',
										handler: function(e){
											if(c_login_id)
											$(e.data.target).textbox('setValue',c_login_id+'@30wishgz.net');
										}
									}],
									validType: 'email',
								});

								$(ed_list[i].target).textbox('setValue',row.c_email_gz);

								break;
							//手机上网ID
							case 'FA31B79FEA42C7A246E7A78F5FCEE504':

								$(ed_list[i].target).textbox({
									icons:[{
										iconCls:'icon-ok',
										handler: function(e){
											if(c_login_id)
											$(e.data.target).textbox('setValue','m_'+c_login_id);
										}
									}],
								});

								$(ed_list[i].target).textbox('setValue',row.c_login_id_m);

								break;
							//网络证书
							case '17384E798664501D49970BFF1959A175':

								$(ed_list[i].target).textbox({
									required:true,
								});

								$(ed_list[i].target).textbox('setValue',row.c_pwd_web);

								break;
							default:
								$(ed_list[i].target).textbox({
									icons:[{
										iconCls:'icon-ok',
										handler: function(e){
											$(e.data.target).textbox('setValue','已开通');
										}
									}]
								});
						}


						break;
				}
			}
		},
		onEndEdit: function(index, row, changes)
		{
			var ed_list=$(this).datagrid('getEditors',index);

			for(var i = 0;i < ed_list.length; i++)
			{
				switch(ed_list[i].field)
				{
					case 'offai_offi_id':

						row.offai_offi_id_s = $(ed_list[i].target).combobox('getText');

						break;
					case 'offai_model':

						//信息系统
						switch(row.offai_offi_id)
						{
							//LDAP账户
							case '26B028F103FD5AE7C1018A214D79E9EC':

							row.c_login_id = $(ed_list[i].target).combobox('getText');
							row.a_id = $(ed_list[i].target).combobox('getValue');
							if(row.c_login_id)
							row.offai_model = '已开通,账户:'+row.c_login_id;
							break;

							//短号
							case 'E733D2DF8A3A4D08E10F0604DD1689B0':

							row.c_tel_code = $(ed_list[i].target).numberbox('getValue');
							if(row.c_tel_code)
							row.offai_model = '已开通,短号:'+row.c_tel_code;
							break;

							//网络证书
							case '17384E798664501D49970BFF1959A175':

							row.c_pwd_web = $(ed_list[i].target).textbox('getValue');
							if(row.c_pwd_web)
							row.offai_model = '已开通,<br>网络证书密码:'+row.c_pwd_web;
							break;

							//邮箱
							case 'BC952B1E100717A078BDD79B45CC0736':

							row.c_email_sys = $(ed_list[i].target).textbox('getValue');
							if(row.c_email_sys)
							row.offai_model = '已开通,<br>邮箱:'+row.c_email_sys;
							break;

							//工资邮箱
							case '53AB852B7054D11DBC846C5A6DBCE359':

							row.c_email_gz = $(ed_list[i].target).textbox('getValue');
							if(row.c_email_gz)
							row.offai_model = '已开通,<br>工资邮箱:'+row.c_email_gz;
							break;

							//手机上网
							case 'FA31B79FEA42C7A246E7A78F5FCEE504':

							row.c_login_id_m = $(ed_list[i].target).textbox('getValue');
							if(row.c_login_id_m)
							row.offai_model = '已开通,<br>手机上网ID'+row.c_login_id_m;
							break;

							default:


						}

						break;
				}
			}

		}
	});

	if( arr_view<?=$time?>.indexOf('content[office]')>-1 )
	{
		$('#table_office<?=$time?>').edatagrid('disableEditing');
		$('#table_office_tool<?=$time?> .oa_op').hide();
	}

	if('<?=$ppo?>' == '<?=OA_OFFA_PPO_START?>')
	{
		$('#table_office<?=$time?>').edatagrid('hideColumn','offai_model');
		$('#table_office<?=$time?>').edatagrid('hideColumn','offai_start_info');
		$('#table_office<?=$time?>').edatagrid('hideColumn','offai_flag_alert');
	}
	else
	{
		$('#table_office_tool<?=$time?> .oa_op').hide();
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

	$('#table_office<?=$time?>').edatagrid('freezeColumn','offai_offi_id');

}

//列格式化输出
function fun_table_office_formatter<?=$time?>(value,row,index){

	switch(this.field)
	{
		case 'offai_start_info':
			if(row.offai_person_start_s)
			value = row.offai_time_start+'<br>'+row.offai_person_start_s+' 开通 ';
			break;
		case 'offai_flag_alert':
			if(value) value='是';
			break;
		default:
			if(row[this.field+'_s'])
				value = row[this.field+'_s'];
	}

	if( ! value ) value = '' ;
	return '<span id="table_office<?=$time?>_'+index+'_'+this.field+'" class="table_office<?=$time?>" >'+value+'</span>';
}

//全选
function fun_office_check<?=$time?>(op,field)
{
	if( arr_view<?=$time?>.indexOf('content[office]')>-1 )
	return;

	var check = true;
	if($(op).parent().hasClass('checked'))
		check = false;

	var op_list=$('#table_office<?=$time?>').datagrid('getChecked');
	var row_s = $('#table_office<?=$time?>').datagrid('getSelected');
	var index_s = $('#table_office<?=$time?>').datagrid('getRowIndex',row_s);

	if($('#table_office<?=$time?>').datagrid('validateRow',index_s))
	{
		$('#table_office<?=$time?>').datagrid('endEdit',index_s);
	}
	else
	{
		$('#table_office<?=$time?>').datagrid('cancelEdit',index_s);
	}

	var arr_index=[];
	var row={};

	row[field]= '';

	if(check)
	switch(field)
	{
		case 'offai_flag_alert':
			row[field] = '1';
			break;
	}

	for(var i=op_list.length-1;i>-1;i--)
	{
		if(op_list[i].hide) continue;
		var index = $('#table_office<?=$time?>').datagrid('getRowIndex',op_list[i]);

		$('#table_office<?=$time?>').datagrid('updateRow',
		{
			index: index,
			row: row
		});

		arr_index.push(index);
	}

	$('#table_office<?=$time?>').datagrid('uncheckAll');

	setTimeout(function(){
		if(check)
		$(op).parent().addClass('checked');

		for(var i=0;i<arr_index.length;i++)
		{
			$('#table_office<?=$time?>').datagrid('checkRow',arr_index[i]);
		}
	},500)

}

//信息系统--操作
function fun_table_office_operate<?=$time?>(btn)
{
	switch(btn)
	{
		case 'add':

			var op_id = get_guid();
			var c_org = $('#txtb_c_org<?=$time?>').val();
			$('#table_office<?=$time?>').edatagrid('addRow',{
				index:0,
				row:{
					offai_id: op_id,
					c_org: c_org
				}
			});

			break;
		case 'del':

			var op_list=$('#table_office<?=$time?>').datagrid('getChecked');

			var row_s = $('#table_office<?=$time?>').datagrid('getSelected');
			var index_s = $('#table_office<?=$time?>').datagrid('getRowIndex',row_s);

			if($('#table_office<?=$time?>').datagrid('validateRow',index_s))
			{
				$('#table_office<?=$time?>').datagrid('endEdit',index_s);
			}
			else
			{
				$('#table_office<?=$time?>').datagrid('cancelEdit',index_s);
			}

			for(var i=op_list.length-1;i>-1;i--)
			{
				var index = $('#table_office<?=$time?>').datagrid('getRowIndex',op_list[i]);
				$('#table_office<?=$time?>').datagrid('deleteRow',index);
			}

			break;
	}
}
</script>