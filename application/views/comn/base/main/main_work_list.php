<div id="tab_work_list<?=$time?>" 
	 class="easyui-tabs" 
	 data-options="fit:true,
	 			   plain:true,
	 			   tabWidth:120,
	 			   onSelect:  function(title,index){
	 			   }
	 			   "
	 style=""> 
	 
	<div title="待办事项 <span class='m-badge wl_to_do' style='display:none'></span>" style="padding:0px;">  
		<div id="table_wlist_to_do_tool<?=$time?>" style="height:25px;">
    		<table style="width:100%;">
    		<tr>
	    		<td style="width:50%">
	        		<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'pagination-load',plain:true" onClick="$('#table_wlist_to_do<?=$time?>').datagrid('reload')"></a> 
	    		</td>
	    		<td  class="table_page" style="width:50%;text-align:right;">
	    		
	    		</td>
    		</tr>
    		</table>
    	</div>
    	<table class="table_wlist_to_do" id="table_wlist_to_do<?=$time?>"></table>
	</div>
	
	<div title="已办事项<span class='m-badge wl_have_do' style='display:none'></span>" style="padding:0px;"> 
		<div id="table_wlist_have_do_tool<?=$time?>" style="height:25px;">
    		<table style="width:100%;">
    		<tr>
	    		<td style="width:50%">
	        		<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'pagination-load',plain:true" onClick="$('#table_wlist_have_do<?=$time?>').datagrid('reload')"></a> 
	    		</td>
	    		<td  class="table_page" style="width:50%;text-align:right;">
	    		
	    		</td>
    		</tr>
    		</table>
    	</div>
    	<table class="table_wlist_have_do" id="table_wlist_have_do<?=$time?>"></table>
	</div>
	
	<div title="已结事项<span class='m-badge wl_end' style='display:none'></span>" style="padding:0px;">   
		<div id="table_wlist_end_tool<?=$time?>" style="height:25px;">
    		<table style="width:100%;">
    		<tr>
	    		<td style="width:50%">
	        		<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'pagination-load',plain:true" onClick="$('#table_wlist_end<?=$time?>').datagrid('reload')"></a> 
	    		</td>
	    		<td  class="table_page" style="width:50%;text-align:right;">
	    		
	    		</td>
    		</tr>
    		</table>
    	</div>
    	<table class="table_wlist_end" id="table_wlist_end<?=$time?>"></table>
	</div>
	
	<div title="我的请求<span class='m-badge wl_i' style='display:none'></span>" style="padding:0px;">  
	 	<div id="table_wlist_i_tool<?=$time?>" style="height:25px;">
    		<table style="width:100%;">
    		<tr>
	    		<td style="width:50%">
	        		<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'pagination-load',plain:true" onClick="$('#table_wlist_i<?=$time?>').datagrid('reload')"></a> 
	    		</td>
	    		<td  class="table_page" style="width:50%;text-align:right;">
	    		
	    		</td>
    		</tr>
    		</table>
    	</div>
    	<table class="table_wlist_i" id="table_wlist_i<?=$time?>"></table>
	</div>  
	 
    <div title="我的关注<span class='m-badge wl_care' style='display:none'></span>" style="padding:0px;"> 
    	<div id="table_wlist_care_tool<?=$time?>" style="height:25px;">
    		<table style="width:100%;">
    		<tr>
	    		<td style="width:50%">
	        		<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'pagination-load',plain:true" onClick="$('#table_wlist_care<?=$time?>').datagrid('reload')"></a> 
	    		</td>
	    		<td  class="table_page" style="width:50%;text-align:right;">
	    		
	    		</td>
    		</tr>
    		</table>
    	</div>
    	<table class="table_wlist_care" id="table_wlist_care<?=$time?>"></table>
    </div>
    
</div>
