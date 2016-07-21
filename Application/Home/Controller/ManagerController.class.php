<?php
namespace Home\Controller;
use Think\Controller;
class ManagerController extends CommonController {
	
  /**客户经理首页**/
  public  function  index(){ 
  
  
  $power = new \Home\Model\manager\ManagerModel();
  $powers = $power->manager_index();      
  $result = json_decode($powers,true);
  $this ->assign("list",$result['data']['list']);
  $this ->assign("page",$result['data']['page']);
  $this->display();
  }
  //添加贸易公司

  public function insert(){ 
  


  $baoguan = new \Home\Model\manager\ManagerModel();
  $logo['logo'] = $baoguan->upload();

  // $img_logo =  substr($logo['logo'],0);
  
  $paths = unserialize($logo['logo']);
  // $path =  substr($paths[0],2);
  
  echo '<div class="div_img"><img src="/Public/images/xinzeng1.png" class="delete_715" onclick="de_(this)" ><input type="file" src="'.$paths.'" name="photoimg[]" style="display:none;"><img src="'.IMAGE."/".$paths.'"  class="preview" path="'.$paths.'"></div>';  
  $arr_cbmsg[] =$img_logo;
 
  //foreach($arr_cbmsg as $k=>$v){

  //  $arr_cbmsg[$k]['logo'] = $v;
     
  //}
  //print_r($arr_cbmsg);die;
  //if($arr_cbmsg['add_id'] == 1){

  //$power = new \Home\Model\manager\ManagerModel();
  //$powers = $power->com_add($arr_cbmsg); 
  
 // }

  //add  
  
 
  echo $powers;

  }
  //bianjimaoyigongsi
  public function del_photo(){

   if($_POST['id']){
    $datas=array($_POST['id'],$_POST['photoimg_']);
    $photos = M('trade_company')->where($datas)->getField('logo');
    $photos = implode(',',unserialize($photos));
    foreach($photos as $key=>$val){
      if($val=$_POST['photoimg_']){
        unset($photos['$key']);
      }

    $photos = M('trade_company')->where($photos)->save($photos); 
    echo $photos;
    }
   }else{
   
    $photoimg =$_POST['photoimg_'];

    // print_r($photoimg);die;
    if(@unlink(IMG."/".$photoimg)){
     echo json_encode(array('code' => 1,'data' => '删除成功'));
    }else{
     echo  json_encode(array('code' => 0,'data' => '删除失败'));
    }; 
    
   }   
  }
  //tianjiamaoyigongsi
  public function add_conpy(){

   
    
    
    $arr_cbmsg = $_POST;
   
    $arr_cbmsg['logo'] = serialize($arr_cbmsg['photoimg_']);
    $power = new \Home\Model\manager\ManagerModel();
    $powers = $power->com_add($arr_cbmsg);

    echo $powers;
   
  }
  //贸易公司
  public function mylist(){ 

  $power = new \Home\Model\manager\ManagerModel();
  $powers = $power->trad_company_list();      
  $result = json_decode($powers,true);
  $this ->assign("list",$result['data']['list']);
  $this ->assign("page",$result['data']['page']);
  
  $this->display();


  }

  //添加报关信息
  public function addbg(){ 
  $power = new \Home\Model\manager\ManagerModel();
  $powers = $power->trad_company_list();      
  $result = json_decode($powers,true);
  $this ->assign("list",$result['data']['list']);  
  $this->display();


  }
  //添加报关信息
  public function inserts(){ 
  header("Content-type:text/html;charset=utf-8");
  $arr_declare =$_POST;
   
  $str = $arr_declare['configure'];
  $arr_declare['configure'] = explode(",",$str);
  
  //add  
  $baoguan = new \Home\Model\manager\ManagerModel();
  $powers = $baoguan->add_declare($arr_declare);

  echo $powers;
 

  }

