<script>

//初始化
//载入导出表格
var row_num<?=$time;?>=2
var page<?=$time;?>=1;
var bt_param<?=$time;?>=<?=$bt_param?>

$(document).ready(function(){

	fun_load_table_export<?=$time;?>();
});

function fun_load_table_export<?=$time;?>()
{
	//数据库字段表
	$('#table_export<?=$time;?>').datagrid({
		fit:true,
		url: 'app/run_back/'+bt_param<?=$time;?>.url,
		singleSelect:true,
		pagination:true,
		pageSize:200,
		pageList:[200],
		columns:[[
		]],
		method:'POST',
		queryParams:{
			data_search: bt_param<?=$time;?>.data_search,
			order: bt_param<?=$time;?>.order,
			sort: bt_param<?=$time;?>.sort,
		},
		onLoadSuccess: function(data)
		{
			bt_param<?=$time;?>.total=data.total;

			var per=parseInt(row_num<?=$time;?>/(bt_param<?=$time;?>.total)*100);
			fun_load_back_task('<?=$id?>','【'+data.title+'】导出中..',per);
			
			var row=JSON.stringify(data.rows)
			fun_save_xlsx<?=$time;?>(row);
		}
	});
}

//生成xlsx
function fun_save_xlsx<?=$time;?>(row)
{
	$.ajax({
        url:"app/run_back/base/fun/fun_xlsx_export/id/<?=$id?>.html",
        type:"POST",
        async:false,
        data:{
            btn: 'save',
            row :  row,
            row_num :  row_num<?=$time;?>,
            bt_param: bt_param<?=$time;?>
        },
        success: function(data){

            if( ! data )
            { 
                return;
            }
            
            var json = JSON.parse(data);

            row_num<?=$time;?>=json.row_num;
            
            if( json.rs )
            {
                if( json.row_num - 1 > bt_param<?=$time;?>.total )
                {
	            	fun_file_download('<?=$id?>.xlsx',bt_param<?=$time;?>.title+'.xlsx','tmp');
	            	setTimeout(function(){
	            		fun_del_back_task('<?=$id;?>')
	                },2000);

	                return;
                }
                
            	page<?=$time;?>++;
            	var p=$('#table_export<?=$time;?>').datagrid('getPager'); 
            	$(p).pagination('select', page<?=$time;?>);    
            }
            else
            {
            	setTimeout(function(){
            		fun_save_xlsx<?=$time;?>(json.row);
                },2000);
            }
        }
	});
}

</script>
	 
