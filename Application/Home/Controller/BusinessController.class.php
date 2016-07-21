<?php
namespace Home\Controller;
use Think\Controller;
class BusinessController extends CommonController {


   /*输号 - 业务首页
    author：Zly
    time：2016年6月30日09:45:40
    */
    public function index(){

         $power = new \Home\Model\business\BusinessModel();
        $powers = $power->index();      
        $result = json_decode($powers,true);
        $global['shuhao'] = M('bg_info bi') ->join(C("DB_PREFIX")."business b on bi.info_id = b.info_id")
                                  ->where("bi.stage = 0 and b.sh_status = 0")
                                  ->count();
        $global['daodan'] = M('bg_info bi') ->join(C("DB_PREFIX")."business b on bi.info_id = b.info_id")
                                  ->where("bi.stage = 1 and b.dd_status = 0")
                                  ->count();
        $global['baojian'] = M('bg_info bi') ->join(C("DB_PREFIX")."business b on bi.info_id = b.info_id")
                                  ->where("bi.stage = 2 and b.bj_status = 0")
                                  ->count();
        $global['baoguan'] = M('bg_info bi') ->join(C("DB_PREFIX")."business b on bi.info_id = b.info_id")
                                  ->where("bi.stage = 3 and b.bg_status = 0")
                                  ->count();
        $global['ysx'] = M('bg_info bi') ->join(C("DB_PREFIX")."business b on bi.info_id = b.info_id")
                                  ->where("bi.stage = 4 and b.ysx_status = 0")
                                  ->count();
        $global['wc'] = M('bg_info bi') ->join(C("DB_PREFIX")."business b on bi.info_id = b.info_id")
                                  ->where("bi.stage = 5")
                                  ->count();
        $this ->assign("list",$result['data']['list']);
        $this ->assign("global",$global);
        $this ->assign("page",$result['data']['page']);
        $this->display();
       
    }
    //输号
    public function shuhao(){
        if($_POST['search_cjh'] != ''){
            $arr['cjh'] = $_POST['search_cjh'];
            $arr['stage'] = $_POST['stage'];
            $model = new \Home\Model\business\BusinessModel();
            $info = $model->business_search_yw($arr);
            $result = json_decode($info,true);
            if($result['code'] == -1){
                $this->assign("cjh",$arr['cjh']);
                $this->display('sousuo_ null');
            }else{
                $this ->assign("list",$result['data']);
                $this->display('sh_search');
            }
            
        }else{
            $power = new \Home\Model\business\BusinessModel();
         
            //逻辑
            $powers = $power->sh_list();      
            $result = json_decode($powers,true);
            // print_r($result);die;
            $this ->assign("list",$result['data']['ing']);
            $this ->assign("resuy",$result['data']['ok']);
            $this->display();
        }
    }
    //查询
    public function slshuhao(){
         $ids=$_POST;
         $id =$ids['id'];
         $power = new \Home\Model\business\BusinessModel();
         $powers = $power->sh_lists($id);      
         
         
        
         
         echo $powers;
        
    }
    //测试暂时保留
    /*public function shuhaosss(){
         $arr_exist['cjh'] ="22222";
         $arr_exist['stage'] ="0";
        
         $power = new \Home\Model\business\BusinessModel();
         $powers = $power->business_search($arr_exist);      
         $result = json_decode($powers,true);
         print_r($result);die;
         
        
         
         echo $powers;
        
    }*/
    //查询

