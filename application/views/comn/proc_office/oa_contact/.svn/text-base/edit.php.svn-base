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
    <div title="员工索引"
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
		 		<center><span class="tb_title"><b>员工信息</b></span></center>
		 		
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
		       				<a href="javascript:void(0)" oaname="btn_import" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-xlsx'" onClick="fun_xlsx_import('proc_office/m_oa_info','员工索引','proc_office/oa_info/import')">导入</a>
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

	                    <tr class="tr_title">
	                    	<td colspan="4" style="height:35px;text-align:left"  >
	                    		<span>基本信息</span>
	                    	</td>
	                    </tr>

						<tr>
							<td class="field_s" style="height:35px;vertical-align:text-center;"  >
								所属机构
							</td>
							<td style="height:35px;vertical-align:text-center;"  colspan="3">
                             	<span name="content[c_org_s]"
									  oaname="content[c_org_s]"
									  class="oa_input"
								>
					    		</span>
							</td>
						</tr>
						<tr>
							<td class="field_s" style="height:35px;text-align: left">
								姓名
							</td>
							<td>
								<input name="content[c_name]"
									   oaname="content[c_name]"
									   class="easyui-textbox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200px',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
							</td>
							<td class="field_s" style="height:35px;text-align: left">
								性别
							</td>
							<td>
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

							<td class="field_s" style="height:35px;text-align: left">
								短号
							</td>
							<td>
								<input name="content[c_tel_code]"
									   oaname="content[c_tel_code]"
									   class="easyui-textbox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
													 validType:['length[0,80]','errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
							</td>
							<td class="field_s" style="height:35px;text-align: left">
								二级部门
							</td>
							<td>
								<input name="content[c_ou_2]"
									   oaname="content[c_ou_2]"
									   class="easyui-textbox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200px',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
							</td>
						</tr>

						<tr>
							<td class="field_s" style="height:35px;text-align: left">
								三级部门
							</td>
							<td>
								<input name="content[c_ou_3]"
									   oaname="content[c_ou_3]"
									   class="easyui-textbox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
													 validType:['length[0,80]','errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
							</td>
							<td class="field_s" style="height:35px;text-align: left">
								四级部门
							</td>
							<td>
								<input name="content[c_ou_4]"
									   oaname="content[c_ou_4]"
									   class="easyui-textbox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
													 validType:['length[0,80]','errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
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
					    			   				 width:'120px',
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
								备用手机
							</td>
							<td style="height:35px;vertical-align:text-center;"  >
								<input name="content[c_tel_2]"
									   oaname="content[c_tel_2]"
									   id="txtb_c_tel_2<?=$time?>"
									   class="easyui-numberbox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'120px',
					    			   				 multiline:false,
													 validType:['length[0,20]','errMsg[\'#hd_err_f_<?=$time?>\']'],
													 fun_ready: 'load_c_tel_2<?=$time?>()'
													 ">
								<span name="content[c_tel_2_info]"
									  oaname="content[c_tel_2_info]"
									  id="span_c_tel_2_info<?=$time?>"
									  class="oa_input"
								></span>

								<script type="text/javascript" >
									function load_c_tel_2<?=$time?>()
									{
										$('#txtb_c_tel_2<?=$time?>').textbox('textbox').bind('blur',
											function(){
												var tel=$(this).val();

												var info=fun_get_code_info('base/fun/get_info_of_tele_info',tel);

												$('#span_c_tel_2_info<?=$time?>').html(info);

											});
									}
								</script>
							</td>
						</tr>

						<tr>
							<td class="field_s" style="height:35px;text-align: left">
								系统ID
							</td>
							<td>
								<input name="content[c_login_id]"
									   oaname="content[c_login_id]"
									   class="easyui-textbox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
													 validType:['length[0,80]','errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
							</td>
							<td class="field_s" style="height:35px;text-align: left">
								手机上网ID
							</td>
							<td>
								<input name="content[c_login_id_m]"
									   oaname="content[c_login_id_m]"
									   class="easyui-textbox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
													 validType:['length[0,80]','errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
							</td>
						</tr>
						<tr>
							<td class="field_s" style="height:35px;text-align: left">
								系统邮箱
							</td>
							<td>
								<input name="content[c_email_sys]"
									   oaname="content[c_email_sys]"
									   class="easyui-textbox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
													 validType:['length[0,80]','errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
							</td>
							<td class="field_s" style="height:35px;text-align: left">
								工资邮箱
							</td>
							<td>
								<input name="content[c_email_gz]"
									   oaname="content[c_email_gz]"
									   class="easyui-textbox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
													 validType:['length[0,80]','errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
							</td>
						</tr>
						<tr>
							<td class="field_s" style="height:35px;text-align: left">
								有线MAC地址
							</td>
							<td>
								<input name="content[c_mac_line]"
									   oaname="content[c_mac_line]"
									   class="easyui-textbox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
													 validType:['length[0,80]','errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
							</td>
							<td class="field_s" style="height:35px;text-align: left">
								无线MAC地址
							</td>
							<td>
								<input name="content[c_mac_noline]"
									   oaname="content[c_mac_noline]"
									   class="easyui-textbox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
													 validType:['length[0,80]','errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
							</td>
						</tr>
						<tr>
							<td class="field_s" style="height:35px;text-align: left">
								网络证书密钥
							</td>
							<td>
								<input name="content[c_pwd_web]"
									   oaname="content[c_pwd_web]"
									   class="easyui-textbox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
													 validType:['length[0,80]','errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
							</td>

						</tr>

						<tr oaname="title_offa_item" class="tr_title oa_op">
							<td colspan="4" style="height:35px;vertical-align:text-center;"  >
								<span>信息系统</span>
							</td>
							<td colspan="4" style="height:35px;text-align:right"  >

								<a href="javascript:void(0);"
								   class="sui-btn btn-bordered btn-small btn-primary"
								   onClick="fun_tr_title_show($('#table_f_<?=$time?>'),'title_offa_item','','collapse');$(this).hide();$(this).next().show();"
								>
									<i class="sui-icon icon-tb-fold"></i>
								</a>

								<a href="javascript:void(0);"
								   class="sui-btn btn-bordered btn-small btn-primary"
								   onClick="fun_tr_title_show($('#table_f_<?=$time?>'),'title_offa_item','show','collapse');$(this).hide();$(this).prev().show();"
								   style="display:none;"
								>
									<i class="sui-icon icon-tb-unfold"></i>
								</a>

							</td>
						</tr>

						<tr>
							<td colspan="4" style="height:35px;vertical-align:text-center;padding-top:10px;"  >
								<div id="table_offa_item_tool<?=$time?>">
									<table style="width:100%;">
										<tr>
											<td style="width:'50%';" >
												<a href="javascript:void(0)" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-add',plain:true" onClick="fun_table_offa_item_operate<?=$time?>('add')">添加</a>
												<a href="javascript:void(0)" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-remove',plain:true" onClick="fun_table_offa_item_operate<?=$time?>('del')">删除</a>
											</td>

										</tr>
									</table>
								</div>
								<table id="table_offa_item<?=$time?>"
									   name="content[offa_item]"
									   oaname="content[offa_item]"
									   class="oa_input data_table"
								>
								</table>

							</td>



	                 </table> 
	                 
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
						time: 'log_<?=$time?>',
						fun_p: 'proc_office',
						fun_m: 'm_oa_contact',
						fun_f: 'get_where_log',
       				 }"
       	>
       	
    </div>
    
</div>

<!-- loading -->
<div id="win_loading<?=$time?>" style="padding:5px;overflow:hidden;"></div> 