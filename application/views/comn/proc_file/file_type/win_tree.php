<table id="table_tree<?=$time?>" base64="1"></table> 

<div id="menu_table_tree<?=$time?>" class="easyui-menu" style="width:200px;">   
 	<div data-options="name:'sort',iconCls:'icon-sort'" onClick="fun_operate_table_tree<?=$time?>('sort')">排序</div>   
</div>       

<!-- loading -->
<div id="win_loading<?=$time?>" style="padding:5px;overflow:hidden;"></div> 