<?php
namespace app\event\model;
use think\Model;
class EventProblemModel extends Model{
    protected $table = 'event_problem';// 对应数据库中的event表

    public function event_problem_insert($problemId,$event_id)
    {
      $this->data([
        'refer_event_id' => $event_id,
        'problem_id' => $problemId
      ]);
      $this->save();
    }
    public function event_problem_inserts($problemId,$event_id)
    {
      $list = array(array());
      $num = count($problemId);
      for($i=0;$i<$num;$i++)
      {
        $list = array('event_id'=>$event_id,'refer_event_id'=>$problemId[$i]);
        $list_merge = array_merge($list_merge,$list);
      }
      $this->saveAll($list);

    }

  }
