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
    <div title="系统"
         style="">
         
        <div id="l_<?=$time?>" 
	   		class="easyui-layout" 
		 	data-options="fit:true">
		 	
		 	<div data-options="region:'north',border:false" 
		 		style="height:auto;padding-top:15px;overflow:hidden;">	
		 		<? if( ! empty($log_time) ){ ?>
		 		<center><span class="tb_title"><b>操作日志</b></span></center>
				<table style="width:800px;margin:0 auto;" class="table_no_line">
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
		 		<center><span class="tb_title"><b>信息系统注销</b></span></center>
		 		
		 		<table id="table_h_<?=$time?>" class="table_no_line"  style="width:800px;margin:0 auto;">
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
		       				<a href="javascript:void(0)" oaname="btn_import" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-xlsx'" onClick="fun_xlsx_import('proc_office/m_office_logout','信息系统注销','proc_office/office_logout/import')">导入</a>
		       				<a href="javascript:void(0)" oaname="btn_next" class="easyui-splitbutton oa_op" data-options="iconCls:'icon-next',menu:'#menu_btn_next<?=$time?>',plain:false" onClick="$.messager.confirm('确认','您确认想要<?=$ppo_btn_next?>吗？',function(r){if(r)f_submit_<?=$time?>('next');});"><?=$ppo_btn_next?></a>
		       				<a href="javascript:void(0)" oaname="btn_pnext" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-pnext'" onClick="$.messager.confirm('确认','您确认想要<?=$ppo_btn_pnext?>吗？',function(r){if(r)f_submit_<?=$time?>('pnext');});"><?=$ppo_btn_pnext?></a>
		       			</td>
		       			<td style="width:'50%';text-align:right;">
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
		 		
		 		<div style="position: absolute;right:20px;top:5px;width:40px;">
		 			<a href="javascript:void(0)" oaname="btn_wl" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-wl'" style="width:35px;margin-bottom:5px;" title="审批信息" onClick="$('#tab_edit_<?=$time?>').tabs('select',2)"></a>
		 			<a href="javascript:void(0)" oaname="btn_im" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-im'" style="width:35px;margin-bottom:5px;" title="308" onClick="fun_im_wl('<?=$offl_id?>','<?=$pp_id?>')"></a>
		 		</div >
		 		
		 		<form id="f_<?=$time?>" class="easyui-form" method="post" data-options="novalidate:false" time="<?=$time?>"> 
		 			<table id="table_f_<?=$time?>" style="width:800px;margin:0 auto;">
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
                               	系统所有人
                            </td>
                            <td style="height:35px;vertical-align:text-center;" > 
                            	<input name="content[offl_c_id_s]" 
					    			   oaname="content[offl_c_id_s]"
					    			   id="txtb_offl_c_id_s<?=$time?>"
					    			   class="easyui-textbox oa_input"
					    			   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 fun_ready: 'load_offl_c_id<?=$time?>()'
													 ">
													 
								<input id="txtb_offl_c_id<?=$time?>" 
									   name="content[offl_c_id]"
									   oaname="content[offl_c_id]"
									   class="oa_input"
									   type="hidden"/>
									   
								<input id="txtb_c_org<?=$time?>" 
									   name="content[c_org]"
									   oaname="content[c_org]"
									   class="oa_input"
									   type="hidden"/>
									   	   
                            </td>
						</tr>
						<tr>
                            <td style="height:35px;vertical-align:text-center;" colspan="4"> 
                            	<span class="field_s">备注</span>
                            	<input name="content[offl_note]"
					    			   oaname="content[offl_note]"
					    			   class="easyui-textbox oa_input"
					    			   data-options="err:err,
					    			   				 height:'50',
					    			   				 width:'100%',
					    			   				 multiline:true,
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                            </td>
	                    </tr>
	                    
	                    <tr oaname="title_c_info" class="tr_title oa_op">
	                    	<td colspan="3" style="height:35px;text-align:left"  >
	                    		<span>所有人信息</span>
	                    		
	                    	</td>
	                    	<td colspan="1" style="height:35px;text-align:right"  >
	                    		
	                    		<a href="javascript:void(0);" 
	                    		   class="sui-btn btn-bordered btn-small btn-primary" 
	                    		   onClick="fun_tr_title_show($('#table_f_<?=$time?>'),'title_c_info','','collapse');$(this).hide();$(this).next().show();"
	                    		   >
	                    		   <i class="sui-icon icon-tb-fold"></i>
	                    		</a>
	                    		
	                    		<a href="javascript:void(0);" 
	                    		   class="sui-btn btn-bordered btn-small btn-primary" 
	                    		   onClick="fun_tr_title_show($('#table_f_<?=$time?>'),'title_c_info','show','collapse');$(this).hide();$(this).prev().show();"
	                    		   style="display:none;"
	                    		   >
	                    		   <i class="sui-icon icon-tb-unfold"></i>
	                    		</a>
	                    		
	                    	</td>
	                    </tr>
	                    
	                    <tr>
	                    	<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	手机
                            </td>
                            
                            <td style="height:35px;vertical-align:text-center;" > 
                             	<span name="content[c_tel]" 
					    			  oaname="content[c_tel]"
					    			  class="oa_input"
					    			>
					    		</span>
					    		<span name="content[c_tel_info]" 
					    			  oaname="content[c_tel_info]"
					    			  class="oa_input"
					    			>
					    		</span>
                             </td>
                             <td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	备用手机
                            </td>
                            
                            <td style="height:35px;vertical-align:text-center;"  > 
                             	<span name="content[c_tel_2]" 
					    			  oaname="content[c_tel_2]"
					    			  class="oa_input"
					    			>
					    		</span>
					    		<span name="content[c_tel_2_info]" 
					    			  oaname="content[c_tel_2_info]"
					    			  class="oa_input"
					    			>
					    		</span>
                             </td>
	                    </tr>
	                    
	                    <tr>
	                    	<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	Email
                            </td>
                            <td>
                            <span name="content[c_email]" 
				    			  oaname="content[c_email]"
				    			  class="oa_input"
				    			>
				    		</span>
				    		</td>
                        </tr>
                        
	                    <tr>
	                    	<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	所属机构
                            </td>
                             <td style="height:35px;vertical-align:text-center;"  colspan="3"> 
                             	<span name="content[c_org_s]" 
					    			  oaname="content[c_org_s]"
					    			  class="oa_input"
					    			>
					    		</span>
                             </td>
                        </tr>
                        
                        <tr>
	                    	<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	法人
                            </td>
                             <td style="height:35px;vertical-align:text-center;"  colspan="3"> 
                             	<span name="content[c_hr_org_s]" 
					    			  oaname="content[c_hr_org_s]"
					    			  class="oa_input"
					    			>
					    		</span>
                             </td>
                        </tr>
                        
                        <tr>
	                    	<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                              	 二级部门
                            </td>
                            <td style="height:35px;vertical-align:text-center;" > 
                             	<span name="content[c_ou_2_s]" 
					    			  oaname="content[c_ou_2_s]"
					    			  class="oa_input"
					    			>
					    		</span>
                             </td>
                             
                             <td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                              	 三级部门
                            </td>
                            <td style="height:35px;vertical-align:text-center;" > 
                             	<span name="content[c_ou_3_s]" 
					    			  oaname="content[c_ou_3_s]"
					    			  class="oa_input"
					    			>
					    		</span>
                             </td>
                        </tr>
                        
                        <tr>
	                    	<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                              	 四级部门
                            </td>
                            <td style="height:35px;vertical-align:text-center;" > 
                             	<span name="content[c_ou_4_s]" 
					    			  oaname="content[c_ou_4_s]"
					    			  class="oa_input"
					    			>
					    		</span>
                             </td>
                             
                             <td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                              	职位
                            </td>
                            <td style="height:35px;vertical-align:text-center;" > 
                             	<span name="content[c_job_s]" 
					    			  oaname="content[c_job_s]"
					    			  class="oa_input"
					    			>
					    		</span>
                             </td>
                             
                        </tr>
                        
                         <tr>
	                    	<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                              	关联账户
                            </td>
                            <td style="height:35px;vertical-align:text-center;" > 
                             	<span name="content[c_login_id]" 
					    			  oaname="content[c_login_id]"
					    			  class="oa_input"
					    			>
					    		</span>
                             </td>
                             
                             <td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                              	短号
                            </td>
                            <td style="height:35px;vertical-align:text-center;" > 
                             	<span name="content[c_tel_code]" 
					    			  oaname="content[c_tel_code]"
					    			  class="oa_input"
					    			>
					    		</span>
                             </td>
                             
                        </tr>
                        
                        <!--开通系统-->
						<tr class="tr_title" >
							<td colspan="4" style="height:35px;vertical-align:text-center;"  >
								<span>信息系统</span>
							</td>
						</tr>

						<tr>
							<td colspan="4" style="height:35px;vertical-align:text-center;padding-top:10px;"  >
								<div id="table_office_tool<?=$time?>">
									<table style="width:100%;">
										<tr>
											<td style="width:'50%';" >
												<a href="javascript:void(0)" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-add',plain:true" onClick="fun_table_office_operate<?=$time?>('add')">添加</a>
												<a href="javascript:void(0)" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-remove',plain:true" onClick="fun_table_office_operate<?=$time?>('del')">删除</a>
											</td>

										</tr>
									</table>
								</div>
								<table id="table_office<?=$time?>"
									   name="content[office]"
									   oaname="content[office]"
									   class="oa_input data_table"
								>
								</table>
							</td>
						</tr>

	                 </table> 
	                 
	                 <!-- 数据校验时间 -->
					<input class="db_time_update" name="content[db_time_update]" type="hidden" />
							
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
						op_id: '<?=$offl_id?>',
						table: 'oa_office_logout',
						field: 'offl_id',
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
						op_id: '<?=$offl_id?>',
						pp_id: '<?=$pp_id?>',
						time: 'wl_<?=$time?>'
       				 }"
       	>
       	
    </div>
    
</div>

<!-- loading -->
<div id="win_loading<?=$time?>" style="padding:5px;overflow:hidden;"></div> 