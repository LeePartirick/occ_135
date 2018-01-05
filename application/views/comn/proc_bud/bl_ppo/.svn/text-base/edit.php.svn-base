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
    <div title="经费流程"
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
		 		<center><span class="tb_title"><b>经费流程</b></span></center>
		 		
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
		       				<a href="javascript:void(0)" oaname="btn_import" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-xlsx'" onClick="fun_xlsx_import('proc_bud/m_bl_ppo','经费流程','proc_bud/bl_ppo/import')">导入</a>
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
	                    	<td style="width:20%"></td>
                            <td style="width:30%"></td>
	                        <td style="width:15%"></td>
                            <td style="width:35%"></td>
	                    </tr>

	                    <tr class="tr_title">
	                    	<td colspan="4" style="height:35px;text-align:left"  >
	                    		<span>基本信息</span>
	                    	</td>
	                    </tr>
	                    
	                    <tr>
							<td class="field_s" style="height:35px;text-align: left">
								预算科目
							</td>
							<td style="height:35px;vertical-align:text-center;" colspan="3">
								<input name="content[blp_sub_s]"
									   oaname="content[blp_sub_s]"
                                       id="txtb_blp_sub_s<?=$time?>"
									   class="easyui-textbox oa_input"
                                       data-options="err:err,
					    			   				 limitToList:true,
					    			   				 valueField:'id',
						    						 textField:'text',
					    			   				 height:'25',
					    			   				 width:'200',
					    			   				 multiline:false,
					    			   				 panelHeight:'auto',
					    			   				 fun_ready:'load_sub<?=$time?>()',
					    			   				 panelMaxHeight:120,
					    			   				 panelWidth:'',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                                <input name="content[blp_sub]"
                                       oaname="content[blp_sub]"
                                       id="txtb_blp_sub<?=$time?>"
                                       class="oa_input"
                                       type="hidden"
                                       >
							</td>
						</tr>
						
						<tr>
							<td class="field_s" style="height:35px;text-align: left">
								金额区间
							</td>
							<td style="height:35px;vertical-align:text-center;"  colspan="3">
								<input name="content[blp_sum_start]"
									   oaname="content[blp_sum_start]"
									   id="txtb_bpl_sum_start<?=$time?>"
									   class="easyui-numberbox oa_input"
                                       data-options="err:err,
									   				 precision:2,
									   				 decimalSeparator:'.',
									   				 groupSeparator:',',
									   				 height:'25',
									   				 width:'200',
									   				 fun_ready: 'load_bpl_sum_start<?=$time?>()',
									   				 validType:['errMsg[\'#hd_err_f_<?=$time?>\']']">
								-	   				 
								<input name="content[blp_sum_end]"
									   oaname="content[blp_sum_end]"
									   id="txtb_bpl_sum_end<?=$time?>"
									   class="easyui-numberbox oa_input"
                                       data-options="err:err,
									   				 precision:2,
									   				 decimalSeparator:'.',
									   				 groupSeparator:',',
									   				 height:'25',
									   				 width:'200',
									   				 fun_ready: 'load_bpl_sum_end<?=$time?>()',
									   				 validType:['errMsg[\'#hd_err_f_<?=$time?>\']']">	   				 
							</td>
						</tr>
						
						<tr>
							<td class="field_s" style="height:35px;vertical-align:text-center;"  >
								审核节点
							</td>
							<td style="height:35px;vertical-align:text-center;" >
								<input name="content[blp_ppo]"
									   oaname="content[blp_ppo]"
									   id="txtb_blp_ppo<?=$time?>"
									   class="easyui-combobox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
					    			   				 valueField: 'id',    
        											 textField: 'text', 
					    			   				 multiline:false,
					    			   				 panelHeight:'auto',
					    			   				 panelMaxHeight:120,
					    			   				 data: [<?=element('blp_ppo',$json_field_define)?>],
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 onChange: function(nV,oV)
													 {
													 	var blp_sub = $('#txtb_blp_sub<?=$time?>').val();
													 	if(blp_sub)
													 	{
														 	var url = 'proc_bud/bl_ppo/get_json/search_bl_ppo_num/1/from/combobox/field_id/bl_ppo_num/field_text/bl_ppo_num/search_blp_sub/'+blp_sub+'/search_blp_ppo/'+nV;
															
															$('#txtb_bl_ppo_num<?=$time?>').combobox('reload',url);
														}
														
														$('#tr_blp_ou<?=$time?>').hide();
														
														if(nV && nV != '<?=BLP_PPO_SP?>')
														{
															$('#tr_blp_ou<?=$time?>').show();
														}
													 }
													 ">
							</td>
							<td class="field_s" style="height:35px;text-align: left" >
								审核阶段
							</td>
							<td style="height:35px;vertical-align:text-center;" >
								<input name="content[blp_ppo_num]"
									   oaname="content[blp_ppo_num]"
									   class="easyui-combobox oa_input"
									   id="txtb_blp_ppo_num<?=$time?>"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
					    			   				 valueField: 'id',    
        											 textField: 'text', 
					    			   				 multiline:false,
					    			   				 panelHeight:'auto',
					    			   				 panelMaxHeight:120,
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 fun_ready: 'load_blp_ppo_num<?=$time?>()'
													 ">
							</td>
						</tr>
						
						<tr id="tr_blp_ou<?=$time?>" >
							<td class="field_s" style="height:35px;text-align: left">
								审核部门
							</td>
							<td style="height:35px;vertical-align:text-center;"  colspan="3">
								<input name="content[blp_ou]"
									   oaname="content[blp_ou]"
									   id="txtb_blp_ou<?=$time?>"
									   class="easyui-tagbox oa_input"
									   data-options="err:err,
					    			   				 valueField:'id',
						    						 textField:'text',
						    						 limitToList:true,
						    						 missingMessage:'该输入项为必填项',
					    			   				 height:'25',
					    			   				 width:'100%',
					    			   				 panelHeight:'0',
					    			   				 onShowPanel:function()
					    			   				 {
					    			   				 	$(this).tagbox('hidePanel');
					    			   				 },
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 fun_ready:'load_blp_ou<?=$time?>()'
													 ">
							</td>
						</tr>
						
						<tr>
							<td class="field_s" style="height:35px;text-align: left">
								审核人
							</td>
							<td style="height:35px;vertical-align:text-center;"  colspan="3">
								<input name="content[blp_c]"
										   oaname="content[blp_c]"
										   id="txtb_blp_c<?=$time?>"
										   class="easyui-tagbox oa_input"
										   data-options="err:err,
						    			   				 valueField:'id',
							    						 textField:'text',
							    						 limitToList:true,
							    						 missingMessage:'该输入项为必填项',
						    			   				 height:'25',
						    			   				 width:'100%',
						    			   				 panelHeight:'0',
						    			   				 onShowPanel:function()
						    			   				 {
						    			   				 	$(this).tagbox('hidePanel');
						    			   				 },
														 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
														 fun_ready:'load_blp_c<?=$time?>()'
														 ">
							</td>
						</tr>
						
						<tr>
							<td class="field_s" style="height:35px;vertical-align:text-top;"  >
								备注
							</td>
							<td style="height:35px;vertical-align:text-top;"  colspan="3">
								<input name="content[blp_note]"
									   oaname="content[blp_note]"
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
	                 
	                 <!-- 数据校验时间 -->
                    <input class="db_time_update" name="content[db_time_update]" type="hidden"/>

		 		</form>
		 		
		 		 <!-- 验证错误 -->
         		 <input id="hd_err_f_<?=$time?>"  type="hidden" />
         		 
		 	</div>
		 	
		</div>
         
    </div>
    <div title="操作日志" 
    	 oaname="tab_log"
       	 data-options="iconCls:'icon-log',
       				  href:'base/main/load_win_log_operate',
       				  queryParams:{
       				  	parent_id: 'tab_edit_<?=$time?>',
						op_id: '<?=$blp_id?>',
						table: 'fm_bl_ppo',
						field: 'blp_id',
						time: 'log_<?=$time?>'
       				 }"
       	>
       	
    </div>
    
</div>

<!-- loading -->
<div id="win_loading<?=$time?>" style="padding:5px;overflow:hidden;"></div> 