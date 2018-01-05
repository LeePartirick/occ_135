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
    <div title="员工信息" 
         style="">
         
        <div id="l_<?=$time?>" 
	   		class="easyui-layout" 
		 	data-options="fit:true">
		 	
		 	<div data-options="region:'north',border:false" 
		 		style="height:auto;padding-top:15px;overflow:hidden;">	
		 		<? if( ! empty($log_time) ){ ?>
		 		<center><span class="tb_title"><b>操作日志</b></span></center>
				<table style="width:1000px;margin:0 auto;" class="table_no_line">
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
		 		<center><span class="tb_title"><b>员工信息</b></span></center>
		 		
		 		<table id="table_h_<?=$time?>" class="table_no_line"  style="width:1050px;margin:0 auto;">
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
		       				<a href="javascript:void(0)" oaname="btn_import" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-xlsx'" onClick="fun_xlsx_import('proc_hr/m_hr_info','员工信息','proc_hr/hr_info/import')">导入</a>  
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
		 		<form id="f_<?=$time?>" class="easyui-form" method="post" data-options="novalidate:false" time="<?=$time?>"> 
		 			<table id="table_f_<?=$time?>" style="width:1030px;margin:0 auto;">
						<tr class="set_width"> 
	                    	<td style="width:100px"></td> 
                            <td style="width:243px"></td> 
	                        <td style="width:100px"></td> 
                            <td style="width:243px"></td> 
                            <td style="width:100px"></td> 
                            <td style="width:244px"></td> 
	                    </tr> 
	                    
	                    <tr class="tr_title" > 
	                    	<td colspan="6" style="height:35px;vertical-align:text-center;"  > 
	                    		<span>基本信息</span>
	                    	</td>
	                    </tr>
	                    
	                   <tr>
	                    	<td class="field_s oa_op" oaname="content[c_org_s]" style="height:35px;vertical-align:text-center;"  > 
                               	所属机构
                            </td>
                             <td class="oa_op" oaname="content[c_org_s]" style="height:35px;vertical-align:text-center;"  colspan="2"> 
                             	<span name="content[c_org_s]" 
					    			  oaname="content[c_org_s]"
					    			  class="oa_input"
					    			>
					    		</span>
                             </td>
                        </tr>
	                    <tr>
	                    	<td class="field_s oa_op" oaname="content[c_name]" style="height:35px;vertical-align:text-center;"  > 
                               	姓名
                            </td>
                            <td class="field_s" oaname="content[c_name]"style="height:35px;vertical-align:text-center;" > 
                            	<input name="content[c_name]" 
					    			   oaname="content[c_name]"
					    			   class="easyui-textbox oa_input"
					    			   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
													 validType:['length[0,80]','errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                            </td>
                            <td class="field_s oa_op" oaname="content[c_name_old]" style="height:35px;vertical-align:text-center;"  > 
                               	曾用名
                            </td>
                            <td class="oa_op" oaname="content[c_name_old]" style="height:35px;vertical-align:text-center;" > 
                            	<input name="content[c_name_old]" 
					    			   oaname="content[c_name_old]"
					    			   class="easyui-textbox oa_input"
					    			   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
													 validType:['length[0,80]','errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                            </td>
                            
                            <td rowspan="4" colspan="2" class="oa_op" oaname="content[c_img_show]">
                            	<center>
					    		<a href="javascript:void(0)" 
					    		   title="单击此处上传图片" 
					    		   class="easyui-tooltip" >
					    		<div name="content[c_img]" 
					    			 oaname="content[c_img]"
					    			 class="upload_img oa_input "
					    			 onClick="fun_photoclip(this,307200)"
					    			 style="height:160px;width:112px;margin-top:10px;background:#E6EEF8;line-height:60px;font-size:14px;"
					    			>
					    		   <center>单击此处上传图片</center>
					    		</div>
					    		<input type="hidden" name="content[c_img_show]" />
					    		</a>
					    		</center>
                            </td>
                            
                         </tr>
                         
                         <tr>
	                    	<td class="field_s oa_op" oaname="content[c_sex]" style="height:35px;vertical-align:text-center;"  > 
                               	性别
                            </td>
                            <td class="oa_op" oaname="content[c_sex]" style="height:35px;vertical-align:text-center;"  > 
                            	<input name="content[c_sex]" 
					    			   oaname="content[c_sex]"
					    			   class="easyui-combobox oa_input"
					    			   data-options="err:err,
					    			   				 limitToList:true,
					    			   				 valueField:'id',    
						    						 textField:'text',
					    			   				 height:'25',
					    			   				 width:'200px',
					    			   				 multiline:false,
					    			   				 data: [<?=element('c_sex',$json_field_define)?>],
					    			   				 panelHeight:'auto',
					    			   				 panelMaxHeight:120,
					    			   				 panelWidth:'',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                            </td>
                            
                            <td class="field_s oa_op" oaname="content[c_hy]" style="height:35px;vertical-align:text-center;"  > 
                               	婚姻状况
                            </td>
                            <td class="oa_op" oaname="content[c_hy]" style="height:35px;vertical-align:text-center;"  > 
                            	<input name="content[c_hy]" 
					    			   oaname="content[c_hy]"
					    			   class="easyui-combobox oa_input"
					    			   data-options="err:err,
					    			   				 limitToList:true,
					    			   				 valueField:'id',    
						    						 textField:'text',
					    			   				 height:'25',
					    			   				 width:'200px',
					    			   				 multiline:false,
					    			   				 data: [<?=element('c_hy',$json_field_define)?>],
					    			   				 panelHeight:'auto',
					    			   				 panelMaxHeight:120,
					    			   				 panelWidth:'',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                            </td>
                            
                         </tr>
                         
                         <tr>
                            
                            <td class="field_s oa_op" oaname="content[c_code_person]" style="height:35px;vertical-align:text-center;"  > 
                               	身份证
                            </td>
                            <td class="oa_op" oaname="content[c_code_person]" style="height:35px;vertical-align:text-center;"  > 
                            	<input name="content[c_code_person]" 
					    			   oaname="content[c_code_person]"
					    			   id="txtb_c_code_person<?=$time?>"
					    			   class="easyui-textbox oa_input"
					    			   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200px',
					    			   				 multiline:false,
													 validType:['person_code','errMsg[\'#hd_err_f_<?=$time?>\']'],
													 fun_ready: 'load_c_code_person<?=$time?>()'
													 ">
                            </td>
                            
                             <td class="field_s oa_op" oaname="content[c_zzmm]" style="height:35px;vertical-align:text-center;"  > 
                               	政治面貌
                            </td>
                            <td class="oa_op" oaname="content[c_zzmm]" style="height:35px;vertical-align:text-center;"  > 
                            	<input name="content[c_zzmm]" 
					    			   oaname="content[c_zzmm]"
					    			   class="easyui-combobox oa_input"
					    			   data-options="err:err,
					    			   				 limitToList:true,
					    			   				 valueField:'id',    
						    						 textField:'text',
					    			   				 height:'25',
					    			   				 width:'200px',
					    			   				 multiline:false,
					    			   				 data: [<?=element('c_zzmm',$json_field_define)?>],
					    			   				 panelHeight:'auto',
					    			   				 panelMaxHeight:120,
					    			   				 panelWidth:'',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                            </td>
                            
                         </tr>
                         
                          <tr>
	                    	<td class="field_s oa_op" oaname="content[c_birthday]" style="height:35px;vertical-align:text-center;"  > 
                               	生日
                            </td>
                            <td class="oa_op" oaname="content[c_birthday]" style="height:35px;vertical-align:text-center;"  > 
                            	<input name="content[c_birthday]" 
					    			   oaname="content[c_birthday]"
					    			   id="txtb_c_birthday<?=$time?>"
					    			   class="easyui-datebox oa_input"
					    			   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'125px',
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
                            
                            <td class="field_s oa_op" oaname="content[c_time_work]"  style="height:35px;vertical-align:text-center;"  > 
                               	参加工作时间
                            </td>
                            <td class="oa_op" oaname="content[c_time_work]" style="height:35px;vertical-align:text-center;"  > 
                            	<input name="content[c_time_work]" 
					    			   oaname="content[c_time_work]"
					    			   id="txtb_c_birthday<?=$time?>"
					    			   class="easyui-datebox oa_input"
					    			   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200px',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                            </td>
                            
                         </tr>
                         
                         <tr>
	                    	<td class="field_s oa_op" oaname="content[c_mz]" style="height:35px;vertical-align:text-center;"  > 
                               	民族
                            </td>
                            <td class="oa_op" oaname="content[c_mz]" style="height:35px;vertical-align:text-center;"  >
                            	<input name="content[c_mz]" 
					    			   oaname="content[c_mz]"
					    			   class="easyui-textbox oa_input"
					    			   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
													 validType:['length[0,80]','errMsg[\'#hd_err_f_<?=$time?>\']'],
													 "> 
                            </td>
                            
                            <td class="field_s oa_op" oaname="content[c_jg]"  style="height:35px;vertical-align:text-center;"  > 
                               	籍贯
                            </td>
                            <td class="oa_op" oaname="content[c_jg]" style="height:35px;vertical-align:text-center;"  > 
                            	<input name="content[c_jg]" 
					    			   oaname="content[c_jg]"
					    			   id="txtb_c_jq<?=$time?>"
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
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                            </td>
                         </tr>
                         
                          <tr>
                         	<td class="field_s oa_op" oaname="content[c_xl]"  style="height:35px;vertical-align:text-center;"  > 
                               	学历
                            </td>
                            <td class="oa_op" oaname="content[c_xl]" style="height:35px;vertical-align:text-center;"  > 
                            	<input name="content[c_xl]" 
					    			   oaname="content[c_xl]"
					    			   class="easyui-combobox oa_input"
					    			   data-options="err:err,
					    			   				 limitToList:true,
					    			   				 valueField:'id',    
						    						 textField:'text',
					    			   				 height:'25',
					    			   				 width:'200px',
					    			   				 multiline:false,
					    			   				 data: [<?=element('c_xl',$json_field_define)?>],
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
                            
                            <td class="field_s oa_op" oaname="content[c_xl_day]" style="height:35px;vertical-align:text-center;"  > 
                               	全日制
                            </td>
                            <td class="oa_op" oaname="content[c_xl_day]" style="height:35px;vertical-align:text-center;"  > 
                            	<input name="content[c_xl_day]" 
					    			   oaname="content[c_xl_day]"
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
	                    	<td class="field_s oa_op" oaname="content[c_xw]" style="height:35px;vertical-align:text-center;"  > 
                               	学位
                            </td>
                            <td class="oa_op" oaname="content[c_xw]" style="height:35px;vertical-align:text-center;"  > 
                            	<input name="content[c_xw]" 
					    			   oaname="content[c_xw]"
					    			   class="easyui-combobox oa_input"
					    			   data-options="err:err,
					    			   				 limitToList:true,
					    			   				 valueField:'id',    
						    						 textField:'text',
					    			   				 height:'25',
					    			   				 width:'200px',
					    			   				 multiline:false,
					    			   				 data: [<?=element('c_xw',$json_field_define)?>],
					    			   				 panelHeight:'auto',
					    			   				 panelMaxHeight:120,
					    			   				 panelWidth:'',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                            </td>
                            
                         </tr>
                         
                         <tr>
	                    	<td class="field_s oa_op" oaname="content[c_tel]"  style="height:35px;vertical-align:text-center;"  > 
                               	手机
                            </td>
                            <td class="oa_op" oaname="content[c_tel]"  style="height:35px;vertical-align:text-center;"  > 
                            	<input name="content[c_tel]" 
					    			   oaname="content[c_tel]"
					    			   id="txtb_c_tel<?=$time?>"
					    			   class="easyui-numberbox oa_input"
					    			   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'120px',
					    			   				 multiline:false,
													 validType:['length[0,20]','errMsg[\'#hd_err_f_<?=$time?>\']'],
													 fun_ready: 'load_c_tel<?=$time?>()'
													 ">
								<span name="content[c_tel_info]"
								      oaname="content[c_tel_info]"
								      id="span_c_tel_info<?=$time?>"
								      class="oa_input"
								      ></span>		
								         		
								<script type="text/javascript" >					 
								function load_c_tel<?=$time?>()
								{
									$('#txtb_c_tel<?=$time?>').textbox('textbox').bind('blur',
									function(){
										var tel=$(this).val();

										var info=fun_get_code_info('base/fun/get_info_of_tele_info',tel);

										$('#span_c_tel_info<?=$time?>').html(info);
										
									});
								}
								</script>	
                            </td>
                            
                            <td class="field_s oa_op" oaname="content[c_tel_2]"  style="height:35px;vertical-align:text-center;"  > 
                               	备用手机
                            </td>
                            <td class="oa_op" oaname="content[c_tel_2]" style="height:35px;vertical-align:text-center;"  > 
                            	<input name="content[c_tel_2]" 
					    			   oaname="content[c_tel_2]"
					    			   id="txtb_c_tel_2<?=$time?>"
					    			   class="easyui-numberbox oa_input"
					    			   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'120px',
					    			   				 multiline:false,
													 validType:['length[0,20]','errMsg[\'#hd_err_f_<?=$time?>\']'],
													 fun_ready: 'load_c_tel_2<?=$time?>()'
													 ">
								<span name="content[c_tel_2_info]"
								      oaname="content[c_tel_2_info]"
								      id="span_c_tel_2_info<?=$time?>"
								      class="oa_input"
								      ></span>		
								         		
								<script type="text/javascript" >					 
								function load_c_tel_2<?=$time?>()
								{
									$('#txtb_c_tel_2<?=$time?>').textbox('textbox').bind('blur',
									function(){
										var tel=$(this).val();

										var info=fun_get_code_info('base/fun/get_info_of_tele_info',tel);

										$('#span_c_tel_2_info<?=$time?>').html(info);
										
									});
								}
								</script>	
                            </td>
                            <td class="field_s oa_op" oaname="content[c_email]"  style="height:35px;vertical-align:text-center;"  > 
                               	Email
                            </td>
                            <td class="oa_op" oaname="content[c_email]" style="height:35px;vertical-align:text-center;"  > 
                            	<input name="content[c_email]" 
					    			   oaname="content[c_email]"
					    			   class="easyui-textbox oa_input"
					    			   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200px',
					    			   				 multiline:false,
													 validType:['length[0,200]','email','errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                            </td>
                         </tr>
                         
                         <tr>
	                    	<td class="field_s oa_op" oaname="content[c_interest]"  style="height:35px;vertical-align:text-center;"  > 
                               	兴趣爱好特长
                            </td>
                            <td class="oa_op" oaname="content[c_interest]" style="height:35px;vertical-align:text-center;"  colspan="5"> 
                            	<input name="content[c_interest]" 
					    			   oaname="content[c_interest]"
					    			   class="easyui-textbox oa_input"
					    			   data-options="err:err,
					    			   				 height:'50',
					    			   				 width:'100%',
					    			   				 multiline:true,
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                            </td>
                            
                         </tr>
                         
                         <tr>
	                    	<td class="field_s oa_op" oaname="content[c_mac_line]"  style="height:35px;vertical-align:text-center;"  > 
                               	有线MAC地址
                            </td>
                            <td class="oa_op" oaname="content[c_mac_line]" style="height:35px;vertical-align:text-center;" > 
                            	<input name="content[c_mac_line]" 
					    			   oaname="content[c_mac_line]"
					    			   class="easyui-textbox oa_input"
					    			   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
													 validType:['length[0,80]','errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                            </td>
                            <td class="field_s oa_op" oaname="content[c_mac_noline]"  style="height:35px;vertical-align:text-center;"  > 
                               	无线MAC地址
                            </td>
                            <td class="oa_op" oaname="content[c_mac_noline]" style="height:35px;vertical-align:text-center;" > 
                            	<input name="content[c_mac_noline]" 
					    			   oaname="content[c_mac_noline]"
					    			   class="easyui-textbox oa_input"
					    			   data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200',
													 validType:['length[0,80]','errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                            </td>
                         </tr>
                         
                         <tr>
                         
                         	<td colspan = "6">
                         		  <div id="tab_hr_info_other<?=$time?>" 
                         		  	oaname="tab_hr_info_other" class="easyui-tabs oa_op"  
									data-options="height:'auto',width:'1000',
												  border:false,
												  tabPosition:'top',
												  tabWidth:'100',
												  tabHeight:'27',
												  headerWidth:'100',
												  showHeader:true,
												  plain:true,
												  justified:false,
												  narrow:false,
												  pill:false,
												  " 
									style=""> 
									<div title="工作信息 <span id='sp_hr_work<?=$time?>' class='m-badge' style='display:none'></span>" 
										 oaname="tab_hr_work"
										 data-options="iconCls:'',
													   selected: true" >
										<?php include 'edit_hr_info_hr_work.php';?>
										<?php include 'edit_hr_info_hr_work_js.php';?>
									</div>
									<div title="卡帐信息 <span id='sp_card<?=$time?>' class='m-badge' style='display:none'></span>" 
										 oaname="tab_card"
										 class="oa_op"
										 data-options="iconCls:'',
													   " >
										<?php include 'edit_hr_info_card.php';?>
										<?php include 'edit_hr_info_card_js.php';?>
									</div>
									<div title="身份证件<span id='sp_idcard<?=$time?>' class='m-badge' style='display:none'></span>" 
										 oaname="tab_idcard"
										 class="oa_op"
										 data-options="iconCls:'',
													   " >
										<?php include 'edit_hr_info_idcard.php';?>
										<?php include 'edit_hr_info_idcard_js.php';?>			   
									</div>
									<div title="档案信息<span id='sp_doc<?=$time?>' class='m-badge' style='display:none'></span>" 
										 oaname="tab_doc"
										 class="oa_op"
										 data-options="iconCls:'',
													   " >
										<?php include 'edit_hr_info_doc.php';?>
										<?php include 'edit_hr_info_doc_js.php';?>	
									</div>
									<div title="居住信息<span id='sp_addr<?=$time?>' class='m-badge' style='display:none'></span>" 
										 oaname="tab_addr"
										 class="oa_op"
										 data-options="iconCls:'',
													   " >
										<?php include 'edit_hr_info_addr.php';?>
										<?php include 'edit_hr_info_addr_js.php';?>	
									</div>
									<div title="家庭信息<span id='sp_family<?=$time?>' class='m-badge' style='display:none'></span>" 
										 oaname="tab_family"
										 class="oa_op"
										 data-options="iconCls:'',
													   " >
										<?php include 'edit_hr_info_family.php';?>
										<?php include 'edit_hr_info_family_js.php';?>	
									</div>
									<div title="教育信息<span id='sp_edu<?=$time?>' class='m-badge' style='display:none'></span>" 
										 oaname="tab_edu"
										 class="oa_op"
										 data-options="iconCls:'',
													   " >
										<?php include 'edit_hr_info_edu.php';?>
										<?php include 'edit_hr_info_edu_js.php';?>	
									</div>
									<div title="工作经历<span id='sp_work<?=$time?>' class='m-badge' style='display:none'></span>" 
										 oaname="tab_work"
										 class="oa_op"
										 data-options="iconCls:'',
													   " >
										<?php include 'edit_hr_info_work.php';?>
										<?php include 'edit_hr_info_work_js.php';?>
									</div>
									<div title="培训经历<span id='sp_train<?=$time?>' class='m-badge' style='display:none'></span>" 
										 oaname="tab_train"
										 class="oa_op"
										 data-options="iconCls:'',
													   " >
										<?php include 'edit_hr_info_train.php';?>
										<?php include 'edit_hr_info_train_js.php';?>			   
									</div>
								</div> 
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
						op_id: '<?=$c_id?>',
						table: 'hr_info',
						field: 'c_id',
						time: 'log_<?=$time?>',
						fun_p: 'proc_hr',
						fun_m: 'm_hr_info',
						fun_f: 'get_where_log',
       				 }"
       	>
       	
    </div>
    
</div>

<!-- loading -->
<div id="win_loading<?=$time?>" style="padding:5px;overflow:hidden;"></div> 