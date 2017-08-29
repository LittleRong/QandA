<?php
namespace app\index\controller;
use think\View;
use think\Controller;
use app\index\model\UserModel;
use app\index\model\EventModel;
use think\Session;
use app\common\controller\UserController;

class Userindex extends UserController{
    public function user_index(){
            $user_id=Session::get('user_id');
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
}
