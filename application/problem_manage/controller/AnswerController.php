<?php
namespace app\problem_manage\controller;
use app\problem_manage\model\ProblemModel;
use app\problem_manage\model\ProblemContentModel;
use app\problem_manage\tool\LogTool;
use think\Db;
class AnswerController{
    public function getSubmitAnswer() {
		//前端提交json {'single':[{'problem_id':xx,'q_id':xx},{'problem_id':xx,'q_id':xx},......],'multi':....}  q_id为用户选择的选项的id
		
	}
	private function dealSingle($singleSubmit,$singleAnswer,$singleMark=2) {
		//input:singleSubmit:array=>[{'problem_id':xx,'q_id':xx},{'problem_id':xx,'q_id':xx},......]
		//    singleAnswer:obj=>{problem_id:answer,problem_id:answer,....}
		//ouput：
		for($i=0; $i<count($singleSubmit); $i++) {
			$ss=
		}
		
	}
	private function dealMulti() {
		
	}
	private function dealJudge() {
		
	}







}