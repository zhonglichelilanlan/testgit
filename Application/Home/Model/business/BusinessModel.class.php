<?php
namespace Home\Model\business;
use Think\Model;
load("@.Logger");
load("@.Guid");
load("@.Time");
class BusinessModel extends Model{
	/*输号 - 业务首页
	author：xuwb
	time：2016年6月30日09:45:40
	*/
	public function sh_list(){

		Logger("begin call Business/sh_list " ,  ZLC . date('Y-m-d') . " -business.log", true);

		$resu['ing'] = M('bg_info bi') ->join(C("DB_PREFIX")."business b on bi.info_id = b.info_id")
										->join(C("DB_PREFIX")."trade_company tc on bi.trade_id = tc.id")
										->join(C("DB_PREFIX")."tc_user tu on tc.id = tu.tc_id")
								        ->where("b.sh_status = 0 and bi.stage = 0")
									    ->order("bi.create_time desc")
									    ->limit(0,2)
									    ->field("tu.user_name,tu.id,tc.name,bi.frame_number,b.sh_certificate_time,b.sh_car_procudure,b.sh_car_permit,b.sh_time_return,b.sh_return_record,b.sh_remarks,b.sh_status,bi.info_id,b.sh_ok_time,b.sh_backlog,b.sh_xkz,b.sh_is_xkz,b.sh_bao,b.sh_bao_price")
									    ->select();
		$resu['ok'] = M('bg_info bi') ->join(C("DB_PREFIX")."business b on bi. info_id = b.info_id")
										->join(C("DB_PREFIX")."trade_company tc on bi.trade_id = tc.id")
										->join(C("DB_PREFIX")."tc_user tu on tc.id = tu.tc_id")
								        ->where("b.sh_status = 1 and bi.stage in(0,1,2,3,4,5)")
									    ->order("bi.create_time desc")
									    ->limit(0,2)
									    ->field("tu.user_name,tu.id,tc.name,bi.frame_number,b.sh_certificate_time,b.sh_car_procudure,b.sh_car_permit,b.sh_time_return,b.sh_return_record,b.sh_remarks,b.sh_status,bi.info_id,b.sh_ok_time,b.sh_xkz,b.sh_is_xkz,b.sh_bao,b.sh_bao_price")
									    ->select();

		if($resu){
			Logger("end call Business/sh_list code:1",  ZLC . date('Y-m-d') . " -business.log", true);
			return json_encode(array('code' => 1,'data' => $resu));
		}else{
			Logger("end call Business/sh_list code:-1",  ZLC . date('Y-m-d') . " -business.log", true);
			return json_encode(array('code' => -1,'data' => '未查到对应的数据'));
		}
	}
	//查询贸易公司详情页
	public function sh_lists($id){

		Logger("begin call Business/sh_list " ,  ZLC . date('Y-m-d') . " -business.log", true);

		$resus = M('bg_info bi') ->join(C("DB_PREFIX")."business b on bi.info_id = b.info_id")
										->join(C("DB_PREFIX")."trade_company tc on bi.trade_id = tc.id")
										->join(C("DB_PREFIX")."tc_user tu on tc.id = tu.tc_id")
								        ->where(" tu.id=".$id)
									    ->order("bi.create_time desc")
									    ->limit(0,2)
									    ->field("tu.user_name,tc.legal_person,tc.name")
									    ->select();
	
		$resu =	$resus[0];						    
		if($resu){
			Logger("end call Business/sh_list code:1",  ZLC . date('Y-m-d') . " -business.log", true);
			return json_encode($resu);
		}else{
			Logger("end call Business/sh_list code:-1",  ZLC . date('Y-m-d') . " -business.log", true);
			return json_encode(array('code' => -1,'data' => '未查到对应的数据'));
		}
	}
	//查询贸易公司详情页
	public function sh_listss($id){
        
		Logger("begin call Business/sh_list " ,  ZLC . date('Y-m-d') . " -business.log", true);

		$resus = M('bg_info bi') ->join(C("DB_PREFIX")."business b on bi.info_id = b.info_id")
								 ->join(C("DB_PREFIX")."car_configure cc on cc.info_id = bi.info_id")
										->join(C("DB_PREFIX")."trade_company tc on bi.trade_id = tc.id")
										->join(C("DB_PREFIX")."tc_user tu on tc.id = tu.tc_id")
								        ->where(" bi.info_id=".$id)
									    ->order(" bi.create_time desc")
									    ->field("bi.product_name,bi.producer,bi.color,bi.brand,bi.kinds,bi.price,bi.frame_number,bi.level,bi.number_seats,bi.size,bi.production_date,bi.engine_number")
		                        		->select();		
        
		   
		$resus[0]['data'] = M('bg_info bi') ->join(C("DB_PREFIX")."car_configure cc on bi.info_id = cc.info_id")
		 						->where("bi.info_id=".$id)
		                        ->field("name")
		                        ->select();
		
		$resu =	$resus[0];
		
		if($resu){
			Logger("end call Business/sh_list code:1",  ZLC . date('Y-m-d') . " -business.log", true);
			return json_encode($resu);
		}else{
			Logger("end call Business/sh_list code:-1",  ZLC . date('Y-m-d') . " -business.log", true);
			return json_encode(array('code' => -1,'data' => '未查到对应的数据'));
		}
	}
	public function sh_listswc($id){

		Logger("begin call Business/sh_list " ,  ZLC . date('Y-m-d') . " -business.log", true);

		$resus = M('bg_info bi') ->join(C("DB_PREFIX")."business b on bi.info_id = b.info_id")
										->join(C("DB_PREFIX")."car_configure cc on cc.info_id = bi.info_id")
										->join(C("DB_PREFIX")."trade_company tc on bi.trade_id = tc.id")
										->join(C("DB_PREFIX")."tc_user tu on tc.id = tu.tc_id")
								        ->where(" bi.info_id=".$id)
									    ->order(" bi.create_time desc")
									    ->field("bi.product_name,bi.producer,bi.color,bi.brand,bi.kinds,bi.price,bi.frame_number,bi.level,bi.number_seats,bi.size,bi.production_date,bi.engine_number")
		                        		->select();		
        
		   
		$resus[0]['data'] = M('bg_info bi') ->join(C("DB_PREFIX")."car_configure cc on bi.info_id = cc.info_id")
		 						->where("bi.info_id=".$id)
		                        ->field("name")
		                        ->select();

		$resu =	$resus[0];

		if($resu){
			Logger("end call Business/sh_list code:1",  ZLC . date('Y-m-d') . " -business.log", true);
			return json_encode($resu);
		}else{
			Logger("end call Business/sh_list code:-1",  ZLC . date('Y-m-d') . " -business.log", true);
			return json_encode(array('code' => -1,'data' => '未查到对应的数据'));
		}
	}
	/*输号 - 业务首页 - 更多
	author：xuwb
	time：2016年6月30日10:47:13
	参数： ------
	$whether：待处理传0，已完成的传1
	*/
	public function sh_list_more($whether,$num = 10){

		Logger("begin call Business/sh_list_more " ,  ZLC . date('Y-m-d') . " -business.log", true);
		if($whether == 1){
			$where = "b.sh_status = ".$whether." and bi.stage in(0,1,2,3,4,5)";
		}else{
			$where = "b.sh_status = ".$whether." and bi.stage = 0";
		}
		$Count = M('bg_info bi') ->join(C("DB_PREFIX")."business b on bi.info_id = b.info_id")
		                         ->where($where) 
		                         ->count();

    	$Page = getpage($Count,$num);

    	$resu['list'] = M('bg_info bi') ->join(C("DB_PREFIX")."business b on bi.info_id = b.info_id")
										->join(C("DB_PREFIX")."trade_company tc on bi.trade_id = tc.id")
										->join(C("DB_PREFIX")."tc_user tu on tc.id = tu.tc_id")
								        ->where($where)  
								        ->limit($Page->firstRow. ',' . $Page->listRows)
									    ->order("bi.create_time desc")
									    ->field("tu.user_name,tu.id,tc.name,bi.frame_number,b.sh_certificate_time,b.sh_car_procudure,b.sh_car_permit,b.sh_time_return,b.sh_return_record,b.sh_remarks,b.sh_status,bi.info_id,b.sh_ok_time,b.sh_xkz,b.sh_is_xkz,b.sh_bao,b.sh_bao_price")
									    ->select();
		
		$resu['page'] = $Page->show();

		if($resu){
			Logger("end call Business/sh_list_more code:1",  ZLC . date('Y-m-d') . " -business.log", true);
			return json_encode(array('code' => 1,'data' => $resu));
		}else{
			Logger("end call Business/sh_list_more code:-1",  ZLC . date('Y-m-d') . " -business.log", true);
			return json_encode(array('code' => -1,'data' => '未查到对应的数据'));
		}
	}
	
