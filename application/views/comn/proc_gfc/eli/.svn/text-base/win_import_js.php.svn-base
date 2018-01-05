<script>

//初始化
var row_num<?=$time;?>=2;
var num_import<?=$time;?>=0;
var msg_err<?=$time;?>='';
var sheet_num<?=$time;?>='1';
$(document).ready(function(){

	fun_read_xlsx<?=$time;?>();
});

//读取xlsx
function fun_read_xlsx<?=$time;?>()
{
	//读取权限配置
	$.ajax({
        url:"app/run_back/<?=$url?>.html",
        type:"POST",
        data:{
            row_num: row_num<?=$time;?>,
            num_import: num_import<?=$time;?>,
            msg_err: msg_err<?=$time;?>,
            sheet_num: sheet_num<?=$time;?>,
        },
        success: function(data){

            if( ! data )
            { 
                return;
            }

            var json = JSON.parse(data);

            row_num<?=$time;?>=json.row_num;
            msg_err<?=$time;?>+=json.msg_err;
            num_import<?=$time;?>=json.num_import;
            sheet_num<?=$time;?>=json.sheet_num;

            if(json.rtn_data && '<?=$fun_no_db?>')
            {
            	json.rtn_data = JSON.parse(json.rtn_data);
                <?=$fun_no_db?>('<?=$f_id?>','import',json.rtn_data);
            }

            if(json.rs)
            {
            	fun_load_back_task('btask_<?=$id;?>','【<?=$title?>】导入...',100);

            	var msg='导入完成！<br/><div style="font-size:12px;">成功导入'+(num_import<?=$time;?>)+'条记录！<br/>'+msg_err<?=$time;?>+'</div>'
            	fun_win_sys_msg('【<?=$title?>】导入结果',msg)
            	
            	setTimeout(function(){
            		fun_del_back_task('btask_<?=$id;?>')
                },2000);

            }
            else
            {            
            	fun_load_back_task('btask_<?=$id;?>','【<?=$title?>】导入中...'+row_num<?=$time;?>,85);
            	fun_read_xlsx<?=$time;?>()
            }
        }
	});
}

</script>
	 
