<?php
namespace Home\Model\zhongliche;
use Think\Model;
load("@.Logger");
load("@.Guid");
load("@.Time");
class ZlcModel extends CUserModel{
	/*内部管理后台 登录接口
	author：xuwb
	time：2016年6月17日09:58:22
	参数 ------
	$username：用户名称
	$pwd：用户密码（MD5前）*/
	public function login($user_name,$pwd){
		Logger("begin call Zlc/login",  ZLC . date('Y-m-d') . "-zlc.log", true);
		$admin = M('admin');

		$resu = $admin ->where("user_name = '".$user_name."' and password = '".md5($pwd)."'")
					   ->find();

		if($resu){
			Logger("end call Zlc/login code:1",  ZLC . date('Y-m-d') . "zlc.log", true);
			return json_encode(array('code' => 1 ,'data' => $resu['id']));
		}else{
			$info = $admin ->where("user_name = '".$user_name."'")
					   	   ->find();
			if($info){
				Logger("end call Zlc/login code:-1",  ZLC . date('Y-m-d') . "-zlc.log", true);
				session('userName',$resu['user_name']);
				// $this ->add_log(1,session('userName'));
				return json_encode(array('code' => -1,'data' => '用户密码错误'));
			}else{
				Logger("end call Zlc/login code:-2",  ZLC . date('Y-m-d') . "-zlc.log", true);
				return json_encode(array('code' => -2,'data' => '用户名错误'));
			}
		}

	}
	/*部门 --- 查询部门接口
	author：xuwb
	time：2016年6月20日13:44:19
	参数：------
	$p_id：父级id（传01查询全部，其余传几查几）
	*/
	public function depart_query($p_id){
		Logger("begin call Zlc/depart_query",  ZLC . date('Y-m-d') . " -zlc.log", true);
		if($p_id < 0){
			return json_encode(array('code' => -2,'data' => '参数非法'));die;
		}
		$model = M('department');

		if($p_id == 01){
			$resu = $model ->where("is_del = 0") ->select();
		}else{
			$resu = $model ->where("p_id = ".$p_id." and is_del = 0") ->select();
		}

		if($resu){
			Logger("end call Zlc/depart_query code:1",  ZLC . date('Y-m-d') . " -zlc.log", true);
			return json_encode(array('code' => 1,'data' => $resu));
		}else{
			Logger("end call Zlc/depart_query code:-1",  ZLC . date('Y-m-d') . " -zlc.log", true);
			return json_encode(array('code' => -1,'data' => '服务器错误'));
		}
	}
	/*查询子部门 ---
	author：xuwb
	time：2016年6月23日13:18:24
	参数：------
	$arr_id：（array）父级id*/
	public function depart_sel($arr_id){
		Logger("begin call Zlc/depart_sel",  ZLC . date('Y-m-d') . " -zlc.log", true);
		$model = M('department');

		foreach ($arr_id as $k => $v) {
		  $parent[$k]['bgname'] = $model->where('id='.$v)->field("name")->select();
		  $parent[$k]['id'] = $model->where('id='.$v)->field("id")->select();	 
		  $parent[$k]['name']=$model->where('p_id='.$v)->select();
		  
		
		 }
		 
		 foreach ($parent as $k => $v) {
		    $parent[$k]['bgname'] =	$parent[$k]['bgname']['0']['name'];
		 	$parent[$k]['id'] =	$parent[$k]['id']['0']['id'];
		 
		 }
		Logger("end call Zlc/depart_sel code:1",  ZLC . date('Y-m-d') . " -zlc.log", true);
		return json_encode($parent);

	}
	/*部门 --- 添加部门接口
	author：xuwb
	time：2016年6月20日13:44:19
	参数：------
	$name：部门名称
	$p_id：父级id
	*/
	public function depart_add($name,$p_id){
		Logger("begin call Zlc/depart_add",  ZLC . date('Y-m-d') . " -zlc.log", true);
		$model = M('department');

		$data['name'] = $name;
		$data['p_id'] = $p_id;
		$data['create_time'] = strtotime(date('Y-m-d H:i:s'));
		$resu = $model ->add($data);

		if($resu){
			Logger("end call Zlc/depart_add code:1",  ZLC . date('Y-m-d') . " -zlc.log", true);
			return json_encode(array('code' => 1));
		}else{
			Logger("end call Zlc/depart_add code:-1",  ZLC . date('Y-m-d') . " -zlc.log", true);
			return json_encode(array('code' => -1,'data' => '服务器错误'));
		}
	}
	/*部门 --- 修改部门接口
	author：xuwb
	time：2016年6月20日13:44:19
	参数：------
	$depart_id：部门id
	$name：部门名称
	$p_id：父级id
	*/
	public function depart_update($depart_msg){
		Logger("begin call Zlc/depart_update",  ZLC . date('Y-m-d') . " -zlc.log", true);
		$model = M('department');
		$info = $model ->where("id = ".$depart_msg['depart_id'])->find();
		if(empty($info)){
			return json_encode(array('code' => -2,'data' => '不存在该部门'));die;
		}

		$data['name'] = $depart_msg['name'];
		$data['p_id'] = $depart_msg['p_id'];
		//$data['create_time'] = strtotime(date('Y-m-d H:i:s'));
		$resu = $model ->where("id = ".$depart_msg['depart_id']) ->save($data);

		if($resu){
			Logger("end call Zlc/depart_update code:1",  ZLC . date('Y-m-d') . " -zlc.log", true);
			return json_encode(array('code' => 1));
		}else{
			Logger("end call Zlc/depart_update code:-1",  ZLC . date('Y-m-d') . " -zlc.log", true);
			return json_encode(array('code' => -1,'data' => '服务器错误'));
		}
	}
	/*部门 --- 删除部门接口
	author：xuwb
	time：2016年6月20日13:44:19
	参数：------
	$depart_id：部门id
	*/
	public function depart_delete($depart_id){
		Logger("begin call Zlc/depart_delete",  ZLC . date('Y-m-d') . " -zlc.log", true);
		$model = M('department');
		$info = $model ->where("id = ".$depart_id)->find();
		if(empty($info)){
			return json_encode(array('code' => -2,'data' => '不存在该部门'));die;
		}

		$resu = $model ->where("id = ".$depart_id) ->setField('is_del',1);

		if($resu){
			Logger("end call Zlc/depart_delete code:1",  ZLC . date('Y-m-d') . " -zlc.log", true);
			return json_encode(array('code' => 1));
		}else{
			Logger("end call Zlc/depart_delete code:-1",  ZLC . date('Y-m-d') . " -zlc.log", true);
			return json_encode(array('code' => -1,'data' => '服务器错误'));
		}
	}
	/*部门 --- 彻底删除部门接口
	author：xuwb
	time：2016年6月20日13:44:19
	参数：------
	$depart_id：部门id
	*/
	public function knew_depart_delete($depart_id){
		Logger("begin call Zlc/knew_depart_delete",  ZLC . date('Y-m-d') . " -zlc.log", true);
		$model = M('department');
		$info = $model ->where("id = ".$depart_id)->find();
		if(empty($info)){
			return json_encode(array('code' => -2,'data' => '不存在该部门'));die;
		}

		$resu = $model ->where("id = ".$depart_id) ->delete();

		if($resu){
			Logger("end call Zlc/knew_depart_delete code:1",  ZLC . date('Y-m-d') . " -zlc.log", true);
			return json_encode(array('code' => 1));
		}else{
			Logger("end call Zlc/knew_depart_delete code:-1",  ZLC . date('Y-m-d') . " -zlc.log", true);
			return json_encode(array('code' => -1,'data' => '服务器错误'));
		}
	}
	/*管理员人员查询
	author：xuwb
	time：2016年6月17日10:18:22
	参数 ------
	$depart_id：传0,查全部,其余传几查为几的部门的人员
	*/
	public function personnel($depart_id){
		Logger("begin call Zlc/personnel_a",  ZLC . date('Y-m-d') . " -zlc.log", true);
		$admin = M('admin a');
		$resu = $admin ->where("id=".$id)
					   ->select();

		Logger("end call Zlc/personnel_a code:1",  ZLC . date('Y-m-d') . " -zlc.log", true);
		return json_encode(array('code' => 1,'data' => $resu));			   
	}

}