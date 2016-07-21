<?php
namespace Home\Model;
//include('./CUser.php');
use Think\Model;
class ZlcbaoguanModel extends CUserModel{
	
	/*报关行 登录接口
	author：xuwb
	time：2016年6月17日09:58:22
	参数 ------
	$username：用户名称
	$pwd：用户密码（MD5前）*/
	public function login($user_name,$pwd){
		$admin = M('admin');

		$resu = $admin ->where("user_name = '".$user_name."' and password = '".md5($pwd)."'")
					   ->find();

		if($resu){
			return json_encode(array('code' => 1 ,'data' => $resu['id']));
		}else{
			$info = $admin ->where("user_name = '".$user_name."'")
					   	   ->find();
			if($info){
				session('userName',$resu['user_name']);
				$this ->add_log(1,session('userName'));
				return json_encode(array('code' => -1,'data' => '用户密码错误'));
			}else{
				return json_encode(array('code' => -2,'data' => '用户名错误'));
			}
		}

	}
	/*管理员人员查询
	author：xuwb
	time：2016年6月17日10:18:22
	参数 ------
	$depart_id：传0,查全部,其余传几查为几的部门的人员
	*/
	public function personnel($depart_id){
		$admin = M('admin a');

		if($depart_id == 0){
			$resu = $admin ->join(C("DB_PREFIX")."department d on d.id=a.depart_id")
						   ->where("a.is_del = 0")
						   ->field("a.id,a.user_name,d.name,d.id as d_id,d.p_id,a.depart_id")
						   ->select();
		}else{
			$dep_id = M('department') ->where("p_id = ".$depart_id) ->field("id") ->select();
			
			if(!empty($dep_id)){
				foreach ($dep_id as $key => $value) {
					foreach ($value as $k => $v) {
						$str .= ",".$v; 
					}	
				}
			$re = $admin ->join(C("DB_PREFIX")."department d on d.id=a.depart_id")
					     ->where("a.is_del = 0 and a.depart_id in(".substr($str,1).")")
					     ->field("a.id,a.user_name,d.name,d.id as d_id,d.p_id,a.depart_id")
					     ->select();
			$su = $admin ->join(C("DB_PREFIX")."department d on d.id=a.depart_id")
					  	 ->where("a.is_del = 0 and a.depart_id = ".$depart_id)
					  	 ->field("a.id,a.user_name,d.name,d.id as d_id,d.p_id,a.depart_id")
					     ->select();
			$resu = array_merge($re,$su);
			}else{
				$resu = $admin ->join(C("DB_PREFIX")."department d on d.id=a.depart_id")
						   ->where("a.is_del = 0 and a.depart_id = ".$depart_id)
						   ->field("a.id,a.user_name,d.name,d.id as d_id,d.p_id,a.depart_id")
						   ->select();
			}
			
		}
		$this ->add_log(2,session('userName'));
		return json_encode(array('code' => 1,'data' => $resu));
	}
	/*报关行人员查询
	author：xuwb
	time：2016年6月17日10:18:22
	参数 ------
	$depart_id：传0,查全部,其余传几查为几的部门的人员
	*/
	public function personnel_bg($depart_id){
		$admin = M('cb_user a');

		if($depart_id == 0){
			$resu = $admin ->join(C("DB_PREFIX")."department d on d.id=a.depart_id")
						   ->where("a.is_del = 0")
						   ->field("a.id,a.user_name,d.name,d.id as d_id,d.p_id,a.depart_id")
						   ->select();
		}else{
			$dep_id = M('department') ->where("p_id = ".$depart_id) ->field("id") ->select();
			
			if(!empty($dep_id)){
				foreach ($dep_id as $key => $value) {
					foreach ($value as $k => $v) {
						$str .= ",".$v; 
					}	
				}
			$re = $admin ->join(C("DB_PREFIX")."department d on d.id=a.depart_id")
					     ->where("a.is_del = 0 and a.depart_id in(".substr($str,1).")")
					     ->field("a.id,a.user_name,d.name,d.id as d_id,d.p_id,a.depart_id")
					     ->select();
			$su = $admin ->join(C("DB_PREFIX")."department d on d.id=a.depart_id")
					  	 ->where("a.is_del = 0 and a.depart_id = ".$depart_id)
					  	 ->field("a.id,a.user_name,d.name,d.id as d_id,d.p_id,a.depart_id")
					     ->select();
			$resu = array_merge($re,$su);
			}else{
				$resu = $admin ->join(C("DB_PREFIX")."department d on d.id=a.depart_id")
						   ->where("a.is_del = 0 and a.depart_id = ".$depart_id)
						   ->field("a.id,a.user_name,d.name,d.id as d_id,d.p_id,a.depart_id")
						   ->select();
			}
			
		}
		$this ->add_log(3,session('userName'));
		return json_encode(array('code' => 1,'data' => $resu));
	}
	/*贸易公司人员查询
	author：xuwb
	time：2016年6月17日10:18:22
	参数 ------
	$depart_id：传0,查全部,其余传几查为几的部门的人员
	*/
	public function personnel_my($depart_id){
		$admin = M('tc_user a');

		if($depart_id == 0){
			$resu = $admin ->join(C("DB_PREFIX")."department d on d.id=a.depart_id")
						   ->where("a.is_del = 0")
						   ->field("a.id,a.user_name,d.name,d.id as d_id,d.p_id,a.depart_id")
						   ->select();
		}else{
			$dep_id = M('department') ->where("p_id = ".$depart_id) ->field("id") ->select();
			
			if(!empty($dep_id)){
				foreach ($dep_id as $key => $value) {
					foreach ($value as $k => $v) {
						$str .= ",".$v; 
					}	
				}
			$re = $admin ->join(C("DB_PREFIX")."department d on d.id=a.depart_id")
					     ->where("a.is_del = 0 and a.depart_id in(".substr($str,1).")")
					     ->field("a.id,a.user_name,d.name,d.id as d_id,d.p_id,a.depart_id")
					     ->select();
			$su = $admin ->join(C("DB_PREFIX")."department d on d.id=a.depart_id")
					  	 ->where("a.is_del = 0 and a.depart_id = ".$depart_id)
					  	 ->field("a.id,a.user_name,d.name,d.id as d_id,d.p_id,a.depart_id")
					     ->select();
			$resu = array_merge($re,$su);
			}else{
				$resu = $admin ->join(C("DB_PREFIX")."department d on d.id=a.depart_id")
						   ->where("a.is_del = 0 and a.depart_id = ".$depart_id)
						   ->field("a.id,a.user_name,d.name,d.id as d_id,d.p_id,a.depart_id")
						   ->select();
			}
			
		}
		$this ->add_log(4,session('userName'));
		return json_encode(array('code' => 1,'data' => $resu));
	}
	/*报关行 人员管理——增加记录接口
	author：xuwb
	time：2016年6月17日13:48:51
	参数 ------
	$model：数据库表
	$user_name：用户名称
	$pwd：用户密码
	$sex：性别
	$mobile：手机号
	$e_mail：邮箱
	$real_name：真实姓名
	$cb_id：所属报关行id
	$tc_id：所属贸易公司id
	*/
	public function add_user($user_msg){
		$total_check = $this->check_user_name($user_msg['user_name']);
		if(!empty($total_check)){
			return $total_check;die;
		}

		$branch_check = $this->checks_msg($user_msg['model'],$user_msg['user_name']);
		if(!empty($branch_check)){
			return $branch_check;die;
		}
		$admin = M($user_msg['model']);
		if($user_msg['model'] == 'cb_user'){
			$data['user_name'] = $user_msg['cb_id'];
		}
		if($user_msg['model'] == 'tc_user'){
			$data['user_name'] = $user_msg['tc_id'];
		}
		$data['user_name'] = $user_msg['user_name'];
		$data['password'] = md5($user_msg['pwd']);
		$data['sex'] = $user_msg['sex'];
		$data['mobile'] = $user_msg['mobile'];
		$data['e_mail'] = $user_msg['e_mail'];
		$data['real_name'] = $user_msg['real_name'];
		$data['create_time'] = strtotime(date('Y-m-d H:i:s'));
		$data['final_update_time'] = strtotime(date('Y-m-d H:i:s'));
		$resu = $admin ->add($data);

		if($resu){
			$user_msg['userName'] = session('userNmae');
			$this ->add_log(5,$user_msg);
			return json_encode(array('code' => 1));
		}else{
			return json_encode(array('code' => -1,'data' => '服务器错误'));
		}
	}
	/*报关行 人员管理——修改记录接口
	author：xuwb
	time：2016年6月17日15:22:56
	参数 ------
	$model：数据库表
	$user_id：用户id
	$user_name：用户名称
	$pwd：用户密码
	$sex：性别
	$mobile：手机号
	$e_mail：邮箱
	$real_name：真实姓名
	*/
	public function update_user($user_msg){
		//是否存在这个用户
		$is_existed = $this->checks_user($user_msg['model'],$user_msg['user_id']);
		if(!empty($is_existed)){
			return $is_existed;die;
		}
		//效验用户名合法性
		$total_check = $this->check_user_name($user_msg['user_name']);
		if(!empty($total_check)){
			return $total_check;die;
		}
		//用户名是否已经注册
		$branch_check = $this->checks_msg($user_msg['model'],$user_msg['user_name']);
		if(!empty($branch_check)){
			return $branch_check;die;
		}
		$admin = M($user_msg['model']);

		$data['user_name'] = $user_msg['user_name'];
		$data['password'] = md5($user_msg['pwd']);
		$data['sex'] = $user_msg['sex'];
		$data['mobile'] = $user_msg['mobile'];
		$data['e_mail'] = $user_msg['e_mail'];
		$data['real_name'] = $user_msg['real_name'];
		$data['final_update_time'] = strtotime(date('Y-m-d H:i:s'));
		$resu = $admin ->where("id = ".$user_msg['user_id']) ->save($data);

		if($resu){
			$user_msg['userName'] = session('userNmae');
			$this ->add_log(6,$user_msg);
			return json_encode(array('code' => 1));
		}else{
			return json_encode(array('code' => -1,'data' => '服务器错误'));
		}
	}
	/*报关行 人员管理——删除记录接口
	author：xuwb
	time：2016年6月17日15:26:15
	参数 ------
	$model：数据库表
	$user_id：用户id
	*/
	public function delete_user($model,$user_id){
		$is_existed = $this->checks_user($model,$user_id);
		//是否存在这个用户
		if(!empty($is_existed)){
			return $is_existed;die;
		}
		$admin = M($model);

		$resu = $admin ->where("id = ".$user_id) ->setField('is_del',1);
		if($resu){
			$this ->add_log(7,$user_id);
			return json_encode(array('code' => 1));
		}else{
			return json_encode(array('code' => -1,'data' => '服务器错误'));
		}
	}
	/*报关行 人员管理——彻底删除记录接口
	author：xuwb
	time：2016年6月17日15:26:15
	参数 ------
	$model：数据库表
	$user_id：用户id
	*/
	public function knew_delete_user($model,$user_id){
		$is_existed = $this->checks_user($model,$user_id);
		//是否存在这个用户
		if(!empty($is_existed)){
			return $is_existed;die;
		}

		$admin = M($model);

		$resu = $admin ->where("id = ".$user_id) ->delete();
		if($resu){
			$this ->add_log(8,$user_id);
			return json_encode(array('code' => 1));
		}else{
			return json_encode(array('code' => -1,'data' => '服务器错误'));
		}
	}
	/*部门 --- 查询部门接口
	author：xuwb
	time：2016年6月20日13:44:19
	参数：------
	$p_id：父级id（传01查询全部，其余传几查几）
	*/
	public function depart_query($p_id){
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
			return json_encode(array('code' => 1,'data' => $resu));
		}else{
			return json_encode(array('code' => -1,'data' => '服务器错误'));
		}
	}
	/*查询子部门 ---
	author：xuwb
	time：2016年6月23日13:18:24
	参数：------
	$arr_id：（array）父级id*/
	public function depart_sel($arr_id){
		$model = M('department');

		// foreach($arr_id as $key => $value){
		// 	$resu[$key]['bgname'] = $model ->where("p_id = ".$value." and is_del = 0") 
		// 							 ->field("name")
		// 							 ->find();
		// 	$resu[$key]['name'] = $model ->where("p_id = ".$value." and is_del = 0")
		// 							 ->select();
		// }
		foreach ($arr_id as $k => $v) {
		  $parent[$k]['bgname'] = $model->where('id='.$v)->field("name")->select();	 
		  $parent[$k]['name']=$model->where('p_id='.$v)->select();
		  
		
		 }
		 foreach ($parent as $k => $v) {
		 	$parent[$k]['bgname'] =	$parent[$k]['bgname']['0']['name'];
		 
		 }
		return $parent;
	}
	/*部门 --- 添加部门接口
	author：xuwb
	time：2016年6月20日13:44:19
	参数：------
	$name：部门名称
	$p_id：父级id
	*/
	public function depart_add($name,$p_id){
		$model = M('department');

		$data['name'] = $name;
		$data['p_id'] = $p_id;
		$data['create_time'] = strtotime(date('Y-m-d H:i:s'));
		$resu = $model ->add($data);

		if($resu){
			return json_encode(array('code' => 1));
		}else{
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
			return json_encode(array('code' => 1));
		}else{
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
		$model = M('department');
		$info = $model ->where("id = ".$depart_id)->find();
		if(empty($info)){
			return json_encode(array('code' => -2,'data' => '不存在该部门'));die;
		}

		$resu = $model ->where("id = ".$depart_id) ->setField('is_del',1);

		if($resu){
			return json_encode(array('code' => 1));
		}else{
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
		$model = M('department');
		$info = $model ->where("id = ".$depart_id)->find();
		if(empty($info)){
			return json_encode(array('code' => -2,'data' => '不存在该部门'));die;
		}

		$resu = $model ->where("id = ".$depart_id) ->delete();

		if($resu){
			return json_encode(array('code' => 1));
		}else{
			return json_encode(array('code' => -1,'data' => '服务器错误'));
		}
	}
	/*报关行列表 --- 添加报关行
	author：xuwb
	time：2016年6月20日15:02:09
	参数：------
	*/
	public function customs_breker($cb_msg){
		$model = M('customs_broker');

		$data['name'] = $cb_msg['name'];
		$data['adress'] = $cb_msg['adress'];
		$data['legal_person'] = $cb_msg['legal_person'];
		$data['officetype'] = $cb_msg['officetype'];
		$data['description'] = $cb_msg['description'];
		$data['create_time'] = strtotime(date('Y-m-d H:i:s'));
		$data['photos'] = $cb_msg['photos'];
		$resu = $model ->add($data);

		$user['user_name'] = $cb_msg['user_name'];
		$user['password'] = $cb_msg['password'];
		$user['is_admin'] = 1;
		$user['cb_id'] = $resu;
		$user['create_time'] = strtotime(date('Y-m-d H:i:s'));
		$resu1 = M('cb_use') ->add($user);

		$user_role['cb_id'] = $resu1; 
		$user_role['cb_role_id'] = 11; 
		$user_role['create_time'] = strtotime(date('Y-m-d H:i:s')); 
		$resu2 = M('cb_user_role') ->add($user_role);

		if($resu && $resu1 && $resu2){
			return json_encode(array('code' => 1));
		}else{
			return json_encode(array('code' => -1,'data' => '服务器错误'));
		}
	}
	/*效验用户名 --- 公用
	author：xuwb
	time：2016年6月17日14:02:46
	参数：------
	$model：数据库表
	$user_name：用户名
	*/
	public function checks_msg($model,$user_name){
		$resu = M($model) ->where("user_name = '".$user_name."'")
						   ->find();
		if($resu){
			return json_encode(array('code' => -4,'data' => '用户名已存在'));
		}
		
	}
	/*效验用户是否存在 --- 公用
	author：xuwb
	time：2016年6月17日14:02:46
	参数：------
	$model：数据库表
	$user_id：用户id
	*/
	public function checks_user($model,$user_id){
		$resu = M($model) ->where("id = ".$user_id)
						   ->find();
		if(empty($resu)){
			return json_encode(array('code' => -5,'data' => '该用户不存在'));
		}
		
	}
	/*判断是否有权限 ---公用
	author：xuwb
	time：2016年6月21日10:22:03
	*/
	public function is_purview($user_id){
		$model = M('admin_user_role aur');

		$resu = $model ->join(C("DB_PREFIX")."admin_role_permissions arp on aur.ad_role_id = 				   arp.ad_role_id")
					   ->join(C("DB_PREFIX")."permissions p on arp.per_id = p.id")
					   ->where("aur.ad_id = ".$user_id." and p.p_id = 0") 
					   ->field("distinct(arp.per_id),p.name,p.url,p.p_id") 
					   ->select();
		foreach ($resu as $key => $value) {
			$resu1 = $model ->join(C("DB_PREFIX")."admin_role_permissions arp on aur.ad_role_id = arp.ad_role_id")
					   ->join(C("DB_PREFIX")."permissions p on arp.per_id = p.id")
					   ->where("aur.ad_id = ".$user_id." and p.p_id != 0") 
					   ->field("distinct(arp.per_id),p.name,p.url,p.p_id") 
					   ->select();
		}
		return $resu;

	}

	public function add_log($message,$info){
		$model = M('admin_log');
		switch ($message) {
		    case 1:
			    $data['info'] = '用户'.$info.'登录了系统';
			    break;
		    case 2:
			    $data['info'] = '用户'.$info.'查询了管理员人员列表';
			    break;
		    case 3:
			    $data['info'] = '用户'.$info.'查询了报关行人员列表';
			    break;
			case 4:
			    $data['info'] = '用户'.$info.'查询了贸易公司人员列表';
			    break;
			case 5:
			    $data['info'] = '用户'.$info['userName'].'添加了成员'.$info['user_name'];
			    break;
			case 6:
			    $data['info'] = '用户'.$info['userName'].'修改了成员'.$info['user_name']."";
			    break;
			case 7:
			    $data['info'] = '用户'.session('userName').'删除了成员'.$info;
			    break;
			case 8:
			    $data['info'] = '用户'.session('userName').'彻底删除了成员'.$info;
			    break;
		   
		}
		// $data['info'] = $message;
		$data['create_time'] = strtotime(date('Y-m-d H:i:s'));

		$resu = $model ->add($data);

	}
	
}