					<table  id = "table_doc<?=$time?>" style="width:1000px;margin:0 auto;">
						<tr class="set_width"> 
	                    	<td style="width:170px"></td> 
                            <td style="width:210px"></td> 
	                        <td style="width:100px"></td> 
                            <td style="width:210px"></td> 
                            <td style="width:100px"></td> 
                            <td style="width:210px"></td> 
	                    </tr> 
	                    
	                    <tr class="tr_title" > 
	                    	<td colspan="6" style="height:35px;vertical-align:text-center;"  > 
	                    		<span>档案信息</span>
	                    	</td>
	                    </tr>
                       <tr>
	                   		<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	档案编码
                            </td>
                            <td style="height:35px;vertical-align:text-center;" >
                                <input name="content[c_doc_code]"
                                       oaname="content[c_doc_code]"
                                       class="easyui-numberbox oa_input"
                                       data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
													 validType:['length[0,40]','errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                            </td>
                             <td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	档案经办人
                            </td>
                            <td style="height:35px;vertical-align:text-center;" >
                                <input name="content[c_doc_person]"
                                       oaname="content[c_doc_person]"
                                       class="easyui-textbox oa_input"
                                       data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
													 validType:['length[0,80]','errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">

                            </td>
                            <td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	联系方式
                            </td>
                            <td style="height:35px;vertical-align:text-center;" >
                                <input name="content[c_doc_person_tele]"
                                       oaname="content[c_doc_person_tele]"
                                       class="easyui-numberbox oa_input"
                                       data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
													 validType:['length[0,20]','errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">

                            </td>
                       </tr>  
                       <tr>
	                   		<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	档案所在机构
                            </td>
                            <td style="height:35px;vertical-align:text-center;"  colspan="3">
                                <input name="content[c_doc_org]"
                                       oaname="content[c_doc_org]"
                                       class="easyui-textbox oa_input"
                                       data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'100%',
													 validType:['length[0,200]','errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                            </td>
                             <td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	机构邮编
                            </td>
                            <td style="height:35px;vertical-align:text-center;" >
                                <input name="content[c_doc_addr_postcode]"
                                       oaname="content[c_doc_addr_postcode]"
                                       class="easyui-textbox oa_input"
                                       data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
													 validType:['length[0,20]','errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                            </td>
                       </tr>    
                       <tr>
	                   		<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	档案机构地址
                            </td>
                            <td style="height:35px;vertical-align:text-center;"  colspan="5">
                                <input name="content[c_doc_addr]"
                                       oaname="content[c_doc_addr]"
                                       class="easyui-textbox oa_input"
                                       data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'100%',
													 validType:['length[0,200]','errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                            </td>
                       </tr>  
                       
                       
					</table>
