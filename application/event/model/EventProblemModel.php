<?php
namespace app\event\model;
use think\Model;
use think\Db;

class EventProblemModel extends Model{
    protected $table = 'event_problem';// 对应数据库中的event表

    public function event_problem_insert($problemId,$event_id)
    {
      $data = ([
        'refer_event_id' => $event_id,
        'problem_id' => $problemId
      ]);
      //$this->save()只适合有主键的数据类型，其他的会出错
      Db::name('event_problem')->insert($data);
    }

  }
