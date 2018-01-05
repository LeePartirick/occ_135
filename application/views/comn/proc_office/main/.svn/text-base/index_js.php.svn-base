<!-- 加载jquery -->
<script type="text/javascript">
//初始化
$(document).ready(function(){

	document.title =document.title+'-信息系统' ;

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
			  {id:'offa_start',name:'开通申请',iconCls:''},
			  {id:'offa_end',name:'注销申请',iconCls:''},
			  {id:'office',name:'信息系统',iconCls:''},
	          {id:'hr_office',name:'员工索引',iconCls:''},
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
			case '开通申请':
			url="proc_office/office_apply/index/fun_open/tab.html";
			break;
			case '注销申请':
				url="proc_office/office_logout/index/fun_open/tab.html";
				break;
			case '信息系统':
			url="proc_office/oa_office/index/fun_open/tab.html";
			break;
			case '员工索引':
				url="proc_office/oa_contact/index/fun_open/tab.html";
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