					<table  id = "table_card<?=$time?>" style="width:1000px;margin:0 auto;">
						<tr class="set_width"> 
	                    	<td style="width:130px"></td> 
                            <td style="width:223px"></td> 
	                        <td style="width:100px"></td> 
                            <td style="width:223px"></td> 
                            <td style="width:100px"></td> 
                            <td style="width:223px"></td> 
	                    </tr> 
	                    
	                    <tr class="tr_title" > 
	                    	<td colspan="6" style="height:35px;vertical-align:text-center;"  > 
	                    		<span>卡帐信息(银行卡、公积金账号等)</span>
	                    	</td>
	                    </tr>
	                   <tr>
	                   		<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	银行卡类别
                            </td>
                            <td style="height:35px;vertical-align:text-center;"  > 
                            	<input name="content[c_bank_type]" 
					    			   oaname="content[c_bank_type]"
                                       id='txtb_c_bank_type<?=$time?>'
					    			   class="easyui-combobox oa_input"
					    			   data-options="err:err,
					    			   				 limitToList:true,
					    			   				 valueField:'id',    
						    						 textField:'text',
					    			   				 height:'25',
					    			   				 width:'200px',
					    			   				 multiline:false,
					    			   				 data: [<?=element('c_bank_type',$json_field_define)?>],
					    			   				 panelHeight:'auto',
					    			   				 panelMaxHeight:120,
					    			   				 panelWidth:'',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 loadFilter:function(data)
													 {
													 	var value = $(this).combobox('getValue');
													 	var data_new = [];
													 	var arr = [1,2,3];
													 	
								    					for(var i =0;i < data.length;i++)
								    					{
								    						if(arr.indexOf( parseInt(data[i].id) ) > -1 || value == data[i].id)
								    						{
								    							data_new.push(data[i]);
								    						}
								    					}
								    					
								    					return data_new;
													 },
													 ">
                            </td>
                            <td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	银行卡号
                            </td>
                            <td style="height:35px;vertical-align:text-center;"  > 
                            	<input name="content[c_bank]" 
					    			   oaname="content[c_bank]"
					    			   class="easyui-textbox oa_input"
					    			   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
													 validType:['length[0,80]','errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                            </td>
                       </tr>    
                       
                       <tr oaname="title_hr_card" class="tr_title oa_op"> 
	                    	<td colspan="5" style="height:35px;vertical-align:text-center;"  > 
	                    		<span>其他卡帐信息</span>
	                    	</td>
	                    	<td colspan="1" style="height:35px;text-align:right"  >
	                    		
	                    		<a href="javascript:void(0);" 
	                    		   class="sui-btn btn-bordered btn-small btn-primary" 
	                    		   onClick="fun_tr_title_show($('#table_f_<?=$time?>'),'title_hr_card','','collapse');$(this).hide();$(this).next().show();"
	                    		   >
	                    		   <i class="sui-icon icon-tb-fold"></i>
	                    		</a>
	                    		
	                    		<a href="javascript:void(0);" 
	                    		   class="sui-btn btn-bordered btn-small btn-primary" 
	                    		   onClick="fun_tr_title_show($('#table_f_<?=$time?>'),'title_hr_card','show','collapse');$(this).hide();$(this).prev().show();"
	                    		   style="display:none;"
	                    		   >
	                    		   <i class="sui-icon icon-tb-unfold"></i>
	                    		</a>
	                    		
	                    	</td>
	                    </tr>
	                    
	                    <tr>
	                    	<td colspan="6" style="height:35px;vertical-align:text-center;padding-top:10px;"  > 
	                    		<div id="table_hr_card_tool<?=$time?>">
									<table style="width:100%;">
										<tr>
											<td style="width:'50%';" >
												<a href="javascript:void(0)" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-add',plain:true" onClick="fun_table_hr_card_operate<?=$time?>('add')">添加</a>
												<a href="javascript:void(0)" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-remove',plain:true" onClick="fun_table_hr_card_operate<?=$time?>('del')">删除</a>
											</td>

										</tr>
									</table>
								</div>
								<table id="table_hr_card<?=$time?>"
									   name="content[hr_card]"
									   oaname="content[hr_card]"
									   class="oa_input data_table"
								>
								</table>
										
	                    	</td>
	                    </tr> 
                       
					</table>
