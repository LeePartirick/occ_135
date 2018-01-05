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

		//预算表税种
		load_table_tax_type<?=$time?>()
				
		//载入预算表
		load_table_budi<?=$time?>();

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

					param['content[budm_tax_type]']=data_form['content[budm_tax_type]'];
					
					param['content[budi]']=data_form['content[budi]'];

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
							url+='/act/<?=STAT_ACT_EDIT?>/budm_id/'+json.id

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

	//载入预算表税种
	function load_table_tax_type<?=$time?>()
	{
		$('#table_tax_type<?=$time?>').edatagrid({    
			width:'100%',
			height:'200',
			toolbar:'#table_tax_type_tool<?=$time?>',
			singleSelect:true,
			selectOnCheck:false,
			checkOnSelect:false,
			striped:true,
			autoSave:true,
			idField:'t_id',
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
			columns:[[    
			    {field:'tax_id',title:'',width:50,align:'center',checkbox:true,
			     formatter: fun_tax_type_index_formatter<?=$time?>
		    	},
			    {field:'tax_name',title:'税种',width:300,halign:'center',align:'left',
	    		 editor:{
				   type:'combobox',
				   options:{
					   required:true,
					   buttonIcon:'icon-clear',
					   valueField:'id',    
					   textField:'text', 
					   panelHeight:'auto',
					   panelMaxHeight:'120',
					   url:'proc_bud/tax/get_json/from/combobox/field_id/t_id/field_text/t_name',
	            	   onClickButton:function()
	            	   {
	            	   		$(this).textbox('clear');
	            	   },
					}
				 },
	             formatter: fun_tax_type_index_formatter<?=$time?>
			    },
			    {field:'tax_rate',title:'税率',width:100,halign:'center',align:'right',
				 editor:{
				   type:'numberbox',
				   options:{
			    	   required:true,
					   suffix:'%',
					   min:0,
					   max:100,
					   buttonIcon:'icon-clear',
	            	   onClickButton:function()
	            	   {
	            	   		$(this).numberbox('clear');
	            	   }
					}
				 },
				 formatter: fun_tax_type_index_formatter<?=$time?>
	            },
	            {field:'tax_no_new',title:'不可新建',width:100,halign:'center',align:'center',
				 editor:{
				   type:'checkbox',
				   options:{
	        			on:'1',
	        			off:''
	        	    }
				 },
				 formatter: fun_tax_type_index_formatter<?=$time?>
	            }  
			]],
			rowStyler: function(index,row){
				if (row.act == <?=STAT_ACT_CREATE?>)
					return 'background:#ffd2d2'; 
				if (row.act == <?=STAT_ACT_REMOVE?>)
					return 'background:#e0e0e0'; 
				
			},
			onBeginEdit: function(index,row)
			{
				var ed_list=$(this).datagrid('getEditors',index);

				for(var i = 0;i < ed_list.length; i++)
				{
					switch(ed_list[i].field)
					{
						case 'tax_name':

							$(ed_list[i].target).combobox('setValue',row.t_id);
							$(ed_list[i].target).combobox('textbox').bind('focus',
							function(){
								$(this).parent().prev().combobox('showPanel');
							});
							
							break;
						case 'tax_rate':

							$(ed_list[i].target).numberbox('textbox').css('text-align','right')
							
							break;
					}
				}
			},
			onEndEdit: function(index, row, changes)
			{
				var index_check = $(this).datagrid('getRowIndex',row.t_id);

				if( index_check > -1 && index_check != index )
				{
					row.tax_name = '';
					
					return;
				}

				var ed_list=$(this).datagrid('getEditors',index);

				for(var i = 0;i < ed_list.length; i++)
				{
					switch(ed_list[i].field)
					{
						case 'tax_name':
							row.t_id = row.tax_name
							row.tax_name = $(ed_list[i].target).combobox('getText');
							break;
					}
				}

				$(this).datagrid('enableDnd');
			},
			onClickRow: function(index, row)
			{
				if($('#txtb_budi_count<?=$time?>').attr('disabled') != 'disabled')
				{
					var count = $('#txtb_budi_count<?=$time?>').tagbox('getValues');
					var str = $('#txtb_budi_count<?=$time?>').tagbox('getText');
					if(str.length>0)
					count.push(str);
					count.push('\''+row.t_id+'\'');
					$('#txtb_budi_count<?=$time?>').tagbox('setValues',count);
				}
			},
			onLoadSuccess: function(){
				$(this).datagrid('enableDnd');
			}
		});  

		if( arr_view<?=$time?>.indexOf('content[budm_tax_type]')>-1 )
		{
			$('#table_tax_type<?=$time?>').edatagrid('disableEditing');
			$('#table_tax_type_tool<?=$time?> .oa_op').hide();
		}
	}

	//列格式化输出
	function fun_tax_type_index_formatter<?=$time?>(value,row,index){

		var value_s = value;
		switch(this.field)
		{
			case 'tax_rate':
				value_s+='%';
				break;
			case 'tax_no_new':
				if(value == 1)
				value_s='不可新建';
				break;
		}

		if( ! value_s ) value_s = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ;
		return '<span id="table_tax_type<?=$time?>_'+index+'_'+this.field+'" class="table_tax_type<?=$time?>" >'+value_s+'</span>';
	}


	//操作税种
	function fun_table_tax_type_operate<?=$time?>(btn)
	{
		switch(btn)
		{
			case 'add':

				var op_id = get_guid();
				$('#table_tax_type<?=$time?>').edatagrid('addRow',{
					row:{
						tax_id: op_id
					}
				});
				
				break;
			case 'del':

				var op_list=$('#table_tax_type<?=$time?>').datagrid('getChecked');

				var row_s = $('#table_tax_type<?=$time?>').datagrid('getSelected');
				var index_s = $('#table_tax_type<?=$time?>').datagrid('getRowIndex',row_s);

				if($('#table_tax_type<?=$time?>').datagrid('validateRow',index_s))
				{
					$('#table_tax_type<?=$time?>').datagrid('endEdit',index_s);
				}
				else
				{
					$('#table_tax_type<?=$time?>').datagrid('cancelEdit',index_s);
				}
				
				for(var i=op_list.length-1;i>-1;i--)
				{
					if(op_list[i].flag_no_del) continue;
					var index = $('#table_tax_type<?=$time?>').datagrid('getRowIndex',op_list[i]);
					$('#table_tax_type<?=$time?>').datagrid('deleteRow',index);
				}

				break;
		}
	}

	//载入预算表
	function load_table_budi<?=$time?>()
	{
		$('#table_budi<?=$time?>').datagrid({    
			width:'100%',
			height:'auto',
			toolbar:'#table_budi_tool<?=$time?>',
			singleSelect:true,
			selectOnCheck:false,
			checkOnSelect:false,
//			striped:true,
			idField:'budi_id',
			remoteSort: false,
//			autoSave:true,
			view: groupview, 
			groupField:'budi_ou_show',
			groupFormatter: function(value,rows)
			{
				return value;
			},
//			groupStyler: function(value,rows)
//			{
//				return 'width:100%;text-align:center';
//			},
			fun_ready:'fun_merge_sub_ou_show<?=$time?>()',
			frozenColumns:[[ 
			{field:'budi_id',title:'',width:50,align:'center',checkbox:true,
			    formatter: fun_budi_index_formatter<?=$time?>
				},
//			   {field:'budi_ou_show',title:'部门',width:100,halign:'center',align:'left',
//			    formatter: fun_budi_index_formatter<?=$time?>
//			   },
			   {field:'budi_sn',title:'行次',width:50,halign:'center',align:'left',
			    sorter: function(a,b){
				    if(a.split('.')[1] == 0)
			   		a=a.split('.')[0]+'.99' ;
			   	
				    if(b.split('.')[1] == 0)
			   		b=b.split('.')[0]+'.99' ;
			   	
			   		a = parseFloat(a);
					b = parseFloat(b);
					return (a>b?1:-1);  
				 },
			    formatter: fun_budi_index_formatter<?=$time?>
			   },
			   {field:'budi_name',title:'核算内容',width:200,halign:'center',align:'left',
				 editor:{
					   type:'combobox',
					   options:{
				   	   //required:true,
				   	   panelHeight:'auto',
				   	   limitToList:true,
				   	   panelMaxHeight:120,
				   	   buttonIcon:'icon-clear',
	         	   	   onClickButton:function()
		         	   {
		         	   		$(this).combobox('clear');
		         	   }
					}
				 },
			     formatter: fun_budi_index_formatter<?=$time?>
			   },
			   {field:'budi_rate',title:'税率',width:100,halign:'center',align:'right',
			    formatter: fun_budi_index_formatter<?=$time?>
			   },
			]],
			columns:[[    
			    {field:'budi_sum',title:'金额(含税)',width:150,halign:'center',align:'right',
		    	 editor:{
				   type:'numberbox',
				   options:{
			    	   precision:2,
					   min:0,
					   buttonIcon:'icon-clear',
	         	   	   onClickButton:function()
		         	   {
		         	   		$(this).numberbox('clear');
		         	   }
					}
				 },
	             formatter: fun_budi_index_formatter<?=$time?>
			    },
			    {field:'budi_sum_notax',title:'金额(不含税)',width:150,halign:'center',align:'right',
	             formatter: fun_budi_index_formatter<?=$time?>
			    },
			]],
			rowStyler: function(index,row){
				if (row.act == <?=STAT_ACT_CREATE?>)
					return 'background:#ffd2d2'; 
				if (row.act == <?=STAT_ACT_REMOVE?>)
					return 'background:#e0e0e0'; 
				if (row.budi_css){
					return row.budi_css;
				}
			},
			onBeginEdit: function(index,row)
			{
				var ed_list=$(this).datagrid('getEditors',index);

				for(var i = 0;i < ed_list.length; i++)
				{
					switch(ed_list[i].field)
					{
						case 'budi_name':

							if( index == 0 )
							{
								$(ed_list[i].target).combobox({
								   valueField: 'text',    
						           textField: 'text',
						           data:[<?=element('budm_type_subc',$json_field_define)?>],
						           value : row.budi_name
								});

								$(ed_list[i].target).combobox('textbox').bind('focus',
								function(){
									$(this).parent().prev().combobox('showPanel');
								});
								
							}
							else if( index == 2 )
							{
								var data = $('#table_tax_type<?=$time?>').datagrid('getRows');
								$(ed_list[i].target).combobox({
								   valueField: 't_id',    
						           textField: 'tax_name',
						           data: data,
						           value : row.budi_name
								});

								$(ed_list[i].target).combobox('textbox').bind('focus',
								function(){
									$(this).parent().prev().combobox('showPanel');
								});
							}
							else
							{
								$(ed_list[i].target).before(row.budi_name)
								$(ed_list[i].target).next().hide();
							}
							
							break;
							
						case 'budi_sum':

							if( ! row.budi_sum) 
							{
								row.budi_sum=0;
							}

							if(row.budi_sum_edit == 0)
								$(ed_list[i].target).numberbox({
									readonly:true,
									icons:[{
									   iconCls:'icon-lock',
								   }]
								})
							else if(row.budi_sum == 0)
								$(ed_list[i].target).numberbox('clear')

							$(ed_list[i].target).numberbox('textbox').css('text-align','right');
							
							break;
							
					}
				}
			},
			onEndEdit: function(index, row, changes)
			{
				if( index == 0 )
				{
					if( row.budi_name == '无')
						row.budi_sum = 0;
				}
				else if( index == 2 )
				{
					$('#table_tax_type<?=$time?>').datagrid('selectRecord',row.budi_name);
					
					var row_tax_type = $('#table_tax_type<?=$time?>').datagrid('getSelected');
					if(row_tax_type)
					row.budi_rate = row_tax_type.tax_rate;

					var ed_budi_name=$(this).datagrid('getEditor',{index:index,field:'budi_name'});

					if(ed_budi_name)
					{
						row.budi_name_s = $(ed_budi_name.target).combobox('getText');
					}
				}
				
				var count = $('#txtb_budm_count<?=$time?>').val();
				count = JSON.parse(count);

				if( row.budi_sum_notax_empty != 1 
				 && ! count['budi_sum_notax;'+row.budi_id])	
					row.budi_sum_notax = row.budi_sum
			},
			onAfterEdit: function(index, row, changes)
			{
				if($('#txtb_budi_count<?=$time?>').attr('disabled') == 'disabled')
				{
					var rows = $('#table_budi<?=$time?>').datagrid('getRows');
					fun_count_budi_cell<?=$time?>('budi_sum;'+rows[1].budi_id);
					
					JSON.parse(JSON.stringify(changes), function (key, value) {  
						fun_count_budi_cell<?=$time?>(key+';'+row.budi_id);
					});
				}
			},
			onBeforeCellEdit: function(index, field)
			{
				fun_merge_sub_ou_show<?=$time?>();

				switch(field)
				{
					case 'budi_name':
						
						if(index != 0 && index != 2)
						{
							return false;
						}
						
						break;
					case 'budi_sum':
						
						break;
					default:
						return false;
				}
				
			},
			onClickCell: function(index, field, value)
			{
				var check_count = true;
				var rows = $(this).datagrid('getRows');
				
				if($('#txtb_budi_count<?=$time?>').attr('disabled') == 'disabled')
				{
					$('#txtb_budi_count<?=$time?>').tagbox('clear');
					var opt = $(this).datagrid('getColumnOption',field);
					var budi_name = rows[index].budi_name;
					if( index == 1 ) budi_name = '标的';
					if( index == 2 ) budi_name = '流转税';
					$('#td_budi_field<?=$time?>').html(budi_name+'-'+opt.title);
					check_count = false;
				}

				if(check_count)
				{
					switch(field)
					{
						case 'budi_name':
							if(index != 2)
								return;
						case 'budi_sum':
						case 'budi_sum_notax':
						case 'budi_rate':
							var count = $('#txtb_budi_count<?=$time?>').tagbox('getValues');
							var str = $('#txtb_budi_count<?=$time?>').tagbox('getText');
							if(str.length>0)
							count.push(str);
							count.push(field+';'+rows[index].budi_id);
							$('#txtb_budi_count<?=$time?>').tagbox('setValues',count);
					}
					
					return ;
				}
				else
				{
					switch(field)
					{
						case 'budi_sum':
						case 'budi_sum_notax':
	
							var json = $('#txtb_budm_count<?=$time?>').val();
							if( ! json ) json = '{}';
							json = JSON.parse(json);
	
							if(json[field+';'+rows[index].budi_id])
							{
								var count = json[field+';'+rows[index].budi_id]
								$('#txtb_budi_count<?=$time?>').tagbox('setValues',count);
							}

							$('#txtb_budi_count<?=$time?>').attr('field',field);
							$('#txtb_budi_count<?=$time?>').attr('budi_id',rows[index].budi_id);
					}
				}
			},
			onLoadSuccess: function(data)
			{
				if(data.rows.length > 0)
					fun_load_budi_count_data<?=$time?>()
			}
		});  

		if( arr_view<?=$time?>.indexOf('content[budi]')>-1 )
		{
			$('#table_budi_tool<?=$time?> .oa_op').hide();
			$('#table_budi<?=$time?>').datagrid('disableCellEditing');
		}
		else
		{
			$('#table_budi<?=$time?>').datagrid('enableCellEditing');
		}

		$('#table_budi<?=$time?>').datagrid('sort', {	  
			sortName: 'budi_sn',
			sortOrder: 'asc'
		});

		fun_merge_sub_ou_show<?=$time?>();
	}

	//计算公式下拉框选项
	function fun_load_budi_count_data<?=$time?>()
	{
		var data = [];
		var rows = $('#table_tax_type<?=$time?>').datagrid('getRows');
		
		for( var i=0;i<rows.length;i++)
		{
			var json={}
			json.id = '\''+rows[i].t_id+'\'';
			json.text = rows[i].tax_name;
			data.push(json)
		}
		
		var rows = $('#table_budi<?=$time?>').datagrid('getRows');

		for( var i=0;i<rows.length;i++)
		{
			var budi_name = rows[i].budi_name
			if(i == 1 ) budi_name = '标的';
			if(i == 2 ) 
			{
				budi_name = '流转税';

				var json={}
				json.id = 'budi_name;'+rows[i].budi_id;
				json.text = '流转税-税种';
				data.push(json)
			}
			
			var json={}
			json.id = 'budi_rate;'+rows[i].budi_id;
			json.text = budi_name+'-税率';
			data.push(json)

			var json={}
			json.id = 'budi_sum;'+rows[i].budi_id;
			json.text = budi_name+'-预算额(含税)';
			data.push(json)

			var json={}
			json.id = 'budi_sum_notax;'+rows[i].budi_id;
			json.text = budi_name+'-预算额(不含税)';
			data.push(json)
		}

		$('#txtb_budi_count<?=$time?>').tagbox('loadData',data);
		$('#txtb_budi_count_other<?=$time?>').tagbox('loadData',data);
	}
	
	//编辑预算表单元格计算公式/css
	function fun_edit_budi_cell<?=$time?>(type)
	{
		var check = false;

		var field = $('#txtb_budi_'+type+'<?=$time?>').attr('field');
		if(field)
		{
			switch(field)
			{
				case 'budi_sum':
				case 'budi_sum_notax':
					var rows = $('#table_budi<?=$time?>').datagrid('getRows');
					$('#txtb_budi_'+type+'<?=$time?>').tagbox('enable');
					check = true;
			}
		}

		if( ! check) return;

		if( type == 'count' )
		{
			fun_layer_budi_count<?=$time?>();
			fun_load_budi_count_data<?=$time?>();
		}

		$('#table_budi<?=$time?>').datagrid('disableCellEditing');

	}

	//计算公式元素弹出框
	var index_layer_budi_count<?=$time?>='';
	function fun_layer_budi_count<?=$time?>(){

		if($('#txtb_budi_count<?=$time?>').attr('disabled') == 'disabled') return;
	     $('#txtb_budi_count<?=$time?>').next().find('.tagbox-label').bind('mouseover',function(){
			     var index = $(this).attr('tagbox-index');
			     index_layer_budi_count<?=$time?> = layer.tips('<a href="javascript:void(0);" class="sui-btn btn-bordered" onClick="fun_budi_count_insert<?=$time?>(\''+index+'\')" >插入</a>'
			    	     ,this
			    	     ,{tips: [1, '#fff']})
		  });
	}

	//计算公式元素插入
	function fun_budi_count_insert<?=$time?>(index)
	{
		 var value_count = [];
		 var value_count_other = [];
 		 var values = $('#txtb_budi_count<?=$time?>').tagbox('getValues');

	     var check = false;
	     for(var i=0;i < values.length ;i++)
	     {
		    if( ! check)
	    		value_count.push(values[i]);
		    else
		    	value_count_other.push(values[i]);
	    	
	     	if(i == index)
	     		check=true;
	     }

	     $('#txtb_budi_count<?=$time?>').tagbox('setValues',value_count);
		 $('#tr_budi_count_other<?=$time?>').show();
		 $('#txtb_budi_count_other<?=$time?>').tagbox('setValues',value_count_other);

		 layer.close(index_layer_budi_count<?=$time?>);
		
	}

	//保存预算表单元格计算公式/css
	function fun_save_budi_cell<?=$time?>(type)
	{
		var json = $('#txtb_budm_'+type+'<?=$time?>').val();
		if( ! json ) json = '{}';
		json = JSON.parse(json);

		var field = $('#txtb_budi_'+type+'<?=$time?>').attr('field');
		var budi_id = $('#txtb_budi_'+type+'<?=$time?>').attr('budi_id');
		switch(type)
		{
			case 'count':
				layer.close(index_layer_budi_count<?=$time?>);
				json[field+';'+budi_id]=$('#txtb_budi_'+type+'<?=$time?>').tagbox('getValues').join(',');
				var count_other=$('#txtb_budi_'+type+'_other<?=$time?>').tagbox('getValues');
				
				if(count_other.length > 0)
				{
					json[field+';'+budi_id]+=','+count_other.join(',');
					$('#txtb_budi_'+type+'<?=$time?>').tagbox('setValues',json[field+';'+budi_id].split(','));
				}

				$('#txtb_budi_'+type+'_other<?=$time?>').tagbox('clear');
				$('#tr_budi_count_other<?=$time?>').hide();

				break;
			case 'css':

				break;
		}

		var field = $('#txtb_budi_'+type+'<?=$time?>').attr('field','');
		var field = $('#txtb_budi_'+type+'<?=$time?>').attr('budi_id','');

		$('#txtb_budi_'+type+'<?=$time?>').tagbox('disable');
		
		$('#txtb_budm_'+type+'<?=$time?>').val(JSON.stringify(json));

		$('#table_budi<?=$time?>').datagrid('enableCellEditing');
	}

	//计算预算表单元格
	var arr_field_count=[];
	function fun_count_budi_cell<?=$time?>(field)
	{
		var count = $('#txtb_budm_count<?=$time?>').val();

		if( ! count ) return;

		//计算公式排序
		var arr_tmp = [];

		var rows = $('#table_budi<?=$time?>').datagrid('getRows');
		
		JSON.parse(count,function(key,value){
			var index = $('#table_budi<?=$time?>').datagrid('getRowIndex',key.split(';')[1])

			if( index > -1 )
			{
				if( key.indexOf('budi_sum_notax')>-1 )
					index += rows.length ;
				
				arr_tmp[index]={};
				arr_tmp[index].field = key;
				arr_tmp[index].count = value;
				arr_tmp[index].index = index;
			}
		})
		
		var i;
		var json = {};
		
		for (i in arr_tmp)
		{
			var key = arr_tmp[i].field;
			var value = arr_tmp[i].count;

			if( ! value) continue;
			
			var arr = value.split(',');
			if(arr.indexOf(field) > -1)
			{
				if(arr_field_count.indexOf(key) < 0)
				arr_field_count.push(key);

				var rtn = 0;
				var str_count ='';
				var rows = $('#table_budi<?=$time?>').datagrid('getRows');
				
				for(var i = 0;i<arr.length;i++)
				{
					if(arr[i] == ';')
						str_count += ';';	
					else if(arr[i].split(';').length == 2)
					{
						var index = $('#table_budi<?=$time?>').datagrid('getRowIndex',arr[i].split(';')[1]);

						if(index < 0)
						{
							str_count += 'parseFloat(0)';
							continue;
						}
						
						switch(arr[i].split(';')[0])
						{
							case 'budi_name':
								str_count += '\''+rows[index].budi_name+'\'';
								break;
							case 'budi_rate':
								str_count += rows[index].budi_rate/100;
								break;
							case 'budi_sum':
								if(rows[index].budi_sum)
								str_count += 'parseFloat('+rows[index].budi_sum+')';
								else
								str_count += 'parseFloat(0)';
								break;
							case 'budi_sum_notax':
								if(rows[index].budi_sum_notax)
								str_count += 'parseFloat('+rows[index].budi_sum_notax+')';
								else
								str_count += 'parseFloat(0)';
								break;
						}
					}
					else if( arr[i] == '=' )
						str_count += 'rtn = ';	
					else
						str_count += arr[i];
				}

				eval(str_count);
				
				var row_rtn = {};
				var index = $('#table_budi<?=$time?>').datagrid('getRowIndex',key.split(';')[1]);
				
				row_rtn[key.split(';')[0]] = parseFloat(rtn).toFixed(2);
				
				$('#table_budi<?=$time?>').datagrid('updateRow',{
					index: index,
					row: row_rtn
				});

			}
		}

		var i = arr_field_count.indexOf(field);
		if(i > -1) arr_field_count.baoremove(i);

		if(arr_field_count.length>0)
			fun_count_budi_cell<?=$time?>(arr_field_count[0]);
		
	}

	//部门同值合并
	function fun_merge_sub_ou_show<?=$time?>()
	{
		return;
		var rows=$('#table_budi<?=$time?>').datagrid('getRows');
		
		var check='';
		var index_check=0;
		
		for(var i=0;i<rows.length;i++)
		{
			if(check != rows[i].budi_ou_show)
			{
				if(i>0)
				{
					$('#table_budi<?=$time?>').datagrid('mergeCells',{
	                    index: index_check,
	                    field: 'budi_ou_show',
	                    rowspan: i-index_check
	                });
				}
				
				index_check=i;
				check=rows[i].budi_ou_show;

			}
		}

		$('#table_budi<?=$time?>').datagrid('mergeCells',{
            index: index_check,
            field: 'budi_ou_show',
            rowspan: i-index_check
        });

	}

	//列格式化输出
	function fun_budi_index_formatter<?=$time?>(value,row,index){

		switch(this.field)
		{
			case 'budi_ou_show':

				value='<span style="font-weight:bold">'+value+'</span>'
				break;
			case 'budi_sn':

				if(value.split('.')[1] == 0)
				value = value.split('.')[0];
				
				break;
			case 'budi_name':
				
				var url='proc_bud/budi/edit/act/2/fun_no_db/fun_no_db_table_budi<?=$time?>';

				if(row.budi_name_s) value = row.budi_name_s;
				
				if( index == 0 )
				{
					switch(row.budi_name)
					{
						case '收取管理费':
							value +='<br>分包合同总额'
							break;
						case '支付管理费':
							value +='<br>总包合同总额'
							break;

					}
				}
				else if(index > 2)
				value='<a href="javascript:void(0);" class="link" onClick="fun_table_budi_win_open<?=$time?>(\''+row.budi_name.substring(0,10)+'\',\'win\',\''+url+'\',\''+row.budi_id+'\');">'+value+'</a>';

				break;
			case 'budi_rate':
				
				value +='%';
				
				break;
			case 'budi_sum_notax':

				if( value ) 
					value = num_parse(value);
				else
					value = '';

				if( index == 0 )
				{
					switch(row.budi_name)
					{
						case '收取管理费':
							value +='<br>'+value
							break;
						case '支付管理费':
							value +='<br>'+value
							break;
					}
				}
				
				break;
			case 'budi_sum':

				if( ! value ) value = 0;
				value = num_parse(value);

				if( index == 0 )
				{
					switch(row.budi_name)
					{
						case '收取管理费':
							value +='<br><span id="sp_sum_sq<?=$time?>">'+value+'</span><span id="sp_sum_gl<?=$time?>" style="display:none">'+row.budi_sum+'</span>'
							break;
						case '支付管理费':
							value +='<br><span id="sp_sum_zf<?=$time?>">'+value+'</span><span id="sp_sum_gl<?=$time?>" style="display:none">'+row.budi_sum+'</span>'
							break;
					}
				}
				else if( index == 1 )
				{
					if($('#sp_sum_sq<?=$time?>').length > 0)
					{
						var sum_sq = parseFloat(row.budi_sum) - parseFloat($('#sp_sum_gl<?=$time?>').text());
						$('#sp_sum_sq<?=$time?>').text(num_parse(sum_sq));
					}
					else if($('#sp_sum_zf<?=$time?>').length > 0)
					{
						var sum_zf = parseFloat(row.budi_sum) + parseFloat($('#sp_sum_gl<?=$time?>').text());
						$('#sp_sum_zf<?=$time?>').text(num_parse(sum_zf));
					}
				}
				
				break;
		}

//		if(row.budi_css && value)
//			value='<span style="'+row.budi_css+'">'+value+'</span>';

		if( ! value ) value = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ;
		return '<span id="table_budi<?=$time?>_'+index+'_'+this.field+'" class="table_budi<?=$time?>" >'+value+'</span>';

	}

	//界面
	function fun_table_budi_win_open<?=$time?>(title,fun,url,id)
	{
		switch(fun)
		{
			case 'win':

				var row ={};
				if(id)
				{
					var index = $('#table_budi<?=$time?>').datagrid('getRowIndex',id);
					var rows = $('#table_budi<?=$time?>').datagrid('getRows');
					row = rows[index];
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
					queryParams:{
						'data_db' : base64_encode(JSON.stringify(row))
					},
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

	//操作预算表明细
	function fun_table_budi_operate<?=$time?>(btn)
	{
		switch(btn)
		{
			case 'add':

				$('#table_budi<?=$time?>').datagrid('clearSelections');

				var rows = $('#table_budi<?=$time?>').datagrid('getRows');

				var row = rows[rows.length-1];

				if( row.budi_sn.split('.')[1] != 0 )
				var budi_sn = row.budi_sn.split('.')[0]+'.'+(parseInt(row.budi_sn.split('.')[1])+1)
				else
				var budi_sn = parseInt( row.budi_sn.split('.')[0])+1;

				var url = 'proc_bud/budi/edit/fun_no_db/fun_no_db_table_budi<?=$time?>/act/1/budi_sn/'+budi_sn+'/budi_ou_show/'+base64_encode(row.budi_ou_show);

				fun_table_budi_win_open<?=$time?>('创建预算表明细','win',url)
				
				break;
			case 'edit':
				var op_list=$('#table_budi<?=$time?>').datagrid('getChecked');

				if(op_list.length == 0 )
				{
					$.messager.show({
				    	title:'通知',
				    	msg:'请选择要批量操作的行！',
				    	timeout:500,
				    	showType:'show',
				    	border:'thin',
			            style:{
			                right:'',
			                bottom:'',
			            }
				    });
					 return;
				}

				var win_id=fun_get_new_win();
				
				var url='proc_bud/budi/edit/act/2/flag_edit_more/1/fun_no_db/fun_edit_budi_more<?=$time?>';

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

				$('#'+win_id).window('refresh',url+'/fun_open/win/fun_open_id/'+win_id);
				
				break;
			case 'del':

				var op_list=$('#table_budi<?=$time?>').datagrid('getChecked');

				var row_s = $('#table_budi<?=$time?>').datagrid('getSelected');
				var index_s = $('#table_budi<?=$time?>').datagrid('getRowIndex',row_s);

				if($('#table_budi<?=$time?>').datagrid('validateRow',index_s))
				{
					$('#table_budi<?=$time?>').datagrid('endEdit',index_s);
				}
				else
				{
					$('#table_budi<?=$time?>').datagrid('cancelEdit',index_s);
				}
				
				for(var i=op_list.length-1;i>-1;i--)
				{
					var index = $('#table_budi<?=$time?>').datagrid('getRowIndex',op_list[i]);

					if(index > 2)
					$('#table_budi<?=$time?>').datagrid('deleteRow',index);
				}

				break;
		}
	}

	function fun_edit_budi_more<?=$time?>(f_id,btn)
	{
		var form_data = fun_get_data_from_f(f_id,1);

		$('#'+f_id).closest('.op_window').window('close');
		
		var row = {};
		JSON.parse(JSON.stringify(form_data),function(key,value){
			if(form_data[key+'_check'] == 1 && key != 'budi_sub')
			{
				if(key == 'budi_css')
					value = form_data['budi_css'].join(';');

				row[key]=value;
			}
		});

		var op_list=$('#table_budi<?=$time?>').datagrid('getChecked');

		var budi_sn='';
		if(row.budi_sn) budi_sn = row.budi_sn;
		
		for(var i=0;i<op_list.length;i++)
		{
			var index = $('#table_budi<?=$time?>').datagrid('getRowIndex',op_list[i]);

			if(budi_sn && budi_sn.split('.')[1] == 0 )
			{
				row.budi_sn = budi_sn.split('.')[0]+'.'+op_list[i].budi_sn.split('.')[1];
				
				if( op_list[i].budi_sn.split('.')[1] == 0)
				budi_sn = parseInt(budi_sn.split('.')[0])+1+'.0';
			}
			else if( budi_sn && budi_sn.split('.')[1] != 0  )
			{
				
				if( op_list[i].budi_sn.split('.')[1] != 0 )
				{
					row.budi_sn = budi_sn;
					budi_sn = budi_sn.split('.')[0]+'.'+(parseInt(budi_sn.split('.')[1])+1);
				}
				else
				{
					budi_sn = budi_sn.split('.')[0]+'.0';
					row.budi_sn = budi_sn;
				}
			}
			
			$('#table_budi<?=$time?>').datagrid('updateRow',{
					index: index,
					row : row
				});
		}
		
		$('#table_budi<?=$time?>').datagrid('sort', {	  
			sortName: 'budi_sn',
			sortOrder: 'asc'
		});

		var data = $('#table_budi<?=$time?>').datagrid('getData');
		$('#table_budi<?=$time?>').datagrid('loadData',data);
		
		fun_merge_sub_ou_show<?=$time?>();
	}

	function fun_no_db_table_budi<?=$time?>(f_id,btn)
	{
		var row = fun_get_data_from_f(f_id,'1');

		row.budi_css = row.budi_css.join(';');
		
		$('#'+f_id).closest('.op_window').window('close');

		if( row.budi_id )
		{
			var index_s = $('#table_budi<?=$time?>').datagrid('getRowIndex',row.budi_id);

			if(btn == 'del')
			{
				$('#table_budi<?=$time?>').datagrid('deleteRow',index_s);
				return;
			}
			
			$('#table_budi<?=$time?>').datagrid('updateRow',{
				index: index_s,
				row: row
			});
		}
		else
		{
			row.budi_id = get_guid();
			$('#table_budi<?=$time?>').datagrid('appendRow',row);
		}

		$('#table_budi<?=$time?>').datagrid('sort', {	  
			sortName: 'budi_sn',
			sortOrder: 'asc'
		});

		var data = $('#table_budi<?=$time?>').datagrid('getData');
		$('#table_budi<?=$time?>').datagrid('loadData',data);
		
		fun_merge_sub_ou_show<?=$time?>();
	}
</script>