<!-- 加载jquery -->
<script type="text/javascript">
//初始化
$(document).ready(function(){

	document.title =document.title+'-主页' ;

	//加载导航列表
	load_table_dh<?=$time?>();

	load_table_wlist_to_do<?=$time?>();

	load_table_wlist_have_do<?=$time?>();
	
	load_table_wlist_end<?=$time?>();

	load_table_wlist_i<?=$time?>();

	load_table_wlist_care<?=$time?>();

	if(client_id)
	$.cookie('client_id',client_id)
	
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
			  {id:'dong',name:'党群门户',iconCls:''},
			  {id:'org',name:'公司门户',iconCls:''},
	          {id:'person',name:'个人门户',iconCls:''},
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
			case '公司门户':
//			url="base/main/main_org.html";
			break;
		}
		
		$('#tab_center<?=$time?>').tabs('add',{
			iconCls: op.iconCls,
			title: op.name,
			closable: true,
//			href:url,
		});
	}
}
	

</script>