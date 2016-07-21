<?php
namespace Home\Controller;
use Think\Controller;
class CommonController extends Controller {
  public function _initialize(){
        
         
       


       $header = new \Home\Model\admins\BaoguanModel();
       $result = $header->index();
       $headers = json_decode($result,true);
       //获得所有对应的权限列表
        $token =session('token');
        $list = new \Home\Model\admins\BaoguanModel();
        $result = $list->power($token);

        $lists = json_decode($result,true);
        // print_r($lists['data']['ci']);die;
        $this->assign('lists',$lists['data']['zhu']);
        $this->assign('infos',$lists['data']['ci']);
        $user_name = session(userName);
        $this->assign('user_name',$user_name);
      //验证token 如果token不存在则退出登录界面
      if($headers['code'] != 1){ 

        session(null); 
        $this->redirect("Home/Login/login");die;
      } 
            
            
            $path_info = $_SERVER['PATH_INFO'];
            $path_info_arr = explode('/',$path_info);
            $this->assign('path_info',$path_info);
            $this->assign('action_names',$path_info_arr[1]);  
        /*if($userId){ 


       $user_id = $userId;
       $baoguan = new \Home\Model\ZlcbaoguanModel();
       $result = $baoguan->is_purview($user_id);
       $left = json_decode($result,true);

       $results = $left['data'];

       $url =''.JDCK.'thinkphp/Home/';
       $this->assign("url",$url);
       $this->assign("list",$results);
        
       
       }*/
   
       
       /* if (empty($_SERVER['PATH_INFO'])) {
               
            $this->assign('action_names','index');

        }else{

            $path_info = $_SERVER['PATH_INFO'];
            $path_info_arr = explode('/',$path_info);
            
            $this->assign('action_names',$path_info_arr[1]);

        }*/
      
      
      //友情链接
        
      
  }
   
}