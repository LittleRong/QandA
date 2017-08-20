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
          return $view->fetch('contact');

      }

      //跳转到事件显示视图
      public function showEvent()
      {
         $result = self::check(1);
        $result = json_decode($result,true);
        $event_time = json_decode($result['event_time'],true);
        $question_num = json_decode($result['question_num'],true);
        $credit_rule = json_decode($result['credit_rule'],true);
        $result = array_merge($result,$event_time,$question_num,$credit_rule);
         $view = new View();
         return $view->fetch('elements',$result);
      }

      //接受ajax数据并写入数据库
      public function manage($eid,$aid,$ename,$start_time,$end_time,$single,$multiple,
              $fill,$judge,$pro_ramdom,$opt_ramdom,$ekind,$time,$single_score,
              $multiple_score,$fill_score,$judge_score,$person_score,
              $team_score,$person_score_up,$team_score_up,$message)
       {
          $this->insert((int)$eid,(int)$aid,$ename,$start_time,$end_time,(int)$single,(int)$multiple,
                  (int)$fill,(int)$judge,(bool)$pro_ramdom,(bool)$opt_ramdom,$ekind,(int)$time,(int)$single_score,
                  (int)$multiple_score,(int)$fill_score,(int)$judge_score,(int)$person_score,
                  (int)$team_score,(int)$person_score_up,(int)$team_score_up,$message);
          $data = array('result'=>'录入成功!');
          return json_encode($data);
      }


      //查询数据库
      public function check($id)
      {
          $user_model = new EventModel();
          $result = $user_model->sql_check($id);
          return $result;
      }

      //查询全部
      public function checkall()
      {
          $user_model = new EventModel();
          $result = $user_model->sql_checkall();
          for($i=0;$i<count($result);$i++)
          {
            echo $result[$i];
            echo "<br>";
          }
      }

      //插入数据
      public function insert($eid,$aid,$ename,$start_time,$end_time,$single,$multiple,
              $fill,$judge,$pro_ramdom,$opt_ramdom,$ekind,$time,$single_score,
              $multiple_score,$fill_score,$judge_score,$person_score,
              $team_score,$person_score_up,$team_score_up,$message)
      // public function insert($eid,$aid,$ename,$start_time,$end_time,$single,$multiple,$fill,$judge,$pro_ramdom,$opt_ramdom,$ekind,$time,$single_score)
      {
          $user_model = new EventModel();
          $user_model->sql_insert($eid,$aid,$ename,$start_time,$end_time,$single,$multiple,
                  $fill,$judge,$pro_ramdom,$opt_ramdom,$ekind,$time,$single_score,
                  $multiple_score,$fill_score,$judge_score,$person_score,
                  $team_score,$person_score_up,$team_score_up,$message);
          // $user_model->sql_insert($eid,$aid,$ename,$start_time,$end_time,$single,$multiple,$fill,$judge,$pro_ramdom,$opt_ramdom,$ekind,$time,$single_score);
      }

      //删除数据
      public function delete()
      {
          $user_model = new EventModel();
          $user_model->sql_delete(3);

      }

  }
 ?>
