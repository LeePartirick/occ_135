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

        //载入档案信息
        load_table_doc_info<?=$time?>();

      	//载入借阅信息
        load_table_jy_info<?=$time?>();

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
                    param['content[doc_info]']=data_form['content[doc_info]'];

					//是否提醒
					var opt=$('#btn_doc_alert_yn<?=$time?>').linkbutton('options');
					if(opt.iconCls == 'icon-prompt'){
						param['content[doc_alert_yn]'] = '1';
					}else{
						param['content[doc_alert_yn]'] = '0';
					}
					
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

                    //遍历form 错误消息添加
                    fun_show_errmsg_of_form('f_<?=$time?>',json.err);

                    $(this).form('enableValidation').form('validate');
                }
                else
                {
                	fun_send_wl(json);
                	
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
                            url+='/act/<?=STAT_ACT_EDIT?>/doc_id/'+json.id

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
    								reload_page<?=$time?>(url);	
    							break;
    						}
                        }
                    }
                }
            }
        });
    }

    //签发单位自动补全
    function load_doc_sign_org<?=$time?>(){
        var op=$('#txtb_doc_sign_org_s<?=$time?>').textbox('options');

        if(op.readonly){
            return;
        }

        $('#txtb_doc_sign_org_s<?=$time?>').textbox({
        	onClickButton: function()
            {
                $('#txtb_doc_sign_org_s<?=$time?>').textbox('clear');
                $('#txtb_doc_sign_org<?=$time?>').val('');
            }
        })
        
        $('#txtb_doc_sign_org_s<?=$time?>').textbox('textbox').autocomplete({
            serviceUrl:'base/auto/get_json_org',
            width:'500',
            param:{rows:10},
            onSelect:function(suggestion){
                $("#table_f_<?=$time?> [oaname='content[doc_sign_org_s]']").textbox('setValue',base64_decode(suggestion.data.o_name))
                $("#table_f_<?=$time?> [oaname='content[doc_sign_org]']").val(base64_decode(suggestion.data.o_id))
            }
        })
    }

    //递交人自动补全
    function load_doc_sub_person<?=$time?>(){
        var op=$('#txtb_doc_sub_person_s<?=$time?>').textbox('options');

        if(op.readonly){
            return;
        }

        $('#txtb_doc_sub_person_s<?=$time?>').textbox({
        	onClickButton:function()
            {
                $('#txtb_doc_sub_person_s<?=$time?>').textbox('clear');
                $('#txtb_doc_sub_person<?=$time?>').val('');
            }
        })
        
        $('#txtb_doc_sub_person_s<?=$time?>').textbox('textbox').autocomplete({
            serviceUrl:'base/auto/get_json_contact',
            width:'300',
            param:{rows:10},
            onSelect:function(suggestion){
                $("#table_f_<?=$time?> [oaname='content[doc_sub_person_s]']").textbox('setValue',base64_decode(suggestion.data.c_show))
                $("#table_f_<?=$time?> [oaname='content[doc_sub_person]']").val(base64_decode(suggestion.data.c_id))
            }
        })
    }

    //保管人自动补全
    function load_doc_keep_person<?=$time?>(){
        var op=$('#txtb_doc_keep_person_s<?=$time?>').textbox('options');

        if(op.readonly){
            return;
        }

        $('#txtb_doc_keep_person_s<?=$time?>').textbox({
        	onClickButton:function()
            {
                $('#txtb_doc_keep_person_s<?=$time?>').textbox('clear');
                $('#txtb_doc_keep_person<?=$time?>').val('');
            }
        })
        
        $('#txtb_doc_keep_person_s<?=$time?>').textbox('textbox').autocomplete({
            serviceUrl:'base/auto/get_json_contact',
            width:'300',
            param:{rows:10},
            onSelect:function(suggestion){
                $("#table_f_<?=$time?> [oaname='content[doc_keep_person_s]']").textbox('setValue',base64_decode(suggestion.data.c_show))
                $("#table_f_<?=$time?> [oaname='content[doc_keep_person]']").val(base64_decode(suggestion.data.c_id))
            }
        })
    }

    //维护人
    function load_doc_protect_person<?=$time?>(){
        var op=$('#txtb_doc_protect_person_s<?=$time?>').textbox('options');

        if(op.readonly){
            return;
        }

        $('#txtb_doc_protect_person_s<?=$time?>').textbox({
        	onClickButton:function()
            {
                $('#txtb_doc_protect_person_s<?=$time?>').textbox('clear');
                $('#txtb_doc_protect_person<?=$time?>').val('');
            }
        })
        
        $('#txtb_doc_protect_person_s<?=$time?>').textbox('textbox').autocomplete({
            serviceUrl:'base/auto/get_json_contact',
            width:'300',
            param:{rows:10},
            onSelect:function(suggestion){
                $("#table_f_<?=$time?> [oaname='content[doc_protect_person_s]']").textbox('setValue',base64_decode(suggestion.data.c_show))
                $("#table_f_<?=$time?> [oaname='content[doc_protect_person]']").val(base64_decode(suggestion.data.c_id))
            }
        })
    }
    
    //财务编号
    function load_doc_gfc_id<?=$time?>()
    {
        var opt = $('#txtb_doc_gfc_id_s<?=$time?>').textbox('options');

        if(  opt.readonly ) return;

        $('#txtb_doc_gfc_id_s<?=$time?>').textbox({
            onClickButton:function()
            {
                $('#txtb_doc_gfc_id_s<?=$time?>').textbox('clear');
                $('#txtb_doc_gfc_id<?=$time?>').val('');
            },
            icons: [{
                iconCls:'icon-search',
                handler: function(e){

                    var win_id=fun_get_new_win();

                    $('#'+win_id).window({
                        title: '请选择项目',
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

                    $('#'+win_id).window('refresh','proc_gfc/gfc/index/fun_open/window/fun_open_id/'+win_id+'/flag_select/2/fun_select/fun_get_gfc_id<?=$time?>');
                    $('#'+win_id).window('center');
                }
            }]
        });

        $('#txtb_doc_gfc_id_s<?=$time?>').textbox('textbox').autocomplete({
            serviceUrl: 'proc_gfc/gfc/get_json/search_gfc_finance_code/1/',
            width:300,
            params:{
                rows:10,
                field_s:'gfc_org,gfc_name,gfc_finance_code,gfc_org_jia,gfc_c,gfc_sum,gfc_category_extra,gfc_category_secret'
            },
            onSelect: function (suggestion) {

                $("#table_f_<?=$time?> [oaname='content[doc_gfc_id_s]']").textbox('setValue',base64_decode(suggestion.data.gfc_finance_code));
                $("#table_f_<?=$time?> [oaname='content[doc_gfc_id]']").val(base64_decode(suggestion.data.gfc_id));

                //公司只读且锁定
                $('#txtb_doc_org<?=$time?>').combobox({
                    readonly:true,
                    buttonIcon:'icon-lock'
                })
                
                var gfc_id = base64_decode(suggestion.data.gfc_id)
                $('#txtb_gfc_id<?=$time?>').val(gfc_id);

                fun_tr_title_show($('#table_f_<?=$time?>'),'title_gfc',1)
                
                $("#table_f_<?=$time?> [oaname='content[doc_name]']").textbox('setValue',base64_decode(suggestion.data.gfc_name));
                $("#table_f_<?=$time?> [oaname='content[doc_sign_org_s]']").textbox('clear');
                $("#table_f_<?=$time?> [oaname='content[doc_sign_org]']").val('');
                $("#table_f_<?=$time?> [name='content[doc_org]']").val(base64_decode(suggestion.data.gfc_org));
                $("#table_f_<?=$time?> [oaname='content[doc_letter_have]']").numberbox('clear');
                $("#table_f_<?=$time?> [oaname='content[doc_page_have]']").numberbox('clear');
                
                //项目信息赋值
                $("#table_f_<?=$time?> [oaname='content[gfc_finance_code]']").html(base64_decode(suggestion.data.gfc_finance_code));
                $("#table_f_<?=$time?> [oaname='content[gfc_name]']").html(base64_decode(suggestion.data.gfc_name));
                $("#table_f_<?=$time?> [oaname='content[gfc_org_jia_s]']").html(base64_decode(suggestion.data.gfc_org_jia_s));
                $("#table_f_<?=$time?> [oaname='content[gfc_c_s]']").html(base64_decode(suggestion.data.gfc_c_s));
                $("#table_f_<?=$time?> [oaname='content[gfc_sum]']").html(base64_decode(suggestion.data.gfc_sum));
                $("#table_f_<?=$time?> [oaname='content[gfc_category_extra]']").html(base64_decode(suggestion.data.gfc_category_extra));
                $("#table_f_<?=$time?> [oaname='content[gfc_category_secret]']").html(base64_decode(suggestion.data.gfc_category_secret));
                console.log($('#txtb_doc_gfc_id<?=$time?>').val())
                if( $('#txtb_doc_gfc_id<?=$time?>').val()){
        		    var url = 'proc_doc/doc/get_json_file';
        	    	url+='/search_doc_gfc/'+$('#txtb_doc_gfc_id<?=$time?>').val()+'/link_op_field/gfc_id/link_op_table/pm_given_financial_code';
        	    	$('#table_doc_info<?=$time?>').datagrid('reload',url);
        		}
            }
        });
    }
    
    //选择项目
    function fun_get_gfc_id<?=$time?>(op)
    {
        var row_c=$(op).datagrid('getChecked');

        if( row_c.length == 0)
        {
            $.messager.show({
                title:'警告',
                msg:'请选择项目！',
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

        $('#txtb_doc_gfc_id_s<?=$time?>').textbox('setValue',base64_decode(row.gfc_finance_code));
        $('#txtb_doc_gfc_id<?=$time?>').val(base64_decode(row.gfc_id));

        var gfc_id = base64_decode(row.gfc_id)
        $('#txtb_doc_gfc_id<?=$time?>').val(gfc_id);

        fun_tr_title_show($('#table_f_<?=$time?>'),'title_gfc',1)
        
        $('#txtb_doc_sign_org_s<?=$time?>').textbox('clear');
        $('#txtb_doc_sign_org<?=$time?>').val('');
        
        $("#table_f_<?=$time?> [oaname='content[doc_name]']").textbox('setValue',base64_decode(row.gfc_name));
        $("#table_f_<?=$time?> [oaname='content[doc_sign_org_s]']").textbox('clear');
        $("#table_f_<?=$time?> [oaname='content[doc_sign_org]']").val('');
        $("#table_f_<?=$time?> [name='content[doc_org]']").val(base64_decode(row.gfc_org));
        $("#table_f_<?=$time?> [oaname='content[doc_letter_have]']").numberbox('clear');
        $("#table_f_<?=$time?> [oaname='content[doc_page_have]']").numberbox('clear');

        $("#table_f_<?=$time?> [oaname='content[gfc_finance_code]']").html(base64_decode(row.gfc_finance_code));
        $("#table_f_<?=$time?> [oaname='content[gfc_name]']").html(base64_decode(row.gfc_name));
        $("#table_f_<?=$time?> [oaname='content[gfc_org_jia_s]']").html(base64_decode(row.gfc_org_jia_s));
        $("#table_f_<?=$time?> [oaname='content[gfc_c_s]']").html(base64_decode(row.gfc_c_s));
        $("#table_f_<?=$time?> [oaname='content[gfc_sum]']").html(base64_decode(row.gfc_sum));
        $("#table_f_<?=$time?> [oaname='content[gfc_category_extra]']").html(base64_decode(row.gfc_category_extra));
        $("#table_f_<?=$time?> [oaname='content[gfc_category_secret]']").html(base64_decode(row.gfc_category_secret));

        
        if( $('#txtb_doc_gfc_id<?=$time?>').val()){
		    var url = 'proc_doc/doc/get_json_file';
	    	url+='/search_doc_gfc/'+$('#txtb_doc_gfc_id<?=$time?>').val()+'/link_op_field/gfc_id/link_op_table/pm_given_financial_code';
	    	$('#table_doc_info<?=$time?>').datagrid('reload',url);
		}
    }

    //根据件增加多行
	function load_doci_letter<?=$time?>()
	{
		var letter_old='';
		var letter_new='';
		
		$("#table_f_<?=$time?> [oaname='content[doc_letter_have]']").numberbox('textbox').css('text-align','right');

		var opt = $("#table_f_<?=$time?> [oaname='content[doc_letter_have]']").numberbox('options');

        if(  opt.readonly ) return;
		
		$("#table_f_<?=$time?> [oaname='content[doc_letter_have]']").numberbox('textbox').bind('blur',
			function(){
				var letter = $("#table_f_<?=$time?> [oaname='content[doc_letter_have]']").textbox('getValue');//获取件数
				var doc_name = $("#table_f_<?=$time?> [oaname='content[doc_name]']").textbox('getValue');//获取档案名
				var page = $("#table_f_<?=$time?> [oaname='content[doc_page_have]']").textbox('getValue');
				var table_row = $('#table_doc_info<?=$time?>').edatagrid('getData').total;
				if(page.length==0)
				{
					page=1;
				}
				
				//只增加
				if(table_row == 0 && letter.length > 0)
				{
					$("#table_f_<?=$time?> [oaname='content[doc_page_have]']").textbox('setValue',letter);
					for(var i = 0;i < letter;i++){
						var op_id = get_guid();
						$('#table_doc_info<?=$time?>').edatagrid('appendRow',{
								doci_id:op_id,
								doci_name:doc_name,
								doci_page_have:page,
								doci_page_now:page,
							});
					}
				}
				else if(letter-table_row > 0)//追加
				{
					$("#table_f_<?=$time?> [oaname='content[doc_page_have]']").textbox('setValue',letter);
					var letter=letter-table_row;
					for(var i = 0;i < letter;i++){
						var op_id = get_guid();
						$('#table_doc_info<?=$time?>').edatagrid('insertRow',{
							row:{
								doci_id:op_id,
								doci_name:doc_name,
								doci_page_have:page,
								doci_page_now:page,
							}
						});
					}
				}
				else//移除
				{
					$("#table_f_<?=$time?> [oaname='content[doc_page_have]']").textbox('setValue',letter);
					var letter=table_row - letter;
					var rows=$('#table_doc_info<?=$time?>').edatagrid('getRows')
					var index=0
					for(var i = 0;i < letter;i++){
						var op_id = get_guid();
						$('#table_doc_info<?=$time?>').edatagrid('deleteRow',index);
					}
				}
			})
	}
	
	//页数
	function load_doci_page<?=$time?>()
	{
		$("#table_f_<?=$time?> [oaname='content[doc_page_have]']").numberbox('textbox').css('text-align','right');

		var opt = $("#table_f_<?=$time?> [oaname='content[doc_letter_have]']").numberbox('options');
		
        if(  opt.readonly ) return;
		
		$("#table_f_<?=$time?> [oaname='content[doc_page_have]']").numberbox('textbox').bind('blur',
			function(){
				var row=$('#table_doc_info<?=$time?>').edatagrid('getRows');//获取行
				var table_row = $('#table_doc_info<?=$time?>').edatagrid('getData').total;//获取总行数
				var page=$("#table_f_<?=$time?> [oaname='content[doc_page_have]']").numberbox('getValue');
				var letter = $("#table_f_<?=$time?> [oaname='content[doc_letter_have]']").textbox('getValue');//获取件数
				var yu = page%letter;
				
				if(yu != 0){
					page=(page-yu)/letter;

					row.doci_page_have = page+yu;
					row.doci_page_now = page+yu;
					$('#table_doc_info<?=$time?>').datagrid('updateRow',{
						index: 0,
						row: row
					});

					for(var i = 1;i < table_row;i++){
						var row = {};
						row.doci_page_have = page;
						row.doci_page_now = page;
						$('#table_doc_info<?=$time?>').datagrid('updateRow',{
							index: i,
							row: row
						});
					}
				}else{
					page=page/letter;
					
					for(var i = 0;i < table_row;i++){
						var row = {};
						row.doci_page_have = page;
						row.doci_page_now = page;
						$('#table_doc_info<?=$time?>').datagrid('updateRow',{
							index: i,
							row: row
						});
					}
				}
			})
	}

	//档案信息--载入
	function load_table_doc_info<?=$time?>()
	{
	    $('#table_doc_info<?=$time?>').edatagrid({
	        width:'100%',
	        height:'150',
	        toolbar:'#table_doc_info_tool<?=$time?>',
	        singleSelect:true,
	        selectOnCheck:false,
	        checkOnSelect:false,
	        striped:true,
	        idField:'doci_id',
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
	            {field:'doci_id',title:'',width:50,align:'center',checkbox:true},
	            {field:'doci_name',title:'档案名称',width:350,halign:'center',align:'left',formatter:fun_table_doc_info_formatter<?=$time?>,
	            		editor:{
						type:'textbox',
						options:{
							err:err,
		            		panelHeight:'0',
							required:true,
							valueField: 'id',    
	                        textField: 'text', 
	                        hasDownArrow:false, 
	                        buttonIcon:'icon-clear',
					    	onClickButton:function()
					        {
								$(this).combobox('clear');
					        }
						}
					}
	            },
	            {field:'doci_page_have',title:'应有页数',width:80,halign:'center',align:'right',formatter:fun_table_doc_info_formatter<?=$time?>,
	                editor:{
	                    type:'numberbox',
	                    options:{
                    		err:err,
	                        buttonIcon:'icon-clear',
	                        required:true,
	                        onClickButton:function()
	                        {
	                            $(this).textbox('clear');
	                        },
	                    }
	                }
	            },
	            {field:'doci_page_now',title:'实际页数',width:80,halign:'center',align:'right',formatter:fun_table_doc_info_formatter<?=$time?>,
					editor:{
			            type:'numberbox',
			            options:{
			                iconCls:'icon-lock',
			                readonly:true,
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
	        onBeforeEdit: function(index,row)
            {
    			if( row.doci_f_id )
				return false;
            },
	        onBeginEdit: function(index,row)
	        {
	            var ed_list=$(this).datagrid('getEditors',index);
	            
	            var ed_doci_id = '';
	            var ed_doci_name = '';
	            var ed_doci_page_have = '';
	            var ed_doci_page_now = '';
	            var ed_f_id='';
	            
	            for(var i = 0;i < ed_list.length; i++)
	            {
	                switch(ed_list[i].field)
	                {
	                    case 'doci_name':
	                    	
	                        ed_doci_name = ed_list[i].target;
							//获取所填的档案全称
							var doc_gfc_id=$("#table_f_<?=$time?> [oaname='content[doc_gfc_id]']").val();
	                        var doc_name=$("#table_f_<?=$time?> [oaname='content[doc_name]']").textbox('getValue');
							if( ! row.doci_name )
							{
								$(ed_list[i].target).textbox('setValue',doc_name);
							}
	
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
	                    case 'doci_page_have':
	
	                        row.doci_page_now = row.doci_page_have;
	                        
	                        break;
	                }
	            }
	        }
	    });
	}

	//列格式化输出
	function fun_table_doc_info_formatter<?=$time?>(value,row,index){
	    switch(this.field)
	    {
	        case 'doci_name':
	            if( row.doci_f_id ){
	                value=row.doci_name
	                var url='proc_file/file/edit/act/2/f_id/'+row.doci_f_id;
		   			value='<a href="javascript:void(0);" class="link" onClick="fun_index_win_open<?=$time?>(\'文件-'+value+'\',\'win\',\''+url+'\');">'+value+'</a>';
	            }
	            break;
	        default:
	
	            if( row[this.field+'_s'] )
	                value = row[this.field+'_s'];
	    }
	
	    if( ! value ) value = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ;
	    return '<span id="table_doc_info<?=$time?>_'+index+'_'+this.field+'" class="table_doc_info<?=$time?>" >'+value+'</span>';
	}
	
	//档案明细--操作
	function fun_table_doc_info_operate<?=$time?>(btn)
	{
	    switch(btn)
	    {
	        case 'add':
	
	            var op_id = get_guid();
	            var doc_name=$("#table_f_<?=$time?> [oaname='content[doc_name]']").textbox('getValue');

	            $('#table_doc_info<?=$time?>').edatagrid('addRow',{
	              index:0,
	              row:{
	                 doci_id: op_id,
	                 doci_name:doc_name
	              }
	          	});
				
	            break;
	        case 'del':
	
	            var op_list=$('#table_doc_info<?=$time?>').datagrid('getChecked');
	
	            var row_s = $('#table_doc_info<?=$time?>').datagrid('getSelected');
	            var index_s = $('#table_doc_info<?=$time?>').datagrid('getRowIndex',row_s);
	
	            if($('#table_doc_info<?=$time?>').datagrid('validateRow',index_s))
	            {
	                $('#table_doc_info<?=$time?>').datagrid('endEdit',index_s);
	            }
	            else
	            {
	                $('#table_doc_info<?=$time?>').datagrid('cancelEdit',index_s);
	            }
	
	            for(var i=op_list.length-1;i>-1;i--)
	            {
		            if( ! op_list[i]['doci_f_id']){
		            	var index = $('#table_doc_info<?=$time?>').datagrid('getRowIndex',op_list[i]);
		            	$('#table_doc_info<?=$time?>').datagrid('deleteRow',index);
			        }
	            }
	
	            break;
	    }
	}

	//文件名链接
	function fun_index_win_open<?=$time?>(title,fun,url)
	{
		var gfc_id=$("#table_f_<?=$time?> [oaname='content[doc_gfc_id]']").val();
		
		url+='/link_op_id/gfc_id/link_op_field/gfc_id/link_op_table/pm_given_financial_code/search_f_t_proc/proc_gfc';

		switch(fun)
		{
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
				$('#'+win_id).window('open')

				break;
					
		}
	}

	//改变icon样式
	function fun_change_icon<?=$time?>(op){
		var opt = $(op).linkbutton('options');
		//为提醒赋值1，不提醒清空赋值
		if( opt.iconCls == 'icon-prompt'){
			$("#btn_doc_alert_yn<?=$time?>").linkbutton({'iconCls':'icon-mute'})
			$("#btn_doc_alert_yn<?=$time?>").attr("title","静音");
		}else{
			$("#btn_doc_alert_yn<?=$time?>").linkbutton({iconCls:'icon-prompt'})
			$("#btn_doc_alert_yn<?=$time?>").attr("title","提醒");
		}
	}
</script>