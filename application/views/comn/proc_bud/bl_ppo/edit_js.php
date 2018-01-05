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

                    param['content[blp_ou]']=data_form['content[blp_ou]'];
                    param['content[blp_c]']=data_form['content[blp_c]'];
                    param['content[blp_ppo_num]'] = data_form['content[blp_ppo_num_s]'];
                    
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
                            url+='/act/<?=STAT_ACT_EDIT?>/blp_id/'+json.id

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

  //预算科目
  function load_sub<?=$time?>()
  {
  	var opt = $('#txtb_blp_sub_s<?=$time?>').textbox('options');

  	if(  opt.readonly ) return;

  	$('#txtb_blp_sub_s<?=$time?>').textbox({
  		onClickButton:function()
  		{
  			$('#txtb_blp_sub_s<?=$time?>').textbox('clear');
  			$('#txtb_blp_sub<?=$time?>').val('');
  		},
  	});
  	
  	var gfc_id = $('#txtb_loan_gfc_id<?=$time?>').val();

  	var url = 'base/auto/get_json_sub'
  		
  	$('#txtb_blp_sub_s<?=$time?>').textbox('textbox').autocomplete({
        serviceUrl: url,
        width:'300',
        params:{
  			rows:10,
  	  },
        onSelect: function (suggestion) {
          	var sub= base64_decode(suggestion.data.sub_id);
          	
  			$('#txtb_blp_sub_s<?=$time?>').textbox('setValue',base64_decode(suggestion.data.sub_name));
  			$('#txtb_blp_sub<?=$time?>').val(sub)

			var blp_ppo = $('#txtb_blp_ppo<?=$time?>').combobox('getValue');
			
			if( blp_ppo )
			{
				var url = 'proc_bud/bl_ppo/get_json/search_blp_ppo_num/1/from/combobox/field_id/blp_ppo_num/field_text/blp_ppo_num/search_blp_sub/'+sub+'/search_blp_ppo/'+blp_ppo;
				$('#txtb_blp_ppo_num<?=$time?>').combobox('reload',url);
			}
  		}
  	});
  }

  //金额右侧输入
  function load_bpl_sum_start<?=$time?>()
  {
      $('#txtb_bpl_sum_start<?=$time?>').numberbox('textbox').css('text-align','right');
  }

  //金额右侧输入
  function load_bpl_sum_end<?=$time?>()
  {
      $('#txtb_bpl_sum_end<?=$time?>').numberbox('textbox').css('text-align','right');
  }

  //审核阶段
  function load_blp_ppo_num<?=$time?>()
  {
		var opt = $('#txtb_blp_ppo_num<?=$time?>').textbox('options');

		if(  opt.readonly ) return;

		var blp_sub = data_<?=$time?>['content[blp_sub]'];
		var blp_ppo =data_<?=$time?>['content[blp_ppo]'];
		
		if( blp_sub )
		{
			var url = 'proc_bud/bl_ppo/get_json/search_blp_ppo_num/1/from/combobox/field_id/blp_ppo_num/field_text/blp_ppo_num/search_blp_sub/'+blp_sub+'/search_blp_ppo/'+blp_ppo;
			$('#txtb_blp_ppo_num<?=$time?>').combobox('reload',url);
		}

		$('#txtb_blp_ppo_num<?=$time?>').combobox('textbox').bind('keyup',function(){
			this.value=this.value.replace(/\D/g,'')
		})
		
		$('#txtb_blp_ppo_num<?=$time?>').combobox('textbox').bind('afterpaste',function(){
			this.value=this.value.replace(/\D/g,'')
		})
		
		$('#txtb_blp_ppo_num<?=$time?>').combobox('textbox').bind('focus',function(){
			$(this).parent().prev().combobox('showPanel');
		})
  }

  //统计部门自动补全
  function load_blp_ou<?=$time?>()
  {
  	var opt = $('#txtb_blp_ou<?=$time?>').tagbox('options');

  	if(  opt.readonly ) return;

  	var json = [
  		{"field":"ou_tag","rule":"find_in_set","value":"1"}
  	]
  	
  	$('#txtb_blp_ou<?=$time?>').tagbox('textbox').autocomplete({
  		serviceUrl: 'base/auto/get_json_ou',
  		width:'400',
  		params:{
  			rows:10,
  			data_search:JSON.stringify(json)
  		},
  		onSelect: function (suggestion) {

  			var ou_id = base64_decode(suggestion.data.ou_id)
  			var ou_name = base64_decode(suggestion.data.ou_name)
          	
          	var values=$('#txtb_blp_ou<?=$time?>').tagbox('getValues');

          	if(values.indexOf(ou_id) > -1 ) 
          	{
          		layer.tips(ou_name+'已存在！'
                  		, $('#txtb_blp_ou<?=$time?>').tagbox('textbox')
                  		,{
                  		  tips: [1],
                  		  time: 2000
          				 }
                  		);
              	return;
          	}
          	
          	var data = $('#txtb_blp_ou<?=$time?>').tagbox('getData');

          	data.push({id: ou_id,text:ou_name});
          	$('#txtb_blp_ou<?=$time?>').tagbox('loadData',data);
          	
          	values.push(ou_id);
          	$('#txtb_blp_ou<?=$time?>').tagbox('setValues',values);
  		}
  	});
  }

  //审核人
  function load_blp_c<?=$time?>()
  {
  	var opt = $('#txtb_blp_c<?=$time?>').tagbox('options');

  	if(  opt.readonly ) return;

  	var json = [
  	]
  	
  	$('#txtb_blp_c<?=$time?>').tagbox('textbox').autocomplete({
  		serviceUrl: 'base/auto/get_json_contact/search_c_login_id/1',
  		width:'400',
  		params:{
  			rows:10,
  		},
  		onSelect: function (suggestion) {

  			var c_id = base64_decode(suggestion.data.c_id)
  			var c_show = base64_decode(suggestion.data.c_show)
          	
          	var values=$('#txtb_blp_c<?=$time?>').tagbox('getValues');

          	if(values.indexOf(c_id) > -1 ) 
          	{
          		layer.tips(c_show+'已存在！'
                  		, $('#txtb_blp_c<?=$time?>').tagbox('textbox')
                  		,{
                  		  tips: [1],
                  		  time: 2000
          				 }
                  		);
              	return;
          	}
          	
          	var data = $('#txtb_blp_c<?=$time?>').tagbox('getData');

          	data.push({id: c_id,text:c_show});
          	$('#txtb_blp_c<?=$time?>').tagbox('loadData',data);
          	
          	values.push(c_id);
          	$('#txtb_blp_c<?=$time?>').tagbox('setValues',values);
  		}
  	});
  }
</script>