    public function slshuhaos(){
         $ids=$_POST;
         $id =$ids['id'];
         $dids =$ids['did'];

         $power = new \Home\Model\business\BusinessModel();
         if($dids == "qufen_2"){
         $powers = $power->sh_listss($id);      
         }else{ 

        $powers = $power->sh_listswc($id);
       
         }   
         
        
         
         echo $powers;
        
    }
    //更新
    public function update(){
         $arr_info=$_POST;
         
         $qufen = $arr_info['qufen'];
         $name = $arr_info['name'];//字段名
         $zhi = $arr_info['zhi'];//获取前台的值
         $arr_info[$name] = $name;//字段名
         $arr_info[$name] = $zhi;//获取前台的值
         
         $is_date = strtotime($arr_info[$name])?strtotime($arr_info[$name]):false;//判断是否是日期
        if($is_date===false){
        
         
          $arr_info[$name] = $zhi;//获取前台的值
          
         }
         else{
          
          $arr_info[$name] = strtotime($zhi);//只要提交的是合法的日期，这里都统一成2014-11-11格式
         
         }
         if($arr_info[$name] == 1){

           $arr_info['sh_ok_time'] =time();
        }   
         /**销毁业务处理**/
         unset($arr_info['name']);//销毁字段名
         unset($arr_info['zhi']);//销毁获取前台的值
         unset($arr_info['qufen']);//判断是未完成还是已完成  
         
         
         
        
         $info_id = $arr_info['id'];
         
         $power = new \Home\Model\business\BusinessModel();
         $powers = $power->update_shmsg($arr_info,$info_id);

         echo $powers;

        
    }  
    //输号 更多 未完成
    public function sh_1(){

        
        
         

          $whether = 0;      
         //逻辑
          
         $power = new \Home\Model\business\BusinessModel();
         $powers = $power->sh_list_more($whether);
         $result = json_decode($powers,true);

         $this ->assign("list",$result['data']['list']);
         $this ->assign("page",$result['data']['page']);
         $this->display();
   }
    //输号 更多 已完成
    public function sh_2(){

        
         $whether = 1;      
         //逻辑 
         $power = new \Home\Model\business\BusinessModel();
         $powers = $power->sh_list_more($whether);
         $result = json_decode($powers,true);
         // print_r($result);die;
         $this ->assign("list",$result['data']['list']);
         $this ->assign("page",$result['data']['page']);
         
         $this->display();
        
    }

    /*到单 - 业务首页
    author：Zly
    time：2016年6月30日09:45:40
    */
    public function daodan(){
        if($_POST['search_cjh'] != ''){
            $arr['cjh'] = $_POST['search_cjh'];
            $arr['stage'] = $_POST['stage'];
            $model = new \Home\Model\business\BusinessModel();
            $info = $model->business_search_yw($arr);
            $result = json_decode($info,true);
            if($result['code'] == -1){
                $this->assign("cjh",$arr['cjh']);
                $this->display('sousuo_ null');
            }else{
                $this ->assign("list",$result['data']);
                $this->display('dd_search');
            }
        }else{
            $power = new \Home\Model\business\BusinessModel();
            $powers = $power->dd_list();      
            $result = json_decode($powers,true);
            // print_r($result);die;
            $this ->assign("list",$result['data']['ing']);
            $this ->assign("infoo",$result['data']['ok']);
            $this->display();
        }
        
    }
    //更新到单
    public function updd(){
         $arr_info=$_POST;
         
         $qufen = $arr_info['qufen'];
         $name = $arr_info['name'];//字段名
         $zhi = $arr_info['zhi'];//获取前台的值
         $arr_info[$name] = $name;//字段名
         $arr_info[$name] = $zhi;//获取前台的值 
         $is_date = strtotime($arr_info[$name])?strtotime($arr_info[$name]):false;
        
        if($is_date===false){
        
         
          $arr_info[$name] = $zhi;//获取前台的值
         
         }
         else{
          
          $arr_info[$name] = strtotime($zhi);//只要提交的是合法的日期，这里都统一成2014-11-11格式
         
         }
         if($arr_info[$name] == 1){              //判断是否是已完成

           $arr_info['dd_ok_time'] =time();
         }   
         /**销毁业务处理**/
         unset($arr_info['name']);//销毁字段名
         unset($arr_info['zhi']);//销毁获取前台的值
         unset($arr_info['qufen']);//判断是未完成还是已完成  
         
         
      
         $info_id=$arr_info['id'];

         $power = new \Home\Model\business\BusinessModel();
         $powers = $power->update_ddmsg($arr_info,$info_id);  

         echo $powers;
        
    }
    //到单 更多 未完成
    public function db_1(){

        
        
         

          $whether = 0;      
         //逻辑
          
         $power = new \Home\Model\business\BusinessModel();
         $powers = $power->dd_list_more($whether);
         $result = json_decode($powers,true);
       
         $this ->assign("list",$result['data']['list']);
         $this ->assign("page",$result['data']['page']);
         $this->display();
    }
    //到单 更多 已完成
    public function db_2(){

        
         $whether = 1;      
         //逻辑 
         $power = new \Home\Model\business\BusinessModel();
         $powers = $power->dd_list_more($whether);
         $result = json_decode($powers,true);

         $this ->assign("list",$result['data']['list']);
         $this ->assign("page",$result['data']['page']);
         
         $this->display();
        
    }

