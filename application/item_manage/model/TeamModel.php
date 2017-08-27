<?php
namespace app\item_manage\model;
use think\Db;
use think\Model;
class TeamModel extends Model{

    //根据用户id和事件id来查找用户所在的组
    public function findTeamId($id,$evenId){
        $arr = Db::table('participant')->where(['user_id'=>$id,'refer_event_id'=>$evenId])->find();
        return $arr['team_id'];
    }

    //根据组id和事件id来获取组积分信息
    public function getTeamCred($teamId,$evenId){
        $arr = Db::table('team')->where(['team_id'=>$teamId,'refer_event_id'=>$evenId])->find();
        return $arr['team_credit'];
    }

    //判断是否为队长，是就返回1，不是就返回0
    public function isLeader($userId,$teamId,$evenId){
        $arr = Db::table('participant')->where(['user_id'=>$userId,'refer_event_id'=>$evenId,'team_id'=>$teamId])->find();
        return $arr['leader'];
    }

    //根据team_id和item_id判断该组兑换该道具的次数
    public function getExchangeNum($teamId,$itemId,$evenId){
        $num = Db::table('credit')->where(['team_id'=>$teamId,'item_id'=>$itemId,'refer_event_id'=>$evenId])->count();
        return $num;
    }

    //兑换成功，扣除队伍积分
    public function deductCredit($teamId,$evenId,$teamCred,$itemCredit){
        $data = ['team_credit'=>$teamCred-$itemCredit];
        return Db::table('team')->where(['team_id'=>$teamId,'refer_event_id'=>$evenId])->update($data);
    }

    //插入记录到credit表中
    public function intoCredit($data){
        return Db::table('credit')->insert($data);

    }

}
