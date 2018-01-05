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
		url:'proc_bud/subject/get_json/flag_tree/1'  ,
		idField:'sub_id',
		treeField:'sub_name',
		showHeader:false,
		pagination: false,
		pagePosition:'top',
		columns:[[    
			{title:'',field:'sub_name',width:'100%',
			 formatter : function(value,row,index)
			 {
				 	if(value)
				 	value=base64_decode(value);

				 	var str='<span id="sp_'+row.sub_id+'">'+value+'</span>';
				 	
				 	if(row.sub_tag)
				 		str+='('+base64_decode(row.sub_tag)+')';
			 		
				 	return str;
			 }
			},    
		]], 
		onLoadSuccess: function(row){
			$(this).treegrid('enableDnd', row ? row.sub_id:null);
		},
		onClickRow: function(row)
		{
			layer.tips('<a href="javascript:void(0);" class="sui-btn btn-bordered" onClick="load_win_edit<?=$time?>(\''+base64_decode(row.sub_id)+'\')" ><i class="sui-icon icon-search"></i></a>'
					, '#sp_'+row.sub_id
					,{
						tips: [1, '#FFF'],
					}
				);
			$(this).treegrid('expand',row.sub_id);
		},
		onDblClickRow: function(row)
		{
			$(this).treegrid('collapse',row.sub_id);

			<? if( ! empty($flag_select) ){ ?>
			<?=$fun_select?>('table_tree<?=$time?>',row);
			<? }?>
		},
		onBeforeDrop: function(targetRow,sourceRow,point)
		{
			if(targetRow)
				$(this).treegrid('expand',targetRow.sub_id);

			var parent=targetRow;//$(this).treegrid('getParent',sourceRow.ou_id);

			var sub_parent = '';
			if(targetRow)
			{ 
				if(point == 'append')
					sub_parent=base64_decode(targetRow.sub_id);
				else
					sub_parent=base64_decode(targetRow._parentId);
			}
			
			var sub_id = base64_decode(sourceRow.sub_id);
			var sub_name = base64_decode(sourceRow.sub_name);

			var check=true;
			
			//保存配置
			$.ajax({
		        url:"proc_bud/subject/win_tree",
		        type:"POST",
		        async:false,
		        data:{
					sub_parent: sub_parent,
					sub_id : sub_id,
					sub_name : sub_name,
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
	var url = 'proc_bud/subject/edit/act/2';

		url+='/sub_id/'+op_id

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