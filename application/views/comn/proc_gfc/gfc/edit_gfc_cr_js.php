<!-- 加载jquery -->
<script type="text/javascript">

	//合同总额
	function load_gfc_cr_sum<?=$time?>()
	{
		$('#txtb_gfc_cr_sum<?=$time?>').numberbox('textbox').css('text-align','right');
	}

	//预计成本
	function load_gfc_cr_sum_cb<?=$time?>()
	{
		$('#txtb_gfc_cr_sum_cb<?=$time?>').numberbox('textbox').css('text-align','right');
	}

	//分包金额
	function load_gfc_subc_sum<?=$time?>()
	{
		$('#txtb_gfc_subc_sum<?=$time?>').numberbox('textbox').css('text-align','right');
	}

    //指定评审人--载入
    var flag_load_cr<?=$time?> = 0;
    function load_table_gfc_cr<?=$time?>()
    {
        $('#table_gfc_cr<?=$time?>').edatagrid({
            width:'100%',
            height:'auto',
            toolbar:'#table_gfc_cr_tool<?=$time?>',
            singleSelect:true,
            selectOnCheck:false,
            checkOnSelect:false,
            striped:true,
            idField:'gfcc_id',
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
			groupField:'cr_ppo',
			groupFormatter: function(value,rows)
			{
    			if( ! value ) value = '?';
				return '第'+value+'阶段';
			},
            remoteSort: false,
            multiSort:true,
            columns:[[
				{field:'gfcc_id',title:'',width:50,align:'center',checkbox:true},
				{field:'gfcc_cr_id',title:'评审内容',width:250,halign:'center',align:'left',
				    formatter: fun_table_gfc_cr_formatter<?=$time?>,
				    editor:{
						type:'combobox',
						options:{
				    		required:true,
				    		valueField:'id',    
				    	    textField:'text' ,  
				    	    panelHeight:'auto',
				    	    panelMaxHeight:150,
				    		formatter: function(row){
								return row['text'].replace('(','<br>(');
							},
				//			icons:[{
				//			   iconCls:'icon-clear',
				//				handler: function(e){
				//					$(e.data.target).combobox('clear');
				//				}
				//		   }]
						}
					}
				},
				{field:'gfcc_c_id',title:'评审人',width:120,halign:'center',align:'center',
				    formatter: fun_table_gfc_cr_formatter<?=$time?>,
				    editor:{
						type:'combobox',
						options:{
				    		required:true,
				        	valueField:'id',    
				    	    textField:'text' ,
				    	    panelHeight:'auto',
				    	    panelMaxHeight:150,
				    	    buttonIcon:'icon-clear',
				     	    onClickButton:function()
				            {
								$(this).combobox('clear');
				            },
						}
					}
				},
				{field:'gfcc_ou',title:'评审部门',width:120,halign:'center',align:'center',
				 formatter: fun_table_gfc_cr_formatter<?=$time?>,
				 editor:{
						type:'textbox',
						options:{
						readonly:true,
						icons:[{
							   iconCls:'icon-lock',
						}]
				    }
				 }
				},
				{field:'gfcc_result',title:'评审结果',width:100,halign:'center',align:'center',
				    formatter: fun_table_gfc_cr_formatter<?=$time?>,
				    editor:{
						type:'combobox',
						options:{
				    		data: [<?=element('gfcc_result',$json_field_define)?>],
				    		panelHeight:'auto',
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
				{field:'cr_sn',title:'排序',width:50,halign:'center',align:'center',sortable:true,hidden:true,
				 sorter:function(a,b){  
					a = parseInt(a);
					b = parseInt(b);
					return (a>b?1:-1);  
				 },
				 editor:{
 					type:'textbox',
 					options:{
						readonly:true,
						icons:[{
 						   iconCls:'icon-lock',
						}]
                    }
                 }
				},
				{field:'cr_ppo',title:'评审阶段',width:50,halign:'center',align:'center',sortable:true,hidden:true,
				 sorter:function(a,b){  
					a = parseInt(a);
					b = parseInt(b);
					return (a>b?1:-1);  
				 },
				 editor:{
 					type:'textbox',
 					options:{
						readonly:true,
						icons:[{
 						   iconCls:'icon-lock',
						}]
                    }
                 }
				},
				{field:'cr_pass_alter',title:'修改后通过',width:50,halign:'center',align:'center',sortable:true,hidden:true,
				 sorter:function(a,b){  
					a = parseInt(a);
					b = parseInt(b);
					return (a>b?1:-1);  
				 },
				 editor:{
 					type:'textbox',
 					options:{
						readonly:true,
						icons:[{
 						   iconCls:'icon-lock',
						}]
                    }
                 }
				},
				{field:'gfcc_comment',title:'评审意见',width:120,halign:'center',align:'center',
				    formatter: fun_table_gfc_cr_formatter<?=$time?>,
				},
            ]],
//            frozenColumns:[[
//            ]],
            rowStyler: function(index,row){
                if (row.act == <?=STAT_ACT_CREATE?>)
                    return 'background:#ffd2d2';
                if (row.act == <?=STAT_ACT_REMOVE?>)
                    return 'background:#e0e0e0';

               	//评审阶段，当前登录人评审项标红
                if ( ! '<?=$log_time?>' 
                  && ! row.act && '<?=$ppo?>' == <?=GFC_PPO_REVIEW?> 
                  && row.cr_ppo == '<?=$min_ppo?>' 
                  && row.gfcc_c_id == '<?=$this->sess->userdata('c_id')?>' )
                	return 'background:#ffd2d2';

            },
            onBeforeLoad: function(data)
            {
				if( ! flag_load_cr<?=$time?>) return false;
            },
            onLoadSuccess: function(data)
            {
            	//load_table_gfc_cr_file<?=$time?>();

            	fun_load_cr_link_field<?=$time?>();
            },
            onClickCell: function(index, field, value)
            {
                var rows = $(this).datagrid('getRows');
                var row = rows[index];
            	if( field == 'gfcc_comment'
                &&( row.gfcc_comment
                    ||
                    (  '<?=$ppo?>' == <?=GFC_PPO_REVIEW?>
	                 && row.cr_ppo == '<?=$min_ppo?>'
	                 && row.gfcc_c_id == '<?=$this->sess->userdata('c_id')?>') 
                  )
                ) 
				{
            		fun_open_win_cr_editor<?=$time?>(row.gfcc_id);
				}
            },
            onBeforeEdit: function(index,row)
            {
            	if( '<?=$ppo?>' == <?=GFC_PPO_REVIEW?> ) 
				{
    				if( ! row.gfcc_cr_id)
        			return true;

    				if( row.gfcc_c_id_start != '<?=$this->sess->userdata('c_id') ?>' && '<?=$min_ppo?>' != 1 )
					return false;

    				if( row.cr_ppo != '<?=$min_ppo?>' && '<?=$min_ppo?>' != 1 )
    				return false;
				}
            },
            onBeginEdit: function(index,row)
            {
            	var ed_list=$(this).datagrid('getEditors',index);

            	var ed_gfcc_cr_id = '';
            	var ed_gfcc_c_id = '';
            	var ed_gfcc_ou = '';
            	var ed_gfcc_result = '';
            	var ed_cr_sn = '';
            	var ed_cr_ppo = '';
            	var ed_cr_pass_alter = '';
            	
    			for(var i = 0;i < ed_list.length; i++)
    			{
    				switch(ed_list[i].field)
    				{
    					case 'gfcc_cr_id':

    						ed_gfcc_cr_id = ed_list[i].target;

    						if( row.gfcc_default == 1 
    	    				 || ('<?=$ppo?>' == <?=GFC_PPO_REVIEW?> && row.gfcc_cr_id) 
    	    				 || row.cr_link_field )
							{
								$(ed_list[i].target).combobox({
									readonly:true,
									buttonIcon:'icon-lock',
						     	    onClickButton:function()
						            {
						            },
								})
							}
    						
        					break;
    					case 'gfcc_c_id':

    						ed_gfcc_c_id = ed_list[i].target;
    						
        					break;
    					case 'gfcc_ou':

    						ed_gfcc_ou = ed_list[i].target;
    						
        					break;
						case 'gfcc_result':

							if( '<?=$ppo?>' != <?=GFC_PPO_REVIEW?>
							|| row.gfcc_c_id != '<?=$this->sess->userdata('c_id');?>'
							|| row.cr_ppo != '<?=$min_ppo?>') 
							{
								$(ed_list[i].target).combobox({
									readonly:true,
									buttonIcon:'icon-lock',
						     	    onClickButton:function()
						            {
						            },
								})
							}
							else
							{
								
								$(ed_list[i].target).combobox('textbox').bind('focus',
								function(){
									$(this).parent().prev().combobox('showPanel');
								});
							}

							var ed_gfcc_result = ed_list[i].target;
							
	    					break;
						case 'cr_sn':

    						ed_cr_sn = ed_list[i].target;
    						
        					break;
						case 'cr_ppo':

    						ed_cr_ppo = ed_list[i].target;
    						
        					break;
						case 'cr_pass_alter':
							ed_cr_pass_alter = ed_list[i].target;
    						
        					break;
						case 'gfcc_comment':
    						
        					break;
    				}
    			}

    			var gfc_ou = $('#txtb_gfc_ou<?=$time?>').val();
				var gfc_category_main = $('#txtb_gfc_category_main<?=$time?>').combobox('getValue');
    			var url = 'proc_gfc/cr/get_json/from/combobox/field_id/cr_id/field_text/cr_name';

    			if( ! row.gfcc_cr_id )
    			url += '/search_cr_ppo_min/<?=$min_ppo?>';
        				
    			if(! row.gfcc_cr_id && gfc_category_main)
				url += '/search_gfc_category_main/'+gfc_category_main;

				if( ! row.gfcc_cr_id && gfc_ou)
				url += '/search_gfc_ou/'+gfc_ou;

//				if(row.gfcc_cr_id)
//				url += '/search_cr_id/'+row.gfcc_cr_id;

    			$(ed_gfcc_cr_id).combobox('reload',url);
    			
    			$(ed_gfcc_cr_id).combobox({
					onSelect:function(record)
					{
						var url = 'proc_gfc/cr/get_json_crp/from/combobox/field_id/c_id/field_text/c_name/search_cr_id/'+record.id;

						var gfc_ou = $('#txtb_gfc_ou<?=$time?>').val();
						var gfc_category_main = $('#txtb_gfc_category_main<?=$time?>').combobox('getValue');
						
						if(gfc_category_main)
						url += '/search_gfc_category_main/'+gfc_category_main;

						if(gfc_ou)
						url += '/search_gfc_ou/'+gfc_ou;

    					$(ed_gfcc_c_id).combobox('reload',url);
    					$(ed_cr_sn).textbox('setValue',base64_decode(record.cr_sn));
    					$(ed_cr_ppo).textbox('setValue',base64_decode(record.cr_ppo))
    					$(ed_cr_pass_alter).textbox('setValue',base64_decode(record.cr_pass_alter))

					},
	    			onChange: function(nV,oV)
					{
						if( nV != oV && nV)
						{
							$(ed_gfcc_c_id).combobox('clear');
						}
					}
        		});

    			if(row.gfcc_cr_id)
    			$(ed_gfcc_cr_id).combobox('setValue',row.gfcc_cr_id)

    			var opt_cr_id = $(ed_gfcc_cr_id).combobox('options');
    			if(row.gfcc_default != 1 && opt_cr_id.readonly != true)
				{
	    			$(ed_gfcc_cr_id).combobox('textbox').bind('focus',
					function(){
						$(this).parent().prev().combobox('showPanel');
					});
				}

    			$(ed_gfcc_c_id).combobox({
					onSelect:function(record)
					{
    					$(ed_gfcc_ou).textbox('setValue',base64_decode(record.ou_name));
					}
        		});

    			$(ed_gfcc_c_id).combobox('setValue',row.gfcc_c_id)
    			
    			if( '<?=$ppo?>' == <?=GFC_PPO_REVIEW?> 
    			 && ( (row.gfcc_c_id_start && row.gfcc_c_id_start != '<?=$this->sess->userdata('c_id') ?>' && ('<?=$min_ppo?>' != 1 || row.gfcc_result) ) )
    			)
    			{
    				$(ed_gfcc_c_id).combobox({
						readonly:true,
						icons:[{
 						   iconCls:'icon-lock',
						}]
					})
    			}
    			else
    			{
	    			$(ed_gfcc_c_id).combobox('textbox').bind('focus',
	    			function(){
	    				$(this).parent().prev().combobox('showPanel');
	    			});
    			}

    			$(ed_gfcc_result).combobox({
    				loadFilter:function(data)
					{
					 	var value = $(this).combobox('getValue');
					 	var data_new = [];
					 	var arr = [1,2,3];

					 	var cr_pass_alter = $(ed_cr_pass_alter).textbox('getValue');
					 	if( cr_pass_alter  != 1 ) arr = [1,2]; 
					 	
	   					for(var i =0;i < data.length;i++)
	   					{
	   						if(arr.indexOf( parseInt(data[i].id) ) > -1 || value == data[i].id)
	   						{
	   							data_new.push(data[i]);
	   						}
	   					}
	   					
	   					return data_new;
					}
				})
				
				$(ed_gfcc_result).combobox('setValue',row.gfcc_result);
            },
            onEndEdit: function(index, row, changes)
            {
            	var ed_list=$(this).datagrid('getEditors',index);

    			for(var i = 0;i < ed_list.length; i++)
    			{
    				switch(ed_list[i].field)
    				{
	    				case 'gfcc_cr_id':
	
							row.gfcc_cr_id_s = $(ed_list[i].target).combobox('getText');
							
	    					break;
						case 'gfcc_c_id':
	
							row.gfcc_c_id_s = $(ed_list[i].target).combobox('getText');
							
	    					break;
						case 'gfcc_result':
							
							row.gfcc_result_s = $(ed_list[i].target).combobox('getText');
							
	    					break;
    				}
    			}

    			if(changes.gfcc_cr_id)
    			load_table_gfc_cr_file<?=$time?>();

    			$(this).datagrid('sort', {	       
    				sortName: 'cr_sn',
    				sortOrder: 'asc'
    			});
            },
        });

        if( arr_view<?=$time?>.indexOf('content[gfc_cr]')>-1 )
        {
        	$('#table_gfc_cr<?=$time?>').edatagrid('disableEditing');
            $('#table_gfc_cr_tool<?=$time?> .oa_op').hide();
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
    function fun_table_gfc_cr_formatter<?=$time?>(value,row,index){

        switch(this.field)
        {
        	case 'gfcc_cr_id':
        		value =  row[this.field+'_s'];
        		if(value)
        		value = value.replace('(','<br>(');
            	break;
           	case 'gfcc_comment':
               	
				if(value) value = '评审意见';

				if(row.gfcc_comment_return) value+= '及反馈';

				if(value)
				value = '<a href="javascript:void(0)" class="link" >'+value+'</a>';
		        break;
            default:
                if(row[this.field+'_s'])
                    value = row[this.field+'_s'];
        }

        if( ! value ) value = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ;
        return '<span id="table_gfc_cr<?=$time?>_'+index+'_'+this.field+'" class="table_gfc_cr<?=$time?>" >'+value+'</span>';
    }

    //评审意见及反馈
    function fun_open_win_cr_editor<?=$time?>(gfcc_id)
    {
    	var index = $('#table_gfc_cr<?=$time?>').datagrid('getRowIndex',gfcc_id);
        var rows = $('#table_gfc_cr<?=$time?>').datagrid('getRows');
        var row = rows[index];
        
    	var win_id=fun_get_new_win();

		var width = 800;
		if(body_width < width )
		width=body_width-50;

		var height = 300;

		if( '<?=$ppo?>' == <?=GFC_PPO_START?> || row.gfcc_comment_return)
		height = 500; 
		
		if(body_height - 150 < height )
		height=body_height - 200;

		var index_gfcc_comment = index;

		var editor_height = height 
		if( '<?=$ppo?>' == <?=GFC_PPO_START?> || row.gfcc_comment_return)
			editor_height = height / 2
			
		var content = '<textarea id="gfcc_comment<?=$time?>" have_focus="" time="<?=$time?>" class="oa_op oa_editor" style="width:'+(width-5)+'px;height:'+(editor_height-5)+'px;"></textarea>';

		var field = 'gfcc_comment'
		var check_editor = true;

		if( '<?=$ppo?>' == '<?=GFC_PPO_START?>')
		{
			content='<span style="font-size:14px;">评审意见:</span><br><div style="width:100%;max-height:'+editor_height+'px;font-size:14px;">'+base64_decode(row.gfcc_comment)+'</div>'+content;
			field = 'gfcc_comment_return';
		}
		else if( '<?=$ppo?>' == '<?=GFC_PPO_REVIEW?>' && row.gfcc_comment_return)
		{
			content += '<span style="font-size:14px;">反馈:</span><br><div style="width:100%;max-height:'+editor_height+'px">'+base64_decode(row.gfcc_comment_return)+'</div>';
		}
		else if( ('<?=$ppo?>' != '<?=GFC_PPO_START?>' && '<?=$ppo?>' != '<?=GFC_PPO_REVIEW?>')
				|| (row.cr_ppo != '<?=$min_ppo?>')
				|| ! ( '<?=$ppo?>' == '<?=GFC_PPO_REVIEW?>' 
			        && row.cr_ppo == '<?=$min_ppo?>'
			        && row.gfcc_c_id == '<?=$this->sess->userdata('c_id')?>'
					) 
		)
		{
			check_editor = false;
			content='<span style="font-size:14px;">评审意见:</span><br><div style="width:100%;max-height:'+editor_height+'px;">'+base64_decode(row.gfcc_comment)+'</div>';
			if(row.gfcc_comment_return)
			content += '<span style="font-size:14px;">反馈:</span><br><div style="width:100%;max-height:'+editor_height+'px;font-size:14px;">'+base64_decode(row.gfcc_comment_return)+'</div>';
		}

			
		var gfcc_comment = '';
		if(row[field]) gfcc_comment = base64_decode(row[field]);
		
		$('#'+win_id).window({
			title: '评审意见及反馈',
			inline:true,
			modal:true,
			width:width,
			height:height,
			content:content,
			border:'thin',
			draggable:false,
			resizable:false,
			collapsible:false,
			minimizable:false,
			maximizable:false,
			onOpen: function()
			{
				var row_s = $('#table_gfc_cr<?=$time?>').datagrid('getSelected');
				var index_s = $('#table_gfc_cr<?=$time?>').datagrid('getRowIndex',row_s);

				if( index_s > -1)
				{
					$('#table_gfc_cr<?=$time?>').datagrid('endEdit',index_s);
				}
			},
			onClose: function()
			{
				if(check_editor)
				{
					var gfcc_comment = self<?=$time?>.ue_gfcc_comment.getContent();
					
					var row = {};
					row[field] = '';
					if(gfcc_comment)
					row[field] = base64_encode(gfcc_comment);
					
					$('#table_gfc_cr<?=$time?>').datagrid('updateRow',{
						index: index_gfcc_comment,
						row:row
					})
	
					self<?=$time?>.ue_gfcc_comment.destroy();

					$('#table_gfc_cr<?=$time?>').datagrid('beginEdit',index);
					$('#table_gfc_cr<?=$time?>').datagrid('cancelEdit',index);
				}

				$('#'+win_id).window('clear');
				$('#'+win_id).window('destroy');
				$('#'+win_id).remove();
			}
		})
		
		if(check_editor)
		{
			self<?=$time?>.ue_gfcc_comment = UE.getEditor('gfcc_comment<?=$time?>',{
	       		toolbars:[ueditor_tool['simple']],
	       		autoHeightEnabled:false,
	       		elementPathEnabled: false, //删除元素路径
	       		//autoClearinitialContent:true,
	       		enableAutoSave :false,
	       		initialFrameHeight: editor_height-70,
	       		//initialContent:gfcc_comment,
	       		wordCount: false  
	       		});
	   		
	   		self<?=$time?>.ue_gfcc_comment.ready(function(){
	   		    self<?=$time?>.isloadedUE = true;

	   		    gfcc_comment=gfcc_comment.replace(/data-original/g, "src")
	   		    self<?=$time?>.ue_gfcc_comment.setContent(gfcc_comment);
		       		    
	   		    //default font and color
	   		    UE.dom.domUtils.setStyles(self<?=$time?>.ue_gfcc_comment.body, {
	   		    'font-family' : "宋体", 'font-size' : '14px'
	   		    });
	   		    
	   		});
		}

		$('#'+win_id+' .lazy').lazyload({
			event: 'click',
			placeholder : "img/grey.gif"
		});

    }
    
    //合同评审人--操作
    function fun_table_gfc_cr_operate<?=$time?>(btn)
    {
        switch(btn)
        {
            case 'add':

            	var op_id = get_guid();
    			$('#table_gfc_cr<?=$time?>').edatagrid('addRow',{
    				row:{
    					gfcc_id: op_id,
    					gfcc_c_id_start : '<?=$this->sess->userdata('c_id')?>',
    					db_person_create: '<?=$this->sess->userdata('c_id')?>'
    				}
    			});

                break;
            case 'del':

                var op_list=$('#table_gfc_cr<?=$time?>').datagrid('getChecked');

                var row_s = $('#table_gfc_cr<?=$time?>').datagrid('getSelected');
                var index_s = $('#table_gfc_cr<?=$time?>').datagrid('getRowIndex',row_s);

                if($('#table_gfc_cr<?=$time?>').datagrid('validateRow',index_s))
                {
                    $('#table_gfc_cr<?=$time?>').datagrid('endEdit',index_s);
                }
                else
                {
                    $('#table_gfc_cr<?=$time?>').datagrid('cancelEdit',index_s);
                }

                for(var i=op_list.length-1;i>-1;i--)
                {
                    if( ( op_list[i].gfcc_default == 1 && op_list[i].cr_person_empty != 1 ) 
                      || op_list[i].gfcc_result
                      || op_list[i].cr_link_field) 
                        continue;

                    if( '<?=$min_ppo?>' > 1 
                      && op_list[i].db_person_create != '<?=$this->sess->userdata('c_id')?>' )
                    	continue;
                    
                    var index = $('#table_gfc_cr<?=$time?>').datagrid('getRowIndex',op_list[i]);
                    $('#table_gfc_cr<?=$time?>').datagrid('deleteRow',index);
                }

                load_table_gfc_cr_file<?=$time?>();

                break;
        }

    }

    //判断关联字段评审项是否存在
    function fun_check_cr_link_field(field)
    {
		var rows =  $('#table_gfc_cr<?=$time?>').datagrid('getRows');

		var check = '';
		
		for(var i=0;i<rows.length;i++)
		{
			if(rows[i].cr_link_field == field)
			{
				check = $('#table_gfc_cr<?=$time?>').datagrid('getRowIndex',rows[i]);
				break;
			}
		}

		return check;
    }

    //加载关联评审项
    function load_cr_of_link_field(field,act)
    {
        if(act == 'add')
        {
	    	var gfc_ou = $('#txtb_gfc_ou<?=$time?>').val();
			var gfc_category_main = $('#txtb_gfc_category_main<?=$time?>').combobox('getValue');
			var url = 'proc_gfc/cr/get_json/search_cr_link_field/'+field;
	
			if(gfc_category_main)
			url += '/search_gfc_category_main/'+gfc_category_main;
	
			if(gfc_ou)
			url += '/search_gfc_ou/'+gfc_ou;
			
			$.ajax({
		        url:url,
		        type:"POST",
		        async:false,
		        data:{ },
		        success:function(data){
			       var json = JSON.parse(data);
			    	
			       var rows = json.rows
			       if(rows.length > 0)
			       {
				      for(var i=0;i<rows.length;i++)
				      {
					      rows[i].cr_person_empty = 0;
				    	  $('#table_gfc_cr<?=$time?>').edatagrid('appendRow',rows[i]);
				      }
			       }
				}
		    });
        }
        else
        {
        	var rows =  $('#table_gfc_cr<?=$time?>').datagrid('getRows');
    		for(var i=rows.length-1;i>-1;i--)
    		{
    			if (rows[i].cr_link_field == field  )
    			{
        			var index = $('#table_gfc_cr<?=$time?>').datagrid('getRowIndex',rows[i]);
        			if(index > -1) $('#table_gfc_cr<?=$time?>').datagrid('deleteRow',index);
    			}
    		}
        }
    }

  	//评审文件
    function load_table_gfc_cr_file<?=$time?>()
    {
    	var rows=$('#table_gfc_cr<?=$time?>').datagrid('getRows');
    	
    	var arr_cr = [];
    	
        for(var i=0;i<rows.length;i++)
        {
        	arr_cr.push(rows[i].gfcc_cr_id);
        }

        var data_form = fun_get_data_from_f('f_<?=$time?>');
        
        $('#table_gfc_cr_file<?=$time?>').datagrid({
            width:'100%',
            height:'100',
            singleSelect:true,
            selectOnCheck:false,
            checkOnSelect:false,
            striped:true,
            showHeader:false,
            url:'proc_gfc/gfc/get_json_cr_file',
            queryParams: {
            	cr_id: arr_cr.join(','),
            	gfc_id: '<?=$gfc_id?>',
            	gfc_category_contract: data_form['content[gfc_category_contract]']
        	},
            columns:[[
            	{field:'file1',title:'',width:'25%',halign:'center',align:'center',
                 formatter: fun_table_gfc_cr_file_formatter<?=$time?>,
                },
                {field:'file2',title:'',width:'25%',halign:'center',align:'center',
                 formatter: fun_table_gfc_cr_file_formatter<?=$time?>,
                },
                {field:'file3',title:'',width:'25%',halign:'center',align:'center',
                 formatter: fun_table_gfc_cr_file_formatter<?=$time?>,
                },
                {field:'file4',title:'',width:'25%',halign:'center',align:'center',
                 formatter: fun_table_gfc_cr_file_formatter<?=$time?>,
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
                
            },
            onBeforeLoad: function(param)
            {
				if( ! param.cr_id) return false;

				if( ! '<?=$gfc_id?>' ) return false;
					
				var gfc_secret = $('#txtb_gfc_category_secret<?=$time?>').combobox('getValue');
                if( gfc_secret != 0 )
                {
                	$('#table_gfc_cr_file<?=$time?>').datagrid('loadData',[]);
					return false;
                }
            }
        });

    }

    //列格式化输出
    function fun_table_gfc_cr_file_formatter<?=$time?>(value,row,index){

    	value = base64_decode(value);
    	
    	if(value && row[this.field+'_sum'])
    	{
    		value = '<a href="javascript:void(0);" class="link" title="查看文件" onclick="fun_win_gfc_file_open<?=$time?>(\'view\',\''+row[this.field+'_id']+'\',\''+value+'\',\'cr\')">'+value+'</a>';
    	}
    	else if(value)
    	{
    		value = '<a href="javascript:void(0);" class="link" style="color:red" title="上传文件" onclick="fun_win_gfc_file_open<?=$time?>(\'add\',\''+row[this.field+'_id']+'\',\''+value+'\',\'cr\')">'+value+'</a>';
    	}
    	
        return value;
    }

    //关联字段评审项
    function fun_load_cr_link_field<?=$time?>()
   	{
    	var rows = $('#table_gfc_eli<?=$time?>').datagrid('getRows');
    	
    	var check_sum = rows.length;
    	var check_cr_link_field = fun_check_cr_link_field(1);

		if(check_sum && check_cr_link_field == '')
		{
			load_cr_of_link_field(1,'add');
		}
		else if( ! check_sum && check_cr_link_field != '')
		{
			load_cr_of_link_field(1,'del')
		}
    	    	
    	var rows = $('#table_gfc_bud<?=$time?>').datagrid('getRows');

		if(hr_budi_id<?=$time?>)
		{
			var hr_index = $('#table_gfc_bud<?=$time?>').datagrid('getRowIndex',hr_budi_id<?=$time?>);

			if(hr_index > -1  )
			{
				var check_cr_link_field = fun_check_cr_link_field(2);
				var sum = parseFloat(rows[hr_index].budi_sum);
				
				if(sum > 0 && check_cr_link_field == '' )
					load_cr_of_link_field('2','add');
				else if(sum == 0 && check_cr_link_field != '' )
					load_cr_of_link_field('2','del');
			}
		}
    }

</script>