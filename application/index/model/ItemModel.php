<?php
namespace app\index\model;
use think\Model;
use think\Db;
use think\Log;

class ItemModel extends Model{
    protected $table = 'item';// 对应数据库中的item表

    //获取事件信息
    public function getItemByEventId($event_id){
      $data = $this->where('refer_event_id',$event_id)->find();
      //判断是不是空！！！！
      $result=array($data['item_id'],$data['item_name'],$data['item_description'],$data['change_rule'],$data['amount'],$data['team_amount']);
      return $result;
    }

}
