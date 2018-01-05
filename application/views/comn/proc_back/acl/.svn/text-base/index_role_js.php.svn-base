<!-- 加载jquery -->
<script type="text/javascript">
//初始化
$(document).ready(function(){

	//载入角色列表
	load_table_role<?=$time?>();
	
});


//载入角色列表
function load_table_role<?=$time?>()
{
	$('#txtb_table_role_search<?=$time?>').textbox({
		width:'100%',
		icons: [{
			iconCls:'icon-clear',
			handler: function(e){
				$(e.data.target).textbox('clear');

				$('#table_acl<?=$time?>').datalist('load',{
					data_search: '[{"field":"role_id","value":"","rule":"="}]'
  				});
			}
		}]
	})
	
	$('#txtb_table_role_search<?=$time?>').textbox('textbox').autocomplete({
      serviceUrl: 'proc_back/role/get_json.html',
      width:'auto',
      onSelect: function (suggestion) {

			var index=$('#table_acl<?=$time?>').datalist('getRowIndex',suggestion.data.role_id);
	
			if(index > -1)
			{
				$('#table_acl<?=$time?>').datalist('scrollTo',index);
				$('#table_acl<?=$time?>').datalist('selectRow',index);
			}
			else
			{
				$('#table_acl<?=$time?>').datalist('load',{
					data_search: '[{"field":"role_id","value":"'+base64_decode(suggestion.data.role_id)+'","rule":"="}]'
  				});
			}
		}
	});
	
	$('#table_role<?=$time?>').datalist({
		fit:true,
		title:'角色列表',
		view: bufferview,
		toolbar:'#table_role_tool<?=$time?>',
		url:'proc_back/role/get_json.html',
		singleSelect:true,
		striped:true,
		autoSave:true,
	    pageSize:50,
		pageList:[50],
		idField:'role_id',
		columns:[[
		 {field:'role_name',title:'角色名称',width:'100%',halign:'center',align:'left',sortable:true,
		  formatter: function(value,row,index){
			  return base64_decode(row.role_name);
		  }
		 }
		]],
		onSelect: function(index, row)
		{
			load_table_proc<?=$time?>(base64_decode(row.role_id))
		}
	});
}

//载入流程列表
function load_table_proc<?=$time?>(role_id)
{
	$('#txtb_table_proc_search<?=$time?>').textbox({
		width:'100%',
		icons: [{
			iconCls:'icon-clear',
			handler: function(e){
				$(e.data.target).textbox('clear');

				$('#table_proc<?=$time?>').datalist('load',{
					data_search: '[{"field":"role_id","value":"","rule":"="}]'
  				});
			}
		}]
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

				load_table_acl<?=$time?>(base64_decode(suggestion.data.p_id),base64_decode(suggestion.data.p_name),role_id)
			}
		}
	});
	
	$('#table_proc<?=$time?>').datalist({
		fit:true,
		title:'流程列表',
		view: bufferview,
		toolbar:'#table_proc_tool<?=$time?>',
		url:'proc_back/main/get_json_proc/role_id/'+role_id+'.html',
		singleSelect:true,
		striped:true,
		autoSave:true,
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
			load_table_acl<?=$time?>(base64_decode(row.p_id),base64_decode(row.p_name),role_id)
		}
	});
}

//载入权限列表
function load_table_acl<?=$time?>(p_id,p_name,role_id)
{
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
		url:'proc_back/acl/get_json_acl_data/p_id/'+p_id+"/role_id/"+role_id,
		idField:'ra_id',
		singleSelect:true,
		striped:true,
	    pageSize:50,
		pageList:[50],
		columns:col,
		frozenColumns:[[
			{field:'ra_name',title:'角色',width:'150',halign:'center',align:'left',sortable:true,
			}
		]],
		onLoadSuccess: function(data)
		{
			
		}
	});
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