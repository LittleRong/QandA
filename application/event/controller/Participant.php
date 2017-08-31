<?php
  namespace app\event\controller;

  use app\event\model\ParticipantModel;
  use app\event\model\TeamModel;
  use think\Controller;
  use think\View;
  use think\Request;
  use app\index\model\UserModel;
  use think\Session;
  use app\common\controller\ManageController;

  class Participant extends ManageController
  {
      //发送数据到participant.html上
      public function participant_manage()
      {
          $model = new UserModel();
          $result = $model->showAllUser();
          $all = array(array());
          $num = count($result);
          for($i=0;$i<$num;$i++)
          {
            $all[$i] = array('id'=>$result[$i]['id'],'name'=>$result[$i]['name']);
          }
          if(empty($all[0]))
          {
            $this->assign('data',null);
          }
          else
            $this->assign('data',$all);
          return $this->fetch("participant");
          // $view = new View();
          // return $view->fetch('participant');
      }

      public function participant_insert($mydata)
      {
          // dump($mydata);
          $event_id = Session::get('myevent_id');
          $model = new ParticipantModel();
          $team_model = new TeamModel();
          $temp = -1;
          foreach ($mydata as $key => $value)
          {
            if($temp != $key)
            {
              $teamid = $team_model->team_insert($event_id);
              $temp = $key;
            }
            $leader = $value[0];
            $teamate1 = $value[1][0];
            $teamate2 = $value[1][1];
            $model->participant_insert((int)$event_id,(int)$leader,(int)$teamid,1);
            $model->participant_insert((int)$event_id,(int)$teamate1,(int)$teamid,0);
            $model->participant_insert((int)$event_id,(int)$teamate2,(int)$teamid,0);
          }
          Session::delete('myevent_id');
          $data = array('result'=>'录入成功!');
          return json_encode($data);

      }

  }
