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

		//开票回款计划
		load_table_gfc_bp<?=$time?>();

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
					param['content[gfc_area]'] = data_form['content[gfc_area]']
					+','+data_form['content[gfc_area_1]']+','+data_form['content[gfc_area_2]'];
					param['content[gfc_area_show]'] = $('#txtb_gfc_area<?=$time?>').combobox('getText')
					+','+$('#txtb_gfc_area_1<?=$time?>').combobox('getText')
					+','+$('#txtb_gfc_area_2<?=$time?>').combobox('getText');
				}
				else
				{
					$(this).form('enableValidation').form('validate');

					return false;
				}

			},
			success: function(data){
				
				$('#win_loading<?=$time?>').window('close');
alert(data);
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
							url+='/act/<?=STAT_ACT_EDIT?>/gfc_id/'+json.id

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

	//界面
	function fun_index_win_open<?=$time?>(title,fun,url)
	{
		switch(fun)
		{
			case 'win':

				var win_id=fun_get_new_win();

				$('#'+win_id).window({
					title: title,
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
						fun_index_win_open<?=$time?>(title,'winopen',url)
					},
					onClose: function()
					{
						
						$('#'+win_id).window('destroy');
						$('#'+win_id).remove();
					}
				})

				$('#'+win_id).window('refresh',url+'/fun_open/win/fun_open_id/'+win_id);
				$('#'+win_id).window('open');
				break;
			case 'winopen':

				window.open(url+'/fun_open/winopen');

				break;
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

		$('#txtb_gfc_org_jia_s<?=$time?>').textbox('textbox').autocomplete({
			serviceUrl: 'base/auto/get_json_org/search_o_status/1',
			params:{
				rows:10,
			},
			onSelect: function (suggestion) {
				$('#txtb_gfc_org_jia_s<?=$time?>').textbox('setValue',base64_decode(suggestion.data.o_id_standard_s));
				$('#txtb_gfc_org_jia<?=$time?>').val(base64_decode(suggestion.data.o_id_standard))
			}
		});
	}

	//项目负责人自动补全
	function load_gfc_c<?=$time?>()
	{
		var opt = $('#txtb_gfc_c_s<?=$time?>').textbox('options');

		if(  opt.readonly ) return;

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
				$('#txtb_gfc_ou_s<?=$time?>').textbox('setValue',base64_decode(suggestion.data.ou_name));
				$('#txtb_gfc_ou<?=$time?>').val(base64_decode(suggestion.data.ou_id));
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

	//未分解金额
	function load_gfc_bp_sum_remain<?=$time?>()
	{
		$('#txtb_gfc_bp_sum_remain<?=$time?>').numberbox('textbox').css('text-align','right');
	}

	//开票回款计划--载入
    function load_table_gfc_bp<?=$time?>()
    {
        $('#table_gfc_bp<?=$time?>').edatagrid({
            width:'100%',
            height:'200',
            toolbar:'#table_gfc_bp_tool<?=$time?>',
            singleSelect:true,
            selectOnCheck:false,
            checkOnSelect:false,
            striped:true,
            nowrap:false,
            remoteSort: false,
            idField:'bp_id',
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
				{field:'bp_id',title:'',width:50,align:'center',checkbox:true},
				{field:'bp_time',title:'预计开票时间',width:125,halign:'center',align:'center',sortable:true,
				    formatter: fun_table_gfc_bp_formatter<?=$time?>,
				    editor:{
						type:'datebox',
						options:{
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
				{field:'bp_time_back',title:'预计回款时间',width:125,halign:'center',align:'center',
				    formatter: fun_table_gfc_bp_formatter<?=$time?>,
				    editor:{
						type:'datebox',
						options:{
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
				{field:'bp_type',title:'货款性质',width:120,halign:'center',align:'center',
				    formatter: fun_table_gfc_bp_formatter<?=$time?>,
				    editor:{
						type:'combobox',
						options:{
				    		data: [<?=element('bp_type',$json_field_define)?>],
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
				{field:'bp_sum',title:'金额',width:200,halign:'center',align:'right',
				    formatter: fun_table_gfc_bp_formatter<?=$time?>,
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
				         	},
							icons:[{
								   iconCls:'icon-per',
									handler: function(e){
										var sum=$(e.data.target).numberbox('getValue');
										if( sum > 0 && sum <= 100 )
											sum = parseFloat($('#txtb_gfc_sum<?=$time?>').numberbox('getValue') * sum / 100).toFixed(2);
											
										$(e.data.target).numberbox('setValue',sum);
									}
							   }]
						}
					} 
				},
				{field:'bp_note',title:'备注',width:200,halign:'center',align:'center',
				    formatter: fun_table_gfc_bp_formatter<?=$time?>,
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
    					case 'bp_time':
    					case 'bp_time_back':

    						var bill_check = $('#txtb_gfc_category_bill<?=$time?>').combobox('getValue');
    						if( bill_check == '<?=BASE_Y?>' && ed_list[i].field == 'bp_time')
    						{
    							$(ed_list[i].target).datebox({
									required:true,
									value: row[ed_list[i].field]
        						})
    						}
    						else if( bill_check == '<?=BASE_N?>' && ed_list[i].field == 'bp_time_back')
    						{
    							$(ed_list[i].target).datebox({
									required:true,
									value: row[ed_list[i].field]
        						})
    						}
        					
    						$(ed_list[i].target).datebox('textbox').bind('focus',
    								function(){
    							$(this).parent().prev().datebox('showPanel');
    						});
        					break;
    					case 'bp_type':
    						$(ed_list[i].target).combobox('textbox').bind('focus',
    								function(){
    							$(this).parent().prev().combobox('showPanel');
    						});
        					break;
    					case 'bp_sum':
        					var max = $('#txtb_gfc_bp_sum_remain<?=$time?>').numberbox('getValue');

        					max = parseFloat(max);
        					if( row.bp_sum )
        					max+=parseFloat(row.bp_sum)
        					
        					if( max == 0 )
        					{
        						$('#table_gfc_bp<?=$time?>').datagrid('cancelEdit',index);
        					}

        					var min = parseFloat(row.bp_sum_kp);
        					if(min < parseFloat(row.bp_sum_hk)) min = parseFloat(row.bp_sum_hk);

        					$(ed_list[i].target).numberbox({
								max: parseFloat(max),
								min: min
            				});
        					
        					if( ! row.bp_sum )
        						$(ed_list[i].target).numberbox('setValue',max);
            					
    						$(ed_list[i].target).numberbox('textbox').css('text-align','right');
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
	    				case 'bp_type':
	    					row.bp_type_s = $(ed_list[i].target).combobox('getText');
	        				break;
    				}
    			}

    			if( ! row.bp_time_back ) row.bp_time_back = getNewDay(row.bp_time,15);

    			load_gfc_bp_prog<?=$time?>();

    			$('#l_<?=$time?> .prog_gfc_bp_plan<?=$time?>').progressbar();
    			$('#l_<?=$time?> .prog_gfc_bp_plan<?=$time?>').find('.progressbar-text').css('text-align','right');
            },
            onLoadSuccess: function(data)
    		{
            	$('#l_<?=$time?> .prog_gfc_bp_plan<?=$time?>').progressbar();
    			$('#l_<?=$time?> .prog_gfc_bp_plan<?=$time?>').find('.progressbar-text').css('text-align','right');
    		},
            onResizeColumn: function(field, width)
    		{
    			$('#l_<?=$time?> .prog_gfc_bp_plan<?=$time?>').progressbar();
    			$('#l_<?=$time?> .prog_gfc_bp_plan<?=$time?>').find('.progressbar-text').css('text-align','right');
    		}
        });

        if( arr_view<?=$time?>.indexOf('content[gfc_bp]')>-1 )
        {
        	$('#table_gfc_bp<?=$time?>').edatagrid('disableEditing');
            $('#table_gfc_bp_tool<?=$time?> .oa_op').hide();
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
    function fun_table_gfc_bp_formatter<?=$time?>(value,row,index){

        switch(this.field)
        {
        	case 'bp_sum':
            	
        		var bp_sum = parseFloat(row.bp_sum);
        		if( ! row.bp_sum_kp ) row.bp_sum_kp = 0;
        		var bp_sum_kp = parseFloat(row.bp_sum_kp);
        		if( ! row.bp_sum_hk ) row.bp_sum_hk = 0;
        		var bp_sum_hk = parseFloat(row.bp_sum_hk);

        		var per_kp = parseFloat(bp_sum_kp/bp_sum*100).toFixed(2);
        		var per_hk = parseFloat(bp_sum_hk/bp_sum*100).toFixed(2);
        		
        		value = '<div style="height:20px;width:100%">'+num_parse(bp_sum)+'</div>' ;
        		
				var url = 'proc_bill/bill/index/ppo/0/gfc_finance_code/<?=$code?>';
        		value += '<div class="easyui-progressbar prog_gfc_bp_plan<?=$time?>" data-options="value:'+per_kp+',text:\'<a href=\\\'javascript:void(0);\\\' class = \\\'m_link\\\'>开票:'+num_parse(bp_sum_kp)+'</a>\'" style="width:100%;" onClick="fun_index_win_open<?=$time?>(\'开票-<?=$code?>\',\'win\',\''+url+'\');"></div> '
        		var url = 'proc_bs/bs_item/index/ppo/0/gfc_finance_code/<?=$code?>';
        		value += '<div class="easyui-progressbar prog_gfc_bp_plan<?=$time?>" data-options="value:'+per_hk+',text:\'<a href=\\\'javascript:void(0);\\\' class = \\\'m_link\\\'>回款:'+num_parse(bp_sum_hk)+'</a>\'" style="width:100%;" onClick="fun_index_win_open<?=$time?>(\'回款-<?=$code?>\',\'win\',\''+url+'\');"></div> '

            	break;
            	
            default:
                if(row[this.field+'_s'])
                    value = row[this.field+'_s'];
        }

        if( ! value ) value = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ;
        return '<span id="table_gfc_bp<?=$time?>_'+index+'_'+this.field+'" class="table_gfc_bp<?=$time?>" >'+value+'</span>';
    }

    //开票回款计划--操作
    function fun_table_gfc_bp_operate<?=$time?>(btn)
    {
        switch(btn)
        {
            case 'add':

            	var row_s = $('#table_gfc_bp<?=$time?>').datagrid('getSelected');
            	var index_s = $('#table_gfc_bp<?=$time?>').datagrid('getRowIndex',row_s);
            	if( index_s > -1)
            	{
            		if($('#table_gfc_bp<?=$time?>').datagrid('validateRow',index_s))
    					$('#table_gfc_bp<?=$time?>').datagrid('endEdit',index_s)
    				else
    					return;//$('#table_gfc_bp<?=$time?>').datagrid('cancelEdit',index_s)
            	}
            	
            	var bp_sum_remain = $('#txtb_gfc_bp_sum_remain<?=$time?>').numberbox('getValue');

            	if( bp_sum_remain <= 0 ) return;
            	
            	var op_id = get_guid();
    			$('#table_gfc_bp<?=$time?>').edatagrid('addRow',{
    				index:0,
    				row:{
    					bp_id: op_id,
    				}
    			});

                break;
            case 'del':

                var op_list=$('#table_gfc_bp<?=$time?>').datagrid('getChecked');

                var row_s = $('#table_gfc_bp<?=$time?>').datagrid('getSelected');
                var index_s = $('#table_gfc_bp<?=$time?>').datagrid('getRowIndex',row_s);

                if($('#table_gfc_bp<?=$time?>').datagrid('validateRow',index_s))
                {
                    $('#table_gfc_bp<?=$time?>').datagrid('endEdit',index_s);
                }
                else
                {
                    $('#table_gfc_bp<?=$time?>').datagrid('cancelEdit',index_s);
                }

                for(var i=op_list.length-1;i>-1;i--)
                {
                    if(op_list[i].bill_id ) continue;
                    
                    var index = $('#table_gfc_bp<?=$time?>').datagrid('getRowIndex',op_list[i]);
                    $('#table_gfc_bp<?=$time?>').datagrid('deleteRow',index);
                }

                load_gfc_bp_prog<?=$time?>();
                        
                break;
        }

    }

    function get_gfc_bp_sum_all<?=$time?>()
    {
    	var op_list=$('#table_gfc_bp<?=$time?>').datagrid('getRows');

    	var bp_sum_all = 0;
    	 
    	for(var i=0;i<op_list.length;i++)
    	{
    		if(op_list[i].bp_sum)
    		bp_sum_all+=parseFloat(op_list[i].bp_sum);
    	}

    	return bp_sum_all;
    }

    function load_gfc_bp_prog<?=$time?>()
    {
    	var bp_sum_all = get_gfc_bp_sum_all<?=$time?>();

        var sum = $('#txtb_gfc_sum<?=$time?>').numberbox('getValue');

		var sum_remain = sum - bp_sum_all;

		$('#txtb_gfc_bp_sum_remain<?=$time?>').numberbox('setValue',sum_remain);

		$('#gfc_bp_prog<?=$time?>').progressbar({
			value: bp_sum_all/sum*100,
			text: '已分解金额:'+num_parse(bp_sum_all)
		})
    }
</script>