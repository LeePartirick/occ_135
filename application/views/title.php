<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<? if ( ! empty ($this->sess->userdata('a_id') ) ){ ?>
	
	<!-- 按钮工具栏 -->
	<div data-options="region:'north'"  style="height:60px;padding:5px;display:none;background:#5488D4;">
		
		<img src="inc/img/logo/logo_CETC.png" style="height:40px;margin-left:10px;margin-top:2px;">
		<img src="inc/img/logo/logo_30red.png" style="height:45px;margin-left:10px;margin-top:2px;">
		<img src="inc/img/logo/logo_occ.png" style="height:35px;margin-left:10px;margin-top:10px;">
		
		<span id="sp_msg_login" style="position:absolute;font-size:14px;right:5px;top:5px;color:#fff">
		<?=date("Y-m-d")?> 
		星期
		<?=$GLOBALS['m_base']['text']['weekday'][date("w")]?>
		<?=$this->sess->userdata('c_name')?>[<?=$this->sess->userdata('a_login_id')?>] ,欢迎登陆！
		</span>
		
		<div style="position:absolute; right:10px;bottom:5px;">
		
			<a href="app/index.html" class="easyui-linkbutton"  data-options="iconCls:'icon-home'"  style="height:30px;width:45px;">&nbsp;</a>  
			<a href="javascript:void(0)" class="easyui-linkbutton"  data-options="iconCls:'icon-search'" style="height:30px;width:45px;">&nbsp;</a>  
		    <a id="btn_back_task" href="javascript:void(0)" class="easyui-linkbutton"  data-options="iconCls:'icon-task'" onmouseenter="fun_show_back_task(this)" style="height:30px;width:45px;"><span class="m-badge" style="display:none;"></span>&nbsp;</a>  
		    
		</div>
				
	</div>
			
<? } ?>