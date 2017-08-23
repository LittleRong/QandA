<?php
  namespace app\event\controller;

  use app\event\model\EventModel;
  use think\Controller;
  use think\View;
  use think\Request;


  class Index extends Controller
  {
        //跳转到事件录入视图
      public function insertEvent()
      {
          $view = new View();
          return $view->fetch('event_insert');
      }

      //跳转到事件显示视图
      public function showEvent()
      {
         $model = new EventModel();
         $result = $model->event_checkall();
         $all = array(array());
         for($i=0;$i<count($result);$i++)
         {
            $item = json_decode($result[$i],true);
            $event_time = json_decode($item['event_time'],true);
            $question_num = json_decode($item['event_num'],true);
            $credit_rule = json_decode($item['credit_rule'],true);
            $merge_item = array_merge($item,$event_time,$question_num,$credit_rule);
            $all[$i] = $merge_item;
        }
        //  dump($all);
        //  $view = new View();
        //  return $view->fetch('elements',$all[0]);
        $this->assign('data',$all);
        return $this->fetch("elements");
      }



      //接受ajax数据并写入数据库
      public function manage($time,$participant_num,$ename,$start_time,$end_time,$single,$multiple,
              $fill,$judge,$pro_random,$opt_random,$ekind,$answer_time,$single_score,
              $multiple_score,$fill_score,$judge_score,$person_score,
              $team_score,$person_score_up,$team_score_up,$message)
       {
          $aid = 2;
          $model = new EventModel();
          $model->event_insert($time,(int)$participant_num,(int)$aid,$ename,$start_time,$end_time,(int)$single,(int)$multiple,
                  (int)$fill,(int)$judge,(boolean)$pro_random,(boolean)$opt_random,$ekind,$answer_time,(int)$single_score,
                  (int)$multiple_score,(int)$fill_score,(int)$judge_score,(int)$person_score,
                  (int)$team_score,(int)$person_score_up,(int)$team_score_up,$message);
          $data = array('result'=>'录入成功!');
          return json_encode($data);
      }

  }
