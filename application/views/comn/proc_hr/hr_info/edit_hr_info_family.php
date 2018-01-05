					<table  id = "table_family<?=$time?>" style="width:1000px;margin:0 auto;">
						<tr class="set_width"> 
	                    	<td style="width:150px"></td> 
	                    	<td style="width:550px"></td>
	                    	<td style="width:200px"></td> 
	                    </tr> 
	                    
	                    <tr oaname="title_hr_family" class="tr_title oa_op"> 
	                    	<td colspan="2" style="height:35px;vertical-align:text-center;"  > 
	                    		<span>家庭信息</span>
	                    	</td>
	                    	<td colspan="1" style="height:35px;text-align:right"  >
	                    		
	                    		<a href="javascript:void(0);" 
	                    		   class="sui-btn btn-bordered btn-small btn-primary" 
	                    		   onClick="fun_tr_title_show($('#table_f_<?=$time?>'),'title_hr_family','','collapse');$(this).hide();$(this).next().show();"
	                    		   >
	                    		   <i class="sui-icon icon-tb-fold"></i>
	                    		</a>
	                    		
	                    		<a href="javascript:void(0);" 
	                    		   class="sui-btn btn-bordered btn-small btn-primary" 
	                    		   onClick="fun_tr_title_show($('#table_f_<?=$time?>'),'title_hr_family','show','collapse');$(this).hide();$(this).prev().show();"
	                    		   style="display:none;"
	                    		   >
	                    		   <i class="sui-icon icon-tb-unfold"></i>
	                    		</a>
	                    		
	                    	</td>
	                    </tr>
	                    
	                    <tr>
	                    	<td colspan="3" style="height:35px;vertical-align:text-center;padding-top:10px;"  > 
	                    		<div id="table_hr_family_tool<?=$time?>">
									<table style="width:100%;">
										<tr>
											<td style="width:'50%';" >
												<a href="javascript:void(0)" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-add',plain:true" onClick="fun_table_hr_family_operate<?=$time?>('add')">添加</a>
												<a href="javascript:void(0)" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-remove',plain:true" onClick="fun_table_hr_family_operate<?=$time?>('del')">删除</a>
											</td>

										</tr>
									</table>
								</div>
								<table id="table_hr_family<?=$time?>"
									   name="content[hr_family]"
									   oaname="content[hr_family]"
									   class="oa_input data_table"
								>
								</table>
										
	                    	</td>
	                    </tr> 
	                    
	                    <tr>
	                   		<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	家庭成员犯罪记录
                            </td>
                            <td style="height:35px;vertical-align:text-center;"  >
								<input name="content[c_family_crime]"
									   oaname="content[c_family_crime]"
									   class="easyui-combobox oa_input"
									   data-options="err:err,
					    			   				 limitToList:true,
					    			   				 valueField:'id',
						    						 textField:'text',
					    			   				 height:'25',
					    			   				 width:'100',
					    			   				 multiline:false,
					    			   				 data: [<?=element('f_have',$json_field_define)?>],
					    			   				 panelHeight:'auto',
					    			   				 panelMaxHeight:120,
					    			   				 panelWidth:'',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 onSelect: function(record)
													 {
													 	if(record.id == 2)
													 	{
													 		$('#tr_hr_family_crime<?=$time?>').show();
													 	}
													 	else
													 	{
													 		$('#tr_hr_family_crime<?=$time?>').hide();
													 	}
													 }
													 ">
								<span>若有则添加</span>						 
                            </td>
                        </tr>
                        
                        <tr id="tr_hr_family_crime<?=$time?>">
	                    	<td colspan="3" style="height:35px;vertical-align:text-center;padding-top:10px;"  > 
	                    		<div id="table_hr_family_crime_tool<?=$time?>">
									<table style="width:100%;">
										<tr>
											<td style="width:'50%';" >
												<a href="javascript:void(0)" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-add',plain:true" onClick="fun_table_hr_family_crime_operate<?=$time?>('add')">添加</a>
												<a href="javascript:void(0)" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-remove',plain:true" onClick="fun_table_hr_family_crime_operate<?=$time?>('del')">删除</a>
											</td>

										</tr>
									</table>
								</div>
								<table id="table_hr_family_crime<?=$time?>"
									   name="content[hr_family_crime]"
									   oaname="content[hr_family_crime]"
									   class="oa_input data_table"
								>
								</table>
										
	                    	</td>
	                    </tr> 
	                    
                         <tr>
	                   		<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	家庭成员港澳台居住证
                            </td>
                            <td style="height:35px;vertical-align:text-center;"  >
								<input name="content[c_family_gat]"
									   oaname="content[c_family_gat]"
									   class="easyui-combobox oa_input"
									   data-options="err:err,
					    			   				 limitToList:true,
					    			   				 valueField:'id',
						    						 textField:'text',
					    			   				 height:'25',
					    			   				 width:'100',
					    			   				 multiline:false,
					    			   				 data: [<?=element('f_have',$json_field_define)?>],
					    			   				 panelHeight:'auto',
					    			   				 panelMaxHeight:120,
					    			   				 panelWidth:'',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 onSelect: function(record)
													 {
													 	if(record.id == 2)
													 	{
													 		$('#tr_hr_family_card_gat<?=$time?>').show();
													 	}
													 	else
													 	{
													 		$('#tr_hr_family_card_gat<?=$time?>').hide();
													 	}
													 }
													 ">
								<span>若有则添加</span>						 
                            </td>
                        </tr>
                        
                        <tr id="tr_hr_family_card_gat<?=$time?>">
	                    	<td colspan="3" style="height:35px;vertical-align:text-center;padding-top:10px;"  > 
	                    		<div id="table_hr_family_card_gat_tool<?=$time?>">
									<table style="width:100%;">
										<tr>
											<td style="width:'50%';" >
												<a href="javascript:void(0)" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-add',plain:true" onClick="fun_table_hr_family_card_gat_operate<?=$time?>('add')">添加</a>
												<a href="javascript:void(0)" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-remove',plain:true" onClick="fun_table_hr_family_card_gat_operate<?=$time?>('del')">删除</a>
											</td>

										</tr>
									</table>
								</div>
								<table id="table_hr_family_card_gat<?=$time?>"
									   name="content[hr_family_card_gat]"
									   oaname="content[hr_family_card_gat]"
									   class="oa_input data_table"
								>
								</table>
										
	                    	</td>
	                    </tr> 
                        
                         <tr>
	                   		<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	家庭成员国外绿卡
                            </td>
                            <td style="height:35px;vertical-align:text-center;"  >
								<input name="content[c_family_foreign]"
									   oaname="content[c_family_foreign]"
									   class="easyui-combobox oa_input"
									   data-options="err:err,
					    			   				 limitToList:true,
					    			   				 valueField:'id',
						    						 textField:'text',
					    			   				 height:'25',
					    			   				 width:'100',
					    			   				 multiline:false,
					    			   				 data: [<?=element('f_have',$json_field_define)?>],
					    			   				 panelHeight:'auto',
					    			   				 panelMaxHeight:120,
					    			   				 panelWidth:'',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 onSelect: function(record)
													 {
													 	if(record.id == 2)
													 	{
													 		$('#tr_hr_family_card<?=$time?>').show();
													 	}
													 	else
													 	{
													 		$('#tr_hr_family_card<?=$time?>').hide();
													 	}
													 }
													 ">
								<span>若有则添加</span>
                            </td>
                        </tr>
                        
                        <tr id="tr_hr_family_card<?=$time?>">
	                    	<td colspan="3" style="height:35px;vertical-align:text-center;padding-top:10px;"  > 
	                    		<div id="table_hr_family_card_tool<?=$time?>">
									<table style="width:100%;">
										<tr>
											<td style="width:'50%';" >
												<a href="javascript:void(0)" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-add',plain:true" onClick="fun_table_hr_family_card_operate<?=$time?>('add')">添加</a>
												<a href="javascript:void(0)" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-remove',plain:true" onClick="fun_table_hr_family_card_operate<?=$time?>('del')">删除</a>
											</td>

										</tr>
									</table>
								</div>
								<table id="table_hr_family_card<?=$time?>"
									   name="content[hr_family_card]"
									   oaname="content[hr_family_card]"
									   class="oa_input data_table"
								>
								</table>
										
	                    	</td>
	                    </tr> 
                       
					</table>
