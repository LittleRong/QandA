<?php

namespace app\index\controller;

use think\Controller;
use think\Request;
use think\View;
use app\index\model\UserModel;
use app\index\model\EventModel;
use think\Session;

class Login extends Controller{
    public function index(){
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
                }else{
                    Session::set('user_id',$login_result->id); //设置session保存当前登陆用户信息
                    if($login_result->permission==1){//管理员用户
                        $data = array('result'=>'管理员');
                    }else{//普通用户
                        $data = array('result'=>'普通用户');
                    }
                }
            }else{
                $data = array('result'=>'登陆失败,用户名或密码错误');
            }
            return json_encode($data);
        }

    }

    //注销
    public function logout(){
        //注销session
        session(null);
        $data = array('result'=>'成功退出');
        return json_encode('$data');
    }

    //转到修改密码页面
    public function change_pwd(){
        $view = new View();
        if(Session::get('user_id')){//用户已经登陆，可修改密码
            return $view->fetch('change_pwd');
        }else{
            return $view->fetch('index');//用户未登录，进入登陆界面
        }
    }

    //修改密码操作
    public function change_pwd_post(Request $request){
        if($request->isPost()){//判断是否为POST方法
            $data=$request->param();
            $old_password=$data['old_password'];
            $new_password=$data['new_password'];
            $user_id=Session::get('user_id');
            $user_model = new UserModel();//实例化用户模型
            $change_result = $user_model->change_pwd($user_id,$old_password,$new_password);//调用函数进行修改密码
            return json_encode($change_result);
        }
    }
}
