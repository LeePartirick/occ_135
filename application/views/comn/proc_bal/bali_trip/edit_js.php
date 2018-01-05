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

	//差旅费明细
	load_table_trip<?=$time?>();

	//出差人明细
	load_table_trip_c<?=$time?>();

	//差旅费补贴
	load_table_trip_sub<?=$time?>();
			
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
				if('<?=$fun_no_db?>')
				{
					eval("<?=$fun_no_db?>('f_<?=$time?>','"+btn+"')");
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
						url+='/act/<?=STAT_ACT_EDIT?>/bali_id/'+json.id

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

//差旅费--载入
function load_table_trip<?=$time?>()
{
    $('#table_trip<?=$time?>').edatagrid({
        width:'100%',
        height:'200',
        toolbar:'#table_trip_tool<?=$time?>',
        singleSelect:true,
        selectOnCheck:false,
        checkOnSelect:false,
        striped:true,
        remoteSort: false,
        showFooter:true,
        idField:'bali_tr_id',
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
			{field:'bali_tr_id',title:'',width:50,align:'center',checkbox:true,rowspan:2},
			{field:'title_out',title:'出发',width:225,align:'center',colspan:2},
			{field:'title_in',title:'到达',width:225,align:'center',colspan:2},
			{field:'baltr_traffic',title:'交通工具',width:80,halign:'center',align:'center',rowspan:2,
			    formatter: fun_table_trip_formatter<?=$time?>,
	    		editor:{
					type:'textbox',
					options:{
			    		 required:true,
				    	 buttonIcon:'icon-clear',
			     	   	 onClickButton:function()
			         	 {
							$(this).textbox('clear');
			         	 },
					}
				} 
			},
			{field:'title_tra',title:'车船票',width:170,align:'center',colspan:2},
			{field:'title_tra',title:'其他费用',width:470,align:'center',colspan:5},
			{field:'baltr_tatal_sum',title:'合计',width:100,halign:'center',align:'right',rowspan:2,
                formatter: fun_table_trip_formatter<?=$time?>,
                editor:{
					type:'numberbox',
					options:{
						readonly:true,
                		precision:2,
		   				min:0,
		   				groupSeparator:',',
		   				buttonIcon:'icon-lock',
					}
				} 
            },
        ],[
            {field:'baltr_time_out',title:'时间',width:125,halign:'center',align:'center',sortable:true,
                formatter: fun_table_trip_formatter<?=$time?>,
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
            {field:'baltr_place_out',title:'地点',width:100,halign:'center',align:'center',
			    formatter: fun_table_trip_formatter<?=$time?>,
	    		editor:{
					type:'textbox',
					options:{
			   	 		 required:true,
				    	 buttonIcon:'icon-clear',
			     	   	 onClickButton:function()
			         	 {
							$(this).textbox('clear');
			         	 },
					}
				} 
			},
            {field:'baltr_time_in',title:'时间',width:125,halign:'center',align:'center',
                formatter: fun_table_trip_formatter<?=$time?>,
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
            {field:'baltr_place_in',title:'地点',width:100,halign:'center',align:'center',
			    formatter: fun_table_trip_formatter<?=$time?>,
	    		editor:{
					type:'textbox',
					options:{
			    		 required:true,
				    	 buttonIcon:'icon-clear',
			     	   	 onClickButton:function()
			         	 {
							$(this).textbox('clear');
			         	 },
					}
				} 
			},
            {field:'baltr_tra_count',title:'单据张数',width:70,halign:'center',align:'right',
                formatter: fun_table_trip_formatter<?=$time?>,
                editor:{
					type:'numberbox',
					options:{
                		required:true,
                		precision:0,
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
            {field:'baltr_tra_sum',title:'金额',width:100,halign:'center',align:'right',
                formatter: fun_table_trip_formatter<?=$time?>,
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
					}
				} 
            },
            {field:'baltr_other_count',title:'单据',width:70,halign:'center',align:'right',
                formatter: fun_table_trip_formatter<?=$time?>,
                editor:{
					type:'numberbox',
					options:{
//                		required:true,
                		precision:0,
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
            {field:'baltr_city_sum',title:'市内交通',width:100,halign:'center',align:'right',
                formatter: fun_table_trip_formatter<?=$time?>,
                editor:{
					type:'numberbox',
					options:{
//                		required:true,
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
            {field:'baltr_room_sum',title:'住宿',width:100,halign:'center',align:'right',
                formatter: fun_table_trip_formatter<?=$time?>,
                editor:{
					type:'numberbox',
					options:{
//                		required:true,
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
            {field:'baltr_food_sum',title:'伙食',width:100,halign:'center',align:'right',
                formatter: fun_table_trip_formatter<?=$time?>,
                editor:{
					type:'numberbox',
					options:{
//                		required:true,
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
            {field:'baltr_other_sum',title:'其他',width:100,halign:'center',align:'right',
                formatter: fun_table_trip_formatter<?=$time?>,
                editor:{
					type:'numberbox',
					options:{
//                		required:true,
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
        onBeginEdit: function(index,row)
        {
        	var ed_list=$(this).datagrid('getEditors',index);

			for(var i = 0;i < ed_list.length; i++)
			{
				switch(ed_list[i].field)
				{
					case 'baltr_time_out':
					case 'baltr_time_in':
						
						$(ed_list[i].target).datebox('textbox').bind('focus',
						function(){
							$(this).parent().prev().datebox('showPanel');
						});
						break;
					case 'baltr_tra_sum':
					case 'baltr_city_sum':
					case 'baltr_room_sum':
					case 'baltr_food_sum':
					case 'baltr_other_sum':
					case 'baltr_tatal_sum':

						$(ed_list[i].target).numberbox({
							onChange:function(nV,oV)
							{
								fun_count_trip_total<?=$time?>();
							}
						});
						
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
//					case 'baltr_tra_sum':
					case 'baltr_city_sum':
					case 'baltr_room_sum':
					case 'baltr_food_sum':
					case 'baltr_other_sum':
						if( ! row[ed_list[i].field] )
							row[ed_list[i].field] = 0;
						
						break;
				}
			}

			fun_load_trip_foot<?=$time?>();
        },
        onLoadSuccess: function(data)
		{
        	fun_load_trip_foot<?=$time?>();
		},
        onResizeColumn: function(field, width)
		{
		}
    });

    if( arr_view<?=$time?>.indexOf('content[trip]')>-1 )
    {
    	$('#table_trip<?=$time?>').edatagrid('disableEditing');
        $('#table_trip_tool<?=$time?> .oa_op').hide();
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

//行合计
function fun_count_trip_total<?=$time?>(){

	var row_s = $('#table_trip<?=$time?>').edatagrid('getSelected');
	var index_s = $('#table_trip<?=$time?>').edatagrid('getRowIndex',row_s);

	var ed_list=$('#table_trip<?=$time?>').datagrid('getEditors',index_s);

	var sum_total = 0;
	
	for(var i = 0;i < ed_list.length; i++)
	{
		switch(ed_list[i].field)
		{
			case 'baltr_tra_sum':
			case 'baltr_city_sum':
			case 'baltr_room_sum':
			case 'baltr_food_sum':
			case 'baltr_other_sum':
				var sum= $(ed_list[i].target).numberbox('getValue');
				if( ! sum ) sum = 0;
				sum_total += parseFloat(sum);
				break;
			case 'baltr_tatal_sum':
				$(ed_list[i].target).numberbox('setValue',sum_total);
				break;
		}
	}
	
}

//底部小计
function fun_load_trip_foot<?=$time?>(){

	var row =  $('#table_trip<?=$time?>').edatagrid('getRows');
	var foot = {};

	foot.baltr_tra_sum = 0;
	foot.baltr_city_sum = 0;
	foot.baltr_room_sum = 0;
	foot.baltr_food_sum = 0;
	foot.baltr_other_sum = 0;
	foot.baltr_tatal_sum = 0;
	
	for(var i=0;i<row.length;i++)
	{
		foot.baltr_tra_sum += parseFloat(row[i].baltr_tra_sum);
		foot.baltr_city_sum += parseFloat(row[i].baltr_city_sum);
		foot.baltr_room_sum += parseFloat(row[i].baltr_room_sum);
		foot.baltr_food_sum += parseFloat(row[i].baltr_food_sum);
		foot.baltr_other_sum += parseFloat(row[i].baltr_other_sum);
		foot.baltr_tatal_sum += parseFloat(row[i].baltr_tatal_sum);
	}

	$('#table_trip<?=$time?>').datagrid('reloadFooter',[
    	foot
    ]);
	                              	
}

//列格式化输出
function fun_table_trip_formatter<?=$time?>(value,row,index){

    switch(this.field)
    {
	    case 'baltr_tra_sum':
		case 'baltr_city_sum':
		case 'baltr_room_sum':
		case 'baltr_food_sum':
		case 'baltr_other_sum':
		case 'baltr_tatal_sum':
    		value = num_parse(value);
        	break;
        	
        default:
            if(row[this.field+'_s'])
                value = row[this.field+'_s'];
    }

    if( ! value ) value = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ;
    return '<span id="table_trip<?=$time?>_'+index+'_'+this.field+'" class="table_trip<?=$time?>" >'+value+'</span>';
}

//差旅费--操作
function fun_table_trip_operate<?=$time?>(btn)
{
    switch(btn)
    {
        case 'add':

        	var row_s = $('#table_trip<?=$time?>').datagrid('getSelected');
        	var index_s = $('#table_trip<?=$time?>').datagrid('getRowIndex',row_s);
        	if( index_s > -1)
        	{
        		if($('#table_trip<?=$time?>').datagrid('validateRow',index_s))
					$('#table_trip<?=$time?>').datagrid('endEdit',index_s)
				else
					return;//$('#table_trip<?=$time?>').datagrid('cancelEdit',index_s)
        	}
        	
        	var op_id = get_guid();
			$('#table_trip<?=$time?>').edatagrid('addRow',{
				index:0,
				row:{
					bali_tr_id: op_id,
				}
			});

            break;
        case 'del':

            var op_list=$('#table_trip<?=$time?>').datagrid('getChecked');

            var row_s = $('#table_trip<?=$time?>').datagrid('getSelected');
            var index_s = $('#table_trip<?=$time?>').datagrid('getRowIndex',row_s);

            if($('#table_trip<?=$time?>').datagrid('validateRow',index_s))
            {
                $('#table_trip<?=$time?>').datagrid('endEdit',index_s);
            }
            else
            {
                $('#table_trip<?=$time?>').datagrid('cancelEdit',index_s);
            }

            for(var i=op_list.length-1;i>-1;i--)
            {
                var index = $('#table_trip<?=$time?>').datagrid('getRowIndex',op_list[i]);
                $('#table_trip<?=$time?>').datagrid('deleteRow',index);
            }
                    
            break;
    }

}

//出差人--载入
var err_table_trip_c<?=$time?> = '';
function load_table_trip_c<?=$time?>()
{
    $('#table_trip_c<?=$time?>').edatagrid({
        width:'100%',
        height:'150',
        toolbar:'#table_trip_c_tool<?=$time?>',
        singleSelect:true,
        selectOnCheck:false,
        checkOnSelect:false,
        striped:true,
        remoteSort: false,
        showFooter:true,
        idField:'bali_trc_id',
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
			{field:'bali_trc_id',title:'',width:50,align:'center',checkbox:true},
			{field:'baltr_c_id',title:'姓名',width:150,halign:'center',align:'left',
			    formatter: fun_table_trip_c_formatter<?=$time?>,
			    editor:{
					type:'combobox',
					options:{
						 err:err,
						 panelHeight:'auto',
						 required:true,
			    		 valueField: 'id',    
			           	 textField: 'text',  
			        	 hasDownArrow:false,
			        	 buttonIcon:'icon-clear',
				   	   	 onClickButton:function()
				       	 {
								$(this).combobox('clear');
				       	 },
					}
				},
			},
			{field:'baltr_c_type',title:'人员类型',width:150,halign:'center',align:'left',
	              formatter: fun_table_trip_c_formatter<?=$time?>,
	              editor:{
					type:'combobox',
					options:{
	            	  	err:err,
	            	  	limitToList:true,
	            	  	data: [<?=element('baltr_c_type',$json_field_define)?>],
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
            {field:'baltr_single',title:'单住',width:80,halign:'center',align:'center',
			    formatter: fun_table_trip_c_formatter<?=$time?>,
	    		editor:{
					type:'numberbox',
					options:{
			    		 err:err,
			    		 min:0,
				    	 buttonIcon:'icon-clear',
			     	   	 onClickButton:function()
			         	 {
							$(this).numberbox('clear');
			         	 },
					}
				} 
			},
			 {field:'baltr_together',title:'合住',width:80,halign:'center',align:'center',
			    formatter: fun_table_trip_c_formatter<?=$time?>,
	    		editor:{
					type:'numberbox',
					options:{
			    		 err:err,
						 min:0,
				    	 buttonIcon:'icon-clear',
			     	   	 onClickButton:function()
			         	 {
							$(this).numberbox('clear');
			         	 },
					}
				} 
			},
			{field:'baltr_pay_type',title:'支付方式',width:150,halign:'center',align:'left',
              formatter: fun_table_trip_c_formatter<?=$time?>,
              editor:{
				type:'combobox',
				options:{
            	  	err:err,
            	  	limitToList:true,
            	  	data: [<?=element('baltr_pay_type',$json_field_define)?>],
          			panelHeight:'auto',
          			required:true,
          			valueField: 'id',    
                  	textField: 'text',  
                  	buttonIcon:'icon-clear',
		     	   	onClickButton:function()
		         	{
						$(this).combobox('clear');
		         	},
		         	loadFilter:function(data)
					{
					 	var value = $(this).combobox('getValue');
					 	var data_new = [];
					 	var arr = [1,9];
					 	
	   					for(var i =0;i < data.length;i++)
	   					{
	   						if(arr.indexOf( parseInt(data[i].id) ) > -1 || value == data[i].id)
	   						{
	   							data_new.push(data[i]);
	   						}
	   					}
	   					
	   					return data_new;
					},
				}
			} 
          },
          {field:'baltr_c_sum',title:'金额',width:125,halign:'right',align:'right',
              formatter: fun_table_trip_c_formatter<?=$time?>,
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
          {field:'c_bank',title:'卡号',width:150,halign:'center',align:'center',
		   formatter: fun_table_trip_c_formatter<?=$time?>,
    	   editor:{
				type:'textbox',
				options:{
					 readonly:true,
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
        onBeginEdit: function(index,row)
        {
        	var ed_list=$(this).datagrid('getEditors',index);

        	var ed_baltr_c_id = '';
        	var ed_c_bank = '';
        	var ed_baltr_single = '';
        	var ed_baltr_together = '';
			for(var i = 0;i < ed_list.length; i++)
			{
				switch(ed_list[i].field)
				{
					case 'baltr_c_id':
						ed_baltr_c_id = ed_list[i].target;
						break;
					case 'c_bank':
						ed_c_bank = ed_list[i].target;
						break;
					case 'baltr_c_type':
					case 'baltr_pay_type':
						
						$(ed_list[i].target).combobox('textbox').bind('focus',
						function(){
							$(this).parent().prev().combobox('showPanel');
						});
						break;
					case 'baltr_c_sum':
						
						$(ed_list[i].target).numberbox('textbox').css('text-align','right');
						
    					break;
					case 'baltr_single':
						ed_baltr_single = ed_list[i].target;
	    				break;
					case 'baltr_together':
						ed_baltr_together = ed_list[i].target;
	    				break;
				}
			}

			$(ed_baltr_c_id).combobox('textbox').autocomplete({
				serviceUrl: 'base/auto/get_json_contact/search_c_login_id/1',
				width:'300',
				params:{
					rows:10,
				},
				onSelect: function (suggestion) {
					var c_id = base64_decode(suggestion.data.c_id);
					var c_show = base64_decode(suggestion.data.c_show);
					
					$(ed_baltr_c_id).combobox('setValue',c_id);
					$(ed_baltr_c_id).combobox('setText',c_show);

					$(ed_c_bank).textbox('setValue',base64_decode(suggestion.data.c_bank));
				}
			});

			$(ed_baltr_c_id).combobox('setValue',row.baltr_c_id);
			$(ed_baltr_c_id).combobox('setText',row.baltr_c_id_s);

			if( ! row.baltr_together && ! row.baltr_single)
			{
				layer.tips('单住/合住不可全部为空！',$(ed_baltr_single).numberbox('textbox'),{tips: [1]});
			}

        },
        onEndEdit: function(index, row, changes)
        {
        	var ed_list=$(this).datagrid('getEditors',index);

        	var ed_baltr_single = '';
        	var ed_baltr_together = '';
			for(var i = 0;i < ed_list.length; i++)
			{
				switch(ed_list[i].field)
				{
					case 'baltr_c_id':
						row.baltr_c_id_s = $(ed_list[i].target).combobox('getText');
						break;
					case 'baltr_c_type':
						row.baltr_c_type_s = $(ed_list[i].target).combotree('getText');
	    				break;
					case 'baltr_pay_type':
						row.baltr_pay_type_s = $(ed_list[i].target).combotree('getText');
	    				break;
				}
			}

			if( ! row.baltr_together && ! row.baltr_single)
			{
				err_table_trip_c<?=$time?> = 1;
			}
        },
        onLoadSuccess: function(data)
		{
		},
        onResizeColumn: function(field, width)
		{
		}
    });

    if( arr_view<?=$time?>.indexOf('content[trip_c]')>-1 )
    {
    	$('#table_trip_c<?=$time?>').edatagrid('disableEditing');
        $('#table_trip_c_tool<?=$time?> .oa_op').hide();
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
function fun_table_trip_c_formatter<?=$time?>(value,row,index){

    switch(this.field)
    {
	    case 'baltr_c_sum':
    		value = num_parse(value);
        	break;
        	
        default:
            if(row[this.field+'_s'])
                value = row[this.field+'_s'];
    }

    if( ! value ) value = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ;
    return '<span id="table_trip_c<?=$time?>_'+index+'_'+this.field+'" class="table_trip_c<?=$time?>" >'+value+'</span>';
}

//差旅费--操作
function fun_table_trip_c_operate<?=$time?>(btn)
{
    switch(btn)
    {
        case 'add':

        	var row_s = $('#table_trip_c<?=$time?>').datagrid('getSelected');
        	var index_s = $('#table_trip_c<?=$time?>').datagrid('getRowIndex',row_s);
        	
        	if( index_s > -1)
        	{
        		if($('#table_trip_c<?=$time?>').datagrid('validateRow',index_s))
					$('#table_trip_c<?=$time?>').datagrid('endEdit',index_s)
				else
					return;//$('#table_trip_c<?=$time?>').datagrid('cancelEdit',index_s)
        	}

        	if( err_table_trip_c<?=$time?> ) 
            {
        		$('#table_trip_c<?=$time?>').edatagrid('editRow',index_s)
				return ;
            }
        	
        	var op_id = get_guid();
			$('#table_trip_c<?=$time?>').edatagrid('addRow',{
				index:0,
				row:{
					bali_trc_id: op_id,
				}
			});

            break;
        case 'del':

            var op_list=$('#table_trip_c<?=$time?>').datagrid('getChecked');

            var row_s = $('#table_trip_c<?=$time?>').datagrid('getSelected');
            var index_s = $('#table_trip_c<?=$time?>').datagrid('getRowIndex',row_s);

            if($('#table_trip_c<?=$time?>').datagrid('validateRow',index_s))
            {
                $('#table_trip_c<?=$time?>').datagrid('endEdit',index_s);
            }
            else
            {
                $('#table_trip_c<?=$time?>').datagrid('cancelEdit',index_s);
            }

            for(var i=op_list.length-1;i>-1;i--)
            {
                var index = $('#table_trip_c<?=$time?>').datagrid('getRowIndex',op_list[i]);
                $('#table_trip_c<?=$time?>').datagrid('deleteRow',index);
            }
                    
            break;
    }

}

//差额补贴--载入
function load_table_trip_sub<?=$time?>()
{
    $('#table_trip_sub<?=$time?>').edatagrid({
        width:'100%',
        height:'150',
        toolbar:'#table_trip_sub_tool<?=$time?>',
        singleSelect:true,
        selectOnCheck:false,
        checkOnSelect:false,
        striped:true,
        remoteSort: false,
        showFooter:true,
        idField:'bali_trc_id',
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
			{field:'bali_trc_id',title:'',width:50,align:'center',checkbox:true},
			{field:'baltrs_c_id',title:'补贴人',width:150,halign:'center',align:'left',
			    formatter: fun_table_trip_sub_formatter<?=$time?>,
			    editor:{
					type:'combobox',
					options:{
						 err:err,
						 panelHeight:'auto',
						 required:true,
			    		 valueField: 'id',    
			           	 textField: 'text',  
			        	 hasDownArrow:false,
			        	 buttonIcon:'icon-clear',
				   	   	 onClickButton:function()
				       	 {
								$(this).combobox('clear');
				       	 },
					}
				},
			},
            {field:'baltrs_day_count',title:'天数',width:80,halign:'center',align:'center',
			    formatter: fun_table_trip_sub_formatter<?=$time?>,
	    		editor:{
					type:'numberbox',
					options:{
			    		 err:err,
			    		 required:true,
			    		 min:0,
				    	 buttonIcon:'icon-clear',
			     	   	 onClickButton:function()
			         	 {
							$(this).numberbox('clear');
			         	 },
					}
				} 
			},
          {field:'baltrs_room_normal',title:'住宿标准（元/人/天）',width:140,halign:'center',align:'right',
              formatter: fun_table_trip_sub_formatter<?=$time?>,
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
          {field:'baltrs_food_normal',title:'伙食标准（元/人/天）',width:140,halign:'center',align:'right',
              formatter: fun_table_trip_sub_formatter<?=$time?>,
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
          {field:'baltrs_room_difference',title:'住宿差额',width:125,halign:'center',align:'right',
              formatter: fun_table_trip_sub_formatter<?=$time?>,
              editor:{
				type:'numberbox',
				options:{
            	    err:err,
//            	    required:true,
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
          {field:'baltr_food_difference',title:'伙食差额',width:125,halign:'center',align:'right',
              formatter: fun_table_trip_sub_formatter<?=$time?>,
              editor:{
				type:'numberbox',
				options:{
            	    err:err,
//            	    required:true,
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
          {field:'baltr_other',title:'其他',width:125,halign:'center',align:'right',
              formatter: fun_table_trip_sub_formatter<?=$time?>,
              editor:{
				type:'numberbox',
				options:{
            	    err:err,
//            	    required:true,
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
          {field:'baltr_sum_total',title:'补贴合计',width:125,halign:'center',align:'right',
              formatter: fun_table_trip_sub_formatter<?=$time?>,
              editor:{
				type:'numberbox',
				options:{
            	    err:err,
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
        onBeginEdit: function(index,row)
        {
        	var ed_list=$(this).datagrid('getEditors',index);

        	var ed_baltrs_c_id = '';
			for(var i = 0;i < ed_list.length; i++)
			{
				switch(ed_list[i].field)
				{
					case 'baltrs_c_id':
						ed_baltrs_c_id = ed_list[i].target;
						break;
					case 'baltrs_room_normal':
				    case 'baltrs_food_normal':
				    case 'baltr_sum_total':

				    	$(ed_list[i].target).numberbox('textbox').css('text-align','right');
				    	
					    break;
				    case 'baltrs_room_difference':
				    case 'baltr_other':
				    case 'baltr_food_difference':

				    	$(ed_list[i].target).numberbox({
							onChange:function(nV,oV)
							{
								fun_count_trip_sub_total<?=$time?>();
							}
						});
						
						$(ed_list[i].target).numberbox('textbox').css('text-align','right');
						
    					break;
				}
			}

			$(ed_baltrs_c_id).combobox('textbox').autocomplete({
				serviceUrl: 'base/auto/get_json_contact/search_c_login_id/1',
				width:'300',
				params:{
					rows:10,
				},
				onSelect: function (suggestion) {
					var c_id = base64_decode(suggestion.data.c_id);
					var c_show = base64_decode(suggestion.data.c_show);
					
					$(ed_baltrs_c_id).combobox('setValue',c_id);
					$(ed_baltrs_c_id).combobox('setText',c_show);

				}
			});

			$(ed_baltrs_c_id).combobox('setValue',row.baltr_c_id);
			$(ed_baltrs_c_id).combobox('setText',row.baltr_c_id_s);

        },
        onEndEdit: function(index, row, changes)
        {
        	var ed_list=$(this).datagrid('getEditors',index);

        	var ed_baltr_single = '';
        	var ed_baltr_together = '';
			for(var i = 0;i < ed_list.length; i++)
			{
				switch(ed_list[i].field)
				{
					case 'baltrs_c_id':
						row.baltrs_c_id_s = $(ed_list[i].target).combobox('getText');
						break;
				}
			}

			fun_load_trip_sub_foot<?=$time?>();
        },
        onLoadSuccess: function(data)
		{
        	fun_load_trip_sub_foot<?=$time?>();
		},
        onResizeColumn: function(field, width)
		{
		}
    });

    if( arr_view<?=$time?>.indexOf('content[trip_sub]')>-1 )
    {
    	$('#table_trip_sub<?=$time?>').edatagrid('disableEditing');
        $('#table_trip_sub_tool<?=$time?> .oa_op').hide();
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

//行合计
function fun_count_trip_sub_total<?=$time?>(){

	var row_s = $('#table_trip_sub<?=$time?>').edatagrid('getSelected');
	var index_s = $('#table_trip_sub<?=$time?>').edatagrid('getRowIndex',row_s);

	var ed_list=$('#table_trip_sub<?=$time?>').datagrid('getEditors',index_s);

	var sum_total = 0;
	
	for(var i = 0;i < ed_list.length; i++)
	{
		switch(ed_list[i].field)
		{
			case 'baltrs_room_difference':
			case 'baltr_other':
			case 'baltr_food_difference':
				var sum= $(ed_list[i].target).numberbox('getValue');
				if( ! sum ) sum = 0;
				sum_total += parseFloat(sum);
				break;
			case 'baltr_sum_total':
				$(ed_list[i].target).numberbox('setValue',sum_total);
				break;
		}
	}
	
}

//底部小计
function fun_load_trip_sub_foot<?=$time?>(){

	var row =  $('#table_trip_sub<?=$time?>').edatagrid('getRows');
	var foot = {};

	foot.baltrs_room_normal = 0;
	foot.baltrs_food_normal = 0;
	foot.baltrs_room_difference = 0;
	foot.baltr_other = 0;
	foot.baltr_food_difference = 0;
	foot.baltr_sum_total = 0;
	
	for(var i=0;i<row.length;i++)
	{
		foot.baltrs_room_normal += parseFloat(row[i].baltrs_room_normal);
		foot.baltrs_food_normal += parseFloat(row[i].baltrs_food_normal);
		foot.baltrs_room_difference += parseFloat(row[i].baltrs_room_difference);
		foot.baltr_other += parseFloat(row[i].baltr_other);
		foot.baltr_food_difference += parseFloat(row[i].baltr_food_difference);
		foot.baltr_sum_total += parseFloat(row[i].baltr_sum_total);
	}
	

	$('#table_trip_sub<?=$time?>').datagrid('reloadFooter',[
    	foot
    ]);
}

//列格式化输出
function fun_table_trip_sub_formatter<?=$time?>(value,row,index){

    switch(this.field)
    {
	    case 'baltrs_room_normal':
	    case 'baltrs_food_normal':
	    case 'baltrs_room_difference':
	    case 'baltr_other':
	    case 'baltr_food_difference':
	    case 'baltr_sum_total':
    		value = num_parse(value);
        	break;
        	
        default:
            if(row[this.field+'_s'])
                value = row[this.field+'_s'];
    }

    if( ! value ) value = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ;
    return '<span id="table_trip_sub<?=$time?>_'+index+'_'+this.field+'" class="table_trip_sub<?=$time?>" >'+value+'</span>';
}

//差旅费补贴--操作
function fun_table_trip_sub_operate<?=$time?>(btn)
{
    switch(btn)
    {
        case 'add':

        	var row_s = $('#table_trip_sub<?=$time?>').datagrid('getSelected');
        	var index_s = $('#table_trip_sub<?=$time?>').datagrid('getRowIndex',row_s);
        	
        	if( index_s > -1)
        	{
        		if($('#table_trip_sub<?=$time?>').datagrid('validateRow',index_s))
					$('#table_trip_sub<?=$time?>').datagrid('endEdit',index_s)
				else
					return;//$('#table_trip_sub<?=$time?>').datagrid('cancelEdit',index_s)
        	}
        	
        	var op_id = get_guid();
			$('#table_trip_sub<?=$time?>').edatagrid('addRow',{
				index:0,
				row:{
					bali_trs_id: op_id,
				}
			});

            break;
        case 'del':

            var op_list=$('#table_trip_sub<?=$time?>').datagrid('getChecked');

            var row_s = $('#table_trip_sub<?=$time?>').datagrid('getSelected');
            var index_s = $('#table_trip_sub<?=$time?>').datagrid('getRowIndex',row_s);

            if($('#table_trip_sub<?=$time?>').datagrid('validateRow',index_s))
            {
                $('#table_trip_sub<?=$time?>').datagrid('endEdit',index_s);
            }
            else
            {
                $('#table_trip_sub<?=$time?>').datagrid('cancelEdit',index_s);
            }

            for(var i=op_list.length-1;i>-1;i--)
            {
                var index = $('#table_trip_sub<?=$time?>').datagrid('getRowIndex',op_list[i]);
                $('#table_trip_sub<?=$time?>').datagrid('deleteRow',index);
            }
                    
            break;
    }
}
</script>