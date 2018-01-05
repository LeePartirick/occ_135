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
    <div title="合同评审项"
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
		 		<center><span class="tb_title"><b>合同评审项</b></span></center>
		 		
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
		       				<a href="javascript:void(0)" oaname="btn_import" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-xlsx'" onClick="fun_xlsx_import('proc_gfc/m_cr','合同评审项','proc_gfc/cr/import')">导入</a>
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
							<td class="field_s oa_op" oaname="content[cr_name]" style="height:35px;vertical-align:text-center;"  >
								评审内容
							</td>
							<td class="oa_op" oaname="content[cr_name]" style="height:35px;vertical-align:text-center;"  colspan="3">
								<input name="content[cr_name]"
									   oaname="content[cr_name]"
									   class="easyui-textbox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'100%',
					    			   				 multiline:false,
													 validType:['length[0,250]','errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
							</td>						
						</tr>
						
						<tr>
							<td class="field_s" style="height:35px;vertical-align:text-center;"  >
								默认评审项
							</td>
							<td style="height:35px;vertical-align:text-center;"  colspan="3" >
								<input name="content[cr_default]"
									   oaname="content[cr_default]"
									   class="easyui-combotree oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'100%',
					    			   				 valueField: 'id',    
        											 textField: 'text', 
					    			   				 multiline:false,
					    			   				 multiple:true,
					    			   				 data: [<?=element('cr_default',$json_field_define)?>],
					    			   				 panelHeight:'auto',
					    			   				 panelMaxHeight:120,
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">	   
							</td>
						</tr>
						
						<tr>
							<td class="field_s" style="height:35px;vertical-align:text-center;"  >
								评审阶段
							</td>
							<td style="height:35px;vertical-align:text-center;" >
								<input name="content[cr_ppo]"
									   oaname="content[cr_ppo]"
									   class="easyui-combobox oa_input"
									   id="txtb_cr_ppo<?=$time?>"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
					    			   				 valueField: 'id',    
        											 textField: 'text', 
					    			   				 multiline:false,
					    			   				 panelHeight:'auto',
					    			   				 panelMaxHeight:120,
					    			   				 url_l:'proc_gfc/cr/get_json/search_cr_ppo/1/from/combobox/field_id/cr_ppo/field_text/cr_ppo',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 fun_ready: 'load_cr_ppo<?=$time?>()'
													 ">
							</td>		
							<td class="field_s" style="height:35px;vertical-align:text-center;"  >
								字段关联评审
							</td>
							<td style="height:35px;vertical-align:text-center;" >
								<input name="content[cr_link_field]"
									   oaname="content[cr_link_field]"
									   class="easyui-combotree oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
					    			   				 valueField: 'id',    
        											 textField: 'text', 
					    			   				 multiline:false,
					    			   				 data: [<?=element('cr_link_field',$json_field_define)?>],
					    			   				 panelHeight:'auto',
					    			   				 panelMaxHeight:120,
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
							</td>
						</tr>
							
						<tr>
							<td class="field_s" style="height:35px;vertical-align:text-center;"  >
								可不选择评审人
							</td>
							<td style="height:35px;vertical-align:text-center;"  >
								<input type="checkbox" 
									   class="oa_input"
									   value="1"
									   name="content[cr_person_empty]"
									   oaname="content[cr_person_empty]">
							</td>
							<td class="field_s" style="height:35px;vertical-align:text-center;"  >
								允许修改后通过
							</td>
							<td style="height:35px;vertical-align:text-center;"  >
								<input type="checkbox" 
									   class="oa_input"
									   value="1"
									   name="content[cr_pass_alter]"
									   oaname="content[cr_pass_alter]">
							</td>
						</tr>
						
						<tr>
							<td class="field_s" style="height:35px;vertical-align:text-center;"  >
								评审关联文件
							</td>
							<td style="height:35px;vertical-align:text-center;"  colspan="3">
								<input name="content[cr_link_file]"
									   oaname="content[cr_link_file]"
									   id="txtb_cr_link_file<?=$time?>"
									   class="easyui-tagbox oa_input"
									   data-options="err:err,
					    			   				 valueField:'id',
						    						 textField:'text',
						    						 limitToList:true,
						    						 missingMessage:'该输入项为必填项',
					    			   				 height:'25',
					    			   				 width:'100%',
					    			   				 hasDownArrow:false,
					    			   				 panelHeight:'0px',
					    			   				 onShowPanel:function()
					    			   				 {
					    			   				 	$(this).tagbox('hidePanel');
					    			   				 },
					    			   				 panelWidth:'',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 fun_ready: 'load_cr_link_file<?=$time?>()'
													 ">
							</td>
						</tr>
						
						<tr>
							<td class="field_s" style="height:35px;vertical-align:text-center;"  >
								备注
							</td>
							<td style="height:35px;vertical-align:text-center;"  colspan="3">
								<input name="content[cr_note]"
									   oaname="content[cr_note]"
									   class="easyui-textbox oa_input"
									   data-options="err:err,
					    			   				 height:'50',
					    			   				 width:'100%',
					    			   				 multiline:true,
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
							</td>						 
						</tr>
						
						<tr class="tr_title oa_op" oaname = "title_crp">
	                    	<td colspan="4" style="height:35px;text-align:left"  >
	                    		<span>合同评审人</span>
	                    	</td>
	                     </tr>
	                    
	                    <tr>
	                    	<td colspan="4" style="height:35px;vertical-align:text-center;padding-top:10px;"  > 
								<div id="table_crp_tool<?=$time?>">
									<table style="width:100%;">
										<tr>
											<td style="width:'50%';" >
												<a href="javascript:void(0)" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-add',plain:true" onClick="fun_table_crp_operate<?=$time?>('add')">添加</a>
												<a href="javascript:void(0)" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-remove',plain:true" onClick="fun_table_crp_operate<?=$time?>('del')">删除</a>
												<a href="javascript:void(0)" class="easyui-linkbutton oa_op" data-options="iconCls:'layout-button-up',plain:true" onClick="fun_table_crp_operate<?=$time?>('up')">上移</a>
												<a href="javascript:void(0)" class="easyui-linkbutton oa_op" data-options="iconCls:'layout-button-down',plain:true" onClick="fun_table_crp_operate<?=$time?>('down')">下移</a>
											</td>

										</tr>
									</table>
								</div>
								<table id="table_crp<?=$time?>"
									   name="content[crp]"
									   oaname="content[crp]"
									   class="oa_input data_table"
									   style="max-height:300px;"
								>
								</table>
										
	                    	</td>
	                    </tr> 

	                 </table> 
	                 
	                 <input name="content[bp_id]" oaname="content[bp_id]" class="oa_input" type="hidden" />
	                 
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
						op_id: '<?=$cr_id?>',
						table: 'pm_contract_review',
						field: 'cr_id',
						time: 'log_<?=$time?>'
       				 }"
       	>
       	
    </div>
    
</div>

<!-- loading -->
<div id="win_loading<?=$time?>" style="padding:5px;overflow:hidden;"></div> 