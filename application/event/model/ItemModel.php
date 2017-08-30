<?php
namespace app\event\model;
use think\Model;
use think\Db;

class ItemModel extends Model{
    protected $table = 'item';// 对应数据库中的item表

    //查找item表中所有数据
    public function item_checkall()
    {
      // $result = $this->all();
      $result = Db::table('item')->where('refer_event_id',null)->select();
      if (empty($result)) {//获取数据，若不存在则返回空
          return null;
      }
      return $result;   //返回用户信息
    }

    public function item_updata($item_id,$event_id)
    {
      Db::table('item')
      ->where('item_id', $item_id)
      ->update(['refer_event_id' => $event_id]);
    }
  }
