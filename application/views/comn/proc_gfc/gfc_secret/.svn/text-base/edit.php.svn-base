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
    <div title="标密申请单"
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
		 		<center><span class="tb_title"><b>标密申请单</b></span></center>
		 		
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
		       				<a href="javascript:void(0)" oaname="btn_import" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-xlsx'" onClick="fun_xlsx_import('proc_gfc/m_gfc_secret','标密申请单','proc_gfc/gfc_secret/import')">导入</a>
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
		 	
		 		<div style="position: absolute;right:15px;top:5px;width:40px;">
		 			<a href="javascript:void(0)" oaname="btn_wl" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-wl'" style="width:35px;margin-bottom:5px;" title="审批信息" onClick="$('#tab_edit_<?=$time?>').tabs('select',2)"></a>
		 			<a href="javascript:void(0)" oaname="btn_im" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-im'" style="width:35px;margin-bottom:5px;" title="308" onClick="fun_im_wl('<?=$gfcs_id?>','<?=$pp_id?>')"></a>
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
								部门
							</td>
							<td style="height:35px;vertical-align:text-center;">
								<span name="content[gfc_ou_s]" 
					    			  oaname="content[gfc_ou_s]"
					    			  class="oa_input"
					    			>
					    		</span>
							</td>
						</tr>
	                    
	                    <tr>
							<td class="field_s" style="height:35px;text-align: left">
								项目密级
							</td>
							<td style="height:35px;vertical-align:text-center;">
								<input name="content[gfcs_category_secret]"
									   oaname="content[gfcs_category_secret]"
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
													 		$('#tr_gfcs_tm_name<?=$time?>').hide();
													 	}
													 	else
													 	{
													 		$('#tr_gfcs_tm_name<?=$time?>').show();
													 	}
													 }
													 ">
							</td>
							
							<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	审批人
                            </td>
                            <td style="height:35px;vertical-align:text-center;"  > 
                            	<input name="content[gfcs_c_check]" 
					    			   oaname="content[gfcs_c_check]"
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
							</td>			   
	                    </tr>
	                    
	                    <tr id="tr_gfcs_tm_name<?=$time?>">
							<td class="field_s oa_op" oaname="content[gfcs_name_tm]" style="height:35px;vertical-align:text-center;">
								脱密后项目全称
							</td>
							<td class="oa_op" oaname="content[gfcs_name_tm]" style="height:35px;vertical-align:text-center;" colspan="3">
								<input name="content[gfcs_name_tm]"
									   oaname="content[gfcs_name_tm]"
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
								备注
							</td>
							<td style="height:35px;vertical-align:text-center;"  colspan="3">
								<input name="content[gfcs_note]"
									   oaname="content[gfcs_note]"
									   class="easyui-textbox oa_input"
									   data-options="err:err,
					    			   				 height:'50',
					    			   				 width:'100%',
					    			   				 multiline:true,
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
						</tr>
						
						<tr class="tr_title">
	                    	<td colspan="4" style="height:35px;text-align:left"  >
	                    		<span>项目信息</span>
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
                               	甲方联系人
                            </td>
                            <td style="height:35px;vertical-align:text-center;"  > 
                            	<span name="content[gfc_c_jia]" 
					    			  oaname="content[gfc_c_jia]"
					    			  class="oa_input"
					    			>
				    			</span>
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
                               	合同总额
                            </td>
                            <td style="height:35px;vertical-align:text-center;"  > 
                            	<span name="content[gfc_sum]" 
					    			  oaname="content[gfc_sum]"
					    			  class="oa_input"
					    			>
					    		</span>	
                            </td>
                            
                            <td class="field_s" style="height:35px;text-align: left">
								预计签约时间
							</td>
							<td style="height:35px;vertical-align:text-center;" >
								<span name="content[gfc_pt_plan_sign]" 
					    			  oaname="content[gfc_pt_plan_sign]"
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
								先实施后签约
							</td>
							<td style="height:35px;vertical-align:text-center;" >
								<span name="content[gfc_category_contract]" 
					    			  oaname="content[gfc_category_contract]"
					    			  class="oa_input"
					    			>
					    		</span>	
							</td>
						</tr>
						
						<tr>
							<td class="field_s" style="height:35px;text-align: left">
								条线
							</td>
							<td style="height:35px;vertical-align:text-center;" >
								<span name="content[gfc_category_tiaoxian_main]" 
					    			  oaname="content[gfc_category_tiaoxian_main]"
					    			  class="oa_input"
					    			>
					    		</span>	
							</td>
							
							<td class="field_s" style="height:35px;text-align: left">
								行业
							</td>
							<td style="height:35px;vertical-align:text-center;" >
								<span name="content[gfc_category_tiaoxian]" 
					    			  oaname="content[gfc_category_tiaoxian]"
					    			  class="oa_input"
					    			>
					    		</span>	
							</td>

						</tr>
						<tr>
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
							
							<td class="field_s" style="height:35px;text-align: left">
								附加属性II
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
								是否总分包合同
							</td>
							<td style="height:35px;vertical-align:text-center;" >
								<span name="content[gfc_category_subc]" 
					    			  oaname="content[gfc_category_subc]"
					    			  class="oa_input"
					    			>
					    		</span>	
							</td>
							
							<td class="field_s" style="height:35px;text-align: left">
								是否合作项目
							</td>
							<td style="height:35px;vertical-align:text-center;" >
								<span name="content[gfc_category_cooperation]" 
					    			  oaname="content[gfc_category_cooperation]"
					    			  class="oa_input"
					    			>
					    		</span>	
							</td>

						</tr>
						<tr>
							<td class="field_s" style="height:35px;text-align: left">
								区域
							</td>
							<td style="height:35px;vertical-align:text-center;" colspan="3">
								<span name="content[gfc_area_show]" 
					    			  oaname="content[gfc_area_show]"
					    			  class="oa_input"
					    			>
					    		</span>						 				 
							</td>
						</tr>

						<tr>
							<td class="field_s" style="height:35px;vertical-align:text-top;"  >
								备注
							</td>
							<td style="height:35px;vertical-align:text-top;"  colspan="3">
								<span name="content[gfc_note]" 
					    			  oaname="content[gfc_note]"
					    			  class="oa_input"
					    			>
					    		</span>
							</td>	
						</tr>

	                 </table> 
	                 
	                 <input name="content[gfc_id]" oaname="content[gfc_id]" class="oa_input" type="hidden" />
	                 
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
						op_id: '<?=$gfcs_id?>',
						table: 'pm_gfc_secret',
						field: 'gfcs_id',
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
						op_id: '<?=$gfcs_id?>',
						pp_id: '<?=$pp_id?>',
						time: 'wl_<?=$time?>'
       				 }"
       	>
       	
    </div>
</div>

<!-- loading -->
<div id="win_loading<?=$time?>" style="padding:5px;overflow:hidden;"></div> 