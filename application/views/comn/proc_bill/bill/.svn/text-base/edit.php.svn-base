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
    <div title="开票信息" 
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
		 		<center><span class="tb_title"><b>开票信息</b></span></center>
		 		
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
		       				<a href="javascript:void(0)" oaname="btn_import" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-xlsx'" onClick="fun_xlsx_import('proc_contact/m_contact','联系人','proc_contact/contact/import')">导入</a>  
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
		 	
		 		<div style="position: absolute;right:20px;top:5px;width:40px;">
		 			<a href="javascript:void(0)" oaname="btn_wl" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-wl'" style="width:35px;margin-bottom:5px;" title="审批信息" onClick="$('#tab_edit_<?=$time?>').tabs('select',2)"></a>
		 			<a href="javascript:void(0)" oaname="btn_im" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-im'" style="width:35px;margin-bottom:5px;" title="308" onClick="fun_im_wl('<?=$bill_id?>','<?=$pp_id?>')"></a>
		 		</div >
		 		<form id="f_<?=$time?>" class="easyui-form" method="post" data-options="novalidate:false" time="<?=$time?>"> 
		 			<table id="table_f_<?=$time?>" style="width:800px;margin:0 auto;">
						<tr class="set_width"> 
	                    	<td style="width:120px"></td> 
                            <td style="width:280px"></td> 
	                        <td style="width:120px"></td> 
                            <td style="width:280px"></td>  
	                    </tr> 
	                    
	                    <tr class="tr_title oa_op" > 
	                    	<td colspan="4" style="height:35px;vertical-align:text-center;"  > 
	                    		<span>项目信息</span>
	                    	</td>
	                    </tr>
	                    <tr>
	                    	<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
	                    		财务编号
                            </td>
                            <td style="height:35px;vertical-align:text-center;"  colspan="3">
                            	<span name="content[gfc_finance_code]" 
					    			  oaname="content[gfc_finance_code]"
					    			  class="oa_input"
					    			>
					    		</span>
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
	                    		项目名称
                            </td>
                            <td style="height:35px;vertical-align:text-center;"  colspan="3"> 
                            	<input name="content[gfc_name]"
									   oaname="content[gfc_name]"
									   id="txtb_gfc_name<?=$time?>" 
									   class="easyui-textbox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'100%',
					    			   				 multiline:false,
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 fun_ready: 'load_gfc_id<?=$time?>()'
													 "
								>
								<input id="txtb_gfc_id<?=$time?>" 
									   name="content[gfc_id]"
									   oaname="content[gfc_id]"
									   class="oa_input"
									   type="hidden"/>	
                            </td>
	                    </tr>
	                    <tr>
	                    	<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
	                    		合同总额
                            </td>
                            <td style="height:35px;vertical-align:text-center;" >
                            	<span name="content[gfc_sum]" 
					    			  oaname="content[gfc_sum]"
					    			  class="oa_input"
					    			>
					    		</span>
                            </td>
                            <td class="field_s" style="height:35px;vertical-align:text-center;"  > 
	                    		项目负责人
                            </td>
                            <td style="height:35px;vertical-align:text-center;" >
                            	<span name="content[gfc_c_s]" 
					    			  oaname="content[gfc_c_s]"
					    			  class="oa_input"
					    			>
					    		</span>
                            </td>
                        </tr>
	                    <tr>
	                    	<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
	                    		开票计划
                            </td>
                            <td style="height:35px;vertical-align:text-center;" colspan = "2">
                            	<input name="content[bp_id]"
									   oaname="content[bp_id]"
									   class="easyui-combogrid oa_input"
									   id="txtb_bp_id<?=$time?>" 
									   data-options="err:err,
					    			   				 limitToList:true,
					    			   				 idField:'bp_id_s',    
            										 textField:'bp_show',    
					    			   				 height:'25',
					    			   				 width:'350px',
					    			   				 multiline:false,
					    			   				 panelHeight:'auto',
					    			   				 panelMaxHeight:120,
					    			   				 panelWidth:'420',
					    			   				 columns:[[    
					    			   				 	{field:'bp_time',title:'开票时间',width:150,halign:'center',align:'left',formatter: fun_index_bp_formatter<?=$time?>},   
										                {field:'bp_type',title:'货款性质',width:100,halign:'center',align:'center',formatter: fun_index_bp_formatter<?=$time?>},    
										                {field:'bp_sum',title:'金额',width:150,halign:'center',align:'right',formatter: fun_index_bp_formatter<?=$time?>},    
										             ]], 
										             onLoadSuccess: function(data)
													 {
										                $('.prog_bp_sum<?=$time?>').progressbar();
														$('.prog_bp_sum<?=$time?>').find('.progressbar-text').css('text-align','right');
													 },
										             onSelect: function(index,row)
										             {
										                var bill_sum = $('#txtb_bill_sum<?=$time?>').numberbox('getValue');
										                
										                var bp_sum_kp = base64_decode(row.bp_sum_kp);
										                if( ! bill_sum )
										                {
											             	bill_sum = parseFloat(base64_decode(row.bp_sum)) - parseFloat(bp_sum_kp);
											             	$('#txtb_bill_sum<?=$time?>').numberbox('setValue',bill_sum);
										             	}
										             	
										             	load_gfc_bp_prog<?=$time?>();
										             	
										             	fun_tr_title_show($('#table_f_<?=$time?>'),'title_bsi',1);
										             	var url = 'proc_bs/bs_item/get_json/search_bp_id/'+base64_decode(row.bp_id);
										             	$('#table_bsi<?=$time?>').datagrid('reload',url);
										             },
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 fun_ready: 'load_bp_id<?=$time?>()'
													 ">
                            </td>
                            <td id="gfc_bp_prog<?=$time?>" style="height:35px;vertical-align:text-center" >
                            	<!--  
                            	<div id="gfc_bp_prog<?=$time?>"
	                    		     class="easyui-progressbar oa_input" 
	                    		     name = "content[gfc_bp_prog]"
                            		 oaname = "content[gfc_bp_prog]"
	                    		     style="width:200px;margin-left:50px;"></div>
	                    		 -->
                            </td>
                        </tr>
                        <tr class="tr_title oa_op" oaname="title_bsi" > 
	                    	<td colspan="4" style="height:35px;vertical-align:text-center;"  > 
	                    		<span>预收账款</span>
	                    	</td>
	                    </tr>
	                    <tr>
							<td colspan="4" style="height:35px;vertical-align:text-center;padding-top:10px;"  >
								<table id="table_bsi<?=$time?>"
									   name="content[bsi]"
									   oaname="content[bsi]"
									   class="oa_input data_table"
								>
								</table>
								
							</td>
						</tr>
	                    <tr class="tr_title oa_op" > 
	                    	<td colspan="4" style="height:35px;vertical-align:text-center;"  > 
	                    		<span>基本信息</span>
	                    	</td>
	                    </tr>
	                    <tr>
	                    	<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	所属机构
                            </td>
                            <td style="height:35px;vertical-align:text-center;"  colspan="3"> 
                            	<input name="content[bill_org_owner]" 
					    			   oaname="content[bill_org_owner]"
					    			   id="txtb_bill_org_owner<?=$time?>"
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
                               	客户名称
                            </td>
                            <td style="height:35px;vertical-align:text-center;"  colspan="3"> 
                            	<input name="content[bill_org_customer_s]"
									   oaname="content[bill_org_customer_s]"
									   id="txtb_bill_org_customer_s<?=$time?>" 
									   class="easyui-textbox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'100%',
					    			   				 multiline:false,
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 fun_ready: 'load_bill_org_customer<?=$time?>()'
													 "
								>
								<input id="txtb_bill_org_customer<?=$time?>" 
									   name="content[bill_org_customer]"
									   oaname="content[bill_org_customer]"
									   class="oa_input"
									   type="hidden"/>	
                            </td>
	                    </tr>
	                    
	                    <tr>
	                    	<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	流转税
                            </td>
                            <td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                            	<input name="content[bill_tax_s]"
									   oaname="content[bill_tax_s]"
									   id="txtb_bill_tax_s<?=$time?>" 
									   class="easyui-textbox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
					    			   				 multiline:false,
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 fun_ready: 'load_bill_tax<?=$time?>()'
													 "
								>
								<input id="txtb_bill_tax<?=$time?>" 
									   name="content[bill_tax]"
									   oaname="content[bill_tax]"
									   class="oa_input"
									   type="hidden"/>	
                            </td>
                            <td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	发票类型
                            </td>
                            <td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                            	<input name="content[bill_category]"
									   oaname="content[bill_category]"
									   id="txtb_bill_category<?=$time?>"
									   class="easyui-combobox oa_input"
									   data-options="err:err,
					    			   				 limitToList:true,
					    			   				 valueField:'id',    
						    						 textField:'text',
					    			   				 height:'25',
					    			   				 width:'200px',
					    			   				 multiline:false,
					    			   				 panelHeight:'auto',
					    			   				 panelMaxHeight:120,
					    			   				 panelWidth:'',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 onSelect:function(record)
													 {
													 	$(this).combobox('setText',record.text);
													 	$('#txtb_it_taking_count<?=$time?>').val(base64_decode(record.it_taking_count))
													 	$('#txtb_it_tax_count<?=$time?>').val(base64_decode(record.it_tax_count))
													 	fun_bill_count<?=$time?>();
													 	load_gfc_bp_prog<?=$time?>();
													 },
													 fun_ready: 'load_bill_category<?=$time?>()'
													 ">
								<input id="txtb_it_taking_count<?=$time?>" 
									   name="content[it_taking_count"
									   oaname="content[it_taking_count]"
									   class="oa_input"
									   type="hidden"/>	
								<input id="txtb_it_tax_count<?=$time?>" 
									   name="content[it_tax_count]"
									   oaname="content[it_tax_count]"
									   class="oa_input"
									   type="hidden"/>			   					 
                            </td>
                        </tr>
                        
                         <tr>
	                    	<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	开票金额
                            </td>
                            <td style="height:35px;vertical-align:text-center;"  > 
                            	<input name="content[bill_sum]" 
					    			   oaname="content[bill_sum]"
					    			   id="txtb_bill_sum<?=$time?>"
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
													 	fun_bill_count<?=$time?>();
													 },
													 fun_ready: 'load_bill_sum<?=$time?>()'
													 ">
                            </td>
                            <td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	发票送达方式
                            </td>
                            <td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                            	<input name="content[bill_send_type]"
									   oaname="content[bill_send_type]"
									   class="easyui-combobox oa_input"
									   data-options="err:err,
					    			   				 limitToList:true,
					    			   				 valueField:'id',    
						    						 textField:'text',
					    			   				 height:'25',
					    			   				 width:'200px',
					    			   				 multiline:false,
					    			   				 data: [<?=element('bill_send_type',$json_field_define)?>],
					    			   				 panelHeight:'auto',
					    			   				 panelMaxHeight:120,
					    			   				 panelWidth:'',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                            </td>
                        </tr>
                        <tr>
	                    	<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	营业收入
                            </td>
                            <td style="height:35px;vertical-align:text-center;"  > 
                            	<input name="content[bill_takings_s]" 
					    			   oaname="content[bill_takings_s]"
					    			   id="txtb_bill_takings_s<?=$time?>"
					    			   class="easyui-numberbox oa_input"
					    			   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
					    			   				 precision:2,
					    			   				 min:0,
					    			   				 groupSeparator:',',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 fun_ready: 'load_bill_takings_s<?=$time?>()'
													 ">
                            </td>
                            <td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	税金
                            </td>
                            <td style="height:35px;vertical-align:text-center;"  > 
                            	<input name="content[bill_tax_sum_s]" 
					    			   oaname="content[bill_tax_sum_s]"
					    			   id="txtb_bill_tax_sum_s<?=$time?>"
					    			   class="easyui-numberbox oa_input"
					    			   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
					    			   				 precision:2,
					    			   				 min:0,
					    			   				 groupSeparator:',',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 fun_ready: 'load_bill_tax_sum_s<?=$time?>()'
													 ">
                            </td>
                        </tr>
                        <tr>
	                    	<td class="field_s" style="height:35px;text-align: left">
								开票时间
							</td>
							<td style="height:35px;vertical-align:text-center;" >
								<input name="content[bill_time_node_kp]" 
					    			   oaname="content[bill_time_node_kp]"
					    			   class="easyui-datebox oa_input"
					    			   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200px',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
							</td>
                            <td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	应收账款
                            </td>
                            <td style="height:35px;vertical-align:text-center;"  > 
                            	<input name="content[bill_ending_sum]" 
					    			   oaname="content[bill_ending_sum]"
					    			   id="txtb_bill_ending_sum<?=$time?>"
					    			   class="easyui-numberbox oa_input"
					    			   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
					    			   				 precision:2,
					    			   				 min:0,
					    			   				 groupSeparator:',',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 fun_ready: 'load_bill_ending_sum<?=$time?>()'
													 ">
                            </td>
                        </tr>
                        <tr>
	                    	<td class="field_s" style="height:35px;text-align: left">
								预计回款时间
							</td>
							<td style="height:35px;vertical-align:text-center;" >
								<input name="content[bill_time_return]" 
					    			   oaname="content[bill_time_return]"
					    			   class="easyui-datebox oa_input"
					    			   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200px',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
							</td>
							<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	开票统计人
                            </td>
                            <td style="height:35px;vertical-align:text-center;"  > 
                            	<input name="content[bill_contact_manager_s]" 
					    			   oaname="content[bill_contact_manager_s]"
					    			   id="txtb_bill_contact_manager_s<?=$time?>"
					    			   class="easyui-textbox oa_input"
					    			   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 fun_ready: 'load_bill_contact_manager<?=$time?>()'
													 ">
								<input id="txtb_bill_contact_manager<?=$time?>" 
									   name="content[bill_contact_manager]"
									   oaname="content[bill_contact_manager]"
									   class="oa_input"
									   type="hidden"/>	
                            </td>
						</tr>
						
						<tr class="tr_title oa_op" > 
	                    	<td colspan="4" style="height:35px;vertical-align:text-center;"  > 
	                    		<span>货物设备信息信息</span>
	                    	</td>
	                    </tr>
	                    
	                    <tr>
							<td colspan="4" style="height:35px;vertical-align:text-center;padding-top:10px;"  >
								<div id="table_bei_tool<?=$time?>">
									<table style="width:100%;">
										<tr>
											<td style="width:'50%';" >
												<a href="javascript:void(0)" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-add',plain:true" onClick="fun_table_bei_operate<?=$time?>('add')">添加</a>
												<a href="javascript:void(0)" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-remove',plain:true" onClick="fun_table_bei_operate<?=$time?>('del')">删除</a>
											</td>
											<td style="width:'50%';text-align:right;">
											</td>
										</tr>
										<tr>
											<td colspan="2" >
												<div id="bei_prog<?=$time?>"
					                    		     class="easyui-progressbar oa_input" 
					                    		     name = "content[bei_prog]"
				                            		 oaname = "content[bei_prog]"
					                    		     style="width:100%;"></div> 
											</td>
										</tr>
									</table>
								</div>
								<table id="table_bei<?=$time?>"
									   name="content[bei]"
									   oaname="content[bei]"
									   class="oa_input data_table"
								>
								</table>
								
							</td>
						</tr>
						<tr class="tr_title oa_op" oaname="title_bdi"> 
	                    	<td colspan="4" style="height:35px;vertical-align:text-center;"  > 
	                    		<span>批准发票明细</span>
	                    	</td>
	                    </tr>
	                    
	                    <tr>
							<td colspan="4" style="height:35px;vertical-align:text-center;padding-top:10px;"  >
								<div id="table_bdi_tool<?=$time?>">
									<table style="width:100%;">
										<tr>
											<td style="width:'50%';" >
												<a href="javascript:void(0)" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-add',plain:true" onClick="fun_table_bdi_operate<?=$time?>('add')">添加</a>
												<a href="javascript:void(0)" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-remove',plain:true" onClick="fun_table_bdi_operate<?=$time?>('del')">删除</a>
											</td>
											<td style="width:'50%';text-align:right;">
											</td>
										</tr>
										<tr>
											<td colspan="2" >
												<div id="bdi_prog<?=$time?>"
					                    		     class="easyui-progressbar oa_input" 
					                    		     name = "content[bdi_prog]"
				                            		 oaname = "content[bdi_prog]"
					                    		     style="width:100%;"></div> 
											</td>
										</tr>
									</table>
								</div>
								<table id="table_bdi<?=$time?>"
									   name="content[bdi]"
									   oaname="content[bdi]"
									   class="oa_input data_table"
								>
								</table>
								
							</td>
						</tr>	
						<tr class="tr_title oa_op" oaname="title_bill_link"> 
	                    	<td colspan="4" style="height:35px;vertical-align:text-center;"  > 
	                    		<span>关联单据</span>
	                    	</td>
	                    </tr>
	                    
	                    <tr>
							<td colspan="4" style="height:35px;vertical-align:text-center;padding-top:10px;"  >
								<table id="table_bill_link<?=$time?>"
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
						op_id: '<?=$bill_id?>',
						table: 'fm_bill',
						field: 'bill_id',
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
						op_id: '<?=$bill_id?>',
						pp_id: '<?=$pp_id?>',
						time: 'wl_<?=$time?>'
       				 }"
       	>
       	
    </div>
    
</div>

<!-- loading -->
<div id="win_loading<?=$time?>" style="padding:5px;overflow:hidden;"></div> 