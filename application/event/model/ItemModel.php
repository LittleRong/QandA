<?php
namespace app\event\model;
use think\Model;
class ItemModel extends Model{
    protected $table = 'item';// 对应数据库中的event表

    //查找item表中所有数据
    public function item_checkall()
    {
      $result = $this->all();
      if (empty($result)) {//获取数据，若不存在则返回空
          return null;
      }
      return $result;   //返回用户信息
    }
  }
