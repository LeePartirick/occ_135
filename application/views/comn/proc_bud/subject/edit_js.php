<!-- 加载jquery -->
<script type="text/javascript">

	//载入数据
	var data_<?=$time?>=<?=$data?>;
	//初始化
	$(document).ready(function(){

		load_win_loading('win_loading<?=$time?>')

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
                    param['content[sub_tag]']=data_form['content[sub_tag]'];
                    param['content[sub_type]']=data_form['content[sub_type]'];
                }
                else
                {
                    $(this).form('enableValidation').form('validate');

                    return false;
                }

            },
            success: function(data){
				//alert(data);
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
                            url+='/act/<?=STAT_ACT_EDIT?>/sub_id/'+json.id

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
	
	//上级目录自动补全
	function load_sub_parent<?=$time?>()
	{
		var opt = $('#txtb_sub_parent_s<?=$time?>').textbox('options');

		if(  opt.readonly ) return;

		$('#txtb_sub_parent_s<?=$time?>').textbox({
			icons: [{
				iconCls:'icon-tree',
				handler: function(e){

					var win_id=fun_get_new_win();

					$('#'+win_id).window({
						title: '团队树-双击选择',
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
					var url = 'proc_bud/subject/win_tree/flag_select/1/fun_select/fun_get_sub_parent<?=$time?>'
					$('#'+win_id).window('refresh',url+'/fun_open/win/fun_open_id/'+win_id);

				}
			}]
		});

		var json = [
			{"field":"sub_parent_path","rule":"not like","value":"<?=$sub_id?>"}
		]

		$('#txtb_sub_parent_s<?=$time?>').textbox('textbox').autocomplete({
			serviceUrl: 'proc_bud/subject/get_json',
			width:'300',
			params:{
				rows:10,
				'data_search':JSON.stringify(json)
			},
			onSelect: function (suggestion) {
				$('#txtb_sub_parent_s<?=$time?>').textbox('setValue',base64_decode(suggestion.data.sub_name));
				$('#txtb_sub_parent<?=$time?>').val(base64_decode(suggestion.data.sub_id))
			}
		});
	}

	function fun_get_sub_parent<?=$time?>(tree,row)
	{
//		if( ! row.sub_name) return;
		$('#'+tree).closest('.op_window').window('close');
		$('#txtb_sub_parent_s<?=$time?>').textbox('setValue',base64_decode(row.sub_name));
		$('#txtb_sub_parent<?=$time?>').val(base64_decode(row.sub_id));

	}
//    标签
    function load_sub_tag<?=$time?>()
    {
        var opt = $('#txtb_sub_tag<?=$time?>').combotree('options');

        if(  opt.readonly ) return;

        if('<?=$flag_edit_more?>')
        {
            $('#txtb_sub_tag<?=$time?>').combotree({
                icons: [{
                    iconCls:'icon-add',
                    handler: function(e){
                        $(e.data.target).combotree('getIcon',1).removeClass('div_input_require');
                        $(e.data.target).combotree('getIcon',2).removeClass('div_input_require');
                        $(this).addClass('div_input_require');
                        $(e.data.target).prev().val('add')
                    }
                },{
                    iconCls:'icon-edit',
                    handler: function(e){
                        $(e.data.target).combotree('getIcon',0).removeClass('div_input_require');
                        $(e.data.target).combotree('getIcon',2).removeClass('div_input_require');
                        $(this).addClass('div_input_require');
                        $(e.data.target).prev().val('edit')
                    }
                },{
                    iconCls:'icon-remove',
                    handler: function(e){
                        $(e.data.target).combotree('getIcon',0).removeClass('div_input_require');
                        $(e.data.target).combotree('getIcon',1).removeClass('div_input_require');
                        $(this).addClass('div_input_require');
                        $(e.data.target).prev().val('del')
                    }
                }]
            });

            $('#txtb_sub_tag<?=$time?>').combotree('getIcon',1).addClass('div_input_require');
            $('#txtb_sub_tag<?=$time?>').before('<input oaname="sub_tag_operate" class="oa_input" type="hidden" value="edit"/>')

        }

    }

</script>