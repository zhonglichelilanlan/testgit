<?php
namespace Home\Controller;
use Think\Controller;
class RoleController extends CommonController {

    /*
    *权限列表
    *Zyl
    *2016年6月29日11:03:19
    */
    public function role(){ 


        //权限列表
        $power = new \Home\Model\admins\BaoguanModel();
        $powers = $power->per_list();
        $result = json_decode($powers,true);
        $list = $result['data'];
        $this->assign("list",$list['list']);
        $this->assign("info",$list['lists']);  
        //角色列表
        $list = $power->role_list();
        $roles = json_decode($list,true);
        $role = $roles['data'];
        $this->assign("role",$role);
        
        $this->display();


    
    }
    /*
    *根据角色id去查询相对应的角色权限
    *ZYL 2016年6月29日13:25:49
    */
    
    public  function select(){ 



        
     //角色列表
    $select = new \Home\Model\admins\BaoguanModel();
    $list = $select->role_list();
    $roles = json_decode($list,true);
    $role = $roles['data'];
    $this->assign("role",$role);            
     //根据角色id去查询相对应的角色权限
     $did = $_GET;    
     $id =$did['did'];     
     $selects = $select->bg_update_role($id);   
     $type = json_decode($selects,true);
     $list2 = $type['data'];
       // print_r($list2);
     $this->assign("list",$list2['list']);
     $this->assign("pers",$list2['lists']); 

     $this->display();

    }
    public function update(){ 

     $arr_role=$_POST;

     $str = $arr_role['pre_id'];
     $arr_role['pre_id'] = explode(",",$str);
     $select = new \Home\Model\admins\BaoguanModel();
     $list = $select->bg_role($arr_role);
     echo  $list;

    }
    
    /*public  function update(){ 



      
     //角色列表
    $select = new \Home\Model\admins\BaoguanModel();
    $list = $select->role_list();
    $roles = json_decode($list,true);
    $role = $roles['data'];
    $this->assign("role",$role);            
     //根据角色id去查询相对应的角色权限
     $did = $_GET;    
     $id =$did['did'];     
     $selects = $select->bg_update_role($id);   
     $type = json_decode($selects,true);
     $list = $type['data'];   
     $this->assign("list",$list['list']);
     $this->assign("lists",$list['lists']); 

     $this->display();

    }*/




     

     public function logs(){ 


        
        $logs = new \Home\Model\admins\BaoguanModel();
        $value = $logs->caozuo_logs();
        $result = json_decode($value,true);
        $results = $result['data'];
         
        $this->assign("list",$results); 
       
        $this->display();
    }









    /*/*
    *添加角色
    参数：------
    $arr_message['model']：角色表

    */
    public function add(){ 


        
        $purview = new \Home\Model\ZlcbaoguanModel();
        $add = $purview->per_list();
        $results = json_decode($add,true);
        $result = $results['data'];
        $this->assign("list",$result); 
        
        $this->display();
    
    }
    /*添加角色并分配权限 ---
    author：xuwb
    time：2016年6月20日16:24:07
    参数：------
    $arr_message['model']：角色表
    $arr_message['model_role']：角色权限关联表
    $arr_message['name']：角色名称
    $arr_message['perm_id']：所拥有的权限id（array）
    
    */
    public function insert(){ 


        $insert =$_POST;
        
        $arr_message['model'] ='admin_role';
        $arr_message['model_role'] ='admin_role_permissions';
        $arr_message['name'] =$insert['name'];
        $arr_message['perm_id'] =$insert['add'];
        $arr_message['role_id'] =$insert['app'];

        $purview = new \Home\Model\RbacModel();
        $add = $purview->role_perm($arr_message);

        
        $this->display('purview');
    
    }
    /*部门管理 --删除-
    author：zhangyl
    time：2016年6月21日16:26:26
    $model：数据库表
    $id：公司id
    */
    public function delete(){ 

    $r_id = $_POST['id'];
   
    $model = 'admin_role';
    

    $baoguan = new \Home\Model\RbacModel();
    $result = $baoguan->knew_delete_role($model,$r_id);

    // $a = json_decode($result,true);  
    echo $result;

    }

    //修改权限
    public function edit(){ 
        $ids=$_GET;
        $id =$ids['did'];
       
        $purview = new \Home\Model\ZlcbaoguanModel();
        //查询全部
        $add = $purview->per_list();
        $resultss = json_decode($add,true);
        $resulth = $resultss['data'];
        $this->assign("resulth",$resulth);
        //查询已经选择的
        $adds = $purview->edit_list($id);
        $results = json_decode($adds,true);
        $result = $results['data'];
        $this->assign("list",$result); 
        
        
        
        
       
        $this->display();

    }
   // public function update(){ 


   //      $insert =$_POST;
        
   //      $arr_message['model'] ='admin_role';
   //      $arr_message['model_role'] ='admin_role_permissions';
   //      $arr_message['name'] =$insert['name'];
   //      $arr_message['perm_id'] =$insert['add'];
   //      $arr_message['role_id'] =$insert['app'];

   //      $purview = new \Home\Model\RbacModel();
   //      $add = $purview->role_perm($arr_message);

        
   //      $this->display('purview');
    
   //  }


}
public function lilanlan(){
	echo "lilanaln";
}
?>