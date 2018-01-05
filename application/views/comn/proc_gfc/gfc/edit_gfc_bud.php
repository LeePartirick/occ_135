						<table id="table_bud_<?=$time?>" style="width:800px;margin:0 auto;">
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
	                    	<td class="field_s" style="height:35px;text-align: left">
								项目开始时间
							</td>
							<td style="height:35px;vertical-align:text-center;" >
								<input name="content[gfc_start_time_sign]" 
					    			   oaname="content[gfc_start_time_sign]"
					    			   class="easyui-datebox oa_input"
					    			   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200px',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
							</td>
                            
                            <td class="field_s" style="height:35px;text-align: left">
								项目完工时间
							</td>
							<td style="height:35px;vertical-align:text-center;" >
								<input name="content[gfc_complet_time_sign]" 
					    			   oaname="content[gfc_complet_time_sign]"
					    			   class="easyui-datebox oa_input"
					    			   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200px',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
							</td>
							
	                    </tr>
	                    
	                    <tr class="tr_title">
	                    	<td colspan="4" style="height:35px;text-align:left"  >
	                    		<span>预算表</span>
	                    	</td>
	                     </tr>
	                    
	                    <tr>
	                    	<td class="field_s" style="height:35px;text-align: left">
								预算表
							</td>
							<td style="height:35px;vertical-align:text-center;" >
								<input name="content[gfc_budm_id]" 
					    			   oaname="content[gfc_budm_id]"
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
					    			   				 url_l:'proc_bud/budm/get_json/from/combobox/field_id/budm_id/field_text/budm_name',
					    			   				 panelWidth:'',
					    			   				 onChange: function(newValue,oldValue)
					    			   				 {
					    			   				 	if(newValue)
					    			   				 	{
					    			   				 		$('#table_gfc_bud<?=$time?>').datagrid('reload','proc_bud/budi/get_json/budm_id/'+newValue);
					    			   				 	}
					    			   				 },
					    			   				 onSelect: function(record)
					    			   				 {
					    			   				 	var budm_count = base64_decode(record.budm_count);
					    			   				 	
					    			   				 	$('#txtb_budm_count<?=$time?>').val(budm_count);
					    			   				 	
					    			   				 },
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
								<input id="txtb_budm_count<?=$time?>" 
									   name="content[budm_count]"
									   oaname="content[budm_count]"
									   class="oa_input"
									   type="hidden" >	
								<input id="txtb_budm_tax_type<?=$time?>" 
									   name="content[budm_tax_type]"
									   oaname="content[budm_tax_type]"
									   class="oa_input"
								       type="hidden">	
								 <input id="txtb_gfc_tax<?=$time?>" 
									   name="content[gfc_tax]"
									   oaname="content[gfc_tax]"
									   class="oa_input"
								       type="hidden">	
								  <input id="txtb_gfc_tax_name<?=$time?>" 
									   name="content[gfc_tax_name]"
									   oaname="content[gfc_tax_name]"
									   class="oa_input"
								       type="hidden">				 
							</td>
                            
                            <td class="field_s" style="height:35px;text-align: left">
								预算表版本
							</td>
							<td style="height:35px;vertical-align:text-center;" >
								<span name="content[gfc_bud_verson]" 
					    			  oaname="content[gfc_bud_verson]"
					    			  class="oa_input"
					    			>
					    		</span> 
							</td>
							
	                    </tr>
	                    
	                    <tr>
	                    	<td colspan="4" style="height:35px;vertical-align:text-center;padding-top:10px;"  > 
								<table id="table_gfc_bud<?=$time?>"
									   name="content[gfc_bud]"
									   oaname="content[gfc_bud]"
									   class="oa_input data_table"
								>
								</table>
								
										
	                    	</td>
	                    </tr> 
	                    
	                    <tr style="display:none">
	                    	<td colspan="4" style="height:35px;vertical-align:text-center;padding-top:10px;"  > 
	                    		<table id="table_gfc_bud_sum<?=$time?>"
									   name="content[gfc_bud_sum]"
									   oaname="content[gfc_bud_sum]"
									   class="oa_input data_table"
								>
								</table>
	                    	</td>
	                    </tr>
	                    
				</table> 
				
