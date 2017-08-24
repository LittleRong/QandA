<?php
namespace app\event\model;
use think\Model;
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
      echo $this->problem_id;   //获取自增ID
    }


}
