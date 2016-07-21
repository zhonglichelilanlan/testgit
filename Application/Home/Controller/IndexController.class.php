<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends CommonController {
	public function password(){ 
	    $this->display();
	}

	public function updatepassword(){ 
	    $arr_msg = $_POST;
	    
	    $token = session('token');

	    $baoguan = new \Home\Model\admins\BaoguanModel();
	    $result = $baoguan->update_pwd($token,$arr_msg);
	    echo $result;
	}
	public function index(){
		$this ->display('index_s');
	}
}