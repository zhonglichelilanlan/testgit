<?php
namespace Home\Model\zhongliche;
use Think\Model;
class CUserModel extends Model{
	/*检验用户名是否存在
	author：xuwb
	time：2016年6月17日14:02:46
	参数：------

	$user_name：用户名
	*/
	public function check_user_name($user_name){
		if($user_name == ''){
			return json_encode(array('code' => -1,'data' => '参数为空'));
		}
		//检验用户名
		$preg = '/^[\w\_]{5,12}$/u';
		if(!preg_match($preg,$user_name)){
			return json_encode(array('code' => -2,'data' => '用户名不合法'));
		}

	}
	
}