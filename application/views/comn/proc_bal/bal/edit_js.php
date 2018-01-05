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

	//个人借款
	load_table_loan_ending<?=$time?>();
	
	//冲账
	load_table_bl<?=$time?>()
			
	//费用报销明细
	load_table_bali<?=$time?>();

	//差旅费明细
	load_table_trip<?=$time?>();

	//出差人明细
	load_table_trip_c<?=$time?>();

	//差旅费补贴
	load_table_trip_sub<?=$time?>();
			
	setTimeout(function(){
		
		//添加只读，编辑,必填
		fun_form_operate('f_<?=$time?>',arr_view<?=$time?>,arr_edit<?=$time?>,arr_required<?=$time?>);

		//载入数据
		load_form_data_<?=$time?>();

		fun_show_trip<?=$time?>();
		
	},500);

	//标题
	var title_conf = {};
	title_conf.fun_open ='<?=$fun_open?>';
	title_conf.fun_open_id = '<?=$fun_open_id?>';
	title_conf.title = '<?=$title;?>';
	title_conf.type = 'edit';
	
	fun_load_title(title_conf);

	switch('<?=$fun_open?>')
	{
		case 'win':
			$('#<?=$fun_open_id?>').window('resize',{width:1350});
			$('#<?=$fun_open_id?>').window('center');
			break;
	}

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

				param['content[bl]']=data_form['content[bl]'];
				param['content[bali]']=data_form['content[bali]'];
				
				param['content[trip]']=data_form['content[trip]'];
				param['content[trip_c]']=data_form['content[trip_c]'];
				param['content[trip_sub]']=data_form['content[trip_sub]'];

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
						url+='/act/<?=STAT_ACT_EDIT?>/bal_id/'+json.id

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
								reload_page<?=$time?>(url);	
							break;
						}
					}
				}
			}
		}
	});
}

//申请人自动补全
function load_bal_contact_manager<?=$time?>()
{
	var opt = $('#txtb_bal_contact_manager_s<?=$time?>').textbox('options');

	if(  opt.readonly ) return;

	$('#txtb_bal_contact_manager_s<?=$time?>').textbox({
	  onClickButton:function()
      {
			$(this).textbox('clear');
			$('#txtb_bal_contact_manager<?=$time?>').val('');
			$('#txtb_bal_c_org<?=$time?>').val('');
      }
	});

	$('#txtb_bal_contact_manager_s<?=$time?>').textbox('textbox').autocomplete({
		serviceUrl: 'base/auto/get_json_contact/search_c_login_id/1',
		width:'300',
		params:{
			rows:10,
		},
		onSelect: function (suggestion) {

			var c_id = base64_decode(suggestion.data.c_id);
			$('#txtb_bal_contact_manager_s<?=$time?>').textbox('setValue',base64_decode(suggestion.data.c_show));
			$('#txtb_bal_contact_manager<?=$time?>').val(c_id);

			$('#txtb_bal_ou_s<?=$time?>').textbox('setValue',base64_decode(suggestion.data.c_ou_bud_s));
			$('#txtb_bal_ou<?=$time?>').val(base64_decode(suggestion.data.c_ou_bud));

			$('#txtb_bal_c_org<?=$time?>').val(base64_decode(suggestion.data.c_org));

			var url = 'proc_loan/loan/get_json/flag_ending/1/search_c_id/'+c_id;
			$('#table_loan_ending<?=$time?>').datagrid('reload',url);
		}
	});
}

//部门自动补全
function load_ou<?=$time?>()
{
	var opt = $('#txtb_bal_ou_s<?=$time?>').textbox('options');

	if(  opt.readonly ) return;

	$('#txtb_bal_ou_s<?=$time?>').textbox({
	  onClickButton:function()
      {
			$(this).textbox('clear');
			$('#txtb_bal_ou<?=$time?>').val('');
      }
	});

	var org = $('#txtb_bal_c_org<?=$time?>').val();

	var json = [
		{"field":"ou_org","rule":"=","value":org},
		{"field":"ou_tag","rule":"find_in_set","value":"1"}
	]

	$('#txtb_bal_ou_s<?=$time?>').textbox('textbox').autocomplete({
      serviceUrl: 'base/auto/get_json_ou',
      width:'400',
      params:{
			rows:10,
			data_search:JSON.stringify(json)
		},
      onSelect: function (suggestion) {

			var ou_id = base64_decode(suggestion.data.ou_id);

			$('#txtb_bal_ou_s<?=$time?>').textbox('setValue',base64_decode(suggestion.data.ou_name));
			$('#txtb_bal_ou<?=$time?>').val(ou_id);
		}
	});
}

//金额
function load_bal_total_sum<?=$time?>()
{
	$('#txtb_bal_total_sum<?=$time?>').numberbox({
		readonly:true,
		buttonIcon:'icon-lock'
	});
	$('#txtb_bal_total_sum<?=$time?>').numberbox('textbox').css('text-align','right');
}

//冲账金额
function load_rei_total_sum<?=$time?>()
{
	$('#txtb_rei_total_sum<?=$time?>').numberbox({
		readonly:true,
		buttonIcon:'icon-lock'
	});
	$('#txtb_rei_total_sum<?=$time?>').numberbox('textbox').css('text-align','right');
}

