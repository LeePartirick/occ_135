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
    <div title="设备清单明细"
         style="">
        <div id="l_<?=$time?>" 
	   		class="easyui-layout" 
		 	data-options="fit:true">
		 	
		 	<div class="oa_op"
		 		 oaname="div_title"
		 		 data-options="region:'north',border:false" 
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
		 		<center><span class="tb_title"><b>设备清单明细</b></span></center>
		 		
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
		       				<a href="javascript:void(0)" oaname="btn_import" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-xlsx'" onClick="fun_xlsx_import('proc_gfc/m_eli','设备清单明细','proc_gfc/eli/import/f_id/f_<?=$time?>/fun_no_db/<?=$fun_no_db?>')">导入</a>
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
		 	
		 		<form id="f_<?=$time?>" class="easyui-form" method="post" data-options="novalidate:false" time="<?=$time?>" style=""> 
			         	 
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
							<td class="field_s oa_op" oaname="content[eli_sub]" style="height:35px;vertical-align:text-center;">
								预算科目
							</td>
							<td class="oa_op" oaname="content[eli_sub]" style="height:35px;vertical-align:text-center;" >
								<input name="content[eli_sub]"
									   oaname="content[eli_sub]"
									   id="txtb_eli_sub<?=$time?>"
									   class="easyui-combobox oa_input"
									   data-options="err:err,
					    			   				 limitToList:true,
					    			   				 valueField:'id',    
						    						 textField:'text',
					    			   				 height:'25',
					    			   				 width:'200',
					    			   				 multiline:false,
					    			   				 panelHeight:'auto',
					    			   				 panelMaxHeight:120,
					    			   				 multiline:false,
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 fun_ready: 'load_eli_sub<?=$time?>()'
													 "
								>
								<input id="txtb_eli_type<?=$time?>" 
									   name="content[eli_type]"
									   oaname="content[eli_type]"
									   class="oa_input"
									   type="hidden"/>	
							</td>
						</tr>
						<tr>
							<td class="field_s oa_op" oaname="content[eli_name]" style="height:35px;vertical-align:text-center;">
								<span class="oa_input" oaname="content[eli_name_s]"></span>
							</td>
							<td class="oa_op" oaname="content[eli_name]" style="height:35px;vertical-align:text-center;" colspan="3">
								<input name="content[eli_name]"
									   oaname="content[eli_name]"
									   id="txtb_eli_name<?=$time?>"
									   class="easyui-textbox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'100%',
					    			   				 multiline:false,
													 validType:['length[0,250]','errMsg[\'#hd_err_f_<?=$time?>\']'],
													 fun_ready: 'load_eli_name<?=$time?>()'
													 "
								>
								<input id="txtb_eli_eq_id<?=$time?>" 
									   name="content[eli_eq_id]"
									   oaname="content[eli_eq_id]"
									   class="oa_input"
									   type="hidden"/>	
							</td>

						</tr>
						
						<tr>
							<td class="field_s oa_op" oaname="content[eli_supply_org]" style="height:35px;vertical-align:text-center;">
								<span class="oa_input" oaname="content[eli_supply_org_s_s]"></span>
							</td>
							<td class="oa_op" oaname="content[eli_supply_org]" style="height:35px;vertical-align:text-center;" colspan="3">
								<input name="content[eli_supply_org_s]"
									   oaname="content[eli_supply_org_s]"
									   id="txtb_eli_supply_org_s<?=$time?>" 
									   class="easyui-textbox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'100%',
					    			   				 multiline:false,
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 fun_ready: 'load_eli_supply_org<?=$time?>()'
													 "
								>
								<input id="txtb_eli_supply_org<?=$time?>" 
									   name="content[eli_supply_org]"
									   oaname="content[eli_supply_org]"
									   class="oa_input"
									   type="hidden"/>	
							</td>

						</tr>
						
						<tr oaname = "tr_eq">
							<td class="field_s oa_op" oaname="content[eli_brand]" style="height:35px;vertical-align:text-center;">
								品牌
							</td>
							<td class="oa_op" oaname="content[eli_brand]" style="height:35px;vertical-align:text-center;" >
								<input name="content[eli_brand]"
									   oaname="content[eli_brand]"
									   id="txtb_eli_brand<?=$time?>"
									   class="easyui-textbox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
					    			   				 multiline:false,
													 validType:['length[0,250]','errMsg[\'#hd_err_f_<?=$time?>\']'],
													 "
								>
							</td>
							<td class="field_s oa_op" oaname="content[eli_model]" style="height:35px;vertical-align:text-center;">
								型号
							</td>
							<td class="oa_op" oaname="content[eli_model]" style="height:35px;vertical-align:text-center;" >
								<input name="content[eli_model]"
									   oaname="content[eli_model]"
									   id="txtb_eli_model<?=$time?>"
									   class="easyui-textbox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
					    			   				 multiline:false,
													 validType:['length[0,250]','errMsg[\'#hd_err_f_<?=$time?>\']'],
													 "
								>
							</td>

						</tr>
						
						<tr>
							<td class="field_s oa_op" oaname="content[eli_parameter]" style="height:35px;vertical-align:text-center;">
								<span class="oa_input" oaname="content[eli_parameter_s]"></span>
							</td>
							<td class="oa_op" oaname="content[eli_parameter]" style="height:35px;vertical-align:text-center;" colspan="3">
								<input name="content[eli_parameter]"
									   oaname="content[eli_parameter]"
									   id="txtb_eli_parameter<?=$time?>"
									   class="easyui-textbox oa_input"
									   data-options="err:err,
					    			   				 height:'50',
					    			   				 width:'100%',
					    			   				 multiline:true,
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 "
								>
							</td>

						</tr>
						
						<tr>
							<td class="field_s oa_op" oaname="content[eli_count]" style="height:35px;vertical-align:text-center;">
								数量
							</td>
							<td class="oa_op" oaname="content[eli_count]" style="height:35px;vertical-align:text-center;" >
								<input name="content[eli_count]"
									   oaname="content[eli_count]"
									   id="txtb_eli_count<?=$time?>"
									   class="easyui-numberbox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
					    			   				 min:0,
					    			   				 precision:2,
					    			   				 groupSeparator:',',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 onChange: function(newValue,oldValue)
													 {
													 	var sum = $('#txtb_eli_sum<?=$time?>').numberbox('getValue');
													 	sum = parseFloat(sum);
													 	if(newValue && sum && sum != 0 )
													 	{
													 		$('#f_<?=$time?>').form('load',{'content[eli_sum_total]': newValue*sum});
													 	}
													 }
													 "
								>
							</td>
							<td class="field_s oa_op" oaname="content[eli_sum]" style="height:35px;vertical-align:text-center;">
								采购单价
							</td>
							<td class="oa_op" oaname="content[eli_sum]" style="height:35px;vertical-align:text-center;" >
								<input name="content[eli_sum]"
									   oaname="content[eli_sum]"
									   id="txtb_eli_sum<?=$time?>"
									   class="easyui-numberbox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
					    			   				 min:0,
					    			   				 precision:2,
					    			   				 groupSeparator:',',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 fun_ready: 'load_eli_sum<?=$time?>()',
													 onChange: function(newValue,oldValue)
													 {
													 	var count = $('#txtb_eli_count<?=$time?>').numberbox('getValue');
													    count = parseFloat(count);
													 	if(newValue && count && count != 0)
													 	{
													 		$('#f_<?=$time?>').form('load',{'content[eli_sum_total]': newValue*count});
													 	}
													 }
													 "
								>
							</td>

						</tr>
						
						<tr>
							<td class="field_s oa_op" oaname="content[eli_maintenance]" style="height:35px;vertical-align:text-center;">
								<span class="oa_input" oaname="content[eli_maintenance_s]"></span>
							</td>
							<td class="oa_op" oaname="content[eli_maintenance]" style="height:35px;vertical-align:text-center;" >
								<input name="content[eli_maintenance]"
									   oaname="content[eli_maintenance]"
									   id="txtb_eli_maintenance<?=$time?>"
									   class="easyui-numberbox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
					    			   				 min:0,
					    			   				 groupSeparator:',',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 "
								>
							</td>
							<td class="field_s oa_op" oaname="content[eli_sum_total]" style="height:35px;vertical-align:text-center;">
								单位成本
							</td>
							<td class="oa_op" oaname="content[eli_sum_total]" style="height:35px;vertical-align:text-center;" >
								<input name="content[eli_sum_total]"
									   oaname="content[eli_sum_total]"
									   id="txtb_eli_sum_total<?=$time?>"
									   class="easyui-numberbox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
					    			   				 min:0,
					    			   				 precision:2,
					    			   				 groupSeparator:',',
													 validType:['length[0,250]','errMsg[\'#hd_err_f_<?=$time?>\']'],
													 fun_ready: 'load_eli_sum_total<?=$time?>()',
													 onChange: function(newValue,oldValue)
													 {
													 	if( ! newValue) return;
													 	
													 	var data =  fun_get_data_from_f('f_<?=$time?>','1');
													 	if(data.eli_sub_s == '零星采购') return;
													 	
													 	var count = data.eli_count
													 	var sum = data.eli_sum
													 	
													 	if( ! count || count == 0)
													 	{
													 		count =1;
													 		$('#f_<?=$time?>').form('load',{'content[eli_count]': 1});
													 	}
													 	
													 	if( ! sum || sum == 0)
													 	{
													 		sum = parseFloat(newValue) / parseFloat(count);
													 		$('#f_<?=$time?>').form('load',{'content[eli_sum]': sum});
													 	}
													 }
													 "
								>
							</td>
						</tr>
						
						<tr oaname = "tr_fb">
							<td class="field_s oa_op" oaname="content[eli_maintenance_start]" style="height:35px;vertical-align:text-center;">
								服务起始时间
							</td>
							<td class="oa_op" oaname="content[eli_maintenance_start]" style="height:35px;vertical-align:text-center;" >
								<input name="content[eli_maintenance_start]"
									   oaname="content[eli_maintenance_start]"
									   class="easyui-datebox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 "
								>
							</td>
						</tr>

						<tr>
							<td class="field_s" style="height:35px;vertical-align:text-top;"  >
								备注
							</td>
							<td style="height:35px;vertical-align:text-top;"  colspan="3">
								<input name="content[eli_note]"
									   oaname="content[eli_note]"
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
						op_id: '<?=$eli_id?>',
						table: 'pm_eq_list_item',
						field: 'eli_id',
						time: 'log_<?=$time?>'
       				 }"
       	>
       	
    </div>
    
</div>

<!-- loading -->
<div id="win_loading<?=$time?>" style="padding:5px;overflow:hidden;"></div> 