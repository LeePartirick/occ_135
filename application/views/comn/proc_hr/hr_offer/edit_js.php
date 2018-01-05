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

				param['content[c_tel_info]']=data_form['content[c_tel_info]'];
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

//			alert(data);
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

				//联系人已存在
				if(json.err.c_id_exist)
				{
					$.messager.confirm('确认',json.err.c_id_exist,function(r){    
					    if (r){    
						    
						    if($('#c_id_exist<?=$time?>').length == 0 )
						   		$('#table_f_<?=$time?>').after('<input id="c_id_exist<?=$time?>" type="hidden" name="content[c_id_exist]" value="1"/>');
						    else
						    	$('#c_id_exist<?=$time?>').val(1);
					    	
						    f_submit_<?=$time?>(btn)
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
					fun_send_wl(json);
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
						url+='/act/<?=STAT_ACT_EDIT?>/offer_id/'+json.id

						fun_send_wl(json);
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

function fun_print<?=$time?>()
{
	var win_id=fun_get_new_win();

	var url=trim('<?=$url?>','.html');
	url += '/flag_print/1';
	
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
		onClose: function()
		{
			$('#'+win_id).window('destroy');
			$('#'+win_id).remove();
		}
	})
	
	$('#'+win_id).window('refresh',url+'/fun_open/win/fun_open_id/'+win_id);
	$('#'+win_id).window('open');
}

function load_c_ou_2_s<?=$time?>()
{
	var opt = $('#txtb_c_ou_2_s<?=$time?>').textbox('options');

	if(  opt.readonly ) return;

	$('#txtb_c_ou_2_s<?=$time?>').textbox({
		buttonIcon:'icon-clear',
    	onClickButton:function()
        {
			$(this).textbox('clear');
			$('#txtb_c_ou_2<?=$time?>').val('');
        },
	});

	var c_org = $('#txtb_c_org<?=$time?>').combobox('getValue');
	
	var json = [
		{"field":"ou_org","rule":"=","value":c_org},
		{"field":"ou_tag","rule":"find_in_set","value":"2"}
	]
	
	$('#txtb_c_ou_2_s<?=$time?>').textbox('textbox').autocomplete({
        serviceUrl: 'base/auto/get_json_ou',
        width:'300',
        params:{
			rows:10,
			data_search:JSON.stringify(json)
		},
        onSelect: function (suggestion) {
			$('#txtb_c_ou_2_s<?=$time?>').textbox('setValue',base64_decode(suggestion.data.ou_name));
			$('#txtb_c_ou_2<?=$time?>').val(base64_decode(suggestion.data.ou_id));

			$('#txtb_c_ou_3_s<?=$time?>').textbox('setValue',base64_decode(suggestion.data.ou_name));
			$('#txtb_c_ou_3<?=$time?>').val(base64_decode(suggestion.data.ou_id))
			
			$('#txtb_c_ou_4_s<?=$time?>').textbox('setValue',base64_decode(suggestion.data.ou_name));
			$('#txtb_c_ou_4<?=$time?>').val(base64_decode(suggestion.data.ou_id))
			
			load_c_ou_3_s<?=$time?>();
		}
	});
}

function load_c_ou_3_s<?=$time?>()
{
	var opt = $('#txtb_c_ou_3_s<?=$time?>').textbox('options');

	if(  opt.readonly ) return;

	$('#txtb_c_ou_3_s<?=$time?>').textbox({
		buttonIcon:'icon-clear',
    	onClickButton:function()
        {
			$(this).textbox('clear');
			$('#txtb_c_ou_3<?=$time?>').val('');
        },
	});

	var c_org = $('#txtb_c_org<?=$time?>').combobox('getValue');
	var c_ou_2 = $('#txtb_c_ou_2<?=$time?>').val();
	
	var json = [
		{"field":"ou_org","rule":"=","value":c_org},
    	{"field":"ou_parent_path","rule":"find_in_set","value":c_ou_2},
    	{"field":"ou_tag","rule":"find_in_set","value":"2"}
    ]
    
    $('#txtb_c_ou_3_s<?=$time?>').textbox('textbox').autocomplete({
        serviceUrl: 'base/auto/get_json_ou',
        width:'300',
        params:{
			rows:10,
			data_search:JSON.stringify(json)
		},
        onSelect: function (suggestion) {
			$('#txtb_c_ou_3_s<?=$time?>').textbox('setValue',base64_decode(suggestion.data.ou_name));
			$('#txtb_c_ou_3<?=$time?>').val(base64_decode(suggestion.data.ou_id));

			$('#txtb_c_ou_4_s<?=$time?>').textbox('setValue',base64_decode(suggestion.data.ou_name));
			$('#txtb_c_ou_4<?=$time?>').val(base64_decode(suggestion.data.ou_id))
			
			load_c_ou_4_s<?=$time?>();
		}
	});
}

function load_c_ou_4_s<?=$time?>()
{
	var opt = $('#txtb_c_ou_4_s<?=$time?>').textbox('options');

	if(  opt.readonly ) return;

	$('#txtb_c_ou_4_s<?=$time?>').textbox({
		buttonIcon:'icon-clear',
    	onClickButton:function()
        {
			$(this).textbox('clear');
			$('#txtb_c_ou_4<?=$time?>').val('');
        },
	});

	var c_org = $('#txtb_c_org<?=$time?>').combobox('getValue');
	var c_ou_3 = $('#txtb_c_ou_3<?=$time?>').val();
	
	var json = [
		{"field":"ou_org","rule":"=","value":c_org},
		{"field":"ou_parent_path","rule":"find_in_set","value":c_ou_3},
		{"field":"ou_tag","rule":"find_in_set","value":"2"}
	]
	
	$('#txtb_c_ou_4_s<?=$time?>').textbox('textbox').autocomplete({
        serviceUrl: 'base/auto/get_json_ou',
        width:'300',
        params:{
			rows:10,
			data_search:JSON.stringify(json)
		},
        onSelect: function (suggestion) {
			$('#txtb_c_ou_4_s<?=$time?>').textbox('setValue',base64_decode(suggestion.data.ou_name));
			$('#txtb_c_ou_4<?=$time?>').val(base64_decode(suggestion.data.ou_id))
		}
	});
}

function load_c_job_s<?=$time?>()
{
	var opt = $('#txtb_c_job_s<?=$time?>').textbox('options');

	if(  opt.readonly ) return;

	$('#txtb_c_job_s<?=$time?>').textbox({
		buttonIcon:'icon-clear',
    	onClickButton:function()
        {
			$(this).textbox('clear');
			$('#txtb_c_job<?=$time?>').val('');
        },
		icons: [{
			iconCls:'icon-add',
			handler: function(e){
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
					minimizable:false,
					maximizable:false,
					onClose: function()
					{
						$('#'+win_id).window('destroy');
						$('#'+win_id).remove();
					}
				})
				
				var url='proc_hr/hr_job/edit'
				$('#'+win_id).window('refresh',url+'/fun_open/win/fun_open_id/'+win_id);
			}
		}]
	});
		
	$('#txtb_c_job_s<?=$time?>').textbox('textbox').autocomplete({
        serviceUrl: 'proc_hr/hr_job/get_json',
        width:'300',
        params:{
			rows:10
		},
        onSelect: function (suggestion) {
			$('#txtb_c_job_s<?=$time?>').textbox('setValue',base64_decode(suggestion.data.job_name));
			$('#txtb_c_job<?=$time?>').val(base64_decode(suggestion.data.job_id))
		}
	});
}
</script>