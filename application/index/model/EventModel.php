<?php
namespace app\index\model;
use think\Model;
use think\Db;
use think\Log;

class EventModel extends Model{
    protected $table = 'event';// 对应数据库中的event表

    //获取用户参加的比赛信息
    public function getEventMessageByUser($user_id){
      //$result="";
      $sql="select event_id,event_title,event_description,participant_num,event_num,event_time
      from event, participant
      where participant.refer_event_id=event.event_id
       and participant.user_id=".$user_id;
      $result_array = Db::query($sql);
      $count=0;
      $final_result=array();
      //筛选在有效时间内的事件
      foreach($result_array as $result){
          //取出时间
          $time=json_decode($result['event_time']);
          $start_time=$time->start_time;//开始时间
          $end_time=$time->end_time;//结束时间
          $now_time=date("y-m-d");//获取现在时间
          //筛选在有效时间内的事件
          if(strtotime($now_time)<strtotime($end_time)&&strtotime($now_time)>strtotime($start_time)){
            //添加元素
            $event_id=$result['event_id'];//事件id
            $result['start_time']=$start_time;
            $result['end_time']=$end_time;
            $result['item']='';
            //取出题目数量
            $event_num=json_decode($result['event_num']);
            $result['fill']=$event_num->fill;
            $result['judge']=$event_num->judge;
            $result['single']=$event_num->single;
            $result['multiple']=$event_num->multiple;
            //筛选道具
            $item_sql="select item_name
            from item
            where item.refer_event_id=".$event_id;
            $item_array = Db::query($item_sql);
            $item_string="";
            foreach($item_array as $item){
                $item_string.=$item['item_name'];
            }
            $result['item']=$item_string;
            array_push($final_result,$result);
          }
          ++$count;
      }
      if (empty($final_result)) {//获取数据，若不存在则返回空
          return null;
      }

      return $final_result;   //返回用户信息
    }

    //获取事件信息
    public function getEventMessageById($event_id){
      $data = $this->where('event_id',$event_id)->field('event_id,event_title,event_description,event_time,event_num,event_type,answer_time,credit_rule')->select();
      $result=array();
      if(empty($data)){//!!！空对象
            return null;
      }else{//解析
          $result['event_id']=$data[0]['event_id'];
          $result['event_title']=$data[0]['event_title'];
          $result['event_description']=$data[0]['event_description'];
          $result['event_type']=$data[0]['event_type'];
          $result['answer_time']=$data[0]['answer_time'];
          //解析时间
          $time=json_decode($data[0]['event_time']);
          $result['start_time']=$time->start_time;
          $result['end_time']=$time->end_time;
          $result['answer_day']=$time->time;
          //解析题数
          $event_num=json_decode($data[0]['event_num']);
          $result['fill']=$event_num->fill;
          $result['judge']=$event_num->judge;
          $result['single']=$event_num->single;
          $result['multiple']=$event_num->multiple;
          //解析积分规则
          $rule=json_decode($data[0]['credit_rule']);
          $result['single_score']=$rule->single_score;
          $result['multiple_score']=$rule->multiple_score;
          $result['fill_score']=$rule->fill_score;
          $result['judge_score']=$rule->judge_score;
          $result['person_score']=$rule->person_score;
          $result['team_score']=$rule->team_score;
          $result['team_score_up']=$rule->team_score_up;
          $result['person_score_up']=$rule->person_score_up;
      }

      return $result;
    }

}
