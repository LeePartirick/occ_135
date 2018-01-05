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
    <div title="档案归档"
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
                <center><span class="tb_title"><b>档案归档</b></span></center>

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
                            <a href="javascript:void(0)" oaname="btn_import" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-xlsx'" onClick="fun_xlsx_import('proc_doc/m_doc','档案归档','proc_doc/doc/import')">导入</a>
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
                    <a href="javascript:void(0)" oaname="btn_im" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-im'" style="width:35px;margin-bottom:5px;" title="308" onClick="fun_im_wl('<?=$doc_id?>','<?=$pp_id?>')"></a>
                    <a href="javascript:void(0)" id="btn_file<?=$time?>" oaname="btn_file" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-file'" style="width:35px;margin-bottom:5px;" title="关联文件" onClick="$('#tab_edit_<?=$time?>').tabs('select',3)"></a>
                </div >
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
	                               	归属公司
	                            </td>
	                            <td style="height:35px;vertical-align:text-center;"  colspan="3"> 
	                            	<input name="content[doc_org]" 
						    			   oaname="content[doc_org]"
						    			   id="txtb_doc_org<?=$time?>"
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
                               	 签发单位
                            </td>
                            <td style="height:35px;vertical-align:text-center;" colspan="3" >
                                <input name="content[doc_sign_org_s]"
                                       oaname="content[doc_sign_org_s]"
                                       id="txtb_doc_sign_org_s<?=$time?>"
                                       class="easyui-textbox oa_input"
                                       data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'100%',
					    			   				 multiline:false,
					    			   				 fun_ready:'load_doc_sign_org<?=$time?>()',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                                <input name="content[doc_sign_org]"
                                       oaname="content[doc_sign_org]"
                                       id="txtb_doc_sign_org<?=$time?>"
                                       class="oa_input"
                                       type="hidden"
                                >
                            </td>
                        </tr>
                        <tr>
                        <td class="field_s" style="height:35px;vertical-align:text-center">
                               	 财务编号
                            </td>
                            <td>
                                <input name="content[doc_gfc_id_s]"
                                       oaname="content[doc_gfc_id_s]"
                                       id="txtb_doc_gfc_id_s<?=$time?>"
                                       class="easyui-textbox oa_input"
                                       data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200px',
					    			   				 multiline:false,
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 fun_ready: 'load_doc_gfc_id<?=$time?>()',
													 onChange:function(newValue,oldValue){
													   var gfc=$('#txtb_doc_gfc_id<?=$time?>').val();
													   var gfc_s=$('#txtb_doc_gfc_id_s<?=$time?>').textbox('getValue');
		                                                if(gfc_s){
		                                                	fun_form_operate('f_<?=$time?>',['content[doc_sign_org_s]','content[doc_name]','content[doc_page_have]','content[doc_letter_have]'],[],arr_required<?=$time?>);
		                                                	
		                                                }else{
		                                                	
		                                                	$('#table_doc_info<?=$time?>').datagrid('loadData',{total:0,rows:[]});
		                                                	fun_tr_title_show($('#table_f_<?=$time?>'),'title_gfc')
		                                                }

													 }
													 "
                                >
                                <input id="txtb_doc_gfc_id<?=$time?>"
                                       name="content[doc_gfc_id]"
                                       oaname="content[doc_gfc_id]"
                                       class="oa_input"
                                       type="hidden"/>
                            </td>
                            <td class="field_s" style="height:35px;vertical-align:text-center">
                               	 项目状态
                            </td>
                            <td>
                                <input name="content[doc_project_type]"
                                       oaname="content[doc_project_type]"
                                       class="easyui-combobox oa_input"
                                       data-options="err:err,
					    			   				 limitToList:true,
					    			   				 valueField:'id',
						    						 textField:'text',
					    			   				 height:'25',
					    			   				 width:'200px',
					    			   				 multiline:false,
					    			   				 data: [<?=element('doc_project_type',$json_field_define)?>],
					    			   				 panelHeight:'auto',
					    			   				 panelMaxHeight:120,
					    			   				 panelWidth:'',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                            </td>
                            
                        </tr>
                        <tr>
                            <td class="field_s" style="height:35px;vertical-align:text-center;">
                                	档案全称
                            </td>
                            <td style="height:35px;vertical-align:text-center;" colspan="3">
                                <input name="content[doc_name]"
                                       oaname="content[doc_name]"
                                       id="txtb_doc_name<?=$time?>"
                                       class="easyui-textbox oa_input"
                                       data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'100%',
					    			   				 multiline:false,
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 onChange:function(newValue,oldValue){
													 
													 }
													 ">
                            </td>
                        </tr>
                        <tr>
                            <td class="field_s" style="height:35px;vertical-align:text-center;">
                               	 有效起始日期
                            </td>
                            <td style="height:35px;vertical-align:text-center;">
                                <input name="content[doc_efftime_start]"
                                       oaname="content[doc_efftime_start]"
                                       class="easyui-datebox oa_input"
                                       data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200px',
					    			   				 multiline:false,
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">

                            </td>
                            <td class="field_s" style="height:35px;vertical-align:text-center">
                                	有效截止日期
                            </td>
                            <td>
                                <input name="content[doc_efftime_end]"
                                       oaname="content[doc_efftime_end]"
                                       class="easyui-datebox oa_input"
                                       data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200px',
					    			   				 multiline:false,
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                            </td>
                        </tr>
                        <tr>
                            <td class="field_s" style="height:35px;vertical-align:text-center">
                                	档案原始号
                            </td>
                            <td>
                                <input name="content[doc_original_code]"
                                       oaname="content[doc_original_code]"
                                       class="easyui-textbox oa_input"
                                       data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200px',
					    			   				 multiline:false,
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">

                            </td>
                            <td class="field_s" style="height:35px;vertical-align:text-center">
                                	录入日期
                            </td>
                            <td>
                                <input name="content[doc_addtime]"
                                       oaname="content[doc_addtime]"
                                       class="easyui-datebox oa_input"
                                       data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200px',
					    			   				 multiline:false,
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                            </td>

                        </tr>
                        <tr>
                            <td class="field_s" style="height:35px;vertical-align:text-center">
                                	递交人
                            </td>
                            <td>
                                <input name="content[doc_sub_person_s]"
                                       oaname="content[doc_sub_person_s]"
                                       id="txtb_doc_sub_person_s<?=$time?>"
                                       class="easyui-textbox oa_input"
                                       data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200px',
					    			   				 multiline:false,
					    			   				 fun_ready:'load_doc_sub_person<?=$time?>()',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                                <input name="content[doc_sub_person]"
                                       oaname="content[doc_sub_person]"
                                       id="txtb_doc_sub_person<?=$time?>"
                                       class="oa_input" type="hidden">
                            </td>
                            <td class="field_s" style="height:35px;vertical-align:text-center">
                               	 档案保管人
                            </td>
                            <td>
                                <input name="content[doc_keep_person_s]"
                                       oaname="content[doc_keep_person_s]"
                                       id="txtb_doc_keep_person_s<?=$time?>"
                                       class="easyui-textbox oa_input"
                                       data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200px',
					    			   				 multiline:false,
					    			   				 fun_ready:'load_doc_keep_person<?=$time?>()',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                                <input name="content[doc_keep_person]"
                                       oaname="content[doc_keep_person]"
                                       id="txtb_doc_keep_person<?=$time?>"
                                       class="oa_input" type="hidden">
                            </td>

                        </tr>
                        <tr>
                            <td class="field_s" style="height:35px;vertical-align:text-center">
                                	档案维护人
                            </td>
                            <td>
                                <input name="content[doc_protect_person_s]"
                                       oaname="content[doc_protect_person_s]"
                                       id="txtb_doc_protect_person_s<?=$time?>"
                                       class="easyui-textbox oa_input"
                                       data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200px',
					    			   				 multiline:false,
					    			   				 fun_ready:'load_doc_protect_person<?=$time?>()',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                                <input name="content[doc_protect_person]"
                                       oaname="content[doc_protect_person]"
                                       id="txtb_doc_protect_person<?=$time?>"
                                       class="oa_input" type="hidden">
                            </td>
                            <td class="field_s" style="height:35px;vertical-align:text-center">
                               	 提醒日期
                            </td>
                            <td>
                                <input name="content[doc_alert_time]"
                                       oaname="content[doc_alert_time]"
                                       class="easyui-datebox oa_input"
                                       data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'125px',
					    			   				 multiline:false,
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
								<a href="javascript:void(0)" id='btn_doc_alert_yn<?=$time?>' oaname="content[doc_alert_yn]" name="content[doc_alert_yn]" class="easyui-linkbutton oa_op" data-options="iconCls:'<?=$icon?>'" value="1" title="提醒" onClick="fun_change_icon<?=$time?>(this)"></a>
                            </td>

                        </tr>
                        <tr>
                            <td class="field_s" style="height:35px;vertical-align:text-center">
                               	 档案密级
                            </td>
                            <td>
                                <input name="content[doc_secret]"
                                       oaname="content[doc_secret]"
                                       class="easyui-combobox oa_input"
                                       data-options="err:err,
					    			   				 limitToList:true,
					    			   				 valueField:'id',
						    						 textField:'text',
					    			   				 height:'25',
					    			   				 width:'200px',
					    			   				 multiline:false,
					    			   				 data: [<?=element('doc_secret',$json_field_define)?>],
					    			   				 panelHeight:'auto',
					    			   				 panelMaxHeight:120,
					    			   				 panelWidth:'',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">

                            </td>
                            <td class="field_s" style="height:35px;vertical-align:text-center">
                              	  限制级别
                            </td>
                            <td>
                                <input name="content[doc_limit_level]"
                                       oaname="content[doc_limit_level]"
                                       class="easyui-combobox oa_input"
                                       data-options="err:err,
					    			   				 limitToList:true,
					    			   				 valueField:'id',
						    						 textField:'text',
					    			   				 height:'25',
					    			   				 width:'200px',
					    			   				 multiline:false,
					    			   				 data: [<?=element('doc_limit_level',$json_field_define)?>],
					    			   				 panelHeight:'auto',
					    			   				 panelMaxHeight:120,
					    			   				 panelWidth:'',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">

                            </td>

                        </tr>
                        <tr>
                            <td class="field_s" style="height:35px;vertical-align:text-center">
                                	存放位置
                            </td>
                            <td>
                                <input name="content[doc_location]"
                                       oaname="content[doc_location]"
                                       class="easyui-textbox oa_input"
                                       data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200px',
					    			   				 multiline:false,
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">

                            </td>
                            
                        </tr>
                        
                        <tr>
                            <td style="height:35px;vertical-align:text-center;" colspan="4" >
                                <span class="field_s">备注</span>
                                <input name="content[doc_note]"
                                       oaname="content[doc_note]"
                                       class="easyui-textbox oa_input"
                                       data-options="err:err,
					    			   				 height:'50',
					    			   				 width:'100%',
					    			   				 multiline:true,
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                            </td>
                        </tr>
                        <tr class="tr_title oa_op" oaname="title_doc">
                            <td colspan="4" style="height:35px;vertical-align:text-center;"  >
                                <span>档案明细</span>
                            </td>
                        </tr>
						<tr>
                            <td class="field_s" style="height:35px;vertical-align:text-center">
                               	 件-页
                            </td>
                            <td>
                                <input name="content[doc_letter_have]"
                                       oaname="content[doc_letter_have]"
                                       class="easyui-numberbox oa_input"
                                       data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'100px',
					    			   				 multiline:false,
					    			   				 fun_ready:'load_doci_letter<?=$time?>()',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
								<input name="content[doc_page_have]"
                                       oaname="content[doc_page_have]"
                                       class="easyui-numberbox oa_input"
                                       data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'100px',
					    			   				 multiline:false,
					    			   				 fun_ready:'load_doci_page<?=$time?>()',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                            </td>
                            
                        </tr>
                        <tr>
                            <td colspan="4" style="height:35px;vertical-align:text-center;padding-top:10px;"  >
                                <div id="table_doc_info_tool<?=$time?>">
                                    <table style="width:100%;">
                                        <tr>
                                            <td style="width:'50%';" >
                                                <a href="javascript:void(0)" id='change<?=$time?>' class="easyui-linkbutton oa_op" data-options="iconCls:'icon-add',plain:true" onClick="fun_table_doc_info_operate<?=$time?>('add')">添加</a>
                                                <a href="javascript:void(0)" class="easyui-linkbutton oa_op" data-options="iconCls:'icon-remove',plain:true" onClick="fun_table_doc_info_operate<?=$time?>('del')">删除</a>
                                            </td>

                                        </tr>
                                    </table>
                                </div>
                                <table id="table_doc_info<?=$time?>"
                                       name="content[doc_info]"
                                       oaname="content[doc_info]"
                                       class="oa_input data_table"
                                >
                                </table>
                            </td>
                        </tr>
                        
                        <tr class="tr_title oa_op" oaname="title_book">
                            <td colspan="4" style="height:35px;vertical-align:text-center;"  >
                                <span>借阅信息</span>
                            </td>
	                        </tr>
	                        <tr>
	                            <td style="height:35px;vertical-align:text-center;" colspan="4" >
	                                <div oaname="tab_jy_info" class="oa_op" style="">  
				         	
				         				<?php include 'edit_jy_info.php';?>
										<?php include 'edit_jy_info_js.php';?>
				         	 
				        			</div>
	                            </td>
	                    </tr>
                        
						<!--审批信息-->
                        <tr class="tr_title oa_op" oaname="title_check">
                            <td colspan="4" style="height:35px;vertical-align:text-center;"  >
                                <span>审批信息</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="field_s" style="height:35px;vertical-align:text-center">
                               	 档案码
                            </td>
                            <td>
                                <input name="content[doc_code]"
                                       oaname="content[doc_code]"
                                       class="easyui-textbox oa_input"
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
													 ">
                            </td>
                        </tr>
                        <tr>
                            <td class="field_s" style="height:35px;vertical-align:text-center">
                               	 公司码
                            </td>
                            <td>
                                <input name="content[doc_company_code]"
                                       oaname="content[doc_company_code]"
                                       class="easyui-combobox oa_input"
                                       data-options="err:err,
					    			   				 limitToList:true,
					    			   				 valueField:'id',
						    						 textField:'text',
					    			   				 height:'25',
					    			   				 width:'200px',
					    			   				 multiline:false,
					    			   				 data: [<?=element('doc_company_code',$json_field_define)?>],
					    			   				 panelHeight:'auto',
					    			   				 panelMaxHeight:120,
					    			   				 panelWidth:'',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                            </td>
                            <td class="field_s" style="height:35px;vertical-align:text-center">
                               	 大类码
                            </td>
                            <td>
                                <input name="content[doc_big_code]"
                                       oaname="content[doc_big_code]"
                                       id="txtb_doc_big_code<?=$time?>"
                                       class="easyui-combobox oa_input"
                                       data-options="err:err,
					    			   				 limitToList:true,
					    			   				 valueField:'id',
						    						 textField:'text',
					    			   				 height:'25',
					    			   				 width:'200px',
					    			   				 multiline:false,
					    			   				 data: [<?=element('doc_big_code',$json_field_define)?>],
					    			   				 panelHeight:'auto',
					    			   				 panelMaxHeight:120,
					    			   				 panelWidth:'',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 onChange: function(newValue,oldValue){
													 	var data=[<?=element('doc_middle_code',$json_field_define)?>];
													 	
													 	var arr=[];
													 	switch(newValue)
													 	{
													 		case '<?=DOC_BIG_CODE_PARTY?>':
													            arr='A-00,A-01,A-02,A-99'.split(',');
													        break;
													        case '<?=DOC_BIG_CODE_BASIS?>':
													            arr='B-00,B-01,B-02,B_03,B-99'.split(',');
													        break;
													        case '<?=DOC_BIG_CODE_CREDIT?>':
													            arr='C-00,C-01,C-02,C-03,C-04,C-99'.split(',');
													        break;
													        case '<?=DOC_BIG_CODE_DECISION?>':
													            arr='D-00,D-01,D-02,D-03,D-04,D-05,D-99'.split(',');
													        break;
													        case '<?=DOC_BIG_CODE_MANAGE?>':
													            arr='E-00,E-01,E-02,E-03,E-04,E-99'.split(',');
													        break;
													        case '<?=DOC_BIG_CODE_FINANCIAL?>':
													            arr='F-00,F-01,F-02,F-03,F-99'.split(',');
													        break;
													        case '<?=DOC_BIG_CODE_PERSONNEL?>':
													            arr='G-00,G-01,G-02,G-03,G-04,G-05,G-99'.split(',');
													        break;
													        case '<?=DOC_BIG_CODE_ADMIN?>':
													            arr='H-00,H-01,H-02,H-99'.split(',');
													        break;
													        case '<?=DOC_BIG_CODE_BUSINESS?>':
													            arr='I-00,I-01,I-02,I-03,I-04,I-05,I-06,I-99'.split(',');
													        break;
													        case '<?=DOC_BIG_CODE_BRANCH?>':
													            arr='J-00,J-01,J-02,J-03,J-04,J-05,J-99'.split(',');
													        break;
													        case '<?=DOC_BIG_CODE_OTHER?>':
													            arr='Z-00,Z-01,Z-02,Z-99'.split(',');
													        break;
													 	}
													 	
													 	var data_new = [];
													 	var value = $('#txtb_doc_middle_code<?=$time?>').combobox('getValue');
    													var check = false;
													 	for(var i=0;i < data.length;i++)
					    								{
					    									if(arr.indexOf(data[i].id) > -1)
					    									{
						    									data_new.push(data[i])
						    									
						    									if(data[i].id == value)
						    									check=true;
					    									}
					    								}
					    								$('#txtb_doc_middle_code<?=$time?>').combobox('loadData',data_new);
					    								
					    								if( ! check )
					    								{
					    									$('#txtb_doc_middle_code<?=$time?>').combobox('clear');
					    								}
													 }
													 ">
                            </td>
                        </tr>
                        <tr>
                            <td class="field_s" style="height:35px;vertical-align:text-center">
                              	  中类码
                            </td>
                            <td>
                                <input name="content[doc_middle_code]"
                                       oaname="content[doc_middle_code]"
                                       id="txtb_doc_middle_code<?=$time?>"
                                       class="easyui-combobox oa_input"
                                       data-options="err:err,
					    			   				 limitToList:true,
					    			   				 valueField:'id',
						    						 textField:'text',
					    			   				 height:'25',
					    			   				 width:'200px',
					    			   				 multiline:false,
					    			   				 data: [<?=element('doc_middle_code',$json_field_define)?>],
					    			   				 panelHeight:'auto',
					    			   				 panelMaxHeight:120,
					    			   				 panelWidth:'',
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                            </td>
                            <td class="field_s" style="height:35px;vertical-align:text-center">
                                	小类码
                            </td>
                            <td>
                                <input name="content[doc_small_code]"
                                       oaname="content[doc_small_code]"
                                       class="easyui-textbox oa_input"
                                       data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200px',
					    			   				 multiline:false,
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                            </td>
                        </tr>
                        
                        <tr>
                            <td class="field_s" style="height:35px;vertical-align:text-center">
                                	案卷题名
                            </td>
                            <td>
                                <input name="content[doc_nominate]"
                                       oaname="content[doc_nominate]"
                                       class="easyui-textbox oa_input"
                                       data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200px',
					    			   				 multiline:false,
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                            </td>
                            <td class="field_s" style="height:35px;vertical-align:text-center">
                                	归档日期
                            </td>
                            <td>
                                <input name="content[doc_return_time]"
                                       oaname="content[doc_return_time]"
                                       class="easyui-datebox oa_input"
                                       data-options="err:err,
					    			   				 height:'25',
					    			   				 width:'200px',
					    			   				 multiline:false,
													 validType:['errMsg[\'#hd_err_f_<?=$time?>\']'],
													 ">
                            </td>
                        </tr>
                        <tr class="tr_title oa_op" oaname="title_gfc">
                            <td colspan="4" style="height:35px;vertical-align:text-center;"  >
                                <span>项目信息</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="field_s" style="height:35px;text-align: left">
                                	项目名称
                            </td>
                            <td colspan="3">
                                <span class="oa_input" name="content[gfc_name]" oaname="content[gfc_name]"></span>
                            </td>
                        </tr>

                        <tr>
                            <td class="field_s" style="height:35px;text-align: left">
                                	甲方单位
                            </td>
                            <td>
                                <span class="oa_input" name="content[gfc_org_jia_s]" oaname="content[gfc_org_jia_s]"></span>
                            </td>
                            <td class="field_s" style="height:35px;text-align: left">
                                	项目负责人
                            </td>
                            <td>
                                <span class="oa_input" name="content[gfc_c_s]" oaname="content[gfc_c_s]"></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="field_s" style="height:35px;text-align: left">
                                	财务编号
                            </td>
                            <td>
                                <span class="oa_input" name="content[gfc_finance_code]" oaname="content[gfc_finance_code]"></span>
                            </td>
                            <td class="field_s" style="height:35px;text-align: left">
                               	 合同总额
                            </td>
                            <td>
                                <span class="oa_input" name="content[gfc_sum]" oaname="content[gfc_sum]"></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="field_s" style="height:35px;text-align: left">
                                	附加属性
                            </td>
                            <td>
                                <span class="oa_input" name="content[gfc_category_extra]" oaname="content[gfc_category_extra]"></span>
                            </td>
                            <td class="field_s" style="height:35px;text-align: left">
                                	是否涉密
                            </td>
                            <td>
                                <span class="oa_input" name="content[gfc_category_secret]" oaname="content[gfc_category_secret]"></span>
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
						op_id: '<?=$doc_id?>',
						table: 'oa_doc',
						field: 'doc_id',
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
						op_id: '<?=$doc_id?>',
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
						op_id: '<?=$doc_id?>',
						table: 'oa_doc',
						field: 'doc_id',
						pp_id: '<?=$pp_id?>',
						time: 'file_<?=$time?>',
						search_f_t_proc: '<?=$proc_id?>',
						flag_f_type_more: 'false',
       				 }"
       	>
       	
    </div>
</div>

<!-- loading -->
<div id="win_loading<?=$time?>" style="padding:5px;overflow:hidden;"></div> 