    /*报检 - 业务首页
    author：Zly1
    time：2016年6月30日09:45:40
    */
    public function baojian(){
        if($_POST['search_cjh'] != ''){
            $arr['cjh'] = $_POST['search_cjh'];
            $arr['stage'] = $_POST['stage'];
            $model = new \Home\Model\business\BusinessModel();
            $info = $model->business_search_yw($arr);
            $result = json_decode($info,true);
            if($result['code'] == -1){
                $this->assign("cjh",$arr['cjh']);
                $this->display('sousuo_ null');
            }else{
                $this ->assign("list",$result['data']);
                $this ->assign("info2",$info);
                $this->display('bj_search');
            }
        }else{
            $power = new \Home\Model\business\BusinessModel();
            $powers = $power->bj_list();      
            $result = json_decode($powers,true);
            $info = M('cdent') ->where("is_display = 0") ->select();
            foreach ($info as $k => $v) {
                $info[$k]['checked'] = '';
            }
            foreach ($result['data']['ing'] as $key => $value) {
                $result['data']['ing'][$key]['zh_list'] = $info;
                foreach ($result['data']['ing'][$key]['zh_list'] as $keys => $values) {
                    
                    foreach ($value['bj_certificates'] as $k => $v) {
                        if($values['id'] == $v){
                            $result['data']['ing'][$key]['zh_list'][$keys]['checked'] = 'checked';
                            break;
                        }
                    }
                }     
            }
            foreach ($result['data']['ok'] as $key => $value) {
                $result['data']['ok'][$key]['zh_list'] = $info;
                foreach ($result['data']['ok'][$key]['zh_list'] as $keys => $values) {
                    foreach ($value['bj_certificates'] as $k => $v) {
                        if($values['id'] == $v){
                            $result['data']['ok'][$key]['zh_list'][$keys]['checked'] = 'checked';
                            break;
                        }
                    }
                }     
            }
            // print_r($result);die;
            $this ->assign("list",$result['data']['ing']);
            $this ->assign("info2",$info);
            $this ->assign("info1",$result['data']['ok']);
             
            $this->display();
        }
        
    }
  
