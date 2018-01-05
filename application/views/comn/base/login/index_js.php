<!-- 加载jquery -->
<script type="text/javascript">

//初始化
$(document).ready(function(){

	//加载登陆面板
	layer.open({
	  type: 1,
	  title:'登陆',
	  closeBtn:0,
	  move:'',
	  zIndex:1, 
	  area: ['350px', '520px'],
	  content:'<div id="div_login"></div>'
	});	


	$('#div_login').panel({   
		fit:true,
		border:false,
		content:$('#f_login') 
	});  

	fun_form_focus('f_login');

	//加载验证码
	fun_load_YZM();

	//每隔1分钟变化一次验证码
	setInterval("fun_load_YZM_for_time();",1200);

	//回车事件
	document.onkeydown = function(event_e){   
		if(window.event)    
        event_e = window.event;    
        var int_keycode = event_e.charCode||event_e.keyCode;    
        if(int_keycode ==13){   
        	fun_f_login_submit('login');  
        }  
	}


	$('.textbox-button').attr('tabindex','-1');
});


//加载验证码
var yzm;
var yzm_time;
function fun_load_YZM(){

	//取消验证码时间提示tab锁定
	//$("#sp_yzm_time").parent().parent().parent().attr('tabindex','-1');
	
	$.ajax({
      type:"GET",
      async:false,
      url:"index.php/app/yzm.html",
      success:function(data){
			var json=JSON.parse(data);
	    	
	    	$('#css_yzm').html(".icon-yzm{background: url('<?=base_url()?>/inc/img/yzm/"+json.filename+"')  no-repeat center center;}");

	    	$('#sp_yzm_time').text('99s');
	    	
	    	yzm=json.word;
	    	$('#hd_yzm_time').val(99);

	    	yzm_time=json.time;

	    	$('#txtb_yzm').textbox('clear');
      }
  });
}

//计算有效时间，加载验证码
function  fun_load_YZM_for_time(){

	var yzm_time=parseInt($('#hd_yzm_time').val());

	yzm_time-=1;
	
	if(!yzm_time){
		 fun_load_YZM();
	}else {
		$('#hd_yzm_time').val(yzm_time);
		
		if(yzm_time<10) yzm_time='0'+yzm_time;

		$('#sp_yzm_time').text(yzm_time+'s');
		
	}
}


//提交
function fun_f_login_submit(btn){

	$("#hd_err_f_login").val('');
	
	$('#f_login').form('submit',{
		url:'base/login/index.html',
		onSubmit:function(param){

			var check= $(this).form('enableValidation').form('validate');

			var login_yzm=$('#txtb_yzm').textbox('getText');

			if(login_yzm && login_yzm!=yzm)
			{
				$("#hd_err_f_login").val(1);

				$('#txtb_yzm').attr('err-msg','验证码错误!')
				
				check=false;
			}
			
			if(check)
			{
				param.btn=btn;
				param['data[login_yzm_time]']=yzm_time;
			}
			else
			{
				$(this).form('enableValidation').form('validate');
				
				//加载验证码
				fun_load_YZM();
				
				return false;
			}

		},
		success: function(data){

			var json={};
			if(data) json=JSON.parse( data );
			
			if( ! json.result)
			{
				$("#hd_err_f_login").val(1);

				//遍历form 错误消息添加
				fun_show_errmsg_of_form('f_login',json.err);

				$(this).form('enableValidation').form('validate');
				
				//加载验证码
				fun_load_YZM();

				//其他错误
				if(json.sys_msg)
				layer.msg(json.sys_msg, {
				  icon: 2,
				  time: 3000 
				});   
			}
			else
			{
				//系统信息
				layer.msg('登陆成功！', {
				  icon: 1,
				  time: 1500 
				}, function(){
					location.reload(); 
				});   
			}
		}
	});
}
</script>