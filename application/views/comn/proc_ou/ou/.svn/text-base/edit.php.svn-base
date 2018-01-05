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
    <div title="团队" 
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
		 		<center><span class="tb_title"><b>团队</b></span></center>
		 		
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
		       				<a href="javascript:void(0)" oaname="btn_import" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-xlsx'" onClick="fun_xlsx_import('proc_ou/m_ou','团队','proc_ou/ou/import')">导入</a>  
		       			</td>
		       			<td style="width:'50%';text-align:right;">
		       				<a href="javascript:void(0)" oaname="btn_person" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-man'" onClick="fun_person_create($('#f_<?=$time?>'),'<?=$url_conf?>')">个性化</a>  
		       				<a href="javascript:void(0)" oaname="btn_log" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-log'" onClick="$('#tab_edit_<?=$time?>').tabs('select',1)">日志</a>  
		       				<a href="javascript:void(0)" oaname="btn_del" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-cancel'" onClick="$.messager.confirm('确认','您确认想要删除记录吗？',function(r){if(r)f_submit_<?=$time?>('del');});">删除</a>  
		       			</td>
		       		</tr>
		       	</table>
		 	</div>
		 	
		 	<div data-options="region:'center',border:false" style="padding:5px;">
		 		<form id="f_<?=$time?>" class="easyui-form" method="post" data-options="novalidate:false" time="<?=$time?>"> 
		 			<table id="table_f_<?=$time?>" style="width:800px;margin:0 auto;">
						<tr class="set_width"> 
	                    	<td style="width:15%"></td> 
                            <td style="width:35%"></td> 
	                        <td style="width:15%"></td> 
                            <td style="width:35%"></td> 
	                    </tr> 
	                    
	                    <tr class="tr_title" > 
	                    	<td colspan="4" style="height:35px;vertical-align:text-center;"  > 
	                    		<span>基本信息</span>
	                    	</td>
	                    </tr>
	                    <tr>
	                    	<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	所属机构
                            </td>
                            <td style="height:35px;vertical-align:text-center;" colspan="3" > 
                            	<input name="content[ou_org_s]" 
					    			   oaname="content[ou_org_s]"
					    			   class="easyui-textbox oa_input"
					    			   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'100%',
					    			   				 multiline:false,
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                            </td>
                         </tr>
	                    <tr>
	                    	<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	团队名称
                            </td>
                            <td style="height:35px;vertical-align:text-center;" colspan="3" > 
                            	<input name="content[ou_name]" 
					    			   oaname="content[ou_name]"
					    			   class="easyui-textbox oa_input"
					    			   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'100%',
					    			   				 multiline:false,
													 validType:['length[0,80]','errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                            </td>
                            
                         </tr>
                         
                         <tr>
	                    	<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	上级团队
                            </td>
                            <td style="height:35px;vertical-align:text-center;" colspan="3"> 
                            	<input name="content[ou_parent_s]" 
					    			   oaname="content[ou_parent_s]"
					    			   id="txtb_ou_parent_s<?=$time?>"
					    			   class="easyui-textbox oa_input"
					    			   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'100%',
					    			   				 multiline:false,
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 fun_ready: 'load_ou_parent<?=$time?>()'
													 ">
								<input id="txtb_ou_parent<?=$time?>" 
									   name="content[ou_parent]"
									   oaname="content[ou_parent]"
									   class="oa_input"
									   type="hidden"/>					 
								<script type="text/javascript" >
								function load_ou_parent<?=$time?>()
								{
									var opt = $('#txtb_ou_parent_s<?=$time?>').textbox('options');

									if(  opt.readonly ) return;

									$('#txtb_ou_parent_s<?=$time?>').textbox({
								    	onClickButton:function()
								        {
											$(this).textbox('clear');
											$('#txtb_ou_parent<?=$time?>').attr('value','');
								        },
										icons: [{
											iconCls:'icon-tree',
											handler: function(e){

												var win_id=fun_get_new_win();
												
												$('#'+win_id).window({
													title: '团队树-双击选择',
													inline:true,
													modal:true,
													border:'thin',
													draggable:false,
													resizable:false,
													collapsible:false,  
													minimizable: false,
													maximizable: false,
													onClose: function()
													{
														$('#'+win_id).window('destroy');
														$('#'+win_id).remove();
													}
												})
												var url = 'proc_ou/ou/win_tree/flag_select/1/fun_select/fun_get_ou_parent<?=$time?>'
												$('#'+win_id).window('refresh',url+'/fun_open/win/fun_open_id/'+win_id);
											
											}
										}]
									});

									var json = [
										{"field":"ou_parent_path","rule":"not like","value":"<?=$ou_id?>"},
										{"field":"ou_class","rule":"=","value":"<?=OU_CLASS_OU?>"}
									]
									
									$('#txtb_ou_parent_s<?=$time?>').textbox('textbox').autocomplete({
								        serviceUrl: 'proc_ou/ou/get_json',
								        width:'300',
								        params:{
											rows:10,
											'data_search':JSON.stringify(json)
								        },
								        onSelect: function (suggestion) {
											$('#txtb_ou_parent_s<?=$time?>').textbox('setValue',base64_decode(suggestion.data.ou_name));
											$('#txtb_ou_parent<?=$time?>').val(base64_decode(suggestion.data.ou_id))
										}
									});
								}

								function fun_get_ou_parent<?=$time?>(tree,row)
								{
									if( ! row.ou_name) return;
									$('#'+tree).closest('.op_window').window('close');
									$('#txtb_ou_parent_s<?=$time?>').textbox('setValue',base64_decode(row.ou_name));
									$('#txtb_ou_parent<?=$time?>').val(base64_decode(row.ou_id));
									
								}
								</script>						 
                            </td>
                         </tr>
                         
                         <tr>
                         	<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	团队分类
                            </td>
                            <td style="height:35px;vertical-align:text-center;" > 
                            	<input name="content[ou_class]" 
					    			   oaname="content[ou_class]"
					    			   class="easyui-combobox oa_input"
					    			   data-options="err:err,
					    			   				 limitToList:true,
					    			   				 valueField:'id',    
						    						 textField:'text',
					    			   				 height:'25',
					    			   				 width:'200px',
					    			   				 multiline:false,
					    			   				 data: [<?=element('ou_class',$json_field_define)?>],
					    			   				 panelHeight:'auto',
					    			   				 panelMaxHeight:120,
					    			   				 panelWidth:'',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                            </td>
                            
                            <td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	组织架构
                            </td>
                            <td style="height:35px;vertical-align:text-center;" > 
                            	<input name="content[ou_level]" 
					    			   oaname="content[ou_level]"
					    			   class="easyui-combobox oa_input"
					    			   data-options="err:err,
					    			   				 limitToList:true,
					    			   				 valueField:'id',    
						    						 textField:'text',
					    			   				 height:'25',
					    			   				 width:'200px',
					    			   				 multiline:false,
					    			   				 data: [<?=element('ou_level',$json_field_define)?>],
					    			   				 panelHeight:'auto',
					    			   				 panelMaxHeight:120,
					    			   				 panelWidth:'',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 onSelect : function(record)
													 {
													 	switch(record.id)
													 	{
													 		case '<?=OU_LEVEL_ORG?>':
													 		case '<?=OU_LEVEL_CORG?>':
													 		fun_tr_title_show($('#table_f_<?=$time?>'),'title_org_info',1)
													 		break;
													 		default:
													 		fun_tr_title_show($('#table_f_<?=$time?>'),'title_org_info')
													 	}
													 }
													 ">
                            </td>
                         </tr>
                         
                         <tr id="tr_ou_org_pre<?=$time?>" oaname="content[ou_org_pre]">
							<td class="field_s oa_op" style="height:35px;text-align: left">
								简称
							</td>
							<td class="oa_op" colspan="3" oaname="content[ou_org_pre]">
								<input name="content[ou_org_pre]"
									   oaname="content[ou_org_pre]"
									   class="easyui-textbox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
					    			   				 multiline:false,
													 validType:['length[0,40]','errMsg[\'#hd_err_f_<?=$time?>\']']
													 ">	   				
							</td>
	                    </tr>
	                    
                         <tr>
                         	<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	状态
                            </td>
                            <td style="height:35px;vertical-align:text-center;" > 
                            	<input name="content[ou_status]" 
					    			   oaname="content[ou_status]"
					    			   class="easyui-combotree oa_input"
					    			   data-options="err:err,
					    			   				 limitToList:true,
					    			   				 valueField:'id',    
						    						 textField:'text',
					    			   				 height:'25',
					    			   				 width:'200',
					    			   				 data: [<?=element('ou_status',$json_field_define)?>],
					    			   				 panelHeight:'auto',
					    			   				 panelMaxHeight:120,
					    			   				 panelWidth:'',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                            </td>
	                    	<td class="field_s" style="height:35px;vertical-align:text-center;"  > 
                               	标签
                            </td>
                            <td style="height:35px;vertical-align:text-center;" > 
                            	<input name="content[ou_tag]" 
					    			   oaname="content[ou_tag]"
					    			   class="easyui-combotree oa_input"
					    			   data-options="err:err,
					    			   				 limitToList:true,
					    			   				 valueField:'id',    
						    						 textField:'text',
					    			   				 height:'25',
					    			   				 width:'200',
					    			   				 multiple:true,
					    			   				 data: [<?=element('ou_tag',$json_field_define)?>],
					    			   				 panelHeight:'auto',
					    			   				 panelMaxHeight:120,
					    			   				 panelWidth:'',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                            </td>
                         </tr>
                         
                         <tr>
                            <td style="height:35px;vertical-align:text-center;" colspan="4" > 
                            	<span class="field_s">备注</span>
                            	<input name="content[ou_note]" 
					    			   oaname="content[ou_note]"
					    			   class="easyui-textbox oa_input"
					    			   data-options="err:err,
					    			   				 height:'50',
					    			   				 width:'100%',
					    			   				 multiline:true,
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                            </td>
                         </tr>
                         
                         <tr oaname="title_org_info" class="tr_title oa_op" > 
	                    	<td colspan="4" style="height:35px;vertical-align:text-center;"  > 
	                    		<span>机构信息(分公司、子公司填写)</span>
	                    	</td>
	                    </tr>
	                    
	                    <tr>
							<td class="field_s" style="height:35px;text-align: left">
								法定代表人
							</td>
							<td>
								<input name="content[o_legal_person]"
									   oaname="content[o_legal_person]"
									   class="easyui-textbox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
					    			   				 multiline:false,
													 validType:['length[0,40]','errMsg[\'#hd_err_f_<?=$time?>\']']
													 ">	   				
							</td>

							<td class="field_s" style="height:35px;text-align: left">
								机构类型
							</td>
							<td>
								<input name="content[o_type]"
									   oaname="content[o_type]"
									   class="easyui-combobox oa_input"
									   data-options="err:err,
					    			   				 limitToList:true,
					    			   				 valueField:'id',
						    						 textField:'text',
					    			   				 height:'25',
					    			   				 width:'200',
					    			   				 multiline:false,
					    			   				 data: [<?=element('o_type',$json_field_define)?>],
					    			   				 panelHeight:'auto',
					    			   				 panelMaxHeight:120,
					    			   				 panelWidth:'',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
							</td>
						</tr>

						<tr>
							<td class="field_s" style="height:35px;text-align: left">
								组织机构代码
							</td>
							<td style="height:35px;text-align:left"   colspan="3">
								<input name="content[o_code_register]"
									   oaname="content[o_code_register]"
									   id="txtb_o_code_register<?=$time?>"
									   class="easyui-textbox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
					    			   				 multiline:false,
													 validType:['length[0,40]','errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
								（统一社会信用代码）					 
							</td>
						</tr>
						<tr>

							<td class="field_s" style="height:35px;text-align: left">
								纳税人识别号
							</td>
							<td>
								<input name="content[o_code_taxpayer]"
									   oaname="content[o_code_taxpayer]"
									   class="easyui-textbox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
					    			   				 multiline:false,
													 validType:['length[0,40]','errMsg[\'#hd_err_f_<?=$time?>\']']
													 ">		   				
							</td>

							<td class="field_s" style="height:35px;text-align: left">
								注册资金
							</td>
							<td>
								<input name="content[o_sum_register]"
									   oaname="content[o_sum_register]"
									   class="easyui-numberbox oa_input"
									   data-options="err:err,
									   				precision:2,
									   				decimalSeparator:'.',
									   				groupSeparator:',',
									   				height:'25',
									   				width:'200',
									   				multiline:false,
									   				validType:['errMsg[\'#hd_err_f_<?=$time?>\']']">

							</td>
						</tr>

						<tr>
							<td class="field_s" style="height:35px;text-align: left">
								营业执照类型
							</td>
							<td>
								<input name="content[a_login_type]"
									   oaname="content[a_login_type]"
									   class="easyui-combobox oa_input"
									   data-options="err:err,
					    			   				 limitToList:true,
					    			   				 valueField:'id',
						    						 textField:'text',
					    			   				 height:'25',
					    			   				 width:'200',
					    			   				 multiline:false,
					    			   				 data: [<?=element('o_licence',$json_field_define)?>],
					    			   				 panelHeight:'auto',
					    			   				 panelMaxHeight:120,
					    			   				 panelWidth:'',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
							</td>
							<td class="field_s" style="height:35px;text-align: left">
								营业期限至
							</td>
							<td>
								<input name="content[o_date_run]"
									   oaname="content[o_date_run]"
									   class="easyui-datebox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
					    			   				 multiline:false,
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']']
													 ">			   				
							</td>
						</tr>

						<tr>
							<td class="field_s" style="height:35px;text-align: left">
								注册地址
							</td>
							<td style="height:35px;text-align:left"   colspan="3">
								<input name="content[o_addr_register]"
									   oaname="content[o_addr_register]"
									   class="easyui-textbox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'100%',
					    			   				 multiline:false,
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
							</td>
						</tr>

						<tr>
							<td class="field_s" style="height:35px;text-align: left">
								经营范围
							</td>
							<td style="height:35px;vertical-align:text-center;"   colspan="3">
								<input name="content[o_range]"
									   oaname="content[o_range]"
									   class="easyui-textbox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'100%',
					    			   				 multiline:false,
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
							</td>
						</tr>
						<!--联系信息-->
						<tr oaname="title_org_info" class="tr_title oa_op" >
							<td colspan="4" style="height:35px;vertical-align:text-center;"  >
								<span>联系信息</span>
							</td>
						</tr>
						<tr>
							<td class="field_s" style="height:35px;text-align: left">
								经营地址
							</td>
							<td style="height:35px;text-align:left"   colspan="3">
								<input name="content[o_addr]"
									   oaname="content[o_addr]"
									   class="easyui-textbox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'100%',
					    			   				 multiline:false,
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
							</td>
						</tr>

						<tr>
							<td class="field_s" style="height:35px;text-align: left">
								联系电话
							</td>
							<td>
								<input name="content[o_tel]"
									   oaname="content[o_tel]"
									   class="easyui-textbox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
					    			   				 multiline:false,
													 validType:['length[0,40]','errMsg[\'#hd_err_f_<?=$time?>\']']
													 ">		   				
							</td>
							<td class="field_s" style="height:35px;text-align: left">
								邮编
							</td>
							<td>
								<input name="content[o_post_code]"
									   oaname="content[o_post_code]"
									   class="easyui-textbox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
					    			   				 multiline:false,
													 validType:['length[0,40]','errMsg[\'#hd_err_f_<?=$time?>\']']
													 ">		   				
							</td>
						</tr>

						<tr>
							<td class="field_s" style="height:35px;text-align: left">
								公司主页
							</td>
							<td style="height:35px;text-align: left"   colspan="3">
								<input name="content[o_web]"
									   oaname="content[o_web]"
									   class="easyui-textbox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'100%',
					    			   				 multiline:false,
													 validType:['length[0,80]','errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
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
						op_id: '<?=$ou_id?>',
						table: 'sys_ou',
						field: 'ou_id',
						time: 'log_<?=$time?>'
       				 }"
       	>
       	
    </div>
    
</div>

<!-- loading -->
<div id="win_loading<?=$time?>" style="padding:5px;overflow:hidden;"></div> 