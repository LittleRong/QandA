<?php
namespace app\item_manage\model;
use think\Db;
use think\Model;

class ItemModel extends Model{
    protected $table = 'item';// 对应数据库中的user表

    //获取表中所有数据
    public function show(){
        return Db::table($this->table)->select();
    }

    //查找记录
    public function findData($id){
        return Db::table($this->table)->where('item_id','=',$id)->find();
    }

    //更新记录
    public function updateData($data,$id){
        return Db::table($this->table)->where('item_id','=',$id)->update($data);
    }


    //从数据库中删除记录
    public function deleteData($id){
        return Db::table($this->table)->where('item_id','=',$id)->delete();
    }

    //新增道具到数据库
    public  function  insertData($data){
        return Db::table($this->table)->insertGetId($data);
    }

    //新增道具到数据库
    public function addTodatabase($item_name,
        $item_description,$change_rule,$amount,$team_amount){
        $insertdata = [
            'item_name'=>$item_name,'item_description'=>$item_description,
            'change_rule'=>$change_rule,'amount'=>$amount,
            'team_amount'=>$team_amount];
        $mark = db('item')->insert($insertdata);
        return $mark;
    }

    //获取道具的可兑换次数
    public function getCanExchangeNum($itemId,$evenId){
        $arr = Db::table($this->table)->where(['item_id'=>$itemId,'refer_event_id'=>$evenId])->find();
        return $arr['team_amount'];

    }

    //获取道具的兑换积分
    public function getItemCredit($itemId){
        $arr = Db::table($this->table)->where(['item_id'=>$itemId])->find();
        return $arr['change_rule'];
    }

    public function getItemNum($itemId){
        $arr = Db::table($this->table)->where(['item_id'=>$itemId])->find();
        return $arr['amount'];
    }

    //道具数量-1
    public function deductItemNum($itemId,$itemNum){
        $data = ['amount'=>$itemNum-1];
        return Db::table('item')->where(['item_id'=>$itemId])->update($data);
    }

    public function showItemByTeam($team_id,$event_id){
      $sql="select item.item_name,G.num
            from item
            inner JOIN
            (select item_id,count(*) as num
            from credit
            where credit.team_id=".$team_id.
            " and credit.refer_event_id=".$event_id.
            " group by(item_id)) as G
            on item.item_id=G.item_id";
      return Db::query($sql);
    }

    public function showItemByEvent($event_id){
        return Db::table($this->table)->where('refer_event_id','=',$event_id)->select();
    }

}
