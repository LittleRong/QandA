<?php
namespace app\event\model;
use think\Model;
use think\Db;

class TeamModel extends Model{
    protected $table = 'team';// 对应数据库中的team表

    public function team_insert($refer_event_id)
    {
      $this->data([
      'refer_event_id' => $refer_event_id,
      'team_score'  => 0,
      'team_credit'  => 0
      ]);
      $this->save();
      return $this->team_id;
    }

}
