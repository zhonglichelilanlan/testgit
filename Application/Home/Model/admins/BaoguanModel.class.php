<?php
namespace Home\Model\admins;
use Think\Model;
// chdir(dirname(__FILE__));
load("@.Logger");
load("@.Guid");
load("@.Time");
// require_once('Logger.php');
// require_once('Guid.php');
// require_once('../public_file/Time.php');
class BaoguanModel extends Model{
	/*报关行人员登录
	author：xuwb
	time：2016年6月22日15:35:25
	参数：------
	$user_name：用户名
	$pwd：密码
	$code：验证码
	*/
	public function login($user_name,$pwd,$code,$id = ""){
		Logger("begin call Baoguan/login",  ZLC . date('Y-m-d') . "user.log", true);
		

         $verify = new \Think\Verify();
         

         

		if(!($verify ->check($code))){
			Logger("end call Baoguan/login code:-7",  ZLC . date('Y-m-d') . " -login.log", true);
			return json_encode(array('code' => -7,'data' => '验证码错误'));
		}
		$model = M('cb_user');

		$resu = $model ->where("user_name = '".$user_name."' and password = '".md5($pwd)."'")
					   ->find();

		if($resu){
			//登陆成功，生成token，保存token
			$token = guid();
			$data['final_update_time'] = strtotime(date('Y-m-d H:i:s'));
			$data['token'] = $token;
			$user_msg = $model ->where("id = ".$resu['id'])
							   ->save($data);
			$user_msg1 = $model ->where("id = ".$resu['id']) ->field("token") ->find();
			if($user_msg){
				session('token',$data['token']);
				session('userName',$resu['user_name']);
				Logger("end call Baoguan/login code:1",  ZLC . date('Y-m-d') . " -login.log", true);
				$logs = array('userName' => session('userName'),'module' => 'Baoguan','action' => 'login');
				$this ->add_log(1,$logs);
				return json_encode(array('code' => 1,'data' => session('token')));
			}else{
				Logger("end call Baoguan/login code:-3",  ZLC . date('Y-m-d') . " -login.log", true);
				return json_encode(array('code' => -3,'data' => '服务器错误'));
			}
		}else{
			$info = $model ->where("user_name = '".$user_name."'")
					   	   ->find();
			if($info){
				Logger("end call Baoguan/login code:-1",  ZLC . date('Y-m-d') . " -login.log", true);
				return json_encode(array('code' => -1,'data' => '用户密码错误'));
			}else{
				Logger("end call Baoguan/login code:-2",  ZLC . date('Y-m-d') . " -login.log", true);
				return json_encode(array('code' => -2,'data' => '用户名错误'));
			}
		}
	}
	/*检验token
	author：xuwb
	time：2016年6月22日17:40:34*/
	public function index(){
		Logger("begin call Baoguan/index"  ,  ZLC . date('Y-m-d') . " -login.log", true);
		if(!session('token')){
			Logger("end call Baoguan/index code:-1",  ZLC . date('Y-m-d') . " -login.log", true);
			return json_encode(array('code' => -1,'data' => 'session中不存在token'));
		}else{
			$token = session('token');

			$resu = M('cb_user') ->where("token = '".$token."'") ->find();
			if($resu){
				$now_time = strtotime(date('Y-m-d H:i:s'));
				$last_time = $resu['final_update_time'];
				$is_invalid = timediff($last_time,$now_time);
				//是否超过token有效期
				if($is_invalid['day'] > 7){
					$info = M('cb_user') ->where("id = ".$resu['id']) ->setField('token','');
					Logger("end call Baoguan/index code:-2",  ZLC . date('Y-m-d') . " -login.log", true);
					return json_encode(array('code' => -2,'data' => 'token已过期'));die;
				}
				Logger("end call Baoguan/index code:1",  ZLC . date('Y-m-d') . " -login.log", true);
				return json_encode(array('code' => 1));
			}else{
				Logger("end call Baoguan/index code:-3",  ZLC . date('Y-m-d') . " -login.log", true);
				return json_encode(array('code' => -3,'data' => '不存在该token'));
			} 
		}	
	}
	/*权限 --- 角色管理 获取角色对应的信息
	author：xuwb
	time：2016年6月23日14:20:46
	参数：------
	$id：角色id*/
	
