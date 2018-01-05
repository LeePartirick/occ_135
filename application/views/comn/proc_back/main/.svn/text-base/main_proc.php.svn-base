<div id="p_test"
	 class="easyui-panel" 
	 data-options="fit:true,
	 			   border:false"
	 style="padding:5px"
	 >
	 
<div class="easyui-layout" 
	 data-options="fit:true"
	 >
	  
	<div data-options="region:'west',
                   	   title:'查询选项',
                   	   iconCls:'icon-search',
                   	   hideCollapsedContent:false,
                   	   split:true" 
         		 style="width:300px;">	
         		 
   		<div id="table_proc_search_tool">
 			<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-search',plain:true" onClick="fun_table_proc_search();">查询</a>
 			<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-reload',plain:true" onClick="load_table_proc_search();">重置</a>
 			<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-clear',plain:true" onClick="fun_proc_search_clear();">清空</a>
 			<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-man',plain:true" onClick="fun_person_search($('#table_proc_search'),'<?=$url?>')">个性化</a>
 		</div>   		 
 		
 		<table id="table_proc_search"></table>
 		
 		<div id="menu_table_proc_search" class="easyui-menu" style="width:200px;">   
 			<div data-options="name:'add',iconCls:'icon-add'">添加查询条件</div>   
 			<div data-options="name:'del',iconCls:'icon-remove'">删除查询条件</div>   
		</div>  
		
   </div>    
   
   <div data-options="region:'center'" 
        style="">
   		<div id="table_proc_tool">
 		<table style="width:100%">
 			<tr>
 				<td style="">
 					<a href="javascript:void(0)" 
			 		   class="easyui-linkbutton" 
			 		   data-options="iconCls:'pagination-load',
			 		   				  plain:true" 
 	   				   onClick="$('#table_proc').datagrid('reload')"></a>
 	   				   
 					<a href="javascript:void(0);"  
 					   class="easyui-linkbutton" 
 					   onClick="fun_person_index_search($('#table_proc'),'<?=$url?>',$('#table_proc_search'))"
 					   data-options="iconCls:'icon-xlsx',
 					   				 plain:true">导出</a>  
 					   				 
 					<a href="javascript:void(0);"  
 					   class="easyui-linkbutton" 
 					   onClick="fun_person_index_search($('#table_proc'),'<?=$url?>')"
 					   data-options="iconCls:'icon-man',
 					   				 plain:true">个性化</a>     				 
 				</td>
 				<td id="td_proc_page" style="text-align:right;">
 				
 				</td>
 			</tr>   				 
 		</table>	   				 
 		</div>
 		
 		<table id="table_proc" ></table>
   </div>
    		 	  
</div>

</div>