<!-- 加载jquery -->
<script type="text/javascript">

//初始化
$(document).ready(function(){

	load_tree<?=$time?>();
});

//载入树
function load_tree<?=$time?>()
{
	$('#table_tree<?=$time?>').treegrid({
		fit:true,
		loadMsg:'',
		border:false,
		url:'proc_ou/ou/get_json/flag_tree/1'  ,
		idField:'ou_id',
		treeField:'ou_name',
		showHeader:false,
		pagination: false,
		pagePosition:'top',
		columns:[[    
			{title:'',field:'ou_name',width:'100%',
			 formatter : function(value,row,index)
			 {
				 	if(value)
				 	value=base64_decode(value);

				 	var str='<span id="sp_'+row.ou_id+'">'+value+'</span>';
				 	
				 	if(row.ou_tag)
				 		str+='('+base64_decode(row.ou_tag)+')';
			 		
				 	return str;
			 }
			},    
		]], 
		onLoadSuccess: function(row){

			<? if( empty($flag_select) ){ ?>
			$(this).treegrid('enableDnd', row ? row.ou_id:null);
			<? }?>
		},
		onClickRow: function(row)
		{
			layer.tips('<a href="javascript:void(0);" class="sui-btn btn-bordered" onClick="load_win_edit<?=$time?>(\''+base64_decode(row.ou_id)+'\')" ><i class="sui-icon icon-search"></i></a>'
					, '#sp_'+row.ou_id
					,{
						tips: [1, '#FFF'],
					}
				);
			$(this).treegrid('expand',row.ou_id);
		},
		onDblClickRow: function(row)
		{
			$(this).treegrid('collapse',row.ou_id);

			<? if( ! empty($flag_select) ){ ?>
			<?=$fun_select?>('table_tree<?=$time?>',row);
			<? }?>
		},
		onBeforeDrop: function(targetRow,sourceRow,point)
		{
			if(targetRow)
				$(this).treegrid('expand',targetRow.ou_id);

			var parent=targetRow;//$(this).treegrid('getParent',sourceRow.ou_id);

			var ou_parent = '';
			if(targetRow)
			{ 
				if(point == 'append')
					ou_parent=base64_decode(targetRow.ou_id);
				else
					ou_parent=base64_decode(targetRow._parentId);
			}
			
			var ou_id = base64_decode(sourceRow.ou_id);
			var ou_name = base64_decode(sourceRow.ou_name);

			var check=true;
			
			//保存配置
			$.ajax({
		        url:"proc_ou/ou/win_tree",
		        type:"POST",
		        async:false,
		        data:{
					ou_parent: ou_parent,
					ou_id : ou_id,
					ou_name : ou_name,
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
	var url = 'proc_ou/ou/edit/act/2';

		url+='/ou_id/'+op_id

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

</script>