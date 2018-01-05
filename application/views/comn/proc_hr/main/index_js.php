<!-- 加载jquery -->
<script type="text/javascript">
//初始化
$(document).ready(function(){

	document.title =document.title+'-人事管理' ;

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
			  {id:'hr_offer',name:'员工录用',iconCls:''},
			  {id:'hr_info',name:'员工索引',iconCls:''},
	          {id:'hr_dim',name:'员工离职',iconCls:''},
	          {id:'hr_doc',name:'归档信息',iconCls:''},
	          {id:'hr_job',name:'职位管理',iconCls:''},
			  {id:'hr_zw',name:'职务管理',iconCls:''},
//			  {id:'hr_contract',name:'合同管理',iconCls:''},
			  {id:'hr_tec',name:'技术方向',iconCls:''},
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
			case '员工录用':
			url="proc_hr/hr_offer/index/fun_open/tab.html";
			break;
			case '员工索引':
			url="proc_hr/hr_info/index/fun_open/tab.html";
			break;
			case '职位管理':
			url="proc_hr/hr_job/index/fun_open/tab.html";
			break;
			case '技术方向':
				url="proc_hr/hr_tec/index/fun_open/tab.html";
			break;
			case '职务管理':
				url="proc_hr/hr_zw/index/fun_open/tab.html";
			break;
//			case '合同管理':
//				url="proc_hr/hr_contract/index/fun_open/tab.html";
//				break;
			case '员工离职':
				url="proc_hr/hr_dim/index/fun_open/tab.html";
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