<?php
namespace app\problem_manage\controller;
use think\Controller;
use app\problem_manage\model\ProblemModel;
use app\problem_manage\model\ProblemContentModel;
use app\problem_manage\model\ProblemUserModel;
use app\problem_manage\model\ParticipantModel;
use app\problem_manage\model\ParticipantHaveAnswerdModel;
use app\problem_manage\model\EventModel;
use app\problem_manage\tool\LogTool;
use think\Db;
use think\Session;
use think\Request;
class ProblemController extends Controller{
	var $partModel ;
	var $part;//用户所属的参赛者
	var $pm ;
	var $em;
	var $event;
	public function _initialize()
    {
        $this->partModel=new ParticipantModel();
				$this->pm=new ProblemModel();
				$this->em=new EventModel();
				if(!Session::get('user_id')){//用户未登录,进入登录页面
						$this->redirect('index/login/index');//用户未登录,进入登录页面
				}

    }
		private function filter($event){
					$pha=ParticipantHaveAnswerdModel::getPardDayAnswer($this->part['participant_id']);
					if (count($pha)>0){//判断用户是否已经答题,>0表示已经答过题目了
						LogTool::info('----------------------participant have answered the question today----------------------',$pha);
						$this->error('您已完成今日答题任务了哦！');
					}
					$event_time=json_decode($event['event_time'],true);
					$today=date('Y-m-d', time());
					if(strtotime($today)<strtotime($event_time['start_time'])
								|| strtotime($today)> strtotime($event_time['end_time'])){
							$this->error('比赛未开始或已经结束啦！');

					}
					$event_days=$event_time['time'];//星期
					if(!array_search((string)date("w"),$event_days)){
								LogTool::info('----------------------$event_days----------------------',$event_days);
								$this->error('今天不是答题日哦！！！');

					}



		}


