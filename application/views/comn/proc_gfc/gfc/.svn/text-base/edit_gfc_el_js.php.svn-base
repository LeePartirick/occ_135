<!-- 加载jquery -->
<script type="text/javascript">

//设备清单--载入
function load_table_gfc_eli<?=$time?>()
{
    $('#table_gfc_eli<?=$time?>').edatagrid({
        width:'100%',
        height:'auto',
        toolbar:'#table_gfc_eli_tool<?=$time?>',
        singleSelect:true,
        selectOnCheck:false,
        checkOnSelect:false,
        striped:true,
        idField:'eli_id',
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
        view: groupview, 
		groupField:'eli_type',
		groupFormatter: function(value,rows)
		{
    		if(value == 1)
    			return '设备采购';
			if(value == 2)
				return '零星采购';
			if(value == 3)
				return '分包采购';
		},
        columns:[[
			{field:'eli_id',title:'',width:50,align:'center',checkbox:true},
			{field:'eli_name',title:'设备名称<br>分包名称',width:150,halign:'center',align:'left',
			    formatter: fun_table_gfc_eli_formatter<?=$time?>,
			},
			{field:'eli_parameter',title:'设备参数<br>服务大概描述',width:150,halign:'center',align:'left',
                formatter: fun_table_gfc_eli_formatter<?=$time?>,
            },
			//{field:'eli_brand',title:'品牌',width:150,halign:'center',align:'center',
			//    formatter: fun_table_gfc_eli_formatter<?=$time?>,
			//},
			//{field:'eli_model',title:'型号',width:150,halign:'center',align:'center',
			//    formatter: fun_table_gfc_eli_formatter<?=$time?>,
			//},
			{field:'eli_c_pr',title:'采购人',width:100,halign:'center',align:'center',hidden:true,
			    formatter: fun_table_gfc_eli_formatter<?=$time?>,
			},                  
			{field:'eli_count',title:'数量',width:80,halign:'center',align:'center',
			    formatter: fun_table_gfc_eli_formatter<?=$time?>,
			    editor:{
					type:'numberbox',
					options:{
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
			{field:'eli_sum',title:'采购单价',width:80,halign:'center',align:'right',
			    formatter: fun_table_gfc_eli_formatter<?=$time?>,
			    editor:{
					type:'numberbox',
					options:{
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
			{field:'eli_sum_total',title:'单位成本',width:80,halign:'center',align:'right',
			    formatter: fun_table_gfc_eli_formatter<?=$time?>,
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
			{field:'eli_maintenance',title:'保修期-月<br>服务期-月',width:120,halign:'center',align:'center',
			    formatter: fun_table_gfc_eli_formatter<?=$time?>,
			    editor:{
					type:'numberbox',
					options:{
			    		required:true,
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
			{field:'eli_sub',title:'预算科目',width:120,halign:'center',align:'center',
			    formatter: fun_table_gfc_eli_formatter<?=$time?>,
//			    editor:{
//					type:'combobox',
//					options:{
//			    		required:true,
//			    		limitToList:true,
//		   				valueField:'id',    
//						textField:'text',
//						panelHeight:'auto',
//		   				panelMaxHeight:120,
//						buttonIcon:'icon-clear',
// 			     	    onClickButton:function()
// 			            {
// 							$(this).combobox('clear');
// 			            }
//					}
//				} 
			},
			{field:'eli_note',title:'备注',width:200,halign:'center',align:'center',
			    formatter: fun_table_gfc_eli_formatter<?=$time?>,
	    		editor:{
					type:'textbox',
					options:{
						height:'100%',
						multiline:true,
						buttonIcon:'icon-clear',
 			     	    onClickButton:function()
 			            {
 							$(this).textbox('clear');
 			            }
					}
				} 
			},
        ]],
//        frozenColumns:[[
//        ]],
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

        	var ed_count,ed_sum,eli_sum_total = '';
        	
			for(var i = 0;i < ed_list.length; i++)
			{
				switch(ed_list[i].field)
				{
//					case 'eli_sub':
//
//						var json = [
//									{"field":"sub_tag","rule":"find_in_set","value":"1,2,3"}
//								]
//						$(ed_list[i].target).combobox({
//							url:'base/auto/get_json_sub/from/combobox/field_id/sub_id/field_text/sub_name',
//							queryParams:{
//								data_search:JSON.stringify(json)
//							},
//							value:row.eli_sub
//						});
//						
//						$(ed_list[i].target).combobox('textbox').bind('focus',
//								function(){
//							$(this).parent().prev().combobox('showPanel');
//						});
//    					break;
					case 'eli_count':
						ed_count = ed_list[i].target;
						break;
					case 'eli_sum':
						ed_sum = ed_list[i].target;
						break;
					case 'eli_sum_total':
						eli_sum_total = ed_list[i].target;
						$(ed_list[i].target).numberbox('textbox').css('text-align','right');
    					break;
					case 'eli_maintenance':
						$(ed_list[i].target).numberbox('textbox').css('text-align','center');
						break;
				}
			}

			$(ed_count).numberbox({
				onChange:function(nV,oV)
				{
					var sum = $(ed_sum).numberbox('getValue');
					if(nV && sum)
						$(eli_sum_total).numberbox('setValue',sum*nV);
				}
			})

			$(ed_count).numberbox('textbox').css('text-align','center');

			$(ed_sum).numberbox({
				onChange:function(nV,oV)
				{
					var count = $(ed_count).numberbox('getValue');
					if(nV && count)
						$(eli_sum_total).numberbox('setValue',count*nV);
				}
			})

			$(ed_sum).numberbox('textbox').css('text-align','right');

        },
        onEndEdit: function(index, row, changes)
        {
        	var ed_list=$(this).datagrid('getEditors',index);

			for(var i = 0;i < ed_list.length; i++)
			{
				switch(ed_list[i].field)
				{
					case 'eli_sub':
						row.eli_sub_s = $(ed_list[i].target).combobox('getText');
	    				break;
				}
			}

			if( row.eli_sub_s != '零星采购' )
			{
				if( ! row.eli_count  ) row.eli_count = 1 
				if( ! row.eli_sum  ) row.eli_sum = parseFloat(row.eli_sum_total/row.eli_count).toFixed(2);
			}
        },
    });

    if( arr_view<?=$time?>.indexOf('content[gfc_eli]')>-1 )
    {
    	$('#table_gfc_eli<?=$time?>').edatagrid('disableEditing');
        $('#table_gfc_eli_tool<?=$time?> .oa_op').hide();
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
function fun_table_gfc_eli_formatter<?=$time?>(value,row,index){

    switch(this.field)
    {
    	case 'eli_name':

             var url='proc_gfc/eli/edit/act/2/fun_no_db/fun_no_db_table_gfc_eli<?=$time?>';
             value='<a href="javascript:void(0);" class="link" onClick="fun_table_gfc_eli_win_open<?=$time?>(\''+value+'\',\'win\',\''+url+'\',\''+row.eli_id+'\');">'+value+'</a>';

        	break;
    	case 'eli_maintenance':

    		if(row.eli_maintenance_start)
    			value += '<br>' +row.eli_maintenance_start
			
        	break;
    	case 'eli_parameter':
    		value = '';
    		if(row.eli_supply_org_s && row.eli_type == 3)
			{
				value += '分包商:' +row.eli_supply_org_s
			}
			
			if(row.eli_brand)
				value += '品牌:' +row.eli_brand
			if(row.eli_model)
				value += '<br>型号:' +row.eli_model

			value +=  '<br>' +row.eli_parameter;

        	break;
    	case 'eli_count':
    	case 'eli_sum':
    	case 'eli_sum_total':
    		value = num_parse(value);
        	break;
        	
        default:
            if(row[this.field+'_s'])
                value = row[this.field+'_s'];
    }

    if( ! value ) value = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ;
    return '<span id="table_gfc_eli<?=$time?>_'+index+'_'+this.field+'" class="table_gfc_eli<?=$time?>" >'+value+'</span>';
}

//界面
function fun_table_gfc_eli_win_open<?=$time?>(title,fun,url,id)
{
    switch(fun)
    {
        case 'win':

            var row ={};
            if(id)
            {
                $('#table_gfc_eli<?=$time?>').datagrid('selectRecord',id);
                row = $('#table_gfc_eli<?=$time?>').datagrid('getSelected');
            }

            var win_id=fun_get_new_win();

            var params={};
            params.data_db = base64_encode(JSON.stringify(row));

            if( '<?=$log_time?>')
            {
                var log_content = $('#table_gfc_eli<?=$time?>').attr('log_content');

                if(log_content && id)
                {
                    log_content = JSON.parse(log_content);

                    JSON.parse(JSON.stringify(row), function (key, value) {
                        if( ! (key in log_content[id]['old'].content) )
                            log_content[id]['old'].content[key] = value
                    });

                    log_content[id]['new'] = {};
                    log_content[id]['new'].content = row;

                    params.log_content = JSON.stringify(log_content[id]);

                    if( '<?=$log_time?>' )
                    {
                        params.flag_log = 1;
                        params.log_time = '<?=$log_time?>';
                        params.log_a_login_id = '<?=$log_a_login_id?>';
                        params.log_c_name = '<?=$log_c_name?>';
                        params.log_act = '<?=$log_act?>';
                        params.log_note = '<?=$log_note?>';
                    }
                    else
                        params.flag_check = 1;
                }
            }

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
                queryParams: params,
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

//设备清单--操作
function fun_table_gfc_eli_operate<?=$time?>(btn)
{
    switch(btn)
    {
        case 'add':
        	
        	$('#table_gfc_eli<?=$time?>').datagrid('clearSelections');

            var url = 'proc_gfc/eli/edit/fun_no_db/fun_no_db_table_gfc_eli<?=$time?>/act/1';

            fun_table_gfc_eli_win_open<?=$time?>('创建设备清单明细','win',url)

            break;
        case 'del':

            var op_list=$('#table_gfc_eli<?=$time?>').datagrid('getChecked');

            var row_s = $('#table_gfc_eli<?=$time?>').datagrid('getSelected');
            var index_s = $('#table_gfc_eli<?=$time?>').datagrid('getRowIndex',row_s);

            if($('#table_gfc_eli<?=$time?>').datagrid('validateRow',index_s))
            {
                $('#table_gfc_eli<?=$time?>').datagrid('endEdit',index_s);
            }
            else
            {
                $('#table_gfc_eli<?=$time?>').datagrid('cancelEdit',index_s);
            }

            for(var i=op_list.length-1;i>-1;i--)
            {
                var index = $('#table_gfc_eli<?=$time?>').datagrid('getRowIndex',op_list[i]);
                $('#table_gfc_eli<?=$time?>').datagrid('deleteRow',index);
            }

            fun_load_eli_bud_sum<?=$time?>();
                    
            break;
    }
}

    function fun_no_db_table_gfc_eli<?=$time?>(f_id,btn,data_import)
    {
        if(btn == 'import')
        {
			var data = $('#table_gfc_eli<?=$time?>').datagrid('getData');
			if(data.rows.length > 0)
			{
				data_import = JSON.stringify(data_import);
				var data_exist = JSON.stringify(data.rows);
				data_import = trim(data_import,']') + ',' + data_exist.substr(1);
				data.rows = JSON.parse(data_import);
			}
			else
			{
				data.rows = data_import
			}
			
			$('#table_gfc_eli<?=$time?>').datagrid('loadData',data);

			fun_load_eli_bud_sum<?=$time?>()
			
			if(f_id)
			$('#'+f_id).closest('.op_window').window('close');
			
        	return;
        }
        
        var row_s = $('#table_gfc_eli<?=$time?>').datagrid('getSelected');
        var row = fun_get_data_from_f(f_id,'1');

        $('#'+f_id).closest('.op_window').window('close');

        if( row.eli_sub_s != '零星采购' )
		{
//			if( ! row.eli_count  ) row.eli_count = 1 
//			if( ! row.eli_sum  ) row.eli_sum = (parseFloat(row.eli_sum_total)/parseFloat(row.eli_count)).toFixed(2);
		}
		
        if( row_s )
        {
            var index_s = $('#table_gfc_eli<?=$time?>').datagrid('getRowIndex',row_s);

            if(btn == 'del')
            {
                $('#table_gfc_eli<?=$time?>').datagrid('deleteRow',index_s);
                return;
            }

            row.gfc_id = '<?=$gfc_id?>';
            $('#table_gfc_eli<?=$time?>').datagrid('updateRow',{
                index: index_s,
                row: row
            });
        }
        else
        {
            row.eli_id = get_guid();

            $('#table_gfc_eli<?=$time?>').datagrid('appendRow',row);
        }

        fun_load_eli_bud_sum<?=$time?>();
    }

    //计算预算金额
    function fun_load_eli_bud_sum<?=$time?>()
   	{
		var rows = $('#table_gfc_eli<?=$time?>').datagrid('getRows');
		
		var json = {};
		
		for(var i=0;i<rows.length;i++)
		{
			if( ! json[rows[i].eli_sub] )
				json[rows[i].eli_sub] = 0;
			
			json[rows[i].eli_sub] = parseFloat(json[rows[i].eli_sub]) + parseFloat(rows[i].eli_sum_total)
		}

		var rows = $('#table_gfc_bud<?=$time?>').datagrid('getRows');

		var field = '';

		var check_sum = false;

		for(var i=0;i<rows.length;i++)
		{
			var index = $('#table_gfc_bud<?=$time?>').datagrid('getRowIndex',rows[i].budi_id);

			if( rows[i].budi_sub 
			 && rows[i].budi_sub in json)
			{
				var row={};
				row.budi_sum = json[rows[i].budi_sub];

				$('#table_gfc_bud<?=$time?>').datagrid('updateRow',{
					index : index,
					row: row
				});

				field = 'budi_sum;'+rows[i].budi_id;
				arr_field_count.push(field)

				check_sum = true;
			}
			else if(
				rows[i].sub_tag.indexOf(1) > -1
			 || rows[i].sub_tag.indexOf(2) > -1
			 || rows[i].sub_tag.indexOf(3) > -1
			)
			{
				var row={};
				row.budi_sum = 0;
				$('#table_gfc_bud<?=$time?>').datagrid('updateRow',{
					index : index,
					row: row
				});

				field = 'budi_sum;'+rows[i].budi_id;
				arr_field_count.push(field)
			}
		}

		var check_cr_link_field = fun_check_cr_link_field(1);

		if(check_sum && check_cr_link_field == '')
		{
			load_cr_of_link_field(1,'add');
		}
		else if( ! check_sum && check_cr_link_field != '')
		{
			load_cr_of_link_field(1,'del')
		}

		if(field)
		fun_count_gfc_bud_cell<?=$time?>(field);

		load_prog_budi_sum<?=$time?>()
   	}
</script>