<div id="l_<?=$time?>"
	 class="easyui-layout" 
	 data-options="fit:true" 
	 style="">
	<div data-options="region:'west',
						title:'文件属性',
						split:true,
						href:'proc_file/file_type/win_tree/time/tree_<?=$time?>',
						tools:[{
							iconCls:'icon-reload',
							handler:function(){
								$('#l_<?=$time?>').layout('panel','west').panel('refresh');
							}
						}]"
		 style="width:250px">

	</div>

    <div data-options="region:'center',href:'proc_file/file_type/index/time/index_file_<?=$time?>'" style="padding:0px;">
    
    </div>   
</div>  
	
	
	 
	 
