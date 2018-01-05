<!-- 加载jquery -->
<script type="text/javascript">

    //身份证件--载入
    function load_table_hr_idcard<?=$time?>()
    {
        $('#table_hr_idcard<?=$time?>').datagrid({
            width:'100%',
            height:'200',
            toolbar:'#table_hr_idcard_tool<?=$time?>',
            singleSelect:true,
            selectOnCheck:false,
            checkOnSelect:false,
            striped:true,
            idField:'hr_idc_id',
            data: [],
            destroyMsg:{
                norecord:{    // 在没有记录选择的时候执行
                    title:'警告',
                    msg:'没有选择要删除的行！'
                },
                confirm:{       // 在选择一行的时候执行
                    title:'确认',
                    msg:'确定要删除此行吗?'
                }
            },
            columns:[[
                {field:'hr_idc_type',title:'证件类型',width:150,halign:'center',align:'center',
                    formatter: fun_table_hr_idcard_formatter<?=$time?>,
                },
                {field:'hr_idc_code',title:'证件号码',width:150,halign:'center',align:'center',
                    formatter: fun_table_hr_idcard_formatter<?=$time?>,
                },
                {field:'hr_idc_note',title:'备注',width:150,halign:'center',align:'center',
                    formatter: fun_table_hr_idcard_formatter<?=$time?>,
                },
            ]],
            frozenColumns:[[
                {field:'hr_idc_id',title:'',width:50,align:'center',checkbox:true},
                {field:'hr_idc_name',title:'证件名称',width:180,halign:'center',align:'left',
                    formatter: fun_table_hr_idcard_formatter<?=$time?>,
                },
            ]],
            rowStyler: function(index,row){
                if (row.act == <?=STAT_ACT_CREATE?>)
                    return 'background:#ffd2d2';
                if (row.act == <?=STAT_ACT_REMOVE?>)
                    return 'background:#e0e0e0';

            },
            onLoadSuccess: function(data)
            {
            },
            onBeginEdit: function(index,row)
            {
            },
            onEndEdit: function(index, row, changes)
            {

            }
        });

        if( arr_view<?=$time?>.indexOf('content[hr_idcard]')>-1 )
        {
            $('#table_hr_idcard_tool<?=$time?> .oa_op').hide();
        }

        switch('<?=$act?>')
        {
            case '<?=STAT_ACT_CREATE?>':

                break;
            case '<?=STAT_ACT_EDIT?>':

                break;
            case '<?=STAT_ACT_VIEW?>':

                break;
        }



    }

    //列格式化输出
    function fun_table_hr_idcard_formatter<?=$time?>(value,row,index){

        switch(this.field)
        {
            case 'hr_idc_name':

                var url='proc_hr/hr_idcard/edit/act/2/fun_no_db/fun_no_db_table_hr_idcard<?=$time?>';
                value='<a href="javascript:void(0);" class="link" onClick="fun_table_hr_idcard_win_open<?=$time?>(\''+row.hr_idc_name.substring(0,10)+'\',\'win\',\''+url+'\',\''+row.hr_idc_id+'\');">'+value+'</a>';

                break;
            case 'hr_idc_type':
                switch(value){
                    case '<?=HR_IDC_TYPE_HZ?>':
                        value='护照';
                        break;
                    case '<?=HR_IDC_TYPE_SFZ?>':
                        value='身份证';
                        break;
                    case '<?=HR_IDC_TYPE_LK?>':
                        value='绿卡';
                        break;
                    case '<?=HR_IDC_TYPE_OTHER?>':
                        value='其他';
                        break;
                }
                break;

            default:
                if(row[this.field+'_s'])
                    value = row[this.field+'_s'];
        }

        if( ! value ) value = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ;
        return '<span id="table_hr_idcard<?=$time?>_'+index+'_'+this.field+'" class="table_hr_idcard<?=$time?>" >'+value+'</span>';
    }

    //界面
    function fun_table_hr_idcard_win_open<?=$time?>(title,fun,url,id)
    {
        switch(fun)
        {
            case 'win':

                var row ={};
                if(id)
                {
                    $('#table_hr_idcard<?=$time?>').datagrid('selectRecord',id);
                    row = $('#table_hr_idcard<?=$time?>').datagrid('getSelected');
                }

                var win_id=fun_get_new_win();

                var params={};
                params.data_db = base64_encode(JSON.stringify(row));

                if( '<?=$log_time?>' ||  '<?=$flag_check?>')
                {
                    var log_content = $('#table_hr_idcard<?=$time?>').attr('log_content');

                    if(log_content && id)
                    {
	                    log_content = JSON.parse(log_content);

                        if( ! ( id in log_content ) )
                        {
                            log_content[id] = {};
                            log_content[id]['old'] = {};
                            log_content[id]['old']['content'] = {};
                        }
	
	                    JSON.parse(JSON.stringify(row), function (key, value) {
	                        if( ! (key in log_content[id]['old'].content) )
	                            log_content[id]['old'].content[key] = value
	                    });
	
	                    log_content[id]['new'] = {};
	                    log_content[id]['new'].content = row;
	
	                    params.log_content = JSON.stringify(log_content[id]);
	
	                    if( '<?=$log_time?>' )
	                    {
	                        params.flag_log = 1;
	                        params.log_time = '<?=$log_time?>';
	                        params.log_a_login_id = '<?=$log_a_login_id?>';
	                        params.log_c_name = '<?=$log_c_name?>';
	                        params.log_act = '<?=$log_act?>';
	                        params.log_note = '<?=$log_note?>';
	                    }
	                    else
	                        params.flag_check = 1;
                    }
                }

                $('#'+win_id).window({
                    title: 'title',
                    inline:true,
                    modal:true,
                    closed:true,
                    border:'thin',
                    draggable:false,
                    resizable:false,
                    collapsible:false,
                    minimizable:false,
                    maximizable:false,
                    method:'post',
                    queryParams: params,
                    onClose: function()
                    {
                        $('#'+win_id).window('destroy');
                        $('#'+win_id).remove();
                    }
                })

                $('#'+win_id).window('refresh',url+'/fun_open/win/fun_open_id/'+win_id);

                break;
        }
    }

    //身份证件--操作
    function fun_table_hr_idcard_operate<?=$time?>(btn)
    {
        switch(btn)
        {
            case 'add':

                $('#table_hr_idcard<?=$time?>').datagrid('clearSelections');

                var url = 'proc_hr/hr_idcard/edit/fun_no_db/fun_no_db_table_hr_idcard<?=$time?>/act/1/c_id/<?=$c_id?>';

                fun_table_hr_idcard_win_open<?=$time?>('创建身份证件','win',url)

                break;
            case 'del':

                var op_list=$('#table_hr_idcard<?=$time?>').datagrid('getChecked');

                var row_s = $('#table_hr_idcard<?=$time?>').datagrid('getSelected');
                var index_s = $('#table_hr_idcard<?=$time?>').datagrid('getRowIndex',row_s);

                if($('#table_hr_idcard<?=$time?>').datagrid('validateRow',index_s))
                {
                    $('#table_hr_idcard<?=$time?>').datagrid('endEdit',index_s);
                }
                else
                {
                    $('#table_hr_idcard<?=$time?>').datagrid('cancelEdit',index_s);
                }

                for(var i=op_list.length-1;i>-1;i--)
                {
                    var index = $('#table_hr_idcard<?=$time?>').datagrid('getRowIndex',op_list[i]);
                    $('#table_hr_idcard<?=$time?>').datagrid('deleteRow',index);
                }

                break;
        }
    }

    function fun_no_db_table_hr_idcard<?=$time?>(f_id,btn)
    {
        var row_s = $('#table_hr_idcard<?=$time?>').datagrid('getSelected');
        var row = fun_get_data_from_f(f_id,'1');

        $('#'+f_id).closest('.op_window').window('close');

        if( row_s )
        {
            var index_s = $('#table_hr_idcard<?=$time?>').datagrid('getRowIndex',row_s);

            if(btn == 'del')
            {
                $('#table_hr_idcard<?=$time?>').datagrid('deleteRow',index_s);
                return;
            }

            row.c_id = '<?=$c_id?>';
            $('#table_hr_idcard<?=$time?>').datagrid('updateRow',{
                index: index_s,
                row: row
            });
        }
        else
        {
            row.hr_idc_id = get_guid();

            $('#table_hr_idcard<?=$time?>').datagrid('appendRow',row);
        }
    }

</script>