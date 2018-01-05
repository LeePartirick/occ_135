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

		//评审人
		load_table_crp<?=$time?>();
		
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
					param['content[cr_ppo]'] = data_form['content[cr_ppo_s]'];

					param['content[crp]'] = data_form['content[crp]'];
					param['content[cr_link_file]'] = data_form['content[cr_link_file]'];
					param['content[cr_default]'] = data_form['content[cr_default]'];

					param['content[cr_person_empty]'] = data_form['content[cr_person_empty]'];
					param['content[cr_pass_alter]'] = data_form['content[cr_pass_alter]'];
					
					if('<?=$fun_no_db?>')
					{
						param.data_db = '<?=$data_db_post?>';
					}

				}
				else
				{
					$(this).form('enableValidation').form('validate');

					return false;
				}

			},
			success: function(data){

				alert(data)
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

					//遍历form 错误消息添加
					fun_show_errmsg_of_form('f_<?=$time?>',json.err);

					$(this).form('enableValidation').form('validate');
				}
				else
				{
					if('<?=$fun_no_db?>')
					{
						eval("<?=$fun_no_db?>('f_<?=$time?>','"+btn+"')")
						return;
					}
					
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
							url+='/act/<?=STAT_ACT_EDIT?>/cr_id/'+json.id

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

	function load_cr_ppo<?=$time?>()
	{
		var opt = $('#txtb_cr_ppo<?=$time?>').textbox('options');

		if(  opt.readonly ) return;

		$('#txtb_cr_ppo<?=$time?>').combobox('textbox').bind('keyup',function(){
			this.value=this.value.replace(/\D/g,'')
		})
		
		$('#txtb_cr_ppo<?=$time?>').combobox('textbox').bind('afterpaste',function(){
			this.value=this.value.replace(/\D/g,'')
		})
		
		$('#txtb_cr_ppo<?=$time?>').combobox('textbox').bind('focus',function(){
			$(this).parent().prev().combobox('showPanel');
		})
	}

	//评审关联文件
	function load_cr_link_file<?=$time?>()
	{
		var opt = $('#txtb_cr_link_file<?=$time?>').tagbox('options');

		if(  opt.readonly ) return;

		$('#txtb_cr_link_file<?=$time?>').tagbox('textbox').autocomplete({
			serviceUrl: 'proc_file/file_type/get_json/search_f_t_proc/proc_gfc',
			width:'300',
			params:{
				rows:10,
			},
			onSelect: function (suggestion) {

				var f_t_id = base64_decode(suggestion.data.f_t_id)
				var f_t_name = base64_decode(suggestion.data.f_t_name)
	        	
	        	var values=$('#txtb_cr_link_file<?=$time?>').tagbox('getValues');

	        	if(values.indexOf(f_t_id) > -1 ) 
	        	{
	        		layer.tips(f_t_name+'已存在！'
	                		, $('#txtb_cr_link_file<?=$time?>').tagbox('textbox')
	                		,{
	                		  tips: [1],
	                		  time: 2000
	        				 }
	                		);
	            	return;
	        	}
	        	
	        	var data = $('#txtb_cr_link_file<?=$time?>').tagbox('getData');

	        	data.push({id: f_t_id,text:f_t_name});
	        	$('#txtb_cr_link_file<?=$time?>').tagbox('loadData',data);
	        	
	        	values.push(f_t_id);
	        	$('#txtb_cr_link_file<?=$time?>').tagbox('setValues',values);
			}
		});
	}

	//评审人--载入
	function load_table_crp<?=$time?>()
	{
	    $('#table_crp<?=$time?>').edatagrid({
	        width:'100%',
	        height:'200',
	        toolbar:'#table_crp_tool<?=$time?>',
	        singleSelect:true,
	        selectOnCheck:false,
	        checkOnSelect:false,
	        striped:true,
	        idField:'crp_c_id',
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
				{field:'crp_id',title:'',width:50,align:'center',checkbox:true},
				{field:'crp_c_id',title:'评审人',width:120,halign:'center',align:'left',
				    formatter: fun_table_crp_formatter<?=$time?>,
		    		editor:{
						type:'combobox',
						options:{
							height:'25',
							hasDownArrow:false,
							panelHeight:0,
							required:true,
							buttonIcon:'icon-clear',
				     	   	onClickButton:function()
				         	{
								$(this).combobox('clear');
				         	},
						}
					} 
				},
				{field:'ou_name',title:'评审部门',width:150,halign:'center',align:'center',
				    formatter: fun_table_crp_formatter<?=$time?>,
		    		editor:{
						type:'textbox',
						options:{
							height:'25',
							icons:[{
							   iconCls:'icon-lock',
						   }]
						}
					} 
				},    	
				{field:'crp_note',title:'备注',width:150,halign:'center',align:'left',
				    formatter: fun_table_crp_formatter<?=$time?>,
		    		editor:{
						type:'textbox',
						options:{
							height:'25',
							buttonIcon:'icon-clear',
				     	   	onClickButton:function()
				         	{
								$(this).textbox('clear');
				         	},
						}
					} 
				},
				{field:'cr_gfc_category_main',title:'可评审性质',width:150,halign:'center',align:'left',
				    formatter: fun_table_crp_formatter<?=$time?>,
		    		editor:{
						type:'combotree',
						options:{
				    	 	valueField:'id',    
						 	textField:'text',
							panelHeight:'auto',
							multiple:true,
							required:true,
							data: [<?=element('gfc_category_main',$json_field_define)?>],
							buttonIcon:'icon-clear',
				     	   	onClickButton:function()
				         	{
								$(this).combotree('clear');
				         	},
						}
					} 
				},
				{field:'cr_gfc_ou',title:'可评审部门',width:200,halign:'center',align:'left',
				    formatter: fun_table_crp_formatter<?=$time?>,
		    		editor:'text'
				},
	        ]],
//	        frozenColumns:[[
//	        ]],
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

	        	var ed_crp_c_id = '';
	        	var ed_ou_name = '';
	        	var ed_cr_gfc_ou = '';
	        	
				for(var i = 0;i < ed_list.length; i++)
				{
					switch(ed_list[i].field)
					{
						case 'crp_c_id':

							ed_crp_c_id =  ed_list[i].target;
							
							if(row.crp_c_id ) $(ed_list[i].target).combobox('setValue',row.crp_c_id);
							if(row.crp_c_id_s ) $(ed_list[i].target).combobox('setText',row.crp_c_id_s);
							
							break;
						case 'ou_name':

							ed_ou_name =  ed_list[i].target;
							
							break;
						case 'cr_gfc_ou':

							ed_cr_gfc_ou = ed_list[i].target;
							
							$(ed_list[i].target).tagbox({
								 required:true,
								 valueField:'id',
	    						 textField:'text',
	    						 limitToList:true,
	    						 missingMessage:'该输入项为必填项',
	   			   				 height:'25',
	   			   				 width:'90%',
	   			   				 hasDownArrow:false,
	   			   				 panelHeight:'0px',
	   			   				 onShowPanel:function()
	   			   				 {
	   			   				 	$(this).tagbox('hidePanel');
	   			   				 },
		   			   			 buttonIcon:'icon-clear',
					     	   	 onClickButton:function()
					         	 {
									$(this).tagbox('clear');
					         	 },
	   			   				 iconAlign:'left',
	   			   				 icons:[{
									iconCls:'icon-tree',
									handler: function(e){

		   			   	        	var win_id=fun_get_new_win();
		   			   	    		
		   			   	    		$('#'+win_id).window({
		   			   	    			title: '选择团队-双击选择部门',
		   			   	    			inline:true,
		   			   	    			modal:true,
		   			   	    			//closed:true,
		   			   	    			border:'thin',
		   			   	    			draggable:false,
		   			   	    			resizable:false,
		   			   	    			
		   			   	    			collapsible:false,  
		   			   	    			minimizable:false,
		   			   	    			maximizable:false,
		   			   	    		})
		   			   	    		
		   			   	    		$('#'+win_id).window('refresh','proc_ou/ou/win_tree/flag_select/1/fun_select/fun_crp_cr_gfc_ou<?=$time?>');
		   			   	    		$('#'+win_id).window('center');

									}
								 }]
							});	

							if(row.cr_gfc_ou_data)
								$(ed_list[i].target).tagbox('loadData',JSON.parse(row.cr_gfc_ou_data));

							$(ed_list[i].target).tagbox('textbox').autocomplete({
								serviceUrl: 'base/auto/get_json_ou',
								width:'400',
								params:{
									rows:10,
								},
								onSelect: function (suggestion) {

									var ou_id = base64_decode(suggestion.data.ou_id)
									var ou_name = base64_decode(suggestion.data.ou_name)

									var values=$(ed_cr_gfc_ou).tagbox('getValues');

						        	if(values.indexOf(ou_id) > -1 ) 
						        	{
						        		layer.tips(ou_name+'已存在！'
						                		, $(ed_cr_gfc_ou).tagbox('textbox')
						                		,{
						                		  tips: [1],
						                		  time: 2000
						        				 }
						                		);
						            	return;
						        	}
						        	
						        	var data = $(ed_cr_gfc_ou).tagbox('getData');
						        	if(data == '[]')
						        	data = JSON.parse(data);

						        	data.push({ id: ou_id, text: ou_name });
						        	$(ed_cr_gfc_ou).tagbox('loadData',data);
						        	
						        	values.push(ou_id);
						        	$(ed_cr_gfc_ou).tagbox('setValues',values);
								}
							});		
							break;
					}
				}

				var crp_c_id = row.crp_c_id;
				$(ed_crp_c_id).combobox('textbox').autocomplete({
					serviceUrl: 'base/auto/get_json_contact/search_c_login_id/1',
					width:'300',
					params:{
						rows:10,
					},
					onSelect: function (suggestion) {

						var c_id = base64_decode(suggestion.data.c_id);
						var c_show = base64_decode(suggestion.data.c_show);
						var index_s = $('#table_crp<?=$time?>').edatagrid('getRowIndex',c_id);
						
						if( c_id != crp_c_id && index_s > -1) 
						{
							$(ed_crp_c_id).combobox('clear');

							layer.tips(c_show+'已存在！'
	                		, $(ed_crp_c_id).combobox('textbox')
	                		,{
	                		  tips: [1],
	                		  time: 2000
	        				 }
	                		);
	                		
							return;
						}
						
						$(ed_crp_c_id).combobox('setValue',c_id);
						$(ed_crp_c_id).combobox('setText',c_show);

						$(ed_ou_name).textbox('setValue',base64_decode(suggestion.data.c_ou_bud_s));
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
						case 'crp_c_id':
							row.crp_c_id_s = $(ed_list[i].target).combobox('getText');
							row.crp_c_id = $(ed_list[i].target).combobox('getValue');
							break;
						case 'cr_gfc_category_main':
							row.cr_gfc_category_main_s = $(ed_list[i].target).combotree('getText');
							break;
						case 'cr_gfc_ou':

							row.cr_gfc_ou = $(ed_list[i].target).tagbox('getValues');

							row.cr_gfc_ou_s = '';
							row.cr_gfc_ou_data = $(ed_list[i].target).tagbox('getData');
							for ( var j=0;j<row.cr_gfc_ou_data.length;j++)
							{
								if(row.cr_gfc_ou.indexOf(row.cr_gfc_ou_data[j].id) > -1)
									row.cr_gfc_ou_s += row.cr_gfc_ou_data[j].text+',';
							}
							row.cr_gfc_ou_data = JSON.stringify(row.cr_gfc_ou_data);

							$(ed_list[i].target).tagbox('destroy');
							break;
					}
				}
	        },
	    });

	    if( arr_view<?=$time?>.indexOf('content[crp]')>-1 )
	    {
	    	$('#table_crp<?=$time?>').edatagrid('disableEditing');
	        $('#table_crp_tool<?=$time?> .oa_op').hide();
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
	function fun_table_crp_formatter<?=$time?>(value,row,index){

	    switch(this.field)
	    {
	        default:
	            if(row[this.field+'_s'])
	                value = row[this.field+'_s'];
	    }

	    if( ! value ) value = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ;
	    return '<span id="table_crp<?=$time?>_'+index+'_'+this.field+'" class="table_crp<?=$time?>" >'+value+'</span>';
	}

	//选择
	function fun_crp_cr_gfc_ou<?=$time?>(op,row)
	{
		$('#'+op).closest('.op_window').window('close');
		
		var row_s = $('#table_crp<?=$time?>').datagrid('getSelected');
		var index_s = $('#table_crp<?=$time?>').datagrid('getRowIndex',row_s);

		var ed = $('#table_crp<?=$time?>').datagrid('getEditor', {index:index_s,field:'cr_gfc_ou'});
		
		var ou_id = base64_decode(row.ou_id)
		var ou_name = base64_decode(row.ou_name)

		var values=$(ed.target).tagbox('getValues');

    	if(values.indexOf(ou_id) > -1 ) 
    	{
    		layer.tips(ou_name+'已存在！'
            		, $(ed_cr_gfc_ou).tagbox('textbox')
            		,{
            		  tips: [1],
            		  time: 2000
    				 }
            		);
        	return;
    	}
    	
    	var data = $(ed.target).tagbox('getData');
    	if(data == '[]')
    	data = JSON.parse(data);

    	data.push({ id: ou_id, text: ou_name });
    	$(ed.target).tagbox('loadData',data);
    	
    	values.push(ou_id);
    	$(ed.target).tagbox('setValues',values);
		
	}

	//评审人--操作
	function fun_table_crp_operate<?=$time?>(btn)
	{
	    switch(btn)
	    {
	    	case 'up':
	    	case 'down':
				var row_s = $('#table_crp<?=$time?>').datagrid('getSelected');
				var rows = $('#table_crp<?=$time?>').datagrid('getRows');
				if( ! row_s) return ;

				var index_s = $('#table_crp<?=$time?>').datagrid('getRowIndex',row_s);

				if(btn == 'up')
				{
					if(index_s > 0)
					{
						$('#table_crp<?=$time?>').datagrid('deleteRow',index_s);
						$('#table_crp<?=$time?>').datagrid('insertRow',{
							index: index_s -1,	// 索引从0开始
							row: row_s
						});
						$('#table_crp<?=$time?>').datagrid('selectRow',index_s-1);
					}
				}
				else
				{
					if(index_s < rows.length)
					{
						$('#table_crp<?=$time?>').datagrid('deleteRow',index_s);
						index_s += 1;
						$('#table_crp<?=$time?>').datagrid('insertRow',{
							index: index_s ,	// 索引从0开始
							row: row_s
						});
						$('#table_crp<?=$time?>').datagrid('selectRow',index_s);
					}
				}
				
		    	break;
	        case 'add':

//	        	var win_id=fun_get_new_win();
//	    		
//	    		$('#'+win_id).window({
//	    			title: '添加评审人-勾选选择评审人',
//	    			inline:true,
//	    			modal:true,
////	    			closed:true,
//	    			border:'thin',
//	    			draggable:false,
//	    			resizable:false,
//	    			collapsible:false,  
//	    			minimizable:false,
//	    			maximizable:false,
//	    		})
//	    		
//	    		$('#'+win_id).window('refresh','proc_contact/contact/index/search_c_type/1/fun_open/window/fun_open_id/'+win_id+'/flag_select/1/fun_select/fun_crp_add<?=$time?>');
//	    		$('#'+win_id).window('center');

				var op_id = get_guid();
	    		$('#table_crp<?=$time?>').edatagrid('addRow',{
	    			index:0,
	    			row:{
	    			crp_id: op_id,
	    			}
	    		});

	            break;
	        case 'del':

	            var op_list=$('#table_crp<?=$time?>').datagrid('getChecked');

	            var row_s = $('#table_crp<?=$time?>').datagrid('getSelected');
	            var index_s = $('#table_crp<?=$time?>').datagrid('getRowIndex',row_s);

	            if($('#table_crp<?=$time?>').datagrid('validateRow',index_s))
	            {
	                $('#table_crp<?=$time?>').datagrid('endEdit',index_s);
	            }
	            else
	            {
	                $('#table_crp<?=$time?>').datagrid('cancelEdit',index_s);
	            }

	            for(var i=op_list.length-1;i>-1;i--)
	            {
	                var index = $('#table_crp<?=$time?>').datagrid('getRowIndex',op_list[i]);
	                $('#table_crp<?=$time?>').datagrid('deleteRow',index);
	            }
	                    
	            break;
	    }
	}

	//批量添加评审人
	function fun_crp_add<?=$time?>(op)
	{
		$(op).closest('.op_window').window('close');
		
		var list=$(op).datagrid('getChecked');

		for(var i=0;i<list.length;i++)
		{
			var row = {};
			row.crp_id = get_guid();
			row.crp_c_id = base64_decode(list[i].c_id);
			row.c_name = base64_decode(list[i].c_name);
			row.c_login_id = base64_decode(list[i].c_login_id)
			row.c_tel = base64_decode(list[i].c_tel)
			var index = $('#table_crp<?=$time?>').datagrid('getRowIndex',row.crp_c_id);

			if(index < 0)
			$('#table_crp<?=$time?>').datagrid('appendRow',row);
		}
		
		$(op).closest('.op_window').window('destroy').remove();
	}
</script>