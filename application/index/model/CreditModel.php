<?php
namespace app\index\model;
use think\Model;
use think\Db;
use think\Log;

class CreditModel extends Model{
    protected $table = 'credit';// 对应数据库中的item表

    //获取事件信息
    public function getCredit($event_id,$user_id){
      $result=array();
      //获取本次事件中的个人积分,组积分
      $sql="select credit,team_credit
      from participant,team
      where participant.user_id=".$user_id.
      " and participant.refer_event_id=".$event_id.
      " and participant.team_id=team.team_id";
      $result_array = Db::query($sql);
      $result['credit']=$result_array[0]['credit'];
      $result['team_credit']=$result_array[0]['team_credit'];
      //获取本次事件中积分详细操作
      $detail_sql="select *
      from credit
      where credit.user_id=".$user_id.
      " and credit.refer_event_id=".$event_id;
      $detail_array = Db::query($detail_sql);
      $result['detail_credit']=$detail_array;
      return $result;
    }

}
