<script type="text/javascript">
//载入数据
var data_<?=$time?>=<?=$data?>;   

//初始化
$(document).ready(function(){

	var html = $("#print<?=$time?>").html();
	
	var LODOP = getCLodop();
    if (LODOP) {
        LODOP.PRINT_INIT("打印任务名");
        LODOP.SET_PRINT_PAGESIZE(1, "", "", "A4");  //自定义纸张大小打印
        LODOP.ADD_PRINT_HTM('5mm', '0mm', "100%", "100%", html);  //设置打印内容

        //线条样式：虚线
        LODOP.SET_PRINT_STYLE("PenStyle", 2);
        LODOP.SET_PRINT_STYLE("PenWidth", 2);

        LODOP.SET_SHOW_MODE("HIDE_SBUTTIN_PREVIEW", 1);
        LODOP.PREVIEW();
    } else {
        alert('LODOP打印插件发生错误，请重试。');
    }

	//标题
	switch('<?=$fun_open?>')
	{
		case 'winopen':
		case '':
		window.close();
		break;
		case 'tab':
		
		break;
		case 'win':

		$('#<?=$fun_open_id?>').window('close');
		
		break;
	}
    
});
</script>