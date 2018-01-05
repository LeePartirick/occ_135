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

					if('<?=$fun_no_db?>')
					{
						param.data_db = '<?=$data_db_post?>';
					}
				}
				else
				{
					$(this).form('enableValidation').form('validate');

					return false;
				}

			},
			success: function(data){
				
				$('#win_loading<?=$time?>').window('close');
//				alert(data);
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
							url+='/act/<?=STAT_ACT_EDIT?>/eli_id/'+json.id

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
	function load_eli_sub<?=$time?>()
	{
		var json = [
			{"field":"sub_tag","rule":"find_in_set","value":"1,2,3"}
		]

		$('#txtb_eli_sub<?=$time?>').combobox({
			url:'base/auto/get_json_sub/from/combobox/field_id/sub_id/field_text/sub_name',
			queryParams:{
				data_search:JSON.stringify(json)
			},
			onSelect:function(record)
			{
				record.sub_tag = base64_decode(record.sub_tag);

				$('#txtb_eli_name<?=$time?>').textbox({});
				if(record.sub_tag.indexOf('3') > -1 )
				{
					$("#f_<?=$time?> [oaname='content[eli_name_s]']").text('分包名称');
					$("#f_<?=$time?> [oaname='content[eli_supply_org_s_s]']").text('分包商');
					$("#f_<?=$time?> [oaname='content[eli_parameter_s]']").text('服务大概描述');
					$("#f_<?=$time?> [oaname='content[eli_maintenance_s]']").text('服务期-月');

					$("#f_<?=$time?> [oaname='tr_eq']").hide();
					$("#f_<?=$time?> [oaname='tr_fb']").show();

					$('#txtb_eli_eq_id<?=$time?>').val('');
				}
				else
				{
					if(record.sub_tag.indexOf('1') > -1 )
					{
						load_eli_name<?=$time?>();
					}
					else
					{
						$('#txtb_eli_eq_id<?=$time?>').val('');
					}
					
					$("#f_<?=$time?> [oaname='content[eli_name_s]']").text('设备名称');
					$("#f_<?=$time?> [oaname='content[eli_supply_org_s_s]']").text('供应商');
					$("#f_<?=$time?> [oaname='content[eli_parameter_s]']").text('设备参数');
					$("#f_<?=$time?> [oaname='content[eli_maintenance_s]']").text('保修期-月');

					$("#f_<?=$time?> [oaname='tr_eq']").show();
					$("#f_<?=$time?> [oaname='tr_fb']").hide();
				}

				$('#txtb_eli_type<?=$time?>').val(record.sub_tag);
			}
		})

		$('#txtb_eli_sub<?=$time?>').combobox('textbox').bind('focus',function(){
			$(this).parent().prev().combobox('showPanel');
		})
	}

	//设备名称
	function load_eli_name<?=$time?>()
	{
		var opt = $('#txtb_eli_name<?=$time?>').textbox('options');

		if(  opt.readonly ) return;

		$('#txtb_eli_name<?=$time?>').textbox('textbox').autocomplete({
			serviceUrl: 'proc_eq/eq/get_json',
			params:{
				rows:10,
				field_s:'eq_name,eq_brand,eq_model,eq_unit,eq_maintenance,eq_parameter,eq_price,eq_org'
			},
			onSelect: function (suggestion) {
				$('#txtb_eli_name<?=$time?>').textbox('setValue',base64_decode(suggestion.data.eq_name));
				$('#txtb_eli_eq_id<?=$time?>').val(base64_decode(suggestion.data.eq_id))
				
				$("#txtb_eli_brand<?=$time?>").textbox('setValue',base64_decode(suggestion.data.eq_brand));
				$("#txtb_eli_model<?=$time?>").textbox('setValue',base64_decode(suggestion.data.eq_model));
				$("#txtb_eli_parameter<?=$time?>").textbox('setValue',base64_decode(suggestion.data.eq_parameter));
				$("#txtb_eli_sum<?=$time?>").numberbox('setValue',base64_decode(suggestion.data.eq_price));
				$("#txtb_eli_maintenance<?=$time?>").numberbox('setValue',base64_decode(suggestion.data.eq_maintenance));

				$("#txtb_eli_supply_org_s<?=$time?>").textbox('setValue',base64_decode(suggestion.data.eli_supply_org_s));
				$("#txtb_eli_supply_org<?=$time?>").val(base64_decode(suggestion.data.eli_supply_org));
			}
		});
	}

	//供应商/分包商自动补全
	function load_eli_supply_org<?=$time?>()
	{
		var opt = $('#txtb_eli_supply_org_s<?=$time?>').textbox('options');

		if(  opt.readonly ) return;

		$('#txtb_eli_supply_org_s<?=$time?>').textbox('textbox').autocomplete({
			serviceUrl: 'base/auto/get_json_org/search_o_status/1',
			params:{
				rows:10,
			},
			onSelect: function (suggestion) {
				$('#txtb_eli_supply_org_s<?=$time?>').textbox('setValue',base64_decode(suggestion.data.o_id_standard_s));
				$('#txtb_eli_supply_org<?=$time?>').val(base64_decode(suggestion.data.o_id_standard))
			}
		});
	}

	//单位成本
	function load_eli_sum_total<?=$time?>()
	{
		$('#txtb_eli_sum_total<?=$time?>').numberbox('textbox').css('text-align','right');
	}

	//采购单价
	function load_eli_sum<?=$time?>()
	{
		$('#txtb_eli_sum<?=$time?>').numberbox('textbox').css('text-align','right');
	}
		
</script>