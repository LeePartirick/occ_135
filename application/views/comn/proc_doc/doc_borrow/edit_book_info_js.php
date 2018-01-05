<!-- 加载jquery -->
<script type="text/javascript">

    //开票回款计划--载入
    function load_table_book_info<?=$time?>()
    {
        $('#table_book_info<?=$time?>').datagrid({
            width:'100%',
            height:'200',
            url:'proc_doc/doc_borrow/get_json_book/search_book_info/'+'<?=$docb_id?>',
            singleSelect:true,
            selectOnCheck:false,
            checkOnSelect:false,
            striped:true,
            remoteSort: false,
            idField:'docb_id',
            data: [],
            columns:[[
				{field:'docb_explain',title:'情况说明',width:200,halign:'center',align:'center',
				    formatter: fun_table_gfc_bp_formatter<?=$time?>,
				},
            ]],
            frozenColumns:[[
                {field:'docb_id',title:'',width:50,align:'center',checkbox:true},
                {field:'docb_code',title:'单据编号',width:125,halign:'center',align:'center',
                    formatter: fun_table_gfc_bp_formatter<?=$time?>,
                },
                {field:'docb_time_start',title:'借阅时间',width:125,halign:'center',align:'center',sortable:true,
                    formatter: fun_table_gfc_bp_formatter<?=$time?>,
    				sorter:function(a,b){
                        a = a.split('-');
                        b = b.split('-');
                        if (a[0] == b[0]){
                            if (a[1] == b[1]){
                                return (a[2]>b[2]?1:-1);
                            } else {
                                return (a[1]>b[1]?1:-1);
                            }
                        } else {
                            return (a[0]>b[0]?1:-1);
                        }
                    }
                },
                {field:'docb_c_id',title:'借阅人',width:120,halign:'center',align:'center',
                    formatter: fun_table_gfc_bp_formatter<?=$time?>,
                },
                {field:'docb_c_ou',title:'所属公司',width:200,halign:'center',align:'center',
                    formatter: fun_table_gfc_bp_formatter<?=$time?>,
                },
            ]],
            rowStyler: function(index,row){
                
            },
            onLoadSuccess: function(data)
            {
            },
        });

    }


    //列格式化输出
    function fun_table_gfc_bp_formatter<?=$time?>(value,row,index){
        switch(this.field)
        {
        	case 'docb_code':
				value=base64_decode(row.docb_code);
				if(row.docb_id)
				{
					var url='proc_doc/doc_borrow/edit/act/2/docb_id/'+base64_decode(row.docb_id);
                  	value='<a href="javascript:void(0);" class="link" onClick="fun_index_win_open<?=$time?>(\''+base64_decode(row.docb_id)+'\',\'win\',\''+url+'\');">'+value+'</a>';
				}
            	break;
        	case 'docb_c_id':
				value=base64_decode(row.docb_c_id_s);
            	break;
        	case 'docb_c_ou':
				value=base64_decode(row.docb_c_ou_s);
            	break;
        	case 'docb_explain':
				value=base64_decode(row.docb_explain);
            	break;
        	case 'docb_time_start':
				value=base64_decode(row.docb_time_start)+'至'+base64_decode(row.docb_time_end);
            	break;
            default:
                if(row[this.field+'_s'])
                    value = row[this.field+'_s'];
        }
        
        return value;
    }
</script>