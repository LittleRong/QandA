<?php
namespace app\problem_manage\model;
use think\Model;
use think\Db;
use app\problem_manage\tool\LogTool;
class EventModel {
  public function getEvent($event_id){
       $res=Db :: table('event') ->where('event_id',$event_id)->select();
       Return $res[0];
  }
  public function getQuestNum($event_id){
     $res=Db :: table('event') ->where('event_id',$event_id)->select();
     Return json_decode($res[0]['event_num'],true);

  }




}
