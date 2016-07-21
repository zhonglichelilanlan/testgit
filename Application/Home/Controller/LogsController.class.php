<?php
namespace Home\Controller;
use Think\Controller;
class LogsController extends CommonController {

     public function logs(){ 


    	//操作日志
    	$logs = new \Home\Model\admins\BaoguanModel();
        $value = $logs->caozuo_logs();
        $result = json_decode($value,true);

        //分页
        $this ->assign("list",$result['data']['list']);
        $this ->assign("page",$result['data']['page']);
        $this ->display('index');
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
   public function update(){ 


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


}
?>