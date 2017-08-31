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
	var $pariticipant;
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
		$allSubmit=$_POST;
		$this->pariticipant=$_POST['participant'];
		$this -> refer_participant_id = $this->pariticipant['participant_id']; //参赛人id
		$this -> refer_team_id = $this->pariticipant['team_id']; //参赛人队伍的id

		$this->creditModel=new CreditModel($this->pariticipant['refer_event_id'],$this->pariticipant['participant_id']);



		$allAnswer=ParticipantModel::getWaitedAnswer($this -> refer_participant_id);//预存在participant表中waitedAnswer的问题id及答案
		//LogTool::info('---------------$allAnswer-----------------',$allAnswer);
		if(count($allAnswer)<=0) {
			LogTool::record('没有找到参赛者，或参赛者中没有预存答案');
		}else{
			$allAnswer=json_decode($allAnswer[0]['waited_answer']);
			$allAnswer=Logtool :: object2array($allAnswer);

		}

		//***********单选*************//
		if(array_key_exists('single',$allSubmit)){
			$singleAnswer = Logtool :: object2array($allAnswer['single']);
			$singleSubmit=$allSubmit['single'];
			$this->dealSingle($singleSubmit, $singleAnswer);
		}

		//***********多选***************//
		//LogTool::info('-----------array_key_exists(multi,$allAnswer)----------',$singleAnswer);
		if(array_key_exists('multi',$allSubmit)){
			$multiAnswer=$allAnswer['multi'];
			$multiSubmit=$allSubmit['multi'];
		    $this->dealMulti($multiSubmit, $multiAnswer);
		}
		//************判断题******************//
		if(array_key_exists('judge',$allSubmit)){
			$judgeAnswer=$allAnswer['judge'];
			$judgeSubmit=$allSubmit['judge'];
			$this->dealJudge($judgeSubmit,$judgeAnswer);

		}

		//************填空题************************//
		if(array_key_exists('fill',$allSubmit)){
			$fillAnswer=$allAnswer['fill'];
			$fillSubmit=$allSubmit['fill'];
			$this->dealFill($fillSubmit,$fillAnswer);
		}


		//***********************************************
		//ParticipantHaveAnswerdModel::savePartHaveAnswerds($this->pantHaveAnswerArr);
		$res=$this->creditModel->dealFinal();
		$res['right_answer']=$allAnswer;
		LogTool::info('-------------------------answer-submit res----------------------',$res);
		Return json_encode($res);
	}
	private function dealSingle($singleSubmit, $singleAnswer) {
		// input:singleSubmit:arr=>[{'problem_id':xx,'q_id':xx},{'problem_id':xx,'q_id':xx},......]
		// singleAnswer:arr=>{problem_id:answer,problem_id:answer,....}
		// ouput：
		//LogTool::info('-----------$singleAnswer----------',$singleAnswer);
		//LogTool::info('-----------$singleSubmit----------',$singleSubmit);
		for($i = 0; $i < count($singleSubmit); $i++) {
			$if_right=0;
			$submit = $singleSubmit[$i];
			//LogTool::info('---------------------------$submit-------------------------',$submit);
			$submitAnswer="";
			if(array_key_exists('q_id',$submit)){//不选择的话这里会为空
					$submitAnswer = $submit['q_id'];
			}

			$submitId = $submit['problem_id'];
			$pantHaveAnswer = new ParticipantHaveAnswerdModel();
			$pantHaveAnswer->setPro($this -> refer_participant_id, $this -> refer_team_id, $submit['problem_id'], $submitAnswer);
			//
			if ($submitAnswer == $singleAnswer[$submitId]||$submitAnswer==strtolower($singleAnswer[$submitId])) { // 回答正确
				$pantHaveAnswer -> setTrueOrFalse(1); //设置为回答正确
				$this->creditModel->dealAnswer(1,'single');
				LogTool::record('-----------single-----right----------------------');
				LogTool::info($submitAnswer,$singleAnswer[$submitId]);

			} else {
				$this->creditModel->dealAnswer(0,'single');
				$pantHaveAnswer -> setTrueOrFalse(0);
				LogTool::record('------------single----error----------------------');
				LogTool::info($submitAnswer,$singleAnswer[$submitId]);
			}
			//LogTool::info('----------------dealsingle---panthaveAnswer-------',$pantHaveAnswer);
			array_push($this -> partHaveAnswerArr, $pantHaveAnswer); //push到用户答题情况的数组

		}
	}
	private function dealMulti($multiSubmit, $multiAnswer) {
		// input:multiSubmit:arr=>[{'problem_id':xx,'q_id':[x,x]},{'problem_id':xx,'q_id':[x,x,x,x]},......]
		// multiAnswer:arr=>{problem_id:[x,x],problem_id:[x,x,x],....}

		for($i = 0; $i < count($multiSubmit); $i++) {
			$submit = $multiSubmit[$i];
			$submitId = $submit['problem_id'];
			$submitAnswer=[];
			if(array_key_exists('q_id',$submit)){//不选择的话这里会为空
					$submitAnswer = $submit['q_id'];
			}
			$pantHaveAnswer = new ParticipantHaveAnswerdModel();
			$pantHaveAnswer->setPro($this -> refer_participant_id, $this -> refer_team_id, $submit['problem_id'], $submitAnswer);
			// ***********************多选判断是否正确*******************//
			$ifRight = 1;
			// 策略：错一道全错
			$rightAnswer = $multiAnswer[$submitId];

			if(count($submitAnswer)==0 ||count($submitAnswer)>count($rightAnswer) ){//没有选或者选多了，全错
					$ifRight = 0;
			}elseif(count(array_diff($submitAnswer, $rightAnswer))||count(array_diff($rightAnswer,$submitAnswer))){//差集不为空，错
				  $ifRight = 0;
			}

			// ***********************************************************
			if ($ifRight) {
				$pantHaveAnswer -> setTrueOrFalse(1); //设置为回答正确
				$this->creditModel->dealAnswer(1,'multi');
				//LogTool::record('-----------multi-----right----------------------');
				//LogTool::info($submitAnswer,$multiAnswer[$submitId]);
			} else {
				$pantHaveAnswer -> setTrueOrFalse(0);
				$this->creditModel->dealAnswer(0,'multi');
				//LogTool::record('-----------multi-----error----------------------');
				//LogTool::info($submitAnswer,$multiAnswer[$submitId]);
			}
			//::info('------------$this -> pantHaveAnswerArr-----------',$this->partHaveAnswerArr);
			array_push($this->partHaveAnswerArr, $pantHaveAnswer); //push到用户答题情况的数组

		}
	}
	private function dealJudge($judgeSubmit, $judgeAnswer) {

			 for($i = 0; $i < count($judgeSubmit); $i++) {
				 		$submit = $judgeSubmit[$i];
						$submitId = $submit['problem_id'];
						$submitAnswer="";
						if(array_key_exists('answer',$submit)){//不选择的话这里会为空
								$submitAnswer = $submit['answer'];
						}
						$pantHaveAnswer = new ParticipantHaveAnswerdModel();
						$pantHaveAnswer->setPro($this -> refer_participant_id, $this -> refer_team_id, $submit['problem_id'], $submitAnswer);
						//**************判断正确与否********************//
						if($submitAnswer==$judgeAnswer[$submitId]){
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

			 for($i = 0; $i < count($fillSubmit); $i++) {
				 		$submit = $fillSubmit[$i];
						$submitId = $submit['problem_id'];
						$submitAnswer="";
						if(array_key_exists('answer',$submit)){//不选择的话这里会为空
								$submitAnswer = $submit['answer'];
						}
						$pantHaveAnswer = new ParticipantHaveAnswerdModel();
						$pantHaveAnswer->setPro($this -> refer_participant_id, $this -> refer_team_id, $submit['problem_id'], $submitAnswer);
						//**************判断正确与否********************//
						if($submitAnswer==$fillAnswer[$submitId]){
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
