<?php
namespace app\item_manage\controller;

use app\item_manage\model\ItemModel;
use app\item_manage\model\TeamModel;
use think\Controller;
use think\Request;
use think\View;
use think\Session;

class Exchange extends Controller{
    public function show_item(){
        $view = new View();
        $item = new ItemModel();
        $team = new TeamModel();
        //下面的需要获取用户ID和事件id填进去
        $userId = Session::get('user_id');
        $eventId = Request::instance()->param('event_id');;
        $teamId = $team->findTeamId($userId,$eventId);
        $teamCred = $team->getTeamCred($teamId,$eventId);
        $arr = $item->showItemByEvent($eventId);
        //获取本组道具
        $have_item=$item->showItemByTeam($teamId,$eventId);
        //队长权限
        $isLeader = $team->isLeader($userId, $teamId, $eventId);
        return $view->fetch('exchange_item',['arr' => $arr,'isLeader' => $isLeader,'teamCred' => $teamCred,'haveItem' => $have_item,'event_id'=>$eventId]);
    }

    public function exchange(Request $request){
      if($request->isPost()){//判断是否为POST方法
          $data=$request->param();
          $userId = Session::get('user_id');
          $eventId = $data['exchange_event'];
          $itemId = $data['exchange_item'];
          $item = new ItemModel();
          $team = new TeamModel();
          $teamId = $team->findTeamId($userId,$eventId);
          //判断是否为队长
          $isLeader = $team->isLeader($userId, $teamId, $eventId);
          //若不是队长，则无兑换权限，直接返回错误信息
          if($isLeader != '1') {
              $res = array('result'=>'无兑换权限');
              return json_encode($res);
          }
          //查看道具库存是否大于0
          $itemNum = $item->getItemNum($itemId);
          if(!empty($itemNum)&&$itemNum==0){
              $res = array('result'=>'道具已无库存');
              return json_encode($res);
          }
          //有兑换权限，判断兑换次数是否小于可兑换次数
          $exchangeNum = $team->getExchangeNum($teamId, $itemId, $eventId);//获取该队伍已兑换这个道具的次数
          $canExchengeNum = $item->getCanExchangeNum($itemId, $eventId);//获取可兑换次数
          if(!empty($canExchengeNum)&&$exchangeNum>=$canExchengeNum){
              $res = array('result'=>'已超出可兑换的次数');
              return json_encode($res);
          }
          //没有超出兑换次数的情况下
          //获取队伍的积分信息
          $teamCred = $team->getTeamCred($teamId,$eventId);
          //获取道具所需的兑换积分
          $itemCredit = $item->getItemCredit($itemId);
          //判断是否够积分兑换
          if($teamCred<$itemCredit){
              $res = array('result'=>'兑换积分不足');
              return json_encode($res);
          }
          //成功兑换的情况下,扣除队伍积分,mark1标记是否扣除积分成功
          $mark1 = $team->deductCredit($teamId,$eventId,$teamCred,$itemCredit);
          //道具的数量减少1
          if(!empty($itemNum)){
              $mark2 = $item->deductItemNum($itemId,$itemNum);
          }else{
             $mark2='true';
          }
          //插入队伍的兑换记录到数据库中
          $change_time=date('Y-m-d H:i:s');
          $data = ['team_id'=>$teamId,'refer_event_id'=>$eventId,'change_time'=>$change_time,'change_value'=>$itemCredit,'change_reason'=>"减少",'item_id'=>$itemId];
          $mark3 = $team->intoCredit($data);
          if($mark1&&$mark2&&$mark3){
              $res = array('result'=>'兑换成功');
              return json_encode($res);
          }else{
              $res = array('result'=>'兑换失败');
              return json_encode($res);
          }
        }
      }
  }
