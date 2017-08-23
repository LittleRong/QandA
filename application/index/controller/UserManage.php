<?php

namespace app\index\controller;

use think\Controller;
use think\Request;
use think\View;
use app\index\model\UserModel;
use app\index\model\EventModel;
use think\Session;

class Usermanage extends Controller{
    public function user_manage(){
      if(Session::get('user_id')){//用户已经登陆，直接进入用户中心
          $user_id=Session::get('user_id');
          $user_model = new UserModel();//实例化用户模型
          if($user_model->isManager($user_id)){//管理员
              return $this->fetch('usermanage/user_manage');
          }else{//普通用户
              $user_model_id = new UserModel();
              $user_data=$user_model_id->getMessageById($user_id);
              $event_model = new EventModel();
              $event_data=$event_model->getEventMessageByUser($user_id);
              $result_data=array();
              $result_data['user_message']=$user_data;
              $result_data['event_message']=$event_data;
              $this->assign('data',$result_data);
              return $this->fetch('userindex/user_index');
          }
      }else{
          return $this->fetch('login/index');//用户未登录，进入登陆界面
      }
    }

    //显示所有用户信息
    public function show(){
      $user_model = new UserModel();
      $user_result = $user_model->showAllUser();
      return json_encode($user_result);
    }

    //新增用户
    public function adduser(Request $request){
      if($request->isPost()){//判断是否为POST方法
          $data=$request->param();
          $user_name=$data['user_name'];
          $login_name=$data['login_name'];
          $password=md5('gmcc1234');//默认密码gmcc1234
          $user_phone_number=$data['user_phone_number'];
          $user_job_number=$data['user_job_number'];
          $user_gender=$data['user_gender'];
          $user_model = new UserModel();
          $result = $user_model->add_user($user_name,$login_name,$password,$user_phone_number,$user_job_number,$user_gender);//插入并返回插入的用户信息
          return json_encode($result);
      }
    }

    //更新用户
    public function updateuser(Request $request){
      if($request->isPost()){//判断是否为POST方法
          $data=$request->param();
          $user_id=$data['user_id'];
          $user_name=$data['user_name'];
          $login_name=$data['login_name'];
          $user_phone_number=$data['user_phone_number'];
          $user_job_number=$data['user_job_number'];
          $user_gender=$data['user_gender'];
          $user_model = new UserModel();
          $result = $user_model->update_user($user_id,$user_name,$login_name,$user_phone_number,$user_job_number,$user_gender);
          return json_encode($result);
      }
    }

    //删除用户
    public function deleteuser(Request $request){
          if($request->isPost()){//判断是否为POST方法
            $data=$request->param();
            $delete_id=$data['delete_id'];
            $user_model = new UserModel();
            $result = $user_model->delete_user($delete_id);
            return json_encode($result);
          }
    }

}
