<?php
namespace app\event\model;
use think\Model;
use think\Db;

class ProblemModel extends Model{
    protected $table = 'problem';// 对应数据库中的problem表

    public function problem_insert($problem_content,$problem_class,$problem_type)
    {
      $this->data([
        'problem_content'  => $problem_content,
        'problem_class' => $problem_class,
       'problem_type'  => $problem_type

      ]);
      $this->save();
      // return $this->problem_id;   //获取自增ID
    }
    public function problem_check()
    {
      $result = $this->all();
      if (empty($result)) {//获取数据，若不存在则返回空
          return null;
      }
      return $result;   //返回用户信息
    }

    public function problem_checkByid($start_id,$end_id)
    {
        return  Db::table('problem')
        ->where('problem_id',['>',$start_id],['<>',$end_id],'and')
        ->find();
    }
    public function problem_checkByNum($num)
    {
      $result =  Db::table('problem')->order('problem_id desc')->limit($num)->select();
      if (empty($result)) {//获取数据，若不存在则返回空
          return null;
      }
      return $result;   //返回用户信息
    }


}
