<?php
namespace app\problem_manage\controller;
use think\Controller;
use think\View;
use app\problem_manage\model\ProblemModel;
use app\problem_manage\model\ProblemContentModel;
use app\problem_manage\model\PanticipantModel;
use app\problem_manage\model\PanticipantHaveAnswerdModel;
use app\problem_manage\tool\LogTool;
use think\Db;
class AnswerController extends Controller {
	var $refer_participant_id;
	var $refer_team_id;
	var $userMark = 0;
	var $credit_rule = array('single_choice_score' => 2,'multiple_choice_score'=>4);
	var $pantHaveAnswerArr = array();
	public function getSy() {
		$view = new View();
        return $view->fetch('sy');
	}
	public function postSy2() {
		LogTool::record($_POST);
		Return 2;
	}
	public function getSubmitAnswer() {
		// 前端提交json {'single':[{'problem_id':xx,'q_id':xx},{'problem_id':xx,'q_id':xx},......],'multi':[{'problem_id':xx,'q_id':['x','x']},{'problem_id':xx,'q_id':['x','x','x']},......]}  q_id为用户选择的选项的id
		$this -> refer_participant_id = 7; //参赛人id
		$this -> refer_team_id = 1; //参赛人队伍的id
		$allAnswer=json_decode(PanticipantModel::getWaitedAnswer($this -> refer_participant_id));//预存在panticipant表中waitedAnswer的问题id及答案
		//***********单选*************//
		$singleAnswer = Logtool :: object2array($allAnswer -> single);
		$singleSubmit=$allSubmit->single;
		$this->dealSingle($singleSubmit, $singleAnswer);
		//***********多选***************//
		$multiAnswer=Logtool :: object2array($allAnswer -> multi);
		$multiSubmit=$allSubmit->multi;
		$this->dealMulti($multiSubmit, $multiAnswer);

		//***********************************************
		PanticipantHaveAnswerdModel::savePantHaveAnswerds($this->pantHaveAnswerArr);
	
	} 
	private function dealSingle($singleSubmit, $singleAnswer) {
		// input:singleSubmit:arr=>[{'problem_id':xx,'q_id':xx},{'problem_id':xx,'q_id':xx},......]
		// singleAnswer:arr=>{problem_id:answer,problem_id:answer,....}
		// ouput：
		$singleCredit = $this -> credit_rule['single_choice_score'];
		for($i = 0; $i < count($singleSubmit); $i++) {
			$submit = $singleSubmit[$i];
			$submitId = $submit['problem_id'];
			$submitAnswer = $submit['q_id'];
			$pantHaveAnswer = new PanticipantHaveAnswerdModel($this -> refer_participant_id, $this -> refer_team_id, $submit['problem_id'], $submitAnswer);
			if ($submitAnswer == $singleAnswer[$submitId]) { // 回答正确
				$pantHaveAnswer -> setTrueOrFalse(1); //设置为回答正确
				$this -> userMark = $this -> userMark + $singleCredit; //增加积分
			} else {
				$pantHaveAnswer -> setTrueOrFalse(0);
			} 
			array_push($this -> pantHaveAnswerArr, $pantHaveAnswer); //push到用户答题情况的数组
			
		} 
	} 
	private function dealMulti($multiSubmit, $multiAnswer) {
		// input:multiSubmit:arr=>[{'problem_id':xx,'q_id':[x,x]},{'problem_id':xx,'q_id':[x,x,x,x]},......]
		// multiAnswer:arr=>{problem_id:[x,x],problem_id:[x,x,x],....}
		$multiCredit = $this -> credit_rule['multiple_choice_score'];
		for($i = 0; $i < count($singleSubmit); $i++) {
			$submit = $singleSubmit[$i];
			$submitId = $submit['problem_id'];
			$submitAnswer = $submit['q_id'];
			$pantHaveAnswer = new PanticipantHaveAnswerdModel($this -> refer_participant_id, $this -> refer_team_id, $submit['problem_id'], $submitAnswer); 
			// ***********************多选判断是否正确*******************//
			$ifRight = 0; 
			// 策略：错一道全错
			$rightAnswer = $multiAnswer[$submitId];
			$diff = array_diff_assoc($submitAnswer, $rightAnswer);
			if (count($diff) == 0) { // 差集为空，完全正确
				$ifRight = 1;
			} 
			// ***********************************************************
			if ($ifRight) {
				$pantHaveAnswer -> setTrueOrFalse(1); //设置为回答正确
				$this -> userMark = $this -> userMark + $multiCredit; //增加积分
			} else {
				$pantHaveAnswer -> setTrueOrFalse(0);
			} 
			array_push($this -> pantHaveAnswerArr, $pantHaveAnswer); //push到用户答题情况的数组
			
		} 
	} 
	private function dealJudge() {
	} 
} 
