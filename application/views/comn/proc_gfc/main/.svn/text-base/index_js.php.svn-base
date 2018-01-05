<!-- 加载jquery -->
<script type="text/javascript">
//初始化
$(document).ready(function(){

	document.title =document.title+'-项目管理' ;

	//加载导航列表
	load_table_dh<?=$time?>();
	
});

//加载导航列表
function load_table_dh<?=$time?>()
{
	$('#table_dh<?=$time?>').treegrid({    
		fit:true,
		title:'<span>导航列表</span>',
//		border:false,
		showHeader:false,
	    idField:'id',    
	    treeField:'name',  
	    columns:[[    
	        {title:'name',field:'name',width:'100%'},    
	    ]],
	    data:[
			  {id:'gfc',name:'财务编号',iconCls:''},
			  {id:'gfc_bp',name:'开票回款计划',iconCls:''},
			  {id:'gfc_secret',name:'标密申请',iconCls:''},
			  {id:'cr',name:'评审设置',iconCls:''},
	  	],
	  	onLoadSuccess: function(data)
	  	{
			$('#table_dh<?=$time?>').treegrid('select','org');
	  	},
	  	onClickRow: function(row)
	  	{
	  		fun_open_tab_center<?=$time?>(row);
	  	}     
  	
	}); 
		
	 $('#table_dh<?=$time?>').datagrid('getPanel').removeClass('lines-both lines-no lines-right lines-bottom').addClass('lines-no');	
}

//打开导航
function fun_open_tab_center<?=$time?>(op)
{
	$('#tab_center<?=$time?>').tabs();
	var tab=$('#tab_center<?=$time?>').tabs('getTab',op.name);

	if(tab)
	{
		$('#tab_center<?=$time?>').tabs('select',op.name);
	}
	else
	{
		var url="";

		switch(op.name)
		{ 
			case '财务编号':
			url="proc_gfc/gfc/index/fun_open/tab.html";
			break;
			case '开票回款计划':
			url="proc_gfc/gfc_bp/index/fun_open/tab.html";
			break;
			case '标密申请':
			url="proc_gfc/gfc_secret/index/fun_open/tab.html";
			break;
			case '评审设置':
			url="proc_gfc/cr/index/fun_open/tab.html";
			break;
		}
		
		$('#tab_center<?=$time?>').tabs('add',{
			iconCls: op.iconCls,
			title: op.name,
			closable: true,
			href:url,
			tools:[{
		        iconCls:'icon-win_max',
		        handler:function(){
					$.messager.confirm('确认', '是否需要打开新窗口？<br>当前为保存数据不做保留！', function(r){
						if (r){
							window.open(url);
							var tab =$('#l_index_<?=$time?>').tabs('getTab',title);
							var index = $('#l_index_<?=$time?>').tabs('getTabIndex',tab);
							$('#l_index_<?=$time?>').tabs('close',index);
						}
					});
		        }
			}]
		});
	}
}
	

</script>