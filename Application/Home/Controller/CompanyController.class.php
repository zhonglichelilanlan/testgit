<?php
namespace Home\Controller;
use Think\Controller;
class CompanyController extends CommonController {
	
  /**公司列表**/
  public  function  index(){ 
  $token = session('token');
  
  $power = new \Home\Model\admins\BaoguanModel();
  $powers = $power->company_member($token);      
  $result = json_decode($powers,true);
  $this ->assign("list",$result['data']['list']);
  $this ->assign("page",$result['data']['page']);

  $this->display();
  }

  /**公司资料**/
  public function company(){ 
  $token = session('token');
  $power = new \Home\Model\admins\BaoguanModel();
  $powers = $power->company_msg($token);      
  $result = json_decode($powers,true);
  $this ->assign("list",$result['data']); 
 
  $this->display();  
  }
  /**修改公司**/
  public function edit(){ 
  //获取角色列表
  $did =$_GET;
  $id = $did['did'];
  $role = new \Home\Model\admins\BaoguanModel();
  $roles = $role->user_infomation($id);
  $list = json_decode($roles,true);
  
  
  $roleh = $role->role_list();
  $roless = json_decode($roleh,true);
  $this ->assign("roless",$roless['data']);
  
  $this ->assign("list",$list['data']);  
  $this->display();  
  

  }
  /**添加公司**/
  public function add(){
  //获取角色列表
  $role = new \Home\Model\admins\BaoguanModel();
  $roles = $role->role_list();
  $list = json_decode($roles,true);
  $this ->assign("list",$list['data']);  
  $this->display();

  }


  public function update(){ 

  //获取角色列表
  $token = session('token');
     //add  
  $arr_msg =$_POST;
  
  $arr_msg['token'] =$token;
  $power = new \Home\Model\admins\BaoguanModel();
  $powers = $power->update_user($arr_msg);

  
  echo $powers;
  }

  public function insert(){ 
  
  $token = session('token');
     //add  
  $arr_msg =$_POST;
  $arr_msg['token'] =$token;
  $power = new \Home\Model\admins\BaoguanModel();
  $powers = $power->add_user($arr_msg); 

  echo $powers;

  }
  public function delete(){ 
  
 
     //add  
  $id =$_POST['id'];
  $power = new \Home\Model\admins\BaoguanModel();
  $powers = $power->delete_user($id); 

  echo $powers;

  }
}