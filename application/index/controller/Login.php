<?php
namespace app\index\controller;
use think\View;
use think\Controller;
use app\index\model\UserModel;
use think\Session;

class login extends Controller{
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
      return $view->fetch('user_answer@user_index/user_index');
    }else{
		//return $view->fetch('model@model/model');
      return $view->fetch('index');//用户未登录，进入登陆界面
    }

  }

  public function login($username='',$password=''){
    $user_model = new UserModel();    //实例化用户模型
    $login_result = $user_model->login($username,$password);  //调用函数进行登录判断
    if($login_result){
      if(Session::get('user_id')){
        $data = array('result'=>'已登陆');
        return json_encode($data);
      }else{
          $data = array('result'=>'登陆成功');
        Session::set('user_id',$login_result->id); //设置session保存当前登陆用户信息
        return json_encode($data);
      }
    }else{
        $data = array('result'=>'登陆失败,用户名或密码错误');
        return json_encode($data);
    }

  }

  public function logout(){
    //注销session
    session(null);
    $data = array('result'=>'成功退出');
    return json_encode('$data');

  }

}
