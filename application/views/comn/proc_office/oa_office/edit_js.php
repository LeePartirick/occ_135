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
		fun_form_operate('f_<?=$time?>',<?=$field_view;?>,<?=$field_edit;?>,<?=$field_required?>);

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

				param['content[offi_org]']=data_form['content[offi_org]'];
				param['content[offi_org_default]']=data_form['content[offi_org_default]'];
				param['content[offi_person_start]']=data_form['content[offi_person_start]'];
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
						url+='/act/<?=STAT_ACT_EDIT?>/offi_id/'+json.id

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

//系统开通人
function load_offi_person_start<?=$time?>()
{
	var opt = $('#txtb_offi_person_start<?=$time?>').tagbox('options');

	if(  opt.readonly ) return;
	
	$('#txtb_offi_person_start<?=$time?>').tagbox('textbox').autocomplete({
		serviceUrl: 'base/auto/get_json_contact/search_c_login_id/1',
		width:'300',
		params:{
			rows:10,
		},
		onSelect: function (suggestion) {

			var c_id = base64_decode(suggestion.data.c_id)
			var c_show = base64_decode(suggestion.data.c_name)
			var c_login_id = base64_decode(suggestion.data.c_login_id)
			if( c_login_id ) c_show+='['+c_login_id+']';
			
        	
        	var values=$('#txtb_offi_person_start<?=$time?>').tagbox('getValues');

        	if(values.indexOf(c_id) > -1 ) 
        	{
        		layer.tips(c_show+'已存在！'
                		, $('#txtb_offi_person_start<?=$time?>').tagbox('textbox')
                		,{
                		  tips: [1],
                		  time: 2000
        				 }
                		);
            	return;
        	}
        	
        	var data = $('#txtb_offi_person_start<?=$time?>').tagbox('getData');

        	data.push({id: c_id,text:c_show});
        	$('#txtb_offi_person_start<?=$time?>').tagbox('loadData',data);
        	
        	values.push(c_id);
        	$('#txtb_offi_person_start<?=$time?>').tagbox('setValues',values);
		}
	});
}
</script>