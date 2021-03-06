<div id="tab_edit_<?=$time?>" 
	 class="easyui-tabs" 
     data-options="fit:true,
    			   border:false,
    			   showHeader:false,
            	   tabWidth:150,
            	   onSelect: function(title,index)
            	   {
            	   		if( index == '0' && '<?=$ppo?>' == '<?=GFC_PPO_START?>'
            	   		&& $('#table_indexfile_<?=$time?>').length > 0)
            	   		{
            	   			load_table_gfc_cr_file<?=$time?>();
            	   		}
            	   		
            	   		if( index == '0' && '<?=$ppo?>' == '<?=GFC_PPO_UPLOAD?>'
            	   		&& $('#table_indexfile_<?=$time?>').length > 0)
            	   		{
            	   			load_table_gfc_return_file<?=$time?>();
            	   		}
            	   		
            	   		if( title == '操作日志' && $('#table_indexlog_<?=$time?>').length > 0)
            	   		{
            	   			$('#table_indexlog_<?=$time?>').datagrid('reload');
            	   		}
            	   }">
    <div title="财务编号"
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
		 		<center><span class="tb_title"><b>项目跟踪</b></span></center>
		 		
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
		       				<a href="javascript:void(0)" oaname="btn_import" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-xlsx'" onClick="fun_xlsx_import('proc_gfc/m_gfc','文件属性','proc_file/gfc/import')">导入</a>
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
		       			<b>当前节点:<?=$ppo_name;?><?=$ppo_name_after;?></b>
		       			</td>
		       		</tr>
		       		<tr>
		       			<td style="width:'100%';font-size:14px;" colspan="2">
		 				<?=$wl_info?>
		       			</td>
		       		</tr>
		       	</table>
		       	
		       	<div id="menu_btn_next<?=$time?>" style="width:60px;" class="easyui-menu">   
				    <div class="oa_op" data-options="iconCls:'icon-yj'" oaname="btn_yj" onClick="fun_yj(<?=$time?>)">移交</div>   
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
		 	
		 		<div style="position: absolute;right:120px;top:5px;width:40px;">
		 			<a href="javascript:void(0)" oaname="btn_wl" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-wl'" style="width:35px;margin-bottom:5px;" title="审批信息" onClick="$('#tab_edit_<?=$time?>').tabs('select',2)"></a>
		 			<a href="javascript:void(0)" oaname="btn_im" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-im'" style="width:35px;margin-bottom:5px;" title="308" onClick="fun_im_wl('<?=$gfc_id?>','<?=$pp_id?>')"></a>
		 			<a href="javascript:void(0)" id="btn_file<?=$time?>" oaname="btn_file" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-file'" style="width:35px;margin-bottom:5px;" title="关联文件" onClick="$('#tab_edit_<?=$time?>').tabs('select',3)"></a>
		 		</div >
		 		
		 		<form id="f_<?=$time?>" class="easyui-form" method="post" data-options="novalidate:false" time="<?=$time?>" style="width:100%;height:100%;"> 
		 			<div id="tab_gfc<?=$time?>" 
					 class="easyui-tabs" 
				     data-options="fit:true,
				    			   border:false,
				    			   plain:true,
				    			   tabPosition:'right',
				    			   headerWidth:100,
				            	   tabWidth:100">
				            	   
						<div title="项目跟踪<span id='sp_gfc<?=$time?>' class='m-badge' style='display:none'></span>"
							 oaname="tab_gfc"
				        	 class="oa_op"
				         	 style=""> 
				         	 
				         	<table id="table_f_<?=$time?>" style="width:800px;margin:0 auto;">
							<tr class="set_width"> 
		                    	<td style="width:120px;"></td>
	                            <td style="width:280px;"></td>
		                        <td style="width:120px;"></td>
	                            <td style="width:280px;"></td>
		                    </tr> 
		                    
		                     <tr class="tr_title oa_op" oaname = "title_return_file">
		                    	<td colspan="4" style="height:35px;text-align:left"  >
		                    		<span>归档合同</span>
		                    	</td>
		                    </tr>
		                    
		                    <tr>
		                    	<td colspan="4" style="height:35px;vertical-align:text-center;padding-top:10px;"  > 
									<table id="table_gfc_return_file<?=$time?>"
										   name="content[gfc_return_file]"
										   oaname="content[gfc_return_file]"
										   class="oa_input data_table">
									</table>
											
		                    	</td>
		                    </tr> 
		                    
		                    <tr class="tr_title oa_op" oaname = "title_check">
		                    	<td colspan="4" style="height:35px;text-align:left"  >
		                    		<span>审核信息</span>
		                    	</td>
		                    </tr>
		                    
		                    <tr>
								<td class="field_s oa_op" oaname="content[gfc_finance_code]" style="height:35px;vertical-align:text-center;">
									财务编号
								</td>
								<td class="oa_op" oaname="content[gfc_finance_code]" style="height:35px;vertical-align:text-center;" >
									<input name="content[gfc_finance_code]"
										   oaname="content[gfc_finance_code]"
										   class="easyui-textbox oa_input"
										   data-options="err:err,
						    			   				 height:'25',
						    			   				 width:'200',
						    			   				 multiline:false,
														 validType:['length[0,40]','errMsg[\'#hd_err_f_<?=$time?>\']'],
														 "
									>
								</td>
								 <td class="field_s" style="height:35px;text-align: left">
									统计时间
								</td>
								<td style="height:35px;vertical-align:text-center;" >
									<input name="content[gfc_time_node_sign]" 
						    			   oaname="content[gfc_time_node_sign]"
						    			   class="easyui-datebox oa_input"
						    			   data-options="err:err,
						    			   				 height:'25',
						    			   				 width:'200px',
														 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
														 ">
								</td>
							</tr>
							<tr>
								<td class="field_s" style="height:35px;text-align: left">
									统计部门
								</td>
								<td colspan="3">
									<input name="content[gfc_ou_tj]"
										   oaname="content[gfc_ou_tj]"
										   id="txtb_gfc_ou_tj<?=$time?>"
										   class="easyui-tagbox oa_input"
										   data-options="err:err,
						    			   				 valueField:'id',
							    						 textField:'text',
							    						 limitToList:true,
							    						 missingMessage:'该输入项为必填项',
						    			   				 height:'25',
						    			   				 width:'100%',
						    			   				 panelHeight:'0',
						    			   				 onShowPanel:function()
						    			   				 {
						    			   				 	$(this).tagbox('hidePanel');
						    			   				 },
														 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
														 fun_ready:'load_gfc_ou_tj<?=$time?>()'
														 ">
								</td>
							</tr>
							
							<tr class="tr_title oa_op" oaname = "title_base">
		                    	<td colspan="4" style="height:35px;text-align:left"  >
		                    		<span>基本信息</span>
		                    	</td>
		                    </tr>	
		                    
		                    <tr>
		                    	<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
	                               	所属机构
	                            </td>
	                            <td style="height:35px;vertical-align:text-center;"  colspan="3"> 
	                            	<input name="content[gfc_org]" 
						    			   oaname="content[gfc_org]"
						    			   id="txtb_gfc_org<?=$time?>"
						    			   class="easyui-combobox oa_input"
						    			   data-options="err:err,
						    			   				 valueField:'id',    
							    						 textField:'text',
						    			   				 height:'25',
						    			   				 width:'100%',
						    			   				 multiline:false,
						    			   				 panelHeight:'auto',
						    			   				 panelMaxHeight:120,
						    			   				 editable:false,
						    			   				 url_l:'base/auto/get_json_hr_org/from/combobox/field_id/ou_id/field_text/ou_name',
						    			   				 panelWidth:'',
						    			   				 onLoadSuccess:function()
						    			   				 {
						    			   				 	load_gfc_c_jia<?=$time?>();
						    			   				 },
														 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
														 ">
	                            </td>
		                    </tr>
		                    <tr>
								<td class="field_s oa_op" oaname="content[gfc_name]" style="height:35px;vertical-align:text-center;">
									项目全称
								</td>
								<td class="oa_op" oaname="content[gfc_name]" style="height:35px;vertical-align:text-center;" colspan="3">
									<input name="content[gfc_name]"
										   oaname="content[gfc_name]"
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
	                               	甲方单位
	                            </td>
	                            <td style="height:35px;vertical-align:text-center;"  colspan="3"> 
	                            	<input name="content[gfc_org_jia_s]"
										   oaname="content[gfc_org_jia_s]"
										   id="txtb_gfc_org_jia_s<?=$time?>" 
										   class="easyui-textbox oa_input"
										   data-options="err:err,
						    			   				 height:'25',
						    			   				 width:'100%',
						    			   				 multiline:false,
														 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
														 fun_ready: 'load_gfc_org_jia<?=$time?>()'
														 "
									>
									<input id="txtb_gfc_org_jia<?=$time?>" 
										   name="content[gfc_org_jia]"
										   oaname="content[gfc_org_jia]"
										   class="oa_input"
										   type="hidden"/>	
	                            </td>
		                    </tr>
		                    
		                    <tr>
		                    	<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
	                               	甲方联系人
	                            </td>
	                            <td style="height:35px;vertical-align:text-center;"  > 
	                            	<input name="content[gfc_c_jia]" 
						    			   oaname="content[gfc_c_jia]"
						    			   id="txtb_gfc_c_jia<?=$time?>"
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
						    			   				 panelWidth:'',
						    			   				 data: [<?=element('gfc_c_jia',$json_field_define)?>],
														 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
														 onSelect:function(record)
														 {
														 	if(record.c_tel)
														 	{
														 		$('#sp_gfc_c_jia_tel<?=$time?>').text(base64_decode(record.c_tel));
														 	}
														 	else if(record.c_phone)
														 	{
														 		$('#sp_gfc_c_jia_tel<?=$time?>').text(base64_decode(record.c_phone));
														 	}
														 },
														 ">
	                            </td>
	                            <td class="field_s" style="height:35px;vertical-align:text-center;"  > 
	                               	甲方联系电话
	                            </td>
	                            <td style="height:35px;vertical-align:text-center;"  > 
	                            	<span name="content[gfc_c_jia_tel]" 
						    			  oaname="content[gfc_c_jia_tel]"
						    			  id='sp_gfc_c_jia_tel<?=$time?>'
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
	                            	<input name="content[gfc_c_s]" 
						    			   oaname="content[gfc_c_s]"
						    			   id="txtb_gfc_c_s<?=$time?>"
						    			   class="easyui-textbox oa_input"
						    			   data-options="err:err,
						    			   				 height:'25',
						    			   				 width:'200',
														 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
														 fun_ready: 'load_gfc_c<?=$time?>()'
														 ">
														 
									<input id="txtb_gfc_c<?=$time?>" 
										   name="content[gfc_c]"
										   oaname="content[gfc_c]"
										   class="oa_input"
										   type="hidden"/>	
										   
									<input id="txtb_gfc_c_org<?=$time?>" 
										   name="content[gfc_c_org]"
										   oaname="content[gfc_c_org]"
										   class="oa_input"
										   type="hidden"/>		   
	                            </td>
	                            <td class="field_s" style="height:35px;vertical-align:text-center;"  > 
	                               	部门
	                            </td>
	                            <td style="height:35px;vertical-align:text-center;"  > 
	                            	<input name="content[gfc_ou_s]" 
						    			   oaname="content[gfc_ou_s]"
						    			   id="txtb_gfc_ou_s<?=$time?>"
						    			   class="easyui-textbox oa_input"
						    			   data-options="err:err,
						    			   				 height:'25',
						    			   				 width:'200',
														 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
														 fun_ready: 'load_gfc_ou<?=$time?>()'
														 ">
									<input id="txtb_gfc_ou<?=$time?>" 
										   name="content[gfc_ou]"
										   oaname="content[gfc_ou]"
										   class="oa_input"
										   type="hidden"/>	
	                            </td>
		                    </tr>
		                    
		                    <tr>
		                    	<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
	                               	项目统计人
	                            </td>
	                            <td style="height:35px;vertical-align:text-center;"  > 
	                            	<input name="content[gfc_c_tj_s]" 
						    			   oaname="content[gfc_c_tj_s]"
						    			   id="txtb_gfc_c_tj_s<?=$time?>"
						    			   class="easyui-textbox oa_input"
						    			   data-options="err:err,
						    			   				 height:'25',
						    			   				 width:'200',
														 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
														 fun_ready: 'load_gfc_c_tj_s<?=$time?>()'
														 ">
									<input id="txtb_gfc_c_tj<?=$time?>" 
										   name="content[gfc_c_tj]"
										   oaname="content[gfc_c_tj]"
										   class="oa_input"
										   type="hidden"/>	
	                            </td>
	                            
	                            <td class="field_s" style="height:35px;text-align: left">
									先实施后签约
								</td>
								<td style="height:35px;vertical-align:text-center;" >
									<input name="content[gfc_category_contract]"
										   oaname="content[gfc_category_contract]"
										   class="easyui-combobox oa_input"
										   data-options="err:err,
						    			   				 limitToList:true,
						    			   				 valueField:'id',    
							    						 textField:'text',
						    			   				 height:'25',
						    			   				 width:'200px',
						    			   				 multiline:false,
						    			   				 data: [<?=element('gfc_category_contract',$json_field_define)?>],
						    			   				 panelHeight:'auto',
						    			   				 panelMaxHeight:120,
						    			   				 panelWidth:'',
														 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
														 ">
								</td>
		                    </tr>
		                    <tr>
		                    	<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
	                               	合同总额
	                            </td>
	                            <td style="height:35px;vertical-align:text-center;"  > 
	                            	<input name="content[gfc_sum]" 
						    			   oaname="content[gfc_sum]"
						    			   id="txtb_gfc_sum<?=$time?>"
						    			   class="easyui-numberbox oa_input"
						    			   data-options="err:err,
						    			   				 height:'25',
						    			   				 width:'200',
						    			   				 precision:2,
						    			   				 min:0,
						    			   				 groupSeparator:',',
														 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
														 onChange:function(newValue,oldValue)
														 {
														 	fun_load_gfc_bud_other<?=$time?>();
														 },
														 fun_ready: 'load_gfc_sum<?=$time?>()'
														 ">
	                            </td>
	                            
	                            <td class="field_s" style="height:35px;text-align: left">
									预计签约时间
								</td>
								<td style="height:35px;vertical-align:text-center;" >
									<input name="content[gfc_pt_plan_sign]" 
						    			   oaname="content[gfc_pt_plan_sign]"
						    			   class="easyui-datebox oa_input"
						    			   data-options="err:err,
						    			   				 height:'25',
						    			   				 width:'200px',
														 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
														 ">
								</td>
								
		                    </tr>
		                    
		                    <tr>
								<td class="field_s" style="height:35px;text-align: left">
									项目性质
								</td>
								<td style="height:35px;vertical-align:text-center;" >
									<input name="content[gfc_category_main]"
										   oaname="content[gfc_category_main]"
										   id="txtb_gfc_category_main<?=$time?>"
										   class="easyui-combobox oa_input"
										   data-options="err:err,
						    			   				 limitToList:true,
						    			   				 valueField:'id',    
							    						 textField:'text',
						    			   				 height:'25',
						    			   				 width:'200px',
						    			   				 multiline:false,
						    			   				 data: [<?=element('gfc_category_main',$json_field_define)?>],
						    			   				 panelHeight:'auto',
						    			   				 panelMaxHeight:120,
						    			   				 panelWidth:'',
														 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
														 loadFilter:function(data)
														 {
														 	var value = $(this).combobox('getValue');
														 	var data_new = [];
														 	var arr = [1,3,4,5,6,7,8];
														 	
									    					for(var i =0;i < data.length;i++)
									    					{
									    						if(arr.indexOf( parseInt(data[i].id) ) > -1 || value == data[i].id)
									    						{
									    							data_new.push(data[i]);
									    						}
									    					}
									    					
									    					return data_new;
														 },
														 fun_ready: 'load_gfc_category_main<?=$time?>()'
														 ">
								</td>
								<td class="field_s" style="height:35px;text-align: left">
									项目密级
								</td>
								<td style="height:35px;vertical-align:text-center;" >
									<input name="content[gfc_category_secret]"
										   oaname="content[gfc_category_secret]"
										   id="txtb_gfc_category_secret<?=$time?>"
										   class="easyui-combobox oa_input"
										   data-options="err:err,
						    			   				 limitToList:true,
						    			   				 valueField:'id',    
							    						 textField:'text',
						    			   				 height:'25',
						    			   				 width:'200px',
						    			   				 multiline:false,
						    			   				 data: [<?=element('gfc_category_secret',$json_field_define)?>],
						    			   				 panelHeight:'auto',
						    			   				 panelMaxHeight:120,
						    			   				 panelWidth:'',
														 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
														 onSelect:function(record)
													 	 {
														 	if(record.id == '<?=GFC_CATEGORY_SECRET_FM?>')
														 	{
														 		if('<?=$act?>' != <?=STAT_ACT_CREATE?> )
														 		$('#btn_file<?=$time?>').show();
														 		$('#tr_gfcs_tm_name<?=$time?>').hide();
														 	}
														 	else
														 	{
														 		$('#btn_file<?=$time?>').hide();
														 		$('#tr_gfcs_tm_name<?=$time?>').show();
														 	}
													 	}
														 ">
								</td>
	
							</tr>
							
							<tr>
								<td class="field_s" style="height:35px;text-align: left">
									条线
								</td>
								<td style="height:35px;vertical-align:text-center;" >
									<input name="content[gfc_category_tiaoxian_main]"
										   oaname="content[gfc_category_tiaoxian_main]"
										   class="easyui-combobox oa_input"
										   data-options="err:err,
						    			   				 limitToList:true,
						    			   				 valueField:'id',    
							    						 textField:'text',
						    			   				 height:'25',
						    			   				 width:'200px',
						    			   				 multiline:false,
						    			   				 data: [<?=element('gfc_category_tiaoxian_main',$json_field_define)?>],
						    			   				 panelHeight:'auto',
						    			   				 panelMaxHeight:120,
						    			   				 panelWidth:'',
														 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
														 ">
								</td>
								
								<td class="field_s" style="height:35px;text-align: left">
									行业
								</td>
								<td style="height:35px;vertical-align:text-center;" >
									<input name="content[gfc_category_tiaoxian]"
										   oaname="content[gfc_category_tiaoxian]"
										   class="easyui-combobox oa_input"
										   data-options="err:err,
						    			   				 limitToList:true,
						    			   				 valueField:'id',    
							    						 textField:'text',
						    			   				 height:'25',
						    			   				 width:'200px',
						    			   				 multiline:false,
						    			   				 data: [<?=element('gfc_category_tiaoxian',$json_field_define)?>],
						    			   				 panelHeight:'auto',
						    			   				 panelMaxHeight:120,
						    			   				 panelWidth:'',
														 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
														 ">
								</td>
	
							</tr>
							<tr>
								<td class="field_s" style="height:35px;text-align: left">
									附加属性
								</td>
								<td style="height:35px;vertical-align:text-center;" >
									<input name="content[gfc_category_extra]"
										   oaname="content[gfc_category_extra]"
										   class="easyui-combobox oa_input"
										   data-options="err:err,
						    			   				 limitToList:true,
						    			   				 valueField:'id',    
							    						 textField:'text',
						    			   				 height:'25',
						    			   				 width:'200px',
						    			   				 multiline:false,
						    			   				 data: [<?=element('gfc_category_extra',$json_field_define)?>],
						    			   				 panelHeight:'auto',
						    			   				 panelMaxHeight:120,
						    			   				 panelWidth:'',
														 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
														 loadFilter:function(data)
														 {
														 	var value = $(this).combobox('getValue');
														 	var data_new = [];
														 	var arr = [14,15];
														 	
									    					for(var i =0;i < data.length;i++)
									    					{
									    						if(arr.indexOf( parseInt(data[i].id) ) > -1 || value == data[i].id)
									    						{
									    							data_new.push(data[i]);
									    						}
									    					}
									    					
									    					return data_new;
														 }
														 ">
								</td>
								
								<td class="field_s" style="height:35px;text-align: left">
									附加属性II
								</td>
								<td style="height:35px;vertical-align:text-center;" >
									<input name="content[gfc_category_statistic]"
										   oaname="content[gfc_category_statistic]"
										   class="easyui-combobox oa_input"
										   data-options="err:err,
						    			   				 limitToList:true,
						    			   				 valueField:'id',    
							    						 textField:'text',
						    			   				 height:'25',
						    			   				 width:'200px',
						    			   				 multiline:false,
						    			   				 data: [<?=element('gfc_category_statistic',$json_field_define)?>],
						    			   				 panelHeight:'auto',
						    			   				 panelMaxHeight:120,
						    			   				 panelWidth:'',
														 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
														 loadFilter:function(data)
														 {
														 	var value = $(this).combobox('getValue');
														 	var data_new = [];
														 	
									    					for(var i =0;i < data.length;i++)
									    					{
									    						if(data[i].id > 37 || value == data[i].id)
									    						{
									    							data_new.push(data[i]);
									    						}
									    					}
									    					
									    					return data_new;
														 }
														 ">
								</td>
	
							</tr>
							
							<tr>
								<td class="field_s" style="height:35px;text-align: left">
									是否总分包合同
								</td>
								<td style="height:35px;vertical-align:text-center;" >
									<input name="content[gfc_category_subc]"
										   oaname="content[gfc_category_subc]"
										   id="txtb_gfc_category_subc<?=$time?>"
										   class="easyui-combobox oa_input"
										   data-options="err:err,
						    			   				 limitToList:true,
						    			   				 valueField:'id',    
							    						 textField:'text',
						    			   				 height:'25',
						    			   				 width:'200px',
						    			   				 multiline:false,
						    			   				 data: [<?=element('gfc_category_subc',$json_field_define)?>],
						    			   				 panelHeight:'auto',
						    			   				 panelMaxHeight:120,
						    			   				 panelWidth:'',
														 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
														 onChange:function(newValue,oldValue)
														 {
														 	fun_load_gfc_bud_other<?=$time?>();
														 }
														 ">
								</td>
								
								<td class="field_s" style="height:35px;text-align: left">
									是否合作项目
								</td>
								<td style="height:35px;vertical-align:text-center;" >
									<input name="content[gfc_category_cooperation]"
										   oaname="content[gfc_category_cooperation]"
										   class="easyui-combobox oa_input"
										   data-options="err:err,
						    			   				 limitToList:true,
						    			   				 valueField:'id',    
							    						 textField:'text',
						    			   				 height:'25',
						    			   				 width:'200px',
						    			   				 multiline:false,
						    			   				 data: [<?=element('gfc_category_cooperation',$json_field_define)?>],
						    			   				 panelHeight:'auto',
						    			   				 panelMaxHeight:120,
						    			   				 panelWidth:'',
														 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
														 ">
								</td>
	
							</tr>
							<tr>
								<td class="field_s" style="height:35px;text-align: left">
									区域
								</td>
								<td style="height:35px;vertical-align:text-center;" colspan="3">
									<input name="content[gfc_area]" 
						    			   oaname="content[gfc_area]"
						    			   id="txtb_gfc_area<?=$time?>"
						    			   class="easyui-combobox oa_input"
						    			   data-options="err:err,
						    			   				 limitToList:true,
						    			   				 valueField:'area_id',    
	    							 					 textField:'name',  
						    			   				 height:'25',
						    			   				 width:'200',
						    			   				 multiline:false,
						    			   				 panelHeight:'auto',
						    			   				 panelMaxHeight:120,
						    			   				 url_l:'base/fun/get_json_china_area',
						    			   				 panelWidth:'',
						    			   				 onChange: function(newValue,oldValue)
						    			   				 {
						    			   				 	if(newValue != oldValue)
						    			   				 	{
						    			   				 		if(newValue)
						    			   				 		{
							    			   				 		var url = 'base/fun/get_json_china_area/p_id/'+newValue
							    			   				 		$('#txtb_gfc_area_1<?=$time?>').combobox('reload',url)
						    			   				 		
						    			   				 			$('#txtb_gfc_area_1<?=$time?>').combobox('enable');
						    			   				 			$('#txtb_gfc_area_2<?=$time?>').combobox('disable');
						    			   				 		}
						    			   				 		else
						    			   				 		{
						    			   				 			$('#txtb_gfc_area_1<?=$time?>').combobox('disable');
						    			   				 			$('#txtb_gfc_area_2<?=$time?>').combobox('disable');
						    			   				 		}
						    			   				 		
						    			   				 		if(oldValue)
						    			   				 		{
						    			   				 			$('#txtb_gfc_area_1<?=$time?>').combobox('clear');
						    			   				 			$('#txtb_gfc_area_2<?=$time?>').combobox('clear');
						    			   				 		}
						    			   				 	}
						    			   				 },
														 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
														 ">
									<input name="content[gfc_area_1]" 
						    			   oaname="content[gfc_area_1]"
						    			   id="txtb_gfc_area_1<?=$time?>"
						    			   class="easyui-combobox oa_input"
						    			   data-options="err:err,
						    			   				 limitToList:true,
						    			   				 valueField:'area_id',    
	    							 					 textField:'name',  
						    			   				 height:'25',
						    			   				 width:'200',
						    			   				 multiline:false,
						    			   				 panelHeight:'auto',
						    			   				 panelMaxHeight:120,
						    			   				 panelWidth:'',
						    			   				 disabled:true,
						    			   				 onChange: function(newValue,oldValue)
						    			   				 {
						    			   				 	if(newValue != oldValue)
						    			   				 	{
						    			   				 		
						    			   				 		if(newValue)
						    			   				 		{
							    			   				 		var url = 'base/fun/get_json_china_area/p_id/'+newValue
							    			   				 		$('#txtb_gfc_area_2<?=$time?>').combobox('reload',url)
						    			   				 		
						    			   				 			$('#txtb_gfc_area_2<?=$time?>').combobox('enable');
						    			   				 		}
						    			   				 		else
						    			   				 		{
						    			   				 			$('#txtb_gfc_area_2<?=$time?>').combobox('disable');
						    			   				 		}
						    			   				 		
						    			   				 		if(oldValue)
						    			   				 		{
						    			   				 			$('#txtb_gfc_area_2<?=$time?>').combobox('clear');
						    			   				 		}
						    			   				 	}
						    			   				 },
														 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
														 ">	
									<input name="content[gfc_area_2]" 
						    			   oaname="content[gfc_area_2]"
						    			   id="txtb_gfc_area_2<?=$time?>"
						    			   class="easyui-combobox oa_input"
						    			   data-options="err:err,
						    			   				 limitToList:true,
						    			   				 valueField:'area_id',    
	    							 					 textField:'name',  
						    			   				 height:'25',
						    			   				 width:'200',
						    			   				 multiline:false,
						    			   				 panelHeight:'auto',
						    			   				 panelMaxHeight:120,
						    			   				 panelWidth:'',
						    			   				 disabled:true,
														 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
														 ">						 				 
								</td>
							</tr>
	
							<tr>
								<td class="field_s" style="height:35px;vertical-align:text-top;"  >
									备注
								</td>
								<td style="height:35px;vertical-align:text-top;"  colspan="3">
									<input name="content[gfc_note]"
										   oaname="content[gfc_note]"
										   class="easyui-textbox oa_input"
										   data-options="err:err,
						    			   				 height:'50',
						    			   				 width:'100%',
						    			   				 multiline:true,
														 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
														 ">
								</td>	
							</tr>
							
							<tr class="tr_title">
		                    	<td colspan="4" style="height:35px;text-align:left"  >
		                    		<span>组成员</span>
		                    	</td>
		                    </tr>	
		                    
		                    <tr>
								<td colspan="4" style="height:35px;vertical-align:text-center;padding-top:10px;"  >
									<div id="table_pm_c_tool<?=$time?>">
										<table style="width:100%;">
											<tr>
												<td style="width:'50%';" >
													<a href="javascript:void(0)" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-add',plain:true" onClick="fun_table_pm_c_operate<?=$time?>('add')">添加</a>
													<a href="javascript:void(0)" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-remove',plain:true" onClick="fun_table_pm_c_operate<?=$time?>('del')">删除</a>
												</td>
												<td style="width:'50%';text-align:right;">
												</td>
											</tr>
										</table>
									</div>
									<table id="table_pm_c<?=$time?>"
										   name="content[pm_c]"
										   oaname="content[pm_c]"
										   class="oa_input data_table"
									>
									</table>
								</td>
							</tr>
		                    
				         	</table>
				         	
				         	<!-- 数据校验时间 -->
							<input class="db_time_update" name="content[db_time_update]" type="hidden" />
				        </div>
				        
				        <div title="开票回款分解<span id='sp_kpbp<?=$time?>' class='m-badge' style='display:none'></span>"
				        	 oaname="tab_kphk"
				        	 class="oa_op"
				         	 style="">  
				         	
				         	<?php include 'edit_gfc_bp.php';?>
							<?php include 'edit_gfc_bp_js.php';?>
				         	 
				        </div>
				        
				         <div title="设备清单<span id='sp_eq_list<?=$time?>' class='m-badge' style='display:none'></span>"
				        	 oaname="tab_eq_list"
				        	 class="oa_op"
				         	 style="">
				         	 
				         	<?php include 'edit_gfc_el.php';?>
							<?php include 'edit_gfc_el_js.php';?>  
				         	 
				        </div>
				        
				        <div title="预算表<span id='sp_bud<?=$time?>' class='m-badge' style='display:none'></span>"
				        	 oaname="tab_bud"
				        	 class="oa_op"
				         	 style="">  
				         	 
				         	<?php include 'edit_gfc_bud.php';?>
							<?php include 'edit_gfc_bud_js.php';?>
				         	 
				        </div>
				        
				        <div title="标密申请单<span id='sp_sercet<?=$time?>' class='m-badge' style='display:none'></span>"
				        	 oaname="tab_secret"
				        	 class="oa_op"
				         	 style="">  
				         	 
				         	<?php include 'edit_gfc_secret.php';?>
							<?php include 'edit_gfc_secret_js.php';?>
				        </div>
				        
				        <div title="指定评审人<span id='sp_check_person<?=$time?>' class='m-badge' style='display:none'></span>"
				        	 oaname="tab_check_person"
				        	 class="oa_op"
				         	 style="">  
				         	<?php include 'edit_gfc_cr.php';?>
							<?php include 'edit_gfc_cr_js.php';?>
				        </div>
			        
					</div>
		 		</form>
		 		
		 		<!-- 验证错误 -->
         		<input id="hd_err_f_<?=$time?>" type="hidden" /> 
         		 
         		<input id="hd_f_t_file_<?=$time?>" type="hidden" /> 
		 	</div>
		 	
		</div>
		
         
    </div>
    <div title="操作日志" 
    	 oaname="tab_log"
       	 data-options="iconCls:'icon-log',
       				  href:'base/main/load_win_log_operate',
       				  queryParams:{
       				  	parent_id: 'tab_edit_<?=$time?>',
						op_id: '<?=$gfc_id?>',
						table: 'pm_given_financial_code',
						field: 'gfc_id',
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
						op_id: '<?=$gfc_id?>',
						pp_id: '<?=$pp_id?>',
						time: 'wl_<?=$time?>'
       				 }"
       	>
       	
    </div>
    
    <div title="关联文件" 
    	 oaname="tab_file"
       	 data-options="iconCls:'icon-file',
       				  href:'base/main/load_win_file_link',
       				  queryParams:{
       				  	parent_id: 'tab_edit_<?=$time?>',
						op_id: '<?=$gfc_id?>',
						table: 'pm_given_financial_code',
						field: 'gfc_id',
						pp_id: '<?=$pp_id?>',
						time: 'file_<?=$time?>',
						search_f_t_proc: '<?=$proc_id?>',
						flag_f_type_more: 'false',
						fun_m: 'm_gfc',
						fun_ck: 'check_file'
       				 }"
       	>
       	
    </div>
    
</div>

<!-- loading -->
<div id="win_loading<?=$time?>" style="padding:5px;overflow:hidden;"></div> 