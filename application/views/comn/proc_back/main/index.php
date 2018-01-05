<div class="easyui-layout"
	 data-options="fit:true"
	 style="">
	 
	<div data-options="region:'west',border:false" 
		 style="width:150px;padding:5px;">
		 
		<!-- 导航列表 -->
    	<table id="table_back_dh" style=""></table> 
		
	</div>
	 
	<div data-options="region:'center',border:false" style="padding:5px;">
		<div id="tab_back_center" class="easyui-tabs" 
			 data-options="fit:true,
			 			   plain:true,
    	     			   tabWidth:150,
    	     			   onSelect: function(title,index)
    	     			   {
    	     			   		var row=$('#table_back_dh').treegrid('getData');
								for(var i=0;i < row.length;i++)
								{
									if(row[i].name == title)
									$('#table_back_dh').treegrid('select',row[i].id);
								}
    	     			   }
    	     			   "
    	     >
		</div>
	</div>
			
</div>