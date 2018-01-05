						<table id="table_el_<?=$time?>" style="width:800px;margin:0 auto;">
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
                               	财务编号
                            </td>
                            <td style="height:35px;vertical-align:text-center;"  colspan="3"> 
                            	<span name="content[gfc_finance_code]" 
					    			  oaname="content[gfc_finance_code]"
					    			  class="oa_input"
					    			>
					    		</span>
                            </td>
	                    </tr>
	                    
	                    <tr>
	                    	<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	项目负责人
                            </td>
                            <td style="height:35px;vertical-align:text-center;"  > 
                            	<span name="content[gfc_c_s]" 
					    			  oaname="content[gfc_c_s]"
					    			  class="oa_input"
					    			>
					    		</span>   
                            </td>
                            <td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	部门
                            </td>
                            <td style="height:35px;vertical-align:text-center;"  > 
                            	<span name="content[gfc_ou_s]" 
					    			  oaname="content[gfc_ou_s]"
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
                            	<span name="content[gfc_sum]" 
					    			  oaname="content[gfc_sum]"
					    			  class="oa_input"
					    			>
					    		</span>  
                            </td>
							<td class="field_s" style="height:35px;text-align: left">
								项目性质
							</td>
							<td style="height:35px;vertical-align:text-center;" >
								<span name="content[gfc_category_main]" 
					    			  oaname="content[gfc_category_main]"
					    			  class="oa_input"
					    			>
					    		</span> 
							</td>
							
						</tr>
						
						<tr>
	                    	<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	设备清单版本
                            </td>
                            <td style="height:35px;vertical-align:text-center;"  colspan="3"> 
                            	<span name="content[gfc_el_verson]" 
					    			  oaname="content[gfc_el_verson]"
					    			  class="oa_input"
					    			>
					    		</span>
                            </td>
	                    </tr>
	                    
	                     <tr class="tr_title">
	                    	<td colspan="4" style="height:35px;text-align:left"  >
	                    		<span>设备清单</span>
	                    	</td>
	                     </tr>
	                    
	                    <tr>
	                    	<td colspan="4" style="height:35px;vertical-align:text-center;padding-top:10px;"  > 
								<div id="table_gfc_eli_tool<?=$time?>">
									<table style="width:100%;">
										<tr>
											<td style="width:'50%';" >
												<a href="javascript:void(0)" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-add',plain:true" onClick="fun_table_gfc_eli_operate<?=$time?>('add')">添加</a>
												<a href="javascript:void(0)" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-xlsx',plain:true" onClick="fun_xlsx_import('proc_gfc/m_eli','设备清单明细','proc_gfc/eli/import/fun_no_db/fun_no_db_table_gfc_eli<?=$time?>')">导入</a>
												<a href="javascript:void(0)" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-remove',plain:true" onClick="fun_table_gfc_eli_operate<?=$time?>('del')">删除</a>
											</td>

										</tr>
									</table>
								</div>
								<table id="table_gfc_eli<?=$time?>"
									   name="content[gfc_eli]"
									   oaname="content[gfc_eli]"
									   class="oa_input data_table"
									   style="max-height:300px;"
								>
								</table>
										
	                    	</td>
	                    </tr> 
				</table> 
				
