						<table id="table_bp_<?=$time?>" style="width:800px;margin:0 auto;">
						  <tr class="set_width"> 
					       		<td style="width:120px;"></td>
	                            <td style="width:280px;"></td>
		                        <td style="width:120px;"></td>
	                            <td style="width:280px;"></td>
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
                            	<span name="content[gfc_org_s]" 
					    			  oaname="content[gfc_org_s]"
					    			  class="oa_input"
					    			>
					    		</span>
                            </td>
	                    </tr>

						<tr>
							<td class="field_s oa_op" style="height:35px;vertical-align:text-center;">
								项目全称
							</td>
							<td class="oa_op" oaname="content[gfc_name]" style="height:35px;vertical-align:text-center;" colspan="3">
								<span name="content[gfc_name]" 
					    			  oaname="content[gfc_name]"
					    			  class="oa_input"
					    			>
					    		</span>
							</td>

						</tr>
						
						<tr>
	                    	<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	甲方单位
                            </td>
                            <td style="height:35px;vertical-align:text-center;"  colspan="3"> 
                            	<span name="content[gfc_org_jia_s]" 
					    			  oaname="content[gfc_org_jia_s]"
					    			  class="oa_input"
					    			>
					    		</span>
                            </td>
	                    </tr>
	                    
	                    <tr>
	                    	<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	合同总额
                            </td>
                            <td style="height:35px;vertical-align:text-center;"  > 
                            	<input id="txtb_gfc_bp_sum<?=$time?>"
                            		   name = "content[gfc_bp_sum]"
                            		   oaname = "content[gfc_bp_sum]"
					    			   class="easyui-numberbox oa_input"
					    			   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
					    			   				 precision:2,
					    			   				 min:0,
					    			   				 groupSeparator:',',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 fun_ready: 'load_gfc_bp_sum<?=$time?>()'
													 ">
                            </td>
                            
                            <td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	未分解金额
                            </td>
                            <td style="height:35px;vertical-align:text-center;"  > 
                            	<input id="txtb_gfc_bp_sum_remain<?=$time?>"
                            		   name = "content[gfc_bp_sum_remain]"
                            		   oaname = "content[gfc_bp_sum_remain]"
					    			   class="easyui-numberbox oa_input"
					    			   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
					    			   				 precision:2,
					    			   				 groupSeparator:',',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 fun_ready: 'load_gfc_bp_sum_remain<?=$time?>()'
													 ">
                            </td>
							
	                    </tr>
	                    
	                    <tr>
	                    	<td class="field_s" style="height:35px;text-align: left">
								是否开票
							</td>
							<td style="height:35px;vertical-align:text-center;" >
								<input name="content[gfc_category_bill]"
									   oaname="content[gfc_category_bill]"
									   id="txtb_gfc_category_bill<?=$time?>"
									   class="easyui-combobox oa_input"
									   data-options="err:err,
					    			   				 limitToList:true,
					    			   				 valueField:'id',    
						    						 textField:'text',
					    			   				 height:'25',
					    			   				 width:'200px',
					    			   				 multiline:false,
					    			   				 data: [<?=element('gfc_category_bill',$json_field_define)?>],
					    			   				 panelHeight:'auto',
					    			   				 panelMaxHeight:120,
					    			   				 panelWidth:'',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
							</td>
	                    </tr>
	                    
	                    <tr>
	                    	<td colspan="4" style="height:35px;vertical-align:text-center;padding-top:10px;"  > 
	                    		<div id="gfc_bp_prog<?=$time?>"
	                    		     class="easyui-progressbar oa_input" 
	                    		     name = "content[gfc_bp_prog]"
                            		 oaname = "content[gfc_bp_prog]"
	                    		     style="width:100%;"></div> 
	                    	</td>
	                    </tr>
	                    
	                    <tr>
	                    	<td colspan="4" style="height:35px;vertical-align:text-center;padding-top:10px;"  > 
	                    		<div id="table_gfc_bp_tool<?=$time?>">
									<table style="width:100%;">
										<tr>
											<td style="width:'50%';" >
												<a href="javascript:void(0)" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-add',plain:true" onClick="fun_table_gfc_bp_operate<?=$time?>('add')">添加</a>
												<a href="javascript:void(0)" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-remove',plain:true" onClick="fun_table_gfc_bp_operate<?=$time?>('del')">删除</a>
											</td>

										</tr>
									</table>
								</div>
								<table id="table_gfc_bp<?=$time?>"
									   name="content[gfc_bp]"
									   oaname="content[gfc_bp]"
									   class="oa_input data_table"
								>
								</table>
										
	                    	</td>
	                    </tr> 
	                    
				</table> 
				
