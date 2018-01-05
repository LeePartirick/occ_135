<!-- 加载jquery -->
<script type="text/javascript">

//初始化
$(document).ready(function(){

	load_win_loading('win_loading<?=$time?>')
	
	load_tree<?=$time?>();
});

//载入树
function load_tree<?=$time?>()
{
	$('#table_tree<?=$time?>').treegrid({
		fit:true,
		loadMsg:'',
		border:false,
		url:'proc_file/file_type/get_json/flag_tree/1'  ,
		idField:'f_t_id',
		treeField:'f_t_name',
		showHeader:false,
		pagination: false,
		pagePosition:'top',
		columns:[[    
			{title:'',field:'f_t_name',width:'100%',
			 formatter : function(value,row,index)
			 {
				 	if(value)
				 	value=base64_decode(value);

				 	var str='<span id="sp_'+row.f_t_id+'">'+value+'</span>';
				 	
				 	if(row.f_t_tag)
				 		str+='('+base64_decode(row.f_t_tag)+')';
			 		
				 	return str;
			 }
			},    
		]], 
		onLoadSuccess: function(row){
			$(this).treegrid('enableDnd', row ? row.f_t_id:null);
		},
		onContextMenu: function(e, node){
			e.preventDefault();
			$(this).treegrid('select', node.f_t_id);

			menu_show('menu_table_tree<?=$time?>',e);
		},
		onClickRow: function(row)
		{
			layer.tips('<a href="javascript:void(0);" class="sui-btn btn-bordered" onClick="load_win_edit<?=$time?>(\''+base64_decode(row.f_t_id)+'\')" ><i class="sui-icon icon-search"></i></a>'
					, '#sp_'+row.f_t_id
					,{
						tips: [1, '#FFF'],
					}
				);
			$(this).treegrid('expand',row.f_t_id);
		},
		onDblClickRow: function(row)
		{
			$(this).treegrid('collapse',row.f_t_id);

			<? if( ! empty($flag_select) ){ ?>
			<?=$fun_select?>('table_tree<?=$time?>',row);
			<? }?>
		},
		onBeforeDrop: function(targetRow,sourceRow,point)
		{
			if(targetRow)
				$(this).treegrid('expand',targetRow.f_t_id);

			var parent=targetRow;//$(this).treegrid('getParent',sourceRow.ou_id);

			var f_t_parent = '';
			if(targetRow)
			{ 
				if(point == 'append')
					f_t_parent=base64_decode(targetRow.f_t_id);
				else
					f_t_parent=base64_decode(targetRow._parentId);
			}
			
			var f_t_id = base64_decode(sourceRow.f_t_id);
			var f_t_name = base64_decode(sourceRow.f_t_name);

			var check=true;
			
			//保存配置
			$.ajax({
		        url:"proc_file/file_type/win_tree",
		        type:"POST",
		        async:false,
		        data:{
					f_t_parent: f_t_parent,
					f_t_id : f_t_id,
					f_t_name : f_t_name,
					btn : 'save'
		        },
		        success:function(data){
			        var json={}
			        if(data) json=JSON.parse(data);

			        if( ! json.rtn )
			        {
			        	check = false;

			        	$.messager.show({
					    	title:'警告',
					    	msg: json.msg_err,
					    	timeout:5000,
					    	showType:'show',
					    	border:'thin',
			                style:{
			                    right:'',
			                    bottom:'',
			                }
					    });
			        }
				}
		    });

		    return check;
		},
	})

	$('#table_tree<?=$time?>').datagrid('getPanel').removeClass('lines-both lines-no lines-right lines-bottom').addClass('lines-no');	
}

//编辑
function load_win_edit<?=$time?>(op_id)
{
	var url = 'proc_file/file_type/edit/act/2';

		url+='/f_t_id/'+op_id

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
				$(this).window('close');
				$(this).window('clear');
				window.open(url+'/fun_open/winopen');
			},
			onClose: function()
			{
				$('#table_index<?=$time?>').datagrid('reload');
				$('#'+win_id).window('destroy');
				$('#'+win_id).remove();
			}
		})
		
		$('#'+win_id).window('refresh',url+'/fun_open/win/fun_open_id/'+win_id);
}

//批量操作
var msg_err<?=$time?>='';
function fun_operate_table_tree<?=$time?>(btn)
{
	switch(btn)
	{
		case 'sort':

			$('#win_loading<?=$time?>').window('open');
			
			var data = $('#table_tree<?=$time?>').treegrid('getChildren');

			var list=[];
			
			for(var i=0;i<data.length;i++)
			{
				var id=data[i]['f_t_id'];

				list.push(base64_decode(id))
			}

			list=list.join(',');

			msg_err<?=$time?>='';
			fun_operate_more<?=$time?>(list,btn);
			
			break
	}
}

function fun_operate_more<?=$time?>(list,btn)
{
	 //批量操作
	$.ajax({
        url:"app/run_back/proc_file/file_type/fun_operate_more.html",
        type:"POST",
        data:{
			list : list,
			btn : btn,
			msg_err: msg_err<?=$time?>
        },
        success:function(data){

        	if( ! data ) return;

            var json = JSON.parse(data);

            msg_err<?=$time?>+=json.msg_err;

            if(json.rs)
            {
            	var msg='批量操作完成！<br/><div style="font-size:12px;"><br/>'+msg_err<?=$time?>+'</div>'
            	fun_win_sys_msg('【文件属性批量操作】操作结果:',msg)

            	msg_err<?=$time?>='';
            	$('#win_loading<?=$time?>').window('close');
            }
            else
            {
            	list=json.list;
            	
            	fun_operate_more<?=$time?>(list,btn)
            }
		}
    });
}

</script>