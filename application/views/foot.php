</body>

<!-- 载入js -->
<script type="text/javascript" >

//jquery
document.write("<scr"+"ipt src=\"inc/js/easyui/jquery.min.js\"></sc"+"ript>");

//cookie
document.write("<scr"+"ipt src=\"inc/js/jquery.cookie.js\"></sc"+"ript>");

//json
document.write("<scr"+"ipt src=\"inc/js/json.js\"></sc"+"ript>");

//base64
document.write("<scr"+"ipt src=\"inc/js/base64.js\"></sc"+"ript>");

//md5
document.write("<scr"+"ipt src=\"inc/js/md5.js\"></sc"+"ript>");

//sui
document.write("<scr"+"ipt src=\"inc/js/sui/js/sui.min.js\"></sc"+"ript>");

//layer
document.write("<scr"+"ipt src=\"inc/js/layer/layer.js\"></sc"+"ript>");
document.write("<scr"+"ipt src=\"inc/js/layui/layui.js\"></sc"+"ript>");

//easyui
document.write("<scr"+"ipt src=\"inc/js/easyui/jquery.easyui.min.js\"></sc"+"ript>");
document.write("<scr"+"ipt src=\"inc/js/easyui/locale/easyui-lang-zh_CN.js\"></sc"+"ript>");

//easyui ext
document.write("<scr"+"ipt src=\"inc/js/easyui/ext/jquery.edatagrid.js\"></sc"+"ript>");//行编辑
document.write("<scr"+"ipt src=\"inc/js/easyui/ext/treegrid-dnd.js\"></sc"+"ript>");//行编辑
document.write("<scr"+"ipt src=\"inc/js/easyui/ext/datagrid-dnd.js\"></sc"+"ript>");//行拖拽
document.write("<scr"+"ipt src=\"inc/js/easyui/ext/datagrid-cellediting.js\"></sc"+"ript>");//单元格编辑
document.write("<scr"+"ipt src=\"inc/js/easyui/ext/columns-ext.js\"></sc"+"ript>");//列移动
document.write("<scr"+"ipt src=\"inc/js/easyui/ext/datagrid-detailview.js\"></sc"+"ript>");//表格折叠
document.write("<scr"+"ipt src=\"inc/js/easyui/ext/datagrid-celltip.js\"></sc"+"ript>");//单元格提示
document.write("<scr"+"ipt src=\"inc/js/easyui/ext/datagrid-groupview.js\"></sc"+"ript>");//表格分组
document.write("<scr"+"ipt src=\"inc/js/easyui/ext/datagrid-bufferview.js\"></sc"+"ript>");//缓存视图
document.write("<scr"+"ipt src=\"inc/js/easyui/ext/datagrid-filter.js\"></sc"+"ript>");//缓存视图

//stream插件
document.write("<scr"+"ipt src=\"inc/js/stream/stream-v1.js\"></sc"+"ript>");

//图片截取插件
document.write("<scr"+"ipt src=\"inc/js/photoClip/iscroll-zoom.js\"></sc"+"ript>");
document.write("<scr"+"ipt src=\"inc/js/photoClip/hammer.js\"></sc"+"ript>");
document.write("<scr"+"ipt src=\"inc/js/photoClip/jquery.photoClip.min.js\"></sc"+"ript>");

//ueditor
document.write("<scr"+"ipt src=\"inc/js/ueditor/ueditor.config.js\"></sc"+"ript>");
document.write("<scr"+"ipt src=\"inc/js/ueditor/ueditor.all.js\"></sc"+"ript>");

//lazyload 图片延迟加载
document.write("<scr"+"ipt src=\"inc/js/lazyload/jquery.lazyload.min.js\"></sc"+"ript>");

//lodop
//document.write("<scr"+"ipt src=\"http://localhost:8000/CLodopfuncs.js\"></sc"+"ript>");
</script>