	public function bg_update_role($id){
		Logger("begin call Baoguan/bg_update_role " ,  ZLC . date('Y-m-d') . " -rbac.log", true);
		
		$resu = M('cb_role_permissions crp') ->join(C("DB_PREFIX")."cb_permissions 											cp on crp.per_id = cp.id")
											 ->where("crp.cb_role_id =".$id." and cp.name != '权限管理'")
											 ->field("cp.name,cp.id,is_type")
		                                     ->select();



		
		$str = '';
		
		foreach ($resu as $key => $value) {
			
			if($value['is_type']!= 0){
			$resus[$key]['is_have'] = 1;
			$resus[$key]['name'] = $value['name'];
			$resus[$key]['id'] = $value['id'];
			$str .= $resus[$key]['id'].',';
			}else{ 

			$resu3[$key]['is_have'] = 1;
			$resu3[$key]['name'] = $value['name'];
			$resu3[$key]['id'] = $value['id'];
			$str1 .= $resu3[$key]['id'].',';	

			}
		}
		if($str != ''){
		$resu1 = M('cb_permissions') ->where("(id not in(".substr($str,0,-1).")) and is_type = 1 and name != '权限管理'") 
									 ->field("name,id") 
		
									 ->select();

		
		foreach ($resu1 as $key => $value) {
			$resu1[$key]['is_have'] = 0;
		}
		
		$array['list'] = array_merge($resus,$resu1);
		

		}else{ 

		$resu1 = M('cb_permissions') ->where("is_type = 1 and name != '权限管理'") 
									 ->field("name,id") 
									 ->select();	

		foreach ($resu1 as $key => $value) {
			$resu1[$key]['is_have'] = 0;
		}
		
		$array['list'] =$resu1;					 
		
		}							 
		
		if($str1 != ''){
		$resu2 = M('cb_permissions') ->where("(id not in(".substr($str1,0,-1).")) and is_type = 0 and name != '权限管理'") 
									 ->field("name,id") 
					                 ->select();
		foreach ($resu2 as $key => $value) {
			
			$resu2[$key]['is_have'] = 0;
			
		}
			$array['lists'] = array_merge($resu3,$resu2);
		}else{ 
		
		$resu2 = M('cb_permissions') ->where("is_type = 0 and name != '权限管理'") 
									 ->field("name,id") 
									 ->select();	
		foreach ($resu2 as $key => $value) {
			
			$resu2[$key]['is_have'] = 0;
			
		}
		$array['lists'] =$resu2;							 
		}			                 
		

		
		
		
		
		
		
		if($array){
			Logger("end call Baoguan/bg_update_role code:1",  ZLC . date('Y-m-d') . " -rbac.log", true);
			return json_encode(array('code' => 1,'data' => $array));
		}else{
			Logger("end call Baoguan/bg_update_role code:-1",  ZLC . date('Y-m-d') . " -rbac.log", true);
			return json_encode(array('code' => -1,'data' => '服务器错误'));
		}
	}
	/*权限 --- 角色管理 修改
	author：xuwb
	time：2016年6月23日14:20:46
	参数：------
	$arr_role['role_id']：角色id
	$arr_role['pre_id']：所勾选的权限id（array）*/
	public function bg_role($arr_role){
		Logger("begin call Baoguan/bg_role " ,  ZLC . date('Y-m-d') . " -rbac.log", true);
		$check = $this ->is_null($arr_role);
		if(!empty($check)){
			Logger("end call Baoguan/bg_role code:-10",  ZLC . date('Y-m-d') . " -rbac.log", true);
			return $check;die;
		}
		$model = M('cb_role_permissions');
		// var_dump($arr_role['pre_id']);die;
		
		$info = $model  ->where("cb_role_id = ".$arr_role['role_id']) 
						->delete();
						
		foreach ($arr_role['pre_id'] as $k => $v) {
			$data['cb_role_id'] = $arr_role['role_id'];
			$data['per_id'] = $v;
			$resu = $model ->add($data);
			
		}

		if($resu){
			Logger("end call Baoguan/bg_role code:1",  ZLC . date('Y-m-d') . " -rbac.log", true);
			$arr_role['userName'] = session('userName');
			$arr_role['module'] = 'Baoguan';
			$arr_role['action'] = 'bg_role';
			$this ->add_log(2,$arr_role);
			return json_encode(array('code' => 1));
		}else{
			Logger("end call Baoguan/bg_role code:-1",  ZLC . date('Y-m-d') . " -rbac.log", true);
			return json_encode(array('code' => -1,'data' => '服务器错误'));
		}
		
	}
	/*修改个人密码
	author：xuwb
	time：2016年6月30日18:31:11
	*/
	public function update_pwd($token,$arr_msg){
		
		Logger("begin call Baoguan/update_pwd " ,  ZLC . date('Y-m-d') . " -rbac.log", true);
		$check = $this ->token_check($token);
		
		
		$resu = M('cb_user') ->where("token = '".$token."' and password = '"
									.md5($arr_msg['old_pwd'])."'")
							 ->find();
							 
		if($resu){
			if($arr_msg['old_pwd'] == $arr_msg['new_pwd']){
				Logger("end call Baoguan/update_pwd code:-2",  ZLC . date('Y-m-d') . " -rbac.log", true);
				return json_encode(array('code' => -4,'data' => '旧密码不能与新密码相同'));
			}
			if($arr_msg['new_pwd'] == $arr_msg['new_again_pwd']){
				$resu1 = M('cb_user') ->where("token = '".$token."'")
							          ->setField('password',md5($arr_msg['new_pwd']));
				if($resu1){
					Logger("end call Baoguan/update_pwd code:1",  ZLC . date('Y-m-d') . " -rbac.log", true);
					return json_encode(array('code' => 1));
				}else{
					Logger("end call Baoguan/update_pwd code:-3",  ZLC . date('Y-m-d') . " -rbac.log", true);
					return json_encode(array('code' => -3,'data' => '服务器错误'));
				}
			}else{
				Logger("end call Baoguan/update_pwd code:-2",  ZLC . date('Y-m-d') . " -rbac.log", true);
				return json_encode(array('code' => -2,'data' => '两次新密码不正确'));
			}
		}else{
			Logger("end call Baoguan/update_pwd code:-1",  ZLC . date('Y-m-d') . " -rbac.log", true);
			return json_encode(array('code' => -1,'data' => '原密码不正确'));
		}
	}
	/*角色列表 
	author：xuwb
	time：2016年6月23日16:45:51
	*/
	public function role_list(){
		Logger("begin call Baoguan/role_list " ,  ZLC . date('Y-m-d') . " -rbac.log", true);
		$resu = M('cb_role') ->where("is_del = 0") ->select();
		if($resu){
			Logger("end call Baoguan/role_list code:1",  ZLC . date('Y-m-d') . " -rbac.log", true);
			$logs = array('userName' => session('userName'),'module' => 'Baoguan','action' => 'role_list');
			$this ->add_log(3,$logs);
			return json_encode(array('code' => 1,'data' => $resu));
		}else{
			Logger("end call Baoguan/role_list code:-1",  ZLC . date('Y-m-d') . " -rbac.log", true);
			return json_encode(array('code' => -1,'data' => '未查到对应的数据'));
		}
		
	}
	/*权限列表
	author：xuwb
	time：2016年6月23日16:57:57
	*/
	public function per_list(){
		Logger("begin call Baoguan/per_list " ,  ZLC . date('Y-m-d') . " -rbac.log", true);
		//其他业务
		$resu['list'] = M('cb_permissions')->where("is_type = 1 and name != '权限管理'")->select();
		$resu['lists'] = M('cb_permissions')->where("is_type = 0")->select();
		if($resu){
			Logger("end call Baoguan/per_list code:1",  ZLC . date('Y-m-d') . " -rbac.log", true);
			$logs = array('userName' => session('userName'),'module' => 'Baoguan','action' => 'per_list');
			$this ->add_log(4,$logs);
			return json_encode(array('code' => 1,'data' => $resu));
		}else{
			Logger("end call Baoguan/per_list code:-1",  ZLC . date('Y-m-d') . " -rbac.log", true);
			return json_encode(array('code' => -1,'data' => '未查到对应的数据'));
		}
	}

