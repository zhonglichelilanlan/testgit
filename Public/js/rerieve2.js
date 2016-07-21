/**
*找回密码第二步
*/
var SUMITNEWPWD = "re_pwd_three_sub";


$(function(){
	$("#registerForm").validate({
		rules:{
			password:{
				isPWD:true,
				required:true
			},
			confirm_password:{
				equalTo:"#password"
			}   
		}
		,errorPlacement: errorAction
		,success: successAction
	}); 
});

function submitForm(){
	if($("#registerForm").valid()) {
		$.post(SUMITNEWPWD,{password:$("#password").val(),confirm_password:$("#confirm_password").val(),mobile:$("#mobile").val(),ts:new Date().getTime()},function(json){
			json = eval("("+json+")");
			if(json.code == 1){
				location.href = json.data;
			}else{
				showErrorMsg(json.data,'password_msg');
			}
		});
	}
}