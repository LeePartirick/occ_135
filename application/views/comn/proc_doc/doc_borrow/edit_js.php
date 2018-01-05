<!-- 加载jquery -->
<script type="text/javascript"><!--

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

        //载入借领档案
        load_table_docb_borrow<?=$time?>();

     	//载入预约信息
    	load_table_book_info<?=$time?>();
        
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

                    param['content[docb_borrow]']=data_form['content[docb_borrow]'];

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
                    
					//档案已借出
                    if(json.err.doci_out)
    				{
    					$.messager.confirm('确认',json.err.doci_out,function(r){
    					    if (r){    
    						    
    						    if($('#doci_out<?=$time?>').length == 0 )
        						{
    						    	$('#table_f_<?=$time?>').after('<input id="doci_out<?=$time?>" type="hidden" name="content[doci_out]" value="1"/>');
        						}
    						    else{
        						    $('#doci_out<?=$time?>').val(1)
        						}
    						    	
    						    f_submit_<?=$time?>(btn)
    						}    
    					});  

    					return;
    				}

					//预约时间有误
                    if(json.err.doci_time)
    				{
    					$.messager.show({
    				    	title:'警告',
    				    	msg: json.err.doci_time,
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

                    if(json.err.docb_diff)
    				{
    					$.messager.show({
    				    	title:'警告',
    				    	msg: json.err.docb_diff,
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

                  	//档案未回
                    if(json.err.doci_notback)
    				{
    					$.messager.show({
    				    	title:'警告',
    				    	msg: json.err.doci_notback,
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
                            url+='/act/<?=STAT_ACT_EDIT?>/docb_id/'+json.id

                            fun_send_wl(json);
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

                            switch(btn)
    						{
    							case 'yj':
    								url=url.replace('/act/2','/act/3');
    							case 'next':
    							case 'pnext':
    								fun_send_wl(json);
    								reload_page<?=$time?>(url);	
    							break;
    						}
                        }
                    }
                }
            }
        });
    }

	//借阅人自动补全
    function load_docb_c_id<?=$time?>(){
        var op=$('#txtb_docb_c_id_s<?=$time?>').textbox('options');
        if(op.readonly){
            return
        }
        $('#txtb_docb_c_id_s<?=$time?>').textbox('textbox').autocomplete({
            serviceUrl: 'base/auto/get_json_contact/search_c_login_id/1',
            param:{rows:10},
            onSelect:function(suggestion){
            	 
                $("#table_f_<?=$time?> [oaname='content[docb_c_id_s]']").textbox('setValue',base64_decode(suggestion.data.c_show))
                $("#table_f_<?=$time?> [oaname='content[docb_c_id]']").val(base64_decode(suggestion.data.c_id))

                $("#table_f_<?=$time?> [oaname='content[docb_c_ou_s]']").textbox('setValue',base64_decode(suggestion.data.c_ou_bud_s));
                $("#table_f_<?=$time?> [oaname='content[docb_c_ou]']").val(base64_decode(suggestion.data.c_ou_bud));

                $("#table_f_<?=$time?> [oaname='content[docb_c_org]']").val(base64_decode(suggestion.data.c_org));
            }
        })
    }
    
    //部门自动补全
    function load_docb_c_ou<?=$time?>()
    {
        var opt = $('#txtb_docb_c_ou_s<?=$time?>').textbox('options');

        if(  opt.readonly ) return;

        $('#txtb_docb_c_ou_s<?=$time?>').textbox({
            onClickButton:function()
            {
                $(this).textbox('clear');
                $('#txtb_docb_c_ou<?=$time?>').val('');
            }
        });
        var docb_org = $('#txtb_docb_c_org<?=$time?>').val();

        var json = [
            {"field":"ou_org","rule":"=","value":docb_org},
            {"field":"ou_tag","rule":"find_in_set","value":"1"}
        ]

        $('#txtb_docb_c_ou_s<?=$time?>').textbox('textbox').autocomplete({
            serviceUrl: 'base/auto/get_json_ou',
            width:'400',
            params:{
                rows:10,
                data_search:JSON.stringify(json)
            },
            onSelect: function (suggestion) {

                var ou_id = base64_decode(suggestion.data.ou_id);

                $("#table_f_<?=$time?> [oaname='content[docb_c_ou_s]']").textbox('setValue',base64_decode(suggestion.data.ou_name));
                $("#table_f_<?=$time?> [oaname='content[docb_c_ou]']").val(ou_id);
            },

        });

    }

    //借阅档案
    function load_table_docb_borrow<?=$time?>()
    {
    	$('#table_docb_borrow<?=$time?>').edatagrid({
            width:'100%',
            height:'200',
            toolbar:'#table_docb_borrow_tool<?=$time?>',
            singleSelect:true,
            selectOnCheck:false,
            checkOnSelect:false,
            striped:true,
            idField:'id',
            data: [],
            remoteSort: false,
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
            frozenColumns:[[
                {field:'id',title:'',width:50,align:'center',checkbox:true},
                {field:'doci_id',title:'档案名称',width:300,halign:'center',align:'left',
                    formatter: fun_table_docb_borrow_formatter<?=$time?>,
                    editor:{
    					type:'combobox',
    					options:{
    	            		panelHeight:'0',
    						required:true,
    						valueField: 'id',    
                            textField: 'text', 
                            hasDownArrow:false, 
                            buttonIcon:'icon-clear',
    				    	onClickButton:function()
    				        {
    							$(this).combobox('clear');
    				        },
					   		icons: [{
				                iconCls:'icon-search',
				                handler: function(e){
	
				                    var win_id=fun_get_new_win();
	
				                    $('#'+win_id).window({
				                        title: '请选择档案',
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
	
				                    $('#'+win_id).window('refresh','proc_doc/doci/index/fun_open/window/fun_open_id/'+win_id+'/flag_select/2/fun_select/fun_get_doci_id<?=$time?>');
				                    $('#'+win_id).window('center');
				                }
			            	}]
    					}
    				}
                },
                {field:'doci_page_have',title:'应有页数',width:80,halign:'center',align:'right',
                    formatter: fun_table_docb_borrow_formatter<?=$time?>,
                    editor:{
    					type:'numberbox',
    					options:{
    						readonly:true,
    						icons:[{
    						   iconCls:'icon-lock',
    					   }]
    					}
    				}
                },
                {field:'doci_page_now',title:'实际页数',width:80,halign:'center',align:'right',
                    formatter: fun_table_docb_borrow_formatter<?=$time?>,
                    editor:{
    					type:'numberbox',
    				}
                },
                {field:'doci_org',title:'所属公司',width:200,halign:'center',align:'left',
                    formatter: fun_table_docb_borrow_formatter<?=$time?>,
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
            ]],
            rowStyler: function(index,row){
                if (row.act == <?=STAT_ACT_CREATE?>)
                    return 'background:#ffd2d2';
                if (row.act == <?=STAT_ACT_REMOVE?>)
                    return 'background:#e0e0e0';
                if (row.hide){
    				return 'display:none'; 
    			}
            },
            onLoadSuccess: function(data)
            {
                
            },
            onBeginEdit: function(index,row)
            {
            	var ed_list=$(this).datagrid('getEditors',index);

            	var ed_doci_id = '';
            	var ed_doci_page_have = '';
            	var ed_doci_page_now = '';
            	var ed_doci_org = '';
            	
    			for(var i = 0;i < ed_list.length; i++)
    			{
    				switch(ed_list[i].field)
    				{
    					case 'doci_id':

    						ed_doci_id = ed_list[i].target;

    						if(row.doci_id) $(ed_list[i].target).combobox('setValue',row.doci_id);
    						if(row.doci_id_s) $(ed_list[i].target).combobox('setText',row.doci_id_s);

    						break;
    					case 'doci_page_have':

    						ed_doci_page_have = ed_list[i].target;
    						break;
    					case 'doci_page_now':

    						ed_doci_page_now = ed_list[i].target;
    						if( <?=$ppo?> == <?=DOC_BORROW_PPO_BACK?>)
    						{
    							$(ed_doci_page_now).numberbox({"readonly":false,
        														'buttonIcon':'icon-clear',
																'onClickButton':function(){$(this).numberbox('clear');}});
    						}else{
    							$(ed_doci_page_now).numberbox({"readonly":true,'iconCls':'icon-lock'});
        					}
    						break;
    					case 'doci_org':

    						ed_doci_org = ed_list[i].target;

    						if(row.doci_org_s) $(ed_list[i].target).textbox('setText',row.doci_org_s);
    						
    						break;
    				}
    			}

    			$(ed_doci_id).combobox('textbox').autocomplete({
    				serviceUrl: 'base/auto/get_json_file',
    				width:'300',
    				params:{
    					rows:10,
    				},
    				onSelect: function (suggestion) {
    					var doci_id = base64_decode(suggestion.data.doci_id);
    					var doci_name = base64_decode(suggestion.data.doci_name);
    					var index = $('#table_docb_borrow<?=$time?>').datagrid('getRowIndex',doci_id);

    					if(index > -1 && <?=$ppo?>==1)
    					{
    						layer.tips(doci_name+'已存在！'
    	                		, $(ed_doci_id).combobox('textbox')
    	                		,{
    	                		  tips: [1],
    	                		  time: 2000
    	        				 }
    	                		);
    						$(ed_doci_id).combobox('clear');
    						return;
    					}
    					
    					$(ed_doci_id).combobox('setValue',doci_id);
    					$(ed_doci_id).combobox('setText',doci_name);

    					$(ed_doci_page_have).numberbox('setValue',base64_decode(suggestion.data.doci_page_have));
    					$(ed_doci_page_now).numberbox('setValue',base64_decode(suggestion.data.doci_page_now));

    					$(ed_doci_org).textbox('setText',base64_decode(suggestion.data.doci_org_s));
    					
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
    					case 'doci_id':
    						row.doci_id_s = $(ed_list[i].target).combobox('getText');
    						break;
    					case 'doci_org':
    						row.doci_org_s = $(ed_list[i].target).combobox('getText');
    						break;
    				}
    			}
//    			load_date<?=$time?>()
            },
        });
        
        if( arr_view<?=$time?>.indexOf('content[docb_borrow]') > -1)
        {
        	$('#table_docb_borrow<?=$time?>').edatagrid('disableEditing');
            $('#table_docb_borrow_tool<?=$time?> .oa_op').hide();
        }
        
        if( <?=$ppo?> > 1 && <?=$ppo?> != <?=DOC_BORROW_PPO_BACK?>)
        {
        	$('#table_docb_borrow<?=$time?>').edatagrid('disableEditing');
        	$('#table_docb_borrow_tool<?=$time?> .oa_op').hide();
        }
        
    }

    //列格式化输出
    function fun_table_docb_borrow_formatter<?=$time?>(value,row,index){

        switch(this.field)
        {
        	case 'doci_id':
            	
        		value=row.doci_id_s;
        		
            	if(row.doc_id)
                {
            		var url='proc_doc/doc/edit/act/2/doc_id/'+row.doc_id;
                  	value='<a href="javascript:void(0);" class="link" onClick="fun_index_win_open<?=$time?>(\''+row.doc_id+'\',\'win\',\''+url+'\');">'+value+'</a>';
                }
                break;
        	
            default:
                if(row[this.field+'_s'])
                    value = row[this.field+'_s'];
        }

        if( ! value ) value = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ;
        return '<span id="table_docb_borrow<?=$time?>_'+index+'_'+this.field+'" class="table_docb_borrow<?=$time?>" >'+value+'</span>';
    }

    //借阅档案--操作
    function fun_table_docb_borrow_operate<?=$time?>(btn)
    {
    	 var op_list=$('#table_docb_borrow<?=$time?>').datagrid('getChecked');
    	
         var row_s = $('#table_docb_borrow<?=$time?>').datagrid('getSelected');
         var index_s = $('#table_docb_borrow<?=$time?>').datagrid('getRowIndex',row_s);

         if($('#table_docb_borrow<?=$time?>').datagrid('validateRow',index_s))
         {
             $('#table_docb_borrow<?=$time?>').datagrid('endEdit',index_s);
         }
         else
         {
             $('#table_docb_borrow<?=$time?>').datagrid('cancelEdit',index_s);
    		     }
    		     
    		    switch(btn)
    		    {
    		        case 'add':
    					var op_id = get_guid();
    		    		$('#table_docb_borrow<?=$time?>').edatagrid('addRow',{
        					index:0,
        					row:{
        						id: op_id,
        					}
        				});

                		break;
    		        case 'add_more':
    		            var win_id=fun_get_new_win();

    		            $('#'+win_id).window({
    		                title: '添加档案',
    		                inline:true,
    		                modal:true,
    		                border:'thin',
    		                draggable:false,
    		                resizable:false,
    		                collapsible:false,
    		                minimizable:false,
    		                maximizable:false,
    		            })

    		            $('#'+win_id).window('refresh','proc_doc/doci/index/fun_open/window/fun_open_id/'+win_id+'/flag_select/1/fun_select/fun_docb_borrow_add<?=$time?>');
    		            $('#'+win_id).window('center');
    		            break;
            		case 'del':

                	for(var i=op_list.length-1;i>-1;i--)
                	{
	                    var index = $('#table_docb_borrow<?=$time?>').datagrid('getRowIndex',op_list[i]);
	                    $('#table_docb_borrow<?=$time?>').datagrid('deleteRow',index);
	                }
                	break;
        }
    }

    //档案的批量添加
    function fun_docb_borrow_add<?=$time?>(op){
    	$(op).closest('.op_window').window('close');

        var list=$(op).datagrid('getChecked');
        var doci_name='';
        
        for(var i=0;i<list.length;i++)
        {
            var row = {};
            row.doci_id = base64_decode(list[i].doci_id);
            row.doci_id_s = base64_decode(list[i].doci_name);
            row.doci_page_have = base64_decode(list[i].doci_page_have);
            row.doci_page_now = base64_decode(list[i].doci_page_now);
            row.doci_org = base64_decode(list[i].doci_org_s);

            var index = $('#table_docb_borrow<?=$time?>').datagrid('getRowIndex',row.doci_id);

            if(index < 0)
            {
            	$('#table_docb_borrow<?=$time?>').datagrid('appendRow',row);
            }else{
            	
            	doci_name += row.doci_id_s+'<br>';
            }
        }
        
        if( doci_name)
        {
            doci_name=trim(doci_name,'<br>');
        	$.messager.show({
                title:'警告',
                msg: doci_name+'已存在',
                timeout:1500,
                showType:'show',
                border:'thin',
                style:{
                    right:'',
                    bottom:'',
                }
            });
        }
        $(op).closest('.op_window').window('destroy').remove();
    }
    
  	//选择档案
    function fun_get_doci_id<?=$time?>(op)
    {
    	var row_c=$(op).datagrid('getChecked');
   	 
    	if( row_c.length == 0) 
    	{
    		$.messager.show({
    	    	title:'警告',
    	    	msg:'请选择档案！',
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

    	var row_s = $('#table_docb_borrow<?=$time?>').datagrid('getSelected');
    	var index_s = $('#table_docb_borrow<?=$time?>').datagrid('getRowIndex',row_s);
    	
    	var ed_list=$('#table_docb_borrow<?=$time?>').datagrid('getEditors',index_s);

    	var ed_doci_id='';
    	var ed_doci_page_now='';
    	var ed_doci_page_have='';
    	var ed_doci_org='';
    		
    	for(var i = 0;i < ed_list.length; i++)
    	{
    		switch(ed_list[i].field)
    		{
    			case 'doci_id':
    				ed_doci_id = ed_list[i].target;
    				break;
    			case 'doci_page_have':
    				ed_doci_page_have = ed_list[i].target;
    				break;
    			case 'doci_page_now':
    				ed_doci_page_now = ed_list[i].target;
    				break;
    			case 'doci_org':
    				ed_doci_org = ed_list[i].target;
    				break;
    		}
    	}

    	$(ed_doci_id).combobox('setValue',base64_decode(row.doci_id));
    	$(ed_doci_id).combobox('setText',base64_decode(row.doci_name));

    	$(ed_doci_page_now).numberbox('setValue',base64_decode(row.doci_page_now));
    	$(ed_doci_page_have).numberbox('setValue',base64_decode(row.doci_page_have));
    	$(ed_doci_org).textbox('setValue',base64_decode(row.doci_org_s));
    }

    //界面 
    function fun_index_win_open<?=$time?>(title,fun,url)
    		{
    			switch(fun)
    			{
    				case 'tab':
    					var tab=$('#l_index_<?=$time?>').tabs('getTab',title);
    					
    					if(tab)
    					{
    						$('#l_index_<?=$time?>').tabs('select',title);
    					}
    		            else
    		            {
    		                $('#l_index_<?=$time?>').tabs('add',{
    		                    title: title,
    		                    closable: true,
    		                    href:url+'/fun_open/tab/fun_open_id/l_index_<?=$time?>',
    		                    tools:[{
    		                        iconCls:'icon-win_max',
    		                        handler:function(){

    		                            $.messager.confirm('确认', '是否需要打开新窗口？<br>当前未保存数据不做保留！', function(r){
    		                                if (r){
    		                                    window.open(url);
    		                                    var tab =$('#l_index_<?=$time?>').tabs('getTab',title);
    		                                    var index = $('#l_index_<?=$time?>').tabs('getTabIndex',tab);
    		                                    $('#l_index_<?=$time?>').tabs('close',index);
    		                                }
    		                            });
    		                        }
    		                    }]
    		                });
    		            }
    					
    					break;
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
    		                minimizable:true,
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
    		                onMinimize: function()
    		                {
    		                    $.messager.confirm('确认', '是否需要新建标签页？<br>当前未保存数据不做保留！', function(r){
    		                        if (r){
    		                            $('#'+win_id).window('close');
    		                            $('#'+win_id).window('clear');
    		                            fun_index_win_open<?=$time?>(title,'tab',url)
    		                        }
    		                        else{
    		                            $('#'+win_id).window('open');
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
    
//    function load_date<?=$time?>()
//    {
//        
//        var data=$('#table_docb_borrow<?=$time?>').datagrid('getData');
//		console.log(data.rows[0].doci_id);
//        $.ajax({
//
//        	url: "proc_doc/doc_borrow/get_json_date/data_search/"+data.rows[0].doci_id,
//
//        	type: "GET",
//
//        	dataType:'json',
//
//        	success:function(data){},
//
//        });
//    }
</script>