	private function buildOption($single_pros,$option_random) { // 建立选择题选项，打乱选项
		//option_random：为1表示要打乱题目顺序
		$shuffled = array();
		$answer = array(); //答案
		for($i = 0; $i < count($single_pros);$i++) {
			$problem_content = json_decode($single_pros[$i]['problem_content']);
			$option = LogTool :: object2array($problem_content -> option); //取出来是object，转array

			$keys = array_keys($option);
			if($option_random){
						shuffle($keys);
			}

			$question_option = array();
			for($key_i = 0; $key_i < count($keys);$key_i++) {
				$question_option[chr(65 + $key_i)] = array('q_id' => $keys[$key_i], 'content' => $option[$keys[$key_i]]);
			}

			$shuffled[$i] = array('problem_id' => $single_pros[$i]['problem_id'], 'problem' => $problem_content -> problem, 'option' => $question_option);
			// LogTool :: record($problem_content);
			$answer[$single_pros[$i]['problem_id']] = $problem_content -> answer;
		}
		$res = array('problem' => $shuffled, 'answer' => $answer);
		Return $res;
	}
	private function dealNoOption($pros) {//处理非选择题
		$d_pro=array();
		$answer=array();
		for($i=0; $i<count($pros); $i++) {
			$problem_content = json_decode($pros[$i]['problem_content']);
			$d_pro[$i]=array('problem_id'=>$pros[$i]['problem_id'],'problem'=>$problem_content -> problem);
			$answer[$pros[$i]['problem_id']] = $problem_content -> answer;
		}
		$res = array('problem' => $d_pro, 'answer' => $answer);
		Return $res;
	}
	private function rebuildQuestion() { // 完全重新生成题目

		$eventProblem=$this-> pm ->getEventProblem($this->part['refer_event_id']);
		$cantProblem=$this-> pm ->getCantSelectProblem($this->part);
		//$option_random=$this->event['option_random'];
		//$questNum=['single'=>3,'multiple'=>3,'judge'=>3,'fill'=>3];
		//$questNum=$this->em->getQuestNum($this->part['refer_event_id']);
		$questNum=json_decode($this->event['event_num'],true);
		LogTool::info('--------questnum--------------',$questNum);
		$pum_answer = new ProblemUserModel();
		$pum_problem = new ProblemUserModel();
		//$waitedQ = $this-> pm -> getUserWaitedQ($this->part, $cantProblem,$eventProblem);//得到用户需要答的题目
		//***********************填空***********************************//
		if($questNum['fill']>0) {
			$fill_pros=$this-> pm ->getPartProblem($this->part,0,$questNum['fill'],$cantProblem,$eventProblem,$this->event['problem_random']);
			$fillRes = $this -> dealNoOption($fill_pros);
			$pum_answer->setfill($fillRes['answer']);
			$pum_problem->setfill($fillRes['problem']);
		}
		//**********************单选***********************************//
		if($questNum['single']>0) {
			$single_pros = $this-> pm ->getPartProblem($this->part,1,$questNum['single'],$cantProblem,$eventProblem,$this->event['problem_random']);
			$singleRes= $this -> buildOption($single_pros,$this->event['option_random']);
			$pum_answer->setSingle($singleRes['answer']);
			$pum_problem->setSingle($singleRes['problem']);
		}

		//**********************多选**********************************//
		if($questNum['multiple']>0) {
			$multi_pros = $this-> pm ->getPartProblem($this->part,2,$questNum['multiple'],$cantProblem,$eventProblem,$this->event['problem_random']);
			$multiRes = $this -> buildOption($multi_pros,$this->event['option_random']);
			$pum_answer->setMulti($multiRes['answer']);
			$pum_problem->setMulti($multiRes['problem']);
		}

		//**********************判断***********************************//
		if($questNum['judge']>0) {
			$judge_pros=$this-> pm ->getPartProblem($this->part,3,$questNum['judge'],$cantProblem,$eventProblem,$this->event['problem_random']);
			$judgeRes = $this -> dealNoOption($judge_pros);
			$pum_answer->setJudge($judgeRes['answer']);
			$pum_problem->setJudge($judgeRes['problem']);
		}

		ParticipantModel :: writeWaitedAnswer($this->part['participant_id'], json_encode($pum_answer)); //把生成的题目id和答案保存到数据库
		LogTool :: info('------------$pum_answer-------',json_encode($pum_answer));
		Return $pum_problem;

	}
	private function buildQuestion() { // 从participant表的waited_answer找的本来就要答的题目
		$pum_problem = new ProblemUserModel();
		$all_answer = json_decode($this->part['waited_answer']); //json变obj,格式problem_id:正确选项
		//LogTool :: info('-------buildQuestion-----$all_answer  -------------------',$all_answer);
		// single=>{"10":"a","2":"a","17":"a","12":"a","5":"a"},multi=>....
		//*******************************单选*******************************
		if($all_answer -> single){
			$single_answer = Logtool :: object2array($all_answer -> single);
			//LogTool :: info('-------buildQuestion-----single_answer-------------------',$single_answer);
			$singleProId = array_keys($single_answer);
			$single_pros = ProblemModel :: getProblemFromId($singleProId); //得到single的题目
			$singleRes = $this -> buildOption($single_pros,$this->event['option_random']);
			$pum_problem->setSingle($singleRes['problem']);
		}

		//*********************************多选*************************************
		if($all_answer -> multi){
			$multi_answer = Logtool :: object2array($all_answer -> multi);
			LogTool :: info('-------buildQuestion-----$multi_answer  -------------------',$multi_answer);
			$multiProId = array_keys($multi_answer);
			$multi_pros = ProblemModel :: getProblemFromId($multiProId); //得到multi的题目
			$multiRes = $this -> buildOption($multi_pros,$this->event['option_random']);
			$pum_problem->setMulti($multiRes['problem']);

		}

		//**********************************判断*********************************//
		if($all_answer -> judge){
			$judge_answer = Logtool :: object2array($all_answer -> judge);
			$judgeProId = array_keys($judge_answer);
			$judge_pros = ProblemModel :: getProblemFromId($judgeProId); //得到multi的题目
			$judgeRes = $this -> dealNoOption($judge_pros);
			$pum_problem->setJudge($judgeRes['problem']);

		}
		//****************************填空*******************************
		if($all_answer -> fill){
			$fill_answer = Logtool :: object2array($all_answer -> fill);
			$fillProId = array_keys($fill_answer);
			$fill_pros = ProblemModel :: getProblemFromId($fillProId); //得到multi的题目
			$fillRes = $this -> dealNoOption($fill_pros);
			$pum_problem->setFill($fillRes['problem']);

		}
		//***********************************************************************
		//LogTool :: info('------------buildquestion-->>>>>_____$pum_answer-------',json_encode($pum_problem));
		Return $pum_problem;



	}
	public function getUserProblem2(){
		$this->error('您已完成今日答题任务了哦！');
	}
	public function getUserProblem() {

		$user = Session::get('user');
		$refer_event_id = Request::instance()->param("event_id");
		$this->part = $this->partModel -> getParticipant($user['id'], $refer_event_id); //array ('participant_id' => 1, 'refer_event_id' => 1, 'user_id' =>
		$this->event=$this->em->getEvent($this->part['refer_event_id']);
		$this->filter($this->event);//过滤
		// 1,'team_id' => 1,'credit' => 0,'leader' => 0, 'waited_answer' => NULL,
		$ifRebuild = 0; //用来判断是否重新生成题目

		if ($this->part['waited_answer']) {
			if (json_decode($this->part['waited_answer']) -> planDate == date('Y-m-d', time())) { // 判断题目是否是当天的
				$ifRebuild = 1;
				LogTool::record('----------------------haven t rebuild the problem----------------------');
			}
		}
		$res=null;
		if ($ifRebuild) {
			$res=$this -> buildQuestion();
		} else {
			$res=$this -> rebuildQuestion();
		}
		$res = json_decode(json_encode($res),true);//转换为数组，方便传输给页面
		LogTool :: info('----------------getUserProblem最后生成的问题---------------------',$res);
		$this->assign('data',$res);
		$this->assign('name',$user['login_name']);
		$this->assign('time',$this->event['answer_time']);
		$this->part['waited_answer']=null;//不传答案
		$this->assign('participant',json_encode($this->part));
		return $this->fetch('user_problem/user_problem');
	}

	public function getNewProblem() { // 写入新题目
		print("geNewProblem");
		$pcm = new ProblemContentModel();
		$pcm_json = json_encode($pcm);
		$pm = new ProblemModel();

		$pm -> saveOneProblem($pcm_json, 2, 2);
	}

	public function getProblem() {
		ProblemModel::getProblem();
	}

}