    public function upbj(){
         $arr_info=$_POST;
        
         $qufen = $arr_info['qufen'];
         if($arr_info['bj_certificates'] != ''){
         $arr_info['bj_certificates'] = $arr_info['zs_is'];//证书列表
         }
         // print_r($arr_info);die;
         $qufen = $arr_info['qufen'];
         $name = $arr_info['name'];//字段名
         $zhi = $arr_info['zhi'];//获取前台的值
         $arr_info[$name] = $name;//字段名
         $arr_info[$name] = $zhi;//获取前台的值 
         if($arr_info['name'] == 'bj_certificates'){
            $infoid = $arr_info['id'];
            $iny = M('business') ->where("info_id = ".$infoid) 
                                 ->field("bj_certificates")
                                 ->find();
            if($iny == ''){
                $datas['bj_certificates'] = $zhi.',';
            }else{
                $array = explode(",",$iny['bj_certificates']);

                if(in_array($zhi, $array)){
                    for($i=0;$i<count($array);$i++){
                        if($zhi == $array[$i]){
                            unset($array[$i]);
                        }
                    }
                }else{
                    array_push($array,$zhi);
                }

                $datas['bj_certificates'] = implode(',', $array);
            }
            $add_msg = M('business') ->where("info_id = ".$infoid)
                                     ->save($datas);
            if($add_msg){
                return json_encode(array('code' => 1));die;
            }else{
                return json_encode(array('code' => -1,'data' => '服务器错误'));die;
            }
         }  
         $is_date = strtotime($arr_info[$name])?strtotime($arr_info[$name]):false;
        if($is_date===false){
        
         
          $arr_info[$name] = $zhi;//获取前台的值
         
         }
         else{
          
          $arr_info[$name] = strtotime($zhi);//只要提交的是合法的日期，这里都统一成2014-11-11格式
         
         }
        if($arr_info[$name] == 1){              //判断是否是已完成

           $arr_info['bj_ok_time'] =time();
        }  
         /**销毁业务处理**/
         unset($arr_info['name']);//销毁字段名
         unset($arr_info['zhi']);//销毁获取前台的值
         unset($arr_info['qufen']);//判断是未完成还是已完成   
         
       
         
        
         $info_id=$arr_info['id'];
         if($arr_info['bj_is_bao'] == 1){

            unset($arr_info['bj_ok_time']); 
         }
        
         $power = new \Home\Model\business\BusinessModel();
         $powers = $power->update_bjmsg($arr_info,$info_id);  

         echo $powers;
        
    }
     //报检 更多 未完成
    public function bj_1(){

        
        
         

          $whether = 0;      
         //逻辑
          
         $power = new \Home\Model\business\BusinessModel();
         $powers = $power->bj_list_more($whether);
         $result = json_decode($powers,true);
         $info = M('cdent') ->where("is_display = 0") ->select();
            foreach ($info as $k => $v) {
                $info[$k]['checked'] = '';
            }
            foreach ($result['data']['list'] as $key => $value) {
                $result['data']['list'][$key]['zh_list'] = $info;
                foreach ($result['data']['list'][$key]['zh_list'] as $keys => $values) {
                    
                    foreach ($value['bj_certificates'] as $k => $v) {
                        if($values['id'] == $v){
                            $result['data']['list'][$key]['zh_list'][$keys]['checked'] = 'checked';
                            break;
                        }
                    }
                }     
            }
         $this ->assign("list",$result['data']['list']);
         $this ->assign("page",$result['data']['page']);
         $this->display();
    }
    //报检 更多 已完成
    public function bj_2(){

        
         $whether = 1;      
         //逻辑 
         $power = new \Home\Model\business\BusinessModel();
         $powers = $power->bj_list_more($whether);
         $result = json_decode($powers,true);
         $info = M('cdent') ->where("is_display = 0") ->select();
            foreach ($info as $k => $v) {
                $info[$k]['checked'] = '';
            }
            foreach ($result['data']['list'] as $key => $value) {
                $result['data']['list'][$key]['zh_list'] = $info;
                foreach ($result['data']['list'][$key]['zh_list'] as $keys => $values) {
                    
                    foreach ($value['bj_certificates'] as $k => $v) {
                        if($values['id'] == $v){
                            $result['data']['list'][$key]['zh_list'][$keys]['checked'] = 'checked';
                            break;
                        }
                    }
                }     
            }
         $this ->assign("list",$result['data']['list']);
         $this ->assign("page",$result['data']['page']);
         
         $this->display();
        
    }