	/*
	  证书列表
	*/
	public function cdents(){
			$data=M('cdent')->select();
			if($data){
				return $data;
			}else{
				return '不存在证书信息';
			}
			

	}
	//
	/*修改  输号信息
	author：xuwb
	time：2016年6月30日11:05:28
	参数：------
	$arr_info：array('字段名' => '值')
	$info_id：报关信息id
	*/
	public function update_shmsg($arr_info,$info_id){
		// print_r($arr_info);
		
		Logger("begin call Business/update_shmsg " ,  ZLC . date('Y-m-d') . " -business.log", true);
		$check = $this ->is_null($info_id);
		if(!empty($check)){
			Logger("end call Business/update_shmsg code:-10",  ZLC . date('Y-m-d') . " -business.log", true);
			return $check;die;
		}

		foreach($arr_info as $key => $value){
			$data[$key] = $value;
		}
		$is_existed = M('business') ->where("info_id = ".$info_id) ->find();
		$last_infos = M('bg_info') ->where("info_id = ".$info_id) 
								   ->field("stage")
								   ->find();
		
		//有数据更新，没有添加
		if($is_existed){
			$resu = M('business') ->where("info_id = ".$info_id) ->save($data);
		}else{
			$data['info_id'] = $info_id;
			$resu = M('business') ->add($data);
		}
		 //echo M('business') ->getlastsql();die;

		$info = M('business') ->where("info_id = ".$info_id) 
		                      ->field("sh_status") 
		                      ->find();
		//如果输号已完成，则修改报关信息的阶段
		if($info['sh_status'] == 1){
			$update_info = M('bg_info') ->where("info_id = ".$info_id)
										->setField('stage',1);
		}
		$now_stage = M('bg_info') ->where("info_id = ".$info_id) 
								   ->field("stage")
								   ->find();
		
		
	    
		if($resu){
			Logger("end call Business/update_shmsg code:1",  ZLC . date('Y-m-d') . " -business.log", true);
			$logs = array('userName' => session('userName'),'info_id' => $info_id,'last_status' => $is_existed['sh_status'], 'last_stage' => $last_infos['stage'],'now_status' => $info['sh_status'], 'now_stage' => $now_stage['stage']);
			$this ->add_info_log($logs);
			return json_encode(array('code' => 1,'data' =>$arr_info));
		}else{
			Logger("end call Business/update_shmsg code:-1",  ZLC . date('Y-m-d') . " -business.log", true);
			return json_encode(array('code' => -1,'data' => '服务器错误'));
		}
	}
	/*到单 - 业务首页
	author：xuwb
	time：2016年6月30日14:18:15
	*/
	public function dd_list(){
		Logger("begin call Business/dd_list " ,  ZLC . date('Y-m-d') . " -business.log", true);

		$resu['ing'] = M('bg_info bi') ->join(C("DB_PREFIX")."business b on bi.									  info_id = b.info_id")
										->join(C("DB_PREFIX")."trade_company tc on bi.trade_id = tc.id")
										->join(C("DB_PREFIX")."tc_user tu on tc.id = tu.tc_id")
								        ->where("b.dd_status = 0 and bi.stage = 1")
									    ->order("bi.create_time desc")
									    ->limit(0,2)
									  
									    ->field("tc.name,bi.frame_number,b.sh_return_record,b.dd_bill_number,b.dd_nathan_time,b.dd_stenclied,b.dd_arrive_time,b.dd_change_time,b.dd_change_main_time,b.dd_status,b.dd_remarks,bi.info_id,b.dd_ok_time,b.dd_is_huan,tu.id,b.dd_ben_yi")
									    ->select();
		$resu['ok'] = M('bg_info bi') ->join(C("DB_PREFIX")."business b on bi.									  info_id = b.info_id")
										->join(C("DB_PREFIX")."trade_company tc on bi.trade_id = tc.id")
										->join(C("DB_PREFIX")."tc_user tu on tc.id = tu.tc_id")
								        ->where("b.dd_status = 1 and bi.stage in(1,2,3,4,5)")
									    ->order("bi.create_time desc")
									    ->limit(0,2)
									    ->field("tc.name,bi.frame_number,b.sh_return_record,b.dd_bill_number,b.dd_nathan_time,b.dd_stenclied,b.dd_arrive_time,b.dd_change_time,b.dd_change_main_time,b.dd_status,b.dd_remarks,bi.info_id,b.dd_ok_time,b.dd_is_huan,tu.id,b.dd_ben_yi")
									    ->select();

		if($resu){
			Logger("end call Business/dd_list code:1",  ZLC . date('Y-m-d') . " -business.log", true);
			return json_encode(array('code' => 1,'data' => $resu));
		}else{
			Logger("end call Business/dd_list code:-1",  ZLC . date('Y-m-d') . " -business.log", true);
			return json_encode(array('code' => -1,'data' => '未查到对应的数据'));
		}
	}
	/*到单 - 业务首页 - 更多
	author：xuwb
	time：2016年6月30日10:47:13
	参数： ------
	$whether：待处理传0，已完成的传1
	*/
	public function dd_list_more($whether,$num = 10){
		Logger("begin call Business/dd_list_more " ,  ZLC . date('Y-m-d') . " -business.log", true);
		if($whether == 1){
			$where = "b.dd_status = ".$whether." and bi.stage in(1,2,3,4,5)";
		}else{
			$where = "b.dd_status = ".$whether." and bi.stage = 1";
		}
		$Count = M('bg_info bi') ->join(C("DB_PREFIX")."business b on bi.									  info_id = b.info_id")
		                         ->where($where) 
		                         ->count();
    	$Page = getpage($Count,$num);

    	$resu['list'] = M('bg_info bi') ->join(C("DB_PREFIX")."business b on bi.									  info_id = b.info_id")
    									->join(C("DB_PREFIX")."trade_company tc on bi.trade_id = tc.id")
    									->join(C("DB_PREFIX")."tc_user tu on tc.id = tu.tc_id")
								        ->where($where)
								        ->limit($Page->firstRow. ',' . $Page->listRows)
									    ->order("bi.create_time desc")
									    ->field("tc.name,bi.frame_number,b.sh_return_record,b.dd_bill_number,b.dd_nathan_time,b.dd_stenclied,b.dd_arrive_time,b.dd_change_time,b.dd_change_main_time,b.dd_status,b.dd_remarks,bi.info_id,b.dd_ok_time,b.dd_is_huan,tu.id,b.dd_ben_yi")
									    ->select();
		$resu['page'] = $Page->show();
		if($resu){
			Logger("end call Business/dd_list_more code:1",  ZLC . date('Y-m-d') . " -business.log", true);
			return json_encode(array('code' => 1,'data' => $resu));
		}else{
			Logger("end call Business/dd_list_more code:-1",  ZLC . date('Y-m-d') . " -business.log", true);
			return json_encode(array('code' => -1,'data' => '未查到对应的数据'));
		}
	}
	/*修改  到单信息
	author：xuwb
	time：2016年6月30日15:03:45
	参数：------
	$arr_info：array('字段名' => '值')，注意：无换单信息勾选了dd_is_huandan=1,反之0
	$info_id：报关信息id
	*/

