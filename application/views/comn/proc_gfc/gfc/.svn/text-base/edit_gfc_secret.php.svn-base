						<table id="table_secret_<?=$time?>" style="width:800px;margin:0 auto;">
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
	                    	<td class="field_s" style="height:35px;text-align: left">
								项目负责人
							</td>
							<td style="height:35px;vertical-align:text-center;">
								<span name="content[gfc_c_s]" 
					    			  oaname="content[gfc_c_s]"
					    			  class="oa_input"
					    			>
					    		</span>
							</td>
							<td class="field_s" style="height:35px;text-align: left">
								项目密级
							</td>
							<td style="height:35px;vertical-align:text-center;">
								<span name="content[gfc_category_secret]" 
					    			  oaname="content[gfc_category_secret]"
					    			  class="oa_input"
					    			>
					    		</span>
							</td>
	                    </tr>
	                    
	                    <tr id="tr_gfcs_tm_name<?=$time?>">
							<td class="field_s oa_op" oaname="content[gfc_name_tm]" style="height:35px;vertical-align:text-center;">
								脱密后项目全称
							</td>
							<td class="oa_op" oaname="content[gfc_name_tm]" style="height:35px;vertical-align:text-center;" colspan="3">
								<input name="content[gfc_name_tm]"
									   oaname="content[gfc_name_tm]"
									   class="easyui-textbox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'100%',
					    			   				 multiline:false,
													 validType:['length[0,250]','errMsg[\'#hd_err_f_<?=$time?>\']'],
													 "
								>
							</td>

						</tr>
						
						<tr>
							<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	审批人
                            </td>
                            <td style="height:35px;vertical-align:text-center;"  colspan="3"> 
                            	<input name="content[gfcs_c_check]" 
					    			   oaname="content[gfcs_c_check]"
					    			   id="txtb_gfcs_c_check<?=$time?>"
					    			   class="easyui-combobox oa_input"
					    			   data-options="err:err,
					    			   				 valueField:'id',    
						    						 textField:'text',
					    			   				 height:'25',
					    			   				 width:'200',
					    			   				 multiline:false,
					    			   				 panelHeight:'auto',
					    			   				 panelMaxHeight:120,
					    			   				 limitToList:true,
					    			   				 url_l:'base/auto/get_json_contact/from/combobox/field_id/c_id/field_text/c_show/search_c_login_id/1/fun_p/proc_gfc/fun_m/m_gfc_secret/fun_f/search_gfcs_c_check',
					    			   				 panelWidth:'',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
								<a href="javascript:void(0)" oaname="btn_gfcs" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-search'" onClick="fun_win_gfcs_open<?=$time?>()">标密申请单</a>
							</td>	
						
						</tr>
	                    
				</table> 
				
