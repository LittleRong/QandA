<?php
namespace app\event\controller;

use PHPExcel_IOFactory;
use PHPExcel;
use app\event\model\ProblemModel;
use app\event\model\EventProblemModel;
use think\View;
use think\Request;
use think\Controller;
use think\Session;

class Question extends Controller
{

    //题目导入
    public function problem_insert()
    {
      if(!Session::get('myevent_id'))
      {
        //get方式取回event_id
        $data = Request::instance()->param('event_id');
        //设置session
        Session::set('myevent_id',$data);
      }
      $view = new View();
      return $view->fetch('tiku_upload');
    }
    //上传文件保存到本地
    public function upload()
    {
      $file = Request::instance()->file('image');
      //定义最大文件大小，文件后缀格式，保存路径
      $info = $file->validate(['size'=>15678,'ext'=>'xlsx,xls'])->move(__DIR__.'/../../../public/uploads/problem');
      if($info)
      {
        //参数为保存名字
        $this->excelreader($info->getSaveName());
        //保存题库成功后跳转到题目配置
        return $this->problem_manage();
      }
      else
      {
        //输出错误信息
        echo $file->getError();
      }
    }

    //excel导入题目到数据库中
    public function excelreader($filename)
    {
       $filename = __DIR__.'/../../../public/uploads/problem/'.$filename;
       $extension = strtolower( pathinfo($filename, PATHINFO_EXTENSION) );

       if($extension == 'xlsx') {
            $objReader = \PHPExcel_IOFactory::createReader('Excel2007');
            $objPHPExcel = $objReader->load($filename, $encode = 'utf-8');
        }else if($extension == 'xls'){
            $objReader =\PHPExcel_IOFactory::createReader('Excel5');
            $objPHPExcel = $objReader->load($filename, $encode = 'utf-8');
        }

        $excel_array = $objPHPExcel->getsheet(0)->toArray();   //转换为数组格式
        array_shift($excel_array);  //删除第一个数组(标题);
        foreach($excel_array as $k=>$v)
        {
             $problem_class = $v[0];
             $problem_type = $v[1];
             $question = $v[2];
             $answer = $v[3];

             $option = array();     //定义选项为一个数组
             $count_num = count($v);
             $key = 97;             //key值的为ascii的小写a开始
             for($i=4;$i<$count_num;$i++)
             {
                $choice = array(chr($key) => $v[$i]);
                if(!empty($v[$i]))
                {
                  $option = array_merge($option,$choice);
                }
                $key++;
             }
             if((int)$problem_type == 2)
             {
                $answer_num = strlen($answer);
                $i = 0;
                $answer_temp = array();
                for($i=0;$i<$answer_num;$i++)
                {
                  array_push($answer_temp,$answer{$i});
                }
                $answer = $answer_temp;

             }
             $problem_content = json_encode(array('problem' => $question,'option'=>$option,'answer'=>$answer ));
             $model = new ProblemModel();
             $model->problem_insert($problem_content,$problem_class,(int)$problem_type);
            //  dump($problem_content);
        }
        // echo "Done";
    }

    //题目配置
    public function problem_manage()
    {

      $model = new ProblemModel();
      $result = $model->problem_check();
      // dump($result);
      $all = array(array());
      $num = count($result);

      for($i=0;$i<$num;$i++)
      {
        $getProblem = json_decode($result[$i],true);
        $problem = json_decode($getProblem['problem_content'],true);
        // $option = $problem['option'];
        unset($getProblem['problem_content']);
        // unset($problem['option']);
        $merge_item = array_merge($getProblem,$problem);
        $all[$i] = $merge_item;
      }
      // dump($all);
      if(empty($all[0]))
      {
        $this->assign('data',null);
      }
      else
        $this->assign('data',$all);
      return $this->fetch("problem_manage");
  }

  public function event_problem_relevance($problemId)
  {

    if(empty($problemId))
    {
      $data = array('result'=>'请勾选题目!');
      return json_encode($data);
    }
     $event_id = Session::get('myevent_id');
    //  $event_id = 1;
     $model = new EventProblemModel();
     $num = count($problemId);
     for($i=0;$i<$num;$i++)
     {
       $model->event_problem_insert((int)$problemId[$i],(int)$event_id);
     }
    //  $model->event_problem_inserts($problemId,(int)$event_id);
     Session::delete('myevent_id');
     $data = array('result'=>'录入成功!');
     return json_encode($data);

  }


}
