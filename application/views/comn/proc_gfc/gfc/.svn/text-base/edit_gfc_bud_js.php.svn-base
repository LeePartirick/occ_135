<!-- 加载jquery -->
<script type="text/javascript">

    //预算表--载入
    var hr_budi_id<?=$time?> = '';
    function load_table_gfc_bud<?=$time?>()
    {
    	$('#table_gfc_bud<?=$time?>').datagrid({    
			width:'100%',
			height:'auto',
			toolbar:'#table_gfc_bud_tool<?=$time?>',
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
				return base64_decode(value);
			},
//			groupStyler: function(value,rows)
//			{
//				return 'width:100%;text-align:center';
//			},
			fun_ready:'fun_merge_sub_ou_show<?=$time?>()',
			frozenColumns:[[ 
				{field:'budi_id',title:'',width:50,align:'center',checkbox:true,hidden:true,
			     formatter: fun_table_gfc_bud_formatter<?=$time?>
				},
//			   {field:'budi_ou_show',title:'部门',width:100,halign:'center',align:'left',
//			    formatter: fun_table_gfc_bud_formatter<?=$time?>
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
			    formatter: fun_table_gfc_bud_formatter<?=$time?>
			   },
			   {field:'budi_name',title:'核算内容',width:200,halign:'center',align:'left',
				 editor:{
					   type:'combobox',
					   options:{
				   	   required:true,
				   	   panelHeight:'auto',
				   	   limitToList:true,
				   	   panelMaxHeight:120,
					   buttonIcon:'icon-clear',
			     	   onClickButton:function()
			           {
							$(this).combobox('clear');
			           },
					}
				 },
			    formatter: fun_table_gfc_bud_formatter<?=$time?>
			   },
			   {field:'budi_rate',title:'税率',width:100,halign:'center',align:'right',hidden:true,
			    formatter: fun_table_gfc_bud_formatter<?=$time?>
			   },
			]],
			columns:[[    
			    {field:'budi_sum_start',title:'初始预算额',width:125,halign:'center',align:'right',hidden:true,
	             formatter: fun_table_gfc_bud_formatter<?=$time?>
			    },
			    {field:'budi_sum_alter',title:'变更额',width:125,halign:'center',align:'right',hidden:true,
	             formatter: fun_table_gfc_bud_formatter<?=$time?>
			    },
			    {field:'budi_sum',title:'预算额(含税)',width:125,halign:'center',align:'right',
		    	 editor:{
				   type:'numberbox',
				   options:{
			    	   precision:2,
					   min:0,
					   buttonIcon:'icon-clear',
			     	   onClickButton:function()
			           {
							$(this).numberbox('clear');
			           },
					}
				 },
	             formatter: fun_table_gfc_bud_formatter<?=$time?>
			    },
			    {field:'budi_sum_notax',title:'预算额(不含税)',width:125,halign:'center',align:'right',
	             formatter: fun_table_gfc_bud_formatter<?=$time?>
			    },
			    {field:'budi_sum_final',title:'预算执行',width:125,halign:'center',align:'right',hidden:true,
	             formatter: fun_table_gfc_bud_formatter<?=$time?>
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

							if( index == 2 )
							{
								var budm_id = $("#table_bud_<?=$time?> [oaname='content[gfc_budm_id]']").combobox('getValue');
								$(ed_list[i].target).combobox({
								   valueField: 'id',    
						           textField: 'text',
						           url: 'proc_gfc/gfc/get_json_tax/from/combobox/field_id/t_id/field_text/t_name/search_budm_id/'+budm_id,
						           value : row.budi_name,
						           onSelect:function(record)
						           {
										$('#txtb_gfc_tax<?=$time?>').val(record.id);
										$('#txtb_gfc_tax_name<?=$time?>').val(record.text);
						           },
						           loadFilter:function(data)
								   {
									 	var value = $(this).combobox('getValue');
									 	var data_new = [];
									 	
				    					for(var i =0;i < data.length;i++)
				    					{
				    						if(parseInt(data[i].tax_no_new) != 1 || value == data[i].id)
				    						{
				    							data_new.push(data[i]);
				    						}
				    					}
				    					
				    					return data_new;
								   }
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

							if(row.budi_sum_edit == 0 )
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
					var ed =$(this).datagrid('getEditor',{index:index,field:'budi_name'});
					if( ! ed ) return;
					
					var json_tax = $(ed.target).combobox('getData');

					for(var i=0;i<json_tax.length;i++)
					{
						if(json_tax[i].id == row.budi_name)
						{
							row.budi_rate =  json_tax[i].tax_rate;
							row.budi_name_s = json_tax[i].t_name

							return;
						}
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
				var rows = $('#table_gfc_bud<?=$time?>').datagrid('getRows');
				
				fun_load_cr_link_field<?=$time?>();
				
				fun_count_gfc_bud_cell<?=$time?>('budi_sum;'+rows[1].budi_id);
				
				JSON.parse(JSON.stringify(changes), function (key, value) {  
					fun_count_gfc_bud_cell<?=$time?>(key+';'+row.budi_id);
				});
			},
			onBeforeCellEdit: function(index, field)
			{
				switch(field)
				{
					case 'budi_name':
						
						if(index != 2)
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
			onLoadSuccess: function(data)
			{
				if(data.hr_budi_id) hr_budi_id<?=$time?> = data.hr_budi_id;
				setTimeout('fun_load_gfc_bud_other<?=$time?>();',500);

				load_prog_budi_sum<?=$time?>();
			}
		});  

		$('#table_gfc_bud_sum<?=$time?>').datagrid();

		if( arr_view<?=$time?>.indexOf('content[budi]')>-1 )
		{
			$('#table_gfc_bud_tool<?=$time?> .oa_op').hide();
			$('#table_gfc_bud<?=$time?>').datagrid('disableCellEditing');
		}
		else
		{
			$('#table_gfc_bud<?=$time?>').datagrid('enableCellEditing');
		}

		$('#table_gfc_bud<?=$time?>').datagrid('sort', {	  
			sortName: 'budi_sn',
			sortOrder: 'asc'
		});

		if('<?=$code?>')
		{
			$('#table_gfc_bud<?=$time?>').datagrid('showColumn','budi_sum_final');
		}
    }

    //载入进度条
    function load_prog_budi_sum<?=$time?>()
    {
    	$('#l_<?=$time?> .prog_budi_sum<?=$time?>').progressbar();
		$('#l_<?=$time?> .prog_budi_sum<?=$time?>').find('.progressbar-text').css('text-align','right');
    }

   //计算预算表单元格
	var arr_field_count=[];
	function fun_count_gfc_bud_cell<?=$time?>(field,type)
	{
		if( ! field ) return;
		
		var count = $('#txtb_budm_count<?=$time?>').val();

		if( ! count ) return;

		//计算公式排序
		var arr_tmp = [];

		var rows = $('#table_gfc_bud<?=$time?>').datagrid('getRows');
		
		JSON.parse(count,function(key,value){
			var index = $('#table_gfc_bud<?=$time?>').datagrid('getRowIndex',key.split(';')[1])

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
		
		var field_count = field;
		if(type) field_count = field_count.replace(type,'');
		else
		{
			type = '';
				
			var check = field_count.split(';')[0];
			check = check.replace('budi_sum','');

			if(check && check != '_notax') type = check;
		}

		for (i in arr_tmp)
		{
			var key = arr_tmp[i].field;
			var value = arr_tmp[i].count;

			if( ! value) continue;

			if( type && key.indexOf('budi_sum_notax') > -1 )
		    continue;

			var arr = value.split(',');

			if(arr.indexOf(field_count) > -1)
			{
				var tmp_key = key.split(';')[0]+type+';'+key.split(';')[1];
				
				if(arr_field_count.indexOf(tmp_key) < 0)
				arr_field_count.push(tmp_key);

				var rtn = 0;
				var str_count ='';
				var rows = $('#table_gfc_bud<?=$time?>').datagrid('getRows');
				
				for(var i = 0;i<arr.length;i++)
				{
					if(arr[i] == ';')
						str_count += ';';	
					else if(arr[i].split(';').length == 2)
					{
						var index = $('#table_gfc_bud<?=$time?>').datagrid('getRowIndex',arr[i].split(';')[1]);

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
								if(rows[index]['budi_sum'+type])
								str_count += 'parseFloat('+rows[index]['budi_sum'+type]+')';
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
				var index = $('#table_gfc_bud<?=$time?>').datagrid('getRowIndex',key.split(';')[1]);

				row_rtn[key.split(';')[0]+type] = parseFloat(rtn).toFixed(2);

				$('#table_gfc_bud<?=$time?>').datagrid('updateRow',{
					index: index,
					row: row_rtn
				});
			}
		}

		var i = arr_field_count.indexOf(field);
		if(i > -1) arr_field_count.baoremove(i);

		if(arr_field_count.length>0)
			fun_count_gfc_bud_cell<?=$time?>(arr_field_count[0],type);
	}
	
    //列格式化输出
    function fun_table_gfc_bud_formatter<?=$time?>(value,row,index){

        switch(this.field)
        {
	        case 'budi_ou_show':
	
				value='<span style="font-weight:bold">'+base64_decode(value)+'</span>'
				break;
			case 'budi_sn':
	
				if(value.split('.')[1] == 0)
				value = value.split('.')[0];
				
				break;
			case 'budi_name':

				if(row.budi_name_s) value = row.budi_name_s;
				
				if(index != 2)
				value = base64_decode(value);

				switch(base64_decode(row.budi_name))
				{
					case '收取管理费':
						value+='<br>分包合同总额';
						break;
					case '支付管理费':
						value+='<br>总包合同总额';
						break;
				}
				
				break;
			case 'budi_rate':
				
				value +='%';
				
				break;
			case 'budi_sum_alter':
				if( ! row.budi_sum ) row.budi_sum = 0;
				if( ! row.budi_sum_start ) row.budi_sum_start = 0;
				
				value = parseFloat(row.budi_sum) - parseFloat(row.budi_sum_start);

				if(value > 0)
					value='<span style="color:red;font-weight:bold;">'+num_parse(value)+'</span>';	
				else if(value < 0)
					value='<span style="">'+num_parse(value)+'</span>';
				else
					value='';
				
				break;
			case 'budi_sum_notax':
				if( ! value ) value = row.budi_sum;
			case 'budi_sum_start':
			case 'budi_sum':
	
				if( ! value ) value = 0;
	
				if( index == 0 )
				{
					var sum = $('#txtb_gfc_sum<?=$time?>').numberbox('getValue');
					switch(base64_decode(row.budi_name))
					{
						case '收取管理费':
							sum = parseFloat(sum) - parseFloat(value);
							value = num_parse(value);
							value +='<br><span id="sp_sum_sq<?=$time?>">'+num_parse(sum)+'</span>'
							break;
						case '支付管理费':
							sum = parseFloat(sum) + parseFloat(value);
							value = num_parse(value);
							value +='<br><span id="sp_sum_zf<?=$time?>">'+num_parse(sum)+'</span>'
							break;
					}
				}
				else
				{
					value = num_parse(value);

					if('<?=$code?>' && row.budi_sub_check == 1 && this.field == 'budi_sum')
					{
						var budi_sum = row.budi_sum;
						var budi_sum_final = row.budi_sum_final;
						if( ! budi_sum_final ) budi_sum_final = 0;
						
						var per = parseFloat(budi_sum_final/budi_sum*100).toFixed(2);
						
						value = '<div class="easyui-progressbar prog_budi_sum<?=$time?>" budi_sum_final="'+num_parse(budi_sum_final)+'" data-options="value:'+per+',text:\''+num_parse(budi_sum)+'\'" style="width:100%;" ></div> '
					}
				}
				
				break;
            	
            default:
                if(row[this.field+'_s'])
                    value = row[this.field+'_s'];
        }

        if( ! value ) value = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ;
		return '<span id="table_gfc_bud<?=$time?>_'+index+'_'+this.field+'" class="table_gfc_bud<?=$time?>" >'+value+'</span>';
    }

    function fun_load_gfc_bud_other<?=$time?>()
    {
    	var rows= $('#table_gfc_bud<?=$time?>').datagrid('getRows');
 		if(rows.length < 3) return;
 		
    	var row = {}
		var subc = $('#txtb_gfc_category_subc<?=$time?>').combobox('getValue');
		
		switch(subc)
 		{
 			case '<?=BUDM_TYPE_SUBC_NO?>':
 			row.budi_name = '无';
 			break;
 			case '<?=BUDM_TYPE_SUBC_YES?>':
 			row.budi_name = '收取管理费';
 			break;
 			case '<?=BUDM_TYPE_SUBC_SUB?>':
 			row.budi_name = '支付管理费';
 			break;
 		}

		if(row.budi_name) row.budi_name = base64_encode(row.budi_name);
 		
		$('#table_gfc_bud<?=$time?>').datagrid('updateRow',{
			index : 0,
			row: row
		})
		
		var row = {}
		row.budi_sum = $('#txtb_gfc_sum<?=$time?>').numberbox('getValue');
		row.budi_sum_edit = 0
		
		$('#table_gfc_bud<?=$time?>').datagrid('updateRow',{
			index : 1,
			row: row
		});

		var row = {}
		row.budi_name = $('#txtb_gfc_tax<?=$time?>').val();
		row.budi_name_s = $('#txtb_gfc_tax_name<?=$time?>').val();
		
		$('#table_gfc_bud<?=$time?>').datagrid('updateRow',{
			index : 2,
			row: row
		});
		
//		var json_tax = $('#txtb_budm_tax_type<?=$time?>').val();
//		json_tax = JSON.parse(json_tax);
//		var t_id = $('#txtb_gfc_tax<?=$time?>').val();
//		for(var i = 0;i<json_tax.length;i++)
//		{
//			if(json_tax[i].t_id == t_id)
//			{
//				var row = {}
//				row.budi_name = json_tax[i].tax_name
//				
//				$('#table_gfc_bud<?=$time?>').datagrid('updateRow',{
//					index : 2,
//					row: row
//				});
//				
//				break;
//			}
//		}

		fun_count_gfc_bud_cell<?=$time?>('budi_sum;'+rows[1].budi_id);
		
		fun_load_gfc_bud_sum<?=$time?>();
		
		fun_load_eli_bud_sum<?=$time?>();
    }

    //预算额
    function fun_load_gfc_bud_sum<?=$time?>()
    {
		var data = $('#table_gfc_bud_sum<?=$time?>').datagrid('getRows');
		
		if(data.length == 0) return;
			
		var field = '';
		var rows = $('#table_gfc_bud<?=$time?>').datagrid('getRows');
		
		for(var i=0;i < data.length;i++)
		{
			if( ! data[i].gbud_budi_id && data[i].budi_id)
			{
				data[i].gbud_budi_id = data[i].budi_id;
				data[i].gbud_sum = data[i].budi_sum;
				data[i].gbud_sum_start = data[i].budi_sum_start;
			}
			
			var index = $('#table_gfc_bud<?=$time?>').datagrid('getRowIndex',data[i].gbud_budi_id);

			if( index < 0 ) continue;

			var row = {};
			
			if(index != 1)
			row.budi_sum = data[i].gbud_sum;
			
			row.budi_sum_start = data[i].gbud_sum_start;
			row.budi_sum_final = data[i].gbud_sum_final;
			row.gbud_id = data[i].gbud_id;

			if(index  == 1)
				row.budi_sum_final = data_<?=$time?>['content[gfc_sum_kp]'];
			
			$('#table_gfc_bud<?=$time?>').datagrid('updateRow',{
				index : index,
				row: row
			});

			if(index == 1)
				field = 'budi_sum;'+data[i].gbud_budi_id;
			else if( rows[index].budi_sum_edit == 1)
			{
				arr_field_count.push('budi_sum;'+data[i].gbud_budi_id);
			}
		}
		
		fun_count_gfc_bud_cell<?=$time?>(field);
		
		fun_load_gfc_bud_sum_other<?=$time?>('_final');

		if( ! '<?=$log_time?>') return;
		var log_gfc_bud = {};
		log_gfc_bud['content[gfc_bud]'] = <?=$log_gfc_bud?>;
		fun_show_errmsg_of_form('f_<?=$time?>',log_gfc_bud,1)
    }

    //预算执行
    function fun_load_gfc_bud_sum_other<?=$time?>(type)
    {
        if( ! '<?=$code?>' ) return;
        
		var field = '';
		var rows = $('#table_gfc_bud<?=$time?>').datagrid('getRows');
		
		for(var i=0;i < rows.length;i++)
		{
			var index = $('#table_gfc_bud<?=$time?>').datagrid('getRowIndex',rows[i].budi_id);
			
			if(index == 1)
				field = 'budi_sum'+type+';'+rows[i].budi_id;
			else
			{
				arr_field_count.push('budi_sum'+type+';'+rows[i].budi_id);
			}
		}
		
    	fun_count_gfc_bud_cell<?=$time?>(field,type);
    }
</script>