<!-- 加载jquery -->
<script type="text/javascript">

	//载入数据
	var data_<?=$time?>=<?=$data?>;
	var arr_disable = <?=$op_disable;?>; 
	//初始化
	$(document).ready(function(){

		load_win_loading('win_loading<?=$time?>')

		if('<?=$act?>' == <?=STAT_ACT_CREATE?>)
		{
			load_file_upload();
		}
		else
		{
			load_table_file_v<?=$time?>();
		}
								
		//添加禁用
		fun_l_disable_class('tab_edit_<?=$time?>',<?=$op_disable;?>);

		setTimeout(function(){

			//添加只读，编辑,必填
			fun_form_operate('f_<?=$time?>',<?=$field_view;?>,<?=$field_edit;?>,<?=$field_required?>,'<?=$flag_edit_more?>');
			
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

				if( btn == 'save' )
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

					param['content[f_type]']=data_form['content[f_type]'];
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
							url+='/act/<?=STAT_ACT_EDIT?>/f_id/'+json.id

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

	//载入文件上传
	function load_file_upload()
	{
		$('#tab_<?=$time?>').tabs();
		$('#tab_<?=$time?>').tabs('hideHeader')
		
		$('#btn_upload_file_<?=$time?>').linkbutton({
			iconCls:'icon-add', 
			width:60
		});
		
		var op_id = 'file_<?=$time?>';

		$('#btn_upload<?=$time?>').linkbutton({
			iconCls:'icon-upload',    
			onClick: function()
			{
				$('#f_<?=$time?>').form('enableValidation');
	
				var check= $('#f_<?=$time?>').form('enableValidation').form('validate');
				if( ! check )
					return false;

				var data_form = fun_get_data_from_f('f_<?=$time?>');
		
				eval('stream'+op_id+'.config.postVarsPerFile.f_note=\''+data_form['content[f_note]']+'\';');
				
				if(isArray(data_form['content[f_type]']))
				eval('stream'+op_id+'.config.postVarsPerFile.f_type=\''+data_form['content[f_type]'].join(',')+'\';');
				else
				eval('stream'+op_id+'.config.postVarsPerFile.f_type=\''+data_form['content[f_type]']+'\';');		
				
				eval('stream'+op_id+'.config.postVarsPerFile.f_secrecy=\''+data_form['content[f_secrecy]']+'\';');

				eval('stream'+op_id+'.config.postVarsPerFile.op_id=\'<?=$link_op_id?>\';');
				eval('stream'+op_id+'.config.postVarsPerFile.op_table=\'<?=$link_op_table?>\';');
				eval('stream'+op_id+'.config.postVarsPerFile.op_field=\'<?=$link_op_field?>\';');

				eval('stream'+op_id+'.config.postVarsPerFile.fun_m=\'<?=$fun_m?>\';');
				eval('stream'+op_id+'.config.postVarsPerFile.fun_up=\'<?=$fun_up?>\';');
				eval('stream'+op_id+'.config.postVarsPerFile.fun_ck=\'<?=$fun_ck?>\';');
				eval('stream'+op_id+'.config.postVarsPerFile.proc=\'<?=$search_f_t_proc?>\';');
				
				eval('stream'+op_id+'.upload();'); 
			}
		});

		switch('<?=$fun_open?>')
		{
			case 'win':
				$('#<?=$fun_open_id?>').attr('time',<?=$time?>);
				$('#<?=$fun_open_id?>').window({
					minimizable:false,
					onBeforeClose:function(){
		    			
				    	var file_num=0;
						eval('file_num=file_num'+op_id);
						
						if(file_num == 0 )
						eval('stream'+op_id+'.destroy();');
						else{

							$.messager.show({
								title:'通知',
								msg:'文件尚未上传完毕！不可关闭！',
								timeout:500,
								showType:'show',
								border:'thin',
								style:{
									right:'',
									bottom:'',
								}
							});
							return false;
						}
					}
				})
				break;
			case 'tab':
				var tab =$('#<?=$fun_open_id?>').tabs('getSelected');
				tab.panel('panel').attr('time',<?=$time?>);
				break;
			case 'winopen':
			case '':
				
				break;
		}
		
		$('#tab_edit_<?=$time?>').append('<div id="up_'+op_id+'"></div>');

		$('#up_'+op_id).panel({   
			href:'base/fun/win_upload/type/upload/op_id/'+op_id,
			method:'POST',
			queryParams:{
				div : 'div_upload<?=$time?>',
			}
		});

	}

	//载入版本列表
	function load_table_file_v<?=$time?>()
	{
		$('#table_file_v<?=$time?>').datagrid({    
		    fit:true,
		    title:'版本列表',
		    view: bufferview,
		    loadMsg:'',
		    border:false,
		    singleSelect:true,
		    rownumbers:true,
		    method:'POST',
		    queryParams: {
			},
			url:'proc_file/file/get_json_verson/f_id/<?=$f_id?>',
		    striped:true,
		    pagination:false,
			pagePosition:'top',
			pageNumber:1,
		    pageSize:50,
			pageList:[50],
			idField:'f_v_id',
			columns:[[  
				{field:'f_v_sn',title:'版本',width:'50',align:'right',
					formatter: fun_index_file_formatter<?=$time?>
				},
				{field:'op',title:'操作',width:'150',align:'center',
					formatter: fun_index_file_formatter<?=$time?>
				},
				{field:'f_v_size',title:'大小',width:'120',align:'right',
					formatter: fun_index_file_formatter<?=$time?>
			   	},
				{field:'db_person_create_s',title:'创建人',width:'150',align:'center',
					formatter: fun_index_file_formatter<?=$time?>
				},
				{field:'db_time_create',title:'创建时间',width:'150',align:'center',
					formatter: fun_index_file_formatter<?=$time?>
				},
				{field:'f_v_note',title:'日志',width:200,halign:'center',align:'center',
			   		formatter: fun_index_file_formatter<?=$time?>
			   	}
			]],
			onRowContextMenu: function(e, index, row)
			{
				if(row.now || arr_disable.indexOf('btn_verson') > -1)
					return;
				
				$('#menu_table_file_v<?=$time?>').menu({
					onClick: function(item)
					{
						 //保存配置
						$.ajax({
					        url:"proc_file/file/fun_update_verson",
					        type:"POST",
					        async:false,
					        data:{
								f_id: base64_decode(row.f_id),
								f_v_sn: base64_decode(row.f_v_sn),
								f_v_id: base64_decode(row.f_v_id),
								f_size: base64_decode(row.f_v_size),
					        },
					        success:function(data){
					        	reload_page<?=$time?>();
					        }
						});
					}
				});

				menu_show('menu_table_file_v<?=$time?>',e)
			}
		});
	}

	//列格式化输出
	function fun_index_file_formatter<?=$time?>(value,row,index)
	{
		value=base64_decode(value);
		
		switch(this.field)
		{
			case 'f_v_sn':
				if(row.now)
					return '<span style="color:red;"><b>'+value+'</b></span>'
				break;
			case 'f_v_size':
				value=$.filesize(value);
				break;
				
		}
		
		return value;
	}

	//上传文件版本
	function fun_upload_version<?=$time?>()
	{
		var op_id=get_guid();
		
		//导入窗口
		if($('#win_upload<?=$time?>').length == 0)
		{
			var html = '<div id="l_upload<?=$time?>" class="easyui-layout div_filter" data-options="fit:true,border:false">';
				html+= '<div data-options="region:\'north\',border:false" style="height:80px;padding:5px;">';
				html+= '<form id="f_file_upload<?=$time?>"  class="easyui-form" ><table><tr><td><input id="f_note<?=$time?>" style="width:400px;"/></td></tr></table></form>';
				html+= '<a href="javascript:void(0)" id="btn_upload_'+op_id+'" style="position:absolute;left:5px;bottom:2px;">选择</a> <a href="javascript:void(0)" id="btn_upload_verson<?=$time?>" style="position:absolute;left:70px;bottom:2px;">上传</a></div>';
				html+= '<div id="div_upload_verson<?=$time?>" data-options="region:\'center\',border:false" style="background: #E6EEF8;padding:5px;">'
				html+= '</div></div></div>'
					
			$('#tab_edit_<?=$time?>').after('<div id="win_upload<?=$time?>" style="overflow:hidden;">'+html+'</div>');

			$('#l_upload<?=$time?>').layout();

		}

		$('#f_file_upload<?=$time?>').form({
			 onSubmit: function(){    

					$(this).form('enableValidation');

					var check= $(this).form('enableValidation').form('validate');
					if( ! check )
						return false;
			
					var f_note = $('#f_note<?=$time?>').textbox('getValue');
					if(f_note.length>0)
					{
						eval('stream'+op_id+'.config.postVarsPerFile.f_v_note=\''+f_note+'\';');
					}
			
					eval('stream'+op_id+'.config.postVarsPerFile.f_id=\'<?=$f_id?>\'');
					
					eval('stream'+op_id+'.upload();'); 

					return false;
		    },    
		})

		$('#btn_upload_'+op_id).linkbutton({
			iconCls:'icon-add', 
			width:60
		})
		
		$('#btn_upload_verson<?=$time?>').linkbutton({
			iconCls:'icon-upload',    
			onClick: function()
			{
				$('#f_file_upload<?=$time?>').form('submit');
			}
		})

		$('#f_note<?=$time?>').textbox({    
			label:'备注',
			labelWidth:'50',
			height:40,
			multiline:true,
			buttonIcon:'icon-clear',
     	   	onClickButton:function()
         	{
				$(this).textbox('clear');
         	},
		}); 
		
		//载入上传控件
		var type_task='';

		var height="100%";
		if($('#l_file<?=$time?>').height() > 300 )
			height = 200;
		
		$('#win_upload<?=$time?>').dialog({  
			title:'上传文件版本',
			width:500,    
		    height:height,
		    border:'thin',
			resizable:false,  
			minimizable:false,
			maximizable:false,
			iconCls:'icon-upload',
		    modal:true,
		    inline:true,
			onOpen: function()
		    {
		    
		    },
		    onClose: function()
		    {
				eval('fun_disable_'+op_id+'();');
				
		    	var file_num=0;
				eval('file_num=file_num'+op_id);

					eval('stream'+op_id+'.destroy();');
				
				$('#win_upload<?=$time?>').dialog('destroy');
				$('#win_upload<?=$time?>').remove();

				reload_page<?=$time?>()
		    }
		});

		$('#p_main').append('<div id="up_'+op_id+'"></div>');

		$('#up_'+op_id).panel({   
			fit:true,
			href:'base/fun/win_upload/type/verson/op_id/'+op_id,
			method:'POST',
			queryParams:{
				div : 'div_upload_verson<?=$time?>'
			}
		});
	}

	//文件下载
	function fun_file_download<?=$time?>()
	{
		var data_form = fun_get_data_from_f('f_<?=$time?>',1);
		var f_name = data_form['f_name'];
		var f_v_sn = data_form['f_v_sn'];
		var f_secrecy = data_form['f_secrecy_s'];
		var db_time_create = data_form['db_time_create'];

		var arr = f_name.split('.');
		var ext = arr[arr.length - 1];
		arr.baoremove(arr.length - 1);

		var name = '['+f_secrecy+']'+arr.join('.')+'-'+f_v_sn+'-'+db_time_create.split(' ')[0]+'.'+ext;
		
		fun_file_download('<?=$f_v_id?>',name,'file')
	}

	//文件下载
	function load_f_secrecy<?=$time?>()
	{
		var opt = $('#txtb_f_secrecy<?=$time?>').combogrid('options');

		$('#txtb_f_secrecy<?=$time?>').combogrid({
			data:[<?=element('f_secrecy',$json_field_define)?>]
		}) 

		if(  opt.readonly ) return;

		$('#txtb_f_secrecy<?=$time?>').combogrid('textbox').bind('focus',
		function(){
			$(this).parent().prev().combogrid('showPanel');
		});
	}
</script>