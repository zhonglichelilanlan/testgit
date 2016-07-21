/**
 * 找回密码引入JS
 */
//  成功调用返回{code:1}
var URL4SENDMSG = "re_pwd_send";//发送验证码的接口地址
var URL4CHECKMOBILE = "re_pwd_one";//仅验证手机号码 不发送短信的接口地址,验证手机号码是否已经注册
var SUBMITFORM = "re_pwd_sub";//注册 表单提交的地址

$(function(){
	$("#registerForm").validate({
		rules:{
			mobile:{
				isMobile:true,
				required:true
			},
			verifyCode:{
				isVerCode:true,
				required:true
			}
		}
		,errorPlacement: errorAction
		,success: successAction
	}); 
});