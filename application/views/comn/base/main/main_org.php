<div id="l_home_org<?=$time?>"
     class="easyui-layout" 
 	 data-options="fit:true">
 	 
	<div data-options="region:'north',border:false" style="height:auto;padding:0px;">
 		<a href="javascript:void(0)" class="easyui-linkbutton" 
 		   data-options="width:100,toggle:true,group:'proc_class'"
 		   style="margin:3px;"
 		   onClick="fun_load_table_proc_list<?=$time?>($(this),'')">全部</a>  
 		<a href="javascript:void(0)" class="easyui-linkbutton" 
 		   data-options="width:100,toggle:true,group:'proc_class'"
 		   style="margin:3px;"
 		   onClick="fun_load_table_proc_list<?=$time?>($(this),'<?=P_CLASS_OA?>')">协同</a>  
 		<a href="javascript:void(0)" class="easyui-linkbutton" 
 		   data-options="width:100,toggle:true,group:'proc_class'"
 		   style="margin:3px;"
 		   onClick="fun_load_table_proc_list<?=$time?>($(this),'<?=P_CLASS_CRM?>')">客户</a>  
 		<a href="javascript:void(0)" class="easyui-linkbutton" 
 		   data-options="width:100,toggle:true,group:'proc_class'"
 		   style="margin:3px;"
 		   onClick="fun_load_table_proc_list<?=$time?>($(this),'<?=P_CLASS_HR?>')">人事</a>  
 		<a href="javascript:void(0)" class="easyui-linkbutton" 
 		   data-options="width:100,toggle:true,group:'proc_class'"
 		   style="margin:3px;"
 		   onClick="fun_load_table_proc_list<?=$time?>($(this),'<?=P_CLASS_SM?>')">采购</a>  
 		<a href="javascript:void(0)" class="easyui-linkbutton" 
 		   data-options="width:100,toggle:true,group:'proc_class'"
 		   style="margin:3px;"
 		   onClick="fun_load_table_proc_list<?=$time?>($(this),'<?=P_CLASS_PM?>')">项目</a>  
 		<a href="javascript:void(0)" class="easyui-linkbutton" 
 		   data-options="width:100,toggle:true,group:'proc_class'"
 		   style="margin:3px;"
 		   onClick="fun_load_table_proc_list<?=$time?>($(this),'<?=P_CLASS_FM?>')">财务</a>
 		<a href="javascript:void(0)" class="easyui-linkbutton"
 		   data-options="width:100,toggle:true,group:'proc_class'"
 		   style="margin:3px;"
 		   onClick="fun_load_table_proc_list<?=$time?>($(this),'<?=P_CLASS_ZC?>')">资产</a>      
 		<a href="javascript:void(0)" class="easyui-linkbutton"
 		   data-options="width:100,toggle:true,group:'proc_class'"
 		   style="margin:3px;"
 		   onClick="fun_load_table_proc_list<?=$time?>($(this),'<?=P_CLASS_BI?>')">报表</a>  
 		<a href="javascript:void(0)" class="easyui-linkbutton" 
 		   data-options="width:100,toggle:true,group:'proc_class'"
 		   style="margin:3px;"
 		   onClick="fun_load_table_proc_list<?=$time?>($(this),'<?=P_CLASS_OTHER?>')">其他</a>  
 	</div> 		
 	
 	<div data-options="region:'center',border:false">
 		
 		<div id="tabs_org<?=$time?>" 
 			class="easyui-tabs" 
			data-options="fit:true,
			 			  showHeader: false,
			 			  plain:true,
			 			  border:false,
			 			  "
			 style=""> 
			 
			<div title="公司门户 "  style="padding:5px;">  
			
			</div> 
			
			<div title="流程列表 "  style="">  
			 
			</div>
			 
		</div>	 
	</div>		 
 	   
</div>