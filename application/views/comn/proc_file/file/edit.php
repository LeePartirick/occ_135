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
    <div title="文件"
         style="">
        <div id="tab_<?=$time?>" 
			 class="easyui-tabs" 
		     data-options="fit:true,
		    			   border:false,
		    			   plain:true,
		    			   tabPosition:'right',
		    			   headerWidth:100,
		            	   tabWidth:100">
		<div title="文件信息"
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
		 		<center><span class="tb_title"><b>文件</b></span></center>
		 		
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
		       				<a href="javascript:void(0)" oaname="btn_select" class="easyui-linkbutton oa_op" id="btn_upload_file_<?=$time?>" style="top:5px;">选择</a> 
		       				<a href="javascript:void(0)" oaname="btn_upload" class="easyui-linkbutton oa_op" id="btn_upload<?=$time?>" style="top:50px;left:170px;position: absolute;">上传</a>
		       				<a href="javascript:void(0)" oaname="btn_save" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-save'" onClick="f_submit_<?=$time?>('save');">保存</a>  
		       				<a href="javascript:void(0)" oaname="btn_import" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-xlsx'" onClick="fun_xlsx_import('proc_file/m_file_type','文档属性','proc_file/file_type/import')">导入</a>
		       				<a href="javascript:void(0)" oaname="btn_download" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-download'" onClick="fun_file_download<?=$time?>()">下载</a>
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
	                    	<td style="width:150px"></td>
                            <td style="width:250px"></td>
	                        <td style="width:150px"></td>
                            <td style="width:250px"></td>
	                    </tr> 
	                    
	                    <tr class="tr_title">
	                    	<td colspan="4" style="height:35px;text-align:left"  >
	                    		<span>基本信息</span>
	                    	</td>
	                    </tr>

						<tr>
							<td class="field_s oa_op" oaname="content[f_name]" style="height:35px;vertical-align:text-center;">
								文件名
							</td>
							<td class="oa_op" oaname="content[f_name]" style="height:35px;vertical-align:text-center;" colspan="3">
								<input name="content[f_name]"
									   oaname="content[f_name]"
									   id="txtb_f_name<?=$time?>"
									   class="easyui-textbox oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'100%',
					    			   				 multiline:false,
													 validType:['length[0,200]','errMsg[\'#hd_err_f_<?=$time?>\']'],
													 "
								>
							</td>

						</tr>
						
						<tr>
							<td class="field_s oa_op" oaname="content[f_v_sn]" style="height:35px;vertical-align:text-center;">
								文件版本
							</td>
							<td class="oa_op" oaname="content[f_v_sn]" style="height:35px;vertical-align:text-center;" >
								<span name="content[f_v_sn]" 
					    			  oaname="content[f_v_sn]"
					    			  class="oa_input"
					    			>
					    		</span>
					    		<a href="javascript:void(0)" oaname="btn_verson" class="easyui-linkbutton oa_op" data-options="" onClick="fun_upload_version<?=$time?>()">更新版本</a>
							</td>
							<td class="field_s oa_op" oaname="content[f_size]" style="height:35px;vertical-align:text-center;">
								文件大小
							</td>
							<td class="oa_op" oaname="content[f_size]" style="height:35px;vertical-align:text-center;" >
								<span name="content[f_size_s]" 
					    			  oaname="content[f_size_s]"
					    			  class="oa_input"
					    			>
					    		</span>
							</td>

						</tr>
						
						<tr>
							<td class="field_s oa_op" oaname="content[f_type]" style="height:35px;vertical-align:text-center;">
								文件属性
							</td>
							<td class="oa_op" oaname="content[f_type]" style="height:35px;vertical-align:text-center;" colspan="3">
								<input name="content[f_type]"
									   oaname="content[f_type]"
									   id="txtb_f_type<?=$time?>"
									   class="easyui-combotree oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'100%',
					    			   				 url_l:'proc_file/file_type/get_json/from/combobox/field_id/f_t_id/field_text/f_t_name/search_f_t_proc/<?=$search_f_t_proc?>',
					    			   				 multiline:false,
					    			   				 multiple:<?=$flag_f_type_more?>,
					    			   				 valueField:'id',    
    												 textField:'text',
					    			   				 panelHeight:'auto',
					    			   				 panelMaxHeight:'120',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 "
								>
							</td>

						</tr>
						
						<tr>
							<td class="field_s oa_op" oaname="content[f_secrecy]" style="height:35px;vertical-align:text-center;">
								文件密级
							</td>
							<td class="oa_op" oaname="content[f_secrecy]" style="height:35px;vertical-align:text-center;" colspan="3">
								<input name="content[f_secrecy]"
									   oaname="content[f_secrecy]"
									   id="txtb_f_secrecy<?=$time?>"
									   class="easyui-combogrid oa_input"
									   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'100%',
					    			   				 multiline:false,
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 idField: 'f_secrecy',
													 textField: 'f_secrecy_show',
													 nowrap:false,
													 columns:[[    
												          {field:'f_secrecy_show',title:'密级',width:80},    
												          {field:'f_secrecy_level',title:'级别',width:50},    
												          {field:'f_secrecy_define',title:'定义',width:350},    
												      ]],   
													 panelWidth:500,
													 panelHeight:'auto',
													 validType:[],
													 fun_ready:'load_f_secrecy<?=$time?>()'"
													 "
								>
							</td>
				
						</tr>
						
						<tr>
							<td class="field_s oa_op" oaname="content[db_person_create]" style="height:35px;vertical-align:text-center;">
								创建人
							</td>
							<td class="oa_op" oaname="content[db_person_create]" style="height:35px;vertical-align:text-center;" >
								<span name="content[db_person_create_s]" 
					    			  oaname="content[db_person_create_s]"
					    			  class="oa_input"
					    			>
					    		</span>
							</td>
							
							<td class="field_s oa_op" oaname="content[db_time_create]" style="height:35px;vertical-align:text-center;">
								创建时间
							</td>
							<td class="oa_op" oaname="content[db_time_create]" style="height:35px;vertical-align:text-center;" >
								<span name="content[db_time_create]" 
					    			  oaname="content[db_time_create]"
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
								<input name="content[f_note]"
									   oaname="content[f_note]"
									   class="easyui-textbox oa_input"
									   data-options="err:err,
					    			   				 height:'50',
					    			   				 width:'100%',
					    			   				 multiline:true,
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
						</tr>

	                 </table> 
	                 
	                 <!-- 数据校验时间 -->
					<input class="db_time_update" name="content[db_time_update]" type="hidden" />
							
		 		</form>
		 		
		 		 <!-- 验证错误 -->
         		 <input id="hd_err_f_<?=$time?>" type="hidden" /> 
         		 
		 	</div>
		 	<?php if($act == STAT_ACT_CREATE){?>
		 	<!-- 文件上传区域 -->
		 	<div oaname="f_upload" class="oa_op" data-options="region:'south',border:false" style="padding:0px;height:150px;background: #E6EEF8;">
		 		<div id="div_upload<?=$time?>" style="width:100%;height:100%;"></div>
		 	</div>
		 	<?php }?>
		</div>
        </div>
        
        <div title="版本列表"
        	 oaname="tab_verson"
        	 class="oa_op"
         	 style="">  
         	 
         	<table id="table_file_v<?=$time?>"></table>   
		  	<div id="menu_table_file_v<?=$time?>" class="easyui-menu" style="width:120px;">   
		 		<div data-options="iconCls:'icon-redo'">更新版本</div>   
			</div>      
         	 
        </div>
        
        </div>
    </div>
    <div title="操作日志" 
    	 oaname="tab_log"
       	 data-options="iconCls:'icon-log',
       				  href:'base/main/load_win_log_operate',
       				  queryParams:{
       				  	parent_id: 'tab_edit_<?=$time?>',
						op_id: '<?=$f_id?>',
						table: 'sys_file',
						field: 'f_id',
						time: 'log_<?=$time?>'
       				 }"
       	>
       	
    </div>
    
</div>

<!-- loading -->
<div id="win_loading<?=$time?>" style="padding:5px;overflow:hidden;"></div> 