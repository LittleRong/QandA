<?php

namespace app\index\controller;

use think\Controller;
use think\Request;
use think\View;
use app\index\model\UserModel;
use think\Session;

class Login extends Controller
{
    public function index(){
        $view = new View();
        if(Session::get('user_id')){//用户已经登陆，直接进入用户中心
            return $view->fetch('user_answer@user_index/user_index');
        }else{
            return $view->fetch('index');//用户未登录，进入登陆界面
        }
    }

    //验证登陆
    public function check(Request $request){
        if($request->isPost()){//判断是否为POST方法
            $data=$request->param();
            $username=$data['username'];
            $password=$data['password'];
            $user_model = new UserModel();//实例化用户模型
            $login_result = $user_model->login($username,$password);//调用函数进行登录判断
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

    }

    //注销
    public function logout()
    {
        //注销session
        session(null);
        $data = array('result'=>'成功退出');
        return json_encode('$data');
    }
}
