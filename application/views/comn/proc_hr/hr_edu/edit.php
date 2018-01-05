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
    <div title="教育信息"
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
		 		<center><span class="tb_title"><b>教育信息</b></span></center>

		 		<table id="table_h_<?=$time?>" class="table_no_line"  style="width:800px;margin:0 auto;">
		 			<tr>
		       			<td style="width:50%">

		       			</td>
		       			<td style="width:'50%';text-align:right;">
		       			<b><?=$db_time_create?></b>
		       			</td>
		       		</tr>
		       		<tr>
		       			<td style="width:'50%';">
		       				<a href="javascript:void(0)" oaname="btn_save" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-save'" onClick="f_submit_<?=$time?>('save');">保存</a>
							<a href="javascript:void(0)" oaname="btn_import" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-xlsx'" onClick="fun_xlsx_import('proc_hr/m_hr_edu','教育信息','proc_hr/hr_edu/import')">导入</a>
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

	                    <tr class="tr_title">
	                    	<td colspan="4" style="height:35px;text-align:left"  >
	                    		<span>基本信息</span>
	                    	</td>
	                    </tr>
						<tr>
							<td class="field_s" style="height:35px;vertical-align:text-center;"  >
								入学时间
							</td>
							<td style="height:35px;vertical-align:text-center;" >
								<input name="content[hr_edu_start_time]"
									   oaname="content[hr_edu_start_time]"
									   class="easyui-datebox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
							</td>
							<td class="field_s" style="height:35px;vertical-align:text-center;"  >
								毕业时间
							</td>
							<td style="height:35px;vertical-align:text-center;" >
								<input name="content[hr_edu_end_time]"
									   oaname="content[hr_edu_end_time]"
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
								学校
							</td>
							<td style="height:35px;vertical-align:text-center;" colspan="3">
								<input name="content[hr_edu_school]"
									   oaname="content[hr_edu_school]"
									   class="easyui-textbox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'100%',
													 validType:['length[0,200]','errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
							</td>
						</tr>
						
						<tr>
							<td class="field_s" style="height:35px;vertical-align:text-center;"  >
								专业
							</td>
							<td style="height:35px;vertical-align:text-center;" colspan="3">
								<input name="content[hr_edu_major]"
									   oaname="content[hr_edu_major]"
									   class="easyui-textbox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'100%',
													 validType:['length[0,200]','errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
							</td>
						</tr>

						<tr>
							<td class="field_s" style="height:35px;vertical-align:text-center;"  >
								学历
							</td>
							<td style="height:35px;vertical-align:text-center;">
								<input name="content[hr_edu_xl]"
									   oaname="content[hr_edu_xl]"
									   class="easyui-combobox oa_input"
									   data-options="err:err,
					    			   				 limitToList:true,
					    			   				 valueField:'id',
						    						 textField:'text',
					    			   				 height:'25',
					    			   				 width:'200px',
					    			   				 multiline:false,
					    			   				 data: [<?=element('hr_edu_xl',$json_field_define)?>],
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
								    						if(parseInt(data[i].id) > 1 || value == data[i].id)
								    						{
								    							data_new.push(data[i]);
								    						}
								    					}
								    					
								    					return data_new;
													 }
													 ">
							</td>
							<td class="field_s" style="height:35px;vertical-align:text-center;"  >
								学习情况
							</td>
							<td style="height:35px;vertical-align:text-center;" >
								<input name="content[hr_edu_type_study]"
									   oaname="content[hr_edu_type_study]"
									   class="easyui-combobox oa_input"
									   data-options="err:err,
					    			   				 limitToList:true,
					    			   				 valueField:'id',
						    						 textField:'text',
					    			   				 height:'25',
					    			   				 width:'200px',
					    			   				 multiline:false,
					    			   				 data: [<?=element('hr_edu_type_study',$json_field_define)?>],
					    			   				 panelHeight:'auto',
					    			   				 panelMaxHeight:120,
					    			   				 panelWidth:'',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
							</td>
						</tr>

						<tr>
							<td class="field_s" style="height:35px;vertical-align:text-center;"  >
								全日制
							</td>
							<td style="height:35px;vertical-align:text-center;" >
								<input name="content[hr_edu_type_day]"
									   oaname="content[hr_edu_type_day]"
									   class="easyui-combobox oa_input"
									   data-options="err:err,
					    			   				 limitToList:true,
					    			   				 valueField:'id',
						    						 textField:'text',
					    			   				 height:'25',
					    			   				 width:'200px',
					    			   				 multiline:false,
					    			   				 data: [<?=element('base_yn',$json_field_define)?>],
					    			   				 panelHeight:'auto',
					    			   				 panelMaxHeight:120,
					    			   				 panelWidth:'',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
							</td>
						</tr>

						<tr>
							<td class="field_s" style="height:35px;vertical-align:text-center;"  >
								校内职务
							</td>
							<td style="height:35px;vertical-align:text-center;" >
								<input name="content[hr_edu_zw]"
									   oaname="content[hr_edu_zw]"
									   class="easyui-textbox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
													 validType:['length[0,200]','errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
							</td>
						</tr>

						<tr>
							<td class="field_s oa_op" style="height:35px;vertical-align:text-center;"  oaname="content[hr_edu_person]">
								证明人
							</td>
							<td class="oa_op"  style="height:35px;vertical-align:text-center;" oaname="content[hr_edu_person]">
								<input name="content[hr_edu_person]"
									   oaname="content[hr_edu_person]"
									   class="easyui-textbox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
													 validType:['length[0,80]','errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
							</td>
							<td class="field_s oa_op" style="height:35px;vertical-align:text-center;"  oaname="content[hr_edu_person_tel]">
								联系方式
							</td>
							<td class="oa_op"  style="height:35px;vertical-align:text-center;" oaname="content[hr_edu_person_tel]">
								<input name="content[hr_edu_person_tel]"
									   oaname="content[hr_edu_person_tel]"
									   class="easyui-textbox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
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
						op_id: '<?=$hr_edu_id?>',
						table: 'hr_edu',
						field: 'hr_edu_id',
						time: 'log_<?=$time?>'
       				 }"
       	>

    </div>

</div>

<!-- loading -->
<div id="win_loading<?=$time?>" style="padding:5px;overflow:hidden;"></div>