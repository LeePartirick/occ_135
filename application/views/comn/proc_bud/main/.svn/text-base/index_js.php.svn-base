<!-- 加载jquery -->
<script type="text/javascript">
//初始化
$(document).ready(function(){

	document.title =document.title+'-预算表' ;

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
			  {id:'budm',name:'预算表模型',iconCls:''},
			  {id:'subject',name:'预算科目',iconCls:''},
			  {id:'bl_ppo',name:'经费流程',iconCls:''},
			  {id:'invoice_type',name:'发票类型',iconCls:''},
			  {id:'tax',name:'流转税',iconCls:''},
	  	],
	  	onLoadSuccess: function(data)
	  	{
			$('#table_dh<?=$time?>').treegrid('select','budm');

			var row = $('#table_dh<?=$time?>').treegrid('getSelected');
			fun_open_tab_center<?=$time?>(row);
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
			case '预算表模型':
			url="proc_bud/budm/index/fun_open/tab.html";
			break;
			case '预算科目':
			url="proc_bud/subject/main/fun_open/tab.html";
			break;
			case '经费流程':
			url="proc_bud/bl_ppo/index/fun_open/tab.html";
			break;
			case '流转税':
			url="proc_bud/tax/index/fun_open/tab.html";
			break;
			case '发票类型':
			url="proc_bud/invoice_type/index/fun_open/tab.html";
			break;
		}
		
		$('#tab_center<?=$time?>').tabs('add',{
			iconCls: op.iconCls,
			title: op.name,
			closable: true,
			href:url,
		});
	}
}
	

</script>