   /**修改公司**/
  public function edit(){ 
  //获取角色列表
  $did =$_GET;
  $id = $did['did'];
  $role = new \Home\Model\manager\ManagerModel();
  $roles = $role->com_infomation($id);
            
  $list = json_decode($roles,true);
  $list['logoh']=unserialize($list['data']['logo']);
  $list['logos'] = explode(',',$list['logoh']);
  
  $str='';

  foreach ($list['logos'] as $key => $val) {
    if($val == ''){
    
    }else{

    $str.= '<div class="div_img"><img src="/Public/images/xinzeng1.png" class="delete_715" onclick="de_(this)" ><input type="file" src="'.$val.'" name="photoimg[]" style="display:none;"><img src="'.IMAGE."/".$val.'"  class="preview" path="'.$val.'"></div>';  
    }  
  }
 
  $list['data']['logo']=$str;

  $this ->assign("str",$str);  
  $this ->assign("list",$list['data']);  
  $this->display();  

  }

  public function editbg(){ 
  //获取角色列表
   $did =$_GET;
   $id = $did['did'];
  
   $power = new \Home\Model\manager\ManagerModel();
   $powers = $power->trad_company_list();

   $result1 = json_decode($powers,true);
   $this ->assign("pert",$result1['data']['list']);
   $powerh = new \Home\Model\manager\ManagerModel();
   $powersh = $powerh->trad_company_list();

   $result = json_decode($powersh,true);
   $this ->assign("did",$id);
   $this ->assign("list",$result['data']['list']);

   $this->display();
  
  
 
  
 
 
  

  }
  /**公司资料**/
  public function company(){ 
  $token = session('token');
  $power = new \Home\Model\admins\BaoguanModel();
  $powers = $power->manager_index($token);      
  $result = json_decode($powers,true);
  $this ->assign("list",$result['data']); 
  
  $this->display();  
  }
 
  /**添加公司**/
  /*public function addbg(){
  //获取角色列表
  $role = new \Home\Model\admins\BaoguanModel();
  $roles = $role->role_list();
  $list = json_decode($roles,true);
  $this ->assign("list",$list['data']);  
  $this->display();

  }*/


  public function update(){ 

  //获取角色列表
  
  
 $arr_trad =$_POST;
  $token = session('token');
     //add
  
 
  
  $arr_trad['logo'] = serialize($arr_trad['photoimg_']);

  $power = new \Home\Model\manager\ManagerModel();
  $powers = $power->update_trad($arr_trad);

  
  echo $powers;
  }

  /*public function insert(){ 
  
  $token = session('token');
     //add  
  $arr_msg =$_POST;
  $arr_msg['token'] =$token;
  $power = new \Home\Model\admins\BaoguanModel();
  $powers = $power->add_user($arr_msg); 

  echo $powers;

  }*/
  public function delete(){ 
  
  
     //add  
  $id =$_POST['id'];
  $power = new \Home\Model\admins\BaoguanModel();
  $powers = $power->delete_user($id); 

  echo $powers;

  }
  public function complete(){
  $did =$_GET;
  $trade_id = $did['did'];
  $whether =1;  
  $power = new \Home\Model\manager\ManagerModel();
  $powers = $power->detail($trade_id,$whether);      
  $result = json_decode($powers,true);
  $this ->assign("list",$result['data']['list']);
  $this ->assign("page",$result['data']['page']);
  
  $this->display();

  }
  public function notcomplete(){
  $did =$_GET;
  $trade_id = $did['did'];  
  $whether =0;  
  $power = new \Home\Model\manager\ManagerModel();
  $powers = $power->detail($trade_id,$whether);
  $result = json_decode($powers,true);

        
  $this ->assign("list",$result['data']['list']);
  $this ->assign("page",$result['data']['page']);
  
  $this->display();

  }
  public function delete_com(){
      $id =$_POST['id'];
      $power = new \Home\Model\manager\ManagerModel(); 
      $powers = $power->delete_trad($id); 

      echo $powers;
  }
}