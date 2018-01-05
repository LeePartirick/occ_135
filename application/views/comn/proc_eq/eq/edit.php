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
    <div title="设备"
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
		 		<center><span class="tb_title"><b>设备</b></span></center>
		 		
		 		<table id="table_h_<?=$time?>" class="table_no_line"  style="width:800px;margin:0 auto;">
		 			<tr>
		       			<td style="width:50%">
		       			<b><?=$code?></b>
		       			</td>
		       			<td style="width:'50%';text-align:right;">
		       			<b><?=$db_time_create?></b>
		       			</td>
		       		</tr>
		       		<tr>
		       			<td style="width:'50%';">
		       				<a href="javascript:void(0)" oaname="btn_save" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-save'" onClick="f_submit_<?=$time?>('save');">保存</a>  
		       				<a href="javascript:void(0)" oaname="btn_import" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-xlsx'" onClick="fun_xlsx_import('proc_eq/m_eq','设备库','proc_eq/eq/import')">导入</a>
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

							<td class="field_s" style="height:35px;text-align: left">
								设备品牌
							</td>
							<td>
								<input name="content[eq_brand]"
									   oaname="content[eq_brand]"
									   class="easyui-textbox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
					    			   				 multiline:false,
													 validType:['length[0,100]','errMsg[\'#hd_err_f_<?=$time?>\']']
													 ">
							</td>

							<td class="field_s" style="height:35px;text-align: left">
								设备名称
							</td>
							<td>
								<input name="content[eq_name]"
									   oaname="content[eq_name]"
									   class="easyui-textbox oa_input"
									   data-options="err:err,
									   				decimalSeparator:'.',
									   				groupSeparator:',',
									   				height:'25',
									   				width:'200',
									   				multiline:false,
									   				validType:['length[0,100]','errMsg[\'#hd_err_f_<?=$time?>\']'],">

							</td>
						</tr>

						<tr>
							<td class="field_s" style="height:35px;text-align: left">
								设备型号
							</td>
							<td style="height:35px;vertical-align:text-center;">
								<input name="content[eq_model]"
									   oaname="content[eq_model]"
									   class="easyui-textbox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
					    			   				 multiline:false,
													 validType:['length[0,100]','errMsg[\'#hd_err_f_<?=$time?>\']']
													 ">
							</td>
							<td class="field_s" style="height:35px;text-align: left">
								设备类别
							</td>
							<td style="height:35px;vertical-align:text-center;" >
								<input name="content[eq_sort]"
									   oaname="content[eq_sort]"
									   class="easyui-combobox oa_input"
									   data-options="err:err,
					    			   				 limitToList:true,
					    			   				 valueField:'id',
						    						 textField:'text',
					    			   				 height:'25',
					    			   				 width:'200',
					    			   				 mutiline:false,
					    			   				 data: [<?=element('eq_sort',$json_field_define)?>],
					    			   				 panelHeight:'auto',
					    			   				 panelMaxHeight:120,
					    			   				 panelWidth:'',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">

							</td>
						</tr>

						<tr>
							<td class="field_s" style="height:35px;text-align: left">
								单位
							</td>
							<td style="height:35px;vertical-align:text-center;"  >
								<input name="content[eq_unit]"
									   oaname="content[eq_unit]"
									   class="easyui-textbox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
					    			   				 multiline:false,
													 validType:['length[0,40]','errMsg[\'#hd_err_f_<?=$time?>\']']
													 ">
							</td>
							<td class="field_s" style="height:35px;text-align: left">
								保修期-月
							</td>
							<td style="height:35px;vertical-align:text-center;">
								<input name="content[eq_maintenance]"
									   oaname="content[eq_maintenance]"
									   class="easyui-numberbox oa_input"
									   data-options="err:err,
									   				precision:0,
									   				height:'25',
									   				width:'200',
									   				multiline:false,
									   				validType:['length[0,11]','errMsg[\'#hd_err_f_<?=$time?>\']'],">
							</td>
						</tr>

						<tr>
							<td class="field_s" style="height:35px;vertical-align:text-top;"  >
								详细描述
							</td>
							<td style="height:35px;vertical-align:text-top;"  colspan="4">
								<input name="content[eq_description]"
									   oaname="content[eq_description]"
									   class="easyui-textbox oa_input"
									   data-options="err:err,
					    			   				 height:'50',
					    			   				 width:'100%',
					    			   				 multiline:true,
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
						</tr>

						<tr>
							<td class="field_s" style="height:35px;vertical-align:text-top;"  >
								设备参数
							</td>
							<td style="height:35px;vertical-align:text-top;"  colspan="4">
								<input name="content[eq_parameter]"
									   oaname="content[eq_parameter]"
									   class="easyui-textbox oa_input"
									   data-options="err:err,
					    			   				 height:'50',
					    			   				 width:'100%',
					    			   				 multiline:true,
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
						</tr>

						<tr>
							<td class="field_s" style="height:35px;text-align: left">
								设备类型
							</td>
							<td style="height:35px;vertical-align:text-center;">
								<input name="content[eq_type]"
									   oaname="content[eq_type]"
									   class="easyui-combobox oa_input"
									   data-options="err:err,
					    			   				 limitToList:true,
					    			   				 valueField:'id',
						    						 textField:'text',
					    			   				 height:'25',
					    			   				 width:'200',
					    			   				 multiline:false,
					    			   				 data: [<?=element('eq_type',$json_field_define)?>],
					    			   				 panelHeight:'auto',
					    			   				 panelMaxHeight:120,
					    			   				 panelWidth:'',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">

							</td>
							<td class="field_s" style="height:35px;text-align: left">
								参考单价
							</td>
							<td style="height:35px;vertical-align:text-center;">
								<input name="content[eq_price]"
									   oaname="content[eq_price]"
									   class="easyui-numberbox oa_input"
									   data-options="err:err,
									   				precision:2,
									   				decimalSeparator:'.',
									   				groupSeparator:',',
									   				height:'25',
									   				width:'200',
									   				multiline:false,
									   				validType:['errMsg[\'#hd_err_f_<?=$time?>\']']">
							</td>
						</tr>

						<tr class="tr_title">
							<td colspan="4" style="height:35px;text-align:left"  >
								<span>供应商信息</span>
							</td>
						</tr>

						<tr>
							<td class="field_s" style="height:35px;text-align: left">
								供应商名称
							</td>
							<td colspan="3">
								<input name="content[eq_org_s]"
									   oaname="content[eq_org_s]"
									   id="txtb_eq_org_s<?=$time?>"
									   class="easyui-textbox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'100%',
					    			   				 multiline:false,
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 fun_ready: 'load_eq_org<?=$time?>()'
													 ">
								<input id="txtb_eq_org<?=$time?>"
									   name="content[eq_org]"
									   oaname="content[eq_org]"
									   class="oa_input"
									   type="hidden""
								/>
							</td>

						</tr>
						<tr>
							<td class="field_s" style="height:35px;text-align: left">
								合作关系
							</td>
							<td colspan="3">
								<input name="content[eq_partnership]"
									   oaname="content[eq_partnership]"
									   class="easyui-combobox oa_input"
									   data-options="err:err,
					    			   				 limitToList:true,
					    			   				 valueField:'id',
						    						 textField:'text',
					    			   				 height:'25',
					    			   				 width:'200',
					    			   				 multiline:false,
					    			   				 data: [<?=element('eq_partnership',$json_field_define)?>],
					    			   				 panelHeight:'auto',
					    			   				 panelMaxHeight:120,
					    			   				 panelWidth:'',
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
						op_id: '<?=$eq_id?>',
						table: 'sm_equipment',
						field: 'eq_id',
						time: 'log_<?=$time?>'
       				 }"
       	>
       	
    </div>
    
</div>

<!-- loading -->
<div id="win_loading<?=$time?>" style="padding:5px;overflow:hidden;"></div> 