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
    <div title="差旅费报销单" 
         style="">
         
        <div id="l_<?=$time?>" 
	   		class="easyui-layout" 
		 	data-options="fit:true">
		 	
		 	<div data-options="region:'north',border:false" 
		 		style="height:auto;padding-top:15px;overflow:hidden;">	
		 		<? if( ! empty($log_time) ){ ?>
		 		<center><span class="tb_title"><b>操作日志</b></span></center>
				<table style="width:1300px;margin:0 auto;" class="table_no_line">
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
		 		<center><span class="tb_title"><b>差旅费报销单</b></span></center>
		 		
		 		<table id="table_h_<?=$time?>" class="table_no_line"  style="width:1300px;margin:0 auto;">
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
		       			</td>
		       			<td style="width:'50%';text-align:right;">
       	       				<a href="javascript:void(0)" oaname="btn_reload" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-reload'" onClick="$.messager.confirm('确认','您确认想要重置为初始数据吗？',function(r){if(r)load_form_data_<?=$time?>();});">重置</a>
		       				<a href="javascript:void(0)" oaname="btn_person" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-man'" onClick="fun_person_create($('#f_<?=$time?>'),'<?=$url_conf?>')">个性化</a>  
		       				<a href="javascript:void(0)" oaname="btn_log" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-log'" onClick="$('#tab_edit_<?=$time?>').tabs('select',1)">日志</a> 
		       			</td>
		       		</tr>
		       		<tr>
		       			<td style="width:'100%';font-size:14px;" colspan="2">
		       			<b>当前节点:<?=$ppo_name;?></b>
		       			</td>
		       		</tr>
		       	</table>
				
		 	</div>
		 	
		 	<div data-options="region:'center',border:false" style="padding:5px;">
		 		
		 		<form id="f_<?=$time?>" class="easyui-form" method="post" data-options="novalidate:false" time="<?=$time?>"> 
		 			<table id="table_f_<?=$time?>" style="width:1300px;margin:0 auto;">
						<tr class="set_width"> 
	                    	<td style="width:100px"></td> 
                            <td style="width:225px"></td> 
	                        <td style="width:100px"></td> 
                            <td style="width:225px"></td> 
                            <td style="width:100px"></td> 
                            <td style="width:225px"></td> 
                            <td style="width:100px"></td> 
                            <td style="width:225px"></td> 
	                    </tr> 
	                    
	                    <tr class="tr_title oa_op" > 
	                    	<td colspan="8" style="height:35px;vertical-align:text-center;"  > 
	                    		<span>基本信息</span>
	                    	</td>
	                    </tr>
	                    
	                    <tr>
	                    	<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	单据编号
                            </td>
                            <td style="height:35px;vertical-align:text-center;" > 
                            	<span name="content[bal_code]" 
					    			  oaname="content[bal_code]"
					    			  class="oa_input"
					    			>
					    		</span>
                            </td>
							<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	申请人
                            </td>
                            <td style="height:35px;vertical-align:text-center;" > 
                            	<span name="content[bal_contact_manager_s]" 
					    			  oaname="content[bal_contact_manager_s]"
					    			  class="oa_input"
					    			>
					    		</span>
                            </td>
                            <td class="field_s" style="height:35px;text-align: left">
								部门
							</td>
							<td style="height:35px;vertical-align:text-center;" >
								<span name="content[bal_ou_s]" 
					    			  oaname="content[bal_ou_s]"
					    			  class="oa_input"
					    			>
					    		</span>
							</td>
							<td class="field_s" style="height:35px;text-align: left">
								日期
							</td>
							<td style="height:35px;vertical-align:text-center;" >
								<span name="content[bal_time_node]" 
					    			  oaname="content[bal_time_node]"
					    			  class="oa_input"
					    			>
					    		</span>
							</td>
	                    </tr>
	                    
	                    <tr>
							<td colspan="8" style="height:35px;vertical-align:text-center;padding-top:10px;"  >
								<div id="table_trip_tool<?=$time?>">
									<table style="width:100%;">
										<tr>
											<td style="width:'50%';" >
												<a href="javascript:void(0)" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-add',plain:true" onClick="fun_table_trip_operate<?=$time?>('add')">添加</a>
												<a href="javascript:void(0)" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-remove',plain:true" onClick="fun_table_trip_operate<?=$time?>('del')">删除</a>
											</td>
											<td style="width:'50%';text-align:right;">
											</td>
										</tr>
									</table>
								</div>
								<table id="table_trip<?=$time?>"
									   name="content[trip]"
									   oaname="content[trip]"
									   class="oa_input data_table"
								>
								</table>
								
							</td>
						</tr>
						
						<tr class="tr_title oa_op" oaname="title_trip_c"> 
	                    	<td colspan="8" style="height:35px;vertical-align:text-center;"  > 
	                    		<span>出差人/垫付人</span>
	                    	</td>
	                    </tr>
	                    
	                    <tr>
							<td colspan="8" style="height:35px;vertical-align:text-center;padding-top:10px;"  >
								<div id="table_trip_c_tool<?=$time?>">
									<table style="width:100%;">
										<tr>
											<td style="width:'50%';" >
												<a href="javascript:void(0)" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-add',plain:true" onClick="fun_table_trip_c_operate<?=$time?>('add')">添加</a>
												<a href="javascript:void(0)" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-remove',plain:true" onClick="fun_table_trip_c_operate<?=$time?>('del')">删除</a>
											</td>
											<td style="width:'50%';text-align:right;">
											</td>
										</tr>
									</table>
								</div>
								<table id="table_trip_c<?=$time?>"
									   name="content[trip_c]"
									   oaname="content[trip_c]"
									   class="oa_input data_table"
								>
								</table>
								
							</td>
						</tr>
						
						<tr class="tr_title oa_op" oaname="title_trip_sub"> 
	                    	<td colspan="8" style="height:35px;vertical-align:text-center;"  > 
	                    		<span>补贴信息</span>
	                    	</td>
	                    </tr>
	                    
	                    <tr>
							<td colspan="8" style="height:35px;vertical-align:text-center;padding-top:10px;"  >
								<div id="table_trip_sub_tool<?=$time?>">
									<table style="width:100%;">
										<tr>
											<td style="width:'50%';" >
												<a href="javascript:void(0)" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-add',plain:true" onClick="fun_table_trip_sub_operate<?=$time?>('add')">添加</a>
												<a href="javascript:void(0)" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-remove',plain:true" onClick="fun_table_trip_sub_operate<?=$time?>('del')">删除</a>
											</td>
											<td style="width:'50%';text-align:right;">
											</td>
										</tr>
									</table>
								</div>
								<table id="table_trip_sub<?=$time?>"
									   name="content[trip_sub]"
									   oaname="content[trip_sub]"
									   class="oa_input data_table"
								>
								</table>
								
							</td>
						</tr>
						
						<tr class="tr_title oa_op" oaname="title_gfc_ft"> 
	                    	<td colspan="8" style="height:35px;vertical-align:text-center;"  > 
	                    		<span>费用分摊</span>
	                    	</td>
	                    </tr>
	                    
	                    <tr>
							<td colspan="8" style="height:35px;vertical-align:text-center;padding-top:10px;"  >
								<div id="table_gfc_ft_tool<?=$time?>">
									<table style="width:100%;">
										<tr>
											<td style="width:'50%';" >
												<a href="javascript:void(0)" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-add',plain:true" onClick="fun_table_gfc_ft_operate<?=$time?>('add')">添加</a>
												<a href="javascript:void(0)" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-remove',plain:true" onClick="fun_table_gfc_ft_operate<?=$time?>('del')">删除</a>
											</td>
											<td style="width:'50%';text-align:right;">
											</td>
										</tr>
									</table>
								</div>
								<table id="table_gfc_ft<?=$time?>"
									   name="content[gfc_ft]"
									   oaname="content[gfc_ft]"
									   class="oa_input data_table"
								>
								</table>
								
							</td>
						</tr>
						
	                 </table> 
	                 
	                 <!-- 数据校验时间 -->
					<input class="db_time_update" name="content[db_time_update]" type="hidden" />
					
					<!-- 移交人 -->
					<input id="person_yj<?=$time?>" name="content[person_yj]" type="hidden" />
					<input id="person_yj_s<?=$time?>" name="content[person_yj_s]" type="hidden" />
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
						op_id: '<?=$bali_id?>',
						table: 'fm_balance',
						field: 'bali_id',
						time: 'log_<?=$time?>'
       				 }"
       	>
       	
    </div>
    
</div>

<!-- loading -->
<div id="win_loading<?=$time?>" style="padding:5px;overflow:hidden;"></div> 