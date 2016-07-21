<?php
namespace Home\Controller;
use Think\Controller;
class CeshiController extends Controller {
	public function _initialize(){
		// $model_name = CONTROLLER_NAME."/".ACTION_NAME;
		// $info = M('permissions') ->where("action = '".$model_name."'")
		// 						 ->find();
		// 						 // print_r($info);die;
		// if(!empty($info)){
		// 	$rbac = new \Home\Model\ZlcbaoguanModel();
		// 	$result = $rbac->is_purview(24);
		// 	$a = array();
		// 	foreach($result as $value){
		// 		$a[] = $value['per_id'];
		// 	}
		// 	if(!in_array($info['id'], $a)){
		// 		echo "没有权限";
		// 	}

		// }
	}
	public function a(){
		$this->display();
	}
	public function index(){
		//$admin_id = 19;
		// $user_name = 'heyman';
		// $pwd = 'admin1234';
		// $sex = 1;
		// $mobile = '18535701949';
		// $e_mail = '185357019491@163.com';
		// $real_name = '风一鸣';
		// $cb_id = 1;
		// $depart_id = 1;
		// $user_msg = array('model' => 'admin', 'user_name' => $user_name, 'pwd' => $pwd, 'sex' => $sex, 'mobile' => $mobile, 'e_mail' => $e_mail, 'real_name' => $real_name, 'cb_id' => $cb_id, 'depart_id' => $depart_id);
		//$depart_msg = array('depart_id' => 2, 'name' => '运营', 'p_id' => 0);

		// $baoguan = new \Home\Model\ZlcbaoguanModel();
		$rbac = new \Home\Model\admins\BaoguanModel();
		$token = '6353A832-EE9E-8FA2-E817-899680D7DC6B';
		// $aaa= array('old_pwd'=>'admins', 'new_pwd'=>'admins1', 'new_again_pwd'=>'admins1');
		$result = $rbac->company_member($token);
		$a = json_decode($result,true);
		print_r($a);
		// $result = $baoguan->upload();
		// $rbac = new \Home\Model\ZlcbaoguanModel();
		// $result = $rbac->personnel(2);
		// $a = json_decode($result,true);
		// print_r($a);

	}
	// function guid(){
	//     if (function_exists('com_create_guid')){
	//         return com_create_guid();
	//     }else{
	//         mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
	//         $charid = strtoupper(md5(uniqid(rand(), true)));
	//         $hyphen = chr(45);// "-"
	//         $uuid = substr($charid, 0, 8).$hyphen
 //            .substr($charid, 8, 4).$hyphen
 //            .substr($charid,12, 4).$hyphen
 //            .substr($charid,16, 4).$hyphen
 //            .substr($charid,20,12);
	//         echo $uuid;
	//     }
	// }
	//echo guid();
	
	public function b(){
		//print_r($_FILES);
		$upload = new \Think\Upload();// 实例化上传类
		$image = new \Think\Image();
	    $upload->maxSize   =     3145728 ;// 设置附件上传大小
	    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
	    $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
	    $upload->savePath  =     ''; // 设置附件上传（子）目录
	    // 上传文件 
	    $info   =   $upload->upload($_FILES);
	    if(!$info) {// 上传错误提示错误信息
	    	return json_encode(array('code' => -6,'data' => $upload->getError()));
	    }else{// 上传成功
	    	$array = array();
	        foreach($info as $file){
		        $file_path = './Uploads/'.$file['savepath'].$file['savename'];
		        $file_mini = './Uploads/mini/'.$file['savepath'].$file['savename'];
		        
				$image ->open($file_path);
		        $image ->thumb(150, 150) ->save($file_mini);
		        $array[] = $file_path;
		        
		    }
		    return serialize($array);
	    }
		// $resu = M('cb_role_permissions crp') ->join(C("DB_PREFIX")."cb_permissions 											cp on crp.per_id = cp.id")
		// 									 ->where("crp.cb_role_id = 4")
		// 									 ->field("cp.name,cp.id")
		// 									 ->select();
		// $str = '';
		// foreach ($resu as $key => $value) {
		// 	$resu[$key]['is_have'] = 1;
		// 	$str .= $resu[$key]['id'].',';
		// }

		// $resu1 = M('cb_permissions') ->where("id not in(".substr($str,0,-1).")") 
		// 							 ->field("name,id") 
		// 							 ->select();
		// foreach ($resu1 as $key => $value) {
		// 	$resu1[$key]['is_have'] = 0;
		// }
		// $a = array_merge($resu,$resu1);
		// print_r($a);
		// $charid = strtoupper(uniqid(mt_rand(), true));
	 //    $hyphen = chr(45);// "-"
	 //    $uuid = chr(123);// "{"

	    // print_r($charid);
		
	}
	public function c(){
		// echo phpinfo();die;
		// $token = '33ede9e6ff6d9159a6da2ea129dc6027';
		$rbac = new \Home\Model\zhongliche\ZlcModel();
		// $arr = array('trade_id' => 2, 'product_name'=>'天津市111', 'producer' => '孙宇222' , 'color' => 800000, 'brand' => '集团简介333', 'kinds' => 'user4', 'price' => 2000000, 'frame_number' => '222', 'level' => '3333', 'number_seats' => '3333', 'size' => '3333', 'production_date' => '3333', 'engine_number' => '3333', 'configure' => array('胎压监测','胎压监测','胎压监测','胎压监测'));
		//输号
		// $arr = array('ysx_shipper' => '1467257956', 'ysx_address'=>'10000', 'ysx_online_time' =>'1467257907', 'ysx_status' => 1);

		// $aaa = array('cjh' => '20125', 'stage' => 4);
		$result = $rbac->login('heyman','admin12341');
		$a = json_decode($result,true);
		print_r($a);
		// $this ->assign("list",$a['data']['list']);
		// $this ->assign("page",$a['data']['page']);
		// $this ->display();

	}
	public function verify(){
		$Verify = new \Think\Verify();
		$Verify->entry();

	}
	public function r(){
		$this->display('verify');
	}
}