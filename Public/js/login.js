var VALLOGININFO = "login_for";//提交用户名和密码的地址如果验证成功 {code:1,data:要跳转的地址}
					  //失败了则{code:负数,data:错误信息}

$(function(){
	$("#registerForm").validate({
		rules:{
			mobile:{
				isMobile:true,
				required:true
			},
			password:{
				isPWD:true,
				required:true
			}
		}
		,errorPlacement: errorAction
		,success: function(label) {
			cleanErrorMsg(label[0].htmlFor+'_msg');
		}
	}); 
});

function submitLogin(){
	//如果没有错误信息,同意表单验证
	if($("#registerForm").valid()) {
		var obj = {
				mobile:$("#mobile").val(),
				password:$.md5($("#password").val())
		};
		obj.ts = new Date().getTime();
		$($("#mobile").next()).attr('class','loading');
		$.post(VALLOGININFO,obj,function(json){
			json = eval("("+json+")");
			if(json.code==1){
				location.href = json.data;
			}else{
				showErrorMsg(json.data,'mobile_msg');
			}
			$($("#mobile").next()).attr('class','');
		});
	}else{
		return;
	}
}