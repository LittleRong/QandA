<?php
namespace app\index\controller;
use think\View;
use think\Controller;
use app\index\model\User;
use think\controller\Rest;
use think\Session;

class login extends Rest{
/*
  //可用于其他页面进行是否登陆判断
  public function _initialize()
     {
       $view = new View();
       if(Session::get('user_id')){//用户已经登陆，直接进入用户中心
         return $view->fetch('user@user_index/user_index');
       }else{
         return $view->fetch('index');//用户未登录，进入登陆界面
       }
     }
*/
  public function index(){
    $view = new View();
    if(Session::get('user_id')){//用户已经登陆，直接进入用户中心
      return $view->fetch('user@user_index/user_index');
    }else{
		//return $view->fetch('model@model/model');
      return $view->fetch('index');//用户未登录，进入登陆界面
    }

  }

  public function login($username='',$password=''){
    $user = User::get([
        'login_name' => $username,
        'pwd' => md5($password)
        ]);
    if($user){
      if(Session::get('user_id')){
        $data = ['result'=>'已登陆'];
        return json($data, 200);
      }else{
        $data = ['result'=>'登陆成功'];
        Session::set('user_id',$user->id); //设置session保存当前登陆用户信息
        return json($data, 200);
      }
    }else{
      $data = ['result'=>'登陆失败,用户名或密码错误'];
      return json($data, 200);
    }
  }

  public function logout(){
    //注销session
    session(null);
    $data = ['result'=>'成功退出'];
    return json($data, 200);

  }

}
