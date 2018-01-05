<!-- 加载jquery -->
<script type="text/javascript">
//根据身份证获取生日
function getBirthFromIdCard(idCard) {  
    var birthday = "";  
    if(idCard != null && idCard != ""){  
        if(idCard.length == 15){  
            birthday = "19"+idCard.substr(6,6);  
        } else if(idCard.length == 18){  
            birthday = idCard.substr(6,8);  
        }  
      
        birthday = birthday.replace(/(.{4})(.{2})/,"$1-$2-");  
    }  
      
    return birthday;  
  }  

//号码信息
function fun_get_code_info(url,code)
{

	if( ! code ) return ;
	
	var info='';
	 //保存配置
	$.ajax({
        url:url,
        type:"POST",
        async:false,
        data:{code: code},
        success:function(data){
        	info=data;
        }
	});
	return info;
}

</script>