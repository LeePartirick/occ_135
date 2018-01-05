					<table id="table_hr_work<?=$time?>" style="width:1000px;margin:0 auto;">
						<tr class="set_width"> 
	                    	<td style="width:100px"></td> 
                            <td style="width:233px"></td> 
	                        <td style="width:100px"></td> 
                            <td style="width:233px"></td> 
                            <td style="width:100px"></td> 
                            <td style="width:234px"></td> 
	                    </tr> 
	                    
	                    <tr class="tr_title" > 
	                    	<td colspan="6" style="height:35px;vertical-align:text-center;"  > 
	                    		<span>工作信息(人事填写)</span>
	                    	</td>
	                    </tr>
	                   <tr>
	                   		<td class="field_s oa_op" oaname="content[hr_code]" style="height:35px;vertical-align:text-center;"  > 
                               	工号
                            </td>
                            <td class="oa_op" oaname="content[hr_code]" style="height:35px;vertical-align:text-center;" > 
					    		
					    		<input name="content[hr_code_pre]" 
					    			   oaname="content[hr_code_pre]"
					    			   class="easyui-textbox oa_input"
					    			   id = "txtb_hr_code_pre<?=$time?>"
					    			   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'100',
													 validType:['length[0,40]','errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
													 
					    		<input name="content[hr_code]" 
					    			   oaname="content[hr_code]"
					    			   class="easyui-textbox oa_input"
					    			   id = "txtb_hr_code<?=$time?>"
					    			   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'100',
													 validType:['length[0,40]','errMsg[\'#hd_err_f_<?=$time?>\']'],
													 fun_ready: 'load_hr_code<?=$time?>()',
													 ">
                             </td>
	                    	<td class="field_s oa_op" oaname="content[c_login_id]" style="height:35px;vertical-align:text-center;"  > 
                               	关联账户
                            </td>
                            <td class="oa_op" oaname="content[c_login_id]" style="height:35px;vertical-align:text-center;" > 
                             	<span name="content[c_login_id]" 
					    			  oaname="content[c_login_id]"
					    			  class="oa_input"
					    			>
					    		</span>
                             </td>
                            <td class="field_s oa_op" oaname="content[c_tel_code]" style="height:35px;vertical-align:text-center;"  > 
                              	短号
                            </td>
                            <td class="oa_op" oaname="content[c_tel_code]" style="height:35px;vertical-align:text-center;" > 
                             	<span name="content[c_tel_code]" 
					    			  oaname="content[c_tel_code]"
					    			  class="oa_input"
					    			>
					    		</span>
                            </td>
                       </tr>     
                       <tr>
                       		<td class="field_s oa_op" oaname="content[c_email_sys]" style="height:35px;vertical-align:text-center;"  > 
                               	系统邮箱
                            </td>
                            <td class="oa_op" oaname="content[c_email_sys]" style="height:35px;vertical-align:text-center;" > 
                             	<span name="content[c_email_sys]" 
					    			  oaname="content[c_email_sys]"
					    			  class="oa_input"
					    			>
					    		</span>
                             </td>
                             <td class="field_s oa_op" oaname="content[c_pwd_web]" style="height:35px;vertical-align:text-center;"  > 
                               	网络证书
                            </td>
                            <td class="oa_op" oaname="content[c_pwd_web]" style="height:35px;vertical-align:text-center;" > 
                             	<span name="content[c_pwd_web]" 
					    			  oaname="content[c_pwd_web]"
					    			  class="oa_input"
					    			>
					    		</span>
                             </td>
                       </tr>
	                   <tr>
	                    	<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	所属机构
                            </td>
                             <td style="height:35px;vertical-align:text-center;"  colspan="3"> 
                             	<input name="content[c_org]" 
					    			   oaname="content[c_org]"
					    			   id="txtb_c_org<?=$time?>"
					    			   class="easyui-combobox oa_input"
					    			   data-options="err:err,
					    			   				 limitToList:true,
					    			   				 valueField:'id',    
						    						 textField:'text',
					    			   				 height:'25',
					    			   				 width:'400',
					    			   				 multiline:false,
					    			   				 panelHeight:'auto',
					    			   				 panelMaxHeight:120,
					    			   				 url_l:'base/auto/get_json_hr_org/from/combobox/field_id/ou_id/field_text/ou_name',
					    			   				 panelWidth:'',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 onChange: function(newValue, oldValue)
													 {
													 	if(newValue != oldValue )
													 	{
													 		
													 		load_c_ou_2_s<?=$time?>();
													 		load_c_ou_3_s<?=$time?>();
													 		load_c_ou_4_s<?=$time?>();
													 		
													 		if(oldValue)
													 		{
														 		$('#txtb_c_ou_2_s<?=$time?>').textbox('clear');
														 		$('#txtb_c_ou_2<?=$time?>').val('');
														 		$('#txtb_c_ou_3_s<?=$time?>').textbox('clear');
														 		$('#txtb_c_ou_3<?=$time?>').val('');
														 		$('#txtb_c_ou_4_s<?=$time?>').textbox('clear');
														 		$('#txtb_c_ou_4<?=$time?>').val('');
													 		}
													 	}
													 }
													 ">
                             </td>
                            <td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	是否推荐
                            </td>
                            <td style="height:35px;vertical-align:text-center;"  > 
                            	<input name="content[hr_offer]" 
					    			   oaname="content[hr_offer]"
					    			   class="easyui-combobox oa_input"
					    			   data-options="err:err,
					    			   				 limitToList:true,
					    			   				 valueField:'id',    
						    						 textField:'text',
					    			   				 height:'25',
					    			   				 width:'200px',
					    			   				 multiline:false,
					    			   				 data: [<?=element('base_yn',$json_field_define)?>],
					    			   				 panelHeight:'auto',
					    			   				 panelMaxHeight:120,
					    			   				 panelWidth:'',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                            </td>
                        </tr>
                        
                        <tr>
	                    	<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	法人
                            </td>
                             <td style="height:35px;vertical-align:text-center;"  colspan="3"> 
                             	<input name="content[c_hr_org]" 
					    			   oaname="content[c_hr_org]"
					    			   class="easyui-combobox oa_input"
					    			   data-options="err:err,
					    			   				 limitToList:true,
					    			   				 valueField:'id',    
						    						 textField:'text',
					    			   				 height:'25',
					    			   				 width:'400',
					    			   				 multiline:false,
					    			   				 panelHeight:'auto',
					    			   				 panelMaxHeight:120,
					    			   				 url_l:'base/auto/get_json_hr_org/from/combobox/field_id/ou_id/field_text/ou_name',
					    			   				 panelWidth:'',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                             </td>
                             <td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	工作地点
                            </td>
                            <td style="height:35px;vertical-align:text-center;" > 
                            	<input name="content[hr_work_place]" 
					    			   oaname="content[hr_work_place]"
					    			   class="easyui-textbox oa_input"
					    			   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
													 validType:['length[0,100]','errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                            </td>
                        </tr>
	                 	<tr>
	                 		<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	股权激励
                            </td>
                            <td style="height:35px;vertical-align:text-center;"  > 
                            	<input name="content[hr_gqjl]" 
					    			   oaname="content[hr_gqjl]"
					    			   class="easyui-combobox oa_input"
					    			   data-options="err:err,
					    			   				 limitToList:true,
					    			   				 valueField:'id',    
						    						 textField:'text',
					    			   				 height:'25',
					    			   				 width:'200px',
					    			   				 multiline:false,
					    			   				 data: [<?=element('base_yn',$json_field_define)?>],
					    			   				 panelHeight:'auto',
					    			   				 panelMaxHeight:120,
					    			   				 panelWidth:'',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                            </td>
                            <td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	社会保险
                            </td>
                            <td style="height:35px;vertical-align:text-center;"  > 
                            	<input name="content[hr_shbx]" 
					    			   oaname="content[hr_shbx]"
					    			   class="easyui-combobox oa_input"
					    			   data-options="err:err,
					    			   				 limitToList:true,
					    			   				 valueField:'id',    
						    						 textField:'text',
					    			   				 height:'25',
					    			   				 width:'200px',
					    			   				 multiline:false,
					    			   				 data: [<?=element('hr_shbx',$json_field_define)?>],
					    			   				 panelHeight:'auto',
					    			   				 panelMaxHeight:120,
					    			   				 panelWidth:'',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                            </td>
                            <td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	带薪年假
                            </td>
                            <td style="height:35px;vertical-align:text-center;"  > 
                            	<input name="content[hr_vacation]" 
					    			   oaname="content[hr_vacation]"
					    			   class="easyui-numberbox oa_input"
					    			   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
					    			   				 precision:2,
					    			   				 suffix:'天',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                            </td>
                        </tr>
                        <tr>
	                    	<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	二级部门
                            </td>
                            <td style="height:35px;vertical-align:text-center;" > 
                            	<input name="content[c_ou_2_s]" 
					    			   oaname="content[c_ou_2_s]"
					    			   id="txtb_c_ou_2_s<?=$time?>"
					    			   class="easyui-textbox oa_input"
					    			   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 fun_ready: 'load_c_ou_2_s<?=$time?>()',
													 ">
								<input id="txtb_c_ou_2<?=$time?>" 
									   name="content[c_ou_2]"
									   oaname="content[c_ou_2]"
									   class="oa_input"
									   type="hidden"/>						 
                            </td>
                            <td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	三级部门
                            </td>
                            <td style="height:35px;vertical-align:text-center;" > 
                            	<input name="content[c_ou_3_s]" 
					    			   oaname="content[c_ou_3_s]"
					    			   id="txtb_c_ou_3_s<?=$time?>"
					    			   class="easyui-textbox oa_input"
					    			   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 fun_ready: 'load_c_ou_3_s<?=$time?>()',
													 ">
								<input id="txtb_c_ou_3<?=$time?>" 
									   name="content[c_ou_3]"
									   oaname="content[c_ou_3]"
									   class="oa_input"
									   type="hidden"/>
                            </td>
                            <td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	四级部门
                            </td>
                            <td style="height:35px;vertical-align:text-center;" > 
                            	<input name="content[c_ou_4_s]" 
					    			   oaname="content[c_ou_4_s]"
					    			   id="txtb_c_ou_4_s<?=$time?>"
					    			   class="easyui-textbox oa_input"
					    			   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 fun_ready: 'load_c_ou_4_s<?=$time?>()',
													 ">
								<input id="txtb_c_ou_4<?=$time?>" 
									   name="content[c_ou_4]"
									   oaname="content[c_ou_4]"
									   class="oa_input"
									   type="hidden"/>
                            </td>
	                 	</tr>  
	                 	<tr>
	                 		<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	职位
                            </td>
                            <td style="height:35px;vertical-align:text-center;" > 
                            	<input name="content[c_job_s]" 
					    			   oaname="content[c_job_s]"
					    			   id="txtb_c_job_s<?=$time?>"
					    			   class="easyui-textbox oa_input"
					    			   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 fun_ready: 'load_c_job_s<?=$time?>()',
													 ">
								<input id="txtb_c_job<?=$time?>" 
									   name="content[c_job]"
									   oaname="content[c_job]"
									   class="oa_input"
									   type="hidden"/>		
                            </td>
                            <td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	职称类别
                            </td>
                            <td style="height:35px;vertical-align:text-center;"  > 
                            	<input name="content[hr_zclb]" 
					    			   oaname="content[hr_zclb]"
					    			   class="easyui-combobox oa_input"
					    			   data-options="err:err,
					    			   				 limitToList:true,
					    			   				 valueField:'id',    
						    						 textField:'text',
					    			   				 height:'25',
					    			   				 width:'200px',
					    			   				 multiline:false,
					    			   				 data: [<?=element('hr_zclb',$json_field_define)?>],
					    			   				 panelHeight:'auto',
					    			   				 panelMaxHeight:120,
					    			   				 panelWidth:'',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                            </td>
                            <td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	职称等级
                            </td>
                            <td style="height:35px;vertical-align:text-center;"  > 
                            	<input name="content[hr_zcdj]" 
					    			   oaname="content[hr_zcdj]"
					    			   class="easyui-combobox oa_input"
					    			   data-options="err:err,
					    			   				 limitToList:true,
					    			   				 valueField:'id',    
						    						 textField:'text',
					    			   				 height:'25',
					    			   				 width:'200px',
					    			   				 multiline:false,
					    			   				 data: [<?=element('hr_zcdj',$json_field_define)?>],
					    			   				 panelHeight:'auto',
					    			   				 panelMaxHeight:120,
					    			   				 panelWidth:'',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                            </td>
	                 	</tr> 
	                 	
	                 	<tr>
	                 		<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	职务大类
                            </td>
                            <td style="height:35px;vertical-align:text-center;"  > 
                            	<input name="content[hr_zw_1]" 
					    			   oaname="content[hr_zw_1]"
					    			   class="easyui-combobox oa_input"
					    			   data-options="err:err,
					    			   				 limitToList:true,
					    			   				 valueField:'id',    
						    						 textField:'text',
					    			   				 height:'25',
					    			   				 width:'200px',
					    			   				 multiline:false,
					    			   				 data: [<?=element('hr_zw_1',$json_field_define)?>],
					    			   				 panelHeight:'auto',
					    			   				 panelMaxHeight:120,
					    			   				 panelWidth:'',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 onChange: function(newValue,oldValue){
													 	
													 	var data = [<?=element('hr_zw_2',$json_field_define)?>]
													 	
													 	var arr=[];
													 	switch(newValue)
													 	{
													 		case '<?=HR_ZW_1_GL?>':
													 		arr = '1,2,3,4'.split(',');
													 		
													 		break;
													 		case '<?=HR_ZW_1_JS?>':
											 				arr= '5,6,7,8,9,10,11,12,13,14'.split(',');
													 		
													 		break;
													 		case '<?=HR_ZW_1_XS?>':
											 				arr = '15,16,17'.split(',');
													 		
													 		break;
													 	}
													 	
													 	var data_new = [];
													 	var value = $('#txtb_hr_zw_2<?=$time?>').combobox('getValue');
    													var check = false;
													 	for(var i=0;i < data.length;i++)
					    								{
					    									if(arr.indexOf(data[i].id) > -1)
					    									{
						    									data_new.push(data[i])
						    									
						    									if(data[i].id == value)
						    									check=true;
					    									}
					    								}
					    								$('#txtb_hr_zw_2<?=$time?>').combobox('loadData',data_new);
					    								
					    								if( ! check )
					    								{
					    									$('#txtb_hr_zw_2<?=$time?>').combobox('clear');
					    									$('#txtb_hr_zw_3<?=$time?>').combobox('clear');
					    								}
													 }
													 ">
                            </td>
                            <td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	职务中类
                            </td>
                            <td style="height:35px;vertical-align:text-center;"  > 
                            	<input name="content[hr_zw_2]" 
					    			   oaname="content[hr_zw_2]"
					    			   id="txtb_hr_zw_2<?=$time?>"
					    			   class="easyui-combobox oa_input"
					    			   data-options="err:err,
					    			   				 limitToList:true,
					    			   				 valueField:'id',    
						    						 textField:'text',
					    			   				 height:'25',
					    			   				 width:'200px',
					    			   				 multiline:false,
					    			   				 data: [<?=element('hr_zw_2',$json_field_define)?>],
					    			   				 panelHeight:'auto',
					    			   				 panelMaxHeight:120,
					    			   				 panelWidth:'',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 onChange: function(newValue,oldValue){
													 	
													 	var data = [<?=element('hr_zw_3',$json_field_define)?>]
													 	var arr=[];
													 	switch(newValue)
													 	{
													 		case '<?=HR_ZW_2_GL_GJ?>':
									 						arr= '1,2'.split(',');
													 		
													 		break;
													 		case '<?=HR_ZW_2_GL_ZJ?>':
													 		arr = '3,4,5'.split(',');
													 		
													 		break;
													 		case '<?=HR_ZW_2_GL_YB?>':
													 		arr = '6,7'.split(',');
													 		
													 		break;
													 		case '<?=HR_ZW_2_GL_CJ?>':
													 		arr = '8,9'.split(',');
													 		
													 		break;
													 		case '<?=HR_ZW_2_JS_SXGCS?>':
													 		case '<?=HR_ZW_2_JS_ZSGCS?>':
													 		case '<?=HR_ZW_2_JS_GJGCS?>':
													 		case '<?=HR_ZW_2_JS_GCS?>':
													 		case '<?=HR_ZW_2_JS_ZLGCS?>':
													 		case '<?=HR_ZW_2_JS_SXXM?>':
													 		case '<?=HR_ZW_2_JS_ZSXM?>':
													 		case '<?=HR_ZW_2_JS_GJXM?>':
													 		case '<?=HR_ZW_2_JS_XM?>':
													 		case '<?=HR_ZW_2_JS_XMZG?>':
													 		arr = '10,11,12,13,14'.split(',');
													 		
													 		break;
													 		case '<?=HR_ZW_2_XS_GJ?>':
													 		arr = '15'.split(',');
													 		
													 		break;
													 		case '<?=HR_ZW_2_XS_JL?>':
													 		arr = '16'.split(',');
													 		
													 		break;
													 		case '<?=HR_ZW_2_XS_XS?>':
													 		arr = '17'.split(',');
													 		
													 		break;
													 	}
													 	
													 	var data_new = [];
													 	var value = $('#txtb_hr_zw_3<?=$time?>').combobox('getValue');
    													var check = false;
													 	for(var i=0;i < data.length;i++)
					    								{
					    									if(arr.indexOf(data[i].id) > -1)
					    									{
						    									data_new.push(data[i])
						    									
						    									if(data[i].id == value)
						    									check=true;
					    									}
					    								}
					    								
					    								$('#txtb_hr_zw_3<?=$time?>').combobox('loadData',data_new);
					    								
					    								if( ! check )
					    								{
					    									$('#txtb_hr_zw_3<?=$time?>').combobox('clear');
					    								}
													 }
													 ">
                            </td>
                            <td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	职务小类
                            </td>
                            <td style="height:35px;vertical-align:text-center;"  > 
                            	<input name="content[hr_zw_3]" 
					    			   oaname="content[hr_zw_3]"
					    			   id="txtb_hr_zw_3<?=$time?>"
					    			   class="easyui-combobox oa_input"
					    			   data-options="err:err,
					    			   				 limitToList:true,
					    			   				 valueField:'id',    
						    						 textField:'text',
					    			   				 height:'25',
					    			   				 width:'200px',
					    			   				 multiline:false,
					    			   				 data: [<?=element('hr_zw_3',$json_field_define)?>],
					    			   				 panelHeight:'auto',
					    			   				 panelMaxHeight:120,
					    			   				 panelWidth:'',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                            </td>
	                 	</tr> 
	                 	
	                 	<tr>
	                 		<td class="field_s oa_op" oaname="content[hr_tec]" style="height:35px;text-align: left">
								技术方向
							</td>
							<td class="oa_op" oaname="content[hr_tec]" colspan="5">
								<input name="content[hr_tec]"
									   oaname="content[hr_tec]"
									   id="txtb_hr_tec<?=$time?>"
									   class="easyui-tagbox oa_input"
									   data-options="err:err,
					    			   				 valueField:'id',
						    						 textField:'text',
						    						 limitToList:true,
						    						 missingMessage:'该输入项为必填项',
					    			   				 height:'25',
					    			   				 width:'900',
					    			   				 panelHeight:'auto',
					    			   				 panelMaxHeight:120,
					    			   				 url_l:'proc_hr/hr_tec/get_json/from/combobox/field_id/tec_id/field_text/tec_name',
					    			   				 panelWidth:'300',
					    			   				 hasDownArrow:true,
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 fun_ready:'load_hr_tec<?=$time?>()'
													 ">
							</td>
	                 	</tr>
	                 	
	                 	<tr>
	                 		<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	用工形式
                            </td>
                            <td style="height:35px;vertical-align:text-center;"  > 
                            	<input name="content[hr_type_work]" 
					    			   oaname="content[hr_type_work]"
					    			   class="easyui-combobox oa_input"
					    			   data-options="err:err,
					    			   				 limitToList:true,
					    			   				 valueField:'id',    
						    						 textField:'text',
					    			   				 height:'25',
					    			   				 width:'200px',
					    			   				 multiline:false,
					    			   				 data: [<?=element('hr_type_work',$json_field_define)?>],
					    			   				 panelHeight:'auto',
					    			   				 panelMaxHeight:120,
					    			   				 panelWidth:'',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                            </td>
                            <td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	人员类别
                            </td>
                            <td style="height:35px;vertical-align:text-center;"  > 
                            	<input name="content[hr_type]" 
					    			   oaname="content[hr_type]"
					    			   class="easyui-combobox oa_input"
					    			   data-options="err:err,
					    			   				 limitToList:true,
					    			   				 valueField:'id',    
						    						 textField:'text',
					    			   				 height:'25',
					    			   				 width:'200px',
					    			   				 multiline:false,
					    			   				 data: [<?=element('hr_type',$json_field_define)?>],
					    			   				 panelHeight:'auto',
					    			   				 panelMaxHeight:120,
					    			   				 panelWidth:'',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                            </td>
                            <td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	累计工龄
                            </td>
                            <td style="height:35px;vertical-align:text-center;"  > 
                            	<input name="content[hr_wage]" 
					    			   oaname="content[hr_wage]"
					    			   class="easyui-numberbox oa_input"
					    			   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
					    			   				 precision:2,
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                            </td>
	                 	</tr>
	                 	<tr>
	                    	<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	入职时间
                            </td>
                            <td style="height:35px;vertical-align:text-center;" > 
                            	<input name="content[hr_time_rz]" 
					    			   oaname="content[hr_time_rz]"
					    			   class="easyui-datebox oa_input"
					    			   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 onSelect: function(date){
													 	var ndate = fun_get_date('Y-m-d');
													 	var arr = ndate.split('-');
													 	var wage = arr[0] - date.getFullYear();
													 	
													 	if( (date.getMonth()+1) == arr[1] && date.getDate() > arr[2])
													 	{
													 		wage--;
													 	}
													 	else if((date.getMonth()+1) > arr[1])
													 	{
													 		wage--;
													 	}
													 	
													 	if( wage < 0 ) wage = 0;
													 	
													 	$('#txtb_hr_wage_org<?=$time?>').val(wage);
													 	
													 	var wage_set = $('#txtb_hr_wage_set<?=$time?>').numberbox('getValue');
													 	
													 	wage = parseInt(wage)+parseInt(wage_set);
													 	$('#txtb_hr_wage_org_s<?=$time?>').numberbox('setValue',wage);
													 }
													 ">
                            </td>
                            <td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	转正时间
                            </td>
                            <td style="height:35px;vertical-align:text-center;" > 
                            	<input name="content[hr_time_zz]" 
					    			   oaname="content[hr_time_zz]"
					    			   class="easyui-datebox oa_input"
					    			   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                            </td>
                            <td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	本单位工龄
                            </td>
                            <td style="height:35px;vertical-align:text-center;"  > 
                            
					    		<input name="content[hr_wage_org_s]" 
					    			   oaname="content[hr_wage_org_s]"
					    			   id="txtb_hr_wage_org_s<?=$time?>"
					    			   class="easyui-numberbox oa_input"
					    			   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'90',
					    			   				 precision:0,
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
								<input id="txtb_hr_wage_org<?=$time?>" 
									   name="content[hr_wage_org]" 
					    			   oaname="content[hr_wage_org]"
					    			   class="oa_input"
								  	   type="hidden"/>			
										 
								<input name="content[hr_wage_set]" 
					    			   oaname="content[hr_wage_set]"
					    			   id="txtb_hr_wage_set<?=$time?>" 
					    			   class="easyui-numberbox oa_input"
					    			   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'90',
					    			   				 precision:0,
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 formatter: function(value)
													 {
													 	if(value > 0 )
													 	value='+'+value;
													 	
													 	return value;
													 },
													 onChange: function(newValue,oldValue)
													 {
													 	var wage = $('#txtb_hr_wage_org<?=$time?>').val();
													 	wage = parseInt(wage)+parseInt(newValue);
													 	 $('#txtb_hr_wage_org_s<?=$time?>').numberbox('setValue',wage);
													 }
													 ">					 
                            </td>
	                 	 </tr>
	                 	 <tr>
	                    	<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	合同签订
                            </td>
                            <td style="height:35px;vertical-align:text-center;" > 
                            	<span name="content[hr_time_ht]" 
					    			  oaname="content[hr_time_ht]"
					    			  class="oa_input"
					    			>
					    		</span>
                            </td>
                            <td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	合同到期
                            </td>
                            <td style="height:35px;vertical-align:text-center;" > 
                            	<span name="content[hr_time_htdq]" 
					    			  oaname="content[hr_time_htdq]"
					    			  class="oa_input"
					    			>
					    		</span>
                            </td>
                          	<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	离职时间
                            </td>
                            <td style="height:35px;vertical-align:text-center;" > 
                            	<input name="content[hr_time_lz]" 
					    			   oaname="content[hr_time_lz]"
					    			   class="easyui-datebox oa_input"
					    			   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                            </td>
	                 	 </tr>
	                 	 <tr>
	                 	    <td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	合同年限
                            </td>
                            <td style="height:35px;vertical-align:text-center;"  > 
                            	<span name="content[hr_ht_year]" 
					    			  oaname="content[hr_ht_year]"
					    			  class="oa_input"
					    			>
					    		</span>
                            </td>
                            <td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	续签次数
                            </td>
                            <td style="height:35px;vertical-align:text-center;"  > 
                            	<span name="content[hr_num_xq]" 
					    			  oaname="content[hr_num_xq]"
					    			  class="oa_input"
					    			>
					    		</span>
                            </td>
	                 	 </tr>
	                 	 
	                 	 <tr class="tr_title oa_op" oaname="title_hr_contract">
	                    	<td colspan="5" style="height:35px;vertical-align:text-center;"  >
	                    		<span>合同信息</span>
	                    	</td>
                             <td colspan="1" style="height:35px;text-align:right"  >

                                 <a href="javascript:void(0);"
                                    class="sui-btn btn-bordered btn-small btn-primary"
                                    onClick="fun_tr_title_show($('#table_f_<?=$time?>'),'title_hr_contract','','collapse');$(this).hide();$(this).next().show();"
                                 >
                                     <i class="sui-icon icon-tb-fold"></i>
                                 </a>

                                 <a href="javascript:void(0);"
                                    class="sui-btn btn-bordered btn-small btn-primary"
                                    onClick="fun_tr_title_show($('#table_f_<?=$time?>'),'title_hr_contract','show','collapse');$(this).hide();$(this).prev().show();"
                                    style="display:none;"
                                 >
                                     <i class="sui-icon icon-tb-unfold"></i>
                                 </a>

                             </td>
	                    </tr>
                        <tr>
                            <td colspan="6" style="height:35px;vertical-align:text-center;padding-top:10px;"  >
                                <div id="table_hr_contract_tool<?=$time?>">
                                    <table style="width:100%;">
                                        <tr>
                                            <td style="width:'50%';" >
                                                <a href="javascript:void(0)" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-add',plain:true" onClick="fun_table_hr_contract_operate<?=$time?>('add')">添加</a>
                                                <a href="javascript:void(0)" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-remove',plain:true" onClick="fun_table_hr_contract_operate<?=$time?>('del')">删除</a>
                                            </td>

                                        </tr>
                                    </table>
                                </div>
                                <table id="table_hr_contract<?=$time?>"
                                       name="content[hr_contract]"
                                       oaname="content[hr_contract]"
                                       class="oa_input data_table"
                                >
                                </table>

                            </td>
                        </tr>

	                    
	                    <tr oaname="title_hr_train_org" class="tr_title oa_op"> 
	                    	<td colspan="5" style="height:35px;vertical-align:text-center;"  > 
	                    		<span>公司培训记录</span>
	                    	</td>
	                    	<td colspan="1" style="height:35px;text-align:right"  >
	                    		
	                    		<a href="javascript:void(0);" 
	                    		   class="sui-btn btn-bordered btn-small btn-primary" 
	                    		   onClick="fun_tr_title_show($('#table_f_<?=$time?>'),'title_hr_train_org','','collapse');$(this).hide();$(this).next().show();"
	                    		   >
	                    		   <i class="sui-icon icon-tb-fold"></i>
	                    		</a>
	                    		
	                    		<a href="javascript:void(0);" 
	                    		   class="sui-btn btn-bordered btn-small btn-primary" 
	                    		   onClick="fun_tr_title_show($('#table_f_<?=$time?>'),'title_hr_train_org','show','collapse');$(this).hide();$(this).prev().show();"
	                    		   style="display:none;"
	                    		   >
	                    		   <i class="sui-icon icon-tb-unfold"></i>
	                    		</a>
	                    		
	                    	</td>
	                    </tr>
	                    
	                    <tr>
	                    	<td colspan="6" style="height:35px;vertical-align:text-center;padding-top:10px;"  > 
	                    		<div id="table_hr_train_org_tool<?=$time?>">
									<table style="width:100%;">
										<tr>
											<td style="width:'50%';" >
												<a href="javascript:void(0)" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-add',plain:true" onClick="fun_table_hr_train_org_operate<?=$time?>('add')">添加</a>
												<a href="javascript:void(0)" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-remove',plain:true" onClick="fun_table_hr_train_org_operate<?=$time?>('del')">删除</a>
											</td>

										</tr>
									</table>
								</div>
								<table id="table_hr_train_org<?=$time?>"
									   name="content[hr_train_org]"
									   oaname="content[hr_train_org]"
									   class="oa_input data_table"
								>
								</table>
										
	                    	</td>
	                    </tr>
	                    
	                    <tr oaname="title_hr_reward" class="tr_title oa_op"> 
	                    	<td colspan="5" style="height:35px;vertical-align:text-center;"  > 
	                    		<span>公司奖惩记录</span>
	                    	</td>
	                    	<td colspan="1" style="height:35px;text-align:right"  >
	                    		
	                    		<a href="javascript:void(0);" 
	                    		   class="sui-btn btn-bordered btn-small btn-primary" 
	                    		   onClick="fun_tr_title_show($('#table_f_<?=$time?>'),'title_hr_reward','','collapse');$(this).hide();$(this).next().show();"
	                    		   >
	                    		   <i class="sui-icon icon-tb-fold"></i>
	                    		</a>
	                    		
	                    		<a href="javascript:void(0);" 
	                    		   class="sui-btn btn-bordered btn-small btn-primary" 
	                    		   onClick="fun_tr_title_show($('#table_f_<?=$time?>'),'title_hr_reward','show','collapse');$(this).hide();$(this).prev().show();"
	                    		   style="display:none;"
	                    		   >
	                    		   <i class="sui-icon icon-tb-unfold"></i>
	                    		</a>
	                    		
	                    	</td>
	                    </tr>
	                    
	                    <tr>
	                    	<td colspan="6" style="height:35px;vertical-align:text-center;padding-top:10px;"  > 
	                    		<div id="table_hr_reward_tool<?=$time?>">
									<table style="width:100%;">
										<tr>
											<td style="width:'50%';" >
												<a href="javascript:void(0)" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-add',plain:true" onClick="fun_table_hr_reward_operate<?=$time?>('add')">添加</a>
												<a href="javascript:void(0)" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-remove',plain:true" onClick="fun_table_hr_reward_operate<?=$time?>('del')">删除</a>
											</td>

										</tr>
									</table>
								</div>
								<table id="table_hr_reward<?=$time?>"
									   name="content[hr_reward]"
									   oaname="content[hr_reward]"
									   class="oa_input data_table"
								>
								</table>
										
	                    	</td>
	                    </tr>

						<tr oaname="title_office" class="tr_title oa_op"> 
	                    	<td colspan="5" style="height:35px;vertical-align:text-center;"  > 
	                    		<span>信息系统</span>
	                    	</td>
	                    	<td colspan="1" style="height:35px;text-align:right"  >
	                    		
	                    		<a href="javascript:void(0);" 
	                    		   class="sui-btn btn-bordered btn-small btn-primary" 
	                    		   onClick="fun_tr_title_show($('#table_f_<?=$time?>'),'title_office','','collapse');$(this).hide();$(this).next().show();"
	                    		   >
	                    		   <i class="sui-icon icon-tb-fold"></i>
	                    		</a>
	                    		
	                    		<a href="javascript:void(0);" 
	                    		   class="sui-btn btn-bordered btn-small btn-primary" 
	                    		   onClick="fun_tr_title_show($('#table_f_<?=$time?>'),'title_office','show','collapse');$(this).hide();$(this).prev().show();"
	                    		   style="display:none;"
	                    		   >
	                    		   <i class="sui-icon icon-tb-unfold"></i>
	                    		</a>
	                    		
	                    	</td>
	                    </tr>
	                    
	                    <tr>
	                    	<td colspan="6" style="height:35px;vertical-align:text-center;padding-top:10px;"  > 
								<table id="table_office<?=$time?>">
								</table>
	                    	</td>
	                    </tr>
	                    
					</table>
                        