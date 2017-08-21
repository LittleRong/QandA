<?php
namespace app\index\model;
use think\Model;
use think\Db;
use app\index\model\Participant;

class EventModel extends Model{
    protected $table = 'event';// 对应数据库中的event表

    //获取用户信息
    public function getEventMessageByUser($user_id){
      //$result="";
      $result = Db::query("select event_title,event_description,item_name from event, participant,item where participant.refer_event_id=event.event_id and event.event_id=item.refer_event_id");
      if (empty($result)) {//获取数据，若不存在则返回空
          return null;
      }
      //筛选在有效时间内的事件
      return $result;   //返回用户信息

    }
}
