<?php
namespace app\index\controller;
use think\View;
use think\Controller;
use app\index\model\UserModel;
use app\index\model\EventModel;
use app\index\model\ItemModel;
use app\index\model\CreditModel;
use think\Session;
use think\Request;

class Eventmessage extends Controller{
    public function event_message(){
      $event_id=Request::instance()->param('event_id');
      $user_id=Session::get('user_id');
      $result=array();
      //获取事件信息
      $event_model = new EventModel();
      $event_data=$event_model->getEventMessageById($event_id);
      $result['event_message']=$event_data;
      //获取道具信息
      $item_model = new ItemModel();
      $item_data=$item_model->getItemByEventId($event_id);
      $result['item_message']=$item_data;
      //获取积分信息
      $credit_model = new CreditModel();
      $credit_data=$credit_model->getCredit($event_id,$user_id);
      $result['credit_message']=$credit_data;
      dump($result);
      $this->assign('data',$result);
      return $this->fetch('eventmessage/event_message');
    }

}