<!-- 加载jquery -->
<script type="text/javascript" >

	//客户端id 定义
	var client_id = '';
	
	//当前页面宽度
	var body_width=$(window).width();
	
	//当前页面高度
	var body_height=$(window).height();

	 //百度编辑器工具栏
    var ueditor_tool=[];
    ueditor_tool['simple']=['Undo', 'Redo','|','link', 'unlink', 'anchor','|','Bold','underline','fontfamily','fontsize','forecolor', '|','cleardoc'];
    ueditor_tool['all']=['Undo', 'Redo','|',
                             'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc', '|',
                             'rowspacingtop', 'rowspacingbottom', 'lineheight', '|',
                             'customstyle', 'paragraph', 'fontfamily', 'fontsize', '|',
                             'directionalityltr', 'directionalityrtl', 'indent', '|',
                             'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|', 'touppercase', 'tolowercase', '|',
                             'link', 'unlink', 'anchor', '|', 'imagenone', 'imageleft', 'imageright', 'imagecenter', '|',
                             'horizontal', 'date', 'time', 'spechars', 'wordimage', '|',
                             'inserttable', 'deletetable', 'insertparagraphbeforetable', 'insertrow', 'deleterow', 'insertcol', 'deletecol', 'mergecells', 'mergeright', 'mergedown', 'splittocells', 'splittorows', 'splittocols', 'charts', '|',
                             'print', 'preview', 'searchreplace', 'drafts', 'help',
                             ];
    
	//easyui调整
	$.messager.defaults.border="thin";
	
	//禁止右键菜单
	$(document).bind('contextmenu',function(e){
		e.preventDefault();
		return false;
	});

	//扩展编辑器
	$.extend($.fn.datagrid.defaults.editors, {
		tagbox: {
			init: function(container, options){
				var input = $('<input type="text">').appendTo(container);
				return input.tagbox(options);
			},
			destroy: function(target){
				$(target).tagbox('destroy');
			},
			getValue: function(target){
				return $(target).tagbox('getValues');
			},
			setValue: function(target, value){
				$(target).tagbox('setValues',value);
			},
			resize: function(target, width){
				$(target).tagbox('resize',width);
			}
		}
	});

	<?php if ( ! empty ($this->sess->userdata('a_id') ) ){ ?>
	//保持sess
	setInterval(function(){

		if( $.cookie('client_id') != client_id) return;
		
		 //保存配置
		$.ajax({
	        url:"base/main/keep_sess.html",
	        type:"POST",
	        async:false,
	        data:{},
	        success:function(data){
				if( data != '<?=$this->sess->userdata('a_id') ?>')
				{
					window.location.href=window.location.href; 
				}
	        }
		});
	        
	},1000*60*5);
	<?}?>

	//浏览器聚焦
	window.onfocus = function(){
		$.cookie('onfocus', '1'); 
	}
	
	//浏览器离开
	window.onblur = function() {
		$.cookie('onfocus', null); 
	}
	
	//窗口大小变化时
	$(window).resize(function() {
		
		//当前页面宽度
		body_width=$(window).width();
	
		//当前页面高度
		body_height=$(window).height();

		var width = 1000;
		if(body_width < width )
		width=body_width-50;

		var height = 550;
		if(body_height - 150 < height )
		height=body_height - 200;

		$('.op_window').window('resize',{
			width: width,
			height: height
		});

		setTimeout(function() {
			$('.op_window').window('hcenter');
		},500)
	
	});

	//图片延迟加载
	function lazyload(op , height){
		//op下 所有lazy类
		var list=$(op).find('.lazy');
		
		for(var i=0;i<list.length;i++)
		{

			if($(list[i]).attr('src') != 'img/grey.gif' && $(list[i]).hasClass('lazy'))
			{
				$(list[i]).removeClass('lazy');
				continue;
			}
			
			var winScrollTop = $(op).scrollTop();
			var winHeight = $(op).height();
			var itemOffsetTop = $(list[i]).offset().top;
			var itemOuterHeight = $(list[i]).outerHeight();

			//可见
			if(!(itemOffsetTop - height > itemOuterHeight) && (itemOffsetTop>0)) {
				$(list[i]).click();
				 break;
		    }

		}

	}
	
	//日期格式化
	function myformatter(date){
		var y = date.getFullYear();
		var m = date.getMonth()+1;
		var d = date.getDate();
		if(m<10) m='0'+m;
		if(d<10) d='0'+d;
		return y+'-'+m+'-'+d;
	}
	
	function myparser(s){
		var sF =s.split('-')[1]+'/'+s.split('-')[2]+'/'+s.split('-')[0];
		var t = Date.parse(sF);
		if (!isNaN(t)){
			return new Date(t);
		} else {
			return new Date();
		}
	}

	//当前时间
	function fun_get_date(date)
	{
		var myDate = new Date();
	
		var weekday=new Array(7);
		weekday[0]="周日";
		weekday[1]="周一";
		weekday[2]="周二";
		weekday[3]="周三";
		weekday[4]="周四";
		weekday[5]="周五";
		weekday[6]="周六";
	
		var reg=new RegExp("W","g"); //创建正则RegExp对象 
		date=date.replace(reg,weekday[myDate.getDay()]);
		
		var reg=new RegExp("Y","g"); //创建正则RegExp对象 
		date=date.replace(reg,myDate.getFullYear());
	
		var reg=new RegExp("m","g"); //创建正则RegExp对象 
		var m=myDate.getMonth();
		m=parseInt(m)+1;
		if(m<10) m='0'+m;
		date=date.replace(reg,m);
	
		var reg=new RegExp("d","g"); //创建正则RegExp对象 
		var d=myDate.getDate();
		if(d<10) d='0'+d;
		date=date.replace(reg,d);
	
		var reg=new RegExp("H","g"); //创建正则RegExp对象 
		var h=myDate.getHours();
		if(h<10) h='0'+h;
		date=date.replace(reg,h);
	
		var reg=new RegExp("i","g"); //创建正则RegExp对象 
		var i=myDate.getMinutes();
		if(i<10) i='0'+i;
		date=date.replace(reg,i);
	
		var reg=new RegExp("s","g"); //创建正则RegExp对象 
		var s=myDate.getSeconds();
		if(s<10) s='0'+s;
		date=date.replace(reg,s);
		
		return date;
	}

	//获取随机id
	function get_guid()
	{
		var str=fun_get_date('YmdHis');
		str+=Math.random();
		return md5(str).toLowerCase();
	}

	//去除最后几位
	function trim(str,l)
	{
		var s=str;
		str=s.substring(0,s.length-l.length);
		return str;
	}

	//去除最后几位
	function ntrim(str,num)
	{
		var s=str;
		str=s.substring(0,s.length-num);
		return str;
	}

	//数字千分位格式化
	function num_parse(value){
		if( value !=0 && ! value )
			return '0.00';
		
		var v=(parseFloat(value).toFixed(2) + '').replace(/\d{1,3}(?=(\d{3})+(\.\d*)?$)/g, '$&,');
		return v;
	}

	//判断是否字符串
	function isString(str){
	return (typeof str=='string')&&str.constructor==String;
	} 

	//判断是否数组
	function isArray(o){
	return Object.prototype.toString.call(o)=='[object Array]';
	}

	//日期天数计算
	function getNewDay(dateTemp, days) {  
	    var dateTemp = dateTemp.split("-");  
	    var nDate = new Date(dateTemp[0] + ',' + dateTemp[1] + ',' + dateTemp[2]); //转换为MM-DD-YYYY格式    
	    var millSeconds = Math.abs(nDate) + (days * 24 * 60 * 60 * 1000);  
	    var rDate = new Date(millSeconds);  
	    var year = rDate.getFullYear();  
	    var month = rDate.getMonth() + 1;  
	    if (month < 10) month = "0" + month;  
	    var date = rDate.getDate();  
	    if (date < 10) date = "0" + date;  
	    return (year + "-" + month + "-" + date);  
	}  
	
	//js 数组删除元素
	/** 
	　 *　方法:Array.baoremove(index) 
	　 *　功能:删除数组元素
	　 *　参数:index删除元素的下标 
	　 *　返回:在原数组上修改数组 
	　 */  
	Array.prototype.baoremove = function(dx)
    {
      if(isNaN(dx)||dx>this.length){return false;}
      this.splice(dx,1);
    }

	//焦点聚集
	function fun_form_focus(form_id){
    	var form=$('#'+form_id+' .textbox-text')
    	for(var i=0;i<form.length;i++)
    	{
        	if( ! $(form[i]).attr('readonly') )
        	{
	    		$(form[i]).focus();
	    		break;
        	}
    	}
	}

	//文件下载
	function fun_file_download(id,name,folder){
		var url='<?=base_url()?>base/fun/file_download/folder/'+folder+'/file/'+base64_encode(id)+'/name/'+base64_encode(name);
    	window.open(url);
	}

	//显示后台任务
	var index_back_task;
	function fun_show_back_task(op)
	{
		var left=$(op).offset().left;
		var top=$(op).offset().top+40;

		if( left+300 > body_width )
			left=body_width-320;
		
		if(index_back_task)
			return;
		
		//捕获页
		index_back_task=layer.open({
		  offset: [top, left],
		  id: 'layer_back_task',
		  type: 1,
		  shade: false,
		  title: false,//'后台任务', 
		  anim: 1,
		  closeBtn: 0,
		  resize:false,
		  content: $('#win_back_task'), 
		  end : function()
		  {
			index_back_task='';
		  }
		});
	}

	//载入后台任务
	function fun_load_back_task(id,title,per)
	{
		if( ! per ) per=5;

		if( ! title) title='后台任务建立中..';
		
		if($('#bar_'+id).length == 0)
		$('#win_back_task').append('<div id="bar_'+id+'" style="width:100%"><div class="bar_name" style="font-size:12px;"></div><div class="sui-progress progress-striped active"><div style="width:'+per+'%;" class="bar"></div></div></div>')

		if( per >= 100)
			title+=' 完成!';

		$('#bar_'+id+' .bar_name').html(title);
		$('#bar_'+id+' .bar').width(per+'%');
		var num_task=$('#win_back_task .bar').length;

		$('#btn_back_task .m-badge').html(num_task);
		
		if(num_task > 0)
		{
			$('#btn_back_task .m-badge').show();
		}
		else
		{
			$('#btn_back_task .m-badge').hide();
		}
	}

	//删除后台任务iframe
	function fun_del_back_task(id)
	{
		$('#'+id).panel('destroy');
		$('#'+id).remove();
		$('#bar_'+id).remove();

		var num_task=$('#win_back_task .bar').length;

		$('#btn_back_task .m-badge').html(num_task);
		
		if(num_task > 0)
			$('#btn_back_task .m-badge').show();
		else
			$('#btn_back_task .m-badge').hide();
	}

	//loading窗口
	function load_win_loading(id)
	{
		$('#'+id).window({    
		    height:60,
		    width:60,
		    border:false,
		    shadow:false,    
		    modal:true,
		    inline:true,
		    noheader:true,
		    resizable:false,
		    closed:true,
		    content: '<div class="sui-loading loading-inline"><i class="sui-icon icon-pc-loading"><\/i><\/div>',
		    onBeforeOpen : function()
		    {
		   		$(this).window('center');
		   		$(this).window('window').removeClass('div_circle').addClass('div_circle');
		   		$(this).window('window').removeClass('div_filter').addClass('div_filter');
		    }
		}); 
	}
	
	//显示菜单
	function menu_show(menu,e)
	{
		//菜单高度
		var memu_height=$('#'+menu).height();
		//鼠标位置高度
		var menu_Y=e.pageY;
		//菜单位置调整值
		var menu_H=0;
		//如果菜单显示后超出浏览器，则调整其显示位置
		if(body_height-menu_Y<memu_height){
			menu_H=memu_height-(body_height-menu_Y)+15;
		}
		
		//显示菜单
		$('#'+menu).menu('show', {
			left: e.pageX,
			top: e.pageY-menu_H
		})
	}

	//form表单提取数据
	function fun_get_data_from_f(form_id,flag_datagrid)
	{
		var op=$("#"+form_id+" .oa_input");

		var data={};
		
		for(var i=0;i<op.length;i++)
		{
			var op_class=$(op[i]).attr("class");
			var op_name=$(op[i]).attr("oaname");
			var op_name_s=trim(op_name,']')+'_s]';

			if( flag_datagrid 
			 && op_name.indexOf('[') > -1 
			 && op_name.indexOf(']') > -1)
			{
				var arr_tmp = op_name.split('[');
				if(arr_tmp.length > 1 )
				{
					arr_tmp = arr_tmp[1].split(']');
					op_name = arr_tmp[0];
				}

				op_name_s = op_name+'_s';
			}
				

			if($(op[i]).attr('type') == 'checkbox')
			{
				data[op_name]=0;
				if($(op[i]).is(':checked'))
				{
					data[op_name]=1;
				}
			}
			else if($(op[i]).attr('type') == 'hidden')
			{
				data[op_name]=$(op[i]).val();
			}
			else if(op[i].tagName == 'SPAN')
			{
				if( ! (op_name in data) )
				data[op_name]=$(op[i]).html();
			}
			else if( op_class.indexOf('data_table')>-1)
			{
				try{
				var row_s = $(op[i]).datagrid('getSelected');
				var index_s = $(op[i]).datagrid('getRowIndex',row_s);

				data[op_name]=$(op[i]).datagrid('getRows');
				
				if(index_s > -1)
				{
					if($(op[i]).datagrid('validateRow',index_s))
					{
						$(op[i]).datagrid('endEdit',index_s);
					}
					else
					{
						$(op[i]).datagrid('cancelEdit',index_s);
					}
				}
				else
				{
//					var cell = $(op[i]).datagrid('getSelectedCells');
//
//					if(cell.length > 0)
//					{
//						for(var f=0;f<cell.length;f++)
//						{
//							var index_s = cell[$f].index;
//							$(op[i]).datagrid('endEdit',index_s);
//						}
//					}
				}

				if($("#"+form_id).attr('log') != 1 && $(op[i]).parent().find('.datagrid-filter-c').length > 0)
				{
					$(op[i]).datagrid('removeFilterRule');
					$(op[i]).datagrid('doFilter');
				}
				
				data[op_name]=$(op[i]).datagrid('getRows');
				data[op_name]=JSON.stringify(data[op_name]);
				
				}catch(e){};
			}
			else if(op_class.indexOf('easyui-combobox')>-1)
			{
				data[op_name]=$(op[i]).combobox('getValue');
				data[op_name_s]=$(op[i]).combobox('getText');
			}
			else if(op_class.indexOf('easyui-combotree')>-1)
			{
				var opt = $(op[i]).combotree('options');
				if(opt.multiple)
				data[op_name]=$(op[i]).combotree('getValues');
				else
				data[op_name]=$(op[i]).combotree('getValue');

				data[op_name_s]=$(op[i]).combotree('getText');
			}
			else if(op_class.indexOf('easyui-combogrid')>-1)
			{
				var opt = $(op[i]).combogrid('options');
				if(opt.multiple)
				data[op_name]=$(op[i]).combogrid('getValues');
				else
				data[op_name]=$(op[i]).combogrid('getValue');

				data[op_name_s]=$(op[i]).combogrid('getText');
			}
			else if(op_class.indexOf('easyui-combotreegrid')>-1)
			{
				var opt = $(op[i]).combotreegrid('options');
				if(opt.multiple)
				data[op_name]=$(op[i]).combotreegrid('getValues');
				else
				data[op_name]=$(op[i]).combotreegrid('getValue');

				data[op_name_s]=$(op[i]).combotreegrid('getText');
			}
			else if(op_class.indexOf('easyui-tagbox')>-1)
			{
				data[op_name]=$(op[i]).tagbox('getValues');
				data[trim(op_name,']')+'_data]']=$(op[i]).tagbox('getData');

				data[op_name_s]=$(op[i]).tagbox('getText');
			}
			else if(op_class.indexOf('easyui-textbox')>-1)
			{
				data[op_name]=$(op[i]).textbox('getValue').trim();
			}
			else if(op_class.indexOf('easyui-numberbox')>-1)
			{
				data[op_name]=$(op[i]).numberbox('getValue');
			}
			else if(op_class.indexOf('easyui-datebox')>-1)
			{
				data[op_name]=$(op[i]).datebox('getValue');
			}
			else if(op_class.indexOf('easyui-datetimebox')>-1)
			{
				data[op_name]=$(op[i]).datetimebox('getValue');
			}
			else if(op_class.indexOf('easyui-switchbutton')>-1)
			{
				var opt=$(op[i]).switchbutton('options');
				
				if(opt.checked)
					data[op_name]=1;
				else
					data[op_name]=0;
			}
		}

		return data;
	}
	
	//错误提示
	function err(target, message,action){
		
		var t = $(target);

		if(message || t.val() == ' ')
			t.parent().addClass('div_input_require');
		else
			t.parent().removeClass('div_input_require');

		var msg=t.parent().prev().attr('err-msg');
		
		if(msg) message=msg;
		
		$.fn.validatebox.defaults.err(target, message, action);
			
	}
	
	//错误提示
	$.extend($.fn.validatebox.defaults.rules, {    
		//自定义错误信息
		errMsg: {    
	        validator: function(value, param){  
				var err=$(this).parent().prev().attr('err-msg');
				var check = $(param[0]).val();

	            return ! check || ! err; 
	        },    
	        message: 'err!'   
	    },
	    //密码不符合要求
	    errPwd: {    
	        validator: function(value,param){    
		
			 	var   re1 =/[A-Za-z]+/;
			 	var   re2 =/[0-9]+/;
			 	var   re3 =/[~!@#$%^&*()_+-/=]+/;
	
	            return  value.length>10 && re1.test(value) && re2.test(value) && re3.test(value);   
	        },    
//	        message: '密码长度必须大于等于11位，且必须同时包含字母，数字和字符！'   
	        message: '密码复杂度不合法！'   
	    },
	    //身份证
        person_code: {
            validator: function(value, param){

        		var re =  /^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}([0-9]|X)$/
                return re.test(value);
            },
            message: '身份证不合法！'
        },
	    //tag控件唯一
        uniquetag: {
            validator: function(value, param){
                var tb = $(this).closest('.tagbox').prev();
                var values = tb.tagbox('getValues');
                return $.inArray(value, values)==-1;
            },
            message: '存在重复项！'
        },    
      	//最大值
        max: {
            validator: function(value, param){
            	var max = parseFloat(param[0]);
            	value = parseFloat(value.replace(/,/g, ""));
                return value - max <= 0;
            },
            message: '超出最大值{0}！'
        },  
	}); 

	//遍历form 错误消息添加
	function fun_show_errmsg_of_form(form_id,err_json,add)
	{
		if( ! err_json) return;

		var op=$("#"+form_id+" .oa_input");

		for(var i=0;i<op.length;i++)
		{
			var name=$(op[i]).attr('oaname');
			var id=$(op[i]).attr('id');
			
			if($(op[i]).attr('type') == 'checkbox')
			{
				if(err_json[name])
					$(op[i]).after('<span class="err_msg" style="color:red">&nbsp;'+err_json[name]+'</span>');
				else if( ! add)
					$(op[i]).next('.err_msg').remove();
			}
			else if($(op[i]).hasClass('upload_img'))
			{
				if(err_json[name])
				{
					$(op[i]).addClass('div_input_require');
					layer.tips(err_json[name], $(op[i]));
				}
				else if( ! add)
				{
					$(op[i]).removeClass('div_input_require');
				}
			}
			else if($(op[i]).hasClass('data_table'))
			{

				if( ! add)
				{
					$('.'+id+' .data_table_cell_err').unbind('mouseover');
					$('.'+id+' .data_table_cell_err').removeAttr('err_msg');
					$('.'+id+'').removeClass('data_table_cell_err');
					$(op[i]).parent().parent().removeClass('div_input_require');
					$(op[i]).parent().parent().unbind('mouseover');
				}
				
				if(err_json[name] && err_json[name] != '')
				{
					$(op[i]).parent().parent().addClass('div_input_require');

					if( ! isArray(err_json[name]) )
					{
						var msg_err = err_json[name]
						$(op[i]).parent().parent().bind('mouseover',
						function(){
							layer.tips(msg_err,this,{tips: [1],});
						})
						continue;
					}
					
					var json_alter={};
					
					for(var j=0;j < err_json[name].length;j++)
					{
						if( err_json[name][j].act == <?=STAT_ACT_REMOVE?> )
						{
							$(op[i]).datagrid('insertRow',{
								index : 0,
								row : err_json[name][j].row
							});
							continue;
						}

						var index = $(op[i]).datagrid('getRowIndex',err_json[name][j].id)
						
						if( err_json[name][j].act == '<?=STAT_ACT_CREATE?>' )
						{
							if(index > -1)
							$(op[i]).datagrid('updateRow',{
									index : index,
									row : {act : 1}
								});
							else
							{
								$(op[i]).datagrid('insertRow',{
									index : 0,
									row : err_json[name][j].row
								});
							}
							
							continue;
						}

						if( err_json[name][j].act == '<?=STAT_ACT_EDIT?>' )
						{
							
							if( ! ( err_json[name][j].id in json_alter) )
							{
								json_alter[err_json[name][j].id]={};
								
								json_alter[err_json[name][j].id]['old']={};
								json_alter[err_json[name][j].id]['old'].content = {};

							}

							if(err_json[name][j].value_old)
							json_alter[err_json[name][j].id].old.content[err_json[name][j].field] = err_json[name][j].value_old;
						}

						$('#'+id+'_'+index+'_'+err_json[name][j].field).addClass('data_table_cell_err');

						$('#'+id+'_'+index+'_'+err_json[name][j].field).attr('err_msg',err_json[name][j].err_msg);
						
						$('#'+id+'_'+index+'_'+err_json[name][j].field).bind('mouseover',
						function(){
							var msg = $(this).attr('err_msg')
							layer.tips(msg,this);
						})
					}

					var log_content = JSON.stringify(json_alter);

					$(op[i]).attr('log_content',log_content);
				}
			}
			else
			{
				//存在错误信息
				if( ! add)
				{
					$(op[i]).attr('err-msg','');
				}
				
				if(err_json[name])
				{
					$(op[i]).attr('err-msg',err_json[name]);

					if($(op[i]).hasClass('easyui-textbox'))
					{
						if( ! $(op[i]).textbox('getText'))
						$(op[i]).textbox('setText',' ');
					}
					else if($(op[i]).hasClass('easyui-passwordbox'))
					{
					}
					else if($(op[i]).hasClass('easyui-numberbox'))
					{
						if( ! $(op[i]).numberbox('getText'))
							$(op[i]).numberbox('setText',' ');
					}
					else if($(op[i]).hasClass('easyui-datebox'))
					{
						if( ! $(op[i]).datebox('getText'))
							$(op[i]).datebox('setText',' ');
					}
					else if($(op[i]).hasClass('easyui-datetimebox'))
					{
						if( ! $(op[i]).datetimebox('getText'))
							$(op[i]).datetimebox('setText',' ');
					}
					else if($(op[i]).hasClass('easyui-combobox'))
					{
						if( ! $(op[i]).combobox('getText'))
							$(op[i]).combobox('setText',' ');
					}
					else if($(op[i]).hasClass('easyui-combotree'))
					{
						if( ! $(op[i]).combotree('getText'))
							$(op[i]).combotree('setText',' ');
					}
					else if($(op[i]).hasClass('easyui-combogrid'))
					{
						if( ! $(op[i]).combogrid('getText'))
							$(op[i]).combogrid('setText',' ');
					}
					else if($(op[i]).hasClass('easyui-tagbox'))
					{
						if( ! $(op[i]).tagbox('getText'))
							$(op[i]).tagbox('setText',' ');
					}
				}
			}
		}
	}

	//layout 添加禁用
	function fun_l_disable_class(l_id,arr_disable)
	{
		var op=$("#"+l_id+' .oa_op');

		for(var i=0;i<op.length;i++)
		{
			var op_name=$(op[i]).attr("oaname");
			var op_class=$(op[i]).attr("class");
			var op_parent_class=$(op[i]).parent().attr("class");
			var op_parent=$(op[i]).parent();

			if(arr_disable.indexOf(op_name) > -1)	
			{
				if( op_class.indexOf('easyui-linkbutton')>-1 
				 || op_class.indexOf('easyui-splitbutton')>-1
				)
				{
					$(op[i]).hide();
				}
				else if(op_class.indexOf('tr_title')>-1)
				{
					fun_tr_title_show($(op[i]).parent(),op_name)
				}
				else if(op[i].tagName == 'TD')
				{
					$(op[i]).hide();
					var list_td=$(op[i]).parent().children('td')
					var hd=0
					for( var j=0;j<list_td.length;j++ )
					{
						if($(list_td[j]).css('display') == 'none' || ! $(list_td[j]).text().trim())
						{
							hd++;
						}
					}

					if(hd == list_td.length)
					$(op[i]).parent().hide();
				}
				else if(op_parent_class && op_parent_class.indexOf('easyui-tabs')>-1)
				{
					$(op[i]).attr('disabled','true');
				}
			}
		}
	}

	//标题行显示隐藏
	function fun_tr_title_show(op,title,show,collapse)
	{
		var list=$(op).find('tr');

		var check = false;
		for(var j=0;j<list.length;j++)
		{
			if(check && $(list[j]).hasClass('tr_title') && $(list[j]).attr('oaname') != title )
				break;
				
			if($(list[j]).attr('oaname') == title)
			{
				check = true
				if(collapse) j++;
			}
			
			if(check)
			{
				if( ! show )
					$(list[j]).hide();
				else
					$(list[j]).show();
			}
		}
	}
	
	//form表单操控(只读，编辑,必填)
	function fun_form_operate(form_id,arr_view,arr_edit,arr_req,flag_edit_more)
	{
		var op=$("#"+form_id+" .oa_input");

		$("#"+form_id).find('table').css('table-layout','fixed');
		
		for(var i=0;i<op.length;i++)
		{
			var op_class=$(op[i]).attr("class");
			var oaname = $(op[i]).attr("oaname");
			var required = false;
			var label = '';
			var labelWidth = 0;

			if(flag_edit_more)
			{
				label = '<input type=\'checkbox\' class=\'oa_input\' oaname=\''+trim(oaname,']')+'_check]\' title="批量编辑控件勾选"/>'
				labelWidth = 30;
			}

			if($(op[i]).attr('type') == 'checkbox')
			{
				if(arr_view.indexOf( oaname ) > -1)
				{
					$(op[i]).attr('disabled','disabled');
				}
				else
				{
					if(label)
					{
						$(op[i]).css('margin-left','30px');
						$(op[i]).before(label);
					}
				}
			}
			else if(op_class.indexOf('upload_img')>-1)
			{
				if(arr_view.indexOf( oaname ) > -1)
				{
					$(op[i]).attr('onClick','');  
					$(op).parent().tooltip({showEvent:''})
				}
				else
				{
					if(arr_req.indexOf( oaname ) > -1 )
					{
						var img=$(op[i]).next().attr('value');
						if ( ! img )
							$(op[i]).addClass('div_input_require');
					}
				}
			}
			else if(op_class.indexOf('data_table')>-1)
			{
				if(arr_view.indexOf( oaname ) > -1)
				{
					$(op[i]).addClass('readonly');
				}
			}
			else if(op_class.indexOf('easyui-textbox')>-1)
			{
				if(arr_view.indexOf( oaname ) > -1)
				{
					$(op[i]).textbox({
						readonly:true,
						require:false,
						buttonIcon:'icon-lock'
					});
				}
				else if(arr_edit.indexOf( oaname ) > -1)
				{
					if(arr_req.indexOf( oaname ) > -1 )
						required = true;
					
					$(op[i]).textbox({
						readonly:false,
						required: required,
						label: label,
						labelWidth: labelWidth,
						buttonIcon:'icon-clear',
						onClickButton:function()
						{
							$(this).textbox('clear');
						}
					});
				}

				var opt = $(op[i]).textbox('options');

				if(opt.fun_ready)
					eval(opt.fun_ready);

			}
			else if(op_class.indexOf('easyui-passwordbox')>-1)
			{
				if(arr_view.indexOf( oaname ) > -1)
				{
					$(op[i]).passwordbox({
						readonly:true,
						require:false,
						showEye:false,
						buttonIcon:'icon-lock'
					});
				}
				else if(arr_edit.indexOf( oaname ) > -1)
				{
					if(arr_req.indexOf( oaname ) > -1 )
						required = true;

					$(op[i]).passwordbox({
						readonly:false,
						required: required,
						label: label,
						labelWidth: labelWidth,
						buttonIcon:'icon-clear',
						onClickButton:function()
						{
							$(this).passwordbox('clear');
						}
					});
				}

				var opt = $(op[i]).passwordbox('options')
				if(opt.fun_ready)
					eval(opt.fun_ready);
			}
			else if(op_class.indexOf('easyui-numberbox')>-1)
			{
				if(arr_view.indexOf( oaname ) > -1)
				{
					$(op[i]).numberbox({
						readonly:true,
						require:false,
						buttonIcon:'icon-lock'
					});
				}
				else if(arr_edit.indexOf( oaname ) > -1)
				{
					if(arr_req.indexOf( oaname ) > -1 )
						required = true;

					$(op[i]).numberbox({
						readonly:false,
						required: required,
						label: label,
						labelWidth: labelWidth,
						buttonIcon:'icon-clear',
						onClickButton:function()
						{
							$(this).numberbox('clear');
						}
					});
				}

				var opt = $(op[i]).numberbox('options')
				
				if(opt.fun_ready)
					eval(opt.fun_ready);
			}
			else if(op_class.indexOf('easyui-datebox')>-1)
			{
				if(arr_view.indexOf( oaname ) > -1)
				{
					$(op[i]).datebox({
						readonly:true,
						require:false,
						hasDownArrow:false,
						buttonIcon:'icon-lock',
					});
				}
				else if(arr_edit.indexOf( oaname ) > -1)
				{
					if(arr_req.indexOf( oaname ) > -1 )
						required = true;

					$(op[i]).datebox({
						readonly:false,
						required: required,
						label: label,
						labelWidth: labelWidth,
						buttonIcon:'icon-clear',
						onClickButton:function()
						{
							$(this).datebox('clear');
						}
					});

					$(op[i]).datebox('textbox').bind('focus',
					function(){
						$(this).parent().prev().datebox('showPanel');
					});
				}

				var opt = $(op[i]).datebox('options')
				
				if(opt.fun_ready)
					eval(opt.fun_ready);
			}
			else if(op_class.indexOf('easyui-datetimebox')>-1)
			{
				if(arr_view.indexOf( oaname ) > -1)
				{
					$(op[i]).datetimebox({
						readonly:true,
						require:false,
						hasDownArrow:false,
						buttonIcon:'icon-lock',
					});
				}
				else if(arr_edit.indexOf( oaname ) > -1)
				{
					if(arr_req.indexOf( oaname ) > -1 )
						required = true;

					$(op[i]).datetimebox({
						readonly:false,
						required: required,
						label: label,
						labelWidth: labelWidth,
						buttonIcon:'icon-clear',
						onClickButton:function()
						{
							$(this).datetimebox('clear');
						}
					});

					$(op[i]).datetimebox('textbox').bind('focus',
					function(){
						$(this).parent().prev().datetimebox('showPanel');
					});
				}

				var opt = $(op[i]).datetimebox('options')
				
				if(opt.fun_ready)
					eval(opt.fun_ready);
			}
			else if(op_class.indexOf('easyui-combobox')>-1)
			{
				if(arr_view.indexOf( oaname ) > -1)
				{
					$(op[i]).combobox({
						readonly:true,
						required:false,
						hasDownArrow:false,
						buttonIcon:'icon-lock',
					});

				}
				else if(arr_edit.indexOf( oaname ) > -1)
				{
					if(arr_req.indexOf( oaname ) > -1 )
						required = true;
					
					$(op[i]).combobox({
						readonly:false,
						required: required,
						label: label,
						labelWidth: labelWidth,
						hasDownArrow:true,
						buttonIcon:'icon-clear',
						onClickButton:function()
						{
							$(this).combobox('clear');
						}
					});

					$(op[i]).combobox('textbox').bind('focus',
					function(){
						$(this).parent().prev().combobox('showPanel');
					});
				}

				var opt = $(op[i]).combobox('options');
				
				if(opt.url_l) $(op[i]).combobox('reload',opt.url_l);
				
				if(opt.fun_ready)
					eval(opt.fun_ready);
			}
			else if(op_class.indexOf('easyui-combotree')>-1)
			{
				if(arr_view.indexOf( oaname ) > -1)
				{
					$(op[i]).combotree({
						readonly:true,
						required:false,
						hasDownArrow:false,
						buttonIcon:'icon-lock',
					});

				}
				else if(arr_edit.indexOf( oaname ) > -1)
				{
					if(arr_req.indexOf( oaname ) > -1 )
						required = true;
					
					$(op[i]).combotree({
						readonly:false,
						required: required,
						label: label,
						labelWidth: labelWidth,
						hasDownArrow:true,
						buttonIcon:'icon-clear',
						onClickButton:function()
						{
							$(this).combotree('clear');
						}
					});

					$(op[i]).combotree('textbox').bind('focus',
					function(){
						$(this).parent().prev().combotree('showPanel');
					});
				}

				var opt = $(op[i]).combotree('options')
				
				if(opt.url_l) $(op[i]).combotree('reload',opt.url_l);
				
				if(opt.fun_ready)
					eval(opt.fun_ready);
			}
			else if(op_class.indexOf('easyui-combogrid')>-1)
			{
				if(arr_view.indexOf( oaname ) > -1)
				{
					$(op[i]).combogrid({
						readonly:true,
						required:false,
						hasDownArrow:false,
						buttonIcon:'icon-lock',
					});
				}
				else if(arr_edit.indexOf( oaname ) > -1)
				{
					if(arr_req.indexOf( oaname ) > -1 )
						required = true;
					
					$(op[i]).combogrid({
						readonly:false,
						required: required,
						label: label,
						labelWidth: labelWidth,
						hasDownArrow:true,
						buttonIcon:'icon-clear',
						onClickButton:function()
						{
							$(this).combogrid('clear');
						}
					});

					$(op[i]).combotree('textbox').bind('focus',
					function(){
						$(this).parent().prev().combogrid('showPanel');
					});
				}

				var opt = $(op[i]).combogrid('options')
				
				if(opt.url_l) $(op[i]).combogrid('reload',opt.url_l);
				
				if(opt.fun_ready)
					eval(opt.fun_ready);
			}
			else if(op_class.indexOf('easyui-tagbox')>-1)
			{
				var opt = $(op[i]).tagbox('options');
				var width = opt.width;
				if(width == '100%') width = $(op[i]).parent().width();
				
				if(arr_view.indexOf( oaname ) > -1)
				{
					$(op[i]).tagbox({
						readonly:true,
						required:false,
						hasDownArrow:false,
						width:width,
						buttonIcon:'icon-lock',
					});

				}
				else if(arr_edit.indexOf( oaname ) > -1)
				{
					if(arr_req.indexOf( oaname ) > -1 )
						required = true;

					width -= labelWidth;
					
					$(op[i]).tagbox({
						readonly:false,
						required: required,
						label: label,
						labelWidth: labelWidth,
						width:width,
						buttonIcon:'icon-clear',
						onClickButton:function()
						{
							$(this).tagbox('clear');
						}
					});

					$(op[i]).tagbox('textbox').bind('focus',
					function(){
						$(this).parent().prev().tagbox('showPanel');
					});
				}

				if(opt.url_l) $(op[i]).tagbox('reload',opt.url_l);

				if(opt.fun_ready)
					eval(opt.fun_ready);
			}
		}
	}

	//form表单其他控件载入数据
	function fun_form_load_data_other(form_id,data)
	{
		var op=$("#"+form_id+" .oa_input");

		for(var i=0;i<op.length;i++)
		{
			var op_name=$(op[i]).attr("oaname");
			var op_class=$(op[i]).attr("class");

			if(op[i].tagName == 'SPAN')
			{
				$(op[i]).html(data[op_name]);
			}
			else if(op_class.indexOf('easyui-progressbar')>-1)
			{
				if(data[op_name])
					$(op[i]).progressbar('setValue',data[op_name]);

				if(data[trim(op_name,']')+'_text]'])
				{
					var text = data[trim(op_name,']')+'_text]'];
					$(op[i]).find('.progressbar-text').text(text);
				}
			}
			else if(op_class.indexOf('data_table')>-1)
			{
				if(data[op_name] && data[op_name] != '')
				{
					var row_s = $(op[i]).datagrid('getSelected');
					var index_s = $(op[i]).datagrid('getRowIndex',row_s);
					if(index_s > -1)$(op[i]).datagrid('cancelEdit',index_s);
					
					$(op[i]).datagrid('loadData',{rows:JSON.parse(data[op_name])});
					
//					var opt = $(op[i]).datagrid('options');
//
//					if(opt.fun_ready)
//						eval(opt.fun_ready)
				}
			}
			else if(op_class.indexOf('upload_img')>-1)
			{
				var img=$(op[i]).next().attr('value');
				if(img)
				{
					$(op[i]).html('<img style="height:100%;width:100%;" src="'+img+'"/>');
					$(op[i]).removeClass('div_input_require');
				}
			}
			else if(op_class.indexOf('easyui-tagbox')>-1)
			{
				if(data[trim(op_name,']')+'_data]'] && data[trim(op_name,']')+'_data]'] != '')
					$(op[i]).tagbox('loadData',JSON.parse(data[trim(op_name,']')+'_data]']));
				
			}
			else if(op_class.indexOf('easyui-switchbutton')>-1)
			{
				var check=false;
				if(data[op_name] > 0 || data['content['+op_name+']'] > 0)
				check=true;	
				
				$(op[i]).switchbutton({
					checked:check
				});
			}
		}
	}
	
	//索引查询初始化
	function load_table_search(table_id,field_search_value_dispaly,field_search_rule,field_search_start,field_search_rule_default,conf_search)
	{
		//个性化配置
		var field_search_value={};
		
		var data_start='';
		var field_sort_rule=new Array();
		var json_field_rule={};
		for(var i=0;i<field_search_rule.length;i++)
		{
			json_field_rule[field_search_rule[i].id]=field_search_rule[i].rule;

			field_sort_rule.push(field_search_rule[i].id);
		}

		if(conf_search)
		{
			var conf_search=JSON.parse(base64_decode(conf_search));
			
			for(var i=0;i<conf_search.length;i++)
			{
				var rule=json_field_rule[conf_search[i].field]
				rule.value=conf_search[i].value;
				rule.value_s=conf_search[i].value_s;

				data_start+=JSON.stringify(rule)+',';
			}
		}
		else
		{
			for(var i=0;i<field_search_start.length;i++)
			{
				data_start+=JSON.stringify(json_field_rule[field_search_start[i]])+',';
			}
		}
		
		data_start=JSON.parse('['+trim(data_start,',')+']');
		
		var columns_search = [[
		          		{field:'field',title:'字段',halign:'center',width:100,sortable:true,
	          			 sorter:function(a,b){  
		    				a = field_sort_rule.indexOf(a);
		    				b = field_sort_rule.indexOf(b);
	    					return (a>b?1:-1);  
		    			 },
		          		 editor:{type:'combobox',
			           	     options:{
				    			valueField:'id',    
				    		    textField:'text',
				    		    limitToList:true,
				    		    panelHeight:'auto',
				    		    panelMaxHeight:200,
				    		    panelWidth:'150',
				    		    required : true,
				    		    data : field_search_rule,
				    		    onLoadSuccess : function(){
		    				 	$(this).parent().prev().combobox('showPanel');
		    			 		},
				    		    onSelect : function(record){
			    		    		if($(this).combobox('getValue'))
			    		    		{
			    		    			$('#'+table_id).propertygrid('endEdit');
				    		    		setTimeout(function(){

				    		    			var r=$('#'+table_id).datagrid('getSelected');
											var i=$('#'+table_id).datagrid('getRowIndex',r);

											if( ! record.rule.field_r )
												record.rule.field_r = '';
											
											record.rule.value_s='';

											if( ! record.rule.m_link )record.rule.m_link = '';
											if( ! record.rule.field_r ) record.rule.field_r = '';
											if( ! record.rule.m_link_content ) record.rule.m_link_content = '';
											
				    		    			$('#'+table_id).propertygrid('updateRow',{
												index: i,
												row: record.rule
				    		    			});
	
				    		    			$('#'+table_id).propertygrid('editCell', {
				    		    				index: i,
				    		    				field: 'field'
				    		    			});
				    		    			
				    		    			$('#'+table_id).propertygrid('selectRow',i);
				    		    			
					    		    	},100)
			    		    		}
				          		}
	          				}
	          			 },
		          		 formatter: function(value,row,index){	
							return row.field_s;
					   	 }
			          	},
		         		{field:'value',title:'值',halign:'center',width:200,
			          	 formatter: function(value,row,index){	

			          		if(row.value && row.value_s)
			          	    	return row.value_s;
		          	    	
				          	if( value && field_search_value_dispaly[row.field] )
				          	{
					          	var value_s='';
					          	for(var i=0;i<value.split(',').length;i++)
					          	{
					          		value_s+=field_search_value_dispaly[row.field][value.split(',')[i]]+',';
					          	}
								return trim(value_s,',');
				          	}
				          	
							return value;
					   	 }
				        }
		              ]];

		//数据库字段表
		$('#'+table_id).propertygrid({    
			fit:true,
			border:false,
			toolbar:'#'+table_id+'_tool',
			showGroup: false,
			scrollbarSize: 0,
			columns: columns_search,
			data:data_start,
			onSelect: function(index, row)
			{
				//回车查询绑定
				var ed=$('#'+table_id).propertygrid('getEditor',{index:index,field:'value'});

				if( ! ed )
				return;
				
				//属性表格控件初始化
				fun_start_propertygrid_ed(this,ed,row);
			},
			onEndEdit: function(index, row, changes)
			{
				var ed_v=$(this).datagrid('getEditor', {index:index,field:'value'});

				if(ed_v.type == 'numberbox')
					row.value_s = $(ed_v.target).numberbox('getText');

				if(row.fun_end)
					eval(row.fun_end)
			},
			onRowContextMenu: function(e, index, row)
			{
				e.preventDefault();
				$('#'+table_id).propertygrid('selectRow',index);

				$('#menu_'+table_id).menu({    
				    onClick: function(item){ 
				      
						if(item.name=='add')
							$('#'+table_id).propertygrid('appendRow',field_search_rule_default);
						else if(item.name=='del')
						{
							var rows = $('#'+table_id).propertygrid('getRows');
							if(rows.length > 1)
							$('#'+table_id).propertygrid('deleteRow',index);
						}
				    }
				}); 

				if( index > -1 )
				menu_show('menu_'+table_id,e);			
			}
		});  
	}

	//属性表格控件初始化
	function fun_start_propertygrid_ed(op,ed,row)
	{
		var id = $(op).attr('id')
		var height_op = $('#'+id).parent().height();
		
		if(row.editor == 'text' || row.editor.type == 'textbox' || row.editor == 'textbox')
		{
			$(ed.target).textbox({
				height:24,
				width:'100%',
				buttonIcon:'icon-clear',
				onClickButton:function()
				{
					$(this).textbox('clear');
				}
			});

			var opt=$(ed.target).textbox('options');

			if(opt.start_fun)
			{
				eval(opt.start_fun)
				return;
			}

			$(ed.target).textbox('textbox').focus();
			
			$(ed.target).textbox('textbox').bind('keydown', function(e){
				if (e.keyCode == 13){	// 当按下回车键时查询
					eval('fun_'+op.id+'()');
				}
			});
		}
		else if(row.editor == 'datetimebox' || row.editor.type == 'datetimebox')
		{
			$(ed.target).datetimebox('showPanel');
			$(ed.target).datetimebox({
				width:'100%',
				value:row.value,
				buttonIcon:'icon-clear',
				onClickButton:function()
				{
					$(this).datetimebox('clear');
				}
			});

			var opt=$(ed.target).datetimebox('options');
			
			if(opt.start_fun)
			{
				eval(opt.start_fun)
				return;
			}

			$(ed.target).datetimebox('textbox').focus();
			
			$(ed.target).datetimebox('textbox').bind('keydown', function(e){
				if (e.keyCode == 13){	// 当按下回车键时查询
					eval('fun_'+op.id+'()');
				}
			});
		}
		else if(row.editor == 'datebox' || row.editor.type == 'datebox')
		{
			$(ed.target).datebox('showPanel');
			$(ed.target).datebox({
				width:'100%',
				value:row.value,
				buttonIcon:'icon-clear',
				onClickButton:function()
				{
					$(this).datebox('clear');
				}
			});
			
			var opt=$(ed.target).datebox('options');
			
			if(opt.start_fun)
			{
				eval(opt.start_fun)
				return;
			}

			$(ed.target).datebox('textbox').focus();
			
			$(ed.target).datebox('textbox').bind('keydown', function(e){
				if (e.keyCode == 13){	// 当按下回车键时查询
					eval('fun_'+op.id+'()');
				}
			});
		}
		else if(row.editor.type == 'combobox')
		{
			$(ed.target).combobox({
				value:row.value,
				buttonIcon:'icon-clear',
				onClickButton:function()
				{
					$(this).combobox('clear');
				}
			});

			$(ed.target).combobox('showPanel');

			var opt=$(ed.target).combobox('options');

			if(opt.url_l) $(ed.target).combobox('reload',opt.url_l);
			
			if(opt.start_fun)
			{
				eval(opt.start_fun)
				return;
			}
			
			$(ed.target).combobox('textbox').focus();
			
			$(ed.target).combobox('textbox').bind('keydown', function(e){
				if (e.keyCode == 13){	// 当按下回车键时查询
					eval('fun_'+op.id+'()');
				}
			});
		}
		else if(row.editor.type == 'combotree')
		{
			$(ed.target).combotree({
				value:row.value,
				buttonIcon:'icon-clear',
				onClickButton:function()
				{
					$(this).combotree('clear');
				}
			});

			$(ed.target).combotree('showPanel');

			var opt=$(ed.target).combotree('options');

			if(opt.url_l) $(ed.target).combotree('reload',opt.url_l);
			
			if(opt.start_fun)
			{
				eval(opt.start_fun)
				return;
			}
			
			$(ed.target).combotree('textbox').focus();
			
			$(ed.target).combotree('textbox').bind('keydown', function(e){
				if (e.keyCode == 13){	// 当按下回车键时查询
					eval('fun_'+op.id+'()');
				}
			});
		}
		else if(row.editor.type == 'numberbox')
		{
			$(ed.target).numberbox({
				value:row.value,
				buttonIcon:'icon-clear',
				onClickButton:function()
				{
					$(this).numberbox('clear');
				}
			});

			var opt=$(ed.target).numberbox('options');
			
			if(opt.start_fun)
			{
				eval(opt.start_fun)
				return;
			}

			$(ed.target).numberbox('textbox').focus();
			
			$(ed.target).numberbox('textbox').bind('keydown', function(e){
				if (e.keyCode == 13){	// 当按下回车键时查询
					eval('fun_'+op.id+'()');
				}
			});
		}
	}

	//创建条件个性化
	function fun_person_create(op,url)
	{
		var data=fun_get_data_from_f($(op).attr('id'));
		
		 //保存配置
		$.ajax({
	        url:"base/fun/conf_person_create.html",
	        type:"POST",
	        async:false,
	        data:{data: base64_encode(JSON.stringify(data)),
			url:url
	        },
	        success:function(data){
	        	layer.msg('个性化已记录！', {
				  icon: 1,
				  time: 1500 
				});
			}
	    });
	}

	//查询条件个性化
	function fun_person_search(op,url)
	{
		var rows=$(op).propertygrid('getRows');
		var search=[];

		for(var i=0;i<rows.length;i++)
		{
			var json={'field' : rows[i].field ,'value':  rows[i].value ,'value_s':  rows[i].value_s}

			search.push(json);
		}
		
		 //保存配置
		$.ajax({
	        url:"base/fun/conf_person_search.html",
	        type:"POST",
	        async:false,
	        data:{search: base64_encode(JSON.stringify(search)),
			url:url
	        },
	        success:function(data){
	        	layer.msg('个性化已记录！', {
				  icon: 1,
				  time: 1500 
				});   
			}
	    });
	}

	//索引列个性化,导出调整
	function fun_person_index_search(op,url,op_search)
	{
		if($('#win_person_index_search').length == 0)
		$('#p_main').append('<div id="win_person_index_search"><div id="table_person_index_search_tool"></div><table id="table_person_index_search"></table></div>');
			
		if($('#menu_table_person_index_search').length == 0)
		{
			$('#win_person_index_search').append('<div id="menu_table_person_index_search"></div>');

			$("#menu_table_person_index_search").menu();

			$('#menu_table_person_index_search').menu('appendItem', {
				text: '冻结',
				name:'frozen'
			});

			$('#menu_table_person_index_search').menu('appendItem', {
				text: '隐藏',
				name:'hide'
			});		

			$('#table_person_index_search_tool').html('<input id="txtb_table_person_index_search_hide"/> <label class="checkbox-pretty inline "><span>无分页</span><input id="txtb_table_person_no_page" type="checkbox" value="1"></label>')

			$('#txtb_table_person_index_search_hide').tagbox({
			    label: '隐藏列:',
			    labelPosition:'before',
			    width:'600',
			    valueField:'id',    
			    textField:'text', 
			    editable:false,
			    panelHeight:0,
			    onRemoveTag: function(value)
			    {
					$('#table_person_index_search').datagrid('showColumn',value)
			    }
			});
		}

		if($(op).attr("no_page") == 1)
			$('#txtb_table_person_no_page').parent().addClass('checked') 

		$('#txtb_table_person_index_search_hide').tagbox('clear');

		$('#txtb_table_person_no_page').parent().show();

		var title_show='索引列表个性化';
		var toolbar='';
		
		//导出
		if(op_search)
		{
			var title_show='xlsx导出设置';
			
			//查询条件
			$(op_search).propertygrid('sort', 
				{
				 sortName: 'field',
				 sortOrder: 'asc'
				}
			);    
			var data_search=$(op_search).propertygrid('getRows');
			data_search=JSON.stringify(data_search);

			$('#txtb_table_person_no_page').parent().hide();

			toolbar=[{
				iconCls:'icon-xlsx',
				text:'导出全部列',
				handler:function(){
					fun_xlsx_export_start('all',data_search)
				}
			},{
				iconCls:'icon-xlsx',
				text:'导出当前列',
				handler:function(){
					fun_xlsx_export_start('now',data_search)
				}
			}]
		}
		
		$('#win_person_index_search').dialog({  
			title: title_show,
			width:800,    
		    height:300,
		    border:'thin',
			resizable:false,  
			minimizable:false,
			maximizable:false,
			iconCls:'icon-man',
		    modal:true,
		    inline:true,
		    toolbar: toolbar,
		    onClose: function()
		    {
				if(op_search) return;
				
				var opt=$('#table_person_index_search').datagrid('options');

				$(op).attr('no_load',1);
				
				$(op).datagrid({
					columns: opt.columns,
					frozenColumns: opt.frozenColumns,
				 });

				$(op).datagrid('sort', {	    
					sortName: opt.sort,
					sortOrder: opt.order
				});

				$(op).attr('no_load',0);
				
				var no_page= 0 ;
				if( $('#txtb_table_person_no_page').parent().hasClass('checked') )
				{
					no_page=1;
					$(op).attr("no_page",1)

					$(op).datagrid({
						view: bufferview,
						pagination:false,
					})
				}
				else
				{
					$(op).attr("no_page",0)
					
					$(op).datagrid({
						pagination:true,
					})
					
					var p=$(op).datagrid('getPager'); 
					$(p).pagination({ 
						layout:['list','manual','first','prev','links','next','last'],
						afterPageText:'页，共{pages}页，'
					});  
				}
				
				 //保存配置
				$.ajax({
			        url:"base/fun/conf_person_index.html",
			        type:"POST",
			        async:false,
			        data:{columns: base64_encode(JSON.stringify(opt.columns)),
					frozenColumns: base64_encode(JSON.stringify(opt.frozenColumns)),
					sort: opt.sort,
					order: opt.order,
					no_page: no_page,
					url:url
			        },
			        success:function(data){
			        	layer.msg('个性化已记录！', {
						  icon: 1,
						  time: 1500 
						}); 
					}
			    });
				 
		    }
		});

		var opt=$(op).datagrid('options');

		var col=opt.columns[0];

		var data_taf=[];
		var field_hide=[];
		for(var i=0;i<col.length;i++)
		{
			if(col[i].hidden)
			{
				var json_field={"id":col[i].field,"text":col[i].title};
				data_taf.push(json_field)
				field_hide.push(col[i].field);
			}
		}
		
		$('#txtb_table_person_index_search_hide').tagbox('loadData',data_taf)
		$('#txtb_table_person_index_search_hide').tagbox('setValues',field_hide)
		
		var data=$(op).datagrid('getData');

		$('#table_person_index_search').datagrid({
			fit:true,
			singleSelect:true,
			striped:true,
			border:false,
			toolbar:"#table_person_index_search_tool",
			columns: opt.columns,
			frozenColumns: opt.frozenColumns,
			data:data,
			url_export: opt.url,
			bt_title: opt.title,
			pagination:false,
			onSortColumn: function(sort, order)
			{
				var opt=$('#table_person_index_search').datagrid('options');
				opt.sort=sort;
				opt.order=order;
				$('#table_person_index_search').datagrid(opt);
			},
			onHeaderContextMenu: function(e, field)
			{
				var opt_col=$('#table_person_index_search').datagrid('getColumnOption',field);
				if(opt_col.checkbox == true)
					return;
				
				$('#menu_table_person_index_search').menu({
					onClick :function(item)
					{
						switch(item.name)
						{
							case 'frozen':
								$('#table_person_index_search').datagrid('freezeColumn',field)
								break;
								
							case 'hide':

								$('#table_person_index_search').datagrid('unfreezeColumn',field)
								
								$('#table_person_index_search').datagrid('hideColumn',field)
								
								var data_taf=$('#txtb_table_person_index_search_hide').tagbox('getData')
								
								var opt_field=$('#table_person_index_search').datagrid('getColumnOption',field);
								
								var json_field={"id":field,"text":opt_field.title};
								data_taf.push(json_field)
								$('#txtb_table_person_index_search_hide').tagbox('loadData',data_taf)
								
								var field_hide=$('#txtb_table_person_index_search_hide').tagbox('getValues')
								field_hide.push(field);
								$('#txtb_table_person_index_search_hide').tagbox('setValues',field_hide)
								break;

						}

						$('#table_person_index_search').datagrid('columnMoving');
					}
				})

				menu_show('menu_table_person_index_search',e)
			}
		})
		
		if(opt.sort)
			$('#table_person_index_search').datagrid('sort', {	    
				sortName: opt.sort,
				sortOrder: opt.order
			});
		
		$('#table_person_index_search').datagrid('columnMoving');
	}

	//开始导出
	//type: 导出类型 all,now
	//op_search: 查询条件
	function fun_xlsx_export_start(type,data_search)
	{
		var opt=$('#table_person_index_search').datagrid('options');

		var bt_name = opt.bt_title+'-导出';
		var bt_param={};
		
		bt_param.data_search=data_search;
		bt_param.title = opt.bt_title;
		bt_param.sort=opt.sort;
		bt_param.order=opt.order;
		bt_param.url=opt.url_export;
		
		var col=[];

		for(var i=0;i<opt.frozenColumns[0].length;i++)
		{
			if( opt.frozenColumns[0][i].checkbox == true)
				continue;

			
			if( type == 'now' 
			 && opt.frozenColumns[0][i].hidden == true)
			continue;

			var op_col={}

			op_col.field=opt.frozenColumns[0][i].field;
			op_col.title=opt.frozenColumns[0][i].title;
			op_col.align=opt.frozenColumns[0][i].align;
			op_col.width=opt.frozenColumns[0][i].width;
			
			col.push(op_col)
		}
		
		for(var i=0;i<opt.columns[0].length;i++)
		{
			if( type == 'now' 
			 && opt.columns[0][i].hidden == true)
			continue;

			var op_col={}
			
			op_col.field=opt.columns[0][i].field;
			op_col.title=opt.columns[0][i].title;
			op_col.align=opt.columns[0][i].align;
			op_col.width=opt.columns[0][i].width;

			col.push(op_col);
		}

		bt_param.col=col;
		
		var op_id='tmp_'+get_guid();
		$('#div_back_task').append('<div id="'+op_id+'" bt_param="'+base64_encode(JSON.stringify(bt_param))+'"></div>');

		$('#'+op_id).panel({
			href:'app/run_back/base/fun/fun_xlsx_export/id/'+op_id+'.html',
			method:'POST',
			queryParams:{
				bt_param: bt_param
			}
		})
		
	}

	//xlsx导入
	function fun_xlsx_import(file,title,url_import)
	{
		//导入窗口
		if($('#win_xlsx_import').length == 0)
		$('#p_main').append('<div id="win_xlsx_import" style="overflow:hidden;"></div>');

		//载入上传控件
		var op_id=get_guid();
		var type_task='';

		$('#win_xlsx_import').dialog({  
			title:title+' 导入',
			width:500,    
		    height:300,
		    border:'thin',
			resizable:false,  
			minimizable:false,
			maximizable:false,
			iconCls:'icon-xlsx',
		    modal:true,
		    inline:true,
		    toolbar:[{
				text:'下载【'+title+'】导入模板',
				iconCls:'icon-download',
				handler:function(){
		    		fun_file_download(file,'【'+title+'】导入模板.xlsx','import')
				}
			}],
			onOpen: function()
		    {
		    
		    },
		    onClose: function()
		    {
    			eval('fun_disable_'+op_id+'();');
    			
		    	var file_num=0;
				eval('file_num=file_num'+op_id);

				if(file_num == 0 )
					eval('stream'+op_id+'.destroy();');
				
				$('#win_xlsx_import').dialog('destroy');
				$('#win_xlsx_import').remove();
		    }
		});

		$('#win_xlsx_import').html('<div style="width:100%;height:100%;background: #E6EEF8;padding-top:50px;font-size:16px;"><center><i>请将文件移入此区域<br/>或点击<a href="javascript:void(0)" id="btn_upload_'+op_id+'">此处</a>选择文件</i></center></div>')

		$('#p_main').append('<div id="up_'+op_id+'"></div>');

		$('#up_'+op_id).panel({   
			fit:true,
			href:'base/fun/win_upload/type/import/op_id/'+op_id,
			method:'POST',
			queryParams:{
				title: title,
				url_import: url_import,
				file: file,
			}
		});

	}

	//系统消息窗口
	function fun_win_sys_msg(title,msg)
	{
		var op_id='win_'+get_guid();
		$('#p_main').append('<div id="'+op_id+'" style="max-height:300px;"></div>');

		$('#'+op_id).window({
			title:title,
			content:msg,
			width:500,
			height:'auto',
			border:'thin',
			minimizable: false,
			maximizable: false,
			draggable: false,
			resizable: false,
			onClose: function()
			{
				$('#'+op_id).window('destroy');
				$('#'+op_id).remove();
			}
		})
	}

	//获取新窗口
	function fun_get_new_win()
	{
		var win_id='op_'+get_guid();

		var width = 1000;
		if(body_width < width )
		width=body_width-50;

		var height = 650;
		if(body_height - 150 < height )
		height=body_height - 200;

		$('#p_main').append('<div id="'+win_id+'" class="op_window" style="height:'+height+'px;width:'+width+'px;"></div>');

//		$('#'+win_id).window({
//			tools:[{
//				iconCls:'icon-clear',
//				handler:function(){
//					$('.op_window').window('close');
//				}
//			}]
//		});
		
		return win_id;
	}

	//加载标题
	function fun_load_title(title_conf)
	{
		switch(title_conf.fun_open)
		{
			case 'winopen':
			case '':
				if(title_conf.title)
				document.title =title_conf.title ;
			
			break;
			case 'tab':
			
			break;
			case 'win':

				if(title_conf.type == 'edit')
				{
					$('#'+title_conf.fun_open_id).window();
		
					$('#'+title_conf.fun_open_id).window('setTitle',title_conf.title);
					
					$('#'+title_conf.fun_open_id).window('open');
					$('#'+title_conf.fun_open_id).window('center');
				}
			
			break;
		}
	}

	//图片截取
	function fun_photoclip(op,size)
	{
		//图片截取
		if($('#win_photoclip').length == 0)
		$('#p_main').append('<div id="win_photoclip"></div>');

		var img_w=$(op).width();
		var img_h=$(op).height();
		
		$('#win_photoclip').dialog({  
			title:'图片上传',
			href:'base/fun/load_win_photoclip',
			width:400,    
		    height:400,
		    border:'thin',
			resizable:false,  
			minimizable:false,
			maximizable:false,
			iconCls:'icon-img',
		    modal:true,
		    inline:true,
		    toolbar:[{
				text:'选择图片',
				iconCls:'icon-img',
				handler:function(){
					$('#btn_img_check').click();
				}
			},{
				text:'保存图片',
				iconCls:'icon-save',
				handler:function(){
					$('#btn_img_cut').click();
	
			    	var img= $("#img_view").css("background-image");
			    	
					if(img != 'none')
					{
				    	img=img.substring(5,img.length-2);
				    	$(op).html('<img style="height:100%;width:100%;" src="'+img+'"/>')
						$(op).next().attr('value',img);

				    	$(op).removeClass('div_require')
					}

					$('#win_photoclip').dialog('close');
				}
			}],
			method:'post',
			queryParams:{
			img_w: img_w,
			img_h: img_h,
			size: size
			},
		    onClose: function()
		    {
		    	$(this).dialog('destroy');
		    	$('#win_photoclip').remove();
		    }
		});
	}

	//移交
	function fun_yj(time)
	{
		var win_id=fun_get_new_win();
		
		$('#'+win_id).window({
			title: '请选择移交人-单击行选择移交人',
			inline:true,
			modal:true,
//			closed:true,
			border:'thin',
			draggable:false,
			resizable:false,
			collapsible:false,  
			minimizable:true,
			maximizable:true,
			onMaximize: function()
			{
				$(this).window('close');
				$(this).window('clear');
			},
			onMinimize: function()
			{
				$(this).window('close');
				$(this).window('clear');
			},
			onClose: function()
			{
				$('#'+win_id).window('destroy');
				$('#'+win_id).remove();
			}
		})
		
		$('#'+win_id).attr('time',time);
		$('#'+win_id).window('refresh','proc_contact/contact/index/fun_open/window/fun_open_id/'+win_id+'/flag_select/2/fun_select/fun_get_yj');
		$('#'+win_id).window('center');
	}

	function fun_get_yj(op)
	{
		var row_c=$(op).datagrid('getChecked');
		 
		if( row_c.length == 0) 
		{
			$.messager.show({
		    	title:'警告',
		    	msg:'请选择移交人！',
		    	timeout:1500,
		    	showType:'show',
		    	border:'thin',
                style:{
                    right:'',
                    bottom:'',
                }
		    });
			return;
		}

		var yj = row_c[0];
		
		$.messager.confirm('确认', '您确认想要移交工单给<BR/>【'+base64_decode(yj['c_name'])+'['+base64_decode(yj['c_login_id'])+']】吗?', function(r){
			if (r){

				var time = $(op).closest('.op_window').attr('time');
				$(op).closest('.op_window').window('close');

				$('#person_yj'+time).val(base64_decode(yj.c_id));
				$('#person_yj_s'+time).val(base64_decode(yj.c_name)+'['+base64_decode(yj.c_login_id)+']');
				
				eval('f_submit_'+time+"('yj')");
			}
		});
	}

</script>