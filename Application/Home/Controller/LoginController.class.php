<?php
namespace Home\Controller;
use Think\Controller;
class LoginController extends Controller {

/*
*登录界面
*Zyl

*/
public function login(){        
    $this->display();
}
/*
*登录参数
*mobile 姓名
*password 密码
*/
public function verify_c(){  
    $Verify = new \Think\Verify();  
    $Verify->fontSize = 18;  
    $Verify->length   = 4;  
    $Verify->useNoise = false;  
    $Verify->codeSet = '0123456789';  
    $Verify->imageW = 130;  
    $Verify->imageH = 50;  
    //$Verify->expire = 600;  
    $Verify->entry();  
}
public function login_for(){
    
     $login = $_POST;

     $user_name = $login['user_name'];
     $pwd = $login['password'];
     $code = $login['code'];
     $baoguan = new \Home\Model\admins\BaoguanModel();
     $result = $baoguan->login($user_name,$pwd,$code);
     $userid = json_decode($result,true);
     /**session存储 userid;账号**/
     /*session('userId',$userid['data']);
     session('mobile',$mobile);
     */  
          
     echo $result;

    
}


public function logout(){ 
    session(null); 
    // echo "<script>alert('退出成功！');</script>";
    $this->redirect("Home/Login/login");die;  
}



}
?>