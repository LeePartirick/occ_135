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
    <div title="非开票往来"
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
		 		<center><span class="tb_title"><b>非开票往来</b></span></center>
		 		
		 		<table id="table_h_<?=$time?>" class="table_no_line"  style="width:800px;margin:0 auto;">
		 			<tr>
		       			<td style="width:50%">
		       			<b><?=$code?></b>
		       			</td>
		       			<td style="width:'50%';text-align:right;">
		       			<b><?=$db_time_create?></b>
		       			</td>
		       		</tr>
		       		<tr>
		       			<td style="width:'50%';">
		       				<a href="javascript:void(0)" oaname="btn_save" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-save'" onClick="f_submit_<?=$time?>('save');">保存</a>  
		       				<a href="javascript:void(0)" oaname="btn_import" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-xlsx'" onClick="fun_xlsx_import('proc_loan/m_loan','非开票往来','proc_loan/loan/import')">导入</a>
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
                            <b>当前节点:<?=$ppo_name?></b>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:100%;font-size:14px" colspan="2">
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
		 			<a href="javascript:void(0)" oaname="btn_im" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-im'" style="width:35px;margin-bottom:5px;" title="308" onClick="fun_im_wl('<?=$loan_id?>','<?=$pp_id?>')"></a>
		 		</div >
		 		
		 		<form id="f_<?=$time?>" class="easyui-form" method="post" data-options="novalidate:false" time="<?=$time?>"> 
		 			<table id="table_f_<?=$time?>" style="width:800px;margin:0 auto;">
						<tr class="set_width"> 
	                    	<td style="width:15%"></td>
                            <td style="width:35%"></td>
	                        <td style="width:15%"></td>
                            <td style="width:35%"></td>
	                    </tr> 
	                    
	                    <tr class="tr_title oa_op" oaname = "title_loan_ending">
                            <td colspan="4" style="height:35px;text-align:left"  >
                                <span>个人借款</span>
                            </td>
                        </tr>
                        
                        <tr>
							<td colspan="4" style="height:35px;vertical-align:text-center;padding-top:10px;"  >
								<table id="table_loan_ending<?=$time?>"
									   class="data_table"
								>
								</table>
							</td>
						</tr>
						
						<tr class="tr_title oa_op" oaname = "title_loan_cz">
                            <td colspan="4" style="height:35px;text-align:left"  >
                                <span>关联冲账</span>
                            </td>
                        </tr>
                        
                        <tr>
							<td colspan="4" style="height:35px;vertical-align:text-center;padding-top:10px;"  >
								<table id="table_loan_cz<?=$time?>"
									   class="data_table"
								>
								</table>
							</td>
						</tr>
	                    
	                    <tr class="tr_title oa_op" oaname="title_base">
	                    	<td colspan="4" style="height:35px;text-align:left"  >
	                    		<span>基本信息</span>
	                    	</td>
	                    </tr>

                        <tr>
                            <td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	所属机构
                            </td>
                            <td style="height:35px;vertical-align:text-center;"  colspan="3"> 
                            	<input name="content[loan_org]" 
					    			   oaname="content[loan_org]"
					    			   id="txtb_loan_org<?=$time?>"
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
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                            </td>
                        </tr>
                        
                       <tr>
	                    	<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	单据编号
                            </td>
                            <td style="height:35px;vertical-align:text-center;" > 
                            	<input name="content[loan_code]"
									   oaname="content[loan_code]"
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
								<input name="content[loan_time_node]" 
					    			   oaname="content[loan_time_node]"
					    			   class="easyui-datebox oa_input"
					    			   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200px',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
							</td>
	                    </tr>
	                    
                        <tr>
                            <td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	申请人
                            </td>
                            <td style="height:35px;vertical-align:text-center;"  > 
                            	<input name="content[loan_c_id_s]" 
					    			   oaname="content[loan_c_id_s]"
					    			   id="txtb_loan_c_id_s<?=$time?>"
					    			   class="easyui-textbox oa_input"
					    			   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 fun_ready: 'load_c<?=$time?>()'
													 ">
													 
								<input id="txtb_loan_c_id<?=$time?>" 
									   name="content[loan_c_id]"
									   oaname="content[loan_c_id]"
									   class="oa_input"
									   type="hidden"/>	
									   
								<input id="txtb_loan_c_id_org<?=$time?>" 
									   name="content[loan_c_id_org]"
									   oaname="content[loan_c_id_org]"
									   class="oa_input"
									   type="hidden"/>		   
                            </td>
                            <td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	部门
                            </td>
                            <td style="height:35px;vertical-align:text-center;"  > 
                            	<input name="content[loan_ou_s]" 
					    			   oaname="content[loan_ou_s]"
					    			   id="txtb_loan_ou_s<?=$time?>"
					    			   class="easyui-textbox oa_input"
					    			   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 fun_ready: 'load_ou<?=$time?>()'
													 ">
								<input id="txtb_loan_ou<?=$time?>" 
									   name="content[loan_ou]"
									   oaname="content[loan_ou]"
									   class="oa_input"
									   type="hidden"/>	
                            </td>
                        </tr>
                        
                        <tr>
                            <td class="field_s" style="height:35px;vertical-align:text-center;"  > 
	                    		关联项目
                            </td>
                            <td style="height:35px;vertical-align:text-center;" > 
                            	<input name="content[loan_gfc_id_s]"
									   oaname="content[loan_gfc_id_s]"
									   id="txtb_loan_gfc_id_s<?=$time?>" 
									   class="easyui-textbox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
					    			   				 multiline:false,
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 fun_ready: 'load_gfc_id<?=$time?>()'
													 "
								>
								<input id="txtb_loan_gfc_id<?=$time?>" 
									   name="content[loan_gfc_id]"
									   oaname="content[loan_gfc_id]"
									   class="oa_input"
									   type="hidden"/>	
                            </td>
                            <td class="field_s" style="height:35px;text-align: left">
                               	 财务属性
                            </td>
                            <td style="height:35px;vertical-align:text-center;">
                                <input name="content[loan_category_finance]"
                                       oaname="content[loan_category_finance]"
                                       class="easyui-combobox oa_input"
                                       data-options="err:err,
					    			   				 limitToList:true,
					    			   				 valueField:'id',
						    						 textField:'text',
					    			   				 height:'25',
					    			   				 width:'200',
					    			   				 mutiline:false,
					    			   				 data: [<?=element('loan_category_finance',$json_field_define)?>],
					    			   				 panelHeight:'auto',
					    			   				 panelMaxHeight:120,
					    			   				 panelWidth:'',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                            </td>
                        </tr>

						<tr>
							<td class="field_s" style="height:35px;text-align: left">
								预算科目
							</td>
							<td style="height:35px;vertical-align:text-center;">
								<input name="content[loan_sub_s]"
									   oaname="content[loan_sub_s]"
                                       id="txtb_loan_sub_s<?=$time?>"
									   class="easyui-textbox oa_input"
                                       data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
					    			   				 multiline:false,
					    			   				 fun_ready:'load_sub<?=$time?>()',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 onChange:function(nV,oV)
													 {
													 	if( ! nV )
													 	{
													 		$('#txtb_loan_ou_tj<?=$time?>').combobox('clear');
															$('#txtb_loan_ou_tj<?=$time?>').combobox('loadData',[]);
													 	}
													 }
													 ">
                                <input name="content[loan_sub]"
                                       oaname="content[loan_sub]"
                                       id="txtb_loan_sub<?=$time?>"
                                       class="oa_input"
                                       type="hidden"
                                       >
							</td>

							<td class="field_s" style="height:35px;text-align: left">
								支付方式
							</td>
							<td style="height:35px;vertical-align:text-center;" >
								<input name="content[loan_pay_type]"
									   oaname="content[loan_pay_type]"
									   class="easyui-combobox oa_input"
									   data-options="err:err,
					    			   				 limitToList:true,
					    			   				 valueField:'id',
						    						 textField:'text',
					    			   				 height:'25',
					    			   				 width:'200',
					    			   				 mutiline:false,
					    			   				 data: [<?=element('loan_pay_type',$json_field_define)?>],
					    			   				 panelHeight:'auto',
					    			   				 panelMaxHeight:120,
					    			   				 panelWidth:'',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">

							</td>
						</tr>

						<tr>
							<td class="field_s" style="height:35px;text-align: left">
								金额
							</td>
							<td style="height:35px;vertical-align:text-center;"  >
								<input name="content[loan_sum]"
									   oaname="content[loan_sum]"
                                       id="txtb_loan_sum<?=$time?>"
									   class="easyui-numberbox oa_input"
                                       data-options="err:err,
									   				 precision:2,
									   				 decimalSeparator:'.',
									   				 groupSeparator:',',
									   				 height:'25',
									   				 width:'200',
									   				 fun_ready: 'load_loan_sum<?=$time?>()',
									   				 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
									   				 onChange:function(nV,oV)
									   				 {
									   				 	var sum = nV;
														var sub = $('#txtb_loan_sub<?=$time?>').val();
														var ou = data_<?=$time?>['content[loan_ou_tj]'];
														if( sub && sum)
														{
															var url = 'proc_bud/bl_ppo/get_json_ou/from/combobox/field_id/link_id/field_text/ou_name/search_sub/'+sub+'/search_sum/'+sum;
															if( ou ) url += '/search_ou/'+ou;
															$('#txtb_loan_ou_tj<?=$time?>').combobox('reload',url);
															$('#txtb_loan_ou_tj<?=$time?>').combobox('clear');
															
															load_loan_bud<?=$time?>();
														}
									   				 }
									   			">
							</td>
							<td class="field_s oa_op" style="height:35px;text-align: left" oaname="content[loan_ending_sum]">
								未冲账金额
							</td>
							<td class="oa_op" style="height:35px;vertical-align:text-center;" oaname="content[loan_ending_sum]">
								<input name="content[loan_ending_sum]"
									   oaname="content[loan_ending_sum]"
									   class="easyui-numberbox oa_input"
									   id = "txtb_loan_ending_sum<?=$time?>"
                                       data-options="err:err,
									   				 precision:2,
									   				 decimalSeparator:'.',
									   				 groupSeparator:',',
									   				 height:'25',
									   				 width:'200',
									   				 multiline:false,
									   				 fun_ready: 'load_loan_ending_sum<?=$time?>()',
									   				 validType:['errMsg[\'#hd_err_f_<?=$time?>\']']">
							</td>
							<td class="oa_op" id="loan_bud<?=$time?>" style="height:35px;text-align: left" oaname="loan_bud" colspan = "2">
							
							
							</td>
						</tr>

						<tr>
							<td class="field_s" style="height:35px;text-align:left"  >
								预计归还月
							</td>
							<td style="height:35px;vertical-align:text-center;">
                                <input name="content[loan_return_month]"
                                       oaname="content[loan_return_month]"
                                       class="easyui-datebox oa_input"
                                       data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
					    			   				 multiline:false,
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']']">
                            </td>
                            <td class="field_s" style="height:35px;text-align:left" >
                                	统计部门
                            </td>
                            <td style="height:35px;vertical-align:text-center;">
                                <input name="content[loan_ou_tj]"
									   oaname="content[loan_ou_tj]"
									   class="easyui-combobox oa_input"
									   id="txtb_loan_ou_tj<?=$time?>"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
					    			   				 valueField: 'id',    
        											 textField: 'text', 
					    			   				 panelHeight:'auto',
					    			   				 panelMaxHeight:120,
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 onBeforeLoad:function()
													 {
													 	if( check_loan_ou_tj<?=$time?> != 1 ) 
													 	return false;
													 },
													 onLoadSuccess:function()
													 {
													 	var data = $(this).combobox('getData');
													 	if(data.length == 0 ) 
													 	{ 
													 	  load_loan_ou_tj_auto<?=$time?>();
													 	  return;
													 	}
													 	else
													 	for( var i = 0 ;i < data.length ; i++)
													 	{
													 		if(data[i].flag_read && i == 0) 
													 		{ 
													 		  load_loan_ou_tj_auto<?=$time?>();
													 		  return;
													 		}
													 	}
													 	
													 	load_loan_ou_tj_combobox<?=$time?>();
													 },
													 fun_ready: 'load_loan_ou_tj<?=$time?>()'
													 ">
                            </td>
						</tr>
                        <tr>
                            <td class="field_s" style="height:35px;vertical-align:text-center;"  >
                                	付款单位
                            </td>
                            <td style="height:35px;vertical-align:text-center;"  colspan="3">
                                <input name="content[loan_o_id_s]"
                                       oaname="content[loan_o_id_s]"
                                       id="txtb_loan_o_id_s<?=$time?>"
                                       class="easyui-textbox oa_input"
                                       data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'100%',
					    			   				 multiline:true,
					    			   				 fun_ready:'load_loan_o_id<?=$time?>()',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                            <input name="content[loan_o_id]"
                                    oaname="content[loan_o_id]"
                                    id="txtb_loan_o_id<?=$time?>"
                                    class="oa_input"
                                    type="hidden">
                        </tr>
                        <tr>
                            <td class="field_s" style="height:35px;vertical-align:text-center;"  >
                                	开户行
                            </td>
                            <td style="height:35px;vertical-align:text-center;"  colspan="3">
                                <input name="content[loan_oacc_bank]"
                                       oaname="content[loan_oacc_bank]"
                                       id="txtb_loan_oacc_bank<?=$time?>"
                                       class="easyui-combobox oa_input"
                                       data-options="err:err,
					    			   				 limitToList:true,
					    			   				 valueField:'id',
						    						 textField:'text',
					    			   				 height:'25',
					    			   				 width:'100%',
					    			   				 multiline:false,
					    			   				 panelHeight:'auto',
					    			   				 panelMaxHeight:120,
					    			   				 panelWidth:'',
					    			   				 data: [<?=element('loan_oacc_bank',$json_field_define)?>],
					    			   				 fun_ready:'load_loan_oacc_bank<?=$time?>()',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                        </tr>
                        <tr>
                            <td class="field_s" style="height:35px;vertical-align:text-top;"  >
                                	用途
                            </td>
                            <td style="height:35px;vertical-align:text-top;"  colspan="4">
                                <input name="content[loan_note]"
                                       oaname="content[loan_note]"
                                       class="easyui-textbox oa_input"
                                       data-options="err:err,
					    			   				 height:'50',
					    			   				 width:'100%',
					    			   				 multiline:true,
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                        </tr>

                        <tr class="tr_title oa_op" oaname = "title_gfc">
                            <td colspan="4" style="height:35px;text-align:left"  >
                                <span>项目信息</span>
                            </td>
                        </tr>

                        <tr>
                            <td class="field_s" style="height:35px;text-align: left">
                                	项目名称
                            </td>
                            <td colspan="3">
                                <span name="content[gfc_name]" 
                                	  oaname="content[gfc_name]"  
                                	  class="oa_input"></span>
                            </td>
						</tr>
                        <tr>
                            <td class="field_s oa_op" style="height:35px;vertical-align:text-center;">
                                	财务编号
                            </td>
                            <td class="oa_op" style="height:35px;vertical-align:text-center;" >
                                <span name="content[gfc_finance_code]" 
                                 	  oaname="content[gfc_finance_code]"  
                                 	  class="oa_input"></span>
                            </td>
                            <td class="field_s" style="height:35px;text-align: left">
                                	合同总额
                            </td>
                            <td style="height:35px;vertical-align:text-center;" >
                                <span name="content[gfc_sum]" 
	                                  oaname="content[gfc_sum]" 
	                                  class="oa_input" ></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="field_s oa_op" style="height:35px;vertical-align:text-center;">
                                	统计部门
                            </td>
                            <td class="oa_op" style="height:35px;vertical-align:text-center;" colspan="3">
                                <span name="content[gfc_ou_tj]" 
                                	  oaname="content[gfc_ou_tj]" 
                                	  class="oa_input" 、></span>
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
						op_id: '<?=$loan_id?>',
						table: 'fm_loan',
						field: 'loan_id',
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
						op_id: '<?=$loan_id?>',
						pp_id: '<?=$pp_id?>',
						time: 'wl_<?=$time?>'
       				 }"
       	>
       	
    </div>
    
</div>

<!-- loading -->
<div id="win_loading<?=$time?>" style="padding:5px;overflow:hidden;"></div> 