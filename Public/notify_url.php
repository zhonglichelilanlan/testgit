<?php


/* *
 * 功能：连连支付服务器异步通知页面
 * 版本：1.0
 * 日期：2014-06-16
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。


 *************************页面功能说明*************************
 * 创建该页面文件时，请留心该页面文件中无任何HTML代码及空格。
 * 该页面不能在本机电脑测试，请到服务器上做测试。请确保外部可以访问该页面。
 */

require_once ("llpay.config.php");
require_once ("../ThinkPHP/Library/Org/Util/llpay_notify.class.php");

//计算得出通知验证结果
$llpayNotify = new LLpayNotify($llpay_config);
$verify_result = $llpayNotify->verifyNotify();

if ($verify_result) { //验证成功
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//请在这里加上商户的业务逻辑程序代

	//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
	//获取连连支付的通知返回参数，可参考技术文档中服务器异步通知参数列表
	$is_notify = true;
	include_once ('ThinkPHP/Library/Org/Util/llpay_cls_json.php');
	$json = new JSON;
	$str = file_get_contents("php://input");
	$val = $json->decode($str);
	$oid_partner = trim($val-> {
		'oid_partner' });
	$dt_order = trim($val-> {
		'dt_order' });
	$no_order = trim($val-> {
		'no_order' });
	$oid_paybill = trim($val-> {
		'oid_paybill' });
	$money_order = trim($val-> {
		'money_order' });
	$result_pay = trim($val-> {
		'result_pay' });
	$settle_date = trim($val-> {
		'settle_date' });
	$info_order = trim($val-> {
		'info_order' });
	$pay_type = trim($val-> {
		'pay_type' });
	$bank_code = trim($val-> {
		'bank_code' });
	$sign_type = trim($val-> {
		'sign_type' });
	$sign = trim($val-> {
		'sign' });
	file_put_contents("log.txt", "异步通知 验证成功\n", FILE_APPEND);
	die("{'ret_code':'0000','ret_msg':'交易成功'}"); //请不要修改或删除
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
} else {
	file_put_contents("log.txt", "异步通知 验证失败\n", FILE_APPEND);
	//验证失败
	die("{'ret_code':'9999','ret_msg':'验签失败'}");
	//调试用，写文本函数记录程序运行情况是否正常
	//logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
}
?>