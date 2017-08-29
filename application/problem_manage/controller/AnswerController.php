<?php
namespace app\problem_manage\controller;
use think\Controller;
use think\View;
use app\problem_manage\model\ProblemModel;
use app\problem_manage\model\ProblemContentModel;
use app\problem_manage\model\ParticipantModel;
use app\problem_manage\model\ParticipantHaveAnswerdModel;
use app\problem_manage\tool\LogTool;
use think\Db;
/*
                           _ooOoo_
                          o8888888o
                          88" . "88
                          (| -_- |)
                          O\  =  /O
                       ____/`---'\____
                     .'  \\|     |//  `.
                    /  \\|||  :  |||//  \
                   /  _||||| -:- |||||-  \
                   |   | \\\  -  /// |   |
                   | \_|  ''\---/''  |   |
                   \  .-\__  `-`  ___/-. /
                 ___`. .'  /--.--\  `. . __
              ."" '<  `.___\_<|>_/___.'  >'"".
             | | :  `- \`.;`\ _ /`;.`/ - ` : | |
             \  \ `-.   \_ __\ /__ _/   .-` /  /
        ======`-.____`-.___\_____/___.-`____.-'======
                           `=---='
        ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
                 佛祖保佑       永无BUG
        */
class AnswerController extends Controller {
	var $refer_participant_id;
	var $refer_team_id;
	var $userMark = 0;
	var $credit_rule = array('single_choice_score' => 2,'multiple_choice_score'=>4);
	var $partHaveAnswerArr = array();
	public function getSy() {
		$view = new View();
        return '3333333';
	}
	public function postSy2() {
		LogTool::record($_POST);
		Return 2;
	}
	public function postSubmitAnswer() {

		LogTool::record($_POST);
		// 前端提交json {'single':[{'problem_id':xx,'q_id':xx},{'problem_id':xx,'q_id':xx},......],'multi':[{'problem_id':xx,'q_id':['x','x']},{'problem_id':xx,'q_id':['x','x','x']},......]}  q_id为用户选择的选项的id
		$this -> refer_participant_id = 6; //参赛人id
		$this -> refer_team_id = 1; //参赛人队伍的id

		$allSubmit=$_POST;
		LogTool::info('-------------answer post------------',$_POST);
		$allAnswer=ParticipantModel::getWaitedAnswer($this -> refer_participant_id);//预存在participant表中waitedAnswer的问题id及答案
		if(count($allAnswer)<=0) {
			LogTool::record('没有找到参赛者，或参赛者中没有预存答案');
		}else{
			$allAnswer=json_decode($allAnswer[0]['waited_answer']);
			$allAnswer=Logtool :: object2array($allAnswer);

		}
		LogTool::record($allSubmit);
		//***********单选*************//

		try{
		$singleAnswer = Logtool :: object2array($allAnswer['single']);
		$singleSubmit=$allSubmit['single'];
		$this->dealSingle($singleSubmit, $singleAnswer);
		}catch(\Exception $e){
				LogTool::record('------answerpost--singleerror-------');
		}
		//***********多选***************//
		try{
		$multiAnswer=Logtool :: object2array($allAnswer['multi']);
		$multiSubmit=$allSubmit['multi'];
		$this->dealMulti($multiSubmit, $multiAnswer);
		}catch(\Exception $e){
				LogTool::record('------answerpost--multiple eerror-------');
		}
		//***********************************************
		//ParticipantHaveAnswerdModel::savePantHaveAnswerds($this->pantHaveAnswerArr);
		LogTool::record($_POST);
		$data=['user_credit'=>$this->userMark];

		//$data=['user_credit'=>$this->userMark,'team_credit'=>100,'team_mate'=>[['name'=>'kk','credit'=>20],['name'=>'kk','credit'=>20]];

		Return json_encode($data);
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
			$pantHaveAnswer = new ParticipantHaveAnswerdModel($this -> refer_participant_id, $this -> refer_team_id, $submit['problem_id'], $submitAnswer);

			$ifRight = 0; 
			if ($submitAnswer == $singleAnswer[$submitId]) { // 回答正确
				$pantHaveAnswer -> setTrueOrFalse(1); //设置为回答正确
				$this -> userMark = $this -> userMark + $singleCredit; //增加积分
			} else {
				$pantHaveAnswer -> setTrueOrFalse(0);
			}
			LogTool::info('----------------dealsingle---panthaveAnswer-------',$pantHaveAnswer);
			array_push($this -> partHaveAnswerArr, $pantHaveAnswer); //push到用户答题情况的数组

		}
	}
	private function dealMulti($multiSubmit, $multiAnswer) {
		// input:multiSubmit:arr=>[{'problem_id':xx,'q_id':[x,x]},{'problem_id':xx,'q_id':[x,x,x,x]},......]
		// multiAnswer:arr=>{problem_id:[x,x],problem_id:[x,x,x],....}
		$multiCredit = $this -> credit_rule['multiple_choice_score'];
		for($i = 0; $i < count($multiSubmit); $i++) {
			$submit = $multiSubmit[$i];
			$submitId = $submit['problem_id'];
			$submitAnswer = $submit['q_id'];
			$pantHaveAnswer = new ParticipantHaveAnswerdModel($this -> refer_participant_id, $this -> refer_team_id, $submit['problem_id'], $submitAnswer);
			// ***********************多选判断是否正确*******************//
			$ifRight = 0;
			// 策略：错一道全错
			$rightAnswer = $multiAnswer[$submitId];
			try{
				$diff = array_diff_assoc($submitAnswer, $rightAnswer);
			}catch(\Exception $e){
				$diff=[1,2];//有异常，暂时按题目错误处理
			}


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
