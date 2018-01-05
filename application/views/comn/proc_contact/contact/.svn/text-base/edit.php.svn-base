<div id="tab_edit_<?=$time?>" 
	 class="easyui-tabs" 
     data-options="fit:true,
    			   border:false,
    			   showHeader:false,
            	   tabWidth:150,
            	   onSelect: function(title,index)
            	   {
            	   		if( title == '操作日志' && $('#table_indexlog_<?=$time?>').length > 0)
            	   		{
            	   			$('#table_indexlog_<?=$time?>').datagrid('reload');
            	   		}
            	   }">
    <div title="联系人" 
         style="">
         
        <div id="l_<?=$time?>" 
	   		class="easyui-layout" 
		 	data-options="fit:true">
		 	
		 	<div data-options="region:'north',border:false" 
		 		style="height:auto;padding-top:15px;overflow:hidden;">	
		 		<? if( ! empty($log_time) ){ ?>
		 		<center><span class="tb_title"><b>操作日志</b></span></center>
				<table style="width:800px;margin:0 auto;" class="table_no_line">
	       			<tr>
	       				<td style="width:'33%';">
	       				<b>操作时间:</b> <?=$log_time?>
	       				</td>
	       				<td style="width:'33%';">
	       				<b>操作类型:</b> <?=$log_act?>
	       				</td>
	       				<td style="width:'34%';">
	       				<b>操作人:</b> <?=$log_c_name?>[<?=$log_a_login_id?>]
	       				</td>
	       			</tr>
	       			<tr>
	       				<td colspan="3">
	       				    <input class="easyui-textbox oa_input" 
		       						data-options="label:'<b>备注:</b>',
		       									  labelWidth:60,
												  multiline:true,
												  height:40,
												  readonly:true,
												  iconCls:'icon-lock'"
									value="<?=$log_note?>"
		       						style="width:100%"/>
	       				</td>
	       			</tr>
	       		</table>
		 		<br/>
		 		<? }?>
		 		<center><span class="tb_title"><b>联系人</b></span></center>
		 		
		 		<table id="table_h_<?=$time?>" class="table_no_line"  style="width:800px;margin:0 auto;">
		 			<tr>
		       			<td style="width:'50%';">
		       			<b><?=$code?></b>
		       			</td>
		       			<td style="width:'50%';text-align:right;">
		       			<b><?=$db_time_create?></b>
		       			</td>
		       		</tr>
		       		<tr>
		       			<td style="width:'50%';">
		       				<a href="javascript:void(0)" oaname="btn_save" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-save'" onClick="f_submit_<?=$time?>('save');">保存</a>  
		       				<a href="javascript:void(0)" oaname="btn_import" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-xlsx'" onClick="fun_xlsx_import('proc_contact/m_contact','联系人','proc_contact/contact/import')">导入</a>  
		       			</td>
		       			<td style="width:'50%';text-align:right;">
		       				<a href="javascript:void(0)" oaname="btn_person" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-man'" onClick="fun_person_create($('#f_<?=$time?>'),'<?=$url_conf?>')">个性化</a>  
		       				<a href="javascript:void(0)" oaname="btn_log" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-log'" onClick="$('#tab_edit_<?=$time?>').tabs('select',1)">日志</a>  
		       				<a href="javascript:void(0)" oaname="btn_del" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-cancel'" onClick="$.messager.confirm('确认','您确认想要删除记录吗？',function(r){if(r)f_submit_<?=$time?>('del');});">删除</a>  
		       			</td>
		       		</tr>
		       	</table>
		 	</div>
		 	
		 	<div data-options="region:'center',border:false" style="padding:5px;">
		 		<form id="f_<?=$time?>" class="easyui-form" method="post" data-options="novalidate:false" time="<?=$time?>"> 
		 			<table id="table_f_<?=$time?>" style="width:800px;margin:0 auto;">
						<tr class="set_width"> 
	                    	<td style="width:15%"></td> 
                            <td style="width:35%"></td> 
	                        <td style="width:15%"></td> 
                            <td style="width:35%"></td> 
	                    </tr> 
	                    
	                    <tr class="tr_title" > 
	                    	<td colspan="4" style="height:35px;vertical-align:text-center;"  > 
	                    		<span>基本信息</span>
	                    	</td>
	                    </tr>
	                    <tr>
	                    	<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	所属机构
                            </td>
                            <td style="height:35px;vertical-align:text-center;"  colspan="3"> 
                            	<input name="content[c_org_s]" 
					    			   oaname="content[c_org_s]"
					    			   id="txtb_c_org_s<?=$time?>" 
					    			   class="easyui-textbox oa_input"
					    			   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'100%',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 fun_ready: 'load_c_org_s<?=$time?>()'
													 ">
								<input id="txtb_c_org<?=$time?>" 
									   name="content[c_org]"
									   oaname="content[c_org]"
									   class="oa_input"
									   type="hidden"/>			
									   			 
								<script type="text/javascript" >
								function load_c_org_s<?=$time?>()
								{
									var opt = $('#txtb_c_org_s<?=$time?>').textbox('options');

									if(  opt.readonly ) return;

									$('#txtb_c_org_s<?=$time?>').textbox({
						         	   	 onClickButton:function()
							         	 {
						         	   		$(this).textbox('clear');
						         	   	    $('#txtb_c_org<?=$time?>').val('')
							         	 }
									});
										
									$('#txtb_c_org_s<?=$time?>').textbox('textbox').autocomplete({
								        serviceUrl: 'proc_org/org/get_json',
								        params:{
											rows:10
										},
								        onSelect: function (suggestion) {
											$('#txtb_c_org_s<?=$time?>').textbox('setValue',base64_decode(suggestion.data.o_name));
											$('#txtb_c_org<?=$time?>').val(base64_decode(suggestion.data.o_id))
										}
									});
								}
								</script>					 
													 
                            </td>
	                    </tr>
	                    <tr>
	                    	<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	姓名
                            </td>
                            <td style="height:35px;vertical-align:text-center;"  > 
                            	<input name="content[c_name]" 
					    			   oaname="content[c_name]"
					    			   class="easyui-textbox oa_input"
					    			   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200px',
					    			   				 multiline:false,
													 validType:['length[0,80]','errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                            </td>
                            <td rowspan="4" colspan="2" class="oa_op" oaname="content[c_img]">
                            	<center>
					    		<a href="javascript:void(0)" 
					    		   title="单击此处上传图片" 
					    		   class="easyui-tooltip" >
					    		<div name="content[c_img]" 
					    			 oaname="content[c_img]"
					    			 class="upload_img oa_input "
					    			 onClick="fun_photoclip(this,307200)"
					    			 style="height:160px;width:112px;margin-top:10px;background:#E6EEF8;line-height:60px;font-size:14px;"
					    			>
					    		   <center>单击此处上传图片</center>
					    		</div>
					    		<input type="hidden" name="content[c_img_show]" />
					    		</a>
					    		</center>
                            </td>
                         </tr>
                         
                         <tr>
	                    	<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	性别
                            </td>
                            <td style="height:35px;vertical-align:text-center;"  > 
                            	<input name="content[c_sex]" 
					    			   oaname="content[c_sex]"
					    			   class="easyui-combobox oa_input"
					    			   data-options="err:err,
					    			   				 limitToList:true,
					    			   				 valueField:'id',    
						    						 textField:'text',
					    			   				 height:'25',
					    			   				 width:'200px',
					    			   				 multiline:false,
					    			   				 data: [<?=element('c_sex',$json_field_define)?>],
					    			   				 panelHeight:'auto',
					    			   				 panelMaxHeight:120,
					    			   				 panelWidth:'',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                            </td>
                         </tr>
                         
                         <tr>
	                    	<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	身份证
                            </td>
                            <td style="height:35px;vertical-align:text-center;"  > 
                            	<input name="content[c_code_person]" 
					    			   oaname="content[c_code_person]"
					    			   id="txtb_c_code_person<?=$time?>"
					    			   class="easyui-textbox oa_input"
					    			   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200px',
					    			   				 multiline:false,
													 validType:['person_code','errMsg[\'#hd_err_f_<?=$time?>\']'],
													 fun_ready: 'load_c_code_person<?=$time?>()'
													 ">
								<script type="text/javascript" >
								function load_c_code_person<?=$time?>()
								{
									$('#txtb_c_code_person<?=$time?>').textbox('textbox').bind('blur',
									function(){
										fun_c_birthday_readonly<?=$time?>()
									});

									fun_c_birthday_readonly<?=$time?>();
								}

								function fun_c_birthday_readonly<?=$time?>()
								{
									var code=$('#txtb_c_code_person<?=$time?>').textbox('getValue');
									
									if(code)
									{
										var birth=getBirthFromIdCard(code);
										if(birth)
										{
											$('#txtb_c_birthday<?=$time?>').datebox({
												readonly:true,
												hasDownArrow:false,
												buttonIcon:'icon-lock',
												onClickButton:function()
									         	{
									         	}
											});
											$('#txtb_c_birthday<?=$time?>').datebox('setValue',birth);
										}
										else
										{
											$('#txtb_c_birthday<?=$time?>').datebox({
												readonly:false,
												hasDownArrow:true,
												buttonIcon:'icon-clear',
								         	   	onClickButton:function()
									         	{
								         	   		$(this).datebox('clear');
									         	}
											});

											$('#txtb_c_birthday<?=$time?>').datebox('textbox').bind('focus',
											function(){
												$(this).parent().prev().datebox('showPanel');
											});
										}
									}
								}

								</script>
												 
                            </td>
                         </tr>
                         
                         <tr>
	                    	<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	生日
                            </td>
                            <td style="height:35px;vertical-align:text-center;"  > 
                            	<input name="content[c_birthday]" 
					    			   oaname="content[c_birthday]"
					    			   id="txtb_c_birthday<?=$time?>"
					    			   class="easyui-datebox oa_input"
					    			   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200px',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 onChange :function( newValue, oldValue)
													 {
													 	var c_age='';
													 	if(newValue)
													 	c_age=fun_get_date('Y')-newValue.split('-')[0]+'岁';
													 	
													 	$('#c_age<?=$time?>').html(c_age);
													 }
													 ">
								<span id="c_age<?=$time?>"
									  name="content[c_age]"
									  oaname="content[c_age]"
									  class="oa_input"></span>			
									  
                            </td>
                         </tr>
	                    
	                     <tr>
	                    	<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	关联账户
                            </td>
                            <td style="height:35px;vertical-align:text-center;"  > 
                            	<input name="content[c_login_id]" 
					    			   oaname="content[c_login_id]"
					    			   id="txtb_c_login_id<?=$time?>"
					    			   class="easyui-textbox oa_input"
					    			   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200px',
					    			   				 multiline:false,
													 validType:['length[0,40]','errMsg[\'#hd_err_f_<?=$time?>\']'],
													 fun_ready: 'load_c_login_id<?=$time?>()'
													 ">
								<input id="txtb_a_id<?=$time?>" 
									   name="content[a_id]"
									   oaname="content[a_id]"
									   class="oa_input"
									   type="hidden"/>					 
								<script type="text/javascript" >
								function load_c_login_id<?=$time?>()
								{
									var opt = $('#txtb_c_login_id<?=$time?>').textbox('options');

									if(  opt.readonly ) return;

									$('#txtb_c_login_id<?=$time?>').textbox({
										buttonIcon:'icon-clear',
						         	   	onClickButton:function()
							         	{
											$(this).textbox('clear');
											$('#txtb_a_id<?=$time?>').val('');
							         	},
										icons: [{
											iconCls:'icon-add',
											handler: function(e){
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
													maximizable:false,
													onClose: function()
													{
														$('#'+win_id).window('destroy');
														$('#'+win_id).remove();
													}
												})
												
												var url='proc_back/account/edit'
												$('#'+win_id).window('refresh',url+'/fun_open/win/fun_open_id/'+win_id);
											}
										},{
											iconCls:'icon-edit',
											handler: function(e){
												var win_id=fun_get_new_win();

												var a_id=$('#txtb_a_id<?=$time?>').val();
												if( ! a_id ) return;
												
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
													maximizable:false,
													onClose: function()
													{
														$('#'+win_id).window('destroy');
														$('#'+win_id).remove();
													}
												})
												
												var url='proc_back/account/edit/act/2/a_id/'+a_id;
												$('#'+win_id).window('refresh',url+'/fun_open/win/fun_open_id/'+win_id);
											}
										}]
									});
										
									$('#txtb_c_login_id<?=$time?>').textbox('textbox').autocomplete({
								        serviceUrl: 'base/auto/get_json_account',
								        width:'200',
								        params:{
											rows:10
										},
								        onSelect: function (suggestion) {
											$('#txtb_c_login_id<?=$time?>').textbox('setValue',base64_decode(suggestion.data.a_login_id));
											$('#txtb_a_id<?=$time?>').val(base64_decode(suggestion.data.a_id))
										}
									});
								}
								</script>		
												 
                            </td>
                         </tr>
                         
                         <tr class="tr_title" > 
	                    	<td colspan="4" style="height:35px;vertical-align:text-center;"  > 
	                    		<span>联系信息</span>
	                    	</td>
	                    </tr>
	                    
	                    <tr>
	                    	<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	手机
                            </td>
                            <td style="height:35px;vertical-align:text-center;"  > 
                            	<input name="content[c_tel]" 
					    			   oaname="content[c_tel]"
					    			   id="txtb_c_tel<?=$time?>"
					    			   class="easyui-numberbox oa_input"
					    			   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200px',
					    			   				 multiline:false,
													 validType:['length[0,20]','errMsg[\'#hd_err_f_<?=$time?>\']'],
													 fun_ready: 'load_c_tel<?=$time?>()'
													 ">
								<span name="content[c_tel_info]"
								      oaname="content[c_tel_info]"
								      id="span_c_tel_info<?=$time?>"
								      class="oa_input"
								      ></span>					
								<script type="text/javascript" >					 
								function load_c_tel<?=$time?>()
								{
									$('#txtb_c_tel<?=$time?>').textbox('textbox').bind('blur',
									function(){
										var tel=$(this).val();

										var info=fun_get_code_info('base/fun/get_info_of_tele_info',tel);

										$('#span_c_tel_info<?=$time?>').html(info);
										
									});
								}
								</script>						 
                            </td>
                            <td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	固定电话
                            </td>
                            <td style="height:35px;vertical-align:text-center;"  > 
                            	<input name="content[c_phone]" 
					    			   oaname="content[c_phone]"
					    			   class="easyui-textbox oa_input"
					    			   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200px',
					    			   				 multiline:false,
													 validType:['length[0,40]','errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                            </td>
                         </tr>
                         
                         <tr>
                         	<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	邮编
                            </td>
                            <td style="height:35px;vertical-align:text-center;"  > 
                            	<input name="content[c_post_code]" 
					    			   oaname="content[c_post_code]"
					    			   class="easyui-textbox oa_input"
					    			   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200px',
					    			   				 multiline:false,
													 validType:['length[0,40]','errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                            </td>
                         	<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	Email
                            </td>
                            <td style="height:35px;vertical-align:text-center;"  > 
                            	<input name="content[c_email]" 
					    			   oaname="content[c_email]"
					    			   class="easyui-textbox oa_input"
					    			   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200px',
					    			   				 multiline:false,
													 validType:['length[0,200]','email','errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                            </td>
                         </tr>
                         
                         <tr>
                            <td colspan="4" style="height:35px;vertical-align:text-center;"  > 
                            	<span class="field_s">通讯地址</span>
                            	<input name="content[c_addr]" 
					    			   oaname="content[c_addr]"
					    			   class="easyui-textbox oa_input"
					    			   data-options="err:err,
					    			   				 height:'50',
					    			   				 width:'100%',
					    			   				 multiline:true,
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                            </td>
                         </tr>
                         
                         <tr class="tr_title" > 
	                    	<td colspan="4" style="height:35px;vertical-align:text-center;"  > 
	                    		<span>备注信息</span>
	                    	</td>
	                    </tr>
	                    
	                    <tr>
                            <td colspan="4" style="height:35px;vertical-align:text-center;padding-top:10px;"  > 
                            	<input name="content[c_note]" 
					    			   oaname="content[c_note]"
					    			   class="easyui-textbox oa_input"
					    			   data-options="err:err,
					    			   				 height:'50',
					    			   				 width:'100%',
					    			   				 multiline:true,
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                            </td>
                         </tr>
	                    
	                 </table> 
	                 
	                 <input name="content[c_id]" oaname="content[c_id]" class="oa_input" type="hidden" />
	                 
	                 <!-- 数据校验时间 -->
					 <input class="db_time_update" name="content[db_time_update]" type="hidden" />
							
		 		</form>
		 		
		 		 <!-- 验证错误 -->
         		 <input id="hd_err_f_<?=$time?>" type="hidden" /> 
         		 
		 	</div>
		 	
		</div>
         
    </div>
    <div title="操作日志" 
    	 oaname="tab_log"
       	 data-options="iconCls:'icon-log',
       				  href:'base/main/load_win_log_operate',
       				  queryParams:{
       				  	parent_id: 'tab_edit_<?=$time?>',
						op_id: '<?=$c_id?>',
						table: 'sys_contact',
						field: 'c_id',
						time: 'log_<?=$time?>'
       				 }"
       	>
       	
    </div>
    
</div>

<!-- loading -->
<div id="win_loading<?=$time?>" style="padding:5px;overflow:hidden;"></div> 