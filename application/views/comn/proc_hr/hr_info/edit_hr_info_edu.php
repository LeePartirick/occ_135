					<table  id = "table_edu<?=$time?>" style="width:1000px;margin:0 auto;">
						<tr class="set_width"> 
	                    	<td style="width:100px"></td> 
                            <td style="width:600px"></td> 
                            <td style="width:100px"></td> 
                            <td style="width:200px"></td> 
	                    </tr> 
	                    
	                    <tr class="tr_title" > 
	                    	<td colspan="4" style="height:35px;vertical-align:text-center;"  > 
	                    		<span>教育信息</span>
	                    	</td>
	                    </tr>
	                   <tr>
	                   		<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	毕业学校
                            </td>
                            <td style="height:35px;vertical-align:text-center;"  colspan="1">
								<input name="content[c_school]"
									   oaname="content[c_school]"
									   class="easyui-textbox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'100%',
													 validType:['length[0,200]','errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                            </td>
                            <td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	毕业时间
                            </td>
                            <td style="height:35px;vertical-align:text-center;"  colspan="1">
								<input name="content[c_time_graduate]"
									   oaname="content[c_time_graduate]"
									   class="easyui-datebox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                            </td>
                       </tr>    
                       <tr>
	                   		<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	专业
                            </td>
                            <td style="height:35px;vertical-align:text-center;"  colspan="1">
								<input name="content[c_zy]"
									   oaname="content[c_zy]"
									   class="easyui-textbox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'100%',
													 validType:['length[0,200]','errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                            </td>
                       </tr>    
                       
                        <tr oaname="title_hr_edu" class="tr_title oa_op"> 
	                    	<td colspan="3" style="height:35px;vertical-align:text-center;"  > 
	                    		<span>教育经历(从高中学历开始)</span>
	                    	</td>
	                    	<td colspan="1" style="height:35px;text-align:right"  >
	                    		
	                    		<a href="javascript:void(0);" 
	                    		   class="sui-btn btn-bordered btn-small btn-primary" 
	                    		   onClick="fun_tr_title_show($('#table_f_<?=$time?>'),'title_hr_edu','','collapse');$(this).hide();$(this).next().show();"
	                    		   >
	                    		   <i class="sui-icon icon-tb-fold"></i>
	                    		</a>
	                    		
	                    		<a href="javascript:void(0);" 
	                    		   class="sui-btn btn-bordered btn-small btn-primary" 
	                    		   onClick="fun_tr_title_show($('#table_f_<?=$time?>'),'title_hr_edu','show','collapse');$(this).hide();$(this).prev().show();"
	                    		   style="display:none;"
	                    		   >
	                    		   <i class="sui-icon icon-tb-unfold"></i>
	                    		</a>
	                    		
	                    	</td>
	                    </tr>
	                    
	                    <tr>
	                    	<td colspan="4" style="height:35px;vertical-align:text-center;padding-top:10px;"  > 
	                    		<div id="table_hr_edu_tool<?=$time?>">
									<table style="width:100%;">
										<tr>
											<td style="width:'50%';" >
												<a href="javascript:void(0)" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-add',plain:true" onClick="fun_table_hr_edu_operate<?=$time?>('add')">添加</a>
												<a href="javascript:void(0)" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-remove',plain:true" onClick="fun_table_hr_edu_operate<?=$time?>('del')">删除</a>
											</td>

										</tr>
									</table>
								</div>
								<table id="table_hr_edu<?=$time?>"
									   name="content[hr_edu]"
									   oaname="content[hr_edu]"
									   class="oa_input data_table"
								>
								</table>
										
	                    	</td>
	                    </tr> 
                       
					</table>
