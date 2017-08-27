<?php
namespace app\manage\model;
use think\Model;
use think\Db;

class ProblemModel extends Model{
    protected $table = 'problem';// 对应数据库中的user表



    //显示所有题目
    public function showAllProblem(){
        $sql="select * from problem";
        $result_array = Db::query($sql);
        //解析json
        $i=0;
        for($i=0;$i<count($result_array);$i++){
            $content=json_decode($result_array[$i]['problem_content']);
            $result_array[$i]['problem']=$content->problem;
            if(is_array($content->answer)){
                $result_array[$i]['answer']=implode(' ',$content->answer);
            }else{
                $result_array[$i]['answer']=$content->answer;
            }


            //解析选项
            if (is_object($content->option)) {
                foreach ($content->option as $key => $value) {
                  $array[$key] = $value;
                }
            }
            else {
                $array = $content->option;
            }
            $result_array[$i]['option']=$array;
        }
        return $result_array;
    }



    // //增加题目
    // public function add_problem($problem_content,$problem_class,$problem_type){
    //     $this->data([
    //         'problem_content'  =>  $problem_content,
    //         'problem_class' =>  $problem_class,
    //         'problem_type'  =>  $problem_type
    //     ]);
    //     $this->save();
    //     $new_problem_id=$this->problem_id;
    //     //查询新信息
    //     $query=['problem_id'=>$new_problem_id];
    //     $result = $this->get($query);
    //     if (empty($result)){
    //       return null;
    //     }else{
    //       return $result;
    //     }
    // }
    //
    // //更新题目
    // public function update_problem($problem_id,$problem_content,$problem_class,$problem_type){
    //     $this->save([
    //       'problem_content'  =>  $problem_content,
    //       'problem_class' =>  $problem_class,
    //       'problem_type'  =>  $problem_type
    //     ],['problem_id' => $problem_id]);
    //     $data['result']="更新成功";
    //     return $data;
    // }
    //
    // //删除题目
    // public function delete_problem($delete_id){
    //     $this->destroy(['problem_id' => $delete_id]);
    //     $data['result']="删除成功";
    //     return $data;
    // }

}
