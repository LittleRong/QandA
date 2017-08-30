<?php
namespace app\event\model;
use think\Model;
use think\Db;

class ParticipantModel extends Model{
    protected $table = 'participant';// 对应数据库中的participant表

    //插入participant表
    public function participant_insert($refer_event_id,$user_id,$team_id,$leaderid=0)
    {

        $data = ([
        'refer_event_id' => $refer_event_id,
        'user_id' => $user_id,
        'team_id' => $team_id,
        'leader'  => $leaderid,
        'credit'  => 0
      ]);
      Db::name('participant')->insert($data);
    }

    //获取当前队伍ID最大值
    public function getMax()
    {
      return  $base = Db::table('participant')->max('team_id');
    }


  }
