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

	//回款关联明细
	load_table_bsi<?=$time?>();
			
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

				param['content[bsi]']=data_form['content[bsi]'];

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

			//alert(data);
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
						url+='/act/<?=STAT_ACT_EDIT?>/bs_id/'+json.id

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

//回款单位自动补全
function load_bs_company_out<?=$time?>()
{
	var opt = $('#txtb_bs_company_out_s<?=$time?>').textbox('options');

	if(  opt.readonly ) return;

	$('#txtb_bs_company_out_s<?=$time?>').textbox({
		onClickButton: function()
		{
			$('#txtb_bs_company_out_s<?=$time?>').textbox('setValue','');
			$('#txtb_bs_company_out<?=$time?>').val('')
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

				var org = $('#bs_company_out<?=$time?>').val();

				if( ! org )
				{ 
					$.messager.show({
						title:'警告',
						msg:'请填写回款单位！',
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
	
	$('#txtb_bs_company_out_s<?=$time?>').textbox('textbox').autocomplete({
		serviceUrl: 'base/auto/get_json_org/search_o_status/1',
		params:{
			rows:10,
		},
		onSelect: function (suggestion) {
			$('#txtb_bs_company_out<?=$time?>').val(base64_decode(suggestion.data.o_id_standard));
			$('#txtb_bs_company_out_s<?=$time?>').textbox('setValue',base64_decode(suggestion.data.o_id_standard_s));
		}
	});
}

//回款统计人自动补全
function load_bs_contact_manager<?=$time?>()
{
	var opt = $('#txtb_bs_contact_manager_s<?=$time?>').textbox('options');

	if(  opt.readonly ) return;

	$('#txtb_bs_contact_manager_s<?=$time?>').textbox('textbox').autocomplete({
		serviceUrl: 'base/auto/get_json_contact/search_c_login_id/1',
		width:'300',
		params:{
			rows:10,
		},
		onSelect: function (suggestion) {
			$('#txtb_bs_contact_manager_s<?=$time?>').textbox('setValue',base64_decode(suggestion.data.c_show));
			$('#txtb_bs_contact_manager<?=$time?>').val(base64_decode(suggestion.data.c_id))
		}
	});
}

//回款金额
function load_bs_sum<?=$time?>()
{
	$('#txtb_bs_sum<?=$time?>').numberbox('textbox').css('text-align','right');
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

//回款关联--载入
function load_table_bsi<?=$time?>()
{
  $('#table_bsi<?=$time?>').edatagrid({
      width:'100%',
      height:'200',
      toolbar:'#table_bsi_tool<?=$time?>',
      singleSelect:true,
      selectOnCheck:false,
      checkOnSelect:false,
      striped:true,
      remoteSort: false,
      idField:'bsi_id',
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
          {field:'bsi_id',title:'',width:50,align:'center',checkbox:true},
          {field:'bsi_type',title:'关联类型',width:120,halign:'center',align:'left',
              formatter: fun_table_bsi_formatter<?=$time?>,
              editor:{
				type:'combobox',
				options:{
            	  	data: [<?=element('bsi_type',$json_field_define)?>],
          			panelHeight:'auto',
          			required:true,
          			valueField: 'id',    
                  	textField: 'text',  
                  	buttonIcon:'icon-clear',
		     	   	onClickButton:function()
		         	{
						$(this).combobox('clear');
		         	},
				}
			} 
          },
          {field:'bsi_link_id',title:'关联单据',width:300,halign:'center',align:'left',
              formatter: fun_table_bsi_formatter<?=$time?>,
              editor:{
				type:'combobox',
				options:{
  					 err:err,
					 panelHeight:'auto',
          			 required:true,
	          		 valueField: 'id',    
	                 textField: 'text',  
                  	 hasDownArrow:false,
                  	 onShowPanel: function()
                  	 {
						$(this).combobox('hidePanel');
                  	 },
                  	 buttonIcon:'icon-clear',
		     	   	 onClickButton:function()
		         	 {
						$(this).combobox('clear');
		         	 },
				}
			},
          },
          {field:'bsi_sum_nolink',title:'未关联金额',width:150,halign:'center',align:'right',
              formatter: fun_table_bsi_formatter<?=$time?>,
              editor:{
				type:'numberbox',
				options:{
              		readonly:true,
              		precision:2,
	   				min:0,
	   				groupSeparator:',',
		   			buttonIcon:'icon-lock',
		     	   	onClickButton:function()
		         	{
		         	},
				}
			} 
          },
          {field:'bsi_sum',title:'关联金额',width:150,halign:'center',align:'right',
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
		         	},
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
          $('.btn_bsi<?=$time?>').linkbutton();
      },
      onBeginEdit: function(index,row)
      {
      		var ed_list=$(this).datagrid('getEditors',index);

      		var ed_bsi_type='';
      		var ed_bsi_link_id='';
      		var ed_bsi_sum_nolink='';
      		var ed_bsi_sum='';
      		
			for(var i = 0;i < ed_list.length; i++)
			{
				switch(ed_list[i].field)
				{
					case 'bsi_type':
						ed_bsi_type = ed_list[i].target;
	      				
						break;
					case 'bsi_link_id':
						ed_bsi_link_id = ed_list[i].target;
						break;
					case 'bsi_sum_nolink':
						ed_bsi_sum_nolink = ed_list[i].target;
						$(ed_list[i].target).numberbox('textbox').css('text-align','right');
						break;
					case 'bsi_sum':

						ed_bsi_sum = ed_list[i].target;
							
						var bsi_sum_all = get_bsi_sum_all<?=$time?>();
				        var sum = $('#txtb_bs_sum<?=$time?>').numberbox('getValue');
						max = parseFloat(sum-bsi_sum_all);
						if( row.bsi_sum)
						max+=parseFloat(row.bsi_sum);
  					
	  					if( max == 0 )
	  					{
	  						$('#table_bsi<?=$time?>').datagrid('cancelEdit',index);
	  					}
	  					
	  					$(ed_list[i].target).numberbox({
								max:parseFloat(max)
	      				});
      					
						$(ed_list[i].target).numberbox('textbox').css('text-align','right');
  					break;
				}
			}

			$(ed_bsi_type).combobox({
				onChange:function(newValue, oldValue)
				{
					if(oldValue)
					$(ed_bsi_link_id).combobox('clear');

					var url = '';

					$(ed_bsi_link_id).combobox({icons:[]});
					$('.sui-dropdown-menu').hide();

					var bs_company_out = $('#txtb_bs_company_out<?=$time?>').val();
					
					switch(newValue)
					{
						case '<?=BSI_TYPE_BILL?>':
							url = 'proc_bill/bill/get_json/search_bill_ending_sum/1';

							$(ed_bsi_link_id).combobox({
								icons:[{
									iconCls:'icon-search',
									handler: function(e){
										var win_id=fun_get_new_win();
									
									    $('#'+win_id).window({
									     	title: '请选择开票',
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
								
									     $('#'+win_id).window('refresh','proc_bill/bill/index/fun_open/window/fun_open_id/'+win_id
											     	+'/flag_select/2/fun_select/fun_get_bill<?=$time?>/search_bill_ending_sum/1'
											     	+'/bill_org_customer/'+bs_company_out);
									     $('#'+win_id).window('center');
									}
								}]
							});
								
							$(ed_bsi_link_id).combobox('textbox').autocomplete({
								serviceUrl: url,
								params:{
									rows:10,
									field_s:'bill_code,bill_org_customer,bill_sum,bill_sum_return,bill_time_node_kp,gfc_finance_code,gfc_name,bill.ppo'
								},
								onSelect: function (suggestion) {
									
									$(ed_bsi_link_id).combobox('setValue',base64_decode(suggestion.data.bill_id));

									var bill_show = '开票编号：'+base64_decode(suggestion.data.bill_code)+'<br>'
												   +'开票金额：'+num_parse(base64_decode(suggestion.data.bill_sum))+'<br>'
												   +'统计时间：'+base64_decode(suggestion.data.bill_code)+'<br>'
												   +'财务编号：'+base64_decode(suggestion.data.gfc_finance_code)+'<br>'
												   +'项目名称：'+base64_decode(suggestion.data.gfc_name)+'<br>'
									
									$(ed_bsi_link_id).combobox('setText',bill_show);

									var sum = parseFloat(base64_decode(suggestion.data.bill_sum)) - parseFloat(base64_decode(suggestion.data.bill_sum_return))
									$(ed_bsi_sum).numberbox('setValue',sum);
									$(ed_bsi_sum_nolink).numberbox('setValue',sum);
								}
							});
							
							break;
						case '<?=BSI_TYPE_LOAN?>':

							url = 'proc_loan/loan/get_json/search_loan_ending_sum/1';

							$(ed_bsi_link_id).combobox({
								icons:[{
									iconCls:'icon-search',
									handler: function(e){
										var win_id=fun_get_new_win();
									
									    $('#'+win_id).window({
									     	title: '请选择非开票',
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
								
									     $('#'+win_id).window('refresh','proc_loan/loan/index/fun_open/window/fun_open_id/'+win_id
											     	+'/flag_select/2/fun_select/fun_get_loan<?=$time?>/search_loan_ending_sum/1'
											     	+'/loan_o_id/'+bs_company_out);
									     $('#'+win_id).window('center');
									}
								}]
							});
								
							$(ed_bsi_link_id).combobox('textbox').autocomplete({
								serviceUrl: url,
								params:{
									rows:10,
									field_s:'loan_code,loan_sum,loan_sum_return,loan_time_node,loan_gfc_id,gfc_finance_code,gfc_name,loan.ppo'
								},
								onSelect: function (suggestion) {

									var row = suggestion.data;

									$(ed_bsi_link_id).combobox('setValue',base64_decode(row.loan_id));

									var loan_show = '单据编号：'+base64_decode(row.loan_code)+'<br>'
												   +'借款金额：'+num_parse(base64_decode(row.loan_sum))+'<br>'
												   +'时间：'+base64_decode(row.loan_time_node)+'<br>'
												   +'财务编号：'+base64_decode(row.gfc_finance_code)+'<br>'
												   +'项目名称：'+base64_decode(row.gfc_name)+'<br>'
									
									$(ed_bsi_link_id).combobox('setText',loan_show);

									var sum = parseFloat(base64_decode(row.loan_sum)) - parseFloat(base64_decode(row.loan_sum_return))
									$(ed_bsi_sum).numberbox('setValue',sum);
									$(ed_bsi_sum_nolink).numberbox('setValue',sum);
									
								}
							});
							

							break;
						case '<?=BSI_TYPE_BP?>':

							url = 'proc_gfc/bp/get_json/flag_bs/1';

							$(ed_bsi_link_id).combobox({
								icons:[{
									iconCls:'icon-search',
									handler: function(e){
										var win_id=fun_get_new_win();
										
									    $('#'+win_id).window({
									     	title: '请选择回款计划',
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
								
									     $('#'+win_id).window('refresh','proc_gfc/bp/index/fun_open/window/fun_open_id/'+win_id
											     	+'/flag_select/2/fun_select/fun_get_bp<?=$time?>/flag_bs/1'
											     	+'/gfc_org_jia/'+bs_company_out);
									     $('#'+win_id).window('center');
									}
								}]
							});
							
							$(ed_bsi_link_id).combobox('textbox').autocomplete({
								serviceUrl: url,
								params:{
									rows:10,
									field_s:'bp_type,bp_sum,bp_time_back,bp_sum_hk,gfc_name,gfc_finance_code'
								},
								onSelect: function (suggestion) {
									
									$(ed_bsi_link_id).combobox('setValue',base64_decode(suggestion.data.bp_id));

									var bp_show = '财务编号：'+base64_decode(suggestion.data.gfc_finance_code)+'<br>'
												   +'项目名称：'+base64_decode(suggestion.data.gfc_name)+'<br>'
												   +'回款金额：'+num_parse(base64_decode(suggestion.data.bp_sum))+'<br>'
												   +'回款时间：'+base64_decode(suggestion.data.bp_time_back)+'<br>'
									   
									$(ed_bsi_link_id).combobox('setText',bp_show);

									var sum = parseFloat(base64_decode(suggestion.data.bp_sum)) - parseFloat(base64_decode(suggestion.data.bp_sum_hk))
									$(ed_bsi_sum).numberbox('setValue',sum);
									$(ed_bsi_sum_nolink).numberbox('setValue',sum);
								}
							});
							
							break;
					}
				}
			});

			$(ed_bsi_type).combobox('setValue',row.bsi_type);
			$(ed_bsi_link_id).combobox('setValue',row.bsi_link_id);
			$(ed_bsi_link_id).combobox('setText',row.bsi_link_id_s);

			$(ed_bsi_type).combobox('textbox').bind('focus',
			function(){
				$(this).parent().prev().combobox('showPanel');
			});

      },
      onEndEdit: function(index, row, changes)
      {
      		var ed_list=$(this).datagrid('getEditors',index);

			for(var i = 0;i < ed_list.length; i++)
			{
				switch(ed_list[i].field)
				{
					case 'bsi_type':
	
						row.bsi_type_s = $(ed_list[i].target).combobox('getText');
						break;
					case 'bsi_link_id':

						row.bsi_link_id = $(ed_list[i].target).combobox('getValue');
						row.bsi_link_id_s = $(ed_list[i].target).combobox('getText');
						break;
				}
			}

			load_bsi_prog<?=$time?>();

      },
      onAfterEdit: function(index, row, changes)
      {
    	  $('.btn_bsi<?=$time?>').linkbutton();
      }
  });

  if( arr_view<?=$time?>.indexOf('content[bsi]')>-1 )
  {
  	  $('#table_bsi<?=$time?>').edatagrid('disableEditing');
      $('#table_bsi_tool<?=$time?> .oa_op').hide();
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

//选择开票
function fun_get_bill<?=$time?>(op)
{
	var row_c=$(op).datagrid('getChecked');
	 
	if( row_c.length == 0) 
	{
		$.messager.show({
	    	title:'警告',
	    	msg:'请选择开票！',
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

	var row_s = $('#table_bsi<?=$time?>').datagrid('getSelected');
	var index_s = $('#table_bsi<?=$time?>').datagrid('getRowIndex',row_s);
	
	var ed_list=$('#table_bsi<?=$time?>').datagrid('getEditors',index_s);

	var ed_bsi_type='';
	var ed_bsi_link_id='';
	var ed_bsi_sum_nolink='';
	var ed_bsi_sum='';
		
	for(var i = 0;i < ed_list.length; i++)
	{
		switch(ed_list[i].field)
		{
			case 'bsi_type':
				ed_bsi_type = ed_list[i].target;
				break;
			case 'bsi_link_id':
				ed_bsi_link_id = ed_list[i].target;
				break;
			case 'bsi_sum_nolink':
				ed_bsi_sum_nolink = ed_list[i].target;
				break;
			case 'bsi_sum':
				ed_bsi_sum = ed_list[i].target;
				break;
		}
	}

	$(ed_bsi_link_id).combobox('setValue',base64_decode(row.bill_id));

	var bill_show = '开票编号：'+base64_decode(row.bill_code)+'<br>'
				   +'开票金额：'+num_parse(base64_decode(row.bill_sum))+'<br>'
				   +'统计时间：'+base64_decode(row.bill_code)+'<br>'
				   +'财务编号：'+base64_decode(row.gfc_finance_code)+'<br>'
				   +'项目名称：'+base64_decode(row.gfc_name)+'<br>'
	
	$(ed_bsi_link_id).combobox('setText',bill_show);

	var sum = parseFloat(base64_decode(row.bill_sum)) - parseFloat(base64_decode(row.bill_sum_return))
	$(ed_bsi_sum).numberbox('setValue',sum);
	$(ed_bsi_sum_nolink).numberbox('setValue',sum);
}

//选择非开票
function fun_get_loan<?=$time?>(op)
{
	var row_c=$(op).datagrid('getChecked');
	 
	if( row_c.length == 0) 
	{
		$.messager.show({
	    	title:'警告',
	    	msg:'请选择非开票！',
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

	var row_s = $('#table_bsi<?=$time?>').datagrid('getSelected');
	var index_s = $('#table_bsi<?=$time?>').datagrid('getRowIndex',row_s);
	
	var ed_list=$('#table_bsi<?=$time?>').datagrid('getEditors',index_s);

	var ed_bsi_type='';
	var ed_bsi_link_id='';
	var ed_bsi_sum_nolink='';
	var ed_bsi_sum='';
		
	for(var i = 0;i < ed_list.length; i++)
	{
		switch(ed_list[i].field)
		{
			case 'bsi_type':
				ed_bsi_type = ed_list[i].target;
				break;
			case 'bsi_link_id':
				ed_bsi_link_id = ed_list[i].target;
				break;
			case 'bsi_sum_nolink':
				ed_bsi_sum_nolink = ed_list[i].target;
				break;
			case 'bsi_sum':
				ed_bsi_sum = ed_list[i].target;
				break;
		}
	}

	$(ed_bsi_link_id).combobox('setValue',base64_decode(row.loan_id));

	var loan_show = '单据编号：'+base64_decode(row.loan_code)+'<br>'
				   +'借款金额：'+num_parse(base64_decode(row.loan_sum))+'<br>'
				   +'时间：'+base64_decode(row.loan_time_node)+'<br>'
				   +'财务编号：'+base64_decode(row.gfc_finance_code)+'<br>'
				   +'项目名称：'+base64_decode(row.gfc_name)+'<br>'
	
	$(ed_bsi_link_id).combobox('setText',loan_show);

	var sum = parseFloat(base64_decode(row.loan_sum)) - parseFloat(base64_decode(row.loan_sum_return))
	$(ed_bsi_sum).numberbox('setValue',sum);
	$(ed_bsi_sum_nolink).numberbox('setValue',sum);
}


//选择回款计划
function fun_get_bp<?=$time?>(op)
{
	var row_c=$(op).datagrid('getChecked');
	 
	if( row_c.length == 0) 
	{
		$.messager.show({
	    	title:'警告',
	    	msg:'请选择回款计划！',
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

	var row_s = $('#table_bsi<?=$time?>').datagrid('getSelected');
	var index_s = $('#table_bsi<?=$time?>').datagrid('getRowIndex',row_s);
	
	var ed_list=$('#table_bsi<?=$time?>').datagrid('getEditors',index_s);

	var ed_bsi_type='';
	var ed_bsi_link_id='';
	var ed_bsi_sum_nolink='';
	var ed_bsi_sum='';
		
	for(var i = 0;i < ed_list.length; i++)
	{
		switch(ed_list[i].field)
		{
			case 'bsi_type':
				ed_bsi_type = ed_list[i].target;
				break;
			case 'bsi_link_id':
				ed_bsi_link_id = ed_list[i].target;
				break;
			case 'bsi_sum_nolink':
				ed_bsi_sum_nolink = ed_list[i].target;
				break;
			case 'bsi_sum':
				ed_bsi_sum = ed_list[i].target;
				break;
		}
	}

	$(ed_bsi_link_id).combobox('setValue',base64_decode(row.bp_id));

	var bp_show = '财务编号：'+base64_decode(row.gfc_finance_code)+'<br>'
				   +'项目名称：'+base64_decode(row.gfc_name)+'<br>'
				   +'回款金额：'+num_parse(base64_decode(row.bp_sum))+'<br>'
				   +'回款时间：'+base64_decode(row.bp_time_back)+'<br>'
	   
	$(ed_bsi_link_id).combobox('setText',bp_show);

	var sum = parseFloat(base64_decode(row.bp_sum)) - parseFloat(base64_decode(row.bp_sum_hk))
	$(ed_bsi_sum).numberbox('setValue',sum);
	$(ed_bsi_sum_nolink).numberbox('setValue',sum);
}

//列格式化输出
function fun_table_bsi_formatter<?=$time?>(value,row,index){

  switch(this.field)
  {
  	  case 'bsi_sum_nolink':
  	  case 'bsi_sum':
	  		value = num_parse(value);
	      	break;
  	  case 'bsi_link_id':

  			var url = '';
			switch(row.bsi_type)
			{
				case '<?=BSI_TYPE_BILL?>':
					url = 'proc_bill/bill/edit/act/<?=STAT_ACT_EDIT?>/bill_id/'+row.bsi_link_id
					break;
				case '<?=BSI_TYPE_LOAN?>':
					url = 'proc_loan/loan/edit/act/<?=STAT_ACT_EDIT?>/loan_id/'+row.bsi_link_id
					break;
				case '<?=BSI_TYPE_BP?>':
					url = 'proc_gfc/gfc_bp/edit/act/<?=STAT_ACT_EDIT?>/gfc_id/'+row.bsi_gfc_id
					break;
			}
			value = '<a href="javascript:void(0)" class="easyui-linkbutton btn_bsi<?=$time?>" data-options="iconCls:\'icon-search\',plain:true"  onclick="fun_index_win_open<?=$time?>(\'123\',\'win\',\''+url+'\')"></a>'
  			value += row.bsi_link_id_s;
  			break;
      default:
          if(row[this.field+'_s'])
              value = row[this.field+'_s'];
  }

  if( ! value ) value = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ;
  return '<span id="table_bsi<?=$time?>_'+index+'_'+this.field+'" class="table_bsi<?=$time?>" >'+value+'</span>';
}

//回款关联--操作
function fun_table_bsi_operate<?=$time?>(btn)
{
  switch(btn)
  {
      case 'add':

      	var row_s = $('#table_bsi<?=$time?>').datagrid('getSelected');
      	var index_s = $('#table_bsi<?=$time?>').datagrid('getRowIndex',row_s);
      	if( index_s > -1)
      	{
				if($('#table_bsi<?=$time?>').datagrid('validateRow',index_s))
					$('#table_bsi<?=$time?>').datagrid('endEdit',index_s)
				else
					return;//$('#table_bsi<?=$time?>').datagrid('cancelEdit',index_s)
      	}
      	
      	var bsi_sum_all = get_bsi_sum_all<?=$time?>();

        var sum = $('#txtb_bs_sum<?=$time?>').numberbox('getValue');

  		var sum_remain = sum - bsi_sum_all;

      	if( sum_remain <= 0 ) return;
      	
      	var op_id = get_guid();
			$('#table_bsi<?=$time?>').edatagrid('addRow',{
				index:0,
				row:{
					bsi_id: op_id,
				}
			});

          break;
      case 'del':

          var op_list=$('#table_bsi<?=$time?>').datagrid('getChecked');

          var row_s = $('#table_bsi<?=$time?>').datagrid('getSelected');
          var index_s = $('#table_bsi<?=$time?>').datagrid('getRowIndex',row_s);

          if($('#table_bsi<?=$time?>').datagrid('validateRow',index_s))
          {
              $('#table_bsi<?=$time?>').datagrid('endEdit',index_s);
          }
          else
          {
              $('#table_bsi<?=$time?>').datagrid('cancelEdit',index_s);
          }

          for(var i=op_list.length-1;i>-1;i--)
          {
              var index = $('#table_bsi<?=$time?>').datagrid('getRowIndex',op_list[i]);
              $('#table_bsi<?=$time?>').datagrid('deleteRow',index);
          }

          load_bsi_prog<?=$time?>();
                  
          break;
  }

}

function get_bsi_sum_all<?=$time?>()
{
	var op_list=$('#table_bsi<?=$time?>').datagrid('getRows');

	var bsi_sum_all = 0;
	for(var i=0;i<op_list.length;i++)
	{
		if(op_list[i].bsi_sum)
		bsi_sum_all+=parseFloat(op_list[i].bsi_sum);
	}

	return bsi_sum_all;
}

function load_bsi_prog<?=$time?>()
{
  var bsi_sum_all = get_bsi_sum_all<?=$time?>();
	
  var sum = $('#txtb_bs_sum<?=$time?>').numberbox('getValue');

	var sum_remain = sum - bsi_sum_all;

	$('#bsi_prog<?=$time?>').progressbar({
		value: bsi_sum_all/sum*100,
		text: num_parse(bsi_sum_all)
	})
}
</script>