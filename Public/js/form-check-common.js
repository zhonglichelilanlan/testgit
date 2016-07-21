/**
 * 有关验证码的一些JS
 */
var count = 60; //验证码发送间隔
var InterValObj; //timer变量，控制时间
var curCount;//当前剩余秒数

//复写 不为空 和 再次输入框的提示信息
jQuery.extend(jQuery.validator.messages, {
	required: "此项不能为空",
	equalTo: "请再次输入相同的值"
});

//添加是否为手机号的验证方法
jQuery.validator.addMethod("isMobile", function(value, element) {
	return isMobileNum(value);
}, "请正确填写您的手机号码");

//添加是否为6位数字验证码的验证法   验证码为 100000 -- 999999的数字
jQuery.validator.addMethod("isVerCode", function(value, element) {
	var length = value.length;
	if(!isNaN(value)){
		if(value>=100000 & value<=999999){
			return true;
		}
	}
	return false;
}, "请正确填写短信验证码");

//添加密码的验证方法
jQuery.validator.addMethod("isPWD", function(value, element) {
	var isPWD = /^[\@A-Za-z0-9\!\#\$\%\^\&\*\.\~]{6,16}$/;
	return isPWD.test(value);
}, "密码为6到16为的 字母数字或下划线");

/**
 * 验证手机号码的合法性
 * @param mobile 手机号码
 * @returns {Boolean}
 */
function isMobileNum(mobile){
	var mobileTest = /^(13[0-9]{9})|(18[0-9]{9})|(14[0-9]{9})|(17[0-9]{9})|(15[0-9]{9})$/;
	return (mobile.length == 11 && mobileTest.test(mobile));
}
/**
 * 验证form里面内容的合法性,如果合法就提交表单
 * @returns
 */
function submitForm(){
	var isOK=true;
	//遍历所有的错误信息栏,有错误置为false
	var obj={};
	$("#registerForm").find("input").each(function() {
		var msgId = $(this).attr("id")+"_msg";
		if($(this).val() == ""){
			isOK = false;
			return;
		}
		if($("#"+msgId).attr('class') == "warming"){
			isOK = false;
			return;
		}
		obj[$(this).attr("name")] = $(this).val();
	});

	//如果没有错误信息,同意表单验证
	if(isOK) {
		$.post(SUBMITFORM,obj,function(json){
			json = eval("(" + json + ")");
			if(json.code == 1){
				location.href = json.data;
			}else{
				showErrorMsg(json.data,"mobile_msg");
			}
		});
	}else{
		return;
	}
}



/**
 * 向手机发送短信
 * @param Url 发送短信接口的URL
 * @param bindInputId 输入手机号码的元素ID
 */
function sendMsg2Mobild(bindInputId,self){
	if(curCount) return;//如果倒计时没有完 直接退出
	var mobile = $('#'+bindInputId).val();//获取填写的手机号
	var isMobile = isMobileNum(mobile);//验证手机号格式合法
	if(isMobile){
		$("#mobile").attr("readonly",'true');//发送短信前将手机号输入栏设为只读
		$.post(URL4SENDMSG,{'m':mobile},function(json){
			json = eval("("+json+")");
			if(json.code!=1){
				$("#mobile").attr("readonly",'false');
				showErrorMsg(json.data,"mobile_msg");
			}
		});
	}else{
		showErrorMsg('请正确填写您的手机号码',"mobile_msg");
		return;
	}
	curCount = count;//开始倒计时
	var a = $($(self).find("a")[0]);
	a.css('background','#FF7100');
	a.html("重新发送:" + curCount + "秒");
	InterValObj = window.setInterval(function() {
		if (curCount == 0) {                
			window.clearInterval(InterValObj);//停止计时器
			a.css('background','#009FE8');
			a.html("重新发送验证码");
		}
		else {
			curCount--;
			a.html("重新发送:" + curCount + "秒");
		}
	}, 1000); //启动计时器，1秒执行一次
}
/**
 * 显示错误信息
 * @param msg 错误的信息内容
 * @param msgId 显示错误信息的元素ID
 */
function showErrorMsg(msg,msgId){
	$("#"+msgId).html(msg);
	$("#"+msgId).attr("class","warming");
}

/**
 * 清除错误信息
 * @param msgId 显示错误信息的元素ID
 */
function cleanErrorMsg(msgId){
	$("#"+msgId).html("");
	$("#"+msgId).attr("class","nowarming");
}
/**
 * 验证失败后触发的行为
 * @param error
 * @param element
 */
function errorAction(error, element) {  
	showErrorMsg(error.html(),element.attr("id")+'_msg');
}

var rightMos = [];
/**
 * 验证成功后触发的行为
 * @param label
 */
function successAction(label) {
	cleanErrorMsg( label[0].htmlFor+'_msg');
	//如果是手机类型,要先发送验证码,以验证手机号  (注册验证手机号不存在,找回密码验证手机号存在)
	if(label[0].htmlFor == "mobile"){
		var mobile = $("#mobile").val();
		if( rightMos.indexOf(mobile) >= 0 || curCount>1) return;
		$($("#mobile").next()).attr('class','loading');
		curCount = 1;//将计时器倒计时设置为1 , 防止在申请过程中 用户点击了发送验证码
		$.post(URL4CHECKMOBILE,{'m':mobile,'ts':new Date().getTime()},function(json){
			json = eval("("+json+")");
			if(json.code!=1){
				showErrorMsg(json.data,"mobile_msg");
			}else{
				curCount =0;//如果成功验证了手机号,计时器置为0
				rightMos.push(mobile);
			}
			$($("#mobile").next()).attr('class','');
		});
	}
}