<!-- 加载jquery -->
<script type="text/javascript">
//初始化
$(document).ready(function(){
	
	document.title ='<?=$this->config->item('site_title')?>-后台管理' ;

	//加载导航列表
	load_table_back_dh();
	
});

//加载导航列表
function load_table_back_dh()
{
	$('#table_back_dh').treegrid({    
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
			  {id:'account',name:'账户管理',iconCls:''},
			  {id:'role',name:'角色管理',iconCls:''},
	          {id:'proc',name:'模块管理',iconCls:''},
	          {id:'acl',name:'权限管理',iconCls:''},
	  	],
	  	onLoadSuccess: function(data)
	  	{
			var row={id:'base',name:'模块管理',iconCls:''};
			fun_open_tab_back_center(row);
	  	},
	  	onClickRow: function(row)
	  	{
	  		fun_open_tab_back_center(row);
	  	}     
  	
	}); 
		
	 $('#table_back_dh').datagrid('getPanel').removeClass('lines-both lines-no lines-right lines-bottom').addClass('lines-no');	
}

//打开后台标签
function fun_open_tab_back_center(op)
{
	$('#tab_back_center').tabs();
	var tab=$('#tab_back_center').tabs('getTab',op.name);

	if(tab)
	{
		$('#tab_back_center').tabs('select',op.name);
	}
	else
	{
		var url="";

		switch(op.name)
		{ 

			case '账户管理':
			url="proc_back/account/index/fun_open/tab.html";
			break;

			case '角色管理':
			url="proc_back/role/index/fun_open/tab.html";
			break;
			
			case '模块管理':
			url="proc_back/main/main_proc/fun_open/tab.html";
			break;

			case '权限管理':
			url="proc_back/acl/main/fun_open/tab.html";
			break;
		}
		
		$('#tab_back_center').tabs('add',{
			iconCls: op.iconCls,
			title: op.name,
			closable: true,
			href:url,
		});
	}
}

</script>