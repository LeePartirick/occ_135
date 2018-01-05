<div class="easyui-layout " 
 	 data-options="fit:true">
	<div data-options="region:'north',border:false" style="height:50px;padding:5px;">
		<input id="txtb_proc_search<?=$time?>" >
	</div>
	<div data-options="region:'center',border:false" style="padding:5px;">
	
		<?php foreach ($list_proc as $v) { ?>
			
			<a id="p_<?=$v['p_id'].$time?>"
			   name="p_<?=$v['p_id'].$time?>"
			   href="javascript:void(0)" 
			   class="easyui-linkbutton" 
			   style="min-width:100px;margin:3px;"
			   data-options="
			   <?php if( $v['p_status_run'] != 1 || empty($v['ra_id_all']) ){?>
			   disabled:true,
			   <?php }?>
			   "
			   onClick="window.open('<?=$v['p_url']?>')"
			 >
				<?=$v['p_name']?>
			</a>
			
		<?php }?>
	
	</div>
</div>