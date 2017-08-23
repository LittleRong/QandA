<?php
namespace app\event\controller;

use PHPExcel_IOFactory;
use PHPExcel;
use app\event\model\ProblemModel;

class Question
{
    public function excelReader()
    {

       $filename = __DIR__."/test.xlsx";
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
             $id = $v[0];
             $question = $v[1];
             $option = json_encode(array('A' => $v[2],'B' => $v[3],'C' => $v[4],'D' =>  $v[5] ));
             $answer = $v[6];
             $problem_content = json_encode(array('problem' => $question,'option'=>$option,'answer'=>$answer ));
             $problem_class = $v[7];
             $problem_type = $v[8];

             $model = new ProblemModel();
             $model->problem_insert((int)$id,$problem_content,$problem_class,(int)$problem_type);

             dump($v);
        }
        echo "Done";
    }

}
