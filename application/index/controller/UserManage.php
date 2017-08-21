<?php

namespace app\index\controller;

use think\Controller;
use think\Request;
use think\View;
use app\index\model\UserModel;
use think\Session;

class UserManage extends Controller{
    public function index(){
        $view = new View();
        if(Session::get('user_id')){//管理员已经登陆，直接进入用户管理
            return $view->fetch('user_manage');
        }else{
            return $view->fetch('login/index');//用户未登录，进入登陆界面
        }
    }

    //显示所有用户信息
    public function show(){
      $user_model = new UserModel();
      $user_result = $user_model->showAllUser();
      return json_encode($user_result);
    }

}
