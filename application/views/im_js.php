<!-- 加载jquery -->
<script type="text/javascript">
document.write("<scr"+"ipt src=\"inc/js/workerman/swfobject.js\"></sc"+"ript>");
document.write("<scr"+"ipt src=\"inc/js/workerman/web_socket.js\"></sc"+"ript>");
</script>

<script type="text/javascript">
if (typeof console == "undefined") {    this.console = { log: function (msg) {  } };}
// 如果浏览器不支持websocket，会使用这个flash自动模拟websocket协议，此过程对开发者透明
WEB_SOCKET_SWF_LOCATION = "/swf/WebSocketMain.swf";
// 开启flash的websocket debug
WEB_SOCKET_DEBUG = true;

var ws;
var self_im = this;

//连接服务端
connect();

function connect() {
 // 创建websocket
// ws = new WebSocket("wss://"+document.domain+":7272");
 ws = new WebSocket("ws://"+document.domain+":7272");
 // 当socket连接打开时，输入用户名
 ws.onopen = onopen;
 // 当有消息时根据消息类型显示不同信息
 ws.onmessage = onmessage; 
 ws.onclose = function() {
//	  console.log("连接关闭，定时重连");
   setTimeout('connect()',5000)
 };
 ws.onerror = function() {
//	  console.log("出现错误");
	 ws = '';
 };
}

//连接建立时发送登录信息
function onopen()
{
  // 登录
  var login_data = '{"type":"login","client_name":"<?=$this->sess->userdata('c_id')?>","client_img":"<?=$this->sess->userdata('c_img')?>","client_name_show":"<?=$this->sess->userdata('c_name').'['.$this->sess->userdata('a_login_id').']'?>","room_id":"<?=$this->sess->userdata('c_id')?>","ip":"<?=get_ip();?>","browser":"<?=fun_urlencode($this->ua->browser());?>","app":""}';
  //  console.log("websocket握手成功，发送登录数据:"+login_data);
  ws.send(login_data);
}

//服务端发来消息时
function onmessage(e)
{
//  console.log(e.data);
  var data = eval("("+e.data+")");
  switch(data['type']){
  
      // 服务端ping客户端
      case 'ping':
          ws.send('{"type":"pong"}');
          break;;
      // 登录 更新用户列表
      case 'login':

    	  //是否当前登陆人登陆返回信息
          if( data['client_name'] == '<?=$this->sess->userdata('c_id')?>')
          {
        	  if( ! client_id )
          		client_id = data['client_id'];

        	  if($.cookie('client_id') == null )
        		$.cookie('client_id',client_id)
          }
        	  
          break;
      // 发言
      case 'say':

    	  if(client_id == data['from_client_id'])
              return;

          if( ! data['content'] )
              return;

          var json = JSON.parse(base64_decode(data['content']));

          switch(json.fun)
          {
          	case 'wl_to_do'://待办事项

          		if( $('.table_wlist_to_do').length > 0 )
          			$('.table_wlist_to_do').datagrid('reload');
      			
              	break;

          	case 'wl_end'://已结事项

          		if( $('.table_wlist_end').length > 0 )
          			$('.table_wlist_end').datagrid('reload');
      			
              	break;
              	
          	case 'wl_i'://我的请求

          		if( $('.table_wlist_i').length > 0 )
          			$('.table_wlist_i').datagrid('reload');
      			
              	break;
              	
          	case 'wl_care'://我的关注

          		if( $('.table_wlist_care').length > 0 )
          			$('.table_wlist_care').datagrid('reload');
      			
              	break;
          }

    	  break;
      // 用户退出 更新用户列表
      case 'logout':

      	if($.cookie('client_id') == data['from_client_id'])
      	{
      		$.cookie( 'client_id', null )
      	}
  }
}

//发送消息
function fun_im_say(str)
{
	if(ws)
	ws.send(str);
}

//打开工单im
function fun_im_wl(op_id,pp_id)
{
	
}

//发送工单
function fun_send_wl(rtn)
{
	//我的请求
	if(rtn.wl_i && rtn.wl_i.length > 0)
	{
		var to_room=rtn.wl_i.join(',');
		var json = { fun: 'wl_i' };
	
		var str='{"type":"say","to_room":"'+to_room+'","content":"'+base64_encode(JSON.stringify(json))+'"}';
	    fun_im_say(str);
	}

  	//待办事项
	if(rtn.wl_accept && rtn.wl_accept.length > 0)
	{
		var to_room=rtn.wl_accept.join(',');
		var json = { fun: 'wl_to_do' };

		var str='{"type":"say","to_room":"'+to_room+'","content":"'+base64_encode(JSON.stringify(json))+'"}';
	    fun_im_say(str);
	}

	//我的关注
	if(rtn.wl_care && rtn.wl_care.length > 0)
	{
		var to_room=rtn.wl_care.join(',');
		var json = { fun: 'wl_care' };

		if( to_room.indexOf('<?=$this->sess->userdata('c_id');?>') > -1 
		 && $('.table_wlist_care').length > 0 )
		{
   			$('.table_wlist_care').datagrid('reload');
		}
		
		var str='{"type":"say","to_room":"'+to_room+'","content":"'+base64_encode(JSON.stringify(json))+'"}';
	    fun_im_say(str);
	}

	//已结事项
	if(rtn.wl_end && rtn.wl_end.length > 0)
	{
		var to_room=rtn.wl_end.join(',');

		if( to_room.indexOf('<?=$this->sess->userdata('c_id');?>') > -1 
		 && $('.table_wlist_i').length > 0 )
		{
   			$('.table_wlist_i').datagrid('reload');
   			$('.table_wlist_end').datagrid('reload');
		}
		
		var json = { fun: 'wl_end' };
	
		var str='{"type":"say","to_room":"'+to_room+'","content":"'+base64_encode(JSON.stringify(json))+'"}';
	    fun_im_say(str);
	}
	
}
</script>