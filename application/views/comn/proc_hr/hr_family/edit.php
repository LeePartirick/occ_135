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
    <div title="家庭信息"
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
		 		<center><span class="tb_title"><b>家庭信息</b></span></center>

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
							<a href="javascript:void(0)" oaname="btn_import" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-xlsx'" onClick="fun_xlsx_import('proc_hr/m_hr_family','家庭信息','proc_hr/hr_family/import')">导入</a>
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
                               	姓名
                            </td>
                            <td style="height:35px;vertical-align:text-center;" >
								<input name="content[hr_f_person]"
									   oaname="content[hr_f_person]"
									   class="easyui-textbox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
													 validType:['length[0,80]','errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                            </td>
							<td class="field_s" style="height:35px;vertical-align:text-center;"  >
								关系
							</td>
							<td style="height:35px;vertical-align:text-center;">
								<input name="content[hr_f_relation]"
									   oaname="content[hr_f_relation]"
									   class="easyui-textbox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
													 validType:['length[0,80]','errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
							</td>
	                    </tr>

						<tr>
							<td class="field_s" style="height:35px;vertical-align:text-center;"  >
								生日
							</td>
							<td style="height:35px;vertical-align:text-center;" >
								<input name="content[hr_f_birthday]"
									   oaname="content[hr_f_birthday]"
									   class="easyui-datebox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'120px',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 onChange :function( newValue, oldValue)
													 {
													 	var c_age='';
													 	if(newValue)
													 	c_age=fun_get_date('Y')-newValue.split('-')[0]+'岁';

													 	$('#c_age<?=$time?>').html(c_age);
													 },
													 ">
								<span id="c_age<?=$time?>"
									  name="content[c_age]"
									  oaname="content[c_age]"
									  class="oa_input"></span>
							</td>
							<td class="field_s" style="height:35px;vertical-align:text-center;"  >
								居住城市
							</td>
							<td style="height:35px;vertical-align:text-center;">
								<input name="content[hr_f_city]"
									   oaname="content[hr_f_city]"
									   class="easyui-textbox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
													 validType:['length[0,80]','errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
							</td>
						</tr>
						<tr>
							<td class="field_s" style="height:35px;vertical-align:text-center;"  >
								国籍
							</td>
							<td style="height:35px;vertical-align:text-center;" >
								<input name="content[hr_f_nationality]"
									   oaname="content[hr_f_nationality]"
									   class="easyui-textbox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
													 validType:['length[0,100]','errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
							</td>

						</tr>
						<tr>
							<td class="field_s" style="height:35px;vertical-align:text-center;"  >
								工作单位
							</td>
							<td style="height:35px;vertical-align:text-center;" colspan="3">
								<input name="content[hr_f_org]"
									   oaname="content[hr_f_org]"
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
								职位
							</td>
							<td style="height:35px;vertical-align:text-center;" >
								<input name="content[hr_f_job]"
									   oaname="content[hr_f_job]"
									   class="easyui-textbox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
													 validType:['length[0,200]','errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
							</td>
							<td class="field_s" style="height:35px;vertical-align:text-center;"  >
								联系方式
							</td>
							<td style="height:35px;vertical-align:text-center;">
								<input name="content[hr_f_tel]"
									   oaname="content[hr_f_tel]"
									   class="easyui-numberbox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
													 validType:['length[0,100]','errMsg[\'#hd_err_f_<?=$time?>\']'],
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
						op_id: '<?=$hr_f_id?>',
						table: 'hr_family',
						field: 'hr_f_id',
						time: 'log_<?=$time?>'
       				 }"
       	>

    </div>

</div>

<!-- loading -->
<div id="win_loading<?=$time?>" style="padding:5px;overflow:hidden;"></div>