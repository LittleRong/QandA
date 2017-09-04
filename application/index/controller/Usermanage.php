<?php

namespace app\index\controller;

use think\Controller;
use think\Request;
use think\View;
use app\index\model\UserModel;
use app\index\model\EventModel;
use think\Session;
use app\common\controller\ManageController;

class Usermanage extends ManageController{
    public function user_manage(){
        return $this->fetch('usermanage/user_manage');
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
          $user_id=$data['change_id'];
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
