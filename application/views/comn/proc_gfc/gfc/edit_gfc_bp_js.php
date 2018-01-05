<!-- 加载jquery -->
<script type="text/javascript">

	//合同标的
	function load_gfc_bp_sum<?=$time?>()
	{
		$('#txtb_gfc_bp_sum<?=$time?>').numberbox('textbox').css('text-align','right');
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
        					
        					$(ed_list[i].target).numberbox({
								max:parseFloat(max)
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
        		value = num_parse(value);

        		if('<?=$code?>')
        		{
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
        		}
        		
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