<!-- 加载jquery -->
<script type="text/javascript">
//初始化
$(document).ready(function(){

	//载入流程列表
	load_table_proc<?=$time?>();
	
});

//载入流程列表
function load_table_proc<?=$time?>()
{
	$('#txtb_table_proc_search<?=$time?>').textbox({
		width:'100%',
		buttonIcon:'icon-clear',
		onClickButton:function()
		{
			$(this).textbox('clear');
	
			$('#table_proc<?=$time?>').datalist('load',{
				data_search: ''
			});
		}
	})
	
	$('#txtb_table_proc_search<?=$time?>').textbox('textbox').autocomplete({
        serviceUrl: 'proc_back/main/get_json_proc.html',
        width:'auto',
        onSelect: function (suggestion) {

			var index=$('#table_proc<?=$time?>').datalist('getRowIndex',suggestion.data.p_id);
	
			if(index > -1)
			{
				$('#table_proc<?=$time?>').datalist('scrollTo',index);
				$('#table_proc<?=$time?>').datalist('selectRow',index);
			}
			else
			{
				$('#table_proc<?=$time?>').datalist('load',{
					data_search: '[{"field":"p_id","value":"'+base64_decode(suggestion.data.p_id)+'","rule":"="}]'
    			});
			}
		}
	});
	
	$('#table_proc<?=$time?>').datalist({
		fit:true,
		view: bufferview,
		toolbar:'#table_proc_tool<?=$time?>',
		url:'proc_back/main/get_json_proc.html',
		singleSelect:true,
		striped:true,
		autoSave:true,
		border:false,
	    pageSize:50,
		pageList:[50],
		idField:'p_id',
		columns:[[
		 {field:'p_name',title:'流程名称',width:'100%',halign:'center',align:'left',sortable:true,
		  formatter: function(value,row,index){
			  return base64_decode(row.p_name);
		  }
		 }
		]],
		onSelect: function(index, row)
		{
			load_table_acl<?=$time?>(base64_decode(row.p_id),base64_decode(row.p_name))
		}
	});
}

//载入权限列表
function load_table_acl<?=$time?>(p_id,p_name)
{
	$('#btn_account_select<?=$time?>').linkbutton({    
	    iconCls: 'icon-man',
	    onClick:function()
	    {
	    	var url = 'proc_back/account/index';

			var win_id=fun_get_new_win()
	    	
			$('#'+win_id).window({
				title: '选择账户',
				border:'thin',
				resizable:false,  
				minimizable:false,
				maximizable:false,
				collapsible:false,
			    inline:true,
			    modal:true
			})

			$('#'+win_id).window('refresh', url+'/flag_select/1/fun_select/fun_account_select<?=$time?>/fun_open/win/fun_open_id/'+win_id);
			$('#'+win_id).window('center');
	    }
	});  
	
	$('#btn_acl_search<?=$time?>').linkbutton({    
	    iconCls: 'icon-search',
	    onClick:function()
	    {
			var search_ra_id=$('#txtb_contact_search<?=$time?>').textbox('getValue');
			
			$('#table_acl<?=$time?>').datagrid('load',
				{
					search_ra_id :search_ra_id
				}
			);
	    }
	});  
	
	$('#txtb_contact_search<?=$time?>').textbox({
		width:'100%',
		height:'90',
		label:'账户:',
		multiline: true,
		labelPosition:'top',
		iconAlign:'left',
		buttonIcon:'icon-clear',
		onClickButton:function()
		{
			$(this).textbox('clear');
		}
	})
	
	$('#txtb_contact_search<?=$time?>').textbox('textbox').bind('keydown', function(e){
		if (e.keyCode == 13){	// 当按下回车键时查询
			var search_ra_id=$('#txtb_contact_search<?=$time?>').textbox('getValue');
			$('#table_acl<?=$time?>').datagrid('load',
				{
					search_ra_id :search_ra_id
				}
			);
			return false;
		}
	});
	
	//列配置
	var col=[[]];
	
	//读取权限配置
	$.ajax({
        url:"proc_back/acl/get_json_proc_acl/p_id/"+p_id,
        type:"POST",
        async:false,
        data:{},
        success: function(data){

        	var json = {};
        	if(data) json=JSON.parse(data);

        	for(var i=0;i<json.length;i++)
            {
        		 var op_col={
                  		field:'acl_'+json[i].acl,title: '<a class="link" onMouseover="layer.tips(\''+json[i].acl_note+'\', this,{tips:[1]});">'+json[i].acl_s+'</a>' ,width:120,halign:'center',align:'center',sortable:true,
                 		formatter: function(value,row,index){

		        			var checked='';
		         			
		         			if(value == 1)
		         				checked='checked="checked"';

		         			return '<input '+checked+' type="checkbox" onclick="return fun_acl_operate<?=$time?>(\''+this.field+'\',\''+row.ra_id+'\',\''+p_id+'\',\''+value+'\',this);"/>';
                 		}
        		 }

        		 col[0].push(op_col)
            }
        }
	});

	$('#table_acl<?=$time?>').datagrid({
		title: p_name+' 权限列表',
		fit:true,
		view: bufferview,
		toolbar:'#table_acl_tool<?=$time?>',
		url:'proc_back/acl/get_json_acl_data/p_id/'+p_id,
		idField:'ra_id',
		singleSelect:true,
		striped:true,
	    pageSize:50,
		pageList:[50],
		columns:col,
		frozenColumns:[[
			{field:'ra_name',title:'账户',width:'150',halign:'center',align:'left',sortable:true,
			}
		]],
		onLoadSuccess: function(data)
		{
			
		}
	});
}

//账户选择
function fun_account_select<?=$time?>(op)
{

	$(op).closest('.op_window').window('close');
	
	var list=$(op).datagrid('getChecked');

	var arr_login_id=[];
	
	for(var i=0;i<list.length;i++)
	{
		if(list[i]['a_login_id'])
		arr_login_id.push(base64_decode(list[i]['a_login_id']))
		else if(list[i]['c_login_id'])
		arr_login_id.push(base64_decode(list[i]['c_login_id']))
	}

	$('#txtb_contact_search<?=$time?>').textbox('setValue',arr_login_id.join(','));

	$(op).closest('.op_window').window('destroy').remove();
}

//权限操作
function fun_acl_operate<?=$time?>(acl,ra_id,op_id,check,op)
{
	var rtn = false;
	var check = 0;
	if($(op).is(':checked') )
		check = 1;

	$.ajax({
        url:"proc_back/acl/fun_acl_operate.html",
        type:"POST",
        async:false,
        data:{
			'content[a_acl]': acl,
			'content[ra_id]': ra_id,
			'content[op_id]': op_id,
			'check' : check
        },
        success: function(data){

        	if( ! data) return;
        	
        	var json = JSON.parse(data)
        	
        	var row={};

        	if( ! json.check  && check == 0)
        	{
        		rtn = true;
        	}
        	else if(  check == 1 )
        	{
        		rtn = true;
        	}
        }
	});

	return rtn ;
}

</script>