<?php
namespace app\problem_manage\controller;
use think\Controller;
use think\View;
use app\problem_manage\model\ProblemModel;
use app\problem_manage\model\ProblemContentModel;
use app\problem_manage\model\ParticipantModel;
use app\problem_manage\model\ParticipantHaveAnswerdModel;
use app\problem_manage\model\CreditModel;
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

	var $creditModel;
	//'{"fill_score": 4, "team_score": 10, "judge_score": 4, "person_score": 10,
	//"single_score": 4, "team_score_up": 1000, "multiple_score": 4, "person_score_up": 100}'
	var $partHaveAnswerArr = array();
	public function _initialize(){
				$this->partHaveAnswerArr=array();


	}
	public function getSy() {
		$view = new View();
        return '3333333';
	}
	public function postSy2() {
		LogTool::record($_POST);
		Return 2;
	}
	public function postSubmitAnswer() {

		LogTool::info('-------------------answer-post-信息--------------------',$_POST);
		// 前端提交json {'single':[{'problem_id':xx,'q_id':xx},{'problem_id':xx,'q_id':xx},......],'multi':[{'problem_id':xx,'q_id':['x','x']},{'problem_id':xx,'q_id':['x','x','x']},......]}  q_id为用户选择的选项的id
		$this -> refer_participant_id = 6; //参赛人id
		$this -> refer_team_id = 1; //参赛人队伍的id
		$this->creditModel=new CreditModel(46,6);
		$allSubmit=$_POST;
		LogTool::record($_POST);
		$allAnswer=ParticipantModel::getWaitedAnswer($this -> refer_participant_id);//预存在participant表中waitedAnswer的问题id及答案
		if(count($allAnswer)<=0) {
			LogTool::record('没有找到参赛者，或参赛者中没有预存答案');
		}else{
			$allAnswer=json_decode($allAnswer[0]['waited_answer']);
			$allAnswer=Logtool :: object2array($allAnswer);

		}
		LogTool::record($allSubmit);
		//***********单选*************//

		$singleAnswer = Logtool :: object2array($allAnswer['single']);
		$singleSubmit=$allSubmit['single'];
		$this->dealSingle($singleSubmit, $singleAnswer);
		//***********多选***************//
		$multiAnswer=Logtool :: object2array($allAnswer['multi']);
		$multiSubmit=$allSubmit['multi'];
		$this->dealMulti($multiSubmit, $multiAnswer);

		//***********************************************
		//ParticipantHaveAnswerdModel::savePartHaveAnswerds($this->pantHaveAnswerArr);
		$res=$this->creditModel->dealFinal();
		Return json_encode($res);
	}
	private function dealSingle($singleSubmit, $singleAnswer) {
		// input:singleSubmit:arr=>[{'problem_id':xx,'q_id':xx},{'problem_id':xx,'q_id':xx},......]
		// singleAnswer:arr=>{problem_id:answer,problem_id:answer,....}
		// ouput：
		for($i = 0; $i < count($singleSubmit); $i++) {
			$submit = $singleSubmit[$i];
			$submitId = $submit['problem_id'];
			$submitAnswer = $submit['q_id'];
			$pantHaveAnswer = new ParticipantHaveAnswerdModel($this -> refer_participant_id, $this -> refer_team_id, $submit['problem_id'], $submitAnswer);
      LogTool::info('----------------$singleAnswer-------',$singleAnswer);
			if ($submitAnswer == $singleAnswer[$submitId]) { // 回答正确
				$pantHaveAnswer -> setTrueOrFalse(1); //设置为回答正确
				$this->creditModel->dealAnswer(1,'single');

			} else {
				$this->creditModel->dealAnswer(0,'single');
				$pantHaveAnswer -> setTrueOrFalse(0);
			}
			LogTool::info('----------------dealsingle---panthaveAnswer-------',$pantHaveAnswer);
			array_push($this -> partHaveAnswerArr, $pantHaveAnswer); //push到用户答题情况的数组

		}
	}
	private function dealMulti($multiSubmit, $multiAnswer) {
		// input:multiSubmit:arr=>[{'problem_id':xx,'q_id':[x,x]},{'problem_id':xx,'q_id':[x,x,x,x]},......]
		// multiAnswer:arr=>{problem_id:[x,x],problem_id:[x,x,x],....}

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
				$this->creditModel->dealAnswer(1,'multi');
			} else {
				$pantHaveAnswer -> setTrueOrFalse(0);
				$this->creditModel->dealAnswer(0,'multi');
			}
			//::info('------------$this -> pantHaveAnswerArr-----------',$this->partHaveAnswerArr);
			array_push($this->partHaveAnswerArr, $pantHaveAnswer); //push到用户答题情况的数组

		}
	}
	private function dealJudge($judgeSubmit, $judgeAnswer) {

			 for($i = 0; $i < count($judgeSubmit); $i++) {
				 		$submit = $judgeSubmit[$i];
						$submitId = $submit['problem_id'];
						$submitAnswer = $submit['q_id'];
						$pantHaveAnswer = new ParticipantHaveAnswerdModel($this -> refer_participant_id, $this -> refer_team_id, $submit['problem_id'], $submitAnswer);
						//**************判断正确与否********************//
						if($submitAnswer==$pantHaveAnswe){
							$pantHaveAnswer -> setTrueOrFalse(1); //设置为回答正确
							$this->creditModel->dealAnswer(1,'judge');

						}else {
							$pantHaveAnswer -> setTrueOrFalse(0);
							$this->creditModel->dealAnswer(0,'judge');
						}
						array_push($this->partHaveAnswerArr, $pantHaveAnswer); //push到用户答题情况的数组
			 }

	}
	private function dealFill($fillSubmit, $fillAnswer) {

			 for($i = 0; $i < count($judgeSubmit); $i++) {
				 		$submit = $judgeSubmit[$i];
						$submitId = $submit['problem_id'];
						$submitAnswer = $submit['q_id'];
						$pantHaveAnswer = new ParticipantHaveAnswerdModel($this -> refer_participant_id, $this -> refer_team_id, $submit['problem_id'], $submitAnswer);
						//**************判断正确与否********************//
						if($submitAnswer==$pantHaveAnswe){
							$pantHaveAnswer -> setTrueOrFalse(1); //设置为回答正确
							$this->creditModel->dealAnswer(1,'fill');

						}else {
							$pantHaveAnswer -> setTrueOrFalse(0);
							$this->creditModel->dealAnswer(0,'fill');
						}
						array_push($this->partHaveAnswerArr, $pantHaveAnswer); //push到用户答题情况的数组
			 }

	}

}
