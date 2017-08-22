<?php
namespace app\event\controller;
//Include class
require_once('../../../vendor\PHPExcel\Classes\PHPExcel\Reader\Excel2007.php');

class Question
{
    public function excelReader()
    {
      echo "hello";
      //vendor("PHPExcel.PHPExcel");
      // $objReader = new PHPExcel_Reader_Excel2007;
      // $objPHPExcel = $objReader->load("test.xlsx");
      // dump($objPHPExcel);
    }

}
