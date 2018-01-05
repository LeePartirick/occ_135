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
    <div title="预算表模型"
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
		 		<center><span class="tb_title"><b>预算表模型</b></span></center>
		 		
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
		       				<a href="javascript:void(0)" oaname="btn_import" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-xlsx'" onClick="fun_xlsx_import('proc_bud/m_budm','预算表模型','proc_bud/budm/import')">导入</a>
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
								预算表名称
							</td>
							<td colspan="3">
								<input name="content[budm_name]"
									   oaname="content[budm_name]"
									   class="easyui-textbox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'100%',
					    			   				 multiline:false,
													 validType:['length[0,200]','errMsg[\'#hd_err_f_<?=$time?>\']'],
													 "
								>
							</td>

						</tr>
						
						<tr>
							<td class="field_s" style="height:35px;text-align: left">
								类型
							</td>
							<td colspan="3">
								<input name="content[budm_type]"
									   oaname="content[budm_type]"
									   class="easyui-combobox oa_input"
									   data-options="err:err,
					    			   				 limitToList:true,
					    			   				 valueField:'id',    
						    						 textField:'text',
					    			   				 height:'25',
					    			   				 width:'200px',
					    			   				 multiline:false,
					    			   				 data: [<?=element('budm_type',$json_field_define)?>],
					    			   				 panelHeight:'auto',
					    			   				 panelMaxHeight:120,
					    			   				 panelWidth:'',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
							</td>

						</tr>

						<tr>
							<td class="field_s" style="height:35px;vertical-align:text-top;"  >
								备注
							</td>
							<td style="height:35px;vertical-align:text-top;"  colspan="3">
								<input name="content[budm_note]"
									   oaname="content[budm_note]"
									   class="easyui-textbox oa_input"
									   data-options="err:err,
					    			   				 height:'50',
					    			   				 width:'100%',
					    			   				 multiline:true,
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
						</tr>
						
						<tr class="tr_title oa_op" oaname="title_tax_type">
	                    	<td colspan="4" style="height:35px;text-align:left"  >
	                    		<span>流转税选项</span>
	                    	</td>
	                    </tr>
						
						<tr >
	                    	<td colspan="4" style="padding-top:5px;"  >
	                    		<div id="table_tax_type_tool<?=$time?>">
	                    			<table style="width:100%;">
	                    				<tr>
							       			<td style="width:'50%';" >
							       				<a href="javascript:void(0)" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-add',plain:true" onClick="fun_table_tax_type_operate<?=$time?>('add')">添加</a>  
				       							<a href="javascript:void(0)" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-remove',plain:true" onClick="fun_table_tax_type_operate<?=$time?>('del')">删除</a>  
							       			</td>
							       			<td style="width:'50%';text-align:right;">
							       			</td>
							       		</tr>
	                    			</table>
	                    		</div>
	                    		
	                    		<table id="table_tax_type<?=$time?>"
	                    			   name="content[budm_tax_type]" 
					    			   oaname="content[budm_tax_type]"
					    			   class="oa_input data_table"
					    			   style="min-height:100px;">
					    			   
					    		</table>
	                    	</td>
	                    </tr>
						
						<tr class="tr_title oa_op" oaname="title_budi">
	                    	<td colspan="4" style="height:35px;text-align:left"  >
	                    		<span>预算表</span>
	                    	</td>
	                    </tr>

						<tr >
	                    	<td colspan="4" style="padding-top:5px;"  >
	                    		<div id="table_budi_tool<?=$time?>">
	                    			<table style="width:100%;">
	                    				<tr>
							       			<td style="width:'50%';" >
							       				<a href="javascript:void(0)" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-add',plain:true" onClick="fun_table_budi_operate<?=$time?>('add')">添加</a>  
				       							<a href="javascript:void(0)" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-edit',plain:true" onClick="fun_table_budi_operate<?=$time?>('edit')">编辑</a>  
				       							<a href="javascript:void(0)" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-remove',plain:true" onClick="fun_table_budi_operate<?=$time?>('del')">删除</a>  
							       			</td>
							       			<td style="width:'50%';text-align:right;">
							       			</td>
							       		</tr>
							       		<tr>
							       			<td colspan = "2" id="td_budi_field<?=$time?>">	
							       			</td>
							       		</tr>
							       		<!--  
							       		<tr>
							       			<td colspan = "2">
							       				<input id="txtb_budi_css<?=$time?>"
													   class="easyui-tagbox"
													   data-options="err:err,
									    			   				 height:'25',
									    			   				 width:'650',
									    			   				 label:'风格CSS',
									    			   				 valueField:'id',    
				    												 textField:'text', 
				    												 panelHeight:'auto',
				    												 panelMaxHeight:'120',
				    												 hasDownArrow:true,
				    												 disabled:true,
				    												 icons:[{
																		   iconCls:'icon-save',
																			handler: function(e){
																				
																			}
																	 }]
																	 ">
												<a href="javascript:void(0)" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-edit',plain:true" onClick=""></a> 
											</td>
							       		</tr>
							       		-->
										<tr>
							       			<td colspan = "2">		
												<input id="txtb_budi_count<?=$time?>"
													   class="easyui-tagbox"
													   data-options="err:err,
									    			   				 height:'25px;',
									    			   				 width:'650',
									    			   				 label:'计算公式',
									    			   				 valueField:'id',    
				    												 textField:'text', 
				    												 panelHeight:'auto',
				    												 panelMaxHeight:'0',
				    												 hasDownArrow:false,
				    												 disabled:true,
				    												 limitToList:false,
				    												 buttonIcon:'icon-clear',
													         	   	 onClickButton:function()
														         	 {
													         	   		$(this).tagbox('clear');
														         	 },
				    												 onChange:function(newValue, oldValue)
				    												 {
				    												 	fun_layer_budi_count<?=$time?>();
				    												 },
				    												 onRemoveTag: function(value)
				    												 {
				    												 	if( typeof(index_layer_budi_count<?=$time?>) != 'undefined' 
				    												 	 && index_layer_budi_count<?=$time?>)
				    												 	layer.close(index_layer_budi_count<?=$time?>);
				    												 },
				    												 icons:[{
																		   iconCls:'icon-save',
																			handler: function(e){
																				fun_save_budi_cell<?=$time?>('count');
																			}
																	 }]
																	 ">	
												<a href="javascript:void(0)" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-edit',plain:true" onClick="fun_edit_budi_cell<?=$time?>('count')"></a>  				 	
							       			</td>
							       		</tr>
							       		<tr id = "tr_budi_count_other<?=$time?>" style="display:none;">
							       			<td colspan = "2" >		
												<input id="txtb_budi_count_other<?=$time?>"
													   class="easyui-tagbox"
													   data-options="err:err,
									    			   				 height:'25px;',
									    			   				 width:'790',
									    			   				 valueField:'id',    
				    												 textField:'text', 
				    												 panelHeight:'auto',
				    												 panelMaxHeight:'0',
				    												 hasDownArrow:false,
				    												 readonly:true,
				    												 limitToList:false,
				    												 icons:[{
																		   iconCls:'icon-lock',
																			handler: function(e){
																			}
																	 }]
																	 ">	
							       			</td>
							       		</tr>
	                    			</table>
	                    		</div>
	                    		
	                    		<table id="table_budi<?=$time?>"
	                    			   name="content[budi]" 
					    			   oaname="content[budi]"
					    			   class="oa_input data_table"
					    			   style="min-height:100px;max-height:800px;">
					    			   
					    		</table>
	                    	
	                    	</td>
	                    </tr>

	                 </table> 
	                 
	                 <input id="txtb_budm_count<?=$time?>" name="content[budm_count]" oaname="content[budm_count]" type="hidden" />
	                 <input id="txtb_budm_css<?=$time?>" name="content[budm_css]" oaname="content[budm_css]" type="hidden" />
	                 
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
						op_id: '<?=$budm_id?>',
						table: 'fm_bud_main',
						field: 'budm_id',
						time: 'log_<?=$time?>'
       				 }"
       	>
       	
    </div>
    
</div>

<!-- loading -->
<div id="win_loading<?=$time?>" style="padding:5px;overflow:hidden;"></div> 