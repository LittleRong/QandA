<?php
namespace app\index\controller;
use think\View;
use think\Controller;
use app\index\model\UserModel;
use think\Session;

class Userindex extends Controller{
    public function user_index(){
        $view = new View();
        if(Session::get('user_id')){//用户已经登陆，直接进入用户中心
            $user_id=Session::get('user_id');
            $user_model = new UserModel();//实例化用户模型
            if($user_model->isManager($user_id)){//管理员
                return $view->fetch('usermanage/user_manage');
            }else{//普通用户
                return $view->fetch('userindex/user_index');
            }
        }else{
            return $view->fetch('login/index');//用户未登录，进入登陆界面
        }
    }

    public function show(){
        $user_id=Session::get('user_id');
    }
}
