<table style="width:100%;">
	<tr>
		<td style="width:125px;text-align:right;">
    		<a href="base/main/login_out.html" title="注销" class="easyui-linkbutton" data-options="iconCls:'icon-login_out',plain:true"></a>
    		<a href="javascript:void(0)" title="编辑个人信息" onClick="fun_index_win_person_open<?=$time?>('编辑个人信息','win','proc_hr/hr_info/edit/act/2/c_id/<?=$this->sess->userdata('c_id')?>/flag_edit/1')" class="easyui-linkbutton" data-options="iconCls:'icon-man',plain:true"></a>
    	</td>
    	<td style="width:200px;font-size:18px;">
			<?=$this->sess->userdata('c_name')?>
    	</td>
	</tr>
	<tr>
    	<td rowspan = "6">
    		<center>
        	<div style="height:160px;width:112px;">
        		<img src="app/get_photo.html" style="width:102px;margin-top:auto;margin-bottom:auto;"/>
        	</div>
        	</center>
    	</td>
    	<td style="font-size:14px;">
    		<?=$this->sess->userdata('a_login_id')?>
    	</td>
    </tr>
    <tr>
    	<td style="font-size:14px;">
    		<?=$this->sess->userdata('c_tel')?>
    	</td>
    </tr>
    <tr>
    	<td style="font-size:14px;">
    		<?=$this->sess->userdata('c_tel_code')?>
    	</td>
    </tr>
    <tr>
    	<td style="font-size:14px;">
    		<?=$this->sess->userdata('hr_ou_name')?>
    	</td>
    </tr>
    <tr>
    	<td style="font-size:14px;">
    		<?=$this->sess->userdata('hr_ou_name_3')?>
    	</td>
    </tr>
    <tr>
    	<td style="font-size:14px;">
    		<?=$this->sess->userdata('hr_job_name')?>
    	</td>
    </tr>
</table>

<!-- 加载jquery -->
<script type="text/javascript">

//界面
function fun_index_win_person_open<?=$time?>(title,fun,url)
{
	switch(fun)
	{
		case 'win':

			var win_id=fun_get_new_win();

			$('#'+win_id).window({
				title: 'title',
				inline:true,
				modal:true,
				closed:true,
				border:'thin',
				draggable:false,
				resizable:false,
				collapsible:false,
				minimizable:false,
				maximizable:true,
				onMaximize: function()
				{
					$(this).window('close');
					$(this).window('clear');
					fun_index_win_person_open<?=$time?>(title,'winopen',url)
				},
				onClose: function()
				{
					$('#'+win_id).window('destroy');
					$('#'+win_id).remove();
				}
			})
			
			$('#'+win_id).window('refresh',url+'/fun_open/win/fun_open_id/'+win_id);

			break;
		case 'winopen':

			window.open(url+'/fun_open/winopen');

			break;
	}
}
</script>