	public function update_ddmsg($arr_info,$info_id){

		 

		Logger("begin call Business/update_ddmsg " ,  ZLC . date('Y-m-d') . " -business.log", true);
		$check = $this ->is_null($info_id);
		if(!empty($check)){
			Logger("end call Business/update_ddmsg code:-10",  ZLC . date('Y-m-d') . " -business.log", true);
			return $check;die;
		}
		if($arr_info['dd_is_huandan'] == 1){
			$data['dd_huandan_time'] = strtotime(date('Y-m-d H:i:s'));
		}
		foreach($arr_info as $key => $value){
			$data[$key] = $value;
		}
		$is_existed = M('business') ->where("info_id = ".$info_id) ->find();
		$last_infos = M('bg_info') ->where("info_id = ".$info_id) 
								   ->field("stage")
								   ->find();
		//有数据更新，没有添加
		
		if($is_existed){
			$resu = M('business') ->where("info_id = ".$info_id) ->save($data);
		}else{
			$data['info_id'] = $info_id;
			$resu = M('business') ->add($data);
		}
		// echo M('business')->getlastsql();die;
		$info = M('business') ->where("info_id = ".$info_id) 
		                      ->field("dd_status") 
		                      ->find();
		//如果输号已完成，则修改报关信息的阶段
		if($info['dd_status'] == 1){
			$update_info = M('bg_info') ->where("info_id = ".$info_id)
										->setField('stage',2);
		}
		$now_stage = M('bg_info') ->where("info_id = ".$info_id) 
								   ->field("stage")
								   ->find();
		if($resu){
			Logger("end call Business/update_ddmsg code:1",  ZLC . date('Y-m-d') . " -business.log", true);
			$logs = array('userName' => session('userName'),'info_id' => $info_id,'last_status' => $is_existed['dd_status'], 'last_stage' => $last_infos['stage'],'now_status' => $info['dd_status'], 'now_stage' => $now_stage['stage']);
			$this ->add_info_log($logs);
			return json_encode(array('code' => 1));
		}else{
			Logger("end call Business/update_ddmsg code:-1",  ZLC . date('Y-m-d') . " -business.log", true);
			return json_encode(array('code' => -1,'data' => '服务器错误'));
		}
	}
	/*报检 - 业务首页
	author：xuwb
	time：2016年6月30日14:18:15
	*/
	public function bj_list(){
		Logger("begin call Business/bj_list " ,  ZLC . date('Y-m-d') . " -business.log", true);

		$resu['ing'] = M('bg_info bi') ->join(C("DB_PREFIX")."business b on bi.									  info_id = b.info_id")
										->join(C("DB_PREFIX")."trade_company tc on bi.trade_id = tc.id")
										->join(C("DB_PREFIX")."tc_user tu on tc.id = tu.tc_id")
								        ->where("b.bj_status = 0 and bi.stage = 2")
									    ->order("bi.create_time desc")
									    ->limit(0,2)
									    ->field("tc.name,bi.frame_number,b.sh_return_record,b.bj_3c_number,b.bj_contract,b.bj_people,b.bj_price,b.bj_factory,b.bj_permit,b.bj_issue_time,b.bj_is_check,b.bj_certificates,b.bj_status,bi.info_id,b.bj_remarks,bj_ymtime,b.bj_ok_time,b.bj_is_bao,bi.info_id,tu.id,b.sh_xkz")
									    ->select();
		 foreach ($resu['ing'] as $k => $v) {
		 	
		 	$resu['ing'][$k]['bj_certificates'] = $v['bj_certificates'];
		 	$str = $resu['ing'][$k]['bj_certificates'];
		 	$resu['ing'][$k]['bj_certificates'] = explode(",",$str);
		 }
		 
         
		//$resu['ing']['bj_price'] = $resu['ing']['bj_price']/100;
		$resu['ok'] = M('bg_info bi') ->join(C("DB_PREFIX")."business b on bi.									  info_id = b.info_id")
										->join(C("DB_PREFIX")."trade_company tc on bi.trade_id = tc.id")
										->join(C("DB_PREFIX")."tc_user tu on tc.id = tu.tc_id")
								        ->where("b.bj_status = 1 and bi.stage in(2,3,4,5)")
									    ->order("bi.create_time desc")
									    ->limit(0,2)
									    ->field("tc.name,bi.frame_number,b.sh_return_record,b.bj_3c_number,b.bj_contract,b.bj_people,b.bj_price,b.bj_factory,b.bj_permit,b.bj_issue_time,b.bj_is_check,b.bj_certificates,b.bj_status,bi.info_id,b.bj_remarks,bj_ymtime,b.bj_ok_time,b.bj_is_bao,bi.info_id,tu.id,b.sh_xkz")
									    ->select();
		 foreach ($resu['ok'] as $k => $v) {
		 	
		 	$resu['ok'][$k]['bj_certificates'] = $v['bj_certificates'];
		 	$str = $resu['ok'][$k]['bj_certificates'];
		 	$resu['ok'][$k]['bj_certificates'] = explode(",",$str);
		 	
		 }

		//$resu['ok']['bj_price'] = $resu['ok']['bj_price']/100;
		if($resu){
			Logger("end call Business/bj_list code:1",  ZLC . date('Y-m-d') . " -business.log", true);
			return json_encode(array('code' => 1,'data' => $resu));
		}else{
			Logger("end call Business/bj_list code:-1",  ZLC . date('Y-m-d') . " -business.log", true);
			return json_encode(array('code' => -1,'data' => '未查到对应的数据'));
		}
	}
	/*报检 - 业务首页 - 更多
	author：xuwb
	time：2016年6月30日10:47:13
	参数： ------
	$whether：待处理传0，已完成的传1
	*/
	public function bj_list_more($whether,$num = 10){
		Logger("begin call Business/bj_list_more " ,  ZLC . date('Y-m-d') . " -business.log", true);

		if($whether == 1){
			$where = "b.bj_status = ".$whether." and bi.stage in(2,3,4,5)";
		}else{
			$where = "b.bj_status = ".$whether." and bi.stage = 2";
		}
		$Count = M('bg_info bi') ->join(C("DB_PREFIX")."business b on bi.									  info_id = b.info_id")
		                         ->where($where) 
		                         ->count();
    	$Page = getpage($Count,$num);

    	$resu['list'] = M('bg_info bi') ->join(C("DB_PREFIX")."business b on bi.									  info_id = b.info_id")
    									->join(C("DB_PREFIX")."trade_company tc on bi.trade_id = tc.id")
    									->join(C("DB_PREFIX")."tc_user tu on tc.id = tu.tc_id")
								        ->where($where)
								        ->limit($Page->firstRow. ',' . $Page->listRows)
									    ->order("bi.create_time desc")
									    ->field("tc.name,bi.frame_number,b.sh_return_record,b.bj_3c_number,b.bj_contract,b.bj_people,b.bj_price,b.bj_factory,b.bj_permit,b.bj_issue_time,b.bj_is_check,b.bj_certificates,b.bj_status,bi.info_id,b.bj_remarks,bj_ymtime,b.bj_ok_time,b.bj_is_bao,bi.info_id,tu.id,b.sh_xkz")
									    ->select();
		//$resu['list']['bj_price'] = $resu['list']['bj_price']/100;
		$resu['page'] = $Page->show();
		if($resu){
			Logger("end call Business/bj_list_more code:1",  ZLC . date('Y-m-d') . " -business.log", true);
			return json_encode(array('code' => 1,'data' => $resu));
		}else{
			Logger("end call Business/bj_list_more code:-1",  ZLC . date('Y-m-d') . " -business.log", true);
			return json_encode(array('code' => -1,'data' => '未查到对应的数据'));
		}
	}
	/*修改  报检信息
	author：xuwb
	time：2016年6月30日15:03:45
	参数：------
	$arr_info：array('字段名' => '值')，注意：勾选了打保bj_is_dabao=1,反之0
	$info_id：报关信息id
	*/
	public function update_bjmsg($arr_info,$info_id){

		Logger("begin call Business/update_bjmsg " ,  ZLC . date('Y-m-d') . " -business.log", true);
		$check = $this ->is_null($info_id);
		if(!empty($check)){
			Logger("end call Business/update_bjmsg code:-10",  ZLC . date('Y-m-d') . " -business.log", true);
			return $check;die;
		}
		if($arr_info['bj_is_bao'] == 1){
			$data['bj_bao_time'] = strtotime(date('Y-m-d H:i:s'));
		}
		foreach($arr_info as $key => $value){
			$data[$key] = $value;
		}
		if(!empty($data['bj_price'])){
			$data['bj_price'] = $data['bj_price'] * 100;
		}
		$is_existed = M('business') ->where("info_id = ".$info_id) ->find();
		$last_infos = M('bg_info') ->where("info_id = ".$info_id) 
								   ->field("stage")
								   ->find();

		
		//证书列表部分更新
		if(!empty($arr_info['bj_certificates'])){
			$certificates = M('business')->where("info_id = ".$info_id)->getField('bj_certificates');
			$arr_certificates=explode(',',$certificates);
			if(!in_array($arr_info['bj_certificates'],$arr_certificates)){
				$certificates=$certificates.','.$arr_info['bj_certificates'];
				$resu = M('business')->where("info_id = ".$info_id)->save('bj_certificates',$certificates);
				return $resu;
			}else{
				foreach($certificates as  $k->$val)
					if($val==$arr_info['bj_certificates']){
						unset($certficates[$k]);						
					}
				$certficates=implode(',',$certficates);
				$resu = M('business')->where("info_id = ".$info_id)->save('bj_certificates',$certificates);
			}
		}
		
		//有数据更新，没有添加
		if($is_existed){
			$resu = M('business') ->where("info_id = ".$info_id) ->save($data);
			
		}else{
			$data['info_id'] = $info_id;
			$resu = M('business') ->add($data);
		

		}
		// echo  M('business')->getlastsql;	
		// 
		$info = M('business') ->where("info_id = ".$info_id) 
		                      ->field("bj_status") 
		                      ->find();
		//如果输号已完成，则修改报关信息的阶段
		if($info['bj_status'] == 1){
			$update_info = M('bg_info') ->where("info_id = ".$info_id)
										->setField('stage',3);
		}
		$now_stage = M('bg_info') ->where("info_id = ".$info_id) 
								   ->field("stage")
								   ->find();
		if($resu){
			Logger("end call Business/update_bjmsg code:1",  ZLC . date('Y-m-d') . " -business.log", true);
			$logs = array('userName' => session('userName'),'info_id' => $info_id,'last_status' => $is_existed['bj_status'], 'last_stage' => $last_infos['stage'],'now_status' => $info['bj_status'], 'now_stage' => $now_stage['stage']);
			$this ->add_info_log($logs);
			return json_encode(array('code' => 1));
		}else{
			Logger("end call Business/update_bjmsg code:-1",  ZLC . date('Y-m-d') . " -business.log", true);
			return json_encode(array('code' => -1,'data' => '服务器错误'));
		}
	}
	/*报关 - 业务首页
	author：xuwb
	time：2016年6月30日14:18:15
	*/
	public function bg_list(){

		Logger("begin call Business/bg_list " ,  ZLC . date('Y-m-d') . " -business.log", true);

		$resu['ing'] = M('bg_info bi') ->join(C("DB_PREFIX")."business b on bi.									  info_id = b.info_id")
										->join(C("DB_PREFIX")."trade_company tc on bi.trade_id = tc.id")
										->join(C("DB_PREFIX")."tc_user tu on tc.id = tu.tc_id")
								        ->where("b.bg_status = 0 and bi.stage = 3")
									    ->order("bi.create_time desc")
									    ->limit(0,2)
									    ->field("tc.name,bi.frame_number,b.sh_return_record,b.bg_number,b.bg_paper_price,b.bg_time,b.bg_hdmi_time,b.bg_atax_time,b.bg_paytax_time,b.bg_party_time,b.bg_receipt_time,b.bg_surveyor_time,b.bg_sjbk_time,b.bg_certificates,b.bg_status,b.bg_remarks,bi.info_id,bg_ok_time,bi.info_id,tu.id,b.bg_hz_name,b.bg_car_bb,b.bg_kefu")
									    ->select();
		foreach ($resu['ing'] as $k => $v) {
		 	
		 	$resu['ing'][$k]['bg_certificates'] = $v['bg_certificates'];
		 	$str = $resu['ing'][$k]['bg_certificates'];
		 	$resu['ing'][$k]['bg_certificates'] = explode(",",$str);
		 	
		 }
		$resu['ok'] = M('bg_info bi') ->join(C("DB_PREFIX")."business b on bi.									  info_id = b.info_id")
										->join(C("DB_PREFIX")."trade_company tc on bi.trade_id = tc.id")
										->join(C("DB_PREFIX")."tc_user tu on tc.id = tu.tc_id")
								        ->where("b.bg_status = 1 and bi.stage in(3,4,5)")
									    ->order("bi.create_time desc")
									    ->limit(0,2)
									    ->field("tc.name,bi.frame_number,b.sh_return_record,b.bg_number,b.bg_paper_price,b.bg_time,b.bg_hdmi_time,b.bg_atax_time,b.bg_paytax_time,b.bg_party_time,b.bg_receipt_time,b.bg_surveyor_time,b.bg_sjbk_time,b.bg_certificates,b.bg_status,b.bg_remarks,bi.info_id,bg_ok_time,bi.info_id,tu.id,b.bg_hz_name,b.bg_car_bb,b.bg_kefu")
									    ->select();
		foreach ($resu['ok'] as $k => $v) {
		 	
		 	$resu['ok'][$k]['bg_certificates'] = $v['bg_certificates'];
		 	$str = $resu['ok'][$k]['bg_certificates'];
		 	$resu['ok'][$k]['bg_certificates'] = explode(",",$str);
		 	
		 }

		if($resu){
			Logger("end call Business/bg_list code:1",  ZLC . date('Y-m-d') . " -business.log", true);
			return json_encode(array('code' => 1,'data' => $resu));
		}else{
			Logger("end call Business/bg_list code:-1",  ZLC . date('Y-m-d') . " -business.log", true);
			return json_encode(array('code' => -1,'data' => '未查到对应的数据'));
		}
	}
	/*报关 - 业务首页 - 更多
	author：xuwb
	time：2016年6月30日10:47:13
	参数： ------
	$whether：待处理传0，已完成的传1
	*/
	public function bg_list_more($whether,$num = 10){
		Logger("begin call Business/bg_list_more " ,  ZLC . date('Y-m-d') . " -business.log", true);

		if($whether == 1){
			$where = "b.bg_status = ".$whether." and bi.stage in(3,4,5)";
		}else{
			$where = "b.bg_status = ".$whether." and bi.stage = 3";
		}
		$Count = M('bg_info bi') ->join(C("DB_PREFIX")."business b on bi.									  info_id = b.info_id")
		                         ->where($where) 
		                         ->count();
    	$Page = getpage($Count,$num);

    	$resu['list'] = M('bg_info bi') ->join(C("DB_PREFIX")."business b on bi.									  info_id = b.info_id")
    									->join(C("DB_PREFIX")."trade_company tc on bi.trade_id = tc.id")
    									->join(C("DB_PREFIX")."tc_user tu on tc.id = tu.tc_id")
								        ->where($where)
								        ->limit($Page->firstRow. ',' . $Page->listRows)
									    ->order("bi.create_time desc")
									    ->field("tc.name,bi.frame_number,b.sh_return_record,b.bg_number,b.bg_paper_price,b.bg_time,b.bg_hdmi_time,b.bg_atax_time,b.bg_paytax_time,b.bg_party_time,b.bg_receipt_time,b.bg_surveyor_time,b.bg_sjbk_time,b.bg_certificates,b.bg_status,b.bg_remarks,bi.info_id,b.bg_ok_time,b.bg_hz_name,b.bg_car_bb,b.bg_kefu")
									    ->select();
		foreach ($variable as $key => $value) {
			# code...
		}
		//$resu['list']['bg_paper_price'] = $resu['list']['bg_paper_price']/100;
		$resu['page'] = $Page->show();
		if($resu){
			Logger("end call Business/bg_list_more code:1",  ZLC . date('Y-m-d') . " -business.log", true);
			return json_encode(array('code' => 1,'data' => $resu));
		}else{
			Logger("end call Business/bg_list_more code:-1",  ZLC . date('Y-m-d') . " -business.log", true);
			return json_encode(array('code' => -1,'data' => '未查到对应的数据'));
		}
	}
	/*修改  报关信息
	author：xuwb
	time：2016年6月30日15:03:45
	参数：------
	$arr_info：array('字段名' => '值')
	$info_id：报关信息id
	*/
	public function update_bgmsg($arr_info,$info_id){
		Logger("begin call Business/update_bgmsg " ,  ZLC . date('Y-m-d') . " -business.log", true);
		$check = $this ->is_null($info_id);
		if(!empty($check)){
			Logger("end call Business/update_bgmsg code:-10",  ZLC . date('Y-m-d') . " -business.log", true);
			return $check;die;
		}
		foreach($arr_info as $key => $value){
			$data[$key] = $value;
		}
		if(!empty($data['bg_paper_price'])){
			$data['bg_paper_price'] = $data['bg_paper_price'] * 100;
		}
		$is_existed = M('business') ->where("info_id = ".$info_id) ->find();
		$last_infos = M('bg_info') ->where("info_id = ".$info_id) 
								   ->field("stage")
								   ->find();
		//有数据更新，没有添加
		if($is_existed){
			$resu = M('business') ->where("info_id = ".$info_id) ->save($data);
		}else{
			$data['info_id'] = $info_id;
			$resu = M('business') ->add($data);
		}

		$info = M('business') ->where("info_id = ".$info_id) 
		                      ->field("bg_status") 
		                      ->find();
		//如果输号已完成，则修改报关信息的阶段
		if($info['bg_status'] == 1){
			$update_info = M('bg_info') ->where("info_id = ".$info_id)
										->setField('stage',4);
		}
		$now_stage = M('bg_info') ->where("info_id = ".$info_id) 
								   ->field("stage")
								   ->find();
		if($resu){
			Logger("end call Business/update_bgmsg code:1",  ZLC . date('Y-m-d') . " -business.log", true);
			$logs = array('userName' => session('userName'),'info_id' => $info_id,'last_status' => $is_existed['bg_status'], 'last_stage' => $last_infos['stage'],'now_status' => $info['bg_status'], 'now_stage' => $now_stage['stage']);
			$this ->add_info_log($logs);
			return json_encode(array('code' => 1));
		}else{
			Logger("end call Business/update_bgmsg code:-1",  ZLC . date('Y-m-d') . " -business.log", true);
			return json_encode(array('code' => -1,'data' => '服务器错误'));
		}
	}
	/*约上线 - 业务首页
	author：xuwb
	time：2016年6月30日14:18:15
	*/
	public function ysx_list(){
		Logger("begin call Business/ysx_list " ,  ZLC . date('Y-m-d') . " -business.log", true);

		$resu['ing'] = M('bg_info bi') ->join(C("DB_PREFIX")."business b on bi.									  info_id = b.info_id")
										->join(C("DB_PREFIX")."trade_company tc on bi.trade_id = tc.id")
										->join(C("DB_PREFIX")."tc_user tu on tc.id = tu.tc_id")
								        ->where("b.ysx_status = 0 and bi.stage = 4")
									    ->order("bi.create_time desc")
									    ->limit(0,2)
									    ->field("tc.name,bi.frame_number,b.sh_return_record,b.ysx_cib,b.ysx_address,b.ysx_shipper,b.ysx_online_time,b.ysx_vehicle_time,b.ysx_unboxing_time,b.ysx_backed_time,b.ysx_status,b.ysx_remarks,bi.info_id,b.ysx_ok_time,bi.info_id,tu.id")
									    ->select();
		$resu['ok'] = M('bg_info bi') ->join(C("DB_PREFIX")."business b on bi.									  info_id = b.info_id")
										->join(C("DB_PREFIX")."trade_company tc on bi.trade_id = tc.id")
										->join(C("DB_PREFIX")."tc_user tu on tc.id = tu.tc_id")
								        ->where("b.ysx_status = 1 and bi.stage in(4,5)")
									    ->order("bi.create_time desc")
									    ->limit(0,2)
									    ->field("tc.name,bi.frame_number,b.sh_return_record,b.ysx_cib,b.ysx_address,b.ysx_shipper,b.ysx_online_time,b.ysx_vehicle_time,b.ysx_unboxing_time,b.ysx_backed_time,b.ysx_status,b.ysx_remarks,bi.info_id,b.ysx_ok_time,bi.info_id,tu.id")
									    ->select();

		if($resu){
			Logger("end call Business/ysx_list code:1",  ZLC . date('Y-m-d') . " -business.log", true);
			return json_encode(array('code' => 1,'data' => $resu));
		}else{
			Logger("end call Business/ysx_list code:-1",  ZLC . date('Y-m-d') . " -business.log", true);
			return json_encode(array('code' => -1,'data' => '未查到对应的数据'));
		}
	}
	/*报关 - 约上线首页 - 更多
	author：xuwb
	time：2016年6月30日10:47:13
	参数： ------
	$whether：待处理传0，已完成的传1
	*/
	public function ysx_list_more($whether,$num = 10){
		Logger("begin call Business/ysx_list_more " ,  ZLC . date('Y-m-d') . " -business.log", true);

		if($whether == 1){
			$where = "b.ysx_status = ".$whether." and bi.stage in(4,5)";
		}else{
			$where = "b.ysx_status = ".$whether." and bi.stage = 4";
		}
		$Count = M('bg_info bi') ->join(C("DB_PREFIX")."business b on bi.									  info_id = b.info_id")
		                         ->where($where) 
		                         ->count();
    	$Page = getpage($Count,$num);

    	$resu['list'] = M('bg_info bi') ->join(C("DB_PREFIX")."business b on bi.									  info_id = b.info_id")
    									->join(C("DB_PREFIX")."trade_company tc on bi.trade_id = tc.id")
    									->join(C("DB_PREFIX")."tc_user tu on tc.id = tu.tc_id")
								        ->where($where)
								        ->limit($Page->firstRow. ',' . $Page->listRows)
									    ->order("bi.create_time desc")
									    ->field("tc.name,bi.frame_number,b.sh_return_record,b.ysx_cib,b.ysx_address,b.ysx_shipper,b.ysx_online_time,b.ysx_vehicle_time,b.ysx_unboxing_time,b.ysx_backed_time,b.ysx_status,b.ysx_remarks,bi.info_id,b.ysx_ok_time")
									    ->select();
		$resu['page'] = $Page->show();
		if($resu){
			Logger("end call Business/ysx_list_more code:1",  ZLC . date('Y-m-d') . " -business.log", true);
			return json_encode(array('code' => 1,'data' => $resu));
		}else{
			Logger("end call Business/ysx_list_more code:-1",  ZLC . date('Y-m-d') . " -business.log", true);
			return json_encode(array('code' => -1,'data' => '未查到对应的数据'));
		}
	}
	/*修改  约上线信息
	author：xuwb
	time：2016年6月30日15:03:45
	参数：------
	$arr_info：array('字段名' => '值')
	$info_id：报关信息id
	*/
	public function update_ysxmsg($arr_info,$info_id){
		Logger("begin call Business/update_ysxmsg " ,  ZLC . date('Y-m-d') . " -business.log", true);
		$check = $this ->is_null($info_id);
		if(!empty($check)){
			Logger("end call Business/update_ysxmsg code:-10",  ZLC . date('Y-m-d') . " -business.log", true);
			return $check;die;
		}
		foreach($arr_info as $key => $value){
			$data[$key] = $value;
		}
		// if(!empty($data['bg_paper_price'])){
		// 	$data['bg_paper_price'] = $data['bg_paper_price'] * 100;
		// }
		$is_existed = M('business') ->where("info_id = ".$info_id) ->find();
		$last_infos = M('bg_info') ->where("info_id = ".$info_id) 
								   ->field("stage")
								   ->find();

		//有数据更新，没有添加
		if($is_existed){
			$resu = M('business') ->where("info_id = ".$info_id) ->save($data);
		}else{
			$data['info_id'] = $info_id;
			$resu = M('business') ->add($data);
		}
		$info = M('business') ->where("info_id = ".$info_id) 
		                      ->field("ysx_status") 
		                      ->find();
		//如果输号已完成，则修改报关信息的阶段
		if($info['ysx_status'] == 1){
			$info_end['stage'] = 5;
			$info_end['status'] = 1;
			$info_end['finish_time'] = strtotime(date('Y-m-d H:i:s'));;
			$update_info = M('bg_info') ->where("info_id = ".$info_id)
										->save($info_end);
		}
		$now_stage = M('bg_info') ->where("info_id = ".$info_id) 
								   ->field("stage")
								   ->find();
		if($resu){
			Logger("end call Business/update_ysxmsg code:1",  ZLC . date('Y-m-d') . " -business.log", true);
			$logs = array('userName' => session('userName'),'info_id' => $info_id,'last_status' => $is_existed['ysx_status'], 'last_stage' => $last_infos['stage'],'now_status' => $info['ysx_status'], 'now_stage' => $now_stage['stage']);
			$this ->add_info_log($logs);
			return json_encode(array('code' => 1));
		}else{
			Logger("end call Business/update_ysxmsg code:-1",  ZLC . date('Y-m-d') . " -business.log", true);
			return json_encode(array('code' => -1,'data' => '服务器错误'));
		}
	}
	/*搜索
	author：xuwb
	time：2016年6月30日18:03:19*/
	public function business_search($cjh){
		Logger("begin call Businesssiness_search " ,  ZLC . date('Y-m-d') . " -business.log", true);
		$where['bi.frame_number']=array('like','%'.$cjh);
		// $where['bi.stage'] = $arr_exist['stage'];
    	$resu = M('bg_info bi') ->join(C("DB_PREFIX")."business b on bi.									  info_id = b.info_id")
								->join(C("DB_PREFIX")."trade_company tc on bi.trade_id = tc.id")
								->join(C("DB_PREFIX")."tc_user tu on tc.id = tu.tc_id")
						        ->where($where)
							    ->order("bi.create_time desc")
							    ->select();
		// echo M('bg_info bi') ->getlastsql();die;
		if($resu){
			Logger("end call Business/ysx_list_more code:1",  ZLC . date('Y-m-d') . " -business.log", true);
			return json_encode(array('code' => 1,'data' => $resu));
		}else{
			Logger("end call Business/ysx_list_more code:-1",  ZLC . date('Y-m-d') . " -business.log", true);
			return json_encode(array('code' => -1,'data' => '未查到对应的数据'));
		}
	}
	public function business_search_yw($arr){
		Logger("begin call Businesssiness_search " ,  ZLC . date('Y-m-d') . " -business.log", true);
		if($arr['stage'] == 0){
			$field = array('tu.user_name','tu.id,tc.name','bi.frame_number','b.sh_certificate_time','b.sh_car_procudure','b.sh_car_permit','b.sh_time_return','b.sh_return_record','b.sh_remarks','b.sh_status','bi.info_id');
		}elseif($arr['stage'] == 1){
			$field = array('tc.name','bi.frame_number','b.sh_return_record','b.dd_bill_number','b.dd_nathan_time','b.dd_stenclied','b.dd_arrive_time','b.dd_change_time','b.dd_change_main_time','b.dd_status','b.dd_remarks','bi.info_id');
		}elseif($arr['stage'] == 2){
			$field = array('tc.name','bi.frame_number','b.sh_return_record','b.bj_3c_number','b.bj_contract','b.bj_people','b.bj_price','b.bj_factory','b.bj_permit','b.bj_issue_time','b.bj_is_check','b.bj_certificates','b.bj_status','b.bj_remarks','bi.info_id');
		}elseif($arr['stage'] == 3){
			$field = array('tc.name','bi.frame_number','b.sh_return_record','b.bg_number','b.bg_paper_price','b.bg_time','b.bg_hdmi_time','b.bg_atax_time','b.bg_paytax_time','b.bg_party_time','b.bg_receipt_time','b.bg_surveyor_time','b.bg_sjbk_time','b.bg_certificates','b.bg_status','b.bg_remarks','bi.info_id');
		}elseif($arr['stage'] == 4){
			$field = array('tc.name','bi.frame_number','b.sh_return_record','b.ysx_cib','b.ysx_address','b.ysx_shipper','b.ysx_online_time','b.ysx_vehicle_time','b.ysx_unboxing_time','b.ysx_backed_time','b.ysx_status','b.ysx_remarks','bi.info_id');
		}
		$where['bi.frame_number']=array('like','%'.$arr['cjh']);
		$where['bi.stage'] = $arr['stage'];
    	$resu = M('bg_info bi') ->join(C("DB_PREFIX")."business b on bi.									  info_id = b.info_id")
								->join(C("DB_PREFIX")."trade_company tc on bi.trade_id = tc.id")
								->join(C("DB_PREFIX")."tc_user tu on tc.id = tu.tc_id")
						        ->where($where)
							    ->order("bi.create_time desc")
							    ->field($field)
							    ->select();
		// echo M('bg_info bi') ->getlastsql();die;
		if($resu){
			Logger("end call Business/ysx_list_more code:1",  ZLC . date('Y-m-d') . " -business.log", true);
			return json_encode(array('code' => 1,'data' => $resu));
		}else{
			Logger("end call Business/ysx_list_more code:-1",  ZLC . date('Y-m-d') . " -business.log", true);
			return json_encode(array('code' => -1,'data' => '未查到对应的数据'));
		}
	}
	/*点击贸易公司名称显示信息
	author：xuwb
	time：2016年7月1日10:09:46
	参数：------
	$cjh：车架号*/
	public function company_info($cjh){
		Logger("begin call Business/company_info " ,  ZLC . date('Y-m-d') . " -business.log", true);

		$resu = M('bg_info bi') ->join(C("DB_PREFIX")."trade_company tc on bi.									  trade_id = tc.id")
								->join(C("DB_PREFIX")."tc_user tu on tu.					tc_id = tc.id")
		                        ->where("bi.frame_number = '".$cjh."' and tu.is_admin = 1")
		                        ->field("tc.name,tc.legal_person,tu.user_name")
							    ->find();
		// echo M('bg_info bi')->getlastsql();die;
		if($resu){
			Logger("end call Business/company_info code:1",  ZLC . date('Y-m-d') . " -business.log", true);
			return json_encode(array('code' => 1,'data' => $resu));
		}else{
			Logger("end call Business/company_info code:-1",  ZLC . date('Y-m-d') . " -business.log", true);
			return json_encode(array('code' => -1,'data' => '未查到对应的数据'));
		}
	}
	/*点击车架号显示信息
	author：xuwb
	time：2016年7月1日10:09:46
	参数：------
	$cjh：车架号*/
	public function cjh_info($cjh){
		Logger("begin call Business/cjh_info " ,  ZLC . date('Y-m-d') . " -business.log", true);

		$resu = M('bg_info bi') ->join(C("DB_PREFIX")."car_configure cc on bi.									  info_id = cc.info_id")
		                        ->where("bi.frame_number = '".$cjh."'")
		                        ->field("group_concat(cc.name) as name,bi.product_name,bi.producer,bi.color,bi.brand,bi.kinds,bi.price,bi.frame_number,bi.level,bi.number_seats,bi.size,bi.production_date,bi.engine_number")
							    ->find();
		// echo M('bg_info bi')->getlastsql();die;
		if($resu){
			Logger("end call Business/cjh_info code:1",  ZLC . date('Y-m-d') . " -business.log", true);
			return json_encode(array('code' => 1,'data' => $resu));
		}else{
			Logger("end call Business/cjh_info code:-1",  ZLC . date('Y-m-d') . " -business.log", true);
			return json_encode(array('code' => -1,'data' => '未查到对应的数据'));
		}
	}
	/*验证参数是否为空 
	author：xuwb
	time：2016年6月30日11:37:48
	*/
	public function is_null($info_id){
		if(empty($info_id)){
			return json_encode(array('code' => -10,'data' => '报关信息id为空'));die;
		}
	}
	/*添加业务日志类 
	author：xuwb
	time：2016年6月24日10:30:04
	------
	$message：数值
	$info：说明信息*/
	public function add_info_log($info){
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
	/*首页数据 
	
	------
	*/
	public function index($num = 10){


		
		
		Logger("begin call Manager/detail " ,  ZLC . date('Y-m-d') . " -manager.log", true);

		$Count = M('bg_info')
		                     ->count();
    	$Page = getpage($Count,$num);
		
		$resu['list'] = M('bg_info bi') ->join(C("DB_PREFIX")."business b on bi.info_id = b.info_id")
								        ->limit($Page->firstRow. ',' . $Page->listRows)
								        ->where("bi.status = 0")
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
}