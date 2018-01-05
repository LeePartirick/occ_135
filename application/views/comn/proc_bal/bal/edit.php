<div id="tab_edit_<?=$time?>" 
	 class="easyui-tabs" 
     data-options="fit:true,
    			   border:false,
    			   showHeader:false,
            	   tabWidth:150,
            	   onSelect: function(title,index)
            	   {
            	   		if( title == '操作日志' && $('#table_indexlog_<?=$time?>').length > 0)
            	   		{
            	   			$('#table_indexlog_<?=$time?>').datagrid('reload');
            	   		}
            	   }">
    <div title="费用报销" 
         style="">
         
        <div id="l_<?=$time?>" 
	   		class="easyui-layout" 
		 	data-options="fit:true">
		 	
		 	<div data-options="region:'north',border:false" 
		 		style="height:auto;padding-top:15px;overflow:hidden;">	
		 		<? if( ! empty($log_time) ){ ?>
		 		<center><span class="tb_title"><b>操作日志</b></span></center>
				<table style="width:1300px;margin:0 auto;" class="table_no_line">
	       			<tr>
	       				<td style="width:'33%';">
	       				<b>操作时间:</b> <?=$log_time?>
	       				</td>
	       				<td style="width:'33%';">
	       				<b>操作类型:</b> <?=$log_act?>
	       				</td>
	       				<td style="width:'34%';">
	       				<b>操作人:</b> <?=$log_c_name?>[<?=$log_a_login_id?>]
	       				</td>
	       			</tr>
	       			<tr>
	       				<td colspan="3">
	       				    <input class="easyui-textbox oa_input" 
		       						data-options="label:'<b>备注:</b>',
		       									  labelWidth:60,
												  multiline:true,
												  height:40,
												  readonly:true,
												  iconCls:'icon-lock'"
									value="<?=$log_note?>"
		       						style="width:100%"/>
	       				</td>
	       			</tr>
	       		</table>
		 		<br/>
		 		<? }?>
		 		<center><span class="tb_title"><b>费用报销</b></span></center>
		 		
		 		<table id="table_h_<?=$time?>" class="table_no_line"  style="width:1300px;margin:0 auto;">
		 			<tr>
		       			<td style="width:'50%';">
		       			<b><?=$code?></b>
		       			</td>
		       			<td style="width:'50%';text-align:right;">
		       			<b><?=$db_time_create?></b>
		       			</td>
		       		</tr>
		       		<tr>
		       			<td style="width:'50%';">
		       				<a href="javascript:void(0)" oaname="btn_save" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-save'" onClick="f_submit_<?=$time?>('save');">保存</a>  
		       				<a href="javascript:void(0)" oaname="btn_import" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-xlsx'" onClick="fun_xlsx_import('proc_bal/m_bal','费用报销','proc_bal/bal/import')">导入</a>  
		       				<a href="javascript:void(0)" oaname="btn_next" class="easyui-splitbutton oa_op" data-options="iconCls:'icon-next',menu:'#menu_btn_next<?=$time?>',plain:false" onClick="$.messager.confirm('确认','您确认想要<?=$ppo_btn_next?>吗？',function(r){if(r)f_submit_<?=$time?>('next');});"><?=$ppo_btn_next?></a>
		       				<a href="javascript:void(0)" oaname="btn_pnext" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-pnext'" onClick="$.messager.confirm('确认','您确认想要<?=$ppo_btn_pnext?>吗？',function(r){if(r)f_submit_<?=$time?>('pnext');});"><?=$ppo_btn_pnext?></a>
		       			</td>
		       			<td style="width:'50%';text-align:right;">
       	       				<a href="javascript:void(0)" oaname="btn_reload" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-reload'" onClick="$.messager.confirm('确认','您确认想要重置为初始数据吗？',function(r){if(r)load_form_data_<?=$time?>();});">重置</a>
		       				<a href="javascript:void(0)" oaname="btn_person" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-man'" onClick="fun_person_create($('#f_<?=$time?>'),'<?=$url_conf?>')">个性化</a>  
		       				<a href="javascript:void(0)" oaname="btn_log" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-log'" onClick="$('#tab_edit_<?=$time?>').tabs('select',1)">日志</a> 
		       				<a href="javascript:void(0)" oaname="btn_del" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-cancel'" onClick="$.messager.confirm('确认','您确认想要删除记录吗？',function(r){if(r)f_submit_<?=$time?>('del');});">删除</a>  
		       			</td>
		       		</tr>
		       		<tr>
		       			<td style="width:'100%';font-size:14px;" colspan="2">
		       			<b>当前节点:<?=$ppo_name;?></b>
		       			</td>
		       		</tr>
		       		<tr>
		       			<td style="width:'100%';font-size:14px;" colspan="2">
		 				<?=$wl_info?>
		       			</td>
		       		</tr>
		       	</table>
		       	
		       	<div id="menu_btn_next<?=$time?>" style="width:60px;">   
				    <div data-options="iconCls:'icon-yj'" onClick="fun_yj(<?=$time?>)">移交</div>   
				</div>  
				
		 	</div>
		 	
		 	<!-- 工单信息  -->
       		<? if( ! empty($flag_wl) ){ ?>
		 	<div data-options="region:'south'
		 					   ,title:'工单信息'
		 					   ,border:false
		 					   ,iconCls:'icon-wl'
		 					   ,hideCollapsedContent:false
		 					  " 
		 		 style="padding:5px;height:auto;overflow:hidden;">
		 		<?if($wl_list_to_do) echo '<p class="field_s">要做的事：'.$wl_list_to_do.'</p>' ?>
		 		<p class="field_s" style="font-size:14px;">工单留言：</p>
       			<script type="text/javascript">
				    //实例化编辑器
				    var self<?=$time?> = this;
				</script>
				
       			<textarea id="wl_comment<?=$time?>" have_focus="" oaname="wl_comment" time="<?=$time?>" class="oa_op oa_editor" style="width:100%;height:100px;"><?=$wl_comment_new;?></textarea>
       			
       			<script type="text/javascript">
		       		//实例化编辑器
		       		self<?=$time?>.ue_wl_comment = UE.getEditor('wl_comment<?=$time?>',{
		       		toolbars:[ueditor_tool['simple']],
		       		autoHeightEnabled:false,
		       		elementPathEnabled: false, //删除元素路径
		       		autoClearinitialContent:true,
		       		enableAutoSave :false,
		       		initialFrameHeight:80,
		       		//initialContent:'',
		       		wordCount: false  
		       		});
		       		self<?=$time?>.ue_wl_comment.ready(function(){
		       		    self<?=$time?>.isloadedUE = true;
		       		    //default font and color
		       		    UE.dom.domUtils.setStyles(self<?=$time?>.ue_wl_comment.body, {
		       		    'font-family' : "宋体", 'font-size' : '14px'
		       		    });
		       		    //回车发送
		       		    UE.dom.domUtils.on(self<?=$time?>.ue_wl_comment.body, 'keyup', function(event){
		       		    if(event.keyCode == 13){
		       			    
		       		    }
		       			});
		       		});
		       		self<?=$time?>.ue_wl_comment.addListener("focus", function (type, event) {
		       		    $('#wl_comment<?=$time?>').attr('have_focus',1);
		       		});
		       		
       			</script>
		 	</div>
		 	<? } ?>
		 	
		 	<div data-options="region:'center',border:false" style="padding:5px;">
		 	
		 		<div style="position: absolute;right:15px;top:5px;width:40px;">
		 			<a href="javascript:void(0)" oaname="btn_wl" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-wl'" style="width:35px;margin-bottom:5px;" title="审批信息" onClick="$('#tab_edit_<?=$time?>').tabs('select',2)"></a>
		 			<a href="javascript:void(0)" oaname="btn_im" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-im'" style="width:35px;margin-bottom:5px;" title="308" onClick="fun_im_wl('<?=$bal_id?>','<?=$pp_id?>')"></a>
		 		</div >
		 		
		 		<form id="f_<?=$time?>" class="easyui-form" method="post" data-options="novalidate:false" time="<?=$time?>"> 
		 			<table id="table_f_<?=$time?>" style="width:1300px;margin:0 auto;">
						<tr class="set_width"> 
	                    	<td style="width:100px"></td> 
                            <td style="width:225px"></td> 
	                        <td style="width:100px"></td> 
                            <td style="width:225px"></td> 
                            <td style="width:100px"></td> 
                            <td style="width:225px"></td> 
                            <td style="width:100px"></td> 
                            <td style="width:225px"></td> 
	                    </tr>  
	                    
	                    <tr class="tr_title oa_op" oaname = "title_loan_ending">
                            <td colspan="8" style="height:35px;text-align:left"  >
                                <span>个人借款</span>
                            </td>
                        </tr>
                        
                        <tr>
							<td colspan="8" style="height:35px;vertical-align:text-center;padding-top:10px;"  >
								<table id="table_loan_ending<?=$time?>"
									   class="data_table"
								>
								</table>
							</td>
						</tr>
	                    
	                    <tr class="tr_title oa_op" > 
	                    	<td colspan="8" style="height:35px;vertical-align:text-center;"  > 
	                    		<span>基本信息</span>
	                    	</td>
	                    </tr>
	                     <tr>
	                    	<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	所属机构
                            </td>
                            <td style="height:35px;vertical-align:text-center;"  colspan="7"> 
                            	<input name="content[bal_org_owner]" 
					    			   oaname="content[bal_org_owner]"
					    			   id="txtb_bal_org_owner<?=$time?>"
					    			   class="easyui-combobox oa_input"
					    			   data-options="err:err,
					    			   				 valueField:'id',    
						    						 textField:'text',
					    			   				 height:'25',
					    			   				 width:'400',
					    			   				 multiline:false,
					    			   				 panelHeight:'auto',
					    			   				 panelMaxHeight:120,
					    			   				 editable:false,
					    			   				 url_l:'base/auto/get_json_hr_org/from/combobox/field_id/ou_id/field_text/ou_name',
					    			   				 panelWidth:'',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                            </td>
	                    </tr>
	                    
	                    <tr>
	                    	<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	单据编号
                            </td>
                            <td style="height:35px;vertical-align:text-center;" > 
                            	<input name="content[bal_code]"
									   oaname="content[bal_code]"
									   class="easyui-textbox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
					    			   				 multiline:false,
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 "
								>
                            </td>
                            
                            <td class="field_s" style="height:35px;text-align: left">
								日期
							</td>
							<td style="height:35px;vertical-align:text-center;" >
								<input name="content[bal_time_node]" 
					    			   oaname="content[bal_time_node]"
					    			   class="easyui-datebox oa_input"
					    			   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200px',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
							</td>
							<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	申请人
                            </td>
                            <td style="height:35px;vertical-align:text-center;" > 
                            	<input name="content[bal_contact_manager_s]" 
					    			   oaname="content[bal_contact_manager_s]"
					    			   id="txtb_bal_contact_manager_s<?=$time?>"
					    			   class="easyui-textbox oa_input"
					    			   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 fun_ready: 'load_bal_contact_manager<?=$time?>()'
													 ">
								<input id="txtb_bal_contact_manager<?=$time?>" 
									   name="content[bal_contact_manager]"
									   oaname="content[bal_contact_manager]"
									   class="oa_input"
									   type="hidden"/>	
									   
								<input id="txtb_bal_c_org<?=$time?>" 
									   name="content[bal_c_org]"
									   oaname="content[bal_c_org]"
									   class="oa_input"
									   type="hidden"/>		   
                            </td>
                            
                            <td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	部门
                            </td>
                            <td style="height:35px;vertical-align:text-center;" > 
                            	<input name="content[bal_ou_s]" 
					    			   oaname="content[bal_ou_s]"
					    			   id="txtb_bal_ou_s<?=$time?>"
					    			   class="easyui-textbox oa_input"
					    			   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 fun_ready: 'load_ou<?=$time?>()'
													 ">
								<input id="txtb_bal_ou<?=$time?>" 
									   name="content[bal_ou]"
									   oaname="content[bal_ou]"
									   class="oa_input"
									   type="hidden"/>	
                            </td>
						</tr>	
						
						 <tr>
	                    	<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	金额
                            </td>
                            <td style="height:35px;vertical-align:text-center;"  > 
                            	<input name="content[bal_total_sum]" 
					    			   oaname="content[bal_total_sum]"
					    			   id="txtb_bal_total_sum<?=$time?>"
					    			   class="easyui-numberbox oa_input"
					    			   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
					    			   				 precision:2,
					    			   				 min:0,
					    			   				 groupSeparator:',',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 fun_ready: 'load_bal_total_sum<?=$time?>()'
													 ">
                            </td>
                            <td class="field_s oa_op" oaname="content[rei_total_sum]" style="height:35px;vertical-align:text-center;"  > 
                               	冲账金额
                            </td>
                            <td class="oa_op" oaname="content[rei_total_sum]" style="height:35px;vertical-align:text-center;"  > 
                            	<input name="content[rei_total_sum]" 
					    			   oaname="content[rei_total_sum]"
					    			   id="txtb_rei_total_sum<?=$time?>"
					    			   class="easyui-numberbox oa_input"
					    			   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
					    			   				 precision:2,
					    			   				 min:0,
					    			   				 groupSeparator:',',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 fun_ready: 'load_rei_total_sum<?=$time?>()'
													 ">
                            </td>
                            
                            <td colspan="4"></td>
                            
                        </tr>
                        
						<tr>
							<td class="field_s" style="height:35px;vertical-align:text-top;"  >
								备注
							</td>
							<td style="height:35px;vertical-align:text-top;"  colspan="7">
								<input name="content[bal_note]"
									   oaname="content[bal_note]"
									   class="easyui-textbox oa_input"
									   data-options="err:err,
					    			   				 height:'50',
					    			   				 width:'100%',
					    			   				 multiline:true,
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
							</td>	
						</tr>	
						
						<tr class="tr_title oa_op" oaname="title_bl"> 
	                    	<td colspan="8" style="height:35px;vertical-align:text-center;"  > 
	                    		<span>冲账</span>
	                    	</td>
	                    </tr>
	                    
	                    <tr>
							<td colspan="8" style="height:35px;vertical-align:text-center;padding-top:10px;"  >
								<table id="table_bl<?=$time?>"
									   name="content[bl]"
									   oaname="content[bl]"
									   class="oa_input data_table"
								>
								</table>
								
							</td>
						</tr>
						
						<tr class="tr_title oa_op" oaname="title_bali"> 
	                    	<td colspan="8" style="height:35px;vertical-align:text-center;"  > 
	                    		<span>费用报销明细</span>
	                    	</td>
	                    </tr>
	                    
	                    <tr>
							<td colspan="8" style="height:35px;vertical-align:text-center;padding-top:10px;"  >
								<div id="table_bali_tool<?=$time?>">
									<table style="width:100%;">
										<tr>
											<td style="width:'50%';" >
												<a href="javascript:void(0)" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-add',plain:true" onClick="fun_table_bali_operate<?=$time?>('add')">添加</a>
												<a href="javascript:void(0)" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-remove',plain:true" onClick="fun_table_bali_operate<?=$time?>('del')">删除</a>
											</td>
											<td style="width:'50%';text-align:right;">
											</td>
										</tr>
									</table>
								</div>
								<table id="table_bali<?=$time?>"
									   name="content[bali]"
									   oaname="content[bali]"
									   class="oa_input data_table"
								>
								</table>
								
							</td>
						</tr>
						
						<tr class="tr_title oa_op" oaname="title_trip"> 
	                    	<td colspan="8" style="height:35px;vertical-align:text-center;"  > 
	                    		<span>差旅费明细</span>
	                    	</td>
	                    </tr>
	                    
	                     <tr>
							<td colspan="8" style="height:35px;vertical-align:text-center;padding-top:10px;"  >
								<div id="table_trip_tool<?=$time?>">
									<table style="width:100%;">
										<tr>
											<td style="width:'50%';" >
												<a href="javascript:void(0)" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-add',plain:true" onClick="fun_table_trip_operate<?=$time?>('add')">添加</a>
												<a href="javascript:void(0)" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-remove',plain:true" onClick="fun_table_trip_operate<?=$time?>('del')">删除</a>
											</td>
											<td style="width:'50%';text-align:right;">
											</td>
										</tr>
									</table>
								</div>
								<table id="table_trip<?=$time?>"
									   name="content[trip]"
									   oaname="content[trip]"
									   class="oa_input data_table"
								>
								</table>
								
							</td>
						</tr>
						
						<tr class="tr_title oa_op" oaname="title_trip_c"> 
	                    	<td colspan="8" style="height:35px;vertical-align:text-center;"  > 
	                    		<span>出差人/垫付人</span>
	                    	</td>
	                    </tr>
	                    
	                    <tr>
							<td colspan="8" style="height:35px;vertical-align:text-center;padding-top:10px;"  >
								<div id="table_trip_c_tool<?=$time?>">
									<table style="width:100%;">
										<tr>
											<td style="width:'50%';" >
												<a href="javascript:void(0)" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-add',plain:true" onClick="fun_table_trip_c_operate<?=$time?>('add')">添加</a>
												<a href="javascript:void(0)" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-remove',plain:true" onClick="fun_table_trip_c_operate<?=$time?>('del')">删除</a>
											</td>
											<td style="width:'50%';text-align:right;">
											</td>
										</tr>
									</table>
								</div>
								<table id="table_trip_c<?=$time?>"
									   name="content[trip_c]"
									   oaname="content[trip_c]"
									   class="oa_input data_table"
								>
								</table>
								
							</td>
						</tr>
						
						<tr class="tr_title oa_op" oaname="title_trip_sub"> 
	                    	<td colspan="8" style="height:35px;vertical-align:text-center;"  > 
	                    		<span>补贴信息</span>
	                    	</td>
	                    </tr>
	                    
	                    <tr>
							<td colspan="8" style="height:35px;vertical-align:text-center;padding-top:10px;"  >
								<div id="table_trip_sub_tool<?=$time?>">
									<table style="width:100%;">
										<tr>
											<td style="width:'50%';" >
												<a href="javascript:void(0)" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-add',plain:true" onClick="fun_table_trip_sub_operate<?=$time?>('add')">添加</a>
												<a href="javascript:void(0)" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-remove',plain:true" onClick="fun_table_trip_sub_operate<?=$time?>('del')">删除</a>
											</td>
											<td style="width:'50%';text-align:right;">
											</td>
										</tr>
									</table>
								</div>
								<table id="table_trip_sub<?=$time?>"
									   name="content[trip_sub]"
									   oaname="content[trip_sub]"
									   class="oa_input data_table"
								>
								</table>
								
							</td>
						</tr>
						
	                 </table> 
	                 
	                 <!-- 数据校验时间 -->
					<input class="db_time_update" name="content[db_time_update]" type="hidden" />
					
					<!-- 移交人 -->
					<input id="person_yj<?=$time?>" name="content[person_yj]" type="hidden" />
					<input id="person_yj_s<?=$time?>" name="content[person_yj_s]" type="hidden" />
		 		 </form>
		 		
		 		 <!-- 验证错误 -->
         		 <input id="hd_err_f_<?=$time?>" type="hidden" /> 
         		 
		 	</div>
		 	
		</div>
         
    </div>
    
    <div title="操作日志" 
    	 oaname="tab_log"
       	 data-options="iconCls:'icon-log',
       				  href:'base/main/load_win_log_operate',
       				  queryParams:{
       				  	parent_id: 'tab_edit_<?=$time?>',
						op_id: '<?=$bal_id?>',
						table: 'fm_balance',
						field: 'bal_id',
						time: 'log_<?=$time?>'
       				 }"
       	>
       	
    </div>
    
    <div title="工单信息" 
    	 oaname="tab_wl"
       	 data-options="iconCls:'icon-wl',
       				  href:'base/main/load_win_worklist',
       				  queryParams:{
       				  	parent_id: 'tab_edit_<?=$time?>',
						op_id: '<?=$bal_id?>',
						pp_id: '<?=$pp_id?>',
						time: 'wl_<?=$time?>'
       				 }"
       	>
       	
    </div>
    
</div>

<!-- loading -->
<div id="win_loading<?=$time?>" style="padding:5px;overflow:hidden;"></div> 