    /*报关 - 业务首页
    author：Zly
    time：2016年6月30日09:45:40
    */
    public function baoguan(){
        if($_POST['search_cjh'] != ''){
            $arr['cjh'] = $_POST['search_cjh'];
            $arr['stage'] = $_POST['stage'];
            $model = new \Home\Model\business\BusinessModel();
            $info = $model->business_search_yw($arr);
            $result = json_decode($info,true);
            if($result['code'] == -1){
                $this->assign("cjh",$arr['cjh']);
                $this->display('sousuo_ null');
            }else{
                $this ->assign("list",$result['data']);
                $this->display('bg_search');
            }
        }else{
            $power = new \Home\Model\business\BusinessModel();
            $powers = $power->bg_list();      
            $result = json_decode($powers,true);
            $info = M('cdent') ->where("is_display = 1") ->select();
            foreach ($info as $k => $v) {
                $info[$k]['checked'] = '';
            }
            foreach ($result['data']['ing'] as $key => $value) {
                $result['data']['ing'][$key]['zh_list'] = $info;
                foreach ($result['data']['ing'][$key]['zh_list'] as $keys => $values) {
                    
                    foreach ($value['bg_certificates'] as $k => $v) {
                        if($values['id'] == $v){
                            $result['data']['ing'][$key]['zh_list'][$keys]['checked'] = 'checked';
                            break;
                        }
                    }
                }     
            }
            foreach ($result['data']['ok'] as $key => $value) {
                $result['data']['ok'][$key]['zh_list'] = $info;
                foreach ($result['data']['ok'][$key]['zh_list'] as $keys => $values) {
                    foreach ($value['bg_certificates'] as $k => $v) {
                        if($values['id'] == $v){
                            $result['data']['ok'][$key]['zh_list'][$keys]['checked'] = 'checked';
                            break;
                        }
                    }
                }     
            }
             
            $this ->assign("list",$result['data']['ing']);
            $this ->assign("resuinfo",$result['data']['ok']);
            $this->display();
        }
        
    }
    //更新报关
    public function updg(){
         $arr_info=$_POST;
         
         
        
         $qufen = $arr_info['qufen'];
         $name = $arr_info['name'];//字段名
         $zhi = $arr_info['zhi'];//获取前台的值
         $arr_info[$name] = $name;//字段名
         $arr_info[$name] = $zhi;//获取前台的值
         if($arr_info['name'] == 'bg_certificates'){
            $infoid = $arr_info['id'];
            $iny = M('business') ->where("info_id = ".$infoid) 
                                 ->field("bg_certificates")
                                 ->find();
            if($iny == ''){
                $datas['bg_certificates'] = $zhi.',';
            }else{
                $array = explode(",",$iny['bg_certificates']);

                if(in_array($zhi, $array)){
                    for($i=0;$i<count($array);$i++){
                        if($zhi == $array[$i]){
                            unset($array[$i]);
                        }
                    }
                }else{
                    array_push($array,$zhi);
                }

                $datas['bg_certificates'] = implode(',', $array);
            }
            
            $add_msg = M('business') ->where("info_id = ".$infoid)
                                     ->save($datas);
            if($add_msg){
                return json_encode(array('code' => 1));die;
            }else{
                return json_encode(array('code' => -1,'data' => '服务器错误'));die;
            }
         }   
         $is_date = strtotime($arr_info[$name])?strtotime($arr_info[$name]):false;
        if($is_date===false){
        
         
          $arr_info[$name] = $zhi;//获取前台的值
         
         }
         else{
          
          $arr_info[$name] = strtotime($zhi);//只要提交的是合法的日期，这里都统一成2014-11-11格式
         
         }
        if($arr_info[$name] == 1){              //判断是否是已完成

           $arr_info['bg_ok_time'] =time();
        } 
         /**销毁业务处理**/
         unset($arr_info['name']);//销毁字段名
         unset($arr_info['zhi']);//销毁获取前台的值
         unset($arr_info['qufen']);//判断是未完成还是已完成
        
         $info_id=$arr_info['id'];

         $power = new \Home\Model\business\BusinessModel();
         $powers = $power->update_bgmsg($arr_info,$info_id);  

         echo $powers;
        
    }
     //报关 更多 未完成
    public function bg_1(){

        
        
         

          $whether = 0;      
         //逻辑
          
         $power = new \Home\Model\business\BusinessModel();
         $powers = $power->bg_list_more($whether);
         $result = json_decode($powers,true);
        
         $this ->assign("list",$result['data']['list']);
         $this ->assign("page",$result['data']['page']);
         $this->display();
    }
    //报关 更多 已完成
    public function bg_2(){

        
         $whether = 1;      
         //逻辑 
         $power = new \Home\Model\business\BusinessModel();
         $powers = $power->bg_list_more($whether);
         $result = json_decode($powers,true);
         $this ->assign("list",$result['data']['list']);
         $this ->assign("page",$result['data']['page']);
         
         $this->display();
        
    }

