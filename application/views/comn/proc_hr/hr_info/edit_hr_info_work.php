					<table  id = "table_work<?=$time?>" style="width:1000px;margin:0 auto;">
						<tr class="set_width"> 
	                    	<td style="width:900px"></td> 
                            <td style="width:100px"></td> 
	                    </tr> 
	                    
                        <tr oaname="title_hr_work" class="tr_title oa_op"> 
	                    	<td colspan="1" style="height:35px;vertical-align:text-center;"  > 
	                    		<span>工作经历(不包括实习与兼职)</span>
	                    	</td>
	                    	<td colspan="1" style="height:35px;text-align:right"  >
	                    		
	                    		<a href="javascript:void(0);" 
	                    		   class="sui-btn btn-bordered btn-small btn-primary" 
	                    		   onClick="fun_tr_title_show($('#table_f_<?=$time?>'),'title_hr_work','','collapse');$(this).hide();$(this).next().show();"
	                    		   >
	                    		   <i class="sui-icon icon-tb-fold"></i>
	                    		</a>
	                    		
	                    		<a href="javascript:void(0);" 
	                    		   class="sui-btn btn-bordered btn-small btn-primary" 
	                    		   onClick="fun_tr_title_show($('#table_f_<?=$time?>'),'title_hr_work','show','collapse');$(this).hide();$(this).prev().show();"
	                    		   style="display:none;"
	                    		   >
	                    		   <i class="sui-icon icon-tb-unfold"></i>
	                    		</a>
	                    		
	                    	</td>
	                    </tr>
	                    
	                    <tr>
	                    	<td colspan="2" style="height:35px;vertical-align:text-center;padding-top:10px;"  > 
	                    		<div id="table_c_work_tool<?=$time?>">
									<table style="width:100%;">
										<tr>
											<td style="width:'50%';" >
												<a href="javascript:void(0)" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-add',plain:true" onClick="fun_table_c_work_operate<?=$time?>('add')">添加</a>
												<a href="javascript:void(0)" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-remove',plain:true" onClick="fun_table_c_work_operate<?=$time?>('del')">删除</a>
											</td>

										</tr>
									</table>
								</div>
								<table id="table_c_work<?=$time?>"
									   name="content[hr_work]"
									   oaname="content[hr_work]"
									   class="oa_input data_table"
								>
								</table>
										
	                    	</td>
	                    </tr> 
                       
					</table>