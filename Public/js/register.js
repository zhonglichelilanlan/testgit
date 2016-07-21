/**
 * 注册页面引入JS
 */
//  成功调用返回{code:1}
var URL4SENDMSG = "register_ver";//发送验证码的接口地址
var URL4CHECKMOBILE = "register_chkmobile";//仅验证手机号码 不发送短信的接口地址,验证手机号码是否已经注册
var SUBMITFORM = "register_sub";//注册 表单提交的地址

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
			},
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
