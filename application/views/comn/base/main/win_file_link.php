<div class="easyui-panel" 
	 data-options="fit:true,
	 			   border:false"
	 style="padding:5px"
	 >
<div id="l_index_<?=$time?>"  
	 class="easyui-tabs" 
	 data-options="fit:true,plain:true,tabWidth:120" 
	 style="">
	 
	 <div title="索引列表" style="padding:5px;">  
	 	
	 	<div class="easyui-layout" 
		 	 data-options="fit:true">
		 	 
			<div data-options="region:'west',
		 					   title:'查询选项',
	                   		   iconCls:'icon-search',
	                   		   hideCollapsedContent:false,
	                   		   split:true" 
	                    style="width:300px;">
	                    
	        	<div id="table_search<?=$time?>_tool">
 					<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-search',plain:true" onClick="fun_table_search<?=$time?>();">查询</a>
 					<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-reload',plain:true" onClick="load_table_search<?=$time?>();">重置</a>
 					<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-clear',plain:true" onClick="fun_table_search_clear<?=$time?>();">清空</a>
 					<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-man',plain:true" onClick="fun_person_search($('#table_search<?=$time?>'),'<?=$url?>')">个性化</a>
 				</div>
 				
 				<table id="table_search<?=$time?>"></table>
 		
 				<div id="menu_table_search<?=$time?>" class="easyui-menu" style="width:200px;">   
 					<div data-options="name:'add',iconCls:'icon-add'">添加查询条件</div>   
 					<div data-options="name:'del',iconCls:'icon-remove'">删除查询条件</div>   
				</div>            		
				 			   	  
			</div>
			
			<div data-options="region:'center'" style="">
			
				<div id="table_index_tool<?=$time?>">
					<table style="width:100%">
		 			<tr>
		 				<td style="">
		 					<a href="javascript:void(0)" 
					 		   class="easyui-linkbutton" 
					 		   data-options="iconCls:'pagination-load',
					 		   				  plain:true" 
	 		   				   onClick="$('#table_index<?=$time?>').datagrid('reload')"
	 		   				   style=""></a>
	 		   				   
	 		   				<? if( ! empty($flag_select) ){ ?>
					 		<a href="javascript:void(0);"  
		 					   class="easyui-linkbutton oa_op" 
		 					   oaname="btn_select"
		 					   onClick="<?=$fun_select?>($('#table_index<?=$time?>'))"
		 					   data-options="iconCls:'icon-ok',
		 					   				 plain:true">选择</a>  
					 		<? }?>
					 		
	 		   				<a id="btn_more<?=$time?>" href="javascript:void(0)" class="easyui-menubutton"     
							   data-options="menu:'#menu_more_<?=$time?>',iconCls:'icon-tool'">批量</a> 
							     
							<div id="menu_more_<?=$time?>" style="width:100px;">   
								<?php if($flag_f_del == 1){ ?>
							    <div data-options="iconCls:'icon-cancel'" onClick="fun_operate_more_check<?=$time?>('del')" >删除</div>   
							    <?php } ?>
							    <div data-options="iconCls:'icon-edit'" onClick="fun_operate_more_check<?=$time?>('edit')" >编辑</div> 
							</div> 
	 		   				   
<!--	 		   				<a href="javascript:void(0);"  -->
<!--		 					   class="easyui-linkbutton" -->
<!--		 					   onClick="fun_person_index_search($('#table_index<?=$time?>'),'<?=$url?>',$('#table_search<?=$time?>'))"-->
<!--		 					   data-options="iconCls:'icon-xlsx',-->
<!--		 					   				 plain:true">导出</a>-->
		 				
		 					<a href="javascript:void(0);"  
		 					   class="easyui-linkbutton" 
		 					   onClick="fun_person_index_search($('#table_index<?=$time?>'),'<?=$url?>')"
		 					   data-options="iconCls:'icon-man',
		 					   				 plain:true">个性化</a>  
		 					   
		 					<a href="javascript:void(0);"  
		 					   class="easyui-linkbutton" 
		 					   onClick="load_win_edit<?=$time?>('','<?=STAT_ACT_CREATE;?>')"
		 					   data-options="iconCls:'icon-add',
		 					   				 plain:true">新建</a>  
							<a href="javascript:void(0);"  
		 					   class="easyui-linkbutton" 
		 					   onClick="fun_operate_more_check<?=$time?>('zip')"
		 					   data-options="iconCls:'icon-download',
		 					   				 plain:true">下载</a> 
		 				</td>
		 				<td id="td_page<?=$time?>" style="text-align:right;">
 				
 						</td>
		 			</tr>
		 			</table>
				</div>
				
				<table id="table_index<?=$time?>" no_page=""></table>
				
			</div>
			
		</div>
				 
	 </div>
	
</div>

<div id="win_edit<?=$time?>"></div>

</div>
				