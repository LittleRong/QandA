<?php
namespace app\user_answer\controller;
use think\View;
use think\Controller;
use app\index\model\User;
use think\controller\Rest;
use think\Session;

class Answer{

    public function index(){
    $view = new View();
    if(Session::get('user_id')){//用户已经登陆，直接进入用户中心
      return $view->fetch('user_index');
    }else{
      return $view->fetch('index@Login/index');//用户未登录，进入登陆界面
    }

  }

}
