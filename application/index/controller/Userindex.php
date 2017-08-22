<?php
namespace app\index\controller;
use think\View;
use think\Controller;
use app\index\model\UserModel;
use app\index\model\EventModel;
use think\Session;

class Userindex extends Controller{
    public function user_index(){
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

}