    /*约上线 - 业务首页
    author：Zly
    time：2016年6月30日09:45:40
    */
    public function ysx(){
        if($_POST['search_cjh'] != ''){
            $arr['cjh'] = $_POST['search_cjh'];
            $arr['stage'] = $_POST['stage'];
            $model = new \Home\Model\business\BusinessModel();
            $info = $model->business_search_yw($arr);
            $result = json_decode($info,true);
            if($result['code'] == -1){
                $this->assign("cjh",$arr['cjh']);
                $this->display('sousuo_ null');
            }else{
                $this ->assign("list",$result['data']);
                $this->display('ysx_search');
            }
            
        }else{
            $power = new \Home\Model\business\BusinessModel();
            $powers = $power->ysx_list();
            $result = json_decode($powers,true);
        
            $this ->assign("list",$result['data']['ing']);
            $this ->assign("ok",$result['data']['ok']);
            $this->display();
        }
        
    }
    //更新约上线
    public function update_ysx(){
         $arr_info=$_POST;
         $qufen = $arr_info['qufen'];
         $name = $arr_info['name'];//字段名
         $zhi = $arr_info['zhi'];//获取前台的值
         $arr_info[$name] = $name;//字段名
         $arr_info[$name] = $zhi;//获取前台的值 
         
         $is_date = strtotime($arr_info[$name])?strtotime($arr_info[$name]):false;

        if($is_date===false){
        
         
          $arr_info[$name] = $zhi;//获取前台的值
         
         }
         else{
          
          $arr_info[$name] = strtotime($zhi);//只要提交的是合法的日期，这里都统一成2014-11-11格式
         
         }
         

         if($arr_info[$name] == 1){              //判断是否是已完成

           $arr_info['ysx_ok_time'] = time();
         }   
         /**销毁业务处理**/
         unset($arr_info['name']);//销毁字段名
         unset($arr_info['zhi']);//销毁获取前台的值
         unset($arr_info['qufen']);//判断是未完成还是已完成  
         // print_r($arr_info);die;
         
         
         // $arr_info['ysx_online_time'] =strtotime($arr_info['ysx_online_time']);
         // $arr_info['ysx_vehicle_time'] =strtotime($arr_info['ysx_vehicle_time']);
         // $arr_info['ysx_unboxing_time']  =strtotime($arr_info['ysx_unboxing_time']);
         // $arr_info['ysx_backed_time'] =strtotime($arr_info['ysx_backed_time']);  
         $info_id=$arr_info['id'];

         $power = new \Home\Model\business\BusinessModel();
         $powers = $power->update_ysxmsg($arr_info,$info_id);  

         echo $powers;
        
    }
    //约上线 更多 未完成
    public function ysx_1(){

        
        
         

          $whether = 0;      
         //逻辑
          
         $power = new \Home\Model\business\BusinessModel();
         $powers = $power->ysx_list_more($whether);
         $result = json_decode($powers,true);
        
         $this ->assign("list",$result['data']['list']);
         $this ->assign("page",$result['data']['page']);
         $this->display();
    }
    //约上线 更多 已完成
    public function ysx_2(){

        
         $whether = 1;      
         //逻辑 
         $power = new \Home\Model\business\BusinessModel();
         $powers = $power->ysx_list_more($whether);
         $result = json_decode($powers,true);
         $this ->assign("list",$result['data']['list']);
         $this ->assign("page",$result['data']['page']);
         
         $this->display();
        
    }
    //客户经理 - 搜索
    public function searchs(){
        $cjh = $_POST['search_cjh'];
        // print_r($cjh);die;
        $model = new \Home\Model\business\BusinessModel();
        $info = $model->business_search($cjh);
        $result = json_decode($info,true);
        if($result['code'] == -1){
            $this->assign("cjh",$cjh);
            $this->display('sousuo_ null');
        }else{
            $this->assign("result",$result['data']);
            $this->display('sousuo_');
        }   
    }

    //业务搜索
    public function search_yw(){
        $arr['cjh'] = $_POST['search_cjh'];
        $arr['stage'] = $_POST['stage'];
        $model = new \Home\Model\business\BusinessModel();
        $info = $model->business_search_yw($arr);
        $result = json_decode($info,true);
        print_r($result);
        // $this->assign("result",$result['data']);
        // $this->display('sousuo_');
    }
   
    



}
?>