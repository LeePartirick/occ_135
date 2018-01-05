<form id="f_login" class="easyui-form" method="post" data-options="novalidate:true">  
	<table style="width:280px;margin:0 auto;">
		<tr>
	        <td style="width:100%;height:15px;text-align:right;"></td>
		</tr>
		<tr>
	        <td style="text-align:center;vertical-align:text-top;height:140px">
	        	<center>
	        	<div style="height:124px;width:102px;" class="div_circle">
	        		<img src="app/get_photo.html" style="width:102px;margin-top:auto;margin-bottom:auto;"/>
	        	</div>
	        	</center>
        	</td>
		</tr>    
		<tr>
	        <td style="text-align:center;vertical-align:text-top;height:60px;">
	        	<input id="txtb_login_id"
	        		   name="data[login_id]"
	        		   oaname="data[login_id]"
	        		   type="text" 
	        		   class="easyui-textbox oa_input" 
	        		   data-options="iconCls:'icon-man',
	        		   				 iconWidth:30,
	        		   				 iconAlign:'left',
	        		   				 prompt:'请输入账号',
	        		   				 validType:['length[0,20]','errMsg[\'#hd_err_f_login\']'],
	        		   				 required:true,
	        		   				 missingMessage:'请输入账号',
	        		   				 err:err,
	        		   				 buttonIcon:'icon-clear',
	        		   				 onClickButton:function()
	        		   				 {
	        		   				 	$(this).textbox('clear');
	        		   				 }
	        		   				 " 
	        		   style="width:100%;height:40px;"/> 
	        </td>
	    </tr>
	    <tr>
	        <td style="text-align:center;vertical-align:text-top;height:60px;">
	        	<input id="txtb_login_pwd"
	        		   name="data[login_pwd]"
	        		   oaname="data[login_pwd]"
	        		   class="easyui-passwordbox oa_input" 
	        		   data-options="iconAlign:'left',
	        		   				 iconWidth:30,
	        		   				 prompt:'请输入密码',
	        		   				 validType:['length[0,30]','errPwd','errMsg[\'#hd_err_f_login\']'],
	        		   				 required:true,
	        		   				 missingMessage:'请输入密码',
	        		   				 err:err,
	        		   				 buttonIcon:'icon-clear',
	        		   				 onClickButton:function()
	        		   				 {
	        		   				 	$(this).passwordbox('clear');
	        		   				 }
	        		   				"  
	        		   style="width:100%;height:40px"/> 
        	</td>
		</tr>
		
		<tr>
	        <td style="text-align:center;vertical-align:text-top;height:60px;">
	        	<input id="txtb_yzm"
	        		   name="data[login_yzm]"
	        		   oaname="data[login_yzm]"
	        		   type="text" 
	        		   class="easyui-textbox oa_input" 
	        		   data-options="icons:[{iconCls:'icon-yzm',
	        		   						 handler: function(e){
	        		   						 	//点击变更验证码
	        		   						 	fun_load_YZM();
	        		   						}}],
        	   						 iconAlign:'left',
	        		   				 iconWidth:90,
	        		   				 buttonText:'&lt;span id=&quot;sp_yzm_time&quot; tabindex=&quot;-1&quot;&gt;00s&lt;/span&gt;',
	        		   				 buttonAlign:'left',
	        		   				 prompt:'请输入数字验证码',
	        		   				 validType:['length[0,4]','errMsg[\'#hd_err_f_login\']'],
	        		   				 required:true,
	        		   				 missingMessage:'请输入验证码',
	        		   				 err:err,
	        		   				 "   
	        		   style="width:100%;height:40px"/> 
	        		   
        	   <!-- 验证码有效期 -->
        	   <input id="hd_yzm_time" type="hidden" />
        	</td>
		</tr>
			
		<tr>
	        <td style="text-align:center;vertical-align:text-top;padding:5px;">
	        	<a href="javascript:void(0)" 
	        	   class="easyui-linkbutton" 
	        	   style="width:100%;height:40px;"
	        	   onclick="fun_f_login_submit('login')">登录</a>  
	           <!-- 验证错误 -->
        	   <input id="hd_err_f_login" type="hidden" />
        	</td>
		</tr>
		
		<tr>
	        <td style="text-align:center;vertical-align:text-top;padding:5px;">
	        	<a href="javascript:void(0)" 
	        	   class="easyui-linkbutton" 
	        	   style="width:100%;height:40px;"
	        	   onclick="$('#f_login').form('clear')">重置</a>  
        	</td>
		</tr> 
	</table>
</form>

<!-- 验证码css -->
<style id='css_yzm'></style>