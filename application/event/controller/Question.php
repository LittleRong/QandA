<?php
namespace app\event\controller;

use PHPExcel_IOFactory;
use PHPExcel;
use app\event\model\ProblemModel;
use think\View;
use think\Request;

class Question
{

    public function problem_insert()
    {
      $view = new View();
      return $view->fetch('tiku_upload');
    }
    //上传文件保存到本地
    public function upload()
    {
      $file = Request::instance()->file('image');
      //定义最大文件大小，文件后缀格式，保存路径
      $info = $file->validate(['size'=>15678,'ext'=>'xlsx,xls'])->move(__DIR__.'/../../../public/uploads');
      if($info)
      {
        $this->excelreader($info->getSaveName());
      }
      else
      {
        echo $file->getError();
      }
    }


    //excel导入题目到数据库中
    public function excelreader($filename)
    {

       $filename = __DIR__.'/../../../public/uploads/'.$filename;
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
             $problem_content = json_encode(array('problem' => $question,'option'=>$option,'answer'=>$answer ));
             $model = new ProblemModel();
             $model->problem_insert($problem_content,$problem_class,(int)$problem_type);
             dump($problem_content);
        }
        echo "Done";
    }

}
