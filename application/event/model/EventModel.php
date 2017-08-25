<?php
namespace app\event\model;
use think\Model;
class EventModel extends Model{
    protected $table = 'event';// 对应数据库中的event表


    //查找event表
    public function event_check($id)
    {
        $query=['eid'=>$id];
        $result = $this->get($query);
        if (empty($result)) {//获取数据，若不存在则返回空
            return null;
        }
        return $result;   //返回用户信息
    }

    //查找event表中所有数据
    public function event_checkall()
    {
      $result = $this->all();
      if (empty($result)) {//获取数据，若不存在则返回空
          return null;
      }
      return $result;   //返回用户信息
    }

    //事件插入
    public function event_insert($time,$participant_num,$aid,$ename,$start_time,$end_time,$single,$multiple,
            $fill,$judge,$pro_random,$opt_random,$ekind,$answer_time,$single_score,
            $multiple_score,$fill_score,$judge_score,$person_score,
            $team_score,$person_score_up,$team_score_up,$message)
    {

      $event_time =  array('start_time'=>$start_time,'end_time'=>$end_time ,'time'=>$time);
      $event_time = json_encode($event_time);

      $question_num = array('single'=>$single,'multiple'=>$multiple,'fill'=>$fill,'judge'=>$judge);
      $question_num = json_encode($question_num);

      $credit_rule  = array('single_score' => $single_score,'multiple_score'=>$multiple_score,
      'fill_score'=>$fill_score,'judge_score'=>$judge_score, 'person_score'=>$person_score,
      'team_score'=>$team_score,'person_score_up'=>$person_score_up,'team_score_up'=>$team_score_up);
      $credit_rule = json_encode($credit_rule);


      $this->data([
        'manage_id'  =>  $aid,
        'event_title'  => $ename,
        'event_time' => $event_time,
        'event_num'  => $question_num,
        'event_type'  => $ekind,
        'problem_random'  =>  $pro_random,
        'option_random'  => $opt_random,
        'credit_rule' => $credit_rule,
        'event_description'  =>  $message,
        'answer_time'  =>  $answer_time,
        'participant_num' => $participant_num
      ]);

      $this->save();
      return  $this->event_id;   //获取自增ID
    }

    //删除数据
    public function sql_delete($id)
    {
        $this->destroy(['id'=>$id]);
    }

}

 ?>
