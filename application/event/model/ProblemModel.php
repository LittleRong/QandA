<?php
namespace app\event\model;
use think\Model;
class ProblemModel extends Model{
    protected $table = 'problem';// 对应数据库中的problem表

    public function problem_insert($id,$problem_content,$problem_class,$problem_type)
    {
      $this->data([
        'problem_id'  =>  $id,
        'problem_content'  => $problem_content,
        'problem_class' => $problem_class,
       'problem_type'  => $problem_type

      ]);
      $this->save();
    }


}
