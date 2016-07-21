<?php
namespace Home\Model\manager;
use Think\Model;
load("@.Logger");
load("@.Guid");
load("@.Time");
class ManagerModel extends Model{
	/*贸易公司列表 
	author：xuwb
	time：2016年6月28日16:03:06*/
	public function trad_company_list($num = 10){
		Logger("begin call Manager/trad_company_list " ,  ZLC . date('Y-m-d') . " -manager.log", true);
		$Count = M('trade_company')->count();
    	$Page = getpage($Count,$num);
		$resu['list'] = M('trade_company tc') ->join(C("DB_PREFIX")."tc_user tu on tc								.id = tu.tc_id")
									  ->where("tu.is_admin = 1")
									  ->limit($Page->firstRow. ',' . $Page->listRows)
									  ->order("tc.create_time desc")
									  ->field("tc.id,tc.name,tc.legal_person,tu.user_name")
	     							  ->select();
	    // foreach ($resu['list'] as $k => $v) {
	    // 	if($v['id']==$id){
	    // 		$resu['list'] = M('trade_company tc') ->join(C("DB_PREFIX")."tc_user tu on tc								.id = tu.tc_id")
					// 				  ->where("tu.is_admin = 1 and tc.id=".$id)
					// 				  ->limit($Page->firstRow. ',' . $Page->listRows)
					// 				  ->order("tc.create_time desc")
					// 				  ->field("tc.id,tc.name,tc.legal_person,tu.user_name")
	    //  							  ->select();
	    // 		$resu['list'][$k]['namess'] =1;
	    // 	}
	    // }
		
							  // echo M('trade_company tc')->getlastsql();die;
		$resu['page'] = $Page->show();
		if($resu){
			Logger("end call Manager/trad_company_list code:1",  ZLC . date('Y-m-d') . " -manager.log", true);
			return json_encode(array('code' => 1,'data' => $resu));
		}else{
			Logger("end call Manager/trad_company_list code:-1",  ZLC . date('Y-m-d') . " -manager.log", true);
			return json_encode(array('code' => -1,'data' => '未查到对应的数据'));
		}
	}
	/*贸易公司添加
	author：xuwb
	time：2016年6月28日16:27:04
	参数：------
	
	$arr_trad['name']：贸易公司名称
	$arr_trad['address']：贸易公司地址
	$arr_trad['legal_person']：贸易公司法人
	$arr_trad['registered_capital']：贸易公司注册资金
	$arr_trad['logo']：贸易公司logo
	$arr_trad['photos']：贸易公司图片
	$arr_trad['user_name']：管理员名称
	$arr_trad['password']：管理员密码
	*/
	public function com_add($arr_trad){
		Logger("begin call Manager/com_add " ,  ZLC . date('Y-m-d') . " -manager.log", true);

		$trad['name'] = $arr_trad['name'];
		$trad['address'] = $arr_trad['address'];
		$trad['legal_person'] = $arr_trad['legal_person'];
		$trad['registered_capital'] = $arr_trad['registered_capital'];
		// $trad['description'] = $arr_trad['description'];
		$trad['logo'] = $arr_trad['logo'];
		//$trad['photos'] = $arr_trad['photos'];
		$trad['create_time'] = strtotime(date('Y-m-d H:i:s'));

		$resu = M('trade_company') ->add($trad);

		$data['user_name'] = $arr_trad['user_name'];
		$data['mobile'] = $arr_trad['mobile'];
		$data['password'] = md5($arr_trad['password']);
		$data['tc_id'] = $resu;
		$data['is_admin'] = 1;
		$data['create_time'] = strtotime(date('Y-m-d H:i:s'));
		$resu1 = M('tc_user') ->add($data);

		// $r_p['cb_id'] = $resu1;
		// $r_p['cb_role_id'] = 11;
		// $r_p['create_time'] = strtotime(date('Y-m-d H:i:s'));
		// $add_role = M('') ->add($data);
		if($resu && $resu1){
			Logger("end call Manager/com_add code:1",  ZLC . date('Y-m-d') . " -manager.log", true);
			$logs = array('userName' => session('userName'),'module' => 'Manager','action' => 'com_add', 'com_name' => $arr_trad['name']);
			$this ->add_log(3,$logs);
			return json_encode(array('code' => 1));
		}else{
			Logger("end call Manager/com_add code:-1",  ZLC . date('Y-m-d') . " -manager.log", true);
			return json_encode(array('code' => -1,'data' => '服务器错误'));
		}
	}
	/*贸易公司修改 --- 获取信息
	author：xuwb
	time：2016年6月28日16:27:04
	参数：------
	$id：贸易公司id
	*/
	public function com_infomation($id){
		Logger("begin call Manager/com_infomation " ,  ZLC . date('Y-m-d') . " -manager.log", true);

		$resu = M('trade_company tc')  ->join(C("DB_PREFIX")."tc_user tu on tc.								 		id = tu.tc_id")
		                               ->where("tc.id = ".$id." and tu.is_admin=1")
		                               ->field("tc.id,tc.name,tc.legal_person,tc.address,tc.registered_capital,tc.description,tc.logo,tc.photos,tu.user_name,tu.password,tu.mobile")
		                               ->find();
		if($resu){
			Logger("end call Manager/com_infomation code:1",  ZLC . date('Y-m-d') . " -manager.log", true);
			return json_encode(array('code' => 1,'data' => $resu));
		}else{
			Logger("end call Manager/com_infomation code:-1",  ZLC . date('Y-m-d') . " -manager.log", true);
			return json_encode(array('code' => -1,'data' => '未查到对应的数据'));
		}
	}
	/*贸易公司修改 --- 提交修改
	author：xuwb
	time：2016年6月28日16:40:04
	参数：------
	$arr_trad['id']：贸易公司id
	$arr_trad['name']：贸易公司名称
	$arr_trad['address']：贸易公司地址
	$arr_trad['legal_person']：贸易公司法人
	$arr_trad['registered_capital']：贸易公司注册资金
	$arr_trad['description']：贸易公司资料
	$arr_trad['logo']：贸易公司logo
	$arr_trad['photos']：贸易公司图片
	$arr_trad['user_name']：管理员名称
	$arr_trad['password']：管理员密码
	*/
	public function update_trad($arr_trad){
		Logger("begin call Manager/update_trad " ,  ZLC . date('Y-m-d') . " -manager.log", true);

		$trad['name'] = $arr_trad['name'];
		$trad['address'] = $arr_trad['address'];
		$trad['legal_person'] = $arr_trad['legal_person'];
		$trad['registered_capital'] = $arr_trad['registered_capital'];
		//$trad['description'] = $arr_trad['description'];
		$trad['logo'] = $arr_trad['logo'];
		//$trad['photos'] = $arr_trad['photos'];

		$resu = M('trade_company') ->where("id = ".$arr_trad['id']) ->save($trad);

		$data['user_name'] = $arr_trad['user_name'];
		$data['mobile'] = $arr_trad['mobile'];
		$data['password'] = md5($arr_trad['password']);
		$resu1 = M('tc_user') ->where("tc_id = ".$arr_trad['id']." and is_admin=1")
		
							  ->save($data);
							  
		if($resu ==1){
			Logger("end call Manager/update_trad code:1",  ZLC . date('Y-m-d') . " -manager.log", true);
			$logs = array('userName' => session('userName'),'module' => 'Manager','action' => 'update_trad', 'company_id' => $arr_trad['id']);
			$this ->add_log(1,$logs);
			return json_encode(array('code' => 1));
		}elseif($resu==0 && $resu1==0){
			Logger("end call Manager/update_trad code:1",  ZLC . date('Y-m-d') . " -manager.log", true);
			$logs = array('userName' => session('userName'),'module' => 'Manager','action' => 'update_trad', 'company_id' => $arr_trad['id']);
			$this ->add_log(1,$logs);
			return json_encode(array('code' => 1));
		}else{
			Logger("end call Manager/update_trad code:-1",  ZLC . date('Y-m-d') . " -manager.log", true);
			return json_encode(array('code' => -1,'data' => '未查到对应的数据'));
		}
	}
	/*贸易公司删除
	author：xuwb
	time：2016年6月28日16:40:04
	参数：------
	$id：贸易公司id
	*/
	public function delete_trad($id){
		Logger("begin call Manager/delete_trad " ,  ZLC . date('Y-m-d') . " -manager.log", true);
		$info = M('bg_info') ->where("trade_id = ".$id) ->select();
		if($info){
			Logger("end call Manager/delete_trad code:-1",  ZLC . date('Y-m-d') . " -manager.log", true);
			return json_encode(array('code' => -1,'data' => '不可以删除'));
		}else{
			$resu = M('trade_company') ->where("id = ".$id) ->delete();
			if($resu){
				Logger("end call Manager/trad_company_list code:1",  ZLC . date('Y-m-d') . " -manager.log", true);
				$logs = array('userName' => session('userName'),'module' => 'Manager','action' => 'delete_trad', 'company_id' => $id);
				$this ->add_log(2,$logs);
				return json_encode(array('code' => 1));
			}else{
				Logger("end call Manager/trad_company_list code:-2",  ZLC . date('Y-m-d') . " -manager.log", true);
				return json_encode(array('code' => -2,'data' => '服务器错误'));
			}
		}
	}
	/*增加报关信息
	author：xuwb
	time：2016年6月29日13:29:18
	参数：------
	$arr_declare['trade_id']：贸易公司id
	$arr_declare['product_name']：品名
	$arr_declare['producer']：产地
	$arr_declare['color']：颜色
	$arr_declare['brand']：品牌
	$arr_declare['kinds']：型号
	$arr_declare['price']：单价
	$arr_declare['frame_number']：车架号
	$arr_declare['level']：级别
	$arr_declare['number_seats']：座位数
	$arr_declare['production_date']：生产日期（时间戳）
	$arr_declare['size']：轮毂尺寸
	$arr_declare['engine_number']：发动机号
	$arr_declare['configure']：车辆配置信息（array）
	*/
	public function add_declare($arr_declare){
		header("Content-Type: text/html;charset=utf-8"); 
		Logger("begin call Manager/add_declare " ,  ZLC . date('Y-m-d') . " -manager.log", true);

		$declare['trade_id'] = $arr_declare['trade_id']; 
		$declare['product_name'] = $arr_declare['product_name']; 
		$declare['producer'] = $arr_declare['producer']; 
		$declare['color'] = $arr_declare['color']; 
		$declare['brand'] = $arr_declare['brand']; 
		$declare['kinds'] = $arr_declare['kinds']; 
		$declare['price'] = $arr_declare['price'] * 100; 
		$declare['frame_number'] = $arr_declare['frame_number']; 
		$declare['level'] = $arr_declare['level']; 
		$declare['number_seats'] = $arr_declare['number_seats']; 
		$declare['size'] = $arr_declare['size']; 
		$declare['production_date'] = strtotime($arr_declare['production_date']); 
		$declare['engine_number'] = $arr_declare['engine_number']; 
		$declare['create_time'] = strtotime(date('Y-m-d H:i:s')); 
		$declare['status'] = 0; 
		$declare['stage'] = 0;

		$resu = M('bg_info') ->add($declare);

		
	
		foreach ($arr_declare['configure'] as $key => $value) {
			$data['info_id'] = $resu;
			$data['name'] = $value;
			
			$resu1 = M('car_configure') ->add($data);
		}
		
		$business['info_id'] = $resu;
		$business['is_del'] = 0;
		$business['sh_status'] = 0;
		$add_business = M('business') ->add($business);
		if($resu && $resu1){
			Logger("end call Baoguan/add_declare code:1",  ZLC . date('Y-m-d') . " -manager.log", true);
			$logs = array('userName' => session('userName'),'info_id' => $resu,'last_status' => 0, 'last_stage' => 0,'now_status' => 0, 'now_stage' => 0);
			$this ->add_info_log(1,$logs);
			return json_encode(array('code' => 1));
		}else{
			Logger("end call Baoguan/add_declare code:-1",  ZLC . date('Y-m-d') . " -manager.log", true);
			return json_encode(array('code' => -1,'data' => '未查到对应的数据'));
		}
		
	}
	/*报关中的列表 / 完成的列表
	author：xuwb
	time：2016年6月29日15:18:54
	参数：------
	$num：分页显示条数
	$whether：报关中传0，完成的传1
	
	public function bg_ing_list($num = 10,$whether){
		Logger("begin call Manager/bg_ing_list " ,  ZLC . date('Y-m-d') . " -manager.log", true);

		$Count = M('bg_info')->where("status = ".$whether) ->count();
    	$Page = new \Think\Page($Count, $num); 
		
		$resu['list'] = M('bg_info bi') ->join(C("DB_PREFIX")."business b on bi.									  info_id = b.info_id")
								        ->where("bi.status = ".$whether)
								        ->limit($Page->firstRow. ',' . $Page->listRows)
									    ->order("bi.create_time desc")
									    ->select();
		$resu['page'] = $Page->show();
		if($resu){
			Logger("end call Baoguan/bg_ing_list code:1",  ZLC . date('Y-m-d') . " -manager.log", true);
			return json_encode(array('code' => 1,'data' => $resu));
		}else{
			Logger("end call Baoguan/bg_ing_list code:-1",  ZLC . date('Y-m-d') . " -manager.log", true);
			return json_encode(array('code' => -1,'data' => '未查到对应的数据'));
		}
	}*/
	/*客户经理首页
	author：xuwb
	time：2016年6月29日17:05:07
	*/
	public function manager_index($num = 10){
		Logger("begin call Manager/manager_index " ,  ZLC . date('Y-m-d') . " -manager.log", true);

		$Count = M('trade_company') ->count();
    	$Page = getpage($Count,$num); 

		$resu['list'] = M('trade_company')->limit($Page->firstRow. ',' 
												  . $Page->listRows)
								          ->order("create_time desc")
								          ->field("id,name")
								          ->select();
		foreach ($resu['list'] as $key => $value) {
			$ing_num = M('bg_info')->where("status = 0 and trade_id = ".$resu['list'][$key]['id']) ->count();
			$ok_num = M('bg_info')->where("status = 1 and trade_id = ".$resu['list'][$key]['id']) ->count();
			$resu['list'][$key]['ing_num'] = $ing_num;
			$resu['list'][$key]['ok_num'] = $ok_num;
		}
		$resu['page'] = $Page->show();
		if($resu){
			Logger("end call Baoguan/manager_index code:1",  ZLC . date('Y-m-d') . " -manager.log", true);
			return json_encode(array('code' => 1,'data' => $resu));
		}else{
			Logger("end call Baoguan/manager_index code:-1",  ZLC . date('Y-m-d') . " -manager.log", true);
			return json_encode(array('code' => -1,'data' => '未查到对应的数据'));
		}
	}
	/*客户经理首页点击数字
	author：xuwb
	time：2016年6月29日17:49:09
	参数：------
	$trade_id：贸易公司id
	$whether：报关中传0，完成的传1
	*/
	public function detail($trade_id,$whether,$num = 10){
		
		Logger("begin call Manager/detail " ,  ZLC . date('Y-m-d') . " -manager.log", true);

		$Count = M('bg_info')->where("trade_id = ".$trade_id." and status = 
									 ".$whether) 
		                     ->count();
    	$Page = getpage($Count,$num);
		
		$resu['list'] = M('bg_info bi') ->join(C("DB_PREFIX")."business b on bi.info_id = b.info_id")
								        ->where("bi.trade_id = ".$trade_id." and bi.status	= ".$whether)
								        ->limit($Page->firstRow. ',' . $Page->listRows)
									    ->order("bi.create_time desc")
									    ->select();
		foreach ($resu['list'] as $k => $v) {
		//总耗时	
		$resu['list'][$k]['bigtime']=ceil(((strtotime(date("Y-m-d"))-$v['create_time']))/86400);
		}
		$resu['page'] = $Page->show();
		if($resu){
			Logger("end call Baoguan/detail code:1",  ZLC . date('Y-m-d') . " -manager.log", true);
			return json_encode(array('code' => 1,'data' => $resu));
		}else{
			Logger("end call Baoguan/detail code:-1",  ZLC . date('Y-m-d') . " -manager.log", true);
			return json_encode(array('code' => -1,'data' => '未查到对应的数据'));
		}
	}
	/*多文件上传 --- 公用
	author：xuwb
	time：2016年6月20日15:15:23
	*/
	public function upload(){ 
		$upload = new \Think\Upload();// 实例化上传类
		// $image = new \Think\Image();
	    $upload->maxSize   =     3145728 ;// 设置附件上传大小
	    $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
	    $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
	    $upload->savePath  =     ''; // 设置附件上传（子）目录
	    $upload->subName   =     'company/'; // 设置附件上传（子）目录
	    // 上传文件 
	    $info   =   $upload->upload();
	    if(!$info) {// 上传错误提示错误信息
	    	return json_encode(array('code' => -6,'data' => $upload->getError()));
	    }else{// 上传成功
	    	$array = array();
	        foreach($info as $file){
		        $file_path = './Uploads/company/'.$file['savename'];
		  //       $file_mini = './Uploads/mini/'.$file['savepath'].$file['savename'];
				// $image ->open($file_path);
		  //       $image ->thumb(150, 150) ->save($file_mini);
		        // $array[] = $file['savename'];
		        
		    }
		    return serialize($file['savename']);
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
			    $data['info'] = '用户'.$info['userName'].'修改了id为'.$info['company_id'].'的贸易公司信息';
			    break;
		    case 2:
		    	$data['info'] = '用户'.$info['userName'].'删除了id为'.$info['company_id'].'的贸易公司信息';
			    break;
		    case 3:
			    $data['info'] = '用户'.$info['userName'].'添加了'.$info['com_name'].'贸易公司';
			    break;		   
		}
		$data['module'] = $info['module'];
		$data['action'] = $info['action'];
		// $data['info'] = $message;
		$data['log_time'] = strtotime(date('Y-m-d H:i:s'));

		$resu = $model ->add($data);

	}
	/*添加业务日志类 
	author：xuwb
	time：2016年6月24日10:30:04
	------
	$message：数值
	$info：说明信息*/
	public function add_info_log($message,$info){
		$model = M('bg_change_log');
		$data['info_id'] = $info['info_id'];
		$data['last_status'] = $info['last_status'];
		$data['last_stage'] = $info['last_stage'];
		$data['now_status'] = $info['now_status'];
		$data['now_stage'] = $info['now_stage'];
		$data['operator'] = $info['userName'];
		// $data['info'] = $message;
		$data['create_time'] = strtotime(date('Y-m-d H:i:s'));

		$resu = $model ->add($data);

	}
}