//界面
function fun_index_win_open<?=$time?>(title,fun,url)
{
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
				minimizable:false,
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

//个人借款--载入
function load_table_loan_ending<?=$time?>()
{
    $('#table_loan_ending<?=$time?>').datagrid({
        width:'100%',
        height:'120',
//        toolbar:'#table_loan_ending_tool<?=$time?>',
        singleSelect:true,
        selectOnCheck:false,
        checkOnSelect:false,
        striped:true,
        remoteSort: false,
        idField:'loan_id',
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
            {field:'loan_code',title:'单据编号',width:120,halign:'center',align:'left',
                formatter: fun_table_loan_ending_formatter<?=$time?>,
            },
            {field:'loan_sum',title:'金额',width:120,halign:'center',align:'right',
                formatter: fun_table_loan_ending_formatter<?=$time?>,
            },
            {field:'loan_ending_sum',title:'未冲账金额',width:120,halign:'center',align:'right',
                formatter: fun_table_loan_ending_formatter<?=$time?>,
            },
            {field:'loan_sub_s',title:'预算科目',width:120,halign:'center',align:'center',
                formatter: fun_table_loan_ending_formatter<?=$time?>,
            },
            {field:'loan_time_node',title:'日期',width:80,halign:'center',align:'center',
                formatter: fun_table_loan_ending_formatter<?=$time?>,
            },
            {field:'loan_return_month',title:'预计归还月',width:80,halign:'center',align:'center',
                formatter: fun_table_loan_ending_formatter<?=$time?>,
            },
            {field:'ppo',title:'流程节点',width:100,halign:'center',align:'center',
                formatter: fun_table_loan_ending_formatter<?=$time?>,
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
//            if(data.total > 0) 
//            {
//            	fun_tr_title_show($('#table_f_<?=$time?>'),'title_loan_ending',1);
//            }
//            else if(data.total == 0)
//            {
//            	fun_tr_title_show($('#table_f_<?=$time?>'),'title_loan_ending');
//            }

            $('#l_<?=$time?> .prog_loan_ending_sum<?=$time?>').progressbar();
			$('#l_<?=$time?> .prog_loan_ending_sum<?=$time?>').find('.progressbar-text').css('text-align','right');
		},
		onResizeColumn: function(field, width)
		{
			if(field == 'loan_ending_sum')
			$('#l_<?=$time?> .prog_loan_ending_sum<?=$time?>').progressbar();
		},
        onBeginEdit: function(index,row)
        {
        	var ed_list=$(this).datagrid('getEditors',index);

			for(var i = 0;i < ed_list.length; i++)
			{
				
			}
        },
    });

    if(data_<?=$time?>['content[bal_contact_manager]'])
    {
    	var url = 'proc_loan/loan/get_json/flag_ending/1/search_c_id/'+data_<?=$time?>['content[bal_contact_manager]'];
    	$('#table_loan_ending<?=$time?>').datagrid('reload',url);
    }

    if( arr_view<?=$time?>.indexOf('content[loan_ending]')>-1 )
    {
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
function fun_table_loan_ending_formatter<?=$time?>(value,row,index){

	value = base64_decode(value);
    switch(this.field)
    {
	    case 'loan_code':
		    
	    	var url='proc_loan/loan/edit/act/2/loan_id/'+base64_decode(row.loan_id);
			value='<a href="javascript:void(0);" class="link" onClick="fun_index_win_open<?=$time?>(\''+base64_decode(row.loan_code)+'\',\'win\',\''+url+'\');">'+value+'</a>';
			
	    	break;
	    case 'loan_ending_sum':
			var loan_ending_sum = base64_decode(row.loan_ending_sum);
			var loan_sum = base64_decode(row.loan_sum);
			var per = parseFloat(loan_ending_sum/loan_sum*100).toFixed(2);
			
			value = num_parse(loan_ending_sum);
			value = '<div class="easyui-progressbar prog_loan_ending_sum<?=$time?>" data-options="value:'+per+',text:\''+value+'\'" style="width:100%;"></div> '

			break;
    }

    if( ! value ) value = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ;
    return '<span id="table_loan_ending<?=$time?>_'+index+'_'+this.field+'" class="table_loan_ending<?=$time?>" >'+value+'</span>';
}


//冲账--载入
function load_table_bl<?=$time?>()
{
  $('#table_bl<?=$time?>').edatagrid({
      width:'100%',
      height:'120',
//      toolbar:'#table_bl_tool<?=$time?>',
      singleSelect:true,
      selectOnCheck:false,
      checkOnSelect:false,
      striped:true,
      remoteSort: false,
      nowrap:false,
      idField:'bl_id',
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
          {field:'bl_id',title:'',width:50,align:'center',checkbox:true},
          {field:'gfc_id',title:'财务编号',width:160,halign:'center',align:'left',
              formatter: fun_table_bl_formatter<?=$time?>,
          },
          {field:'loan_id',title:'单据编号',width:160,halign:'center',align:'left',
              formatter: fun_table_bl_formatter<?=$time?>,
          },
          {field:'loan_sum',title:'借款金额',width:120,halign:'center',align:'right',
              formatter: fun_table_bl_formatter<?=$time?>,
          },
          {field:'loan_ending_sum',title:'未冲账金额',width:120,halign:'center',align:'right',
              formatter: fun_table_bl_formatter<?=$time?>,
          },
          {field:'bl_sum',title:'冲账金额',width:120,halign:'center',align:'right',
              formatter: fun_table_bl_formatter<?=$time?>,
          },
//          {field:'bali_id',title:'bali_id',width:120,halign:'center',align:'right',
//              formatter: fun_table_bl_formatter<?=$time?>,
//          },
      ]],
      rowStyler: function(index,row){
          if (row.act == <?=STAT_ACT_CREATE?>)
              return 'background:#ffd2d2';
          if (row.act == <?=STAT_ACT_REMOVE?>)
              return 'background:#e0e0e0';

      },
      onLoadSuccess: function(data)
      {
    	  	$('#l_<?=$time?> .prog_loan_ending_sum<?=$time?>').progressbar();
			$('#l_<?=$time?> .prog_loan_ending_sum<?=$time?>').find('.progressbar-text').css('text-align','right');
	  },
	  onResizeColumn: function(field, width)
	  {
			if(field == 'loan_ending_sum')
			$('#l_<?=$time?> .prog_loan_ending_sum<?=$time?>').progressbar();
	  },
      onBeginEdit: function(index,row)
      {
	      	var ed_list=$(this).datagrid('getEditors',index);
	
			for(var i = 0;i < ed_list.length; i++)
			{
				switch(ed_list[i].field)
				{
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
				}
			}
      },
      onAfterEdit: function(index, row, changes)
      {
      }
  });

  $('#table_bl<?=$time?>').datagrid('enableFilter');
  //$('#table_bl<?=$time?>').datagrid('destroyFilter');
  if( arr_view<?=$time?>.indexOf('content[bl]')>-1 )
  {
//  	  $('#table_bl<?=$time?>').edatagrid('disableEditing');
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
function fun_table_bl_formatter<?=$time?>(value,row,index){

  switch(this.field)
  {
      case 'gfc_id':

    	  var url='proc_gfc/gfc/edit/act/2/gfc_id/'+row.gfc_id;
		  value='<a href="javascript:void(0);" class="link" onClick="fun_index_win_open<?=$time?>(\''+row.gfc_id_s+'\',\'win\',\''+url+'\');">'+row.gfc_id_s+'</a>';
    	  
          break;
      case 'loan_id':

    	  var url='proc_loan/loan/edit/act/2/loan_id/'+row.loan_id;
		  value='<a href="javascript:void(0);" class="link" onClick="fun_index_win_open<?=$time?>(\''+row.loan_id_s+'\',\'win\',\''+url+'\');">'+row.loan_id_s+'</a>';

          break;
	  case 'loan_ending_sum':
			var loan_ending_sum = parseFloat(row.loan_ending_sum) //- parseFloat(row.bl_sum);
			var loan_sum = parseFloat(row.loan_sum);
			var per = parseFloat(loan_ending_sum/loan_sum*100).toFixed(2);
			
			value = num_parse(loan_ending_sum);
			value = '<div class="easyui-progressbar prog_loan_ending_sum<?=$time?>" data-options="value:'+per+',text:\''+value+'\'" style="width:100%;"></div> '
	
			break;
	  case 'loan_sum':
  	  case 'bl_sum':
	  		value = num_parse(value);
	      	break;
      default:
          if(row[this.field+'_s'])
              value = row[this.field+'_s'];
  }

  if( ! value ) value = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ;
  return '<span id="table_bl<?=$time?>_'+index+'_'+this.field+'" class="table_bl<?=$time?>" >'+value+'</span>';
}

//费用报销明细--载入
function load_table_bali<?=$time?>()
{
  $('#table_bali<?=$time?>').edatagrid({
      width:'100%',
      height:'200',
      toolbar:'#table_bali_tool<?=$time?>',
      singleSelect:true,
      selectOnCheck:false,
      checkOnSelect:false,
      striped:true,
      remoteSort: false,
      nowrap:false,
      idField:'bali_id',
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
          {field:'bali_id',title:'',width:50,align:'center',checkbox:true},
          {field:'bali_gfc_id',title:'财务编号',width:160,halign:'center',align:'left',
              formatter: fun_table_bali_formatter<?=$time?>,
              editor:{
				type:'combobox',
				options:{
  					 err:err,
					 panelHeight:'auto',
	          		 valueField: 'id',    
	                 textField: 'text',  
                  	 hasDownArrow:false,
                  	 onShowPanel: function()
                  	 {
						$(this).combobox('hidePanel');
                  	 },
                  	 buttonIcon:'icon-clear',
		     	   	 onClickButton:function()
		         	 {
						$(this).combobox('clear');
		         	 },
				}
			},
          },
          {field:'bali_sum_total',title:'金额',width:125,halign:'center',align:'right',
              formatter: fun_table_bali_formatter<?=$time?>,
              editor:{
				type:'numberbox',
				options:{
            	    err:err,
            	    required:true,
              		precision:2,
	   				min:0,
	   				groupSeparator:',',
		   			buttonIcon:'icon-clear',
		     	   	onClickButton:function()
		         	{
						$(this).numberbox('clear');
		         	},
				}
			} 
          },
          {field:'bali_sum_zzs',title:'其中增值税',width:125,halign:'center',align:'right',
              formatter: fun_table_bali_formatter<?=$time?>,
              editor:{
				type:'numberbox',
				options:{
            	    err:err,
              		precision:2,
	   				min:0,
	   				groupSeparator:',',
		   			buttonIcon:'icon-clear',
		     	   	onClickButton:function()
		         	{
						$(this).numberbox('clear');
		         	},
				}
			} 
          },
          {field:'bali_abstract',title:'内容摘要',width:120,halign:'center',align:'left',
              formatter: fun_table_bali_formatter<?=$time?>,
              editor:{
				type:'combobox',
				options:{
            	    err:err,
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
          {field:'bali_sub',title:'预算科目',width:150,halign:'center',align:'left',
              formatter: fun_table_bali_formatter<?=$time?>,
              editor:{
				type:'combobox',
				options:{
  					 err:err,
					 panelHeight:'auto',
          			 required:true,
	          		 valueField: 'id',    
	                 textField: 'text',  
                  	 hasDownArrow:false,
                  	 onShowPanel: function()
                  	 {
						$(this).combobox('hidePanel');
                  	 },
                  	 buttonIcon:'icon-clear',
		     	   	 onClickButton:function()
		         	 {
						$(this).combobox('clear');
		         	 },
				}
			},
          },
          {field:'bali_ou_tj',title:'统计部门',width:150,halign:'center',align:'left',
              formatter: fun_table_bali_formatter<?=$time?>,
              editor:{
				type:'combobox',
				options:{
  					 err:err,
					 panelHeight:'auto',
          			 required:true,
	          		 valueField: 'id',    
	                 textField: 'text',  
                  	 hasDownArrow:false,
                  	 buttonIcon:'icon-clear',
		     	   	 onClickButton:function()
		         	 {
						$(this).combobox('clear');
		         	 },
				}
			},
          },
          {field:'bali_pay_type',title:'支付方式',width:150,halign:'center',align:'left',
              formatter: fun_table_bali_formatter<?=$time?>,
              editor:{
				type:'combobox',
				options:{
            	  	err:err,
            	  	limitToList:true,
            	  	data: [<?=element('bali_pay_type',$json_field_define)?>],
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
          {field:'bali_note',title:'备注',width:150,halign:'center',align:'left',
              formatter: fun_table_bali_formatter<?=$time?>,
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
          {field:'sub_tag',title:'预算科目标签',width:150,halign:'center',align:'left',hidden:true,
              formatter: fun_table_bali_formatter<?=$time?>,
              editor:{
				type:'textbox',
			} 
          },
      ]],
      rowStyler: function(index,row){
          if (row.act == <?=STAT_ACT_CREATE?>)
              return 'background:#ffd2d2';
          if (row.act == <?=STAT_ACT_REMOVE?>)
              return 'background:#e0e0e0';
          
          if( ! '<?=$log_time?>' 
           && ('<?=$ppo?>' == '<?=BAL_PPO_FH?>' || '<?=$ppo?>' == '<?=BAL_PPO_SH?>' || '<?=$ppo?>' == '<?=BAL_PPO_SP?>')
           && row.blp_ppo_person && row.blp_ppo_person.indexOf('<?=$this->sess->userdata('c_id')?>'>-1))
        	  return 'background:#ffd2d2';
      },
      onLoadSuccess: function(data)
      {
    	  
      },
      onSelect: function(index, row)
      {
          $('#table_bl<?=$time?>').datagrid('removeFilterRule');
    	  $('#table_bl<?=$time?>').datagrid('addFilterRule', {
    			field: 'bali_id',
    			op: 'contains',
    			value: row.bali_id
    		});
    	  $('#table_bl<?=$time?>').datagrid('doFilter');
      },
      onBeginEdit: function(index,row)
      {
      		var ed_list=$(this).datagrid('getEditors',index);

      		var ed_bali_gfc_id='';
      		var ed_bali_sum_total='';
      		var ed_bali_sum_zzs='';
      		var ed_bali_sub='';
      		var ed_bali_ou_tj='';
      		var ed_bali_pay_type = '';
      		var ed_sub_tag = '';
      		
			for(var i = 0;i < ed_list.length; i++)
			{
				switch(ed_list[i].field)
				{
					case 'bali_gfc_id':
						ed_bali_gfc_id = ed_list[i].target;
						break;
					case 'bali_sum_total':
						ed_bali_sum_total = ed_list[i].target;
						$(ed_list[i].target).numberbox('textbox').css('text-align','right');

						if(row.bali_pay_type == '<?=LOAN_PAY_TYPE_CHARGEOFFS?>')
						{
							$(ed_list[i].target).numberbox('readonly');
							$(ed_list[i].target).numberbox('textbox').prev().find('.icon-clear').removeClass('icon-clear').addClass('icon-lock');
						}
						
						break;
					case 'bali_sum_zzs':
						ed_bali_sum_zzs = ed_list[i].target;
						$(ed_list[i].target).numberbox('textbox').css('text-align','right');
						break;
					case 'bali_sub':
						ed_bali_sub = ed_list[i].target;
  						break;
					case 'bali_ou_tj':
						ed_bali_ou_tj = ed_list[i].target;
  						break;
					case 'bali_abstract':

						if('<?=$ppo?>' == '<?=BAL_PPO_END?>' || '<?=$ppo?>' >= '<?=BAL_PPO_GZ?>')
						{
							$(ed_list[i].target).combobox({
								value : row.bali_abstract,
							});

							$(ed_list[i].target).combobox('reload','base/auto/get_json_sub/search_sub_tag/<?=SUB_TAG_BAL?>/from/combobox/field_id/sub_id/field_text/sub_name')
							
							$(ed_list[i].target).combobox('textbox').bind('focus',
							function(){
								$(this).parent().prev().combobox('showPanel');
							});
						}
						else
						{
							$(ed_list[i].target).combobox({
								hasDownArrow: false,
								onShowPanel: function()
								{
									$(this).combobox('hidePanel');
								}
							});
						}

						$(ed_list[i].target).combobox('setValue',row.bali_abstract);
							
						break;
					case 'bali_pay_type':

						ed_bali_pay_type = ed_list[i].target;
						
  						break;
					case 'sub_tag':
						ed_sub_tag = ed_list[i].target;
  						break;
				}
			}
			
			$(ed_bali_gfc_id).combobox({
				 onChange:function(nV,oV)
              	 {
					if( ! nV && oV )
					{
						$(ed_bali_sub).combobox('clear');
						$(ed_bali_sub).combobox();
						fun_load_bali_sub<?=$time?>(ed_bali_sub,'',ed_bali_ou_tj,ed_bali_sum_total,ed_sub_tag);
					}
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
				
					     $('#'+win_id).window('refresh','proc_gfc/gfc/index/fun_open/window/fun_open_id/'+win_id+'/flag_select/2/fun_select/fun_get_gfc_id<?=$time?>/search_gfc_finance_code/1');
					     $('#'+win_id).window('center');
					}
				}]
			});
			
			$(ed_bali_gfc_id).combobox('textbox').autocomplete({
				serviceUrl: 'proc_gfc/gfc/get_json/search_gfc_finance_code/1',
				width:200,
				params:{
					rows:10,
					field_s:'gfc_name,gfc_finance_code,gfc_c,gfc_sum,gfc_org,gfc_org_jia,gfc_tax'
				},
				onSelect: function (suggestion) {

					var row = suggestion.data;

					var gfc_id = base64_decode(row.gfc_id);
					$(ed_bali_gfc_id).combobox('setValue',gfc_id);
					$(ed_bali_gfc_id).combobox('setText',base64_decode(row.gfc_finance_code));

					$(ed_bali_sub).combobox('clear');
					$(ed_bali_sub).combobox();
					fun_load_bali_sub<?=$time?>(ed_bali_sub,gfc_id,ed_bali_ou_tj,ed_bali_sum_total,ed_sub_tag);
				}
			});
			
			$(ed_bali_gfc_id).combobox('setValue',row.bali_gfc_id);
			$(ed_bali_gfc_id).combobox('setText',row.bali_gfc_id_s);

			fun_load_bali_sub<?=$time?>(ed_bali_sub,row.bali_gfc_id,ed_bali_ou_tj,ed_bali_sum_total,ed_sub_tag);
					
			$(ed_bali_sub).combobox('setValue',row.bali_sub);
			$(ed_bali_sub).combobox('setText',row.bali_sub_s);
			
			fun_load_bali_sub_final<?=$time?>();
			
			$(ed_bali_ou_tj).combobox({
				 onBeforeLoad:function()
				 {
				 	if( check_bali_ou_tj<?=$time?> != 1 ) 
				 	return false;
				 },
				 onLoadSuccess:function()
				 {
				 	var data = $(this).combobox('getData');
				 	if(data.length == 0 ) 
				 	{ 
				 	  load_bali_ou_tj_auto<?=$time?>(ed_bali_ou_tj);
				 	  return;
				 	}
				 	else
				 	for( var i = 0 ;i < data.length ; i++)
				 	{
				 		if(data[i].flag_read && i == 0) 
				 		{ 
				 		  load_bali_ou_tj_auto<?=$time?>(ed_bali_ou_tj);
				 		  return;
				 		}
				 	}
				 	
				 	load_bali_ou_tj_combobox<?=$time?>(ed_bali_ou_tj);
				 }
			});

			fun_load_bali_ou_tj<?=$time?>(ed_bali_ou_tj,row.bali_sub,row.bali_sum_total,row.bali_ou_tj);

			$(ed_bali_ou_tj).combobox('setValue',row.bali_ou_tj);
			$(ed_bali_ou_tj).combobox('setText',row.bali_ou_tj_s);

			$(ed_bali_pay_type).combobox({
				value:row.bali_pay_type,
				onChange:function(nV,oV)
	         	{
					if( nV != '<?=LOAN_PAY_TYPE_CHARGEOFFS?>' )
					{
						$(this).combobox('getIcon',0).hide();
						fun_clear_loan<?=$time?>(row.bali_id);

						$(ed_bali_sum_total).numberbox('readonly',false);
						$(ed_bali_sum_total).numberbox('textbox').prev().find('.icon-lock').removeClass('icon-lock').addClass('icon-clear');

					}
					else
					{
						$(this).combobox('getIcon',0).show();
						$(this).combobox('getIcon',0).click();

						$(ed_bali_sum_total).numberbox('readonly');
						$(ed_bali_sum_total).numberbox('textbox').prev().find('.icon-clear').removeClass('icon-clear').addClass('icon-lock');
					}
	         	},
				icons: [{
            		iconCls:'icon-search',
            		handler: function(e){

        				var loan_gfc_id = $(ed_bali_gfc_id).combobox('getValue');
        				var loan_c_id = $('#txtb_bal_contact_manager<?=$time?>').val();
        				var loan_sub = $(ed_bali_sub).combobox('getValue');

        				if( ! loan_c_id || ! loan_sub )
        				{
        					$.messager.show({
        				    	title:'警告',
        				    	msg:'请选择申请人以及预算科目！',
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

						var win_id=fun_get_new_win();
						
					    $('#'+win_id).window({
					     	title: '请选择非开票',
					     	width:1300,
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
				
						var url = 'proc_bal/bal/index_loan_ending/fun_open/window/fun_open_id/'+win_id+'/flag_select/1/fun_select/fun_get_loan<?=$time?>';
						
						url += '/loan_c_id/'+loan_c_id;
						url += '/loan_sub/'+loan_sub;
						url += '/loan_gfc_id/'+loan_gfc_id;
						
						layer.closeAll();
					     $('#'+win_id).window('refresh',url);
					     $('#'+win_id).window('center');
            		}
            	}],
			});

			if( row.bali_pay_type != '<?=LOAN_PAY_TYPE_CHARGEOFFS?>' )
			{
				$(ed_bali_pay_type).combobox('getIcon',0).hide();
				fun_clear_loan<?=$time?>(row.bali_id);
			}

			$(ed_bali_pay_type).combobox('textbox').bind('focus',
					function(){
				$(this).parent().prev().combobox('showPanel');
			});
      },
      onEndEdit: function(index, row, changes)
      {
      		var ed_list=$(this).datagrid('getEditors',index);

			for(var i = 0;i < ed_list.length; i++)
			{
				switch(ed_list[i].field)
				{
					case 'bali_abstract':
						row.bali_abstract_s = $(ed_list[i].target).combobox('getText');
						
						if('<?=$ppo?>'  > '<?=BAL_PPO_END?>' && '<?=$ppo?>' < '<?=BAL_PPO_GZ?>')
						row.bali_abstract = $(ed_list[i].target).combobox('getText');

						break;
					case 'bali_pay_type':
						row.bali_pay_type_s = $(ed_list[i].target).combobox('getText');
						break;
					case 'bali_sum_zzs':
						if( ! row.bali_sum_zzs) row.bali_sum_zzs = 0;
						if( row.bali_sum_zzs > row.bali_sum_total) row.bali_sum_zzs = row.bali_sum_total;
						break;
					case 'bali_sub':
					case 'bali_ou_tj':
					case 'bali_gfc_id':
						row[ed_list[i].field] = $(ed_list[i].target).combobox('getValue');
						row[ed_list[i].field+'_s'] = $(ed_list[i].target).combobox('getText');
						break;
				}
			}

//			layer.close(index_bali_sub_final<?=$time?>);
			layer.closeAll();
			$('.sui-suggestion-container').remove();

			fun_show_trip<?=$time?>();

			fun_count_bal_total_sum<?=$time?>();
      },
      onAfterEdit: function(index, row, changes)
      {
          
      }
  });

  if( arr_view<?=$time?>.indexOf('content[bali]')>-1 )
  {
  	  $('#table_bali<?=$time?>').edatagrid('disableEditing');
      $('#table_bali_tool<?=$time?> .oa_op').hide();
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

//选择非开票
function fun_get_loan<?=$time?>(op)
{
	var row_s = $(op).datagrid('getSelected');
	var index_s = $(op).datagrid('getRowIndex',row_s);
	
    $(op).datagrid('endEdit',index_s);
    
	var row_c=$(op).datagrid('getChecked');
	 
	if( row_c.length == 0) 
	{
		$.messager.show({
	    	title:'警告',
	    	msg:'请选择非开票！',
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

	$(op).closest('.op_window').window('close');

	var row_s = $('#table_bali<?=$time?>').datagrid('getSelected');
	var index_s = $('#table_bali<?=$time?>').datagrid('getRowIndex',row_s);
	
	var ed_list=$('#table_bali<?=$time?>').datagrid('getEditors',index_s);

	var ed_bali_sum_total = '';
		
	for(var i = 0;i < ed_list.length; i++)
	{
		switch(ed_list[i].field)
		{
			case 'bali_sum_total':
				ed_bali_sum_total = ed_list[i].target;
				break;
		}
	}

	var bali_sum_total = 0;

	fun_clear_loan<?=$time?>(row_s.bali_id);

	for(var i = 0;i<row_c.length;i++)
	{
		var row_bl = {};
		row_bl.bl_id = get_guid();
		
		row_bl.bali_id = row_s.bali_id;
		
		row_bl.gfc_id = base64_decode(row_c[i].loan_gfc_id);
		row_bl.gfc_id_s = base64_decode(row_c[i].gfc_finance_code);
		row_bl.loan_id = base64_decode(row_c[i].loan_id);
		row_bl.loan_id_s = base64_decode(row_c[i].loan_code);
		row_bl.loan_sum = base64_decode(row_c[i].loan_sum);
		row_bl.loan_ending_sum = parseFloat(base64_decode(row_c[i].loan_ending_sum));
		row_bl.bl_sum = parseFloat(row_c[i].bl_sum);
		
		if( row_bl.bl_sum > row_bl.loan_ending_sum ) 
			row_bl.bl_sum = row_bl.loan_ending_sum;
				
		$('#table_bl<?=$time?>').datagrid('appendRow',row_bl);

		bali_sum_total+= parseFloat(row_bl.bl_sum);
	}

	$(ed_bali_sum_total).numberbox('setValue',bali_sum_total);
}

//清空非开票
function fun_clear_loan<?=$time?>(bali_id)
{
	var rows = $('#table_bl<?=$time?>').datagrid('getRows');

	for(var i=0;i<rows.length;i++)
	{
		if(rows[i].bali_id == bali_id )
		{
			var index = $('#table_bl<?=$time?>').datagrid('getRowIndex',rows[i]);
			$('#table_bl<?=$time?>').datagrid('deleteRow',index);
		}
	}
}

//计算费用总数
function fun_count_bal_total_sum<?=$time?>()
{
	var rows = $('#table_bali<?=$time?>').datagrid('getRows');

	var bal_total_sum = 0;
	var rei_total_sum = 0;
	
	for(var i=0;i<rows.length;i++)
	{
		bal_total_sum += parseFloat(rows[i].bali_sum_total);

		if(rows[i].bali_pay_type == '<?=LOAN_PAY_TYPE_CHARGEOFFS?>')
		rei_total_sum += parseFloat(rows[i].bali_sum_total);
	}

	$('#txtb_bal_total_sum<?=$time?>').numberbox('setValue',bal_total_sum);
	$('#txtb_rei_total_sum<?=$time?>').numberbox('setValue',rei_total_sum);
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
	
	var row_s = $('#table_bali<?=$time?>').datagrid('getSelected');
	var index_s = $('#table_bali<?=$time?>').datagrid('getRowIndex',row_s);
	
	var ed_list=$('#table_bali<?=$time?>').datagrid('getEditors',index_s);

	var ed_bali_gfc_id='';
	var ed_bali_sub='';
	var ed_bali_ou_tj='';
	var ed_bali_sum_total = '';
		
	for(var i = 0;i < ed_list.length; i++)
	{
		switch(ed_list[i].field)
		{
			case 'bali_gfc_id':
				ed_bali_gfc_id = ed_list[i].target;
				break;
			case 'bali_sum_total':
				ed_bali_sum_total = ed_list[i].target;
				break;
			case 'bali_sub':
				ed_bali_sub = ed_list[i].target;
				break;
			case 'bali_ou_tj':
				ed_bali_ou_tj = ed_list[i].target;
				break;
		}
	}

	var gfc_id = base64_decode(row.gfc_id);
	$(ed_bali_gfc_id).combobox('setValue',gfc_id);
	$(ed_bali_gfc_id).combobox('setText',base64_decode(row.gfc_finance_code));

	$(ed_bali_sub).combobox('clear');
	$(ed_bali_sub).combobox();
	fun_load_bali_sub<?=$time?>(ed_bali_sub,row.bali_gfc_id,ed_bali_ou_tj,ed_bali_sum_total,ed_sub_tag);
}

//
function fun_load_bali_sub<?=$time?>(ed_bali_sub,bali_gfc_id,ed_bali_ou_tj,ed_bali_sum_total,ed_sub_tag)
{
	
	var url = 'base/auto/get_json_sub/search_sub_class/3'

	if(bali_gfc_id)
		url = 'base/auto/get_json_sub/search_gfc_id/'+bali_gfc_id;

	$(ed_bali_sub).combobox('textbox').autocomplete({
		serviceUrl: url,
		width:300,
		params:{
			rows:10,
		},
		onSelect: function (suggestion) {

			var sub_id = base64_decode(suggestion.data.sub_id)
			$(ed_bali_sub).combobox('setValue',sub_id);
			$(ed_bali_sub).combobox('setText',base64_decode(suggestion.data.sub_name));

			var sum = $(ed_bali_sum_total).numberbox('getValue');
			var sub = sub_id;
			
			if( sub && sum)
			{
				var url = 'proc_bud/bl_ppo/get_json_ou/from/combobox/field_id/link_id/field_text/ou_name/search_sub/'+sub+'/search_sum/'+sum;
				$(ed_bali_ou_tj).combobox('reload',url);
			}

			fun_load_bali_sub_final<?=$time?>();

			//差旅费填写
			var sub_tag = base64_decode(suggestion.data.sub_tag);
			$(ed_sub_tag).textbox('setValue',sub_tag);
		}
	});
}

function fun_show_trip<?=$time?>()
{
	var rows = $('#table_bali<?=$time?>').edatagrid('getRows');

	for(var i=0;i<rows.length;i++)
	{
		if(rows[i].sub_tag && rows[i].sub_tag.indexOf('<?=SUB_TAG_TRIP?>') > -1)
		{
			fun_tr_title_show($('#table_f_<?=$time?>'),'title_trip',1);
			fun_tr_title_show($('#table_f_<?=$time?>'),'title_trip_c',1);
			fun_tr_title_show($('#table_f_<?=$time?>'),'title_trip_sub',1);
			
//			$('#table_trip<?=$time?>').datagrid();
//			$('#table_trip_c<?=$time?>').datagrid();
//			$('#table_trip_sub<?=$time?>').datagrid();
			return;
		}
	}

	fun_tr_title_show($('#table_f_<?=$time?>'),'title_trip',0);
	fun_tr_title_show($('#table_f_<?=$time?>'),'title_trip_c',0);
	fun_tr_title_show($('#table_f_<?=$time?>'),'title_trip_sub',0);
}

var index_bali_sub_final<?=$time?> ;
function fun_load_bali_sub_final<?=$time?>()
{
	var row_s = $('#table_bali<?=$time?>').datagrid('getSelected');
	var index_s = $('#table_bali<?=$time?>').datagrid('getRowIndex',row_s);
	
	var ed_list=$('#table_bali<?=$time?>').datagrid('getEditors',index_s);
	
	var ed_bali_gfc_id='';
	var ed_bali_sub='';
	var ed_bali_ou_tj='';
	var ed_bali_sum_total = '';
	
	var sum = 0;
	var sub_id = '';
	var gfc_id = '';
	
	for(var i = 0;i < ed_list.length; i++)
	{
		switch(ed_list[i].field)
		{
			case 'bali_gfc_id':
				ed_bali_gfc_id = ed_list[i].target;
				gfc_id = $(ed_bali_gfc_id).combobox('getValue');
				break;
			case 'bali_sum_total':
				ed_bali_sum_total = ed_list[i].target;
				sum = $(ed_bali_sum_total).numberbox('getValue');
				break;
			case 'bali_sub':
				ed_bali_sub = ed_list[i].target;
				sub_id = $(ed_bali_sub).combobox('getValue');
				break;
			case 'bali_ou_tj':
				ed_bali_ou_tj = ed_list[i].target;
				break;
		}
	}
	

	if( ! gfc_id || ! sub_id ) return; 

	$.ajax({
        url:"proc_gfc/gfc/get_bud_final",
        type:"POST",
        data:{
			'content[gfc_id]' : gfc_id,
			'content[sub_id]' : sub_id,
			'content[id]': row_s.bali_id
        },
        success:function(data){

        	if( ! data ) return;

            var json = JSON.parse(data);

            json.sum_final_no = parseFloat(json.sum_final_no);
            
            var per_final = parseFloat(json.sum_final/json.sum_bud*100).toFixed(2);
            var per_final_no = parseFloat(json.sum_final_no/json.sum_bud*100).toFixed(2);
            var per_sum = parseFloat(sum/json.sum_bud*100).toFixed(2);
            
            var html = '<div class="sui-progress" style="width:200px;">'
                	   +'<div style="width: '+per_final+'%;" class="bar " onmouseenter="layer.tips(\'已执行:'+num_parse(json.sum_final)+'\', this);"></div>'
                	   +'<div style="width: '+per_sum+'%;" class="bar bar-success" onmouseenter="layer.tips(\'本次金额:'+num_parse(sum)+'\', this);"></div>'
                	   +'<div style="width: '+per_final_no+'%;" class="bar bar-warning" onmouseenter="layer.tips(\'未过账:'+num_parse(json.sum_final_no)+'\', this);"></div>'
                	   +'<div style="position:absolute; left:0px;width:100%;text-align:center;">预算:'+num_parse(json.sum_bud)+' </div>'
                	   +'</div>'

            $(ed_bali_sub).combobox('textbox').bind('mouseenter',function(e){

            	index_bali_sub_final<?=$time?> = layer.open({
          		  offset: [e.pageY-80, e.pageX],
          		  id :'layer_bali_sub_final<?=$time?>',
          		  type: 1,
          		  shade: false,
          		  title: false,//'后台任务', 
          		  anim: 0,
          		  closeBtn: 0,
          		  resize:false,
          		  content: html, 
	              end : function()
	      		  {
          			index_bali_sub_final<?=$time?>='';
	      		  }
          		});
            });  
		}
    });
}

var check_bali_ou_tj<?=$time?> = 1
function fun_load_bali_ou_tj<?=$time?>(ed_bali_ou_tj,bali_sub,bali_sum_total,bali_ou_tj)
{
	var sum = bali_sum_total;
	var sub = bali_sub;
	var ou = bali_ou_tj
	if( sub )
	{
		var url = 'proc_bud/bl_ppo/get_json_ou/from/combobox/field_id/link_id/field_text/ou_name/search_sub/'+sub+'/search_sum/'+sum;
		if( ou ) url += '/search_ou/'+ou;
		
		$(ed_bali_ou_tj).combobox('reload',url);
	}
}

function load_bali_ou_tj_combobox<?=$time?>(ed_bali_ou_tj)
{
	var opt = $(ed_bali_ou_tj).combobox('options');

	if(  opt.hasDownArrow ) return;
	
	check_bali_ou_tj<?=$time?> = 0;
	
	$(ed_bali_ou_tj).combobox({
		hasDownArrow:true,
		limitToList:true,
		buttonIcon:'icon-clear',
		onClickButton:function()
		{
			$(this).combobox('clear');
		}
	});

	var row_s = $('#table_bali<?=$time?>').datagrid('getSelected');

	if(row_s.bali_ou_tj)
	{
		$(ed_bali_ou_tj).combobox('setValue',row_s.bali_ou_tj);
	}

	$(ed_bali_ou_tj).combobox('textbox').bind('focus',
	function(){
		$(this).parent().prev().combobox('showPanel');
	});

	check_bali_ou_tj<?=$time?> = 1;
}

function load_bali_ou_tj_auto<?=$time?>(ed_bali_ou_tj)
{
	var opt = $(ed_bali_ou_tj).combobox('options');

	check_bali_ou_tj<?=$time?> = 0;
	
	$(ed_bali_ou_tj).combobox({
		hasDownArrow:false,
		limitToList:false,
		buttonIcon:'icon-clear',
		onClickButton:function()
		{
			$(this).combobox('clear');
		}
	});
	
	var json = [
		{"field":"ou_tag","rule":"find_in_set","value":"1"}
	]

	var row_s = $('#table_bali<?=$time?>').datagrid('getSelected');

	if(row_s.bali_ou_tj)
	{
		$(ed_bali_ou_tj).combobox('setValue',row_s.bali_ou_tj);
		$(ed_bali_ou_tj).combobox('setText',row_s.bali_ou_tj_s);
	}
	
	$(ed_bali_ou_tj).combobox('textbox').autocomplete({
        serviceUrl: 'base/auto/get_json_ou',
        width:'400',
        params:{
			rows:10,
			data_search:JSON.stringify(json)
		},
        onSelect: function (suggestion) {

			var ou_id = base64_decode(suggestion.data.ou_id);
			var ou_name = base64_decode(suggestion.data.ou_name)

			$(ed_bali_ou_tj).combobox('setValue',ou_id);
			$(ed_bali_ou_tj).combobox('setText',ou_name);
		}
	});

	check_bali_ou_tj<?=$time?> = 1;
}

//列格式化输出
function fun_table_bali_formatter<?=$time?>(value,row,index){

  switch(this.field)
  {
  	  case 'bali_sum_total':
  	  case 'bali_sum_zzs':
	  		value = num_parse(value);
	      	break;
  	  case 'bali_gfc_id':

  		    if(row.bali_gfc_id)
  		    {
	  	 	    var url='proc_gfc/gfc/edit/act/2/gfc_id/'+row.bali_gfc_id;
			    value='<a href="javascript:void(0);" class="link" onClick="fun_index_win_open<?=$time?>(\''+row.bali_gfc_id_s+'\',\'win\',\''+url+'\');">'+row.bali_gfc_id_s+'</a>';
  		    }
  			break;
      default:
          if(row[this.field+'_s'])
              value = row[this.field+'_s'];
  }

  if( ! value ) value = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ;
  return '<span id="table_bali<?=$time?>_'+index+'_'+this.field+'" class="table_bali<?=$time?>" >'+value+'</span>';
}

//费用报销明细--操作
function fun_table_bali_operate<?=$time?>(btn)
{
  switch(btn)
  {
      case 'add':

	      	var row_s = $('#table_bali<?=$time?>').datagrid('getSelected');
	      	var index_s = $('#table_bali<?=$time?>').datagrid('getRowIndex',row_s);
	      	if( index_s > -1)
	      	{
					if($('#table_bali<?=$time?>').datagrid('validateRow',index_s))
						$('#table_bali<?=$time?>').datagrid('endEdit',index_s)
					else
						return;//$('#table_bali<?=$time?>').datagrid('cancelEdit',index_s)
	      	}
	      	
      		var op_id = get_guid();
			$('#table_bali<?=$time?>').edatagrid('addRow',{
				index:0,
				row:{
					bali_id: op_id,
				}
			});

          break;
      case 'del':

          var op_list=$('#table_bali<?=$time?>').datagrid('getChecked');

          var row_s = $('#table_bali<?=$time?>').datagrid('getSelected');
          var index_s = $('#table_bali<?=$time?>').datagrid('getRowIndex',row_s);

          if($('#table_bali<?=$time?>').datagrid('validateRow',index_s))
          {
              $('#table_bali<?=$time?>').datagrid('endEdit',index_s);
          }
          else
          {
              $('#table_bali<?=$time?>').datagrid('cancelEdit',index_s);
          }

          for(var i=op_list.length-1;i>-1;i--)
          {
              var index = $('#table_bali<?=$time?>').datagrid('getRowIndex',op_list[i]);
              $('#table_bali<?=$time?>').datagrid('deleteRow',index);
          }
                  
          break;
  }

}


//差旅费--载入
function load_table_trip<?=$time?>()
{
  $('#table_trip<?=$time?>').edatagrid({
      width:'100%',
      height:'200',
      toolbar:'#table_trip_tool<?=$time?>',
      singleSelect:true,
      selectOnCheck:false,
      checkOnSelect:false,
      striped:true,
      remoteSort: false,
      showFooter:true,
      idField:'bali_tr_id',
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
			{field:'bali_tr_id',title:'',width:50,align:'center',checkbox:true,rowspan:2},
			{field:'title_out',title:'出发',width:225,align:'center',colspan:2},
			{field:'title_in',title:'到达',width:225,align:'center',colspan:2},
			{field:'baltr_traffic',title:'交通工具',width:80,halign:'center',align:'center',rowspan:2,
			    formatter: fun_table_trip_formatter<?=$time?>,
	    		editor:{
					type:'textbox',
					options:{
			    		 required:true,
				    	 buttonIcon:'icon-clear',
			     	   	 onClickButton:function()
			         	 {
							$(this).textbox('clear');
			         	 },
					}
				} 
			},
			{field:'title_tra',title:'车船票',width:170,align:'center',colspan:2},
			{field:'title_tra',title:'其他费用',width:470,align:'center',colspan:5},
			{field:'baltr_tatal_sum',title:'合计',width:100,halign:'center',align:'right',rowspan:2,
              formatter: fun_table_trip_formatter<?=$time?>,
              editor:{
					type:'numberbox',
					options:{
						readonly:true,
              		precision:2,
		   				min:0,
		   				groupSeparator:',',
		   				buttonIcon:'icon-lock',
					}
				} 
          },
      ],[
          {field:'baltr_time_out',title:'时间',width:125,halign:'center',align:'center',sortable:true,
              formatter: fun_table_trip_formatter<?=$time?>,
              editor:{
					type:'datebox',
					options:{
              		 required:true,
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
          {field:'baltr_place_out',title:'地点',width:100,halign:'center',align:'center',
			    formatter: fun_table_trip_formatter<?=$time?>,
	    		editor:{
					type:'textbox',
					options:{
			   	 		 required:true,
				    	 buttonIcon:'icon-clear',
			     	   	 onClickButton:function()
			         	 {
							$(this).textbox('clear');
			         	 },
					}
				} 
			},
          {field:'baltr_time_in',title:'时间',width:125,halign:'center',align:'center',
              formatter: fun_table_trip_formatter<?=$time?>,
              editor:{
					type:'datebox',
					options:{
              		 required:true,
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
          {field:'baltr_place_in',title:'地点',width:100,halign:'center',align:'center',
			    formatter: fun_table_trip_formatter<?=$time?>,
	    		editor:{
					type:'textbox',
					options:{
			    		 required:true,
				    	 buttonIcon:'icon-clear',
			     	   	 onClickButton:function()
			         	 {
							$(this).textbox('clear');
			         	 },
					}
				} 
			},
          {field:'baltr_tra_count',title:'单据张数',width:70,halign:'center',align:'right',
              formatter: fun_table_trip_formatter<?=$time?>,
              editor:{
					type:'numberbox',
					options:{
              		required:true,
              		precision:0,
		   				min:0,
		   				groupSeparator:',',
		   				buttonIcon:'icon-clear',
			     	   	onClickButton:function()
			         	{
							$(this).numberbox('clear');
			         	},
					}
				} 
          },
          {field:'baltr_tra_sum',title:'金额',width:100,halign:'center',align:'right',
              formatter: fun_table_trip_formatter<?=$time?>,
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
					}
				} 
          },
          {field:'baltr_other_count',title:'单据',width:70,halign:'center',align:'right',
              formatter: fun_table_trip_formatter<?=$time?>,
              editor:{
					type:'numberbox',
					options:{
//              		required:true,
              		precision:0,
		   				min:0,
		   				groupSeparator:',',
		   				buttonIcon:'icon-clear',
			     	   	onClickButton:function()
			         	{
							$(this).numberbox('clear');
			         	},
					}
				} 
          },
          {field:'baltr_city_sum',title:'市内交通',width:100,halign:'center',align:'right',
              formatter: fun_table_trip_formatter<?=$time?>,
              editor:{
					type:'numberbox',
					options:{
//              		required:true,
              		precision:2,
		   				min:0,
		   				groupSeparator:',',
		   				buttonIcon:'icon-clear',
			     	   	onClickButton:function()
			         	{
							$(this).numberbox('clear');
			         	},
					}
				} 
          },
          {field:'baltr_room_sum',title:'住宿',width:100,halign:'center',align:'right',
              formatter: fun_table_trip_formatter<?=$time?>,
              editor:{
					type:'numberbox',
					options:{
//              		required:true,
              		precision:2,
		   				min:0,
		   				groupSeparator:',',
		   				buttonIcon:'icon-clear',
			     	   	onClickButton:function()
			         	{
							$(this).numberbox('clear');
			         	},
					}
				} 
          },
          {field:'baltr_food_sum',title:'伙食',width:100,halign:'center',align:'right',
              formatter: fun_table_trip_formatter<?=$time?>,
              editor:{
					type:'numberbox',
					options:{
//              		required:true,
              		precision:2,
		   				min:0,
		   				groupSeparator:',',
		   				buttonIcon:'icon-clear',
			     	   	onClickButton:function()
			         	{
							$(this).numberbox('clear');
			         	},
					}
				} 
          },
          {field:'baltr_other_sum',title:'其他',width:100,halign:'center',align:'right',
              formatter: fun_table_trip_formatter<?=$time?>,
              editor:{
					type:'numberbox',
					options:{
//              		required:true,
              		precision:2,
		   				min:0,
		   				groupSeparator:',',
		   				buttonIcon:'icon-clear',
			     	   	onClickButton:function()
			         	{
							$(this).numberbox('clear');
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
					case 'baltr_time_out':
					case 'baltr_time_in':
						
						$(ed_list[i].target).datebox('textbox').bind('focus',
						function(){
							$(this).parent().prev().datebox('showPanel');
						});
						break;
					case 'baltr_tra_sum':
					case 'baltr_city_sum':
					case 'baltr_room_sum':
					case 'baltr_food_sum':
					case 'baltr_other_sum':
					case 'baltr_tatal_sum':

						$(ed_list[i].target).numberbox({
							onChange:function(nV,oV)
							{
								fun_count_trip_total<?=$time?>();
							}
						});
						
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
//					case 'baltr_tra_sum':
					case 'baltr_city_sum':
					case 'baltr_room_sum':
					case 'baltr_food_sum':
					case 'baltr_other_sum':
						if( ! row[ed_list[i].field] )
							row[ed_list[i].field] = 0;
						
						break;
				}
			}

			fun_load_trip_foot<?=$time?>();
      },
      onLoadSuccess: function(data)
		{
      	fun_load_trip_foot<?=$time?>();
		},
      onResizeColumn: function(field, width)
		{
		}
  });

  if( arr_view<?=$time?>.indexOf('content[trip]')>-1 )
  {
  	$('#table_trip<?=$time?>').edatagrid('disableEditing');
      $('#table_trip_tool<?=$time?> .oa_op').hide();
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

//行合计
function fun_count_trip_total<?=$time?>(){

	var row_s = $('#table_trip<?=$time?>').edatagrid('getSelected');
	var index_s = $('#table_trip<?=$time?>').edatagrid('getRowIndex',row_s);

	var ed_list=$('#table_trip<?=$time?>').datagrid('getEditors',index_s);

	var sum_total = 0;
	
	for(var i = 0;i < ed_list.length; i++)
	{
		switch(ed_list[i].field)
		{
			case 'baltr_tra_sum':
			case 'baltr_city_sum':
			case 'baltr_room_sum':
			case 'baltr_food_sum':
			case 'baltr_other_sum':
				var sum= $(ed_list[i].target).numberbox('getValue');
				if( ! sum ) sum = 0;
				sum_total += parseFloat(sum);
				break;
			case 'baltr_tatal_sum':
				$(ed_list[i].target).numberbox('setValue',sum_total);
				break;
		}
	}
	
}

//底部小计
function fun_load_trip_foot<?=$time?>(){

	var row =  $('#table_trip<?=$time?>').edatagrid('getRows');
	var foot = {};

	foot.baltr_tra_sum = 0;
	foot.baltr_city_sum = 0;
	foot.baltr_room_sum = 0;
	foot.baltr_food_sum = 0;
	foot.baltr_other_sum = 0;
	foot.baltr_tatal_sum = 0;
	
	for(var i=0;i<row.length;i++)
	{
		foot.baltr_tra_sum += parseFloat(row[i].baltr_tra_sum);
		foot.baltr_city_sum += parseFloat(row[i].baltr_city_sum);
		foot.baltr_room_sum += parseFloat(row[i].baltr_room_sum);
		foot.baltr_food_sum += parseFloat(row[i].baltr_food_sum);
		foot.baltr_other_sum += parseFloat(row[i].baltr_other_sum);
		foot.baltr_tatal_sum += parseFloat(row[i].baltr_tatal_sum);
	}

	$('#table_trip<?=$time?>').datagrid('reloadFooter',[
  	foot
  ]);
	                              	
}

//列格式化输出
function fun_table_trip_formatter<?=$time?>(value,row,index){

  switch(this.field)
  {
	    case 'baltr_tra_sum':
		case 'baltr_city_sum':
		case 'baltr_room_sum':
		case 'baltr_food_sum':
		case 'baltr_other_sum':
		case 'baltr_tatal_sum':
  		value = num_parse(value);
      	break;
      	
      default:
          if(row[this.field+'_s'])
              value = row[this.field+'_s'];
  }

  if( ! value ) value = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ;
  return '<span id="table_trip<?=$time?>_'+index+'_'+this.field+'" class="table_trip<?=$time?>" >'+value+'</span>';
}

//差旅费--操作
function fun_table_trip_operate<?=$time?>(btn)
{
  switch(btn)
  {
      case 'add':

      	var row_s = $('#table_trip<?=$time?>').datagrid('getSelected');
      	var index_s = $('#table_trip<?=$time?>').datagrid('getRowIndex',row_s);
      	if( index_s > -1)
      	{
      		if($('#table_trip<?=$time?>').datagrid('validateRow',index_s))
					$('#table_trip<?=$time?>').datagrid('endEdit',index_s)
				else
					return;//$('#table_trip<?=$time?>').datagrid('cancelEdit',index_s)
      	}
      	
      	var op_id = get_guid();
			$('#table_trip<?=$time?>').edatagrid('addRow',{
				index:0,
				row:{
					bali_tr_id: op_id,
				}
			});

          break;
      case 'del':

          var op_list=$('#table_trip<?=$time?>').datagrid('getChecked');

          var row_s = $('#table_trip<?=$time?>').datagrid('getSelected');
          var index_s = $('#table_trip<?=$time?>').datagrid('getRowIndex',row_s);

          if($('#table_trip<?=$time?>').datagrid('validateRow',index_s))
          {
              $('#table_trip<?=$time?>').datagrid('endEdit',index_s);
          }
          else
          {
              $('#table_trip<?=$time?>').datagrid('cancelEdit',index_s);
          }

          for(var i=op_list.length-1;i>-1;i--)
          {
              var index = $('#table_trip<?=$time?>').datagrid('getRowIndex',op_list[i]);
              $('#table_trip<?=$time?>').datagrid('deleteRow',index);
          }
                  
          break;
  }

}

//出差人--载入
var err_table_trip_c<?=$time?> = '';
function load_table_trip_c<?=$time?>()
{
  $('#table_trip_c<?=$time?>').edatagrid({
      width:'100%',
      height:'150',
      toolbar:'#table_trip_c_tool<?=$time?>',
      singleSelect:true,
      selectOnCheck:false,
      checkOnSelect:false,
      striped:true,
      remoteSort: false,
      showFooter:true,
      idField:'bali_trc_id',
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
			{field:'bali_trc_id',title:'',width:50,align:'center',checkbox:true},
			{field:'baltr_c_id',title:'姓名',width:150,halign:'center',align:'left',
			    formatter: fun_table_trip_c_formatter<?=$time?>,
			    editor:{
					type:'combobox',
					options:{
						 err:err,
						 panelHeight:'auto',
						 required:true,
			    		 valueField: 'id',    
			           	 textField: 'text',  
			        	 hasDownArrow:false,
			        	 buttonIcon:'icon-clear',
				   	   	 onClickButton:function()
				       	 {
								$(this).combobox('clear');
				       	 },
					}
				},
			},
			{field:'baltr_c_type',title:'人员类型',width:150,halign:'center',align:'left',
	              formatter: fun_table_trip_c_formatter<?=$time?>,
	              editor:{
					type:'combobox',
					options:{
	            	  	err:err,
	            	  	limitToList:true,
	            	  	data: [<?=element('baltr_c_type',$json_field_define)?>],
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
          {field:'baltr_single',title:'单住',width:80,halign:'center',align:'center',
			    formatter: fun_table_trip_c_formatter<?=$time?>,
	    		editor:{
					type:'numberbox',
					options:{
			    		 err:err,
			    		 min:0,
				    	 buttonIcon:'icon-clear',
			     	   	 onClickButton:function()
			         	 {
							$(this).numberbox('clear');
			         	 },
					}
				} 
			},
			 {field:'baltr_together',title:'合住',width:80,halign:'center',align:'center',
			    formatter: fun_table_trip_c_formatter<?=$time?>,
	    		editor:{
					type:'numberbox',
					options:{
			    		 err:err,
						 min:0,
				    	 buttonIcon:'icon-clear',
			     	   	 onClickButton:function()
			         	 {
							$(this).numberbox('clear');
			         	 },
					}
				} 
			},
			{field:'baltr_pay_type',title:'支付方式',width:150,halign:'center',align:'left',
            formatter: fun_table_trip_c_formatter<?=$time?>,
            editor:{
				type:'combobox',
				options:{
          	  	err:err,
          	  	limitToList:true,
          	  	data: [<?=element('baltr_pay_type',$json_field_define)?>],
        			panelHeight:'auto',
        			required:true,
        			valueField: 'id',    
                	textField: 'text',  
                	buttonIcon:'icon-clear',
		     	   	onClickButton:function()
		         	{
						$(this).combobox('clear');
		         	},
		         	loadFilter:function(data)
					{
					 	var value = $(this).combobox('getValue');
					 	var data_new = [];
					 	var arr = [1,9];
					 	
	   					for(var i =0;i < data.length;i++)
	   					{
	   						if(arr.indexOf( parseInt(data[i].id) ) > -1 || value == data[i].id)
	   						{
	   							data_new.push(data[i]);
	   						}
	   					}
	   					
	   					return data_new;
					},
				}
			} 
        },
        {field:'baltr_c_sum',title:'金额',width:125,halign:'right',align:'right',
            formatter: fun_table_trip_c_formatter<?=$time?>,
            editor:{
				type:'numberbox',
				options:{
          	    err:err,
          	    required:true,
            		precision:2,
	   				min:0,
	   				groupSeparator:',',
		   			buttonIcon:'icon-clear',
		     	   	onClickButton:function()
		         	{
						$(this).numberbox('clear');
		         	},
				}
			} 
        },
        {field:'c_bank',title:'卡号',width:150,halign:'center',align:'center',
		   formatter: fun_table_trip_c_formatter<?=$time?>,
  	   editor:{
				type:'textbox',
				options:{
					 readonly:true,
			    	 buttonIcon:'icon-lock',
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

      	var ed_baltr_c_id = '';
      	var ed_c_bank = '';
      	var ed_baltr_single = '';
      	var ed_baltr_together = '';
			for(var i = 0;i < ed_list.length; i++)
			{
				switch(ed_list[i].field)
				{
					case 'baltr_c_id':
						ed_baltr_c_id = ed_list[i].target;
						break;
					case 'c_bank':
						ed_c_bank = ed_list[i].target;
						break;
					case 'baltr_c_type':
					case 'baltr_pay_type':
						
						$(ed_list[i].target).combobox('textbox').bind('focus',
						function(){
							$(this).parent().prev().combobox('showPanel');
						});
						break;
					case 'baltr_c_sum':
						
						$(ed_list[i].target).numberbox('textbox').css('text-align','right');
						
  					break;
					case 'baltr_single':
						ed_baltr_single = ed_list[i].target;
	    				break;
					case 'baltr_together':
						ed_baltr_together = ed_list[i].target;
	    				break;
				}
			}

			$(ed_baltr_c_id).combobox('textbox').autocomplete({
				serviceUrl: 'base/auto/get_json_contact/search_c_login_id/1',
				width:'300',
				params:{
					rows:10,
				},
				onSelect: function (suggestion) {
					var c_id = base64_decode(suggestion.data.c_id);
					var c_show = base64_decode(suggestion.data.c_show);
					
					$(ed_baltr_c_id).combobox('setValue',c_id);
					$(ed_baltr_c_id).combobox('setText',c_show);

					$(ed_c_bank).textbox('setValue',base64_decode(suggestion.data.c_bank));
				}
			});

			$(ed_baltr_c_id).combobox('setValue',row.baltr_c_id);
			$(ed_baltr_c_id).combobox('setText',row.baltr_c_id_s);

			if( ! row.baltr_together && ! row.baltr_single)
			{
				layer.tips('单住/合住不可全部为空！',$(ed_baltr_single).numberbox('textbox'),{tips: [1]});
			}

      },
      onEndEdit: function(index, row, changes)
      {
      	var ed_list=$(this).datagrid('getEditors',index);

      	var ed_baltr_single = '';
      	var ed_baltr_together = '';
			for(var i = 0;i < ed_list.length; i++)
			{
				switch(ed_list[i].field)
				{
					case 'baltr_c_id':
						row.baltr_c_id_s = $(ed_list[i].target).combobox('getText');
						break;
					case 'baltr_c_type':
						row.baltr_c_type_s = $(ed_list[i].target).combotree('getText');
	    				break;
					case 'baltr_pay_type':
						row.baltr_pay_type_s = $(ed_list[i].target).combotree('getText');
	    				break;
				}
			}

			if( ! row.baltr_together && ! row.baltr_single)
			{
				err_table_trip_c<?=$time?> = 1;
			}
      },
      onLoadSuccess: function(data)
		{
		},
      onResizeColumn: function(field, width)
		{
		}
  });

  if( arr_view<?=$time?>.indexOf('content[trip_c]')>-1 )
  {
  	$('#table_trip_c<?=$time?>').edatagrid('disableEditing');
      $('#table_trip_c_tool<?=$time?> .oa_op').hide();
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
function fun_table_trip_c_formatter<?=$time?>(value,row,index){

  switch(this.field)
  {
	    case 'baltr_c_sum':
  		value = num_parse(value);
      	break;
      	
      default:
          if(row[this.field+'_s'])
              value = row[this.field+'_s'];
  }

  if( ! value ) value = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ;
  return '<span id="table_trip_c<?=$time?>_'+index+'_'+this.field+'" class="table_trip_c<?=$time?>" >'+value+'</span>';
}

//差旅费--操作
function fun_table_trip_c_operate<?=$time?>(btn)
{
  switch(btn)
  {
      case 'add':

      	var row_s = $('#table_trip_c<?=$time?>').datagrid('getSelected');
      	var index_s = $('#table_trip_c<?=$time?>').datagrid('getRowIndex',row_s);
      	
      	if( index_s > -1)
      	{
      		if($('#table_trip_c<?=$time?>').datagrid('validateRow',index_s))
					$('#table_trip_c<?=$time?>').datagrid('endEdit',index_s)
				else
					return;//$('#table_trip_c<?=$time?>').datagrid('cancelEdit',index_s)
      	}

      	if( err_table_trip_c<?=$time?> ) 
          {
      		$('#table_trip_c<?=$time?>').edatagrid('editRow',index_s)
				return ;
          }
      	
      	var op_id = get_guid();
			$('#table_trip_c<?=$time?>').edatagrid('addRow',{
				index:0,
				row:{
					bali_trc_id: op_id,
				}
			});

          break;
      case 'del':

          var op_list=$('#table_trip_c<?=$time?>').datagrid('getChecked');

          var row_s = $('#table_trip_c<?=$time?>').datagrid('getSelected');
          var index_s = $('#table_trip_c<?=$time?>').datagrid('getRowIndex',row_s);

          if($('#table_trip_c<?=$time?>').datagrid('validateRow',index_s))
          {
              $('#table_trip_c<?=$time?>').datagrid('endEdit',index_s);
          }
          else
          {
              $('#table_trip_c<?=$time?>').datagrid('cancelEdit',index_s);
          }

          for(var i=op_list.length-1;i>-1;i--)
          {
              var index = $('#table_trip_c<?=$time?>').datagrid('getRowIndex',op_list[i]);
              $('#table_trip_c<?=$time?>').datagrid('deleteRow',index);
          }
                  
          break;
  }

}

//差额补贴--载入
function load_table_trip_sub<?=$time?>()
{
  $('#table_trip_sub<?=$time?>').edatagrid({
      width:'100%',
      height:'150',
      toolbar:'#table_trip_sub_tool<?=$time?>',
      singleSelect:true,
      selectOnCheck:false,
      checkOnSelect:false,
      striped:true,
      remoteSort: false,
      showFooter:true,
      idField:'bali_trc_id',
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
			{field:'bali_trc_id',title:'',width:50,align:'center',checkbox:true},
			{field:'baltrs_c_id',title:'补贴人',width:150,halign:'center',align:'left',
			    formatter: fun_table_trip_sub_formatter<?=$time?>,
			    editor:{
					type:'combobox',
					options:{
						 err:err,
						 panelHeight:'auto',
						 required:true,
			    		 valueField: 'id',    
			           	 textField: 'text',  
			        	 hasDownArrow:false,
			        	 buttonIcon:'icon-clear',
				   	   	 onClickButton:function()
				       	 {
								$(this).combobox('clear');
				       	 },
					}
				},
			},
          {field:'baltrs_day_count',title:'天数',width:80,halign:'center',align:'center',
			    formatter: fun_table_trip_sub_formatter<?=$time?>,
	    		editor:{
					type:'numberbox',
					options:{
			    		 err:err,
			    		 required:true,
			    		 min:0,
				    	 buttonIcon:'icon-clear',
			     	   	 onClickButton:function()
			         	 {
							$(this).numberbox('clear');
			         	 },
					}
				} 
			},
        {field:'baltrs_room_normal',title:'住宿标准（元/人/天）',width:140,halign:'center',align:'right',
            formatter: fun_table_trip_sub_formatter<?=$time?>,
            editor:{
				type:'numberbox',
				options:{
          	    err:err,
          	    required:true,
            		precision:2,
	   				min:0,
	   				groupSeparator:',',
		   			buttonIcon:'icon-clear',
		     	   	onClickButton:function()
		         	{
						$(this).numberbox('clear');
		         	},
				}
			} 
        },
        {field:'baltrs_food_normal',title:'伙食标准（元/人/天）',width:140,halign:'center',align:'right',
            formatter: fun_table_trip_sub_formatter<?=$time?>,
            editor:{
				type:'numberbox',
				options:{
          	    err:err,
          	    required:true,
            		precision:2,
	   				min:0,
	   				groupSeparator:',',
		   			buttonIcon:'icon-clear',
		     	   	onClickButton:function()
		         	{
						$(this).numberbox('clear');
		         	},
				}
			} 
        },
        {field:'baltrs_room_difference',title:'住宿差额',width:125,halign:'center',align:'right',
            formatter: fun_table_trip_sub_formatter<?=$time?>,
            editor:{
				type:'numberbox',
				options:{
          	    err:err,
//          	    required:true,
            		precision:2,
	   				min:0,
	   				groupSeparator:',',
		   			buttonIcon:'icon-clear',
		     	   	onClickButton:function()
		         	{
						$(this).numberbox('clear');
		         	},
				}
			} 
        },
        {field:'baltr_food_difference',title:'伙食差额',width:125,halign:'center',align:'right',
            formatter: fun_table_trip_sub_formatter<?=$time?>,
            editor:{
				type:'numberbox',
				options:{
          	    err:err,
//          	    required:true,
            		precision:2,
	   				min:0,
	   				groupSeparator:',',
		   			buttonIcon:'icon-clear',
		     	   	onClickButton:function()
		         	{
						$(this).numberbox('clear');
		         	},
				}
			} 
        },
        {field:'baltr_other',title:'其他',width:125,halign:'center',align:'right',
            formatter: fun_table_trip_sub_formatter<?=$time?>,
            editor:{
				type:'numberbox',
				options:{
          	    err:err,
//          	    required:true,
            		precision:2,
	   				min:0,
	   				groupSeparator:',',
		   			buttonIcon:'icon-clear',
		     	   	onClickButton:function()
		         	{
						$(this).numberbox('clear');
		         	},
				}
			} 
        },
        {field:'baltr_sum_total',title:'补贴合计',width:125,halign:'center',align:'right',
            formatter: fun_table_trip_sub_formatter<?=$time?>,
            editor:{
				type:'numberbox',
				options:{
          	    err:err,
          	    readonly:true,
            		precision:2,
	   				min:0,
	   				groupSeparator:',',
		   			buttonIcon:'icon-lock',
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

      	var ed_baltrs_c_id = '';
			for(var i = 0;i < ed_list.length; i++)
			{
				switch(ed_list[i].field)
				{
					case 'baltrs_c_id':
						ed_baltrs_c_id = ed_list[i].target;
						break;
					case 'baltrs_room_normal':
				    case 'baltrs_food_normal':
				    case 'baltr_sum_total':

				    	$(ed_list[i].target).numberbox('textbox').css('text-align','right');
				    	
					    break;
				    case 'baltrs_room_difference':
				    case 'baltr_other':
				    case 'baltr_food_difference':

				    	$(ed_list[i].target).numberbox({
							onChange:function(nV,oV)
							{
								fun_count_trip_sub_total<?=$time?>();
							}
						});
						
						$(ed_list[i].target).numberbox('textbox').css('text-align','right');
						
  					break;
				}
			}

			$(ed_baltrs_c_id).combobox('textbox').autocomplete({
				serviceUrl: 'base/auto/get_json_contact/search_c_login_id/1',
				width:'300',
				params:{
					rows:10,
				},
				onSelect: function (suggestion) {
					var c_id = base64_decode(suggestion.data.c_id);
					var c_show = base64_decode(suggestion.data.c_show);
					
					$(ed_baltrs_c_id).combobox('setValue',c_id);
					$(ed_baltrs_c_id).combobox('setText',c_show);

				}
			});

			$(ed_baltrs_c_id).combobox('setValue',row.baltr_c_id);
			$(ed_baltrs_c_id).combobox('setText',row.baltr_c_id_s);

      },
      onEndEdit: function(index, row, changes)
      {
      	var ed_list=$(this).datagrid('getEditors',index);

      	var ed_baltr_single = '';
      	var ed_baltr_together = '';
			for(var i = 0;i < ed_list.length; i++)
			{
				switch(ed_list[i].field)
				{
					case 'baltrs_c_id':
						row.baltrs_c_id_s = $(ed_list[i].target).combobox('getText');
						break;
				}
			}

			fun_load_trip_sub_foot<?=$time?>();
      },
      onLoadSuccess: function(data)
		{
      	fun_load_trip_sub_foot<?=$time?>();
		},
      onResizeColumn: function(field, width)
		{
		}
  });

  if( arr_view<?=$time?>.indexOf('content[trip_sub]')>-1 )
  {
  	$('#table_trip_sub<?=$time?>').edatagrid('disableEditing');
      $('#table_trip_sub_tool<?=$time?> .oa_op').hide();
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

//行合计
function fun_count_trip_sub_total<?=$time?>(){

	var row_s = $('#table_trip_sub<?=$time?>').edatagrid('getSelected');
	var index_s = $('#table_trip_sub<?=$time?>').edatagrid('getRowIndex',row_s);

	var ed_list=$('#table_trip_sub<?=$time?>').datagrid('getEditors',index_s);

	var sum_total = 0;
	
	for(var i = 0;i < ed_list.length; i++)
	{
		switch(ed_list[i].field)
		{
			case 'baltrs_room_difference':
			case 'baltr_other':
			case 'baltr_food_difference':
				var sum= $(ed_list[i].target).numberbox('getValue');
				if( ! sum ) sum = 0;
				sum_total += parseFloat(sum);
				break;
			case 'baltr_sum_total':
				$(ed_list[i].target).numberbox('setValue',sum_total);
				break;
		}
	}
	
}

//底部小计
function fun_load_trip_sub_foot<?=$time?>(){

	var row =  $('#table_trip_sub<?=$time?>').edatagrid('getRows');
	var foot = {};

	foot.baltrs_room_normal = 0;
	foot.baltrs_food_normal = 0;
	foot.baltrs_room_difference = 0;
	foot.baltr_other = 0;
	foot.baltr_food_difference = 0;
	foot.baltr_sum_total = 0;
	
	for(var i=0;i<row.length;i++)
	{
		foot.baltrs_room_normal += parseFloat(row[i].baltrs_room_normal);
		foot.baltrs_food_normal += parseFloat(row[i].baltrs_food_normal);
		foot.baltrs_room_difference += parseFloat(row[i].baltrs_room_difference);
		foot.baltr_other += parseFloat(row[i].baltr_other);
		foot.baltr_food_difference += parseFloat(row[i].baltr_food_difference);
		foot.baltr_sum_total += parseFloat(row[i].baltr_sum_total);
	}
	

	$('#table_trip_sub<?=$time?>').datagrid('reloadFooter',[
  	foot
  ]);
}

//列格式化输出
function fun_table_trip_sub_formatter<?=$time?>(value,row,index){

  switch(this.field)
  {
	    case 'baltrs_room_normal':
	    case 'baltrs_food_normal':
	    case 'baltrs_room_difference':
	    case 'baltr_other':
	    case 'baltr_food_difference':
	    case 'baltr_sum_total':
  		value = num_parse(value);
      	break;
      	
      default:
          if(row[this.field+'_s'])
              value = row[this.field+'_s'];
  }

  if( ! value ) value = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ;
  return '<span id="table_trip_sub<?=$time?>_'+index+'_'+this.field+'" class="table_trip_sub<?=$time?>" >'+value+'</span>';
}

//差旅费补贴--操作
function fun_table_trip_sub_operate<?=$time?>(btn)
{
  switch(btn)
  {
      case 'add':

      	var row_s = $('#table_trip_sub<?=$time?>').datagrid('getSelected');
      	var index_s = $('#table_trip_sub<?=$time?>').datagrid('getRowIndex',row_s);
      	
      	if( index_s > -1)
      	{
      		if($('#table_trip_sub<?=$time?>').datagrid('validateRow',index_s))
					$('#table_trip_sub<?=$time?>').datagrid('endEdit',index_s)
				else
					return;//$('#table_trip_sub<?=$time?>').datagrid('cancelEdit',index_s)
      	}
      	
      	var op_id = get_guid();
			$('#table_trip_sub<?=$time?>').edatagrid('addRow',{
				index:0,
				row:{
					bali_trs_id: op_id,
				}
			});

          break;
      case 'del':

          var op_list=$('#table_trip_sub<?=$time?>').datagrid('getChecked');

          var row_s = $('#table_trip_sub<?=$time?>').datagrid('getSelected');
          var index_s = $('#table_trip_sub<?=$time?>').datagrid('getRowIndex',row_s);

          if($('#table_trip_sub<?=$time?>').datagrid('validateRow',index_s))
          {
              $('#table_trip_sub<?=$time?>').datagrid('endEdit',index_s);
          }
          else
          {
              $('#table_trip_sub<?=$time?>').datagrid('cancelEdit',index_s);
          }

          for(var i=op_list.length-1;i>-1;i--)
          {
              var index = $('#table_trip_sub<?=$time?>').datagrid('getRowIndex',op_list[i]);
              $('#table_trip_sub<?=$time?>').datagrid('deleteRow',index);
          }
                  
          break;
  }
}
</script>