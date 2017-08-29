<?php
  namespace app\event\controller;

  use app\event\model\EventModel;
  use app\event\model\ItemModel;
  use think\Controller;
  use think\View;
  use think\Request;
  use think\Session;


  class Index extends Controller
  {

        //跳转到事件录入视图
      public function insertevent()
      {
          $model = new ItemModel();
          $result = $model->item_checkall();
          $all = array(array());
          foreach ($result as $key => $value)
          {
            $item_id = $value['item_id'];
            $item_name = $value['item_name'];
            $item_description = $value['item_description'];
            $change_rule = $value['change_rule'];
            $all[$key] = array_merge(['item_id'=>$item_id],['item_name'=>$item_name],
              ['item_description'=>$item_description],['change_rule'=>$change_rule]);
          }
          //dump($all);
          if(empty($all[0]))
          {
            $this->assign('data',null);
          }
          else
            $this->assign('data',$all);
          return $this->fetch("event_insert");
          // $view = new View();
          // return $view->fetch('event_insert');
      }

      //跳转到事件显示视图
      public function showevent()
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
            unset($item['event_time'],$item['event_num'],$item['credit_rule']);
            $merge_item = array_merge($item,$event_time,$question_num,$credit_rule);
            $all[$i] = $merge_item;
        }
        //  dump($all);
        //  $view = new View();
        //  return $view->fetch('elements',$all[0]);

        if(empty($all[0]))
        {
          $this->assign('data',null);
        }
        else
          $this->assign('data',$all);
        return $this->fetch("event_manager");
      }

      //接受ajax数据并写入数据库
      public function manage($time,$participant_num,$ename,$start_time,$end_time,$single,$multiple,
              $fill,$judge,$pro_random,$opt_random,$ekind,$answer_time,$single_score,
              $multiple_score,$fill_score,$judge_score,$person_score,
              $team_score,$person_score_up,$team_score_up,$message)
       {
          //这里用session获取管理员ID
          $aid = 2;
          $model = new EventModel();
          //$event_id事件自增ID
          $event_id = $model->event_insert($time,(int)$participant_num,(int)$aid,$ename,$start_time,$end_time,(int)$single,(int)$multiple,
                  (int)$fill,(int)$judge,(boolean)$pro_random,(boolean)$opt_random,$ekind,$answer_time,(int)$single_score,
                  (int)$multiple_score,(int)$fill_score,(int)$judge_score,(int)$person_score,
                  (int)$team_score,(int)$person_score_up,(int)$team_score_up,$message);
          Session::set('myevent_id',$event_id);
          //dump($event_id);
          $data = array('result'=>'录入成功!');
          return json_encode($data);
      }

  }
