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
    <div title="预算表模型明细"
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
		 		<center><span class="tb_title"><b>预算表模型明细</b></span></center>
		 		
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
		       				<a href="javascript:void(0)" oaname="btn_import" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-xlsx'" onClick="fun_xlsx_import('proc_bud/m_budi','预算表模型明细','proc_bud/budi/import')">导入</a>
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
								CSS风格
							</td>
							<td style="height:35px;vertical-align:text-center;"  colspan="3">
								<input name="content[budi_css]"
									   oaname="content[budi_css]"
									   class="easyui-tagbox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'100%',
					    			   				 valueField:'id',    
    												 textField:'text', 
    												 panelHeight:'auto',
    												 panelMaxHeight:'120',
    												 //hasDownArrow:true,
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 data:[<?=element('budi_css', $json_field_define)?>]
													 ">
							</td>						 
						</tr>
						
						<tr>
							<td class="field_s oa_op" oaname="content[budi_sn]"  style="height:35px;text-align: left">
								行次
							</td>
							<td class="field_s oa_op" oaname="content[budi_sn]" style="height:35px;vertical-align:text-center;">
								<input name="content[budi_sn]"
									   oaname="content[budi_sn]"
									   class="easyui-numberbox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 precision:1,
					    			   				 min:1,
					    			   				 width:'200',
					    			   				 multiline:false,
													 validType:['length[0,40]','errMsg[\'#hd_err_f_<?=$time?>\']'],
													 "
								>
							</td>
							
							<td class="field_s" style="height:35px;text-align: left">
								部门
							</td>
							<td >
								<input name="content[budi_ou_show]"
									   oaname="content[budi_ou_show]"
									   class="easyui-textbox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
					    			   				 multiline:false,
													 validType:['length[0,200]','errMsg[\'#hd_err_f_<?=$time?>\']'],
													 "
								>
							</td>

						</tr>
						
						<tr>
							<td class="field_s oa_op" oaname="content[budi_sub]" style="height:35px;text-align: left">
								预算科目
							</td>
							<td class="field_s oa_op" oaname="content[budi_sub]" style="height:35px;vertical-align:text-center;">
								<input name="content[budi_sub_s]"
									   oaname="content[budi_sub_s]"
									   id="txtb_budi_sub_s<?=$time?>"
									   class="easyui-textbox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
					    			   				 multiline:false,
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 fun_ready: 'load_budi_sub_s<?=$time?>()'
													 "
								>
								<input id="txtb_budi_sub<?=$time?>" 
									   name="content[budi_sub]"
									   oaname="content[budi_sub]"
									   class="oa_input"
									   type="hidden"/>		
							</td>
							<td class="field_s oa_op" oaname="content[budi_name]" style="height:35px;text-align: left">
								核算内容
							</td>
							<td class="field_s oa_op" oaname="content[budi_name]" style="height:35px;vertical-align:text-center;">
								<input name="content[budi_name]"
									   oaname="content[budi_name]"
									   id="txtb_budi_name<?=$time?>"
									   class="easyui-textbox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
					    			   				 multiline:false,
													 validType:['length[0,200]','errMsg[\'#hd_err_f_<?=$time?>\']'],
													 "
								>
							</td>
						</tr>
						
						<tr>
							<td class="field_s" style="height:35px;text-align: left">
								税率
							</td>
							<td style="height:35px;vertical-align:text-center;">
								<input name="content[budi_rate]"
									   oaname="content[budi_rate]"
									   class="easyui-numberbox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
					    			   				 precision:2,
					    			   				 suffix:'%',
					    			   				 max:100,
					    			   				 min:0,
					    			   				 multiline:false,
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 "
								>
							</td>
							<td class="field_s" style="height:35px;vertical-align:text-center;"  >
								科目可选
							</td>
							<td style="height:35px;vertical-align:text-center;"  >
								<input type="checkbox" 
									   class="oa_input"
									   value="1"
									   name="content[budi_sub_check]"
									   oaname="content[budi_sub_check]">
							</td>
						</tr>

						<tr>
							<td class="field_s" style="height:35px;vertical-align:text-center;"  >
								金额可编辑
							</td>
							<td style="height:35px;vertical-align:text-center;"  >
								<input type="checkbox" 
									   class="oa_input"
									   value="1"
									   name="content[budi_sum_edit]"
									   oaname="content[budi_sum_edit]">
							</td>		
							<td class="field_s" style="height:35px;vertical-align:text-center;"  >
								无不含税金额
							</td>
							<td style="height:35px;vertical-align:text-center;"  >
								<input type="checkbox" 
									   class="oa_input"
									   value="1"
									   name="content[budi_sum_notax_empty]"
									   oaname="content[budi_sum_notax_empty]">
							</td>					 
						</tr>
						<tr>
							<td class="field_s" style="height:35px;vertical-align:text-center;"  >
								备注
							</td>
							<td style="height:35px;vertical-align:text-center;"  colspan="3">
								<input name="content[budi_note]"
									   oaname="content[budi_note]"
									   class="easyui-textbox oa_input"
									   data-options="err:err,
					    			   				 height:'50',
					    			   				 width:'100%',
					    			   				 multiline:true,
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
						</tr>

	                 </table> 
	                 
	                 <input name="content[budi_id]" oaname="content[budi_id]" class="oa_input" type="hidden" />
	                 
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
						op_id: '<?=$budi_id?>',
						table: 'fm_bud_item',
						field: 'budi_id',
						time: 'log_<?=$time?>'
       				 }"
       	>
       	
    </div>
    
</div>

<!-- loading -->
<div id="win_loading<?=$time?>" style="padding:5px;overflow:hidden;"></div> 