						<table id="table_cr_<?=$time?>" style="width:800px;margin:0 auto;">
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
							<td class="field_s oa_op"  style="height:35px;vertical-align:text-center;">
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
							
							<td class="field_s" style="height:35px;text-align: left">
								附加属性
							</td>
							<td style="height:35px;vertical-align:text-center;" >
								<span name="content[gfc_category_extra]" 
					    			  oaname="content[gfc_category_extra]"
					    			  class="oa_input"
					    			>
					    		</span> 
							</td>

						</tr>
						
						 <tr>
							<td class="field_s" style="height:35px;text-align: left">
								附加属性2
							</td>
							<td style="height:35px;vertical-align:text-center;" >
								<span name="content[gfc_category_statistic]" 
					    			  oaname="content[gfc_category_statistic]"
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
                            	<input id="txtb_gfc_cr_sum<?=$time?>"
                            		   name = "content[gfc_cr_sum]"
                            		   oaname = "content[gfc_cr_sum]"
					    			   class="easyui-numberbox oa_input"
					    			   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
					    			   				 precision:2,
					    			   				 min:0,
					    			   				 groupSeparator:',',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 fun_ready: 'load_gfc_cr_sum<?=$time?>()'
													 ">
                            </td>
                            
                            <td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	预计成本
                            </td>
                            <td style="height:35px;vertical-align:text-right;"  > 
                            	<input id="txtb_gfc_cr_sum_cb<?=$time?>"
                            		   name = "content[gfc_cr_sum_cb]"
                            		   oaname = "content[gfc_cr_sum_cb]"
					    			   class="easyui-numberbox oa_input"
					    			   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
					    			   				 precision:2,
					    			   				 groupSeparator:',',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 fun_ready: 'load_gfc_cr_sum_cb<?=$time?>()'
													 ">
                            </td>
							
	                    </tr>
	                    <tr>
	                     	<td class="field_s" style="height:35px;text-align: left">
								预计签约时间
							</td>
							<td style="height:35px;vertical-align:text-center;" >
								<span name="content[gfc_pt_plan_sign]" 
					    			  oaname="content[gfc_pt_plan_sign]"
					    			  class="oa_input"
					    			>
					    		</span> 
							</td>
							<td class="field_s" style="height:35px;text-align: left">
								财务编号
							</td>
							<td style="height:35px;vertical-align:text-center;" >
								<span name="content[gfc_finance_code]" 
					    			  oaname="content[gfc_finance_code]"
					    			  class="oa_input"
					    			>
					    		</span> 
							</td>
						</tr>
						
						<tr>
	                    	<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	项目组成员
                            </td>
                            <td style="height:35px;vertical-align:text-center;"  colspan="3"> 
                            	<span name="content[pm_c_s]" 
					    			  oaname="content[pm_c_s]"
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
                               	甲方联系人
                            </td>
                            <td style="height:35px;vertical-align:text-center;"  > 
                            	<span name="content[gfc_c_jia_s]" 
					    			  oaname="content[gfc_c_jia_s]"
					    			  class="oa_input"
					    			>
					    		</span>
                            </td>
                            <td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	甲方联系电话
                            </td>
                            <td style="height:35px;vertical-align:text-center;"  > 
                            	<span name="content[gfc_c_jia_tel]" 
					    			  oaname="content[gfc_c_jia_tel]"
					    			  class="oa_input"
					    			>
					    		</span>
                            </td>
	                    </tr>
	                    
	                    <tr>
							<td class="field_s" style="height:35px;text-align: left">
								是否总分包合同
							</td>
							<td style="height:35px;vertical-align:text-center;" >
								<span name="content[gfc_category_subc]" 
					    			  oaname="content[gfc_category_subc]"
					    			  class="oa_input"
					    			>
					    		</span>
							</td>
							<td class="field_s" style="height:35px;text-align: left">
								分包金额
							</td>
							<td style="height:35px;vertical-align:text-right;" >
					    		<input id="txtb_gfc_subc_sum<?=$time?>"
                            		   name = "content[gfc_subc_sum]"
                            		   oaname = "content[gfc_subc_sum]"
					    			   class="easyui-numberbox oa_input"
					    			   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
					    			   				 precision:2,
					    			   				 groupSeparator:',',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 fun_ready: 'load_gfc_subc_sum<?=$time?>()'
													 ">
							</td>
						</tr>
						
						<tr>
							<td class="field_s" style="height:35px;text-align: left">
								版本
							</td>
							<td style="height:35px;vertical-align:text-center;" >
								<span name="content[gfc_cr_verson]" 
					    			  oaname="content[gfc_cr_verson]"
					    			  class="oa_input"
					    			>
					    		</span>
							</td>
						</tr>
						
						<tr class="tr_title oa_op" oaname = "title_cr_file">
	                    	<td colspan="4" style="height:35px;text-align:left"  >
	                    		<span>评审文件</span>
	                    	</td>
	                     </tr>
	                     
	                    <tr>
	                    	<td colspan="4" style="height:35px;vertical-align:text-center;padding-top:10px;"  > 
								<table id="table_gfc_cr_file<?=$time?>"
									   name="content[gfc_cr_file]"
									   oaname="content[gfc_cr_file]"
									   class="oa_input data_table">
								</table>
										
	                    	</td>
	                    </tr> 
	                    
	                    <tr class="tr_title">
	                    	<td colspan="4" style="height:35px;text-align:left"  >
	                    		<span>评审信息</span>
	                    	</td>
	                     </tr>
	                     
	                    <tr>
	                    	<td colspan="4" style="height:35px;vertical-align:text-center;padding-top:10px;"  > 
	                    		<div id="table_gfc_cr_tool<?=$time?>">
									<table style="width:100%;">
										<tr>
											<td style="width:'50%';" >
												<a href="javascript:void(0)" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-add',plain:true" onClick="fun_table_gfc_cr_operate<?=$time?>('add')">添加</a>
												<a href="javascript:void(0)" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-remove',plain:true" onClick="fun_table_gfc_cr_operate<?=$time?>('del')">删除</a>
											</td>

										</tr>
									</table>
								</div>
								<table id="table_gfc_cr<?=$time?>"
									   name="content[gfc_cr]"
									   oaname="content[gfc_cr]"
									   class="oa_input data_table"
								>
								</table>
										
	                    	</td>
	                    </tr> 
	                    
				</table> 
				