	/*查找角色所对应的权限
	author：xuwb
	time：2016年6月23日16:51:24
	参数：------
	$role_id：角色id
	*/
	public function pre_list($role_id){
		Logger("begin call Baoguan/pre_list " ,  ZLC . date('Y-m-d') . " -rbac.log", true);
		$resu = M('cb_role_permissions crp') 
		        ->join(C("DB_PREFIX")."cb_permissions cp on crp.per_id = cp.id")
		        ->where("crp.cb_role_id = ".$role_id)
		        ->field("cp.id,cp.name,cp.action,cp.url")
		        ->select();
		if($resu){
			Logger("end call Baoguan/pre_list code:1",  ZLC . date('Y-m-d') . " -rbac.log", true);
			return json_encode(array('code' => 1,'data' => $resu));
		}else{
			Logger("end call Baoguan/pre_list code:-1",  ZLC . date('Y-m-d') . " -rbac.log", true);
			return json_encode(array('code' => -1,'data' => '未查到对应的数据'));
		}
	}
	/*获取主页的所能见的列表 --- 权限
	author：xuwb
	time：2016年6月23日17:29:25
	参数：------
	$token：token值
	*/
	public function power($token){
		Logger("begin call Baoguan/power " ,  ZLC . date('Y-m-d') . " -rbac.log", true);
		$check = $this ->token_check($token);
		if(!empty($check)){
			Logger("end call Baoguan/power code:-2/-3",  ZLC . date('Y-m-d') . " -rbac.log", true);
			return $check;die;
		}

		$info['zhu'] = M('cb_user cu') ->join(C("DB_PREFIX")."cb_user_role cur on cu.id = 							cur.cb_id")
		                        ->join(C("DB_PREFIX")."cb_role_permissions crp on cur.cb_role_id = crp.cb_role_id")
		                        ->join(C("DB_PREFIX")."cb_permissions cp on crp.per_id = cp.id")
		                       	->distinct(true)
		                        ->where("cu.token = '".$token."' and is_type = 1") 
		                        ->field("cp.id,cp.name,cp.action,cp.url,cp.is_type")
		                        ->select();
		$info['ci'] = M('cb_user cu') ->join(C("DB_PREFIX")."cb_user_role cur on cu.id = 							cur.cb_id")
		                        ->join(C("DB_PREFIX")."cb_role_permissions crp on cur.cb_role_id = crp.cb_role_id")
		                        ->join(C("DB_PREFIX")."cb_permissions cp on crp.per_id = cp.id")
		                       	->distinct(true)
		                        ->where("cu.token = '".$token."' and is_type = 0") 
		                        ->field("cp.id,cp.name,cp.action,cp.url,cp.is_type")
		                        ->select();
		if($info){
			Logger("end call Baoguan/power code:1",  ZLC . date('Y-m-d') . " -rbac.log", true);
			return json_encode(array('code' => 1,'data' => $info));
		}else{
			Logger("end call Baoguan/power code:-1",  ZLC . date('Y-m-d') . " -rbac.log", true);
			return json_encode(array('code' => -1,'data' => '未查到对应的数据'));
		}
	}
	/*公司管理 —— 公司信息
	author：xuwb
	time：2016年6月28日10:44:36
	参数：------
	$token：用户token
	*/
	public function company_msg($token){
		Logger("begin call Baoguan/company_msg " ,  ZLC . date('Y-m-d') . " -rbac.log", true);
		$check = $this ->token_check($token);
		if(!empty($check)){
			Logger("end call Baoguan/power code:-2/-3",  ZLC . date('Y-m-d') . " -rbac.log", true);
			return $check;die;
		}
		$info = M('cb_user') ->where("token = '".$token."'") ->field("cb_id") ->find();
		$resu = M('cb_user cu') ->join(C("DB_PREFIX")."customs_broker cb on cb.id = 							cu.cb_id")
								// ->join(C("DB_PREFIX")."cb_user_role cur on cur.cb_id 	 = cu.id")
								->where("cu.is_admin = 1 and cb.id = ".$info['cb_id'])
								->field("cb.name,cb.address,cu.password,cu.user_name")
								->find();
		if($resu){
			Logger("end call Baoguan/company_msg code:1",  ZLC . date('Y-m-d') . " -rbac.log", true);
			return json_encode(array('code' => 1,'data' => $resu));
		}else{
			Logger("end call Baoguan/company_msg code:-1",  ZLC . date('Y-m-d') . " -rbac.log", true);
			return json_encode(array('code' => -1,'data' => '未查到对应的数据'));
		}

	}
	/*公司管理 - 公司成员
	author：xuwb
	time：2016年6月28日11:06:40
	参数：------
	$token：用户token
	*/
	public function company_member($token,$num = 10){
		Logger("begin call Baoguan/company_member " ,  ZLC . date('Y-m-d') . " -rbac.log", true);
		$check = $this ->token_check($token);
		if(!empty($check)){
			Logger("end call Baoguan/company_member code:-2/-3",  ZLC . date('Y-m-d') . " -rbac.log", true);
			return $check;die;
		}

		$info = M('cb_user') ->where("token = '".$token."'") ->field("cb_id") ->find();
		$Count = M('cb_user cu')->join(C("DB_PREFIX")."cb_user_role cur on cur.cb_id 						 = cu.id")
								->join(C("DB_PREFIX")."cb_role cb on cb.id = cur.cb_role_id")
								->limit($Page->firstRow. ',' . $Page->listRows)
								->where("cu.cb_id = ".$info['cb_id'])
								->Count();
		$Page = getpage($Count,$num);
		

    	
		
		$resu['list'] = M('cb_user cu') ->join(C("DB_PREFIX")."cb_user_role cur on cur.cb_id 						 = cu.id")
								->join(C("DB_PREFIX")."cb_role cb on cb.id = cur.cb_role_id")
								->limit($Page->firstRow. ',' . $Page->listRows)
								->where("cu.cb_id = ".$info['cb_id'])
								->field("cu.user_name,cu.mobile,cb.name,cu.id")
								->select();
		
		$resu['page'] = $Page->show();
						
		if($resu){
			Logger("end call Baoguan/company_member code:1",  ZLC . date('Y-m-d') . " -rbac.log", true);
			return json_encode(array('code' => 1,'data' => $resu));
		}else{
			Logger("end call Baoguan/company_member code:-1",  ZLC . date('Y-m-d') . " -rbac.log", true);
			return json_encode(array('code' => -1,'data' => '未查到对应的数据'));
		}
	}
	/*增加员工
	author：xuwb
	time：2016年6月28日13:52:49
	参数：------
	$arr_msg['token']：当前登录的用户token
	$arr_msg['user_name']：添加的员工名称
	$arr_msg['password']：添加的员工登录密码
	$arr_msg['mobile']：添加的员工手机
	$arr_msg['role']：员工所属角色id
	*/
	public function add_user($arr_msg){
		// session('userName','fengyiming1');
		Logger("begin call Baoguan/add_user " ,  ZLC . date('Y-m-d') . " -rbac.log", true);
		$check = $this ->token_check($arr_msg['token']);
		if(!empty($check)){
			Logger("end call Baoguan/add_user code:-2/-3",  ZLC . date('Y-m-d') . " -rbac.log", true);
			return $check;die;
		}
		$info = M('cb_user') ->where("token = '".$arr_msg['token']."'") ->field("cb_id") ->find();
		$data['user_name'] = $arr_msg['user_name'];
		$data['password'] = md5($arr_msg['password']);
		$data['mobile'] = $arr_msg['mobile'];
		$data['cb_id'] = $info['cb_id'];

		$resu = M('cb_user') ->add($data);
     
		$user_role['cb_id'] = $resu; 
		$user_role['cb_role_id'] = $arr_msg['role']; 
		$user_role['create_time'] = strtotime(date('Y-m-d H:i:s')); 
		$resu1 = M('cb_user_role') ->add($user_role);

		// $r_p['cb_id'] = $resu1;
		// $r_p['cb_role_id'] = 11;
		// $r_p['create_time'] = strtotime(date('Y-m-d H:i:s'));
		// $add_role = M('cb_user_role') ->add($data);
		if($resu && $resu1){
			Logger("end call Baoguan/add_user code:1",  ZLC . date('Y-m-d') . " -rbac.log", true);
			$logs = array('userName' => session('userName'),'module' => 'Baoguan','action' => 'add_user', 'user' => $arr_msg['user_name']);
				$this ->add_log(5,$logs);
			return json_encode(array('code' => 1));
		}else{
			Logger("end call Baoguan/add_user code:-1",  ZLC . date('Y-m-d') . " -rbac.log", true);
			return json_encode(array('code' => -1,'data' => '未查到对应的数据'));
		}
	}
	/*修改员工信息 -- 获取员工信息
	author：xuwb
	time：2016年6月28日14:45:36
	参数：------
	$id：用户id
	*/
	public function user_infomation($id){
		Logger("begin call Baoguan/user_infomation " ,  ZLC . date('Y-m-d') . " -rbac.log", true);
		$check = $this ->is_null($id);
		if(!empty($check)){
			Logger("end call Baoguan/add_user code:-10",  ZLC . date('Y-m-d') . " -rbac.log", true);
			return $check;die;
		}
		$resu = M('cb_user cu') ->join(C("DB_PREFIX")."cb_user_role cur on cur.cb_id 						 = cu.id")
								->join(C("DB_PREFIX")."cb_role cb on cb.id = cur.cb_role_id")
								->where("cu.id = ".$id)
								->field("cb.id as cid,cu.user_name,cu.mobile,group_concat(cb.name) as name,cu.id,cu.password")
								->find();
		if($resu){
			Logger("end call Baoguan/user_infomation code:1",  ZLC . date('Y-m-d') . " -rbac.log", true);
			return json_encode(array('code' => 1,'data' => $resu));
		}else{
			Logger("end call Baoguan/user_infomation code:-1",  ZLC . date('Y-m-d') . " -rbac.log", true);
			return json_encode(array('code' => -1,'data' => '未查到对应的数据'));
		}

	}
	/*修改员工信息 -- 修改提交
	author：xuwb
	time：2016年6月28日14:54:33
	参数：------
	$arr_msg['id']：用户id
	$arr_msg['user_name']：添加的员工名称
	$arr_msg['password']：添加的员工登录密码
	$arr_msg['mobile']：添加的员工手机
	$arr_msg['role']：员工所属角色id
	*/
	public function update_user($arr_msg){
		Logger("begin call Baoguan/update_user " ,  ZLC . date('Y-m-d') . " -rbac.log", true);

		$data['user_name'] = $arr_msg['user_name'];
		$data['password'] = md5($arr_msg['password']);
		$data['mobile'] = $arr_msg['mobile'];
		//$data['cb_id'] = $info['cb_id'];
		$resu = M('cb_user') ->where("id = ".$arr_msg['id']) ->save($data);

		$resu1 = M('cb_user_role') ->where("cb_id = ".$arr_msg['id']) ->delete();

		$user_role['cb_id'] = $arr_msg['id']; 
		$user_role['cb_role_id'] = $arr_msg['role'];
		$user_role['create_time'] = strtotime(date('Y-m-d H:i:s'));
		$resu2 = M('cb_user_role') ->add($user_role);
		if($resu && $resu2){
			Logger("end call Baoguan/update_user code:1",  ZLC . date('Y-m-d') . " -rbac.log", true);
			$logs = array('userName' => session('userName'),'module' => 'Baoguan','action' => 'update_user', 'user_id' => $arr_msg['id']);
			$this ->add_log(6,$logs);
			return json_encode(array('code' => 1));
		}else{
			Logger("end call Baoguan/update_user code:-1",  ZLC . date('Y-m-d') . " -rbac.log", true);
			return json_encode(array('code' => -1,'data' => '未查到对应的数据'));
		}
	}
	/*删除员工
	author：xuwb
	time：2016年6月28日15:19:04
	参数：------
	$id：用户id*/
	public function delete_user($id){
		Logger("begin call Baoguan/delete_user " ,  ZLC . date('Y-m-d') . " -rbac.log", true);

		$check = $this ->is_null($id);
		if(!empty($check)){
			Logger("end call Baoguan/delete_user code:-10",  ZLC . date('Y-m-d') . " -rbac.log", true);
			return $check;die;
		}

		$resu = M('cb_user') ->where("id = ".$id) ->delete();
		if($resu){
			Logger("end call Baoguan/delete_user code:1",  ZLC . date('Y-m-d') . " -rbac.log", true);
			return json_encode(array('code' => 1));
		}else{
			Logger("end call Baoguan/delete_user code:-1",  ZLC . date('Y-m-d') . " -rbac.log", true);
			return json_encode(array('code' => -1,'data' => '未查到对应的数据'));
		}
	}
	/*操作日志页面数据
	author：xuwb
	time：2016年6月28日17:22:47
	*/
	public function caozuo_logs($num = 10){
		Logger("begin call Baoguan/caozuo_logs " ,  ZLC . date('Y-m-d') . " -rbac.log", true);
		$Count = M('bg_change_log')->count();
    	$Page = getpage($Count,$num);
		$resu['list'] = M('bg_change_log bcl') ->join(C("DB_PREFIX")."bg_info bf on bcl.info_id = bf.info_id")
		                               ->limit($Page->firstRow. ',' . $Page->listRows                                  )
									   ->order("bcl.create_time desc")
				                       ->select();
		$resu['page'] = $Page->show();
		if($resu){
			Logger("end call Baoguan/caozuo_logs code:1",  ZLC . date('Y-m-d') . " -rbac.log", true);
			return json_encode(array('code' => 1,'data' => $resu));
		}else{
			Logger("end call Baoguan/caozuo_logs code:-1",  ZLC . date('Y-m-d') . " -rbac.log", true);
			return json_encode(array('code' => -1,'data' => '未查到对应的数据'));
		}
	}
	/*验证参数是否为空 
	author：xuwb
	time：2016年6月23日16:28:34
	*/
	public function is_null($msg){
		if(empty($msg)){
			return json_encode(array('code' => -10,'data' => '参数为空'));die;
		}
	}
	/*数据库是否存在该token，
	  token是否过期 
	 auThor：xuwb
	 time：2016年6月23日17:09:28
	 参数：------
	 $token：token值
	*/
	public function token_check($token){
		$model = M('cb_user');

		$resu = $model ->where("token = '".$token."'") ->find();
		if($resu){
			$now_time = strtotime(date('Y-m-d H:i:s'));
			$last_time = $resu['final_update_time'];
			$is_invalid = timediff($last_time,$now_time);
			// print_r($is_invalid);die;
			//是否超过token有效期
			if($is_invalid['day'] > 7){
				$info = M('cb_user') ->where("id = ".$resu['id']) ->setField('token','');
				return json_encode(array('code' => -3,'data' => 'token已过期'));die;
			}
		}else{
			return json_encode(array('code' => -2,'data' => '不存在该token'));die;
		}
	}
	/*添加日志类 
	author：xuwb
	time：2016年6月24日10:30:04
	------
	$message：数值
	$info：说明信息*/
	public function add_log($message,$info){
		$model = M('other_log');
		switch ($message) {
		    case 1:
			    $data['info'] = '用户'.$info['userName'].'登录了系统';
			    break;
		    case 2:
		    	foreach ($info['pre_id'] as $key => $value) {
		    		$str .= $value.',';
		    	}
			    $data['info'] = '用户'.$info['userName'].'修改了id为'.$info['role_id'].'的管理员权限,修改为'.$str;
			    break;
		    case 3:
			    $data['info'] = '用户'.$info['userName'].'查询了角色列表';
			    break;
			case 4:
			    $data['info'] = '用户'.$info['userName'].'查询了权限列表';
			    break;
			case 5:
			    $data['info'] = '用户'.$info['userName'].'添加了员工'.$info['user'];
			    break;
			case 6:
			    $data['info'] = '用户'.$info['userName'].'修改了id为'.$info['user_id'].'的员工信息';
			    break;
		   
		}
		$data['module'] = $info['module'];
		$data['action'] = $info['action'];
		// $data['info'] = $message;
		$data['log_time'] = strtotime(date('Y-m-d H:i:s'));

		$resu = $model ->add($data);

	}
}