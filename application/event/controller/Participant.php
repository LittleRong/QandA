<?php
  namespace app\event\controller;

  use app\event\model\ParticipantModel;
  use think\Controller;
  use think\View;
  use think\Request;
  use app\index\model\UserModel;
  use think\Session;
  use app\common\controller\ManageContrller;

  class Participant extends ManageContrller
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
          //获取队伍ID最大值
          $base = $model->getMax();
          foreach ($mydata as $key => $value)
          {
            $teamid = $key+1;     //teamid默认应该从1开始
            $leader = $value[0];
            $teamate1 = $value[1][0];
            $teamate2 = $value[1][1];
            $model->participant_insert((int)$event_id,(int)$leader,(int)$teamid+$base,1);
            $model->participant_insert((int)$event_id,(int)$teamate1,(int)$teamid+$base,0);
            $model->participant_insert((int)$event_id,(int)$teamate2,(int)$teamid+$base,0);
          }
          Session::delete('myevent_id');
          $data = array('result'=>'录入成功!');
          return json_encode($data);